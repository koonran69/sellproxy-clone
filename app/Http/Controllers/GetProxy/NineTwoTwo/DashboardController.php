<?php

namespace App\Http\Controllers\GetProxy\NineTwoTwo;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Core\Http\Requests\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Http\Requests\GetProxy\ProxyConnectRequest;
use App\Models\ProxyConnectionLog;
use App\Services\GetProxy\NineTwoTwoProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected NineTwoTwoProxyService $service
    ) {}
    public function index()
    {
        $provider = ProxyProvider::NineTwoTwo;

        $token = Session::get($provider->getSessionTokenKey());
        $key = Session::get($provider->getSessionKey());

        if (!$token || !$key) {
            return redirect()->route('getProxies.show', ['slug' => $provider->slug()]);
        }

        $providers = ProxyProvider::all();

        foreach ($providers as $k => &$p) {
            $p['is_connected'] = Session::has(ProxyProvider::tryFrom($k)->getSessionTokenKey());
        }

        return view('get-proxies.dashboard', [
            'provider'      => $provider->value,
            'providerSlug'  => $provider->slug(),
            'providerLabel' => $provider->description(),
            'providers'     => $providers,
            'data'          => [],
        ]);
    }

    public function connect(ProxyConnectRequest $request): JsonResponse
    {
        $data = $request->validated();

        $provider = ProxyProvider::NineTwoTwo;

        $result = $this->service->connect($data);

        ProxyConnectionLog::storeLog($data, $result, $provider->value, $request);

        if ($result['success']) {
            Session::put($provider->getSessionTokenKey(), $result['token']);
            Session::put($provider->getSessionKey(), $result['key']);

            Session::put($provider->getSessionCredentialsKey(), [
                'email' => $data['username'],
                'password' => $data['password'],
                'username' => $result['username'],
            ]);

            return response()->json([
                'success'  => true,
                'message'  => "Kết nối {$provider->description()} thành công!",
                'redirect' => route('getProxies.nicetwotwoproxy.index'),
            ]);
        }

        return $this->errorResponse($result['message'] ?? 'Kết nối thất bại.');
    }

    public function refresh(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [$provider, $token, $key] = $resolved;

        $creds = Session::get($provider->getSessionCredentialsKey(), []);

        $balanceTraffic = $this->service->getBalanceTraffic($token, $key);

        $balanceRecharge = $this->service->getBalanceRecharge($token, $key);

        if (!$balanceTraffic['success'] || empty($balanceTraffic['data']) || !$balanceRecharge['success'] || empty($balanceRecharge['data'])) {
            // Xóa session trước khi phản hồi
            Session::forget([$provider->getSessionTokenKey(), $provider->getSessionKey(), $provider->getSessionCredentialsKey()]);
            return $this->expiredResponse($provider, 'Token không còn hiệu lực! Vui lòng đăng nhập lại');
        }

        //Xử lý mapping dữ liệu
        $data = [
            'email' => $creds['email'] ?? '',
            'username' => $creds['username'] ?? '',

            'residential_expire_date' => $balanceTraffic['data']['residential']['expire_date'] ?? null,
            'residential_traffic_mb' => $balanceTraffic['data']['residential']['traffic_mb'] ?? null,
            'residential_status' => $balanceTraffic['data']['residential']['status'] ?? null,

            'rotating_expire_date' => $balanceTraffic['data']['rotating']['expire_date'] ?? null,
            'rotating_traffic_mb' => $balanceTraffic['data']['rotating']['traffic_mb'] ?? null,
            'rotating_status' => $balanceTraffic['data']['rotating']['status'] ?? null,

            'residential_business_expire_date' => $balanceTraffic['data']['residential_business']['expire_date'] ?? null,
            'residential_business_traffic_mb' => $balanceTraffic['data']['residential_business']['traffic_mb'] ?? null,
            'residential_business_status' => $balanceTraffic['data']['residential_business']['status'] ?? null,

            'balance_recharge' => '$'.$balanceRecharge['data']['balance'] ?? null,
        ];

        return ($balanceTraffic['success'] && $balanceRecharge['success'])
            ? response()->json(['success' => true, 'data' => $data])
            : $this->errorResponse('Không thể lấy dữ liệu cập nhật.');
    }

    public function logout()
    {
        $provider = ProxyProvider::NineTwoTwo;

        Session::forget($provider->getSessionTokenKey());
        Session::forget($provider->getSessionKey());

        Session::forget($provider->getSessionCredentialsKey());

        return redirect()->route('getProxies.show', ['slug' => $provider->slug()]);
    }
}
