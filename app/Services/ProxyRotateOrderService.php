<?php

namespace App\Services;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\ProxyRotateOrderData;
use App\Dto\ProxyStaticOrderData;
use App\Models\ProxyHomeOrder;
use App\Models\Transaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxyRotateOrderService
{
    protected string $baseUrl;
    protected string $accessToken;
    public function __construct(
        private readonly CredentialService $cred
    ) {
        $this->baseUrl = env('HOMEPROXY_BASE','');
        $this->accessToken = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function notEnoungMoney(int $userId, ProxyRotateOrderData $dto): bool
    {
        $total = $this->computeTotal($dto);

        $user = DB::table('users')->where('id', $userId)->first();

        if($user->available_balance < $total)
        {
            return true;
        }

        return false;
    }

    public function create(int $userId, ProxyRotateOrderData $dto)
    {
        $this->ensureCredentials($dto);

        $total = $this->computeTotal($dto);

        $user = DB::table('users')->where('id', $userId)->lockForUpdate()->first();

        DB::beginTransaction();

        try {
            if (!$user) {
                throw new \RuntimeException('Không tìm thấy người dùng');
            }
            if ($user->available_balance < $total) {
                throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
            }

            DB::table('users')->where('id', $userId)->update([
                'available_balance' => $user->available_balance - $total,
                'balance' => $user->balance - $total,
                'updated_at' => now(),
            ]);

            $apiRes = $this->callPartnerApi($dto);

            $local = $this->storeLocalOrder($userId, $dto, $total, $apiRes);

            $orderModel = ProxyHomeOrder::query()
                ->where('id', $local['id'])
                ->first();

            Transaction::create([
                'user_id' => $userId,
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $total * -1,
                'status' => TransactionStatus::Paid,
                'reference_id' => $orderModel->id,
                'reference_type' => ProxyHomeOrder::class,
                'note' => 'Thanh toán đơn hàng #'.$orderModel->code
            ]);

            sleep(3);
            $synced = app(ProxyHomeSyncService::class)->syncProxiesForOrder($orderModel);

            DB::commit();

            return [
                'local_order' => $local,
                'partner_raw' => $apiRes,
                'amount'      => $total,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('[ProxyRotate] Call create exception: '.$exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            return [];
        }
    }

    public function computeTotal(ProxyRotateOrderData $dto): int
    {
        $unitPrices = config('proxyhome.unit_price_rotate', [])[$dto->typeUnit];
        $ratios = [
            'day'   => 1,
            'week'  => 7,
            'month' => 30,
        ];

        return (int) ($dto->unit * $dto->quantity * $unitPrices);
    }

    protected function ensureCredentials(ProxyRotateOrderData $dto): void
    {
        if (trim(strtolower($dto->user)) === 'random') {
            $dto->user = $this->cred->makeUsername('sel');
        }
        if (trim(strtolower($dto->password)) === 'random') {
            $dto->password = $this->cred->makePassword();
        }
    }

    protected function getProductIdByUnit($unit)
    {
        return config('proxyhome.product_ids.rotate')[$unit];
    }
    protected function callPartnerApi(ProxyRotateOrderData $dto): array
    {
        $baseUrl    = $this->baseUrl;
        $merchantId = env('PROXY_API_MERCHANT_ID');
        $token      = env('PROXY_API_TOKEN');
        $productId = $this->getProductIdByUnit($dto->typeUnit);

        $url = $baseUrl . '/api/merchant/orders';

        $ratios = [
            'day'   => 1,
            'week'  => 7,
            'month' => 30,
        ];

        $dayOfUse = $dto->unit * $ratios[$dto->typeUnit];
        $payload = [
            'paymentMethod' => 'WALLET',
            'products' => [[
                'rotateInterval' => $dto->interval,
                'provider' => 'HOMEPROXY',
                'dayOfUse'     => $dayOfUse,
                'password'     => $dto->password,
                'user'         => $dto->user,
                'protocolType' => 'HTTP',
                'quantity'     => $dto->quantity,
                // 'product'      => ['id' => $productId],
                'product'      => ['id' => '8ecf9d6e-e464-4c48-9436-f9f00b8dc46c'],
            ]],
        ];

        $accessToken = $this->accessToken;
        try {
            $req = Http::acceptJson()
                ->withToken($accessToken)
                ->timeout(20);

            if ($merchantId) {
                $req = $req->withHeaders(['x-merchant-id' => $merchantId]);
            }
        //    dd($payload);
            $res = $req->post($url, $payload);
            // dd($res->object());
            if (!$res->successful()) {
                Log::warning('[ProxyRotate] Partner API error', [
                    'status' => $res->status(),
                    'body'   => $res->body(),
                ]);
                throw new \RuntimeException('Tạo đơn hàng thất bại (HTTP '.$res->status().')');
            }
            return $res->json();
        } catch (\Throwable $e) {
            Log::error('[ProxyRotate] Call partner API exception: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \RuntimeException('Không thể kết nối: '.$e->getMessage());
        }
    }

    protected function storeLocalOrder(int $userId, ProxyRotateOrderData $dto, int $total, array $apiRes): array
    {
        $ratios = [
            'day'   => 1,
            'week'  => 7,
            'month' => 30,
        ];

        $dayOfUse = $dto->unit * $ratios[$dto->typeUnit];

        $order = ProxyHomeOrder::create([
            'partner_order_id' => $apiRes['id'],
            'code'             => uniqid_real(),
            'user_id'          => $userId,
            'type'             => 'rotate',
            'provider'         => 'HOMEPROXY',
            'protocol'         => 'HTTP',
            'location'         => '',
            'days'             => $dayOfUse,
            'quantity'         => $dto->quantity,
            'amount'           => $total,
            'partner_response' => json_encode($apiRes, JSON_UNESCAPED_UNICODE),
            'status'           => 'created',
        ]);

        return $order->toArray();
    }

    public function bulkUpdateAuth(array $userProxyIds, string $username, string $password, ?string $protocol = null, ?int $rotateInterval = null): array
    {
        $payload = [
            "userProxyIds"  => array_values($userProxyIds),
            "password"      => $password,
            "username"      => $username,
        ];

        if ($protocol !== null && $protocol !== '') {
            $payload["protocol"] = $protocol;
        }
        if ($rotateInterval !== null) {
            $payload["rotateInterval"] = (int) $rotateInterval;
        }

        $baseUrl    = $this->baseUrl;

        $endpoint = $baseUrl . '/api/merchant/orders/change-info-proxies';
        $accessToken = $this->accessToken;
        $resp = Http::withToken($accessToken)
            ->acceptJson()
            ->post($endpoint, $payload);

        return [
            'ok'    => $resp->successful(),
            'status'=> $resp->status(),
            'body'  => $this->safeJson($resp),
            'raw'   => $resp,
        ];
    }

    private function safeJson(Response $resp)
    {
        try {
            return $resp->json();
        } catch (\Throwable $e) {
            return $resp->body();
        }
    }

    public function bulkRenew(array $userProxyIds, int $days, int $autoRenew = 0): array
    {
        $autoRenew = 0; //TODO update chắc chắn không cho bậc auto renew bên gốc, auto chỉ có bên web
        $payload = [
            "userProxyIds" => array_values($userProxyIds),
            "dayOfRenewal" => (int)$days,
            "isRenewal"    => (boolean)$autoRenew,
        ];

        $baseUrl    = $this->baseUrl;
        $endpoint = $baseUrl . '/api/merchant/orders/renewal-proxies';
        $accessToken = $this->accessToken;

        try {
            $resp = Http::withToken($accessToken)->acceptJson()->post($endpoint, $payload);
        } catch (\Exception $exception) {
            Log::error('[bulkRenew] Call partner API exception: '.$exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            throw new \RuntimeException('Không thể kết nối: '.$exception->getMessage());
        }

        return [
            'ok'     => $resp->successful(),
            'status' => $resp->status(),
            'body'   => $this->safeJson($resp),
            'raw'    => $resp,
        ];
    }

    public function bulkUpdateProtocal(array $userProxyIds, string $protocol = null): array
    {
        $payload = [
            "userProxyIds"  => array_values($userProxyIds),
        ];

        $payload["protocol"] = $protocol;

        $baseUrl    = $this->baseUrl;

        $endpoint = $baseUrl . '/api/merchant/orders/change-info-proxies';
        $accessToken = $this->accessToken;
        $resp = Http::withToken($accessToken)
            ->acceptJson()
            ->post($endpoint, $payload);

        return [
            'ok'    => $resp->successful(),
            'status'=> $resp->status(),
            'body'  => $this->safeJson($resp),
            'raw'   => $resp,
        ];
    }

    public function bulkRoate($userProxyId)
    {
        $baseUrl    = $this->baseUrl;

        $endpoint = $baseUrl . '/api/merchant/proxies/' . $userProxyId . '/rotate';
        $accessToken = $this->accessToken;

        $resp = Http::withToken($accessToken)
            ->acceptJson()
            ->get($endpoint);

        return [
            'ok'    => $resp->successful(),
            'status'=> $resp->status(),
            'body'  => $this->safeJson($resp),
            'raw'   => $resp,
        ];
    }
}
