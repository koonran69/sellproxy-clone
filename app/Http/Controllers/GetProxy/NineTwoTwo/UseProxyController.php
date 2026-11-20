<?php

namespace App\Http\Controllers\GetProxy\NineTwoTwo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\NineTwoTwoProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UseProxyController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected NineTwoTwoProxyService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token, $key] = $resolved;

        $page = $request->input('page', 1);
        $size = $request->input('size', 10);
        $proxy_type  = $request->input('proxy_type');

        $result = $this->service->subAccountList($token, $key, $page, $size, $proxy_type);

        $subAccounts = [];
        if ($result['success']) {
            $subAccounts = $result['data']['list'] ?? $result['data'] ?? [];
        }

        return response()->json([
            'success' => true,
            'sub_accounts' => $subAccounts,
            'regions' => config('nicetwotwoproxy.regions', []),
            'countries' => config('nicetwotwoproxy.countries', []),
        ]);
    }
}
