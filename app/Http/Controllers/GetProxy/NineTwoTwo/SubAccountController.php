<?php

namespace App\Http\Controllers\GetProxy\NineTwoTwo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetProxy\Traits\HasProxyAuth;
use App\Services\GetProxy\NineTwoTwoProxyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubAccountController extends Controller
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

        if (!isset($result['success'])) {
            return $this->errorResponse('Dữ liệu từ dịch vụ không hợp lệ.');
        }

        if ($result['success']) {
            $list = $result['data']['lists'] ?? $result['data'] ?? [];

            if (!is_array($list)) $list = [];

            $html = view('get-proxies.dashboards.nicetwotwoproxy.sub-accounts-list', [
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

        [, $token, $key] = $resolved;
        $proxy_type = 1; //Set the type for creating sub-accounts:1 represents residential proxy, 2 represents unlimited residential proxy、3 represents dynamic rotation of ISP
        $username = $request->input('username');
        $password = $request->input('password');
        $limit    = (int) $request->input('limit', 0);
        $remake = $request->input('remark');

        if (!$username || !$password) {
            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{5,23}$/', $username)) {
            return $this->errorResponse('Tên người dùng phải chứa từ 6 đến 24 chữ cái, chữ số và dấu gạch dưới, và bắt đầu bằng một chữ cái tiếng Anh.');
        }

        $result = $this->service->addSubAccount($token, $key, $username, $password, $limit, $proxy_type, $remake);

        return response()->json($result);
    }

    public function update(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token, $key] = $resolved;
        $proxy_type = 1; //Set the type for creating sub-accounts:1 represents residential proxy, 2 represents unlimited residential proxy、3 represents dynamic rotation of ISP
        $original_account = $request->input('original_account');
        $username = $request->input('username');
        $password = $request->input('password');
        $limit    = (int) $request->input('limit', 0);
        $remake = $request->input('remark');

        if (!$username || !$password) {
            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]{5,23}$/', $username)) {
            return $this->errorResponse('Tên người dùng phải chứa từ 6 đến 24 chữ cái, chữ số và dấu gạch dưới, và bắt đầu bằng một chữ cái tiếng Anh.');
        }

        $result = $this->service->updateSubAccount($token, $key, $original_account, $username, $password, $limit, $proxy_type, $remake);

        return response()->json($result);
    }

    public function delete(Request $request): JsonResponse
    {
        $resolved = $this->getAuth($request);

        if ($resolved instanceof JsonResponse) return $resolved;

        [, $token, $key] = $resolved;

        $proxy_type = 1; //Set the type for creating sub-accounts:1 represents residential proxy, 2 represents unlimited residential proxy、3 represents dynamic rotation of ISP
        $account = $request->input('account');

        if (!$account) {
            return $this->errorResponse('Thông tin không đầy đủ.');
        }

        $result = $this->service->deleteSubAccount($token, $key, $account, $proxy_type);

        return response()->json($result);
    }
}
