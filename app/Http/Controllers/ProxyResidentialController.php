<?php

namespace App\Http\Controllers;

use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Http\Requests\Request;
use App\Http\Requests\StoreProxyResidentialStaticOrderRequest;
use App\Models\ProxyCountry;
use App\Models\ProxyResidentialOrder;
use App\Models\ProxyResidentialProxy;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ProxyResidentialService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class ProxyResidentialController extends Controller
{
    protected $rate;

    public function __construct(
        protected ProxyResidentialService $proxyResidentialService,
        public ProxyResidentialOrder      $proxyResidentialOrderModel,
        public ProxyResidentialProxy      $proxyResidentialProxyModel,

        public Transaction                $transactionModel,
        public User                       $userModel,
    )
    {
        $this->rate = config('core.rate');
    }

    public function exportProxyStatic(Request $request)
    {
        $user = $request->user();
        $isps = config('proxyresidental')['setting']['isps'];
        $query = ProxyResidentialProxy::with('order.location')->select('*')->where('user_id', $user->id);

        $rows = $query->orderBy('id')->cursor()->map(function (ProxyResidentialProxy $p) use ($isps) {
            $ip_port = '';
            $ip_port_username_pass = '';
            $username_pass_ip_port = '';
            if ($p->ipVersion === "IPv4") {

                $port = $p->httpPort ?? $p->socks5Port ?? $p->httpsPort ?? $p->port ?? null;

                if ($port) {
                    $ip_port = "{$p->publicIp}:{$port}";
                    $ip_port_username_pass = "{$ip_port}:{$p->username}:{$p->password}";
                    $username_pass_ip_port = "{$p->username}:{$p->password}@{$ip_port}";
                }

            } else {
                // IPv6
                if (is_array($p->hostnames)) {
                    foreach ($p->hostnames as $key => $ipv6) {

                        // key dạng: ipv4:port
                        [$ipv4, $port] = explode(':', $key);

                        $ipv4_with_port = "{$ipv4}:{$port}";

                        // Ghép dạng chuỗi — nếu nhiều giá trị thì nối bằng xuống dòng
                        $ip_port .= $ipv4_with_port . "\n";

                        $ip_port_username_pass .= "{$ipv4_with_port}:{$p->username}:{$p->password}\n";

                        $username_pass_ip_port .= "{$p->username}:{$p->password}@{$ipv4_with_port}\n";
                    }
                }
            }

            $country_code = '';
            if ($p->order && $p->order->country) {
                $loc = $p->order->country;

                $country_name = $loc->name ?? 'N/A';
                $country_code = $loc->code ?? 'N/A';
                $stringCountry = $country_name . "( Mã: $country_code )";
            } else {
                $stringCountry = '';
            }

            $isp_name = '';
            if ($p->order && $p->order->isp && $country_code) {
                $ispId = $p->order->isp;
                if (isset($isps[$country_code][$ispId])) {
                    $isp_name = $isps[$country_code][$ispId]['label'];
                }
            }

            return [
                'ID'         => $p->id,
                'Mã (Partner Order)'         => $p->partner_order_id,
                'Mã đơn hàng'         => $p->pr_order_id ,
                'PROXY IP:PORT'               => trim($ip_port),
                'PROXY IP:PORT:USERNAME:PASS' => trim($ip_port_username_pass),
                'PROXY USER:PASS@IP:PORT'     => trim($username_pass_ip_port),
                'Network'   => $p->networkType ?? '',
                'IP Version'   => $p->ipVersion ?? '',
                'Loại'   => $p->proxyType ?? '',
                'Quốc gia'   => $stringCountry,
                'ISP'   => $isp_name,
                'Ngày mua' => optional($p->partner_createdAt)
                    ? $p->partner_createdAt->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
                'Ngày hết hạn' => optional($p->partner_expiresAt)
                    ? Carbon::parse($p->partner_expiresAt)->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
                    : '',
            ];
        })->toArray();

        $filename = "danh-sach-proxy-dan-cu.xlsx";
        return (new FastExcel($rows))->download($filename);
    }

    public function extendProxy(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'time_period' => 'required',
        ]);
        $user = $request->user();
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();
        if (!$proxy) {
            return response()->json([
                'success' => false,
                'message' => "Proxy không tồn tại!",
            ]);
        }
        try {
            // 1. Lấy giá
            $res_price = $this->proxyResidentialService->calculatePeriodExtensionPrice($proxy->proxy_id, $request->time_period);
            $finalPrice = $res_price['finalPrice'] * $this->rate['VND'];

            if ($user->available_balance < $finalPrice) {
                throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
            }

            // 2. Gia hạn proxy
            $res_extend_proxy = $this->proxyResidentialService->extendProxy($proxy, $request->time_period);
            // 3. Transaction để đảm bảo tính toàn vẹn
            DB::beginTransaction();
            try {
                // Cập nhật ví
                $this->userModel->where('id', $user->id)->update([
                    'available_balance' => $user->available_balance - $finalPrice,
                    'balance' => $user->balance - $finalPrice,
                    'updated_at' => now(),
                ]);
                $getDetail = $this->proxyResidentialService->proxyDetailV2($res_extend_proxy['id']);
                //Cập nhật proxy
                $proxy->update([
                    'proxy_id' => $res_extend_proxy['id'],
                    'proxy_status' => $res_extend_proxy['status'],
                    'networkType' => $res_extend_proxy['networkType'],
                    'authentication' => $res_extend_proxy['authentication'],
                    'username' => $res_extend_proxy['authentication']['username'],
                    'password' => $res_extend_proxy['authentication']['password'],
                    'connection' => $res_extend_proxy['connection'],
                    'publicIp' => $res_extend_proxy['connection']['publicIp'],
                    'connectIp' => $res_extend_proxy['connection']['connectIp'],
                    'httpPort' => $res_extend_proxy['connection']['httpPort'],
                    'httpsPort' => $res_extend_proxy['connection']['httpsPort'],
                    'ipVersion' => $res_extend_proxy['connection']['ipVersion'],
                    'socks5Port' => $res_extend_proxy['connection']['socks5Port'],
                    'hostnames' => $getDetail['connection']['hostnames'] ?? null,
                    'proxyType' => $res_extend_proxy['proxyType'],
                    'partner_createdAt' => Carbon::parse($res_extend_proxy['createdAt'])->format('Y-m-d H:i:s'),
                    'partner_expiresAt' => Carbon::parse($res_extend_proxy['expiresAt'])->format('Y-m-d H:i:s'),
                    'metadata' => $res_extend_proxy['metadata'],
                    'partner_proxies_response' => $res_extend_proxy,
                ]);

                // Tạo transaction log
                $this->transactionModel->create([
                    'user_id' => $user->id,
                    'code' => 'PRX' . uniqid_real(6),
                    'amount' => $finalPrice * -1,
                    'status' => TransactionStatus::Paid,
                    'reference_id' => $proxy->order->id,
                    'reference_type' => ProxyResidentialOrder::class,
                    'note' => 'Gia hạn đơn hàng proxy (dân cư) #' . $proxy->order->id
                ]);

                $proxy->order->update([
                    'month' => $request->time_period,
                    'partner_price_response' => $res_price,
                    'partner_proxies_response' => $res_extend_proxy
                ]);


                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Gia hạn thêm thành công',
                    'amount' => $finalPrice,
                ]);

            } catch (\Throwable $e) {
                DB::rollBack();

                // Ghi log chi tiết lỗi
                Log::error('Lỗi khi lưu thông tin gia hạn Proxy', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,
                    'service_id' => $proxy->order->service,
                ]);

                throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
            }

        } catch (\Throwable $e) {
            Log::error('Lỗi extendProxy tổng thể', [
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

    public function changeNoteProxy(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'note' => 'required',
        ]);
        $user = $request->user();
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();
        if (!$proxy) {
            return response()->json([
                'success' => false,
                'message' => "Proxy không tồn tại!",
            ]);
        }

        $proxy->note = $request->input('note');
        $proxy->save();
        return response()->json([
            'success' => true,
            'message' => "Cập nhật thành công!",
        ]);
    }
    public function changeProtocolProxy(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'protocol' => 'required',
        ]);
        $user = $request->user();
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();
        if (!$proxy) {
            return response()->json([
                'success' => false,
                'message' => "Proxy không tồn tại!",
            ]);
        }
        $res = $this->proxyResidentialService->changeProtocol($proxy, $request->protocol);
        if ($res) {
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!",
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => "Có lỗi xãy ra, vui lòng thử lại sau!",
        ]);
    }

    public function changeAuthProxy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $user = $request->user();
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();
        if (!$proxy) {
            return response()->json([
                'success' => false,
                'message' => "Proxy không tồn tại!",
            ]);
        }
        $res = $this->proxyResidentialService->changeAuthProxy($proxy);
        if ($res) {
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!",
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => "Có lỗi xãy ra, vui lòng thử lại sau!",
        ]);
    }

    public function sync(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $user = $request->user();
        $proxy = $this->proxyResidentialProxyModel->with('order')->where('id', $request->input('id'))->where('user_id', $user->id)->firstOrFail();
        if ($proxy->order->service != 'dedicated-mobile') {
            //bên cung cấp chỉ cho xoay ip với loại dedicated-mobile
            return response()->json([
                'success' => false,
                'message' => 'Mạng này không hỗ trợ xoay IP',
            ]);
        }
        $res = $this->proxyResidentialService->syncProxy($proxy);
        return response()->json([
            'success' => true,
            'message' => 'Xoay thành công',
            'data' => $res
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
        $filter['q'] = $request->input('q', '');
        $sql = ProxyResidentialProxy::with('order.location')->select('*');
        $sql->where('user_id', '=', $user->id);

        if (!empty($filter['q'])) {
            switch ($filter['search_by']) {
                case 'id':
                    $sql->where(function ($q) use ($filter) {
                        $q->where('proxy_id', 'LIKE', "%{$filter['q']}%")
                            ->orWhere('publicIp', 'LIKE', "%{$filter['q']}%");
                    });
                    break;

                case 'code':
                    $sql->where('pr_order_id', 'LIKE', "%{$filter['q']}%");
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

    public function listProxies(Request $request)
    {
        $validated = $request->validate([
            'search_by' => 'nullable|in:proxy_id,partner_order_id,pr_order_id',
            'q' => 'nullable|string|max:255',
        ]);
        $searchBy = $validated['search_by'] ?? 'id';
        $q = trim($validated['q'] ?? '');

        $availableTypes = config('proxyresidental')['setting']['availableTypes'];
        $isps = config('proxyresidental')['setting']['isps'];
        $rate = $this->rate;

        return view("proxy-residential.listProxy", [
            'search_by' => $searchBy,
            'q' => $q,
            'availableTypes' => $availableTypes,
            'rate' => $rate,
            'isps' => $isps
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

        $sql = ProxyResidentialOrder::with('user:id')->select('*');

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
        return view("proxy-residential.listProxyOrders");
    }

    public function searchTransactionHistory(Request $request)
    {
        $user = $request->user();
        $filter = $request->all();
        $filter['offset'] = $request->input('offset', 0);
        $filter['limit'] = $request->input('limit', 10);
        $filter['sort'] = $request->input('sort', 'id');
        $filter['order'] = $request->input('order', 'desc');

        $sql = Transaction::with('user:id,phone')->select('*');

        $sql->where('user_id', '=', $user->id)
        ->where('reference_type', ReferenceType::ProxyResidentialOrder);


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
        return view("proxy-residential.transactionHistory");
    }

    public function proxyMakeOrder(StoreProxyResidentialStaticOrderRequest $request): object
    {
        $user = $request->user();
        if (!$user) {
            throw new \RuntimeException('Không tìm thấy người dùng');
        }

        $data = $request->validated();
        $serviceId = $data['service_id'];
        $planId = $data['plan_id'] ?? null;
        $country = $data['country'] ?? null;
        $isp = $data['isp'] ?? null;
        $quantity = $data['quantity'] ?? 0;
        $months = $data['months'] ?? 0;
        $traffic = $data['traffic'] ?? 0;
        $packageId = $data['package_id'] ?? null;

        try {
            // 1. Lấy giá
            $res_price = $this->proxyResidentialService->getPrice($serviceId, $planId, $traffic, $country, $isp, $quantity, $months, $packageId);
            $finalPrice = $res_price['finalPrice'] * $this->rate['VND'];

            if ($user->available_balance < $finalPrice) {
                throw new \RuntimeException('Số dư ví không đủ để thanh toán.');
            }

            // 2. Gọi partner để tạo order
            $res_order = $this->proxyResidentialService->makeAnOrder($serviceId, $planId, $traffic, $country, $isp, $quantity, $months, $packageId);

            // 3. Lấy danh sách proxy thuộc order
            $res_proxies = $this->proxyResidentialService->proxiesThisOrder($res_order['id']);

            $metadata = config('proxyresidental');
            $type = $metadata[$serviceId]['type'] ?? 'unknown';

            // 4. Transaction để đảm bảo tính toàn vẹn
            DB::beginTransaction();

            try {
                // Cập nhật ví
                $this->userModel->where('id', $user->id)->update([
                    'available_balance' => $user->available_balance - $finalPrice,
                    'balance' => $user->balance - $finalPrice,
                    'updated_at' => now(),
                ]);

                // Tạo đơn hàng local
                $orderProxyCreated = $this->proxyResidentialOrderModel->create([
                    'partner_order_id' => $res_order['id'],
                    'user_id' => $user->id,
                    'type' => $type,
                    'service' => $serviceId,
                    'plan' => $planId,
                    'location' => $country,
                    'isp' => $isp,
                    'traffic' => $traffic,
                    'package' => $packageId,
                    'month' => $months,
                    'quantity' => $quantity,
                    'amount' => $finalPrice,
                    'rate_vnd' => $this->rate['VND'],
                    'request' => $data,
                    'partner_price_response' => $res_price,
                    'partner_order_response' => $res_order,
                    'partner_proxies_response' => $res_proxies,
                ]);

                // Chuẩn bị data proxy con
                // Dùng hàm insert nên laravel đang không cast được nên phải json_encode thủ công
                $dataProxies = [];
                foreach ($res_proxies as $res_proxy) {
                    //Vì với ip v6 thì api proxiesThisOrder nó không trả hostnames,phải gọi detail v2 mới có, nên cho chạy vòng lặp gọi detail v2 để đủ dữ liệu.
                    $getDetail = $this->proxyResidentialService->proxyDetailV2($res_proxy['id']);

                    $dataProxies[] = [
                        'partner_order_id' => $res_order['id'],
                        'user_id' => $user->id,
                        'pr_order_id' => $orderProxyCreated->id,
                        'proxy_id' => $res_proxy['id'],
                        'proxy_status' => $res_proxy['status'],
                        'networkType' => $res_proxy['networkType'],
                        'authentication' => json_encode($res_proxy['authentication']),
                        'username' => $res_proxy['authentication']['username'],
                        'password' => $res_proxy['authentication']['password'],
                        'connection' => json_encode($res_proxy['connection']),
                        'publicIp' => $res_proxy['connection']['publicIp'],
                        'connectIp' => $res_proxy['connection']['connectIp'],
                        'httpPort' => $res_proxy['connection']['httpPort'],
                        'httpsPort' => $res_proxy['connection']['httpsPort'],
                        'ipVersion' => $res_proxy['connection']['ipVersion'],
                        'socks5Port' => $res_proxy['connection']['socks5Port'],
                        'hostnames' => $getDetail['connection']['hostnames'] ? json_encode($getDetail['connection']['hostnames']) : null,
                        'proxyType' => $res_proxy['proxyType'],
                        'partner_createdAt' => Carbon::parse($res_proxy['createdAt'])->format('Y-m-d H:i:s'),
                        'partner_expiresAt' => Carbon::parse($res_proxy['expiresAt'])->format('Y-m-d H:i:s'),
                        'metadata' => json_encode($res_proxy['metadata']),
                        'partner_proxies_response' => json_encode($res_proxy),
                    ];
                }

                // Lưu proxies con
                $this->proxyResidentialProxyModel->insert($dataProxies);

                // Tạo transaction log
                $this->transactionModel->create([
                    'user_id' => $user->id,
                    'code' => 'PRX' . uniqid_real(6),
                    'amount' => $finalPrice * -1,
                    'status' => TransactionStatus::Paid,
                    'reference_id' => $orderProxyCreated->id,
                    'reference_type' => ProxyResidentialOrder::class,
                    'note' => 'Thanh toán đơn hàng proxy (dân cư) #' . $orderProxyCreated->id
                ]);


                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'order_id' => $orderProxyCreated->id,
                    'amount' => $finalPrice,
                    'partner_order' => $res_order['id'],
                ]);

            } catch (\Throwable $e) {
                DB::rollBack();

                // Ghi log chi tiết lỗi
                Log::error('Lỗi khi lưu đơn hàng Proxy', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'user_id' => $user->id,
                    'service_id' => $serviceId,
                    'country' => $country,
                    'isp' => $isp,
                ]);

                throw $e; // ném ra ngoài để catch bên ngoài xử lý JSON
            }

        } catch (\Throwable $e) {
            Log::error('Lỗi proxyMakeOrder tổng thể', [
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

    public function proxyGetPrice(Request $request): object
    {
        try {
            $serviceId = $request->input('service_id');
            $planId = $request->input('plan_id') ?? null;
            $traffic = $request->input('traffic') ?? 0;
            $country = $request->input('country') ?? null;
            $isp = $request->input('isp') ?? null;
            $quantity = $request->input('quantity') ?? 0;
            $months = $request->input('months') ?? 0;
            $package = $request->input('package') ?? 0;

//            dd($serviceId, $planId, $traffic, $country, $isp, $quantity, $months);
            $res_services = $this->proxyResidentialService->getPrice($serviceId, $planId, $traffic, $country, $isp, $quantity, $months, $package);
            return response()->json([
                'success' => true,
                "finalPrice" => $res_services['finalPrice'],
                "priceNoDiscounts" => $res_services['priceNoDiscounts'],
                "discount" => $res_services['discount'],
                "unitPrice" => $res_services['unitPrice'],
                "unitPriceAfterDiscount" => $res_services['unitPriceAfterDiscount'],
                "additionalAmount" => $res_services['additionalAmount'],
                "additionalAmountAfterDiscount" => $res_services['additionalAmountAfterDiscount'],
                "paymentFee" => $res_services['paymentFee'],
                "subtotal" => $res_services['subtotal'],
                "discountAmount" => $res_services['discountAmount'],
                "finalPriceInCurrency" => $res_services['finalPriceInCurrency'],
                "currency" => $res_services['currency'],
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ajaxPeriodExtensionPrice(Request $request): object
    {
        $res_calculate = $this->proxyResidentialService->calculatePeriodExtensionPrice($request->proxy_id, $request->month);
        return response()->json([
            'success' => true,
            'data' => $res_calculate,
        ]);
    }

    public function ajaxServiceDetail(Request $request)
    {
        $res_services = $this->proxyResidentialService->detailService($request->service_id, $request->plan_id);
        return response()->json([
            'success' => true,
            'data' => $res_services,
        ]);
    }

    public function proxyStaticList(): object
    {
        $data = $this->getDataAllService();
        $metadata = config('proxyresidental');

        $getCountryAll = Cache::rememberForever('country_all', function () {
            $dataCountryAll = ProxyCountry::select('name', 'code', 'feature_image')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->code => [
                            'name' => $item->name,
                            'feature_image' => $item->feature_image,
                        ]
                    ];
                })
                ->toArray();
            return $dataCountryAll;
        });

        $rate = config('core.rate');

        return view('proxy-residential.static', compact('data', 'metadata', 'getCountryAll', 'rate'));
    }

    public function getDataAllService(): array
    {
        //Lưu cache vĩnh viễn, nếu bên thứ 3 thay đổi thì xử lý cập nhật rồi clear cache sau, tránh gây lỗi
        $data = Cache::rememberForever('proxy_services_cache', function () {
            $res_services = $this->proxyResidentialService->getAllServices(false, false);
            //remove 2 gói ipv6 vì chưa khả dụng (không trả data quốc gia để order và bên cung cấp cũng có cảnh báo IPv6 proxies may not support all websites. Test compatibility before ordering.)
            $data['services'] = array_filter($res_services['services'] ?? [], function ($service) {
                return !in_array($service['id'], ['static-residential-ipv6']);
            });

            $data['services'] = array_values($data['services']);
            foreach ($data['services'] as &$service) {
                //Có nhiều plan → gọi API song song (details + price)
                if (!empty($service['plans'])) {
                    foreach ($service['plans'] as &$plan) {

                        $withMetadata = ($service['id'] === 'dedicated-mobile');
                        $country = null;
                        $period = ['unit' => 'months', 'value' => 1];

                        if ($withMetadata) {
                            // Dedicated-mobile có metadata & tính theo ngày
                            $details = $this->proxyResidentialService->getServiceFullData(
                                $service['id'],
                                $plan['id'],
                                true
                            );
                            $country = $details['info']['countries'][0] ?? null;
                            $period = ['unit' => 'days', 'value' => 7];
                        }

                        $planData = $this->proxyResidentialService->getServiceFullData(
                            $service['id'],
                            $plan['id'],
                            $withMetadata,
                            $country,
                            $period
                        );

                        $plan['info'] = $planData['info'];
                        $plan['price'] = $planData['price'];
                    }
                } //Service không có plan
                else {
                    $planPrice = match ($service['id']) {
                        'rotating-residential', 'rotating-mobile'
                        => $this->proxyResidentialService->getSimpleServicePrice($service['id'], ['traffic' => 1]),
                        'static-datacenter-ipv6', 'static-residential-ipv6'
                        => $this->proxyResidentialService->getSimpleServicePrice($service['id'], [
                            'packageId' => '50',
                            'period' => ['unit' => 'months', 'value' => 1],
                        ]),
                        default
                        => $this->proxyResidentialService->getSimpleServicePrice($service['id']),
                    };
                    //Khách yêu cầu mở thêm gói ipv6 datacenter
                    if ($service['id'] == 'static-datacenter-ipv6') {
                        $service['plans'][] = [
                            'info' => [
                                'countries' => config('proxyresidental')[$service['id']]['metadata']['countries'],
                                'periods' => ['months'=>config('proxyresidental')[$service['id']]['metadata']['months']],
                                'packages' => config('proxyresidental')[$service['id']]['metadata']['packages'],
                            ],
                            'price' => $planPrice,
                        ];
                    } else {
                        $service['plans'][] = [
                            'info' => [],
                            'price' => $planPrice,
                        ];
                    }
                }
            }
            return $data;
        });

        return $data;
    }
}
