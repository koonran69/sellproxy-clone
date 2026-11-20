<?php

namespace App\Http\Controllers\GetProxy\Abc;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\AbcProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CdkController extends Controller
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

        $page = (int) $request->input('page', 1);
        $size = (int) $request->input('size', 15);
        $type = $request->input('type');

        $allList = [];
        $totalCount = 0;

        if ($type) {
            $result = $this->service->getCdkList($token, $page, $size, (int)$type);
            if ($result['success']) {
                $list = $result['data']['list'] ?? [];
                if (!is_array($list) && is_array($result['data'])) {
                    $list = isset($result['data']['ret']) ? [] : $result['data'];
                }

                if (is_array($list)) {
                    foreach ($list as &$item) {
                        if (is_array($item)) $item['resource_type'] = (int)$type;
                    }
                    $allList = $list;
                }
                $totalCount = $result['data']['total'] ?? $result['data']['count'] ?? (is_array($list) ? count($list) : 0);
            }
        } else {
            $types = [1, 2];
            $multiResults = $this->service->getMultiTypeCdkList($token, $types, $page, $size);

            $merged = [];
            foreach ($multiResults as $t => $res) {
                if ($res['success']) {
                    $l = $res['data']['list'] ?? (isset($res['data']['ret']) ? [] : $res['data']);
                    if (is_array($l)) {
                        foreach ($l as &$item) {
                            if (is_array($item)) $item['resource_type'] = $t;
                        }
                        $merged = array_merge($merged, $l);
                    }
                    $totalCount += (int)($res['data']['total'] ?? $res['data']['count'] ?? 0);
                }
            }

            usort($merged, function ($a, $b) {
                $ta = is_array($a) ? ($a['create_time'] ?? 0) : 0;
                $tb = is_array($b) ? ($b['create_time'] ?? 0) : 0;
                return $tb <=> $ta;
            });

            $allList = array_slice($merged, 0, $size);
        }

        $paginator = new LengthAwarePaginator(
            $allList,
            $totalCount,
            $size,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $html = view('get-proxies.dashboards.abcproxy.parts.cdk-list', [
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
        [, $token] = $resolved;

        $num    = $request->input('num');     // Quantity per CDK
        $count  = $request->input('count');   // Number of CDKs
        $type   = $request->input('type', 2); // 1 = Socks5, 2 = Residential

        if (!$num || !$count) {
            return $this->errorResponse('Vui lòng nhập đầy đủ thông tin.');
        }

        $result = $this->service->generateCdk($token, (string)$num, (string)$count, (string)$type);

        return response()->json($result);
    }

    public function exchange(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $cdk = $request->input('cdk');

        if (!$cdk) {
            return $this->errorResponse('Vui lòng nhập mã CDK.');
        }

        $result = $this->service->exchangeCdk($token, $cdk);

        return response()->json($result);
    }
}
