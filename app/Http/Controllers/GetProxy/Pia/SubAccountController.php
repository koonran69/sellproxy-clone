<?php

namespace App\Http\Controllers\GetProxy\Pia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\PiaProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubAccountController extends Controller
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

        $page = $request->input('page', 1);
        $size = 20;

        $result = $this->service->getChildInfo($token, $page, $size);

        if ($result['success']) {
            $data = $result['data'];
            $list = $data['list'] ?? [];
            $totalCount = $data['count'] ?? 0;

            $html = view('get-proxies.dashboards.piaproxy.sub-accounts-list', [
                'list' => $list,
                'page' => $page,
                'size' => $size
            ])->render();

            return response()->json([
                'success'      => true,
                'html'         => $html,
                'current_page' => $page,
                'total_pages'  => ceil($totalCount / $size),
                'total_count'  => $totalCount
            ]);
        }

        return $this->errorResponse($result['message'] ?? 'Lỗi không xác định.');
    }
}
