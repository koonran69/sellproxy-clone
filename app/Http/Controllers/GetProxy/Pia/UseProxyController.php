<?php

namespace App\Http\Controllers\GetProxy\Pia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\PiaProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UseProxyController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected PiaProxyService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $countCheck = $this->service->getChildInfo($token, 1, 1); // Lấy 1 cái để biết tổng 'count'
        $totalCount = $countCheck['data']['count'] ?? 0;

        $result = $this->service->getChildInfo($token,1, $totalCount);

        $subAccounts = [];
        if ($result['success']) {
            $subAccounts = $result['data']['list'] ?? $result['data'] ?? [];
        }

        return response()->json([
            'success' => true,
            'sub_accounts' => $subAccounts,
            'regions' => config('piaproxy.regions', []),
            'countries' => config('piaproxy.countries', []),
        ]);
    }
}
