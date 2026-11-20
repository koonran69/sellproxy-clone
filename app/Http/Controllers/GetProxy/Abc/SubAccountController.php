<?php

namespace App\Http\Controllers\GetProxy\Abc;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\AbcProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubAccountController extends Controller
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

        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $result = $this->service->subAccountList($token, $page, $size);

        if (!isset($result['success'])) {

            return $this->errorResponse('Dữ liệu từ dịch vụ không hợp lệ.');
        }

        if ($result['success']) {

            $list = $result['data']['list'] ?? $result['data'] ?? [];

            if (!is_array($list)) $list = [];

            $html = view('get-proxies.dashboards.abcproxy.sub-accounts-list', [
                'list' => $list
            ])->render();

            return response()->json([
                'success' => true,
                'data'    => $list,
                'html'    => $html,
                'count'   => $result['data']['count'] ?? count($list)
            ]);
        }

        return $this->errorResponse($result['message'] ?? 'Lỗi không xác định từ API.');
    }

    public function add(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $username = $request->input('username');
        $password = $request->input('password');
        $limit    = (int) $request->input('limit', 0);

        if (!$username || !$password) {
            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{5,23}$/', $username)) {
            return $this->errorResponse('Tên người dùng phải chứa từ 6 đến 24 chữ cái, chữ số và dấu gạch dưới, và bắt đầu bằng một chữ cái tiếng Anh.');
        }

        $result = $this->service->addSubAccount($token, $username, $password, $limit);

        return response()->json($result);
    }

    public function toggle(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $id     = $request->input('id');
        $status = $request->input('status');

        if (!$id || !$status) {

            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        $result = $this->service->changeSubAccountState($token, $id, (int)$status);

        return response()->json($result);
    }

    public function update(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $username = $request->input('account');
        $password = $request->input('password');
        $state    = $request->input('state');

        if (!$username || !$password || !$state) {

            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        $result = $this->service->updateSubAccount($token, $username, $password, $state);

        return response()->json($result);
    }

    public function delete(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token] = $resolved;

        $id = $request->input('id');

        if (!$id) {
            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        $result = $this->service->deleteSubAccount($token, (int)$id);

        return response()->json($result);
    }
}
