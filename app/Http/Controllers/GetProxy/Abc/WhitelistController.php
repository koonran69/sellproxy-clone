<?php

namespace App\Http\Controllers\GetProxy\Abc;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Http\Requests\GetProxy\Abc\WhitelistRequest;
use App\Services\GetProxy\AbcProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class WhitelistController extends Controller
{
    use HasProxyAuth;

    public function __construct(
        protected AbcProxyService $service
    ) {}

    public function list(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $page = (int) $request->input('page', 1);
        $size = (int) $request->input('size', 15);

        $result = $this->service->getWhitelist($token, $page, $size);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Không thể lấy danh sách Whitelist.',
            ]);
        }

        $data  = $result['data'];
        $items = $data['list'] ?? [];
        $total = $data['count'] ?? count($items);

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $size,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $html = view('get-proxies.dashboards.abcproxy.parts.whitelist-list', [
            'list' => $paginator,
        ])->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'ip'          => $data['ip'] ?? null,
            'count'       => $total,
            'upper_limit' => $data['upper_limit'] ?? 500,
        ]);
    }

    public function add(WhitelistRequest $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [, $token] = $resolved;

        $result = $this->service->addWhitelist($token, $request->ips);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? ($result['success'] ? 'Thêm IP thành công.' : 'Thêm IP thất bại.'),
            'data'    => $result['data'] ?? null,
        ]);
    }

    public function lock(WhitelistRequest $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [, $token] = $resolved;

        $result = $this->service->lockWhitelist($token, $request->ips, (int) $request->status);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'data'    => $result['data'] ?? null,
        ]);
    }

    public function delete(WhitelistRequest $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [, $token] = $resolved;

        $result = $this->service->deleteWhitelist($token, $request->ips);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'data'    => $result['data'] ?? null,
        ]);
    }

    public function proxyInfo(WhitelistRequest $request): JsonResponse
    {
        $resolved = $this->getAuth($request);
        if ($resolved instanceof JsonResponse) return $resolved;
        [, $token] = $resolved;

        $params = array_filter([
            'proxy_type'  => $request->input('proxy_type', 'flow'),
            'quantity'    => (int) $request->input('quantity', 1),
            'region_code' => $request->input('region_code'),
            'ip_mode'     => (int) $request->input('ip_mode', 0),
            'protocol'    => (int) $request->input('protocol', 1),
            'format'      => $request->input('format', 'json'),
            'white_ips'   => $request->input('white_ips'),
            'status'      => $request->input('status'),
        ], fn($v) => $v !== null && $v !== '');

        $result = $this->service->getApiProxyInfo($token, $params);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'] ?? null,
            'data'    => $result['data'] ?? null,
        ]);
    }
}
