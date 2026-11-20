<?php

namespace App\Http\Controllers\GetProxy\Pia;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Http\Requests\GetProxy\ProxyConnectRequest;
use App\Models\ProxyConnectionLog;
use App\Services\GetProxy\PiaProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected PiaProxyService $service
    ) {}

    public function index()
    {
        $provider = ProxyProvider::Pia;

        $token = Session::get($provider->getSessionTokenKey());

        if (!$token) {
            return redirect()->route('getProxies.show', ['slug' => $provider->slug()]);
        }

        $providers = ProxyProvider::all();

        foreach ($providers as $key => &$p) {
            $p['is_connected'] = Session::has(ProxyProvider::tryFrom($key)->getSessionTokenKey());
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

        $provider = ProxyProvider::Pia;

        $result = $this->service->connect($data);

        ProxyConnectionLog::storeLog($data, $result, $provider->value, $request);

        if ($result['success']) {
            Session::put($provider->getSessionTokenKey(), $result['token']);

            Session::put($provider->getSessionCredentialsKey(), [
                'email' => $data['username'],
                'password' => $data['password'],
                'username' => $result['username'],
            ]);

            return response()->json([
                'success'  => true,
                'message'  => "Kết nối {$provider->description()} thành công!",
                'redirect' => route('getProxies.piaproxy.index'),
            ]);
        }

        return $this->errorResponse($result['message'] ?? 'Kết nối thất bại.');
    }

    public function refresh(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [$provider,$token] = $resolved;

        $creds = Session::get($provider->getSessionCredentialsKey(), []);

//        $resultFlowBalance= $this->service->getResidentialFlowBalance($token);

        //Hiện không có api user info, chỉ có thể lấy all child để tính toán flow_used và data_center_used tổng
        $countCheck = $this->service->getChildInfo($token, 1, 1); // Lấy 1 cái để biết tổng 'count'
        $totalCount = $countCheck['data']['count'] ?? 0;

        $resultChild = $this->service->getChildInfo($token,1, $totalCount);

        $data = $this->service->getMappingInfo($resultChild['data'], $creds);

        return $resultChild['success']
            ? response()->json(['success' => true, 'data' => $data])
            : $this->errorResponse('Không thể lấy dữ liệu cập nhật.');
    }

    public function logout()
    {
        $provider = ProxyProvider::Pia;

        Session::forget($provider->getSessionTokenKey());

        Session::forget($provider->getSessionCredentialsKey());

        return redirect()->route('getProxies.show', ['slug' => $provider->slug()]);
    }
}
