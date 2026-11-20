<?php

namespace App\Services;

use App\Core\Enums\DefaultStatus;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyHomeProxy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxyHomeSyncService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = env('HOMEPROXY_BASE','');
        $this->token   = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function syncRenewedProxiesByOrders(array $oldLocalIds, int $autoRenew = 0): int
    {
        if (empty($oldLocalIds)) {
            return 0;
        }

        // 1. LẤY CHI TIẾT CÁC PROXY CŨ ĐỂ BIẾT CHÚNG THUỘC ĐƠN HÀNG NÀO
        // Bổ sung select thêm user_id và code để phục vụ cho việc tạo bản ghi mới khi đổi ID
        $localProxies = DB::table('proxy_home_proxies')
            ->whereIn('id', $oldLocalIds)
            ->select('id', 'user_id', 'code', 'ip', 'port', 'partner_item_id', 'partner_order_id')
            ->get();

        // Gom danh sách các mã đơn hàng gốc cần quét lại dữ liệu
        $partnerOrderIds = $localProxies->pluck('partner_order_id')->filter()->unique()->toArray();

        if (empty($partnerOrderIds)) {
            Log::error('[SyncRenew][DATA_ERROR] Không tìm thấy mã đơn hàng liên kết với các proxy id này.', [
                'oldLocalIds' => $oldLocalIds,
            ]);
            throw new \RuntimeException('Hệ thống không tìm thấy thông tin đơn hàng gốc. Vui lòng thử lại sau.');
        }

        $allPartnerItems = [];

        // 2. TẢI TOÀN BỘ DỮ LIỆU CẬP NHẬT TỪ HỆ THỐNG GỐC CỦA ĐƠN HÀNG
        foreach ($partnerOrderIds as $partnerOrderId) {
            $page = 1;
            do {
                $response = Http::withToken($this->token)
                    ->acceptJson()
                    ->get($this->baseUrl . '/api/merchant/proxies', [
                        'filter' => 'orderId:$eq:string:' . $partnerOrderId,
                        'page'   => $page,
                        'limit'  => 100
                    ]);

                if (!$response->ok()) {
                    Log::error('[SyncRenew][API_FAILED] Thất bại khi tải dữ liệu cấu hình từ hệ thống gốc', [
                        'partner_order_id' => $partnerOrderId,
                        'response'         => $response->body()
                    ]);
                    break;
                }

                $payload = $response->json() ?? [];
                $items   = $payload['data'] ?? [];
                $hasNext = (bool)($payload['hasNextPage'] ?? false);

                $allPartnerItems = array_merge($allPartnerItems, $items);
                $page++;
            } while ($hasNext);
        }

        if (empty($allPartnerItems)) {
            Log::error('[SyncRenew][SYNC_FAILED] Không lấy được dữ liệu cấu hình proxy từ hệ thống gốc.', [
                'partnerOrderIds' => $partnerOrderIds,
            ]);
            throw new \RuntimeException('Đồng bộ dữ liệu proxy thất bại. Vui lòng liên hệ bộ phận hỗ trợ kỹ thuật.');
        }

        // 3. TẠO MẠNG TRA CỨU NHANH THEO CẶP DUY NHẤT "IP:PORT"
        $partnerMap = [];
        foreach ($allPartnerItems as $item) {
            $ip   = $item['proxy']['ipaddress']['ip'] ?? null;
            $port = $item['proxy']['port'] ?? null;
            if ($ip && $port) {
                $mapKey = trim($ip) . ':' . trim($port);
                $partnerMap[$mapKey] = $item;
            }
        }

        // 4. TIẾN HÀNH PHÂN LOẠI XỬ LÝ (CẬP NHẬT HOẶC TẠO MỚI)
        $updatedCount = 0;
        DB::transaction(function () use ($localProxies, $partnerMap, $autoRenew, &$updatedCount) {
            foreach ($localProxies as $oldProxy) {
                $mapKey = trim($oldProxy->ip) . ':' . trim($oldProxy->port);

                // Tìm thông tin mới nhất khớp theo IP và Port
                $item = $partnerMap[$mapKey] ?? null;

                if (!$item) {
                    Log::warning('[SyncRenew][MISSING_ITEM] Không tìm thấy proxy cũ này trong dữ liệu mới cập nhật', [
                        'proxy_id'         => $oldProxy->id,
                        'ip'               => $oldProxy->ip,
                        'port'             => $oldProxy->port,
                        'partner_order_id' => $oldProxy->partner_order_id
                    ]);
                    continue;
                }

                $proxyData  = $item['proxy'] ?? [];
                $ipData     = $proxyData['ipaddress'] ?? [];
                $statusData = $item['status'] ?? [];

                $newPartnerItemId = (int)($item['id'] ?? 0);
                if ($newPartnerItemId <= 0) continue;

                $expiredAt        = $this->fromEpochMs($item['expiredAt'] ?? null);
                $changeIpAt       = $this->parseToTimeVN($ipData['changeIpAt'] ?? null);
                $partnerCreatedAt = $this->parseToTimeVN($item['createdAt'] ?? null);
                $partnerUpdatedAt = $this->parseToTimeVN($item['updatedAt'] ?? null);

                // ====================================================================
                // TRƯỜNG HỢP 1: TRÙNG ID GỐC (Gia hạn sớm khi chưa hết hạn)
                // => Chỉ cần ghi đè thời gian gia hạn mới lên chính bản ghi local cũ
                // ====================================================================
                if ($oldProxy->partner_item_id == $newPartnerItemId) {

                    DB::table('proxy_home_proxies')->where('id', $oldProxy->id)->update([
                        'protocol'           => $item['protocol'] ?? ($proxyData['protocol'] ?? null),
                        'username'           => $proxyData['username'] ?? null,
                        'password'           => $proxyData['password'] ?? null,
                        'rotate_interval'    => $proxyData['rotateInterval'] ?? 0,
                        'location'           => $ipData['location'] ?? null,
                        'provider'           => $ipData['provider'] ?? null,
                        'category_type_slug' => $ipData['categorytype']['slug'] ?? null,
                        'category_type_name' => $ipData['categorytype']['name'] ?? null,
                        'ip_entity_id'       => $ipData['id'] ?? null,
                        'change_ip_at'       => $changeIpAt,
                        'ttl'                => $ipData['ttl'] ?? null,
                        'status_id'          => isset($statusData['id']) ? (int)$statusData['id'] : null,
                        'status_name'        => $statusData['name'] ?? null,
                        'expired_at'         => $expiredAt,
                        'auto_renew'         => $autoRenew,
                        'partner_created_at' => $partnerCreatedAt,
                        'partner_updated_at' => $partnerUpdatedAt,
                        'partner_raw'        => json_encode($item, JSON_UNESCAPED_UNICODE),
                        'updated_at'         => now(),
                    ]);

                    Log::info("[SyncRenew][UPDATE_OK] Proxy [{$oldProxy->ip}] gia hạn sớm thành công. Giữ nguyên ID gốc [{$newPartnerItemId}].");
                }
                // ====================================================================
                // TRƯỜNG HỢP 2: KHÁC ID GỐC (Gia hạn trễ khi proxy đã hết hạn trước đó)
                // => Đổi trạng thái bản ghi cũ thành Hết hạn & Khởi tạo một dòng mới tinh
                // ====================================================================
                else {

                    // Cơ chế chặn trùng (Idempotency Check) phòng trường hợp khách hàng click lặp lệnh hoặc gọi lại hàm
                    $isAlreadyCreated = DB::table('proxy_home_proxies')
                        ->where('partner_item_id', $newPartnerItemId)
                        ->exists();

                    if (!$isAlreadyCreated) {

                        // A. Chuyển trạng thái bản ghi cũ thành hết hạn/đã bị thay thế để lưu vết lịch sử ví
                        DB::table('proxy_home_proxies')->where('id', $oldProxy->id)->update([
                            'status_id'   => -1, // Đánh dấu trạng thái đóng/hết hạn của hệ thống bạn
                            'status_name' => 'Expired (Renewed to new ID ' . $newPartnerItemId . ')',
                            'updated_at'  => now()
                        ]);

                        // B. Khởi tạo bản ghi mới chứa mã định danh ID mới
                        ProxyHomeProxy::create([
                            'partner_item_id'    => $newPartnerItemId,
                            'user_id'            => $oldProxy->user_id,
                            'code'               => $oldProxy->code,
                            'partner_order_id'   => $oldProxy->partner_order_id,
                            'protocol'           => $item['protocol'] ?? ($proxyData['protocol'] ?? null),
                            'username'           => $proxyData['username'] ?? null,
                            'password'           => $proxyData['password'] ?? null,
                            'ip'                 => $oldProxy->ip,
                            'port'               => $oldProxy->port,
                            'rotate_interval'    => $proxyData['rotateInterval'] ?? 0,
                            'location'           => $ipData['location'] ?? null,
                            'provider'           => $ipData['provider'] ?? null,
                            'category_type_slug' => $ipData['categorytype']['slug'] ?? null,
                            'category_type_name' => $ipData['categorytype']['name'] ?? null,
                            'ip_entity_id'       => $ipData['id'] ?? null,
                            'change_ip_at'       => $changeIpAt,
                            'ttl'                => $ipData['ttl'] ?? null,
                            'status_id'          => isset($statusData['id']) ? (int)$statusData['id'] : null,
                            'status_name'        => $statusData['name'] ?? null,
                            'expired_at'         => $expiredAt,
                            'auto_renew'         => $autoRenew,
                            'partner_created_at' => $partnerCreatedAt,
                            'partner_updated_at' => $partnerUpdatedAt,
                            'partner_raw'        => json_encode($item, JSON_UNESCAPED_UNICODE),
                        ]);

                        Log::info("[SyncRenew][NEW_RECORD_OK] Proxy [{$oldProxy->ip}] gia hạn muộn thành công. Đã đóng ID cũ [{$oldProxy->partner_item_id}] và tạo cấu hình mới ID [{$newPartnerItemId}].");
                    }
                }

                $updatedCount++;
            }
        });

        return $updatedCount;
    }

    public function syncProxy(ProxyHomeProxy $proxy)
    {
        try {
            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($this->baseUrl . '/api/merchant/proxies', [
                    'filter' => 'orderId:$eq:string:' . $proxy->partner_order_id
                ]);

            if (!$response->ok()) {
                Log::error('Proxy Home API lỗi khi sync', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'order_id' => $proxy->partner_order_id,
                    'url' => $this->baseUrl . '/api/merchant/proxies',
                    'params' => [
                        'filter' => 'orderId:$eq:string:' . $proxy->partner_order_id
                    ]
                ]);

                return null;
            }

            $response = $response->object()->data;
            foreach($response as $item)
            {
                if($proxy->partner_item_id == $item->id)
                {
                    $proxy->update([
                        'protocol' => $item->protocol,
                        'username' => $item->proxy->username,
                        'password' => $item->proxy->password,
                        'ip' => $item->proxy->ipaddress->ip,
                        'port' => $item->proxy->port,
                        'location' => $item->proxy->ipaddress->location,
                        'provider' => $item->proxy->ipaddress->provider,
                        'partner_raw' => json_encode($item, JSON_UNESCAPED_UNICODE)
                    ]);

                    return true;
                }
            }
            Log::info('Proxy Home: Item ID not found in response', [
                'target_id' => $proxy->partner_item_id,
                'received_ids' => collect($response)->pluck('id')
            ]);

            return false;
        }catch (\Throwable $e) {
            Log::error('Proxy Home Cập nhật IP không thành công!', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Cập nhật không thành công!');
        }
    }

    public function syncProxiesForOrder(ProxyHomeOrder $order): int
    {
        if (empty($order->partner_order_id)) {
            return 0;
        }

        $page = 1;
        $insertedOrUpdated = 0;

        do {
            $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($this->baseUrl . '/api/merchant/proxies', [
                    'filter' => 'orderId:$eq:string:' . $order->partner_order_id,
                    'page' => $page,
                    'limit' => 100
                ]);

            if (!$response->ok()) {
                break;
            }

            $payload = $response->json() ?? [];
            $items   = $payload['data'] ?? [];
            $hasNext = (bool)($payload['hasNextPage'] ?? false);

            foreach ($items as $item) {
                if (($item['orderId'] ?? null) !== $order->partner_order_id) {
                    continue;
                }

                $proxy = $item['proxy'] ?? [];
                $ip    = $proxy['ipaddress'] ?? [];
                $status= $item['status'] ?? [];

                $partnerItemId = (int)($item['id'] ?? 0);
                if ($partnerItemId <= 0) {
                    continue;
                }

                $expiredAt = $this->fromEpochMs($item['expiredAt'] ?? null);
                $changeIpAt = $this->parseToTimeVN($ip['changeIpAt'] ?? null);
                $partnerCreatedAt = $this->parseToTimeVN($item['createdAt'] ?? null);

                $partnerUpdatedAt = $this->parseToTimeVN($item['updatedAt'] ?? null);

                ProxyHomeProxy::updateOrCreate(
                    ['partner_item_id' => $partnerItemId],
                    [
                        'user_id'           => $order->user_id,
                        'code'              => $order->code,
                        'partner_order_id'   => $order->partner_order_id,
                        'protocol'           => $item['protocol'] ?? ($proxy['protocol'] ?? null),

                        'username'           => $proxy['username'] ?? null,
                        'password'           => $proxy['password'] ?? null,
                        'ip'                 => $proxy['ipaddress']['ip'] ?? null,
                        'port'               => isset($proxy['port']) ? (int)$proxy['port'] : null,
                        'rotate_interval'    => $proxy['rotateInterval'] ?? 0,

                        'location'           => $ip['location'] ?? null,
                        'provider'           => $ip['provider'] ?? null,
                        'category_type_slug' => $ip['categorytype']['slug'] ?? null,
                        'category_type_name' => $ip['categorytype']['name'] ?? null,

                        'ip_entity_id'       => $ip['id'] ?? null,
                        'change_ip_at'       => $changeIpAt,
                        'ttl'                => $ip['ttl'] ?? null,

                        'status_id'          => isset($status['id']) ? (int)$status['id'] : null,
                        'status_name'        => $status['name'] ?? null,

                        'expired_at'         => $expiredAt,
                        'partner_created_at' => $partnerCreatedAt,
                        'partner_updated_at' => $partnerUpdatedAt,

                        'partner_raw'        => json_encode($item, JSON_UNESCAPED_UNICODE),
                    ]
                );

                $insertedOrUpdated++;
            }

            $page++;
        } while ($hasNext);

        return $insertedOrUpdated;
    }

    private function fromEpochMs($ms): ?string
    {
        if (empty($ms)) return null;
        try {
            $sec = (int) floor($ms / 1000);
            return date('Y-m-d H:i:s', $sec);
        } catch (\Throwable) {
            return null;
        }
    }

    private function parseIso(?string $iso): ?string
    {
        if (empty($iso)) return null;
        try {
            return date('Y-m-d H:i:s', strtotime($iso));
        } catch (\Throwable) {
            return null;
        }
    }

    public static function parseToTimeVN($datetime)
    {
        if($datetime)
        {
            return Carbon::parse($datetime, 'UTC')
            ->setTimezone('Asia/Ho_Chi_Minh')
            ->format('Y-m-d H:i:s');
        }

        return null;
    }
}
