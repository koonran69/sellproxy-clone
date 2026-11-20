<?php

namespace App\Http\Controllers\GetProxy\Abc;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Models\ProxyConnectionLog;
use App\Services\GetProxy\AbcProxyService;
use App\Http\Requests\GetProxy\ProxyConnectRequest;
use App\Models\ProxyLoginLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected AbcProxyService $service,
        protected ProxyLoginLog $logModel
    ) {}

    public function index()
    {
        $provider = ProxyProvider::Abc;

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

        $provider = ProxyProvider::Abc;

        $result = $this->service->connect($data);

        ProxyConnectionLog::storeLog($data, $result, $provider->value, $request);

        if ($result['success']) {
            Session::put($provider->getSessionTokenKey(), $result['token']);

            Session::put($provider->getSessionCredentialsKey(), [
                'username' => $data['username'],
                'password' => $data['password'],
            ]);

            return response()->json([
                'success'  => true,
                'message'  => "Kết nối {$provider->description()} thành công!",
                'redirect' => route('getProxies.abcproxy.index'),
            ]);
        }

        return $this->errorResponse($result['message'] ?? 'Kết nối thất bại.');
    }

    public function refresh(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [$provider, $token] = $resolved;

        $creds = Session::get($provider->getSessionCredentialsKey(), []);

        $result = $this->service->getUserInfo($token, $creds);

        return $result['success']
            ? response()->json(['success' => true, 'data' => $result['data']])
            : $this->errorResponse('Không thể lấy dữ liệu cập nhật.');
    }

    public function logout()
    {
        $provider = ProxyProvider::Abc;

        Session::forget($provider->getSessionTokenKey());

        Session::forget($provider->getSessionCredentialsKey());

        return redirect()->route('getProxies.show', ['slug' => $provider->slug()]);
    }
}
