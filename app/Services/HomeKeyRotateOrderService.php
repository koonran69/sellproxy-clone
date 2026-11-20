<?php

namespace App\Services;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\KeyRotateOrderData;
use App\Models\ProxyHomeOrder;
use App\Models\Transaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeKeyRotateOrderService
{
    protected string $api_host;
    protected string $accessToken;
    public function __construct(
        private readonly CredentialService $cred
    ) {
        $this->api_host = env('HOMEPROXY_BASE','');
        $this->accessToken = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function notEnoungMoney(int $userId, KeyRotateOrderData $dto): bool
    {
        $total = $this->computeTotal($dto);

        $user = DB::table('users')->where('id', $userId)->first();

        if($user->available_balance < $total)
        {
            return true;
        }

        return false;
    }

    public function generateToken($partner_item_id)
    {
        $baseUrl    = $this->api_host;
        $url        = $baseUrl . "/api/merchant/proxies/{$partner_item_id}/generate-token";
        $accessToken = $this->accessToken;

        try {
            $req = Http::acceptJson()
                ->withToken($accessToken)
                ->timeout(20);

            $res = $req->get($url);

            if (!$res->successful()) {
                Log::warning('[ProxyRotate] Partner API error', [
                    'status' => $res->status(),
                    'body'   => $res->body(),
                ]);
                throw new \RuntimeException('Generate token thất bại (HTTP '.$res->status().')');
            }

            return $res->json();
        } catch (\Throwable $e) {
            Log::error('[ProxyRotate] Call partner API exception: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \RuntimeException('Không thể kết nối: '.$e->getMessage());
        }
    }

    public function create(int $userId, KeyRotateOrderData $dto)
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
                'note' => 'Thanh toán đơn hàng (Key Xoay) #'.$orderModel->code
            ]);

            sleep(3);
            app(ProxyHomeSyncService::class)->syncProxiesForOrder($orderModel);

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

    public function computeTotal(KeyRotateOrderData $dto): int
    {
        $configs = config('proxyhome.rotate_keys');
        $item = collect($configs)->firstWhere('unit', $dto->typeUnit);
        return $item['price'] * $dto->unit * $dto->quantity;
    }

    protected function ensureCredentials(KeyRotateOrderData $dto): void
    {
        if (trim(strtolower($dto->user)) === 'random') {
            $dto->user = $this->cred->makeUsername('sel');
        }
        if (trim(strtolower($dto->password)) === 'random') {
            $dto->password = $this->cred->makePassword();
        }
    }

    protected function storeLocalOrder(int $userId, KeyRotateOrderData $dto, int $total, array $apiRes): array
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
            'type'             => 'key-rotate',
            'provider'         => 'HOMEPROXY',
            'protocol'         => 'HTTP',
            'location'         => '', //key-rotate không có location
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

        $baseUrl    = $this->api_host;

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

    public function bulkUpdateProtocal(array $userProxyIds, string $protocol = null): array
    {
        $payload = [
            "userProxyIds"  => array_values($userProxyIds),
        ];

        $payload["protocol"] = $protocol;

        $baseUrl    = $this->api_host;

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
        $baseUrl    = $this->api_host;

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

    protected function callPartnerApi(KeyRotateOrderData $dto): array
    {
        $baseUrl    = $this->api_host;
        $merchantId = env('PROXY_API_MERCHANT_ID');

        $configs = config('proxyhome.rotate_keys');
        $item = collect($configs)->firstWhere('unit', $dto->typeUnit);

        $url = $baseUrl . '/api/merchant/orders';

        $payload = [
            'paymentMethod' => 'WALLET',
            'withTaxCode' => false,
            'products' => [[
                'dayOfUse'     => $dto->unit,
                'isAutoRotate' => false,
                'isCdk'        => true, //key rorate
                'password'     => $dto->password,
                'user'         => $dto->user,
                'protocolType' => 'HTTP',
                'provider' => 'HOMEPROXY',
                'quantity'     => $dto->quantity,
                'rotateInterval' => $dto->interval ?? 0,
                'product'      => ['id' => $item['id']],
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

            $res = $req->post($url, $payload);

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

    private function safeJson(Response $resp)
    {
        try {
            return $resp->json();
        } catch (\Throwable $e) {
            return $resp->body();
        }
    }
}
