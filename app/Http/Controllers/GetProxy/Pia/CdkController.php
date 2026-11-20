<?php

namespace App\Http\Controllers\GetProxy\Pia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\PiaProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class CdkController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected PiaProxyService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        return response()->json([
            'success' => true,
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [$provider, $token] = $resolved;

        $flow    = $request->input('flow');
        $number  = $request->input('number');

        if (!$flow || !$number) {
            return $this->errorResponse('Vui lòng nhập đầy đủ thông tin.');
        }
        $creds = Session::get($provider->getSessionCredentialsKey(), []);
        $result = $this->service->generateCdk($token, $creds, (string)$flow, (string)$number);
        return response()->json($result);
    }

    public function exchange(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [$provider, $token] = $resolved;

        $cdk = $request->input('cdk');

        if (!$cdk) {
            return $this->errorResponse('Vui lòng nhập mã CDK.');
        }

        $creds = Session::get($provider->getSessionCredentialsKey(), []);
        $result = $this->service->exchangeCdk($token, $creds, $cdk);

        return response()->json($result);
    }
}
