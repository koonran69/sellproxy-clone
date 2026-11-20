<?php

namespace App\Services;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\ProxyStaticOrderData;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyHomeProxy;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProxyStaticOrderService
{
    protected string $baseUrl;
    protected string $accessToken;
    public function __construct(
        private readonly HomeProxyAuthService $authService,
        private readonly CredentialService $cred
    ) {
        $this->baseUrl = env('HOMEPROXY_BASE','');
        $this->accessToken = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function create(int $userId, ProxyStaticOrderData $dto): array
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
            throw $exception;
            DB::rollBack();
            Log::error('[ProxyStatic] Call create exception: '.$exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            return [];
        }
    }

    public function computeTotal(ProxyStaticOrderData $dto): int
    {
//        $unitPrices = config('proxyhome.unit_price_static', []);
//
//        if($dto->days > 30)
//        {
//            $add = $dto->days - 30;
//
//            $unit = $unitPrices[30] + (600 * $add);
//        }else {
//
//            $unit = $unitPrices[$dto->days];
//        }
//
//        if ($unit === null) {
//            throw new \RuntimeException('Không tìm thấy đơn giá cho nhà mạng: ' . $dto->provider);
//        }
//
//        return (int) ($unit * $dto->quantity);

        // 1. Lấy giá gốc theo nhà mạng từ config (mặc định 1200 nếu không có)
        $allUnitPrices = config('proxyhome.unit_prices', []);
        $basePrice = $allUnitPrices[$dto->provider] ?? 1200;

        $days = $dto->days;
        $discount = 0;
        // 2. Xác định tỷ lệ giảm giá dựa trên số ngày
        if ($days >= 1 && $days <= 5) {
            $discount = 0;
        } elseif ($days >= 6 && $days <= 10) {
            $discount = 0.1; // Giảm 10%
        } elseif ($days >= 11 && $days <= 20) {
            $discount = 0.2; // Giảm 20%
        } elseif ($days >= 21 && $days <= 25) {
            $discount = 0.3; // Giảm 30%
        } elseif ($days >= 26) {
            $discount = 0.4; // Giảm 40%
        }

        // 3. Tính đơn giá cho 1 proxy trên tổng số ngày sử dụng
        // Công thức: (Giá gốc * (1 - %giảm giá)) * Số ngày
        $priceForOneProxy = ($basePrice * (1 - $discount)) * $days;

        // 4. Nhân với số lượng và ép kiểu về int
        return (int) ($priceForOneProxy * $dto->quantity);
    }

    protected function ensureCredentials(ProxyStaticOrderData $dto): void
    {
        if (trim(strtolower($dto->user)) === 'random') {
            $dto->user = $this->cred->makeUsername($dto->provider);
        }
        if (trim(strtolower($dto->password)) === 'random') {
            $dto->password = $this->cred->makePassword();
        }
    }

    protected function callPartnerApi(ProxyStaticOrderData $dto): array
    {
        $baseUrl    = $this->baseUrl;
        $merchantId = env('PROXY_API_MERCHANT_ID');
        $token      = env('PROXY_API_TOKEN');

        $productId = $dto->productId ?: Arr::get(config('proxyhome.product_ids.static'), $dto->provider);
        if (!$productId) {
            throw new \RuntimeException('Thiếu mapping product id cho nhà mạng ' . $dto->provider);
        }

        $url = $baseUrl . '/api/merchant/orders';

        $payload = [
            'paymentMethod' => 'WALLET',
            'products' => [[
                'dayOfUse'     => $dto->days,
                'password'     => $dto->password,
                'user'         => $dto->user,
                'protocolType' => strtoupper($dto->protocolType),
                'quantity'     => $dto->quantity,
                'provider'     => $dto->provider,
                'product'      => ['id' => $productId],
            ]],
        ];

        if (!empty($dto->location) && $dto->location != "random" ) {
            $payload['products'][0]['location'] = $dto->location;
        }
        //$accessToken = $this->authService->getAccessToken();
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
                Log::warning('[ProxyStatic] Partner API error', [
                    'status' => $res->status(),
                    'body'   => $res->body(),
                ]);
                throw new \RuntimeException('Tạo đơn hàng thất bại (HTTP '.$res->status().')');
            }
            return $res->json();
        } catch (\Throwable $e) {
            Log::error('[ProxyStatic] Call partner API exception: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \RuntimeException('Không thể kết nối: '.$e->getMessage());
        }
    }

    protected function storeLocalOrder(int $userId, ProxyStaticOrderData $dto, int $total, array $apiRes): array
    {
        $order = ProxyHomeOrder::create([
            'partner_order_id' => $apiRes['id'],
            'code'             => uniqid_real(),
            'user_id'          => $userId,
            'type'             => 'static',
            'provider'         => $dto->provider,
            'protocol'         => $dto->protocolType,
            'location'         => $dto->location,
            'days'             => $dto->days,
            'quantity'         => $dto->quantity,
            'amount'           => $total,
            'partner_response' => json_encode($apiRes, JSON_UNESCAPED_UNICODE),
            'status'           => 'created',
        ]);

        return $order->toArray();
    }

    public function bulkUpdateAuth(array $userProxyIds, string $username, string $password, ?string $protocol = null, ?int $rotateInterval = null, ?bool $is_rotate = false): array
    {
        $payload = [
            "userProxyIds"  => array_values($userProxyIds),
            "password"      => $password,
            "username"      => $username,
        ];

        if ($protocol !== null && $protocol !== '') {
            $payload["protocol"] = $protocol;
        }

        if ($rotateInterval !== null && $is_rotate) {
            $payload["rotateInterval"] = (int) $rotateInterval;
            $payload["isAutoRotate"] = true;
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

    public function bulkRenew(array $userProxyIds, int $days, int $autoRenew = 0, ?int $categoryTypeId = null): array
    {
        $autoRenew = 0;
        $payload = [
            "userProxyIds" => array_values($userProxyIds),
            "dayOfRenewal" => (int)$days,
            "isRenewal"    => (boolean)$autoRenew,
        ];

        if($categoryTypeId !== null && $categoryTypeId != 0)
        {
            $payload['categoryTypeId'] = $categoryTypeId;
        }

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

    public function renewProxyBySystem($proxy) {
        $order = $proxy->order;
        $total = $order->amount / $order->quantity;
        $days    = (int)$order->days;

        switch ($order->type) {
            case 'proxy-datacenter-cmc': //proxy datacenter
            case 'proxy-datacenter-us':
            case 'static': //proxy tĩnh
                $cat_type_id = 1;
                break;

            case 'rotate': //proxy xoay
            case 'key-rotate': //key xoay
                $cat_type_id = 2;
                break;

            case 'combo': //combo gồm tĩnh và datacenter
                $cat_type_id = 4;
                break;

            default:
                throw new \RuntimeException('Không gia hạn được!');
                break;
        }

        $user = $proxy->user;
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng (renewProxyBySystem home)');
        }
        if ($user->available_balance < $total) {
            throw new \RuntimeException('Số dư ví không đủ để thanh toán. (renewProxyBySystem home)');
        }
        $userProxyIds = [$proxy->partner_item_id];
        if (empty($userProxyIds)) {
            throw new \RuntimeException('Thiếu partner_item_id để gia hạn. (renewProxyBySystem home)');
        }

        $resp = $this->bulkRenew($userProxyIds, $days, false, $cat_type_id);
        if (!$resp['ok']) {
            throw new \RuntimeException('Gọi API gia hạn thất bại. (renewProxyBySystem home)');
        }

        DB::transaction(function () use ($user, $total, $days, $proxy , $order) {

            $lockedUser = User::query()
                ->whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedUser->available_balance < $total) {
                throw new \RuntimeException('Số dư không đủ');
            }

            $lockedUser->decrement('available_balance', $total);
            $lockedUser->decrement('balance', $total);

            Transaction::create([
                'user_id' => $user->id,
                'code' => 'PRX' . uniqid_real(),
                'amount' => $total * -1,
                'status' => TransactionStatus::Paid,
                'reference_id' => $order->id,
                'reference_type' => ProxyHomeOrder::class,
                'note'           => sprintf(
                    'Gia hạn đơn hàng #%code 1 proxy (%d ngày). Danh sách IP: [%s]. ID proxy cũ: [%s]',
                    $order->code,
                    $days,
                    $proxy->ip,
                    $proxy->partner_item_id
                ),
            ]);
            ProxyHomeProxy::where('id', $proxy->id)
                ->update([
                    'expired_at' => DB::raw("DATE_ADD(expired_at, INTERVAL {$days} DAY)")
                ]);

        });
    }
}
