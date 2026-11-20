<?php

namespace App\Http\Controllers\GetProxy\Traits;

use App\Core\Enums\GetProxy\ProxyProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

trait HasProxyAuth
{
    protected function getAuth(Request $request)
    {
        $providerValue = $request->provider;

        $provider = is_numeric($providerValue)
            ? ProxyProvider::tryFrom((int)$providerValue)
            : ProxyProvider::fromSlug((string)$providerValue);

        if (!$provider) {
            return $this->errorResponse('Nhà cung cấp không hợp lệ.');
        }

        $token = Session::get($provider->getSessionTokenKey());

        if (!$token) {
            return $this->errorResponse('Token hết hạn.');
        }

        if($provider == ProxyProvider::NineTwoTwo){
            $key = Session::get($provider->getSessionKey());
            if (!$key) {
                return $this->errorResponse('Key hết hạn.');
            }
            return [$provider, $token, $key];
        }else{
            return [$provider, $token];
        }
    }

    protected function expiredResponse(ProxyProvider $provider, string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'is_token_expired' => true,
            'message' => $message,
            'redirect' => route('getProxies.show', ['slug' => $provider->slug()])
        ], 401);
    }

    protected function errorResponse(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
