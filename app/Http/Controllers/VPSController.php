<?php

namespace App\Http\Controllers;

use App\Core\Enums\ProxyTypeAction;
use App\Core\Enums\StatusProxy;
use App\Core\Enums\StatusVPS;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Enums\VpsTypeAction;
use App\Core\Http\Requests\Request;
use App\Http\Requests\VPSOrderRequest;
use App\Http\Requests\VPSProxyOrderRequest;
use App\Models\ProxyResidentialProxy;
use App\Models\ProxySellvps247;
use App\Models\ProxySellvps247Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vps;
use App\Models\VpsOrder;
use App\Services\VPS\VPSService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use function Aws\default_user_agent;

class VPSController extends Controller
{
    protected array $regions;
    protected array $purposes;
    protected int $feePercent;
    protected array $durations;
    protected array $proxyType;

    public function __construct(
        protected VPSService           $VPSService,
        protected VpsOrder             $vpsOrderModel,
        protected Vps                  $vpsModel,

        protected ProxySellvps247Order $proxySellvps247OrderModel,
        protected ProxySellvps247      $proxySellvps247Model,

        public Transaction             $transactionModel,
        public User                    $userModel,
    )
    {
        $this->regions = $this->VPSService->listRegion();
        $this->purposes = config('vps.purposes');
        $this->feePercent = config('vps.fee_percent');
        $this->durations = config('vps.durations');
        $this->proxyType = config('vps.proxy_type');
        // đang dùng đổ cho sidebar nên share view dùng chung cho tất cả
        view()->share('vpsRegions', $this->regions);
        view()->share('purposes', $this->purposes);
        view()->share('durations', $this->durations);
        view()->share('proxyType', $this->proxyType);
    }

    //===============================Proxy=================================
    public function exportProxy(Request $request)
    {
        $user = $request->user();
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        $query = ProxySellvps247::with('order')->select('*')->where('user_id', $user->id);
        $rows = $query->orderBy('id')->cursor()->map(function (ProxySellvps247 $p) use ($regions) {
            $ip_port = "{$p->ip}:{$p->remote_port}";
            $ip_port_username_pass = "{$ip_port}:{$p->username}:{$p->password}";
            $username_pass_ip_port = "{$p->username}:{$p->password}@{$ip_port}";

            if($p->country === 'VNR'){
                $p->country = 'VN';
            }
            $country_name = $regions[$p->country]['name'] ?? 'N/A';
            $country_code = $regions[$p->country]['symbol'] ?? 'N/A';
            $stringCountry = $country_name . "( Mã: $country_code )";

            if($p->state){
                $stringState = 'Bang: '. $p->state;
            }elseif($p->isp){
                $stringState = 'Nhà mạng:'. $p->isp;
            }else{
                $stringState =  '-';
            }

            return [
                'ID' => $p->id,
                'Tên' => $p->name,
                'Trạng thái' => $p->status,
                'Mã đơn hàng' => $p->order_id,
                'Proxy ID (Partner)' => $p->proxy_id ,
                'Tên server' => $p->server_name ,
                'Loại' => $p->proxy_type_name ,
                'PROXY IP:PORT'               => trim($ip_port),
                'PROXY IP:PORT:USERNAME:PASS' => trim($ip_port_username_pass),
                'PROXY USER:PASS@IP:PORT'     => trim($username_pass_ip_port),
                'Ram' =>  $p->ram . " GB",
                'CPU' =>  $p->cpu. " Cores",
                'SSD' =>  $p->ssd . " GB",
                'Quốc gia'   => $stringCountry,
                'Bang/Nhà mạng'   => $stringState,
                'Số lần thay đổi IP' => $p->change_ip_time,
                'Số tiền' => number_format($p->price).'đ',
                'Ngày mua' => optional($p->partner_created_at)
                    ? $p->partner_created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
                'Ngày hết hạn' => optional($p->partner_expired_at)
                    ? Carbon::parse($p->partner_expired_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
            ];
        })->toArray();

        $filename = "danh-sach-proxy.xlsx";
        return (new FastExcel($rows))->download($filename);
    }
    public function reSettingProxy(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        try {
            $dataRequest['random_username'] = $request['status_random_username'] ?? "";
            $dataRequest['random_password'] = $request['status_random_password'] ?? "";
            $dataRequest['random_remote_port'] = $request['status_random_port'] ?? "";
            $dataRequest['type'] = $request['proxyType'];

            $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
            if ($dataRequest['random_username']) {
                $dataRequest['random_username'] = "";
                $dataRequest['username'] = $this->generateRandomUsername();
            } else {
                if (empty($request['username'])) {
                    $dataRequest['username'] = $getProxy->username;
                } else {
                    $dataRequest['username'] = $request['username'];
                }
            }
            if ($dataRequest['random_password']) {
                $dataRequest['random_password'] = "";
                $dataRequest['password'] = $this->generateRandomPassword();
            } else {
                if (empty($request['password'])) {
                    $dataRequest['password'] = $getProxy->password;
                } else {
                    $dataRequest['password'] = $request['password'];
                }
            }
            if ($dataRequest['random_remote_port']) {
                $dataRequest['random_remote_port'] = "";
                $dataRequest['remote_port'] = (string)rand(10000, 65000);
            } else {
                if (empty($request['port'])) {
                    $dataRequest['remote_port'] = $getProxy->remote_port;
                } else {
                    if ($request['port'] < 10000 || $request['port'] > 65000) {
                        throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                    }
                    $dataRequest['remote_port'] = (string)$request['port'];
                }
            }

            $dataRequest['sid'] = $getProxy->proxy_id;

            $this->VPSService->reSetting($dataRequest);

            //Gọi lại api chi tiết vps để lấy các thông tin data chuẩn value đang lưu bên đó
            $res_proxy = $this->VPSService->vpsInfo($getProxy->proxy_id);
            $getProxy->update([
                'ip' => $res_proxy['ip'],
                'username' => $res_proxy['username'],
                'password' => $dataRequest['password'],
                'remote_port' => $res_proxy['remote_port'],
                'change_ip_time' => $res_proxy['change_ip_time'],
                'networkType' => $dataRequest['type'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng vps', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function renewProxy(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
        $getPriceRenewRes = $this->VPSService->renewCalculate($getProxy->proxy_id, $request->month);
        $getPriceRenew = $getPriceRenewRes['result']['success'][$getProxy->ip];

        $finalPrice = floatval(str_replace([',', ' VND'], '', $getPriceRenew['expense']));//giá cuối sẽ thanh toán

        if ($user->available_balance < $finalPrice) {
            throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
        }

        //Bên vps trả thông tin về không cần update order, chỉ cần update proxy đang gia hạn là được
        $new_expired_day = date('Y-m-d', strtotime($getPriceRenew['new_expired_day'])); //Bên kia chỉ trả ngày tháng năm
        $old_time_expired = date('H:i:s', strtotime($getProxy->partner_expired_at));
        $expired_at = $new_expired_day . ' ' . $old_time_expired;

        $res_make_order = $this->VPSService->renewVPS($getProxy->proxy_id, $request->month);
        $make_order = $res_make_order['result']['success'][$getProxy->ip];

        DB::beginTransaction();
        try {
            // Cập nhật ví
            $this->userModel->where('id', $user->id)->update([
                'available_balance' => $user->available_balance - $finalPrice,
                'balance' => $user->balance - $finalPrice,
                'updated_at' => now(),
            ]);

            $getProxy->update([
                'price' => $finalPrice,
                'partner_expired_at' => $expired_at,
                'amount_before' => floatval(str_replace([',', ' VND'], '', $make_order['old_balance'])),
                'amount_last' => floatval(str_replace([',', ' VND'], '', $make_order['new_balance'])),
                'partner_server_info_response' => json_encode($res_make_order),
            ]);

            $this->transactionModel->create([
                'user_id' => $user->id,
                'code' => 'PROXY' . uniqid_real(6),
                'amount' => $finalPrice * -1,
                'status' => TransactionStatus::Paid,
                'reference_id' => $getProxy->id,
                'reference_type' => ProxySellvps247::class,
                'note' => 'Thanh toán gia hạn Proxy (ID Proxy: #' . $getProxy->id . ')'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công',
            ]);


        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng gia hạn proxy', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function ajaxRenewCalculateProxy(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
        $dataRes = $this->VPSService->renewCalculate($getProxy->proxy_id, $request->month);
        $data = $dataRes['result']['success'][$getProxy->ip];
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function changeIPProxy(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        try {
            $dataRequest['random_password'] = (bool)$request['status_random_password'];
            $dataRequest['random_remote_port'] = (bool)$request['status_random_port'];
            $dataRequest['range_ip'] = $request['range_ip'];
            $dataRequest['proxy_type'] = $request['proxyType'];

            $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
            //Gán gái trị random false và generate giá trị gửi đi
            if ($dataRequest['random_password']) {
                $dataRequest['random_password'] = false;
                $dataRequest['password'] = $this->generateRandomPassword();
            } else {
                if (empty($request['password'])) {
                    $dataRequest['password'] = $getProxy->password;
                } else {
                    $dataRequest['password'] = $request['password'];
                }
            }

            if ($dataRequest['random_remote_port']) {
                $dataRequest['random_remote_port'] = false;
                $dataRequest['remote_port'] = rand(10000, 65000);
            } else {
                if (empty($request['port'])) {
                    $dataRequest['remote_port'] = $getProxy->remote_port;
                } else {
                    if ($request['port'] < 10000 || $request['port'] > 65000) {
                        throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                    }
                    $dataRequest['remote_port'] = (int)$request['port'];
                }
            }
            $dataRequest['ip'] = $getProxy->ip;
            $this->VPSService->changeIP($dataRequest);

            //Gọi lại api chi tiết vps để lấy các thông tin data chuẩn value đang lưu bên đó
            $res_proxy = $this->VPSService->vpsInfo($getProxy->proxy_id);
            $getProxy->update([
                'ip' => $res_proxy['ip'],
                'password' => $dataRequest['password'],
                'remote_port' => $res_proxy['remote_port'],
                'change_ip_time' => $res_proxy['change_ip_time'],
                'networkType' => $dataRequest['proxy_type'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi cập nhật Ip proxy', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);
            throw new \RuntimeException("Có lỗi xãy ra, vui lòng thử lại sau!");
        }
    }

    public function ajaxGetChangeIPProxy(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
        $data = $this->VPSService->getChangeIP($getProxy->ip);
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function confirmActionProxy(Request $request)
    {
        if (!array_key_exists($request->type, ProxyTypeAction::asSelectArray())) {
            throw new \RuntimeException('Thao tác không đúng!');
        }
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);

        switch ($request->type) {
            case ProxyTypeAction::reboot->value:
                $this->VPSService->reboot($getProxy->proxy_id);
                $message = 'Khởi động lại thành công, vui lòng chờ trong ít phút';
                $getProxy->status = StatusProxy::Active;
                $getProxy->save();
                break;
            case ProxyTypeAction::pause->value:
                $this->VPSService->pause($getProxy->proxy_id);
                $message = 'Tạm dừng thành công, vui lòng chờ trong ít phút';
                $getProxy->status = StatusProxy::Pause;
                $getProxy->save();
                break;
            case ProxyTypeAction::auto_fix->value:
                $this->VPSService->autoFixError($getProxy->proxy_id);
                $message = 'Sửa lỗi tự động thành công, vui lòng chờ trong ít phút';
                break;
            default:
        }

        return response()->json([
            'success' => true,
            'message' => $message ?? '',
        ]);
    }

    public function ajaxAutoExtendProxy(Request $request)
    {
        $user = $request->user();
        $getProxy = $this->proxySellvps247Model->where('user_id', $user->id)->findOrFail($request->id);
//        $change = $this->VPSService->statusAutoRenew($getProxy->proxy_id);
        $getProxy->auto_renew = !$getProxy->auto_renew;
        $getProxy->save();
        return response()->json([
            'success' => true,
            'status' => $getProxy->auto_renew,
            'message' => $getProxy->auto_renew ? 'Bậc tự động gia hạn thành công' : 'Tắt tự động gia hạn thành công'
        ]);
    }

    public function searchProxyManagement(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['q'] = $request->input('q', '');
        $sql = $this->proxySellvps247Model->with('order')->select('*');
        $sql->where('user_id', '=', $user->id);
        if (!empty($filter['q'])) {
            switch ($filter['search_by']) {
                case 'id':
                    $sql->where(function ($q) use ($filter) {
                        $q->where('proxy_id', 'LIKE', "%{$filter['q']}%")
                            ->orWhere('ip', 'LIKE', "%{$filter['q']}%");
                    });
                    break;

                case 'code':
                    $sql->where('order_id', 'LIKE', "%{$filter['q']}%");
                    break;
            }
        }
        $by_time = $request->input('by_time');
        if (!empty($by_time)) {
            switch ($by_time) {
                case 'using':
                    $sql->where(function ($q) use ($by_time) {
                        $q->where('partner_expired_at', '>', date('Y-m-d H:i:s', time()));
                    });
                    break;
                case 'due':
                    $sql->where(function ($q) {
                        $now = date('Y-m-d H:i:s');
                        $threeDaysLater = date('Y-m-d H:i:s', strtotime('+3 days'));

                        $q->where('partner_expired_at', '>', $now)
                            ->where('partner_expired_at', '<=', $threeDaysLater);
                    });
                    break;
                case 'expired':
                    $sql->where(function ($q) use ($by_time) {
                        $q->where('partner_expired_at', '<=', date('Y-m-d H:i:s', time())); //Lấy luôn cả trường hợp =
                    });
                    break;
                default:
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

    public function listProxyManagement(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable', //|in:id,vps_id,vps_order_id,server_name
            'q' => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q = trim($validated['q'] ?? '');

        switch ($request->by_time) {
            case 'all':
                $nameList = 'Tất cả dịch vụ';
                break;
            case 'using':
                $nameList = 'Đang sử dụng';
                break;
            case 'due':
                $nameList = 'Còn hạn (dưới 3 ngày)';
                break;
            case 'expired':
                $nameList = 'Đã hết hạn';
                break;
            default:
                $nameList = 'Tất cả dịch vụ';
        }
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        return view("vps.proxy.list-used", [
            'search_by' => $searchBy,
            'q' => $q,
            'by_time' => $nameList,
            'regions' => $regions
        ]);
    }

    public function searchProxyOrders(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');

        $sql = $this->proxySellvps247OrderModel->with('user:id')->select('*');

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

    public function listProxyOrders()
    {
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        return view("vps.proxy.listProxyOrders")->with('regions', $regions);
    }

    public function searchTransactionProxyHistory(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');

        $sql = $this->transactionModel->with('user:id,phone')->select('*');

        $sql->where('user_id', '=', $user->id)
            ->whereIn('reference_type', [ReferenceType::ProxySellvps247, ReferenceType::ProxySellvps247Order]);

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

    public function transactionProxyHistory()
    {
        return view("vps.proxy.transactionHistory");
    }

    public function makeOrderProxy(VPSProxyOrderRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $data = $request->validated();
        try {
            // 1. Lấy giá
            $payload = ['coupon' => $data['coupon'], 'duration' => $data['duration'], 'is_proxy' => $data['is_proxy'], 'nation' => $data['nation'], 'plan_id' => $data['plan_id'], 'quantity' => $data['quantity']];
            $price_res = $this->VPSService->proxyCalculate($payload);
            $finalPrice = (double)preg_replace('/[^0-9]/', '', $price_res['must_pay']);
            if ($data['random_username']) {
                $data['random_username'] = false;
                $data['username'] = $this->generateRandomUsername();
            }
            if ($data['random_password']) {
                $data['random_password'] = false;
                $data['password'] = $this->generateRandomPassword();
            }
            if ($data['random_remote_port']) {
                $data['random_remote_port'] = false;
                $data['remote_port'] = rand(10000, 65000);
            } else {
                if ($data['remote_port'] < 10000 || $data['remote_port'] > 65000) {
                    throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                }
                $data['remote_port'] = (int)$data['remote_port'];
            }

            if ($user->available_balance < $finalPrice) {
                throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
            }

            //Gọi partner để tạo order
            $res_make_order = $this->VPSService->makeOrder($data);
            DB::beginTransaction();
            try {
                // Cập nhật ví
                $this->userModel->where('id', $user->id)->update([
                    'available_balance' => $user->available_balance - $finalPrice,
                    'balance' => $user->balance - $finalPrice,
                    'updated_at' => now(),
                ]);

                //Tạo đơn hàng local
                $orderProxyCreated = $this->proxySellvps247OrderModel->create([
                    'user_id' => $user->id,
                    'duration' => $data['duration'],
                    'auto_renew' => $data['auto_renew'],
                    'quantity' => $data['quantity'],
                    'coupon' => $data['coupon'],
                    'range_ip' => $data['range_ip'],
                    'nation' => $data['nation'],
                    'state' => $data['state'],
                    'isp' => $data['isp'],
                    'username' => $data['username'],
                    'password' => $data['password'],
                    'remote_port' => $data['remote_port'],
                    'price' => $finalPrice,
                    'request' => $data,
                    'partner_price_response' => $price_res,
                    'partner_order_response' => $res_make_order['servers'],
                ]);

                $dataProxy = [];
                foreach ($res_make_order['servers'] as $proxy) {
                    $res_proxy = $this->VPSService->vpsInfo($proxy['id']);
                    $priceProxy = (float)preg_replace('/[^0-9]/', '', $proxy['price']);
                    $dataProxy[] = [
                        'proxy_id' => $proxy['id'],
                        'user_id' => $user->id,
                        'order_id' => $orderProxyCreated->id,
                        'server_name' => $res_proxy['server_name'],
                        'ip' => $proxy['ip'],
                        'username' => $proxy['username'],
                        'password' => $proxy['password'],
                        'remote_port' => $proxy['remote_port'],
                        'name' => $proxy['name'],
                        'amount_before' => (float)preg_replace('/[^0-9]/', '', $proxy['amount_before']),
                        'amount_last' => (float)preg_replace('/[^0-9]/', '', $proxy['amount_last']),
                        'template' => $res_proxy['template'],
                        'ram' => $res_proxy['ram'],
                        'cpu' => $res_proxy['cpu'],
                        'ssd' => $res_proxy['ssd'],
                        'country' => $res_proxy['country'],
                        'region' => $res_proxy['region'],
                        'PlanName' => $res_proxy['PlanName'],
                        'change_ip_time' => $res_proxy['change_ip_time'],
                        'note' => $res_proxy['note'],
                        'networkType' => $data['proxy_type'],
                        'partner_created_at' => Carbon::parse($res_proxy['created_at'])->format('Y-m-d H:i:s'),
                        'partner_expired_at' => Carbon::parse($res_proxy['expired_at'])->format('Y-m-d H:i:s'),
                        'auto_renew' => $data['auto_renew'],
                        'price' => $priceProxy,
                        'state' => $data['state'],
                        'isp' => $data['isp'],
                        'partner_server_info_response' => json_encode($res_proxy),
                    ];
                }
                // Lưu proxy con
                $this->proxySellvps247Model->insert($dataProxy);

                $this->transactionModel->create([
                    'user_id' => $user->id,
                    'code' => 'PROXY' . uniqid_real(6),
                    'amount' => $finalPrice * -1,
                    'status' => TransactionStatus::Paid,
                    'reference_id' => $orderProxyCreated->id,
                    'reference_type' => ProxySellvps247Order::class,
                    'note' => 'Thanh toán đơn hàng Proxy (ID đơn hàng: #' . $orderProxyCreated->id . ')'
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                ]);


            } catch (\Throwable $e) {
                DB::rollBack();

                // Ghi log chi tiết lỗi
                Log::error('Lỗi khi lưu đơn hàng proxy sell247', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,

                ]);

                throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
            }

        } catch (\Throwable $e) {
            Log::error('Lỗi proxy order buy tổng thể', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function ajaxProxyCalculate(Request $request)
    {

        $coupon = $request->coupon ?? "";
        $duration = (int)$request->duration;
        $is_proxy = (bool)$request->is_proxy;
        $nation = $request->nation;
        $plan_id = (int)$request->plan_id;
        $quantity = (int)$request->quantity;
        $payload = ['coupon' => $coupon, 'duration' => $duration, 'is_proxy' => $is_proxy, 'nation' => $nation, 'plan_id' => $plan_id, 'quantity' => $quantity];
        $support = $this->VPSService->proxyCalculate($payload);
        return response()->json([
            'success' => true,
            'data' => $support
        ]);
    }

    public function ajaxProxySupport(Request $request)
    {
        $support = $this->VPSService->proxySupport($request->nation ?? 'VNR', $request->state, $request->isp);
        return response()->json([
            'success' => true,
            'data' => $support
        ]);
    }

    public function getProxyOrderBuy(Request $request)
    {
        $support = $this->VPSService->proxySupport($request->nation ?? 'VNR');
        return view("vps.proxy.buying-order", [
            'feePercent' => $this->feePercent,
            'support' => $support,
        ]);
    }

    //===============================VPS===================================
    public function exportVPS(Request $request)
    {
        $user = $request->user();
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        $query = Vps::with('order')->select('*')->where('user_id', $user->id);
        $rows = $query->orderBy('id')->cursor()->map(function (Vps $p) use ($regions) {
            $ip_port = "{$p->ip}:{$p->remote_port}";
            $ip_port_username_pass = "{$ip_port}:{$p->username}:{$p->password}";
            $username_pass_ip_port = "{$p->username}:{$p->password}@{$ip_port}";

            if($p->country !== 'GPU'){
                $country_name = $regions[$p->country]['name'] ?? 'N/A';
                $country_code = $regions[$p->country]['symbol'] ?? 'N/A';
                $stringCountry = $country_name . "( Mã: $country_code )";
            }else{
                $stringCountry = 'GPU';
            }

           if($p->state){
               if($p->state === "GPU") $stringState = $p->state;
               else $stringState = 'Bang: '. $p->state;
           }elseif($p->provider){
               $stringState = 'Nhà mạng:'. $p->provider;
           }else{
               $stringState =  '-';
           }

            return [
                'ID' => $p->id,
                'Tên' => $p->name,
                'Trạng thái' => $p->status,
                'Mã đơn hàng' => $p->vps_order_id,
                'VPS ID (Partner)' => $p->vps_id ,
                'Tên server' => $p->server_name ,
                'Hệ điều hành' => $p->os_name ,
                'PROXY IP:PORT'               => trim($ip_port),
                'PROXY IP:PORT:USERNAME:PASS' => trim($ip_port_username_pass),
                'PROXY USER:PASS@IP:PORT'     => trim($username_pass_ip_port),
                'Tên gói' =>  $p->PlanName,
                'Ram' =>  $p->ram . " GB",
                'CPU' =>  $p->cpu. " Cores",
                'SSD' =>  $p->ssd . " GB",
                'Cài đặt chrome'   => $p->install_chrome?'Có':'Không',
                'Cài đặt firefox'   => $p->install_firefox?'Có':'Không',
                'Quốc gia'   => $stringCountry,
                'Bang/Nhà mạng/GPU'   => $stringState,
                'Số lần thay đổi IP' => $p->change_ip_time,
                'Số tiền' => number_format($p->price).'đ',
                'Ngày mua' => optional($p->partner_created_at)
                ? $p->partner_created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                : '',
                'Ngày hết hạn' => optional($p->partner_expired_at)
                ? Carbon::parse($p->partner_expired_at)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                : '',
            ];
        })->toArray();

        $filename = "danh-sach-vps.xlsx";
        return (new FastExcel($rows))->download($filename);
    }

    public function reSettingVPS(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        try {
            $dataRequest['install_chrome'] = $request['status_chrome'] ?? "";
            $dataRequest['install_firefox'] = $request['status_firefox'] ?? "";
            $dataRequest['random_password'] = $request['status_random_password'] ?? "";
            $dataRequest['random_remote_port'] = $request['status_random_port'] ?? "";

            $dataRequest['os'] = (int)$request['os'];
            $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
            if ($dataRequest['random_password']) {
                $dataRequest['random_password'] = "";
                $dataRequest['password'] = $this->generateRandomPassword();
            } else {
                if (empty($request['password'])) {
                    $dataRequest['password'] = $getVps->password;
                } else {
                    $dataRequest['password'] = $request['password'];
                }
            }
            if ($dataRequest['random_remote_port']) {
                $dataRequest['random_remote_port'] = "";
                $dataRequest['remote_port'] = (string)rand(10000, 65000);
            } else {
                if (empty($request['port'])) {
                    $dataRequest['remote_port'] = $getVps->remote_port;
                } else {
                    if ($request['port'] < 10000 || $request['port'] > 65000) {
                        throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                    }
                    $dataRequest['remote_port'] = (string)$request['port'];
                }
            }

            $dataRequest['sid'] = $getVps->vps_id;
            $this->VPSService->reSetting($dataRequest);

            //Gọi lại api chi tiết vps để lấy các thông tin data chuẩn value đang lưu bên đó
            $res_vps = $this->VPSService->vpsInfo($getVps->vps_id);
            $getVps->update([
                'server_name' => $res_vps['server_name'],
                'ip' => $res_vps['ip'],
                'username' => $res_vps['username'],
                'password' => $dataRequest['password'],
                'template' => $res_vps['template'],
                'os_id' => $request['os'],
                'os_name' => $request['os_name'],
                'ram' => $res_vps['ram'],
                'cpu' => $res_vps['cpu'],
                'ssd' => $res_vps['ssd'],
                'remote_port' => $res_vps['remote_port'],
                'install_chrome' => (bool)$res_vps['install_chrome'],
                'install_firefox' => (bool)$res_vps['install_firefox'],
                'country' => $res_vps['country'],
                'region' => $res_vps['region'],
                'PlanName' => $res_vps['PlanName'],
                'change_ip_time' => $res_vps['change_ip_time'],
                'note' => $res_vps['note'],
                'partner_server_info_response' => json_encode($res_vps),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng vps', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function ajaxGetSupportOS(Request $request)
    {
        if ($request->country === "GPU") {
            $data = $this->VPSService->supportOS(true);
        } else {
            $data = $this->VPSService->supportOS();
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function renewVPS(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $getPriceRenewRes = $this->VPSService->renewCalculate($getVps->vps_id, $request->month);
        $getPriceRenew = $getPriceRenewRes['result']['success'][$getVps->ip];

        $expense = floatval(str_replace([',', ' VND'], '', $getPriceRenew['expense']));//giá cuối sẽ thanh toán
        $finalPrice = $expense;
        $finalPrice = $finalPrice + ($finalPrice * $this->feePercent / 100);

        if ($user->available_balance < $finalPrice) {
            throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
        }

        //Bên vps trả thông tin về không cần update order, chỉ cần update server/vps đang gia hạn là được
        $new_expired_day = date('Y-m-d', strtotime($getPriceRenew['new_expired_day'])); //Bên kia chỉ trả ngày tháng năm
        $old_time_expired = date('H:i:s', strtotime($getVps->partner_expired_at));
        $expired_at = $new_expired_day . ' ' . $old_time_expired;

        $res_make_order = $this->VPSService->renewVPS($getVps->vps_id, $request->month);
        $make_order = $res_make_order['result']['success'][$getVps->ip];

        DB::beginTransaction();
        try {
            // Cập nhật ví
            $this->userModel->where('id', $user->id)->update([
                'available_balance' => $user->available_balance - $finalPrice,
                'balance' => $user->balance - $finalPrice,
                'updated_at' => now(),
            ]);

            $getVps->update([
                'price' => $finalPrice,
                'partner_expired_at' => $expired_at,
                'amount_before' => floatval(str_replace([',', ' VND'], '', $make_order['old_balance'])),
                'amount_last' => floatval(str_replace([',', ' VND'], '', $make_order['new_balance'])),
                'partner_server_info_response' => json_encode($res_make_order),
            ]);

            $this->transactionModel->create([
                'user_id' => $user->id,
                'code' => 'VPS' . uniqid_real(6),
                'amount' => $finalPrice * -1,
                'status' => TransactionStatus::Paid,
                'reference_id' => $getVps->id,
                'reference_type' => Vps::class,
                'note' => 'Thanh toán gia hạn VPS (ID VPS: #' . $getVps->id . ')'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công',
            ]);


        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng vps', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function ajaxRenewCalculate(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $dataRes = $this->VPSService->renewCalculate($getVps->vps_id, $request->month);
        $data = $dataRes['result']['success'][$getVps->ip];
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function confirmAction(Request $request)
    {
        if (!array_key_exists($request->type, VpsTypeAction::asSelectArray())) {
            throw new \RuntimeException('Thao tác không đúng!');
        }
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);

        switch ($request->type) {
            case VpsTypeAction::reboot->value:
                $res = $this->VPSService->reboot($getVps->vps_id);
                $message = 'Khởi động lại thành công, vui lòng chờ trong ít phút';
                $getVps->status = StatusVPS::Active;
                $getVps->save();
                break;
            case VpsTypeAction::pause->value:
                $res = $this->VPSService->pause($getVps->vps_id);
                $message = 'Tạm dừng thành công, vui lòng chờ trong ít phút';
                $getVps->status = StatusVPS::Pause;
                $getVps->save();
                break;
            case VpsTypeAction::auto_fix->value:
                $res = $this->VPSService->autoFixError($getVps->vps_id);
                $message = 'Sửa lỗi tự động thành công, vui lòng chờ trong ít phút';
                break;
            default:
        }

        return response()->json([
            'success' => true,
            'message' => $message ?? '',
        ]);
    }

    public function changeIP(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        try {
            $dataRequest['install_chrome'] = (bool)$request['status_chrome'];
            $dataRequest['install_firefox'] = (bool)$request['status_firefox'];
            $dataRequest['not_remove_data'] = (bool)$request['status_delete_data'];
            $dataRequest['random_password'] = (bool)$request['status_random_password'];
            $dataRequest['random_remote_port'] = (bool)$request['status_random_port'];
            $dataRequest['os_id'] = (int)$request['os'];
            $dataRequest['os_name'] = $request['os_name'];
            $dataRequest['range_ip'] = $request['range_ip'];
            if ($request['provider']) {
                $dataRequest['isp'] = $request['provider'];
            }
            if ($request['location']) {
                $dataRequest['has_state'] = $request['location'];
            }

            $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
            //Gán gái trị random false và generate giá trị gửi đi
            if ($dataRequest['random_password']) {
                $dataRequest['random_password'] = false;
                $dataRequest['password'] = $this->generateRandomPassword();
            } else {
                if (empty($request['password'])) {
                    $dataRequest['password'] = $getVps->password;
                } else {
                    $dataRequest['password'] = $request['password'];
                }
            }

            if ($dataRequest['random_remote_port']) {
                $dataRequest['random_remote_port'] = false;
                $dataRequest['remote_port'] = rand(10000, 65000);
            } else {
                if (empty($request['port'])) {
                    $dataRequest['remote_port'] = $getVps->remote_port;
                } else {
                    if ($request['port'] < 10000 || $request['port'] > 65000) {
                        throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                    }
                    $dataRequest['remote_port'] = (int)$request['port'];
                }
            }

            $dataRequest['ip'] = $getVps->ip;

            $this->VPSService->changeIP($dataRequest);

            //Gọi lại api chi tiết vps để lấy các thông tin data chuẩn value đang lưu bên đó
            $res_vps = $this->VPSService->vpsInfo($getVps->vps_id);
            $getVps->update([
                'server_name' => $res_vps['server_name'],
                'ip' => $res_vps['ip'],
                'username' => $res_vps['username'],
                'password' => $dataRequest['password'],
                'template' => $res_vps['template'],
                'os_id' => $dataRequest['os_id'],
                'os_name' => $dataRequest['os_name'],
                'ram' => $res_vps['ram'],
                'cpu' => $res_vps['cpu'],
                'ssd' => $res_vps['ssd'],
                'remote_port' => $res_vps['remote_port'],
                'install_chrome' => $dataRequest['install_chrome'],
                'install_firefox' => $dataRequest['install_firefox'],
                'delete_data' => $dataRequest['not_remove_data'],
                'country' => $res_vps['country'],
                'region' => $res_vps['region'],
                'PlanName' => $res_vps['PlanName'],
                'change_ip_time' => $res_vps['change_ip_time'],
                'note' => $res_vps['note'],
                'partner_server_info_response' => json_encode($res_vps),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng vps', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function ajaxGetChangeIP(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $data = $this->VPSService->getChangeIP($getVps->ip, $request->provider, $request->location);
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function upgradeVPS(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $getPriceUpgrade = $this->VPSService->upgradeCalculate($getVps->vps_id, $request->plan_id);

        $plans = $this->VPSService->getUpgradePlan($getVps->vps_id);
        $planCollect = collect($plans)->keyBy('id')->toArray();
        $planSelect = $planCollect[$request->plan_id];
        $expense = floatval(str_replace([',', ' VND'], '', $getPriceUpgrade['expense']));//giá cuối sẽ thanh toán
        $finalPrice = $expense;
        $finalPrice = $finalPrice + ($finalPrice * $this->feePercent / 100);

        if ($user->available_balance < $finalPrice) {
            throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
        }

        //Bên vps trả thông tin về không cần update order, chỉ cần update server/vps đang nâng cấp là được
        $priceVps = (float)preg_replace('/[^0-9]/', '', $planSelect['price']);
        $priceVps = $priceVps + ($priceVps * $this->feePercent / 100);

        $cpu = explode(" ", $planSelect['cpu'])[0];
        $ram = explode(" ", $planSelect['ram'])[0];
        $ssd = explode(" ", $planSelect['ssd'])[0];

        $created_at = date('Y-m-d H:i:s');
        $expired_at = date('Y-m-d H:i:s', strtotime('+30 days', strtotime($created_at)));

        $res_make_order = $this->VPSService->upgradeVPS($getVps->vps_id, $request->plan_id);

        DB::beginTransaction();
        try {
            // Cập nhật ví
            $this->userModel->where('id', $user->id)->update([
                'available_balance' => $user->available_balance - $finalPrice,
                'balance' => $user->balance - $finalPrice,
                'updated_at' => now(),
            ]);

            $getVps->update([
                'PlanName' => $planSelect['name'],
                'price' => $priceVps,
                'cpu' => $cpu,
                'ram' => $ram,
                'ssd' => $ssd,
                'partner_created_at' => $created_at,
                'partner_expired_at' => $expired_at,
                'amount_before' => floatval(str_replace([',', ' VND'], '', $res_make_order['old_balance'])),
                'amount_last' => floatval(str_replace([',', ' VND'], '', $res_make_order['new_balance'])),
                'partner_server_info_response' => json_encode($res_make_order),
            ]);

            $this->transactionModel->create([
                'user_id' => $user->id,
                'code' => 'VPS' . uniqid_real(6),
                'amount' => $finalPrice * -1,
                'status' => TransactionStatus::Paid,
                'reference_id' => $getVps->id,
                'reference_type' => Vps::class,
                'note' => 'Thanh toán nâng cấp VPS (ID VPS: #' . $getVps->id . ')'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công',
            ]);


        } catch (\Throwable $e) {
            DB::rollBack();

            // Ghi log chi tiết lỗi
            Log::error('Lỗi khi lưu đơn hàng vps', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,

            ]);

            throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
        }
    }

    public function ajaxUpgradeVPSCalculate(Request $request)
    {
        $user = $request->user();
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $data = $this->VPSService->upgradeCalculate($getVps->vps_id, $request->plan_id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function ajaxGetUpgradePlan(Request $request)
    {
        $user = $request->user();
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
        $plans = $this->VPSService->getUpgradePlan($getVps->vps_id);
        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    public function ajaxAutoExtend(Request $request)
    {
        $user = $request->user();
        $getVps = $this->vpsModel->where('user_id', $user->id)->findOrFail($request->id);
//        $change = $this->VPSService->statusAutoRenew($getVps->vps_id);
        $getVps->auto_renew = !$getVps->auto_renew;
        $getVps->save();
        return response()->json([
            'success' => true,
            'status' => $getVps->auto_renew,
            'message' => $getVps->auto_renew ? 'Bậc tự động gia hạn thành công' : 'Tắt tự động gia hạn thành công'
        ]);
    }

    public function searchVpsManagement(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');
        $filter['search_by'] = $request->input('search_by', 'id');
        $filter['q'] = $request->input('q', '');
        $sql = Vps::with('order')->select('*');
        $sql->where('user_id', '=', $user->id);

        if (!empty($filter['q'])) {
            switch ($filter['search_by']) {
                case 'id':
                    $sql->where(function ($q) use ($filter) {
                        $q->where('vps_id', 'LIKE', "%{$filter['q']}%")
                            ->orWhere('ip', 'LIKE', "%{$filter['q']}%");
                    });
                    break;

                case 'code':
                    $sql->where('vps_order_id', 'LIKE', "%{$filter['q']}%");
                    break;
            }
        }
        $by_time = $request->input('by_time');
        if (!empty($by_time)) {
            switch ($by_time) {
                case 'using':
                    $sql->where(function ($q) use ($by_time) {
                        $q->where('partner_expired_at', '>', date('Y-m-d H:i:s', time()));
                    });
                    break;
                case 'due':
                    $sql->where(function ($q) {
                        $now = date('Y-m-d H:i:s');
                        $threeDaysLater = date('Y-m-d H:i:s', strtotime('+3 days'));

                        $q->where('partner_expired_at', '>', $now)
                            ->where('partner_expired_at', '<=', $threeDaysLater);
                    });
                    break;
                case 'expired':
                    $sql->where(function ($q) use ($by_time) {
                        $q->where('partner_expired_at', '<=', date('Y-m-d H:i:s', time())); //Lấy luôn cả trường hợp =
                    });
                    break;
                default:
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

    public function listVpsManagement(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable', //|in:id,vps_id,vps_order_id,server_name
            'q' => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q = trim($validated['q'] ?? '');

        switch ($request->by_time) {
            case 'all':
                $nameList = 'Tất cả dịch vụ';
                break;
            case 'using':
                $nameList = 'Đang sử dụng';
                break;
            case 'due':
                $nameList = 'Còn hạn (dưới 3 ngày)';
                break;
            case 'expired':
                $nameList = 'Đã hết hạn';
                break;
            default:
                $nameList = 'Tất cả dịch vụ';
        }
        $regions = collect($this->regions)->keyBy('symbol')->toArray();

        return view("vps.list-used", [
            'search_by' => $searchBy,
            'q' => $q,
            'by_time' => $nameList,
            'regions' => $regions
        ]);
    }

    public function searchVpsOrders(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');

        $sql = $this->vpsOrderModel->with('user:id')->select('*');

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

    public function listVpsOrders()
    {
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        return view("vps.listVpsOrders")->with('regions', $regions);
    }

    public function searchTransactionHistory(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');

        $sql = $this->transactionModel->with('user:id,phone')->select('*');

        $sql->where('user_id', '=', $user->id)
            ->whereIn('reference_type', [ReferenceType::VpsOrder, ReferenceType::Vps]);


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

    public function transactionHistory()
    {
        return view("vps.transactionHistory");
    }

    public function makeOrder(VPSOrderRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }
        $data = $request->validated();
        try {
            // 1. Lấy giá
            $price_res = $this->VPSService->calculate($data['coupon'], $data['duration'], $data['plan_id'], $data['quantity']);
            $finalPrice = (double)preg_replace('/[^0-9]/', '', $price_res['must_pay']);
            $finalPrice = $finalPrice + ($finalPrice * $this->feePercent / 100);

            //Gán giá trị random về false rồi tự gen tạo pass và port
            if ($data['random_password']) {
                $data['random_password'] = false;
                $data['password'] = $this->generateRandomPassword();
            }
            if ($data['random_remote_port']) {
                $data['random_remote_port'] = false;
                $data['remote_port'] = rand(10000, 65000);
            } else {
                if ($data['remote_port'] < 10000 || $data['remote_port'] > 65000) {
                    throw new \RuntimeException('Port bắt buột từ 10000 đến 65000');
                }
                $data['remote_port'] = (int)$data['remote_port'];
            }

            if ($user->available_balance < $finalPrice) {
                throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
            }

            //Gọi partner để tạo order
            $res_make_order = $this->VPSService->makeOrder($data);

            DB::beginTransaction();
            try {
                // Cập nhật ví
                $this->userModel->where('id', $user->id)->update([
                    'available_balance' => $user->available_balance - $finalPrice,
                    'balance' => $user->balance - $finalPrice,
                    'updated_at' => now(),
                ]);

                //Tạo đơn hàng local
                $orderVpsCreated = $this->vpsOrderModel->create([
                    'user_id' => $user->id,
                    'plan_id' => $data['plan_id'],
                    'duration' => $data['duration'],
                    'auto_renew' => $data['auto_renew'],
                    'quantity' => $data['quantity'],
                    'os_id' => $data['os_id'],
                    'os_name' => $data['os_name'],
                    'random_password' => $data['random_password'],
                    'random_remote_port' => $data['random_remote_port'],
                    'install_chrome' => $data['install_chrome'],
                    'install_firefox' => $data['install_firefox'],
                    'coupon' => $data['coupon'],
                    'range_ip' => $data['range_ip'],
                    'state' => $data['state'],
                    'provider' => $data['provider'],
                    'password' => $data['password'],
                    'port' => $data['remote_port'],
                    'nation' => $data['nation'],
                    'price' => $finalPrice,
                    'request' => $data,
                    'partner_price_response' => $price_res,
                    'partner_order_response' => $res_make_order['servers'],
                ]);

                $dataVps = [];
                foreach ($res_make_order['servers'] as $vps) {
                    $res_vps = $this->VPSService->vpsInfo($vps['id']);
                    $priceVps = (float)preg_replace('/[^0-9]/', '', $vps['price']);
                    $priceVps = $priceVps + ($priceVps * $this->feePercent / 100);
                    $dataVps[] = [
                        'vps_id' => $vps['id'],
                        'user_id' => $user->id,
                        'vps_order_id' => $orderVpsCreated->id,
                        'server_name' => $res_vps['server_name'],
                        'template' => $res_vps['template'],
                        'ram' => $res_vps['ram'],
                        'cpu' => $res_vps['cpu'],
                        'ssd' => $res_vps['ssd'],
                        'install_chrome' => $res_vps['install_chrome'],
                        'install_firefox' => $res_vps['install_firefox'],
                        'country' => $res_vps['country'],
                        'region' => $res_vps['region'],
                        'PlanName' => $res_vps['PlanName'],
                        'change_ip_time' => $res_vps['change_ip_time'],
                        'note' => $res_vps['note'],
                        'partner_created_at' => Carbon::parse($res_vps['created_at'])->format('Y-m-d H:i:s'),
                        'partner_expired_at' => Carbon::parse($res_vps['expired_at'])->format('Y-m-d H:i:s'),
                        'name' => $vps['name'],
                        'ip' => $vps['ip'],
                        'username' => $vps['username'],
                        'password' => $vps['password'],
                        'remote_port' => $vps['remote_port'],
                        'amount_before' => (float)preg_replace('/[^0-9]/', '', $vps['amount_before']),
                        'amount_last' => (float)preg_replace('/[^0-9]/', '', $vps['amount_last']),
                        'auto_renew' => $data['auto_renew'],
                        'delete_data' => false,
                        'price' => $priceVps,
                        'state' => $data['state'],
                        'provider' => $data['provider'],
                        'os_id' => $data['os_id'],
                        'os_name' => $data['os_name'],

                        'partner_server_info_response' => json_encode($res_vps),
                    ];
                }

                // Lưu vps con
                $this->vpsModel->insert($dataVps);

                $this->transactionModel->create([
                    'user_id' => $user->id,
                    'code' => 'VPS' . uniqid_real(6),
                    'amount' => $finalPrice * -1,
                    'status' => TransactionStatus::Paid,
                    'reference_id' => $orderVpsCreated->id,
                    'reference_type' => VpsOrder::class,
                    'note' => 'Thanh toán đơn hàng VPS (ID đơn hàng: #' . $orderVpsCreated->id . ')'
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                ]);


            } catch (\Throwable $e) {
                DB::rollBack();

                // Ghi log chi tiết lỗi
                Log::error('Lỗi khi lưu đơn hàng vps', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,

                ]);

                throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
            }

        } catch (\Throwable $e) {
            Log::error('Lỗi vps order buy tổng thể', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function ajaxCalculate(Request $request)
    {
        $dataSupportPlan = $this->VPSService->calculate($request->coupon ?? '', $request->duration, $request->plan_id, $request->quantity);
        return response()->json([
            'success' => true,
            'data' => $dataSupportPlan
        ]);
    }

    public function ajaxSupport(Request $request)
    {
        $dataSupportPlan = $this->VPSService->supportPlan($request->plan_id, $request->state, $request->provider);
        return response()->json([
            'success' => true,
            'data' => $dataSupportPlan
        ]);
    }

    public function buyingOrderGPU(Request $request)
    {
        $packages = $this->VPSService->getPackageGPU();
        $packageCollect = collect($packages)->keyBy('id')->toArray();
        $packageDetail = $packageCollect[$request->id];
        $dataSupportGPU = $this->VPSService->supportGPU($request->id);

        return view("vps.buying-order-gpu", [
            'package' => $packageDetail ?? null,
            'dataSupportPlan' => $dataSupportGPU,
            'feePercent' => $this->feePercent
        ]);
    }

    public function buyingOrder(Request $request)
    {
        $nation = $request->nation;
        $packages = $this->VPSService->getPackageWithPrice($nation);
        $packageCollect = collect($packages)->keyBy('id')->toArray();
        $packageDetail = $packageCollect[$request->id];
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        $getDetailRegion = $regions[$nation];

        $dataSupportPlan = $this->VPSService->supportPlan($request->id);

        return view("vps.buying-order", [
            'package' => $packageDetail ?? null,
            'getDetailRegion' => $getDetailRegion,
            'dataSupportPlan' => $dataSupportPlan,
            'feePercent' => $this->feePercent
        ]);
    }

    public function buying(Request $request)
    {
        $nation = $request->nation;
        $packages = $this->VPSService->getPackageWithPrice($nation);
        $regions = collect($this->regions)->keyBy('symbol')->toArray();
        $getDetailRegion = $regions[$nation];
        return view("vps.buying", [
            'packages' => $packages ?? null,
            'getDetail' => $getDetailRegion,
            'type' => 'nation',
            'feePercent' => $this->feePercent
        ]);
    }

    public function buyingGPU(Request $request)
    {
        //Lấy danh sách  dịch vụ VPS
        $packages = $this->VPSService->getPackageGPU();
        $getDetailPurpose = $this->purposes['GPU'];
        return view("vps.buying", [
            'packages' => $packages ?? null,
            'getDetail' => $getDetailPurpose,
            'type' => 'gpu',
            'feePercent' => $this->feePercent
        ]);
    }

    public function generateRandomUsername(int $length = 8): string
    {
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';

        // Ký tự đầu tiên luôn là chữ
        $username = [
            $lower[random_int(0, strlen($lower) - 1)],
        ];

        // Các ký tự còn lại có thể là chữ hoặc số
        $all = $lower . $numbers;

        // random cho đến đủ độ dài (đã có 1 ký tự đầu tiên)
        for ($i = 1; $i < $length; $i++) {
            $username[] = $all[random_int(0, strlen($all) - 1)];
        }

        return implode('', $username);
    }

    public function generateRandomPassword(int $length = 10): string
    {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $special = '~!@#$%^&*';

        // Đảm bảo mỗi nhóm ký tự có ít nhất 1 ký tự
        $password = [
            $upper[random_int(0, strlen($upper) - 1)],
            $lower[random_int(0, strlen($lower) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $special[random_int(0, strlen($special) - 1)],
        ];

        // Trộn tất cả nhóm lại để random phần còn lại
        $all = $upper . $lower . $numbers . $special;

        // Thêm random cho đến đủ độ dài
        for ($i = 4; $i < $length; $i++) {
            $password[] = $all[random_int(0, strlen($all) - 1)];
        }

        // Xáo trộn vị trí ký tự
        shuffle($password);

        return implode('', $password);
    }
}
