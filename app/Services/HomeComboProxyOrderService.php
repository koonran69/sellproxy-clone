<?php

namespace App\Services;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\ComboProxyOrderData;
use App\Models\ProxyHomeOrder;
use App\Models\Transaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeComboProxyOrderService
{
    protected string $api_host;
    protected string $accessToken;
    public function __construct(
        private readonly CredentialService $cred
    ) {
        $this->api_host = env('HOMEPROXY_BASE','');
        $this->accessToken = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function notEnoungMoney(int $userId, ComboProxyOrderData $dto): bool
    {
        $total = $this->computeTotal($dto);

        $user = DB::table('users')->where('id', $userId)->first();

        if($user->available_balance < $total)
        {
            return true;
        }

        return false;
    }

    public function create(int $userId, ComboProxyOrderData $dto)
    {
        $this->ensureCredentials($dto);

        $total = $this->computeTotal($dto);

        $configs = config('proxyhome.combos');
        $item = collect($configs)->where('id', $dto->id)->where('provider', $dto->provider)->first();
        if(!$item){
            throw new \RuntimeException('Không tìm thấy gói combo');
        }

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
                'note' => "Thanh toán đơn hàng (".$item['name'].") #$orderModel->code"
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

    public function computeTotal(ComboProxyOrderData $dto): int
    {
        $configs = config('proxyhome.combos');
        $item = collect($configs)->where('id', $dto->id)->where('provider', $dto->provider)->first();

        if (!$item) {
            return 0;
        }

        $basePrice = (int) ($item['price'] ?? 0);
        $discountRules = $item['discount_rules'] ?? [];
        $unit = $dto->unit;
        $quantity = $dto->quantity;

        $discountPercent = 0;

        if (!empty($discountRules)) {
            if (isset($discountRules['min_unit'])) {
                if ($unit >= (int)$discountRules['min_unit']) {
                    $discountPercent = (float)($discountRules['percent'] ?? 0);
                }
            }
            elseif (isset($discountRules['tiers']) && is_array($discountRules['tiers'])) {
                foreach ($discountRules['tiers'] as $tier) {
                    if ($unit >= (int)$tier[0]) {
                        $discountPercent = (float)$tier[1];
                    }
                }
            }
        }

        $subTotal = $basePrice * $unit * $quantity;
        $total = $subTotal * (1 - $discountPercent / 100);

        return (int) floor($total + 0.5); // Làm tròn tương đương Math.round ở FE
    }

    protected function ensureCredentials(ComboProxyOrderData $dto): void
    {
        if (trim(strtolower($dto->user)) === 'random') {
            $dto->user = $this->cred->makeUsername('sel');
        }
        if (trim(strtolower($dto->password)) === 'random') {
            $dto->password = $this->cred->makePassword();
        }
    }

    protected function storeLocalOrder(int $userId, ComboProxyOrderData $dto, int $total, array $apiRes): array
    {
        $ratios = [
            'day'   => 1,
            'week'  => 7,
            'month' => 30,
        ];

        $dayOfUse = $dto->unit * $ratios[$dto->type_unit];
        if(in_array(strtolower(trim($dto->provider)),['cmc','us'])){
            //đây là combo proxy datacenter
            $type = 'proxy-datacenter-'.strtolower(trim($dto->provider));
        }else{
            //đây là combo proxy tĩnh vn thuộc viettel, fpt hoặc vnpt
            $type = 'static';
        }

        $order = ProxyHomeOrder::create([
            'partner_order_id' => $apiRes['id'],
            'code'             => uniqid_real(),
            'user_id'          => $userId,
            'type'             => $type,
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

    protected function callPartnerApi(ComboProxyOrderData $dto): array
    {
        $baseUrl    = $this->api_host;
        $merchantId = env('PROXY_API_MERCHANT_ID');

        $configs = config('proxyhome.combos');
        $item = collect($configs)->where('id', $dto->id)->where('provider', $dto->provider)->first();

        if (!$item) {
            throw new \RuntimeException('Tạo đơn hàng thất bại!. Không tìm thấy gói combo');
        }

        $url = $baseUrl . '/api/merchant/orders';

        $payload = [
            'paymentMethod' => 'WALLET',
            'withTaxCode' => false,
            'products' => [[
                'dayOfUse'     => $dto->unit, //bên gốc tự bắt theo id combo để phân biệt đây là số lượng ngày hay tháng
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
