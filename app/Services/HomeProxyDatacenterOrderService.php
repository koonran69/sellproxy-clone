<?php

namespace App\Services;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\ProxyDatacenterOrderData;
use App\Models\ProxyHomeOrder;
use App\Models\Transaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeProxyDatacenterOrderService
{
    protected string $api_host;
    protected string $accessToken;
    public function __construct(
        private readonly CredentialService $cred
    ) {
        $this->api_host = env('HOMEPROXY_BASE','');
        $this->accessToken = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function notEnoungMoney(int $userId, ProxyDatacenterOrderData $dto): bool
    {
        $total = $this->computeTotal($dto);

        $user = DB::table('users')->where('id', $userId)->first();

        if($user->available_balance < $total)
        {
            return true;
        }

        return false;
    }

    public function create(int $userId, ProxyDatacenterOrderData $dto)
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
                'note' => 'Thanh toán đơn hàng (Proxy datacenter) #'.$orderModel->code
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

    public function computeTotal(ProxyDatacenterOrderData $dto): int
    {
        $configs = config('proxyhome.datacenter_proxies');
        $item = collect($configs)->firstWhere('provider', $dto->provider);

        $basePrice = $item['price'];
        $tiers = $item['tiers'] ?? [];
        $months = $dto->unit;
        $quantity = $dto->quantity;

        $discountRate = 0;

        if (!empty($tiers)) {
            foreach ($tiers as $minMonths => $rate) {
                if ($months >= (int)$minMonths) {
                    $discountRate = (float)$rate;
                }
            }
        }

        $pricePerMonth = $basePrice * (1 - $discountRate);
        $subTotal = $pricePerMonth * $months * $quantity;
        return (int) floor($subTotal + 0.5); //Tự làm tròn theo kiểu cộng 0.5 rồi ép kiểu int (tương đương Math.round ở fe)
    }

    protected function ensureCredentials(ProxyDatacenterOrderData $dto): void
    {
        if (trim(strtolower($dto->user)) === 'random') {
            $dto->user = $this->cred->makeUsername('sel');
        }
        if (trim(strtolower($dto->password)) === 'random') {
            $dto->password = $this->cred->makePassword();
        }
    }

    protected function storeLocalOrder(int $userId, ProxyDatacenterOrderData $dto, int $total, array $apiRes): array
    {
        $ratios = [
            'day'   => 1,
            'week'  => 7,
            'month' => 30,
        ];

        $dayOfUse = $dto->unit * $ratios['month']; //proxy datacenter chỉ bán theo tháng

        $order = ProxyHomeOrder::create([
            'partner_order_id' => $apiRes['id'],
            'code'             => uniqid_real(),
            'user_id'          => $userId,
            'type'             => 'proxy-datacenter-'.strtolower(trim($dto->provider)), //CMC: Việt nam, US: Mỹ
            'provider'         => $dto->provider,
            'protocol'         => $dto->protocol,
            'location'         => $dto->location,
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

    public function bulkRenew(array $userProxyIds, int $days, int $autoRenew = 0): array
    {
        $autoRenew = 0; //TODO update chắc chắn không cho bậc auto renew bên gốc, auto chỉ có bên web
        $payload = [
            "userProxyIds" => array_values($userProxyIds),
            "dayOfRenewal" => (int)$days,
            "isRenewal"    => (boolean)$autoRenew,
        ];

        $baseUrl    = $this->api_host;
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

    protected function callPartnerApi(ProxyDatacenterOrderData $dto): array
    {
        $baseUrl    = $this->api_host;
        $merchantId = env('PROXY_API_MERCHANT_ID');

        $configs = config('proxyhome.datacenter_proxies');
        $item = collect($configs)->firstWhere('provider', $dto->provider);

        $url = $baseUrl . '/api/merchant/orders';

        $payload = [
            'paymentMethod' => 'WALLET',
            'withTaxCode' => false,
            'products' => [[
                'dayOfUse'     => $dto->unit,
                'isAutoRotate' => false,
                'isCdk'        => false,
                'password'     => $dto->password,
                'user'         => $dto->user,
                'protocolType' => $dto->protocol,
                'provider'     => $dto->provider,
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
