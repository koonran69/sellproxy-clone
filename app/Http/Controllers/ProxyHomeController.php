<?php

namespace App\Http\Controllers;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Dto\ComboProxyOrderData;
use App\Dto\KeyRotateOrderData;
use App\Dto\ProxyDatacenterOrderData;
use App\Dto\ProxyRotateOrderData;
use App\Dto\ProxyStaticOrderData;
use App\Http\Requests\HomeKeyRotateOrderRequest;
use App\Http\Requests\HomeProxyComboOrderRequest;
use App\Http\Requests\HomeProxyDatacenterOrderRequest;
use App\Http\Requests\StoreProxyRotateOrderRequest;
use App\Http\Requests\StoreProxyStaticOrderRequest;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyHomeProxy;
use App\Models\Transaction;
use App\Services\HomeComboProxyOrderService;
use App\Services\HomeKeyRotateOrderService;
use App\Services\HomeProxyDatacenterOrderService;
use App\Services\ProxyHomePricingService;
use App\Services\ProxyHomeSyncService;
use App\Services\ProxyRotateOrderService;
use App\Services\ProxyStaticOrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Rap2hpoutre\FastExcel\FastExcel;

class ProxyHomeController extends Controller
{
    public function __construct(
        private readonly ProxyStaticOrderService $proxyStaticOrderService,
        private readonly ProxyRotateOrderService $proxyRotateOrderService,
        private readonly HomeKeyRotateOrderService $homeKeyRotateOrderService,
        private readonly HomeProxyDatacenterOrderService $homeProxyDatacenterOrderService,
        private readonly HomeComboProxyOrderService $homeComboProxyOrderService,

        public ProxyHomeSyncService $syncService
    ) {

    }

    public function handleSyncProxiesForOrder(Request $request)
    {
        $request->validate([
            'partner_order_id' => 'required|string',
        ]);
        $partnerOrderId = $request->partner_order_id;
        $orderModel = ProxyHomeOrder::query()
            ->where('partner_order_id', $partnerOrderId)
            ->first();
        if (!$orderModel) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng với partner_order_id này trong hệ thống.',
                'partner_order_id' => $partnerOrderId
            ], 404);
        }
        try {
            $syncService = app(ProxyHomeSyncService::class);
            $synced = false;
            $retryCount = 3;
            while ($retryCount > 0 && !$synced) {
                $synced = $syncService->syncProxiesForOrder($orderModel);
                if (!$synced && $retryCount > 1) {
                    sleep(2);
                }
                $retryCount--;
            }
            if (!$synced) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã gọi đồng bộ nhưng bên thứ 3 chưa trả về dữ liệu proxy. Vui lòng thử lại sau ít phút.',
                    'partner_order_id' => $partnerOrderId
                ], 400);
            }
            return response()->json([
                'success' => true,
                'message' => 'Đồng bộ proxy thủ công thành công!',
                'partner_order_id' => $partnerOrderId,
                'proxies_count' => $orderModel->proxies()->count() ?? 0,
            ]);

        } catch (\Exception $e) {
            Log::error("Sync proxies failed for order {$partnerOrderId}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống khi đồng bộ proxy: ' . $e->getMessage(),
                'partner_order_id' => $partnerOrderId
            ], 500);
        }
    }

    public function generateTokenKeyRotate(Request $request, $partner_item_id)
    {
        $user = $request->user();

        $proxyHome = ProxyHomeProxy::where('user_id', $user->id)
            ->where('partner_item_id', $partner_item_id)
            ->first();

        if(!$proxyHome){
            return response()->json([
                'status' => false,
                'message' => "Proxy #$partner_item_id Not Found",
            ], 422);
        }

        try {
            $result = $this->homeKeyRotateOrderService->generateToken($partner_item_id);
            return response()->json([
                'status' => true,
                'message' => 'Lấy token thành công',
                'token' => $result['token'] ?? ($result['data']['token'] ?? null),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function keyRotateList() {
        return view("proxyhome.key-rotate", ['keys' => config('proxyhome.rotate_keys')]);
    }

    public function submitKeyRotateOrder(HomeKeyRotateOrderRequest $request)
    {
        $user = $request->user();

        $dto = new KeyRotateOrderData($request->validated());

        if($this->homeKeyRotateOrderService->notEnoungMoney($user->id, $dto))
        {
            return response()->json([
                'status' => false,
                'message'     => trans('Ví của bạn không đủ tiền!'),
            ]);
        }

        try {
            $result = $this->homeKeyRotateOrderService->create($user->id, $dto);
            return response()->json([
                'status' => true,
                'message'     => 'Tạo đơn hàng thành công',
                'amount'      => $result['amount'],
                'local_order' => $result['local_order'],
                'partner'     => $result['partner_raw'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function listKeyRotate(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable|in:id,code',
            'q'         => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q        = trim($validated['q'] ?? '');

        return view("proxyhome.listKeyRotate", [
            'search_by' => $searchBy,
            'q'         => $q
        ]);
    }

    public function proxyDatacenterList() {
        return view("proxyhome.proxy-datacenter", ['datacenters' => config('proxyhome.datacenter_proxies')]);
    }

    public function submitProxyDatacenterOrder(HomeProxyDatacenterOrderRequest $request)
    {
        $user = $request->user();

        $dto = new ProxyDatacenterOrderData($request->validated());

        if($this->homeProxyDatacenterOrderService->notEnoungMoney($user->id, $dto))
        {
            return response()->json([
                'status' => false,
                'message'     => trans('Ví của bạn không đủ tiền!'),
            ]);
        }

        try {
            $result = $this->homeProxyDatacenterOrderService->create($user->id, $dto);

            return response()->json([
                'status' => true,
                'message'     => 'Tạo đơn hàng thành công',
                'amount'      => $result['amount'],
                'local_order' => $result['local_order'],
                'partner'     => $result['partner_raw'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function listProxyDatacenter(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable|in:id,code',
            'q'         => 'nullable|string|max:255',
        ]);

        $searchBy = $validated['search_by'] ?? 'id';
        $q        = trim($validated['q'] ?? '');

        return view("proxyhome.listProxyDatacenter", [
            'search_by' => $searchBy,
            'q'         => $q,
            'datacenters' => config('proxyhome.datacenter_proxies')
        ]);
    }

    public function comboProxyList(Request $request)
    {
        $allCombos = config('proxyhome.combos');

        return view("proxyhome.combo-proxy", [
            'comboTinh' => array_filter($allCombos, fn($i) => str_contains($i['slug'], 'tinh')),
            'comboVN'   => array_filter($allCombos, fn($i) => str_contains($i['slug'], 'dc-vn')),
            'comboUS'   => array_filter($allCombos, fn($i) => str_contains($i['slug'], 'dc-us')),
        ]);
    }

    public function submitComboOrder(HomeProxyComboOrderRequest $request)
    {
        $user = $request->user();

        $dto = new ComboProxyOrderData($request->validated());

        if($this->homeComboProxyOrderService->notEnoungMoney($user->id, $dto))
        {
            return response()->json([
                'status' => false,
                'message'     => trans('Ví của bạn không đủ tiền!'),
            ]);
        }

        try {
            $result = $this->homeComboProxyOrderService->create($user->id, $dto);
            return response()->json([
                'status' => true,
                'message'     => 'Tạo đơn hàng thành công',
                'amount'      => $result['amount'],
                'local_order' => $result['local_order'],
                'partner'     => $result['partner_raw'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function proxyStaticList(Request $request)
    {
        $data['locations'] = config('proxyhome.locations');
        $data['prices'] = config('proxyhome.unit_price_static');

        $data['unit_prices'] = config('proxyhome.unit_prices');

        return view("proxyhome.static")->with($data);
    }

    public function proxyRotateList(Request $request)
    {
        return view("proxyhome.rotate");
    }

    public function proxyStaticOrder(StoreProxyStaticOrderRequest $request)
    {
        $user = $request->user();

        $dto = new ProxyStaticOrderData($request->validated());

        try {
            $result = $this->proxyStaticOrderService->create($user->id, $dto);

            return response()->json([
                'message'     => 'Tạo đơn hàng thành công',
                'amount'      => $result['amount'],
                'local_order' => $result['local_order'],
                'partner'     => $result['partner_raw'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function listProxies(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable|in:id,code',
            'q'         => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q        = trim($validated['q'] ?? '');
        $unitPrices = config('proxyhome.unit_price_static', []);

        $unitPriceStatic = config('proxyhome.unit_prices');
        return view("proxyhome.listProxy", [
            'search_by' => $searchBy,
            'q'         => $q,
            'unitPrices' => $unitPrices,
            'unitPriceStatic' => $unitPriceStatic,
        ]);
    }

    public function searchProxies(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['type_proxy'] = $request->input('type_proxy') !== "proxy-datacenter" ? [$request->input('type_proxy')] : ["proxy-datacenter-us","proxy-datacenter-cmc"];
        $filter['q'] = $request->input('q', '');

        $sql = ProxyHomeProxy::with('order');
        $sql->whereHas('order', function ($query) use ($filter) {
            $query->whereIn('type', $filter['type_proxy']);
        });
        $sql->where('category_type_slug', 'static');
        $sql->where('user_id', '=', $user->id);
        $sql->where('status_id', '!=', -1);

        if(!empty($filter['q'])) {
            switch ($filter['search_by']) {
                case 'id':
                    $sql->where(fn($q) => $q->where('id', $filter['q'])->orWhere('ip', $filter['q']));
                    break;
                case 'code':
                    $sql->where('code', $filter['q']);
                    break;
            }
        }

        $sort = $filter['sort'] ?? 'updated_at';
        $order = $filter['order'] ?? 'desc';
        if ($sort) {
            $sql->orderBy($sort, $order);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->get()
            ->toArray();

        return response()->json([
            'total' => $total,
            'rows' => $data,
        ]);
    }

    public function bulkChangePassword(Request $request)
    {
        $validated = $request->validate([
            'items'           => 'required|string',
            'account'         => 'required|string|min:3|max:100',
            'password'        => 'required|string|min:9|max:100',
            'protocol'        => 'nullable|string|max:20',
            'rotate_interval' => 'nullable|integer|min:0',
        ], [
            'items.required'    => 'Chưa chọn proxy nào.',
            'account.required'  => 'Vui lòng nhập tài khoản.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $items = json_decode($validated['items'], true);

        if (!is_array($items) || empty($items)) {
            throw ValidationException::withMessages(['items' => 'Payload items không hợp lệ.']);
        }

        $userProxyIds = collect($items)
            ->map(fn($it) => Arr::get($it, 'partner_item_id'))
            ->filter(fn($v) => filled($v))
            ->unique()
            ->values()
            ->all();

        if (empty($userProxyIds)) {
            throw ValidationException::withMessages(['items' => 'Không tìm thấy ip_entity_id hợp lệ.']);
        }
        $username       = $validated['account'];
        $password       = $validated['password'];
        $protocol       = $validated['protocol'] ?? null;
        $rotateInterval = array_key_exists('rotate_interval', $validated) ? (int) $validated['rotate_interval'] : null;
        $result = $this->proxyStaticOrderService->bulkUpdateAuth(
            userProxyIds: $userProxyIds,
            username: $username,
            password: $password,
            protocol: $protocol,
            rotateInterval: $rotateInterval
        );

        if (!$result['ok']) {
            Log::warning('Bulk change-auth failed', [
                'status' => $result['status'],
                'body'   => $result['body'],
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gọi API thất bại.',
                'detail'  => $result['body'],
            ], 422);
        }

        $localIds = collect($items)
            ->map(fn($it) => Arr::get($it, 'id'))
            ->filter(fn($v) => !empty($v))
            ->unique()
            ->values()
            ->all();

        if (!empty($localIds)) {
            DB::transaction(function () use ($localIds, $username, $password) {
                ProxyHomeProxy::whereIn('id', $localIds)->update([
                    'username' => $username,
                    'password' => $password,
                    'updated_at'    => now(),
                ]);
            });
        }

        return response()->json([
            'status'  => 'ok',
            'message' => 'Cập nhật thông tin proxy thành công.',
            'data'    => [
                'requested' => [
                    'count_userProxyIds' => count($userProxyIds),
                    'protocol'           => $protocol,
                    'rotateInterval'     => $rotateInterval,
                ],
                'provider_response' => $result['body']
            ],
        ]);
    }

    public function bulkRenew(Request $request, ProxyHomePricingService $pricingService, ProxyStaticOrderService $proxyStaticOrderService) {
        $validated = $request->validate([
            'items'      => 'required|string',
            'days'     => 'required|integer|min:1',
            'auto_renew' => 'nullable|integer|in:0,1',
        ]);

        $items = json_decode($validated['items'], true);
        if (!is_array($items) || empty($items)) {
            throw ValidationException::withMessages(['items' => 'Payload items không hợp lệ.']);
        }

        $days    = (int)$validated['days'];
        $autoRenew = (int)($validated['auto_renew'] ?? false);

        $localIds = collect($items)->pluck('id')->filter()->unique()->values()->all();

        $proxies  = ProxyHomeProxy::whereIn('id', $localIds)->get(['id','provider','code']);

        $order_code = $proxies[0]->code;
        $order = ProxyHomeOrder::where('code', $order_code)->first();
        $quote = $pricingService->totalForProxies($proxies, $days);

        $total = (int)$quote['total'];

        switch ($order->type) {
            case 'proxy-datacenter-cmc': //proxy datacenter điền form gia hạn với thời hạn là số tháng không cần convert ngày sang tháng mà dùng luôn bên gốc tự xử lý
            case 'proxy-datacenter-us':
            case 'static': //proxy tĩnh đang theo ngày nên form gia hạn nhập số lượng thời hạn thì dùng luôn
                $cat_type_id = 1;
                break;

            case 'rotate': //proxy xoay gia hạn đang truyền số ngày lên, nên cần conver về nếu là tuần và tháng
            case 'key-rotate': //key xoay gia hạn đang truyền số ngày lên, nên cần conver về nếu là tuần và tháng
                $cat_type_id = 2;

                $total = $order->amount / $order->quantity;
                $typeDay = json_decode($order->partner_response)->products[0]->product->category->unit;

                $days = match ($typeDay) {
                    'ngày' => $order->days,
                    'tuần' => round($order->days / 7),
                    'tháng' => round($order->days / 30),
                    default => throw new \RuntimeException('Không gia hạn được!'),
                };
                break;

            case 'combo': //combo proxy mua gồm tĩnh và datacenter nên rơi vào lại các case trên
            default:
                throw new \RuntimeException('Không gia hạn được!');
        }

        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        if ($user->available_balance < $total) {
            throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
        }
        $userProxyIds = collect($items)->pluck('partner_item_id')->filter()->unique()->values()->all();
        if (empty($userProxyIds)) {
            throw ValidationException::withMessages(['items' => 'Thiếu partner_item_id để gia hạn.']);
        }

        $resp = $proxyStaticOrderService->bulkRenew($userProxyIds, $days, $autoRenew, $cat_type_id);
        if (!$resp['ok']) {
            Log::error('[RENEW_PROXY][API_FAILED] Gọi API gia hạn phía đối tác thất bại (proxy hết hạn hoăc không tìm thấy)', [
                'user_id'         => $user->id,
                'local_proxy_ids' => $localIds,
                'response_body'   => $resp['body']
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Gia hạn thất bại. Bạn chỉ có thể gia hạn thêm khi proxy còn hạn',
                'detail'  => $resp['body'],
            ], 422);
        }

        try {
            $oldProxiesMeta = DB::table('proxy_home_proxies')
                ->whereIn('id', $localIds)
                ->select('id', 'ip', 'port', 'partner_item_id')
                ->get();

            $oldIpList        = $oldProxiesMeta->pluck('ip')->implode(', ');
            $oldPartnerIdsStr = $oldProxiesMeta->pluck('partner_item_id')->implode(', ');

            DB::transaction(function () use ($user, $total, $days, $localIds, $oldIpList, $oldPartnerIdsStr, $order) {
                // 1. Trừ tiền tài khoản người dùng
                DB::table('users')->where('id', $user->id)->update([
                    'available_balance' => $user->available_balance - $total,
                    'balance'           => $user->balance - $total,
                    'updated_at'        => now(),
                ]);

                // 2. Tạo lịch sử giao dịch chi tiết phục vụ đối soát
                Transaction::create([
                    'user_id'        => $user->id,
                    'code'           => 'PRX' . uniqid_real(6),
                    'amount'         => $total * -1,
                    'status'         => TransactionStatus::Paid,
                    'reference_id' => $order->id,
                    'reference_type' => ProxyHomeOrder::class,
                    'note'           => sprintf(
                        'Gia hạn %d proxy (%d ngày). Danh sách IP: [%s]. ID proxy cũ: [%s]',
                        count($localIds),
                        $days,
                        $oldIpList,
                        $oldPartnerIdsStr
                    )
                ]);
            });

            Log::info('[RENEW_PROXY][FINANCE_OK] Đã trừ tiền thành công. Bắt đầu đồng bộ dựa trên Đơn hàng đối tác...', [
                'user_id'   => $user->id,
                'local_ids' => $localIds
            ]);

            // 3. Gọi Service Re-Sync dữ liệu bằng cách quét các Order ID liên quan
            $syncCount = app(ProxyHomeSyncService::class)->syncRenewedProxiesByOrders(
                $localIds,
                $autoRenew
            );

            return response()->json([
                'status'     => 'ok',
                'message' => sprintf('Gia hạn và đồng bộ thành công %d proxy mới thành công.', $syncCount),
                'charged_vnd'=> $total,
                'provider'   => $resp['body'],
            ]);
        } catch (\Exception $e) {
            Log::critical('[RENEW_PROXY][SYNC_FATAL_ERROR] TIỀN ĐÃ TRỪ nhưng lỗi đồng bộ dữ liệu sau gia hạn!', [
                'user_id'       => $user->id,
                'charged_total' => $total,
                'local_ids'     => $localIds,
                'error'         => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gia hạn và trừ tiền thành công nhưng gặp lỗi đồng bộ hệ thống cục bộ: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function bulkProtocal(Request $request)
    {
        $validated = $request->validate([
            'items'           => 'required|string',
            'protocal'        => 'nullable|string|max:20',
        ], [
            'items.required'    => 'Chưa chọn proxy nào.',
        ]);

        $items = json_decode($validated['items'], true);

        if (!is_array($items) || empty($items)) {
            throw ValidationException::withMessages(['items' => 'Payload items không hợp lệ.']);
        }

        $userProxyIds = collect($items)
            ->map(fn($it) => Arr::get($it, 'partner_item_id'))
            ->filter(fn($v) => filled($v))
            ->unique()
            ->values()
            ->all();

        if (empty($userProxyIds)) {
            throw ValidationException::withMessages(['items' => 'Không tìm thấy ip_entity_id hợp lệ.']);
        }

        $protocol       = $validated['protocal'] ?? null;
        $result = $this->proxyStaticOrderService->bulkUpdateProtocal(
            userProxyIds: $userProxyIds,
            protocol: $protocol,
        );

        if (!$result['ok']) {
            Log::warning('Bulk change-auth failed', [
                'status' => $result['status'],
                'body'   => $result['body'],
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gọi API thất bại.',
                'detail'  => $result['body'],
            ], 422);
        }

        $localIds = collect($items)
            ->map(fn($it) => Arr::get($it, 'id'))
            ->filter(fn($v) => !empty($v))
            ->unique()
            ->values()
            ->all();

        if (!empty($localIds)) {
            DB::transaction(function () use ($localIds, $protocol) {
                ProxyHomeProxy::whereIn('id', $localIds)->update([
                    'protocol' => $protocol,
                    'updated_at'    => now(),
                ]);
            });
        }

        return response()->json([
            'status'  => 'ok',
            'message' => 'Cập nhật thông tin proxy thành công.',
            'data'    => [
                'requested' => [
                    'count_userProxyIds' => count($userProxyIds),
                    'protocol' => $protocol
                ],
                'provider_response' => $result['body']
            ],
        ]);
    }

    public function exportProxyStatic(Request $request)
    {
        $user = $request->user();
        $query = ProxyHomeProxy::select("*")
            ->where('category_type_slug', 'static')
            ->where('user_id', $user->id);

        $rows = $query->orderBy('id')->cursor()->map(function (ProxyHomeProxy $p) {
            return [
                'ID'         => $p->id,
                'Provider'   => $p->provider,
                'IP'         => $p->ip ?? '',
                'Username'   => $p->username ?? '',
                'Password'   => $p->password ?? '',
                'Port'   => $p->port ?? '',
                'Protocol'   => $p->protocol ?? '',
                'Expired At' => optional($p->expired_at)
                    ? Carbon::parse($p->expired_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
                'Created At' => optional($p->created_at)
                    ? $p->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
            ];
        })->toArray();

        $filename = "danh-sach-proxy.xlsx";
        return (new FastExcel($rows))->download($filename);
    }

    public function listProxyOrders(Request $request)
    {
        return view("proxyhome.listProxyOrders");
    }

    public function searchProxyOrders(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['q'] = $request->input('q', '');

        $sql = ProxyHomeOrder::with('user:id,phone')->select('*');

        $sql->where('user_id', '=', $user->id);


        $sort = $filter['sort'] ?? 'updated_at';
        $order = $filter['order'] ?? 'desc';
        if ($sort) {
            $sql->orderBy($sort, $order);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->get()
            ->toArray();

        return response()->json([
            'total' => $total,
            'rows' => $data,
        ]);
    }

    public function transactionHistory(Request $request)
    {
        return view("proxyhome.transactionHistory");
    }

    public function searchTransactionHistory(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['q'] = $request->input('q', '');

        $sql = Transaction::with('user:id,phone')->select('*');

        $sql->where('user_id', '=', $user->id);


        $sort = $filter['sort'] ?? 'updated_at';
        $order = $filter['order'] ?? 'desc';
        if ($sort) {
            $sql->orderBy($sort, $order);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->get()
            ->toArray();

        return response()->json([
            'total' => $total,
            'rows' => $data,
        ]);
    }

    public function proxyRotateOrder(StoreProxyRotateOrderRequest $request)
    {
        $user = $request->user();

        $dto = new ProxyRotateOrderData($request->validated());

        if($this->proxyRotateOrderService->notEnoungMoney($user->id, $dto))
        {
            return response()->json([
                'status' => false,
                'message'     => trans('Ví của bạn không đủ tiền!'),
            ]);
        }

        try {
            $result = $this->proxyRotateOrderService->create($user->id, $dto);

            return response()->json([
                'status' => true,
                'message'     => 'Tạo đơn hàng thành công',
                'amount'      => $result['amount'],
                'local_order' => $result['local_order'],
                'partner'     => $result['partner_raw'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function listRotateProxies(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable|in:id,code',
            'q'         => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q        = trim($validated['q'] ?? '');
        return view("proxyhome.listProxyRotate", [
            'search_by' => $searchBy,
            'q'         => $q
        ]);
    }

    public function searchRotateProxies(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['type_proxy'] = $request->input('type_proxy', 'rotate');
        $filter['q'] = $request->input('q', '');

        $sql = ProxyHomeProxy::with('order');
        $sql->whereHas('order', function ($query) use ($filter) {
            $query->where('type', $filter['type_proxy']);
        });
        $sql->where('category_type_slug', 'rotate');
        $sql->where('user_id', '=', $user->id);
        $sql->where('status_id', '!=', -1);
        $sql->where('expired_at', '>=', now());

        if(!empty($filter['q'])) {
            switch ($filter['search_by']) {
                case 'id':
                    // $id = (int)preg_replace('/\D+/', '', $filter['q']);
                    // if ($id > 0) $sql->where(fn($q) => $q->where('id', $id)->orWhere('ip', $filter['q']));
                    $sql->where(fn($q) => $q->where('id', $filter['q'])->orWhere('ip', $filter['q']));
                    break;
                case 'code':
                    $sql->where('code', $filter['q']);
                    break;
            }
        }

        $sort = $filter['sort'] ?? 'updated_at';
        $order = $filter['order'] ?? 'desc';
        if ($sort) {
            $sql->orderBy($sort, $order);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->with('order')
            ->take($filter['limit'])
            ->get()
            ->toArray();

        return response()->json([
            'total' => $total,
            'rows' => $data,
        ]);
    }

    public function exportProxyRotate(Request $request)
    {
        $user = $request->user();
        $type = $request->input('type') ?? 'rotate';

        $query = ProxyHomeProxy::with('order')
            ->whereHas('order', function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->where('category_type_slug', 'rotate')
            ->where('user_id', $user->id);

        $rows = $query->orderBy('id')->cursor()->map(function (ProxyHomeProxy $p) use ($type) {
            $data = [
                'ID'         => $p->id,
                'Provider'   => $p->provider,
                'IP'         => $p->ip ?? '',
                'Port'       => $p->port ?? '',
                'Username'   => $p->username ?? '',
                'Password'   => $p->password ?? '',
                'Protocol'   => $p->protocol ?? '',
            ];

            if ($type === 'key-rotate') {
                $token = '';
                try {
                    $result = $this->homeKeyRotateOrderService->generateToken($p->partner_item_id);
                    $token = $result['token'] ?? ($result['data']['token'] ?? '');
                } catch (\Throwable $e) {
                    $token = 'Lỗi lấy token';
                }

                $data = [
                    'ID'         => $p->id,
                    'Provider'   => $p->provider,
                    'Key'        => $token,
                    'Protocol'   => 'HTTP/SOCKS5',
                ];
            }

            $data['Expired At'] = optional($p->expired_at)
                ? Carbon::parse($p->expired_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                : '';
            $data['Created At'] = optional($p->created_at)
                ? $p->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                : '';

            return $data;
        })->toArray();

        $filename = $type !== 'key-rotate' ? "danh-sach-proxy-xoay.xlsx" : "danh-sach-key-xoay.xlsx";
        return (new FastExcel($rows))->download($filename);
    }

    public function bulkChangePasswordRotate(Request $request)
    {
        $validated = $request->validate([
            'password'        => 'nullable|string|min:9|max:100',
            'id' => 'required',
            // 'protocol' => 'required|string',
            'is_rotate' => 'nullable|boolean',
            'rotate_interval' => 'nullable|integer|min:0',
        ], [
            'account.required'  => 'Vui lòng nhập tài khoản.',
        ]);

        $proxyHome = ProxyHomeProxy::where('id', $request->id)->first();
        $proxyId = $proxyHome->partner_item_id;
        $userProxyIds = [ $proxyId ];

        if (empty($userProxyIds)) {
            throw ValidationException::withMessages(['items' => 'Không tìm thấy ip_entity_id hợp lệ.']);
        }

        $username       = $proxyHome->username;
        $password       = $validated['password'] ?? null;
        // $protocol       = $validated['protocol'] ?? null;
        $rotateInterval = isset($validated['rotate_interval']) && $validated['rotate_interval'] > 0 ? (int) $validated['rotate_interval'] : 0;
        $result = $this->proxyStaticOrderService->bulkUpdateAuth(
            userProxyIds: $userProxyIds,
            username: $username,
            password: $password,
            // protocol: $protocol,
            rotateInterval: $rotateInterval,
            is_rotate: $validated['is_rotate'] ?? false,
        );

        if (!$result['ok']) {
            Log::warning('Bulk change-auth failed', [
                'status' => $result['status'],
                'body'   => $result['body'],
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gọi API thất bại.',
                'detail'  => $result['body'],
            ], 422);
        }

        ProxyHomeProxy::where('id', $request->id)->update([
            'password' => $password,
            // 'protocol' => $protocol,
            'rotate_interval' => $rotateInterval,
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Cập nhật thông tin proxy thành công.',
            'data'    => [
                'requested' => [
                    'count_userProxyIds' => count($userProxyIds),
                    // 'protocol'           => $protocol,
                    'rotateInterval'     => $rotateInterval,
                ],
                'provider_response' => $result['body']
            ],
        ]);
    }

    public function actionRotate(Request $request) {
        $proxyHome = ProxyHomeProxy::where('id', $request->input('id'))->first();
        $partnerId = $proxyHome->partner_item_id;
        $res = $this->proxyRotateOrderService->bulkRoate($partnerId);
        return $res;
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function sync(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $user = $request->user();

        $proxy = ProxyHomeProxy::where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();

        $this->syncService->syncProxy($proxy);
    }

    public function freeRotate(Request $request)
    {
        $this->actionRotate($request);

        return response()->json([
            'msg' => trans('Rotate successfully!')
        ]);
    }
}
