<?php

namespace App\Http\Controllers\GetProxy\NineTwoTwo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\NineTwoTwoProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CdkController extends Controller
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

        $page = (string) $request->input('page', '1');
        $size = (string) $request->input('size', '20');

        $allList = [];
        $totalCount = 0;

        $result = $this->service->getCdkList($token, $key, $page, $size);

        if ($result['success']) {
            $allList = $result['data']['list'] ?? [];
            $totalCount = $result['data']['total'] ?? $result['data']['count'] ?? 0;
        }

        $paginator = new LengthAwarePaginator(
            $allList,
            $totalCount,
            $size,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $html = view('get-proxies.dashboards.nicetwotwoproxy.parts.cdk-list', [
            'list' => $paginator
        ])->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'total'        => $paginator->total(),
            ]
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [, $token, $key] = $resolved;

        $package_type = 2; //Số dư doanh nghiệp residential proxy balance
        $cate   = $request->input('cate', 'flow');
        $num    = $request->input('num');
        $count  = $request->input('count');

        if (!$num || !$count) {
            return $this->errorResponse('Vui lòng nhập đầy đủ thông tin dung lượng và số lượng.');
        }

        if($num < 5){
            return $this->errorResponse('Dung lượng mỗi mã CDK phải >= 5.');
        }

        $result = $this->service->generateCdk(
            $token,
            $key,
            $package_type,
            (string)$cate,
            (int)$num,
            (int)$count,
        );

        if ($result['success'] && isset($result['data']['cdk_list'])) {
            return response()->json([
                'success' => true,
                'data'    => $result['data']['cdk_list'],
                'balance' => $result['data']['balance'] ?? null,
                'flow' => $result['data']['flow'] ?? null,
                'flow_redeem' => $result['data']['flow_redeem'] ?? null
            ]);
        }

        return response()->json($result);
    }

    public function exchange(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token, $key] = $resolved;

        $cdk = $request->input('cdk');

        if (!$cdk) {
            return $this->errorResponse('Vui lòng nhập mã CDK.');
        }

        $result = $this->service->exchangeCdk($token, $key, $cdk);

        return response()->json($result);
    }
}
