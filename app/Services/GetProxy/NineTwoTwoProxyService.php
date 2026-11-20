<?php

namespace App\Services\GetProxy;

use App\Core\Enums\GetProxy\ProxyProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NineTwoTwoProxyService
{
    protected string $baseUrl = 'https://docapi.922data.com/api';

    public function connect(array $credentials): array
    {
        try {
            $res = $this->post('user/token_key', [
                'email' => $credentials['username'] ?? '',
                'password' => $credentials['password'] ?? '',
                'provider' => $credentials['provider'] ?? '',
            ]);

            if (empty($res)) {
                return [
                    'success' => false,
                    'message' => 'Không thể kết nối đến hệ thống. Vui lòng thử lại sau!'
                ];
            }

            if (!isset($res['success']) || !$res['success']) {
                return [
                    'success' => false,
                    'message' => $res['msg'] ?? 'Đăng nhập không thành công!'
                ];
            }

            $access_token = $res['data']['token'] ?? null;
            $key = $res['data']['key'] ?? null;

            if (empty($access_token) || empty($key)) {
                return [
                    'success' => false,
                    'message' => 'Không nhận được mã xác thực từ máy chủ.'
                ];
            }

            return [
                'success' => true,
                'token' => $access_token,
                'key' => $key,
                'email' => $res['data']['email'] ?? null,
                'username' => $res['data']['username'] ?? null,
            ];

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình xử lý! Vui lòng thử lại sau'
            ];
        }
    }

    public function getBalanceTraffic(string $token, string $key): array
    {
        $params = array_filter([
            'token' => $token,
            'key' => $key
        ]);

        $res = $this->get('balance/traffic', $params, $token);

        if (!$res['success'] || empty($res['data'])){
            return [
                'success' => false,
                'is_token_expired' => true,
                'message' => 'Phiên làm việc hết hạn hoặc không có dữ liệu.'
            ];
        }

        $data = $res['data'];

        $info = [
            'residential' => $data['residential'] ?? [],
            'rotating' => $data['rotating'] ?? [],
            'residential_business' => $data['residential_business'] ?? [],
        ];

        return ['success' => true, 'data' => $info];
    }

    public function getBalanceRecharge(string $token, string $key): array
    {
        $params = array_filter([
            'token' => $token,
            'key' => $key
        ]);

        $res = $this->get('balance/recharge', $params, $token);

        if (!$res['success'] || empty($res['data'])){
            return [
                'success' => false,
                'is_token_expired' => true,
                'message' => 'Phiên làm việc hết hạn hoặc không có dữ liệu.'
            ];
        }

        $data = $res['data'];

        $info = [
            'balance' => $data['balance'] ?? [],
        ];
        return ['success' => true, 'data' => $info];
    }

    public function subAccountList(string $token, string $key, int $page = 1, int $size = 10, int $proxy_type = null): array
    {
        $params = [
            'page' => (string) $page,
            'size' => (string) $size,
            'token' => $token,
            'key' => $key
        ];

        if (!is_null($proxy_type)) {
            $params['proxy_type'] = $proxy_type;
        }

        return $this->get('account/lists', $params, $token);
    }

    public function addSubAccount(string $token, string $key, string $username, string $password, int $limit = 0, int $proxy_type = 1, string $remake = null): array
    {
        return $this->post('account/create', [
            'token' => $token,
            'key' => $key,
            'account'   => $username,
            'password'   => $password,
            'proxy_type' => $proxy_type,
            'remake' => $remake,
            'traffic' => $limit,
            'traffic_unit' => 'GB',
        ], $token);
    }

    public function deleteSubAccount(string $token, string $key, string $account, int $proxy_type): array
    {
        return $this->post('account/delete', [
            'token' => $token,
            'key' => $key,
            'account' => $account,
            'proxy_type' => $proxy_type
        ], $token);
    }

    public function updateSubAccount(string $token, string $key, string $original_account, string $username, string $password, int $limit = 0, int $proxy_type = 1, string $remake = null): array
    {
        return $this->post('account/update', [
            'token' => $token,
            'key' => $key,
            'original_account' => $original_account,
            'account'   => $username,
            'password'   => $password,
            'proxy_type' => $proxy_type,
            'remake' => $remake,
            'traffic' => $limit,
            'traffic_unit' => 'GB',
        ], $token);
    }

    public function generateCdk(string $token, string $key, int $package_type, string $cate, int $num, int $count): array
    {
        return $this->post('cdk/enterprise_create', [
            'token'    => $token,
            'key'      => $key,
            'package_type' => $package_type,
            'cate'     => $cate,
            'num'      => $num,
            'count'    => $count,
        ], $token);
    }

    public function exchangeCdk(string $token, string $key, string $cdk): array
    {
        return $this->post('cdk/convert', [
            'token'    => $token,
            'key'      => $key,
            'cdkey' => $cdk,
        ], $token);
    }

    public function getCdkList(string $token, string $key, string $page, string $size): array
    {
        $params = [
            'token' => $token,
            'key' => $key,
            'page' => $page,
            'size' => $size,
            'type'   => '', // Để trống để lấy All (Invite, Commission, Agent...)
            'status' => '0' // Dùng chuỗi '0' để đồng bộ kiểu string, lấy All (Normal + In Use)
        ];
        return $this->get('cdk/lists', $params, $token);
    }

    public function getWhitelist(string $token, int $page = 1, int $size = 15): array
    {
        return $this->post('white_ip', [
            'page'   => (string) $page,
            'size'   => (string) $size,
            'status' => '1',
        ], $token);
    }

    public function addWhitelist(string $token, string $ips): array
    {
        return $this->post('add_white_ip', ['white_ips' => $ips], $token);
    }

    public function lockWhitelist(string $token, string $ips, int $status): array
    {
        return $this->post('lock_white_ip', ['white_ips' => $ips, 'status' => (string) $status], $token);
    }

    public function deleteWhitelist(string $token, string $ips): array
    {
        return $this->post('del_white_ip', ['white_ips' => $ips], $token);
    }

    public function getApiProxyInfo(string $token, array $params): array
    {
        return $this->post('api_proxy_info', $params, $token);
    }

    protected function get(string $endpoint, array $params = [], ?string $token = null): array
    {
        try {
            $http = Http::withToken($token);

            $response = $http->get("{$this->baseUrl}/{$endpoint}", $params);

            $res = $response->json() ?? [];

            //922 nó có nhiều trường hợp response trả về :)) nên cứ bắt theo nó.
            $nineTwoTwoSuccessCodes = [
                '__T_CDK_GENERATE_OK',
                '__T_EX_SUCCESS',
                '__T_EX_CDK_SUCCESS',
                'ok',
                '200'
            ];

            $resCode = $res['code'] ?? ($res['msg'] ?? '');

            $isSuccess = $response->successful() && (
                    in_array($resCode, $nineTwoTwoSuccessCodes) ||
                    ($res['ret'] ?? -1) === 0 ||
                    ($res['code'] ?? -1) === 1 ||
                    ($resCode === 'success')
                );

            if (!$isSuccess) {
                $errorMessage = $this->mapNineTwoTwoError($resCode);
                return ['success' => false, 'message' => $errorMessage, 'code' => $resCode];
            }

            return ['success' => true, 'data' => $res['ret_data'] ?? $res['data'] ?? $res];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    protected function post(string $endpoint, array $params = [], ?string $token = null): array
    {
        try {
            $http = Http::asForm();

            if ($token) $http = $http->withToken($token);

            $response = $http->post("{$this->baseUrl}/{$endpoint}", $params);

            $res = $response->json() ?? [];

            //922 nó có nhiều trường hợp response trả về :)) nên cứ bắt theo nó.
            $nineTwoTwoSuccessCodes = [
                '__T_SUCCESS',
                '__T_CDK_GENERATE_OK',
                '__T_EX_SUCCESS',
                '__T_EX_CDK_SUCCESS',
                'ok',
                '200'
            ];

            $resCode = $res['code'] ?? ($res['msg'] ?? '');

            $isSuccess = $response->successful() && (
                    in_array($resCode, $nineTwoTwoSuccessCodes) ||
                    ($res['ret'] ?? -1) === 0 ||
                    ($res['code'] ?? -1) === 1 ||
                    ($resCode === 'success')
                );

            if (!$isSuccess) {
                $errorMessage = $this->mapNineTwoTwoError($resCode);
                return ['success' => false, 'message' => $errorMessage, 'code' => $resCode];
            }

            return ['success' => true, 'data' => $res['ret_data'] ?? $res['data'] ?? $res];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => "Lỗi HTTP Exception: {$e->getMessage()}"];
        }
    }
    private function mapNineTwoTwoError(string $code): string
    {
        return match ($code) {
            '__T_AGENT_NOT_EXIST', //Đại lý không được hỗ trợ
            '__T_AGENT_BALANCE_LOW' => 'Có lỗi xãy ra vui lòng thử lại sau!. Hoặc liên hệ để được hỗ trợ ngay', //Số dư tài khoản đại lý không đủ để thực hiện thao tác này.
            '__T_CDK_NOT_FOUND'     => 'Mã CDK không tồn tại hoặc đã nhập sai.',
            '__T_CDK_USED'          => 'Mã CDK này đã được sử dụng trước đó.',
            '__T_TOKEN_EXPIRED'     => 'Phiên làm việc đã hết hạn, vui lòng đăng nhập lại.',
            '__T_EX_USED'           => 'Mã CDK này đã được sử dụng!',
            default                 => "Có lỗi xãy ra vui lòng thử lại sau!. Hoặc liên hệ để được hỗ trợ ngay"
        };
    }
}
