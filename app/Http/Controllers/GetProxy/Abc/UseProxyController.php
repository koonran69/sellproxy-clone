<?php

namespace App\Http\Controllers\GetProxy\Abc;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\AbcProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UseProxyController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected AbcProxyService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $result = $this->service->subAccountList($token, 1, 100);

        $subAccounts = [];
        if ($result['success']) {
            $subAccounts = $result['data']['list'] ?? $result['data'] ?? [];
        }

        return response()->json([
            'success' => true,
            'sub_accounts' => $subAccounts,
            'regions' => config('abcproxy.regions', []),
            'countries' => config('abcproxy.countries', []),
        ]);
    }
}
