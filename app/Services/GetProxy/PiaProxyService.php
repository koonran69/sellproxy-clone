<?php

namespace App\Services\GetProxy;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PiaProxyService
{
    protected string $baseUrl = 'http://account.piadata.net/open';
    public function connect(array $credentials): array
    {
        try {
            $res = $this->post('s', [
                'email' => $credentials['username'] ?? '',
                'passwd' => $credentials['password'] ?? '',
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

            $access_token = $res['data']['s'] ?? null;

            if (empty($access_token)) {
                return [
                    'success' => false,
                    'message' => 'Không nhận được mã xác thực từ máy chủ.'
                ];
            }

            return [
                'success' => true,
                'token' => $access_token,
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

    public function getMappingInfo($childInfo, $user): array
    {
        $list = collect($childInfo['list'] ?? []);

        //(Quy đổi từ Byte sang GB)
        $divisor = 1024 ** 3;

        // Tính tổng tất cả child từ danh sách đầy đủ
        $totalFlowUsed = $list->sum('flow_used')/$divisor;
        $totalFlowLimit = $list->sum('flow_limit');
        $totalDcUsed = $list->sum('data_center_used')/$divisor;
        $totalDcLimit = $list->sum('data_center_limit');

        return [
            'email' => $user['email'] ?? '',
            'username' => $user['username'] ?? '',
            'count_child_info' => $childInfo['count'] ?? 0,
            'flow_used' => $totalFlowUsed,
            'flow_limit' => $totalFlowLimit,
            'data_center_used' => $totalDcUsed,
            'data_center_limit' => $totalDcLimit,
            'list_child_preview' => $list->take(5)->toArray(), //Hiển thị ở tổng quan tối đa 5 rồi cho xem thêm
            'residential_text' => $totalFlowUsed > 0 ? number_format($totalFlowUsed,2).' GB / '. ($totalFlowLimit > 0 ? number_format($totalFlowLimit,2).' GB' : 0) : 0,
            'datacenter_text' => $totalDcUsed > 0 ? number_format($totalDcUsed,2).' GB / '. ($totalDcLimit > 0 ? number_format($totalDcLimit,2).' GB' : 0) : 0,
        ];
    }

    public function getChildInfo(string $token, $page = null, $size = null): array
    {
        $params = ['s' => $token];
        if (!is_null($page)) {
            $params['page'] = $page;
        }
        if (!is_null($size)) {
            $params['size'] = $size;
        }

        $res = $this->get('child_info', $params, $token);

        if (empty($res)) {
            return [
                'success' => false,
                'message' => 'Không thể kết nối đến hệ thống PIA Proxy. Vui lòng thử lại sau!'
            ];
        }

        if (!isset($res['success']) || !$res['success']) {
            return [
                'success' => false,
                'message' => $res['msg'] ?? 'Vui lòng ngắt kết nối PIA Proxy và đăng nhập lại!'
            ];
        }

        return ['success' => true, 'data' => $res['data']];
    }

    public function getResidentialFlowBalance(string $token): array
    {
        $params = ['s' => $token];
        $res = $this->get('proxy/residential/flow_balance', $params, $token);

        if (empty($res)) {
            return [
                'success' => false,
                'message' => 'Không thể kết nối đến hệ thống PIA Proxy. Vui lòng thử lại sau!'
            ];
        }

        if (!isset($res['success']) || !$res['success']) {
            return [
                'success' => false,
                'message' => $res['msg'] ?? 'Vui lòng ngắt kết nối PIA Proxy và đăng nhập lại!'
            ];
        }

        return ['success' => true, 'data' => $res['data']];
    }


    public function generateCdk(string $token, array $user, string $flow, string $number): array
    {
        return $this->put('cdk/flow', [
            's'     => $token,
            'username'    => $user['username'] ?? '',
            'number' => $number,
            'flow'    => $flow,
        ], $token);
    }

    public function exchangeCdk(string $token, array $user, string $cdk): array
    {
        return $this->post('cdk', [
            's'     => $token,
            'username'    => $user['username'] ?? '',
            'cdk' => $cdk,
        ], $token);
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

            $isSuccess = $response->successful() &&
                (($res['ret'] ?? -1) === 0 || ($res['code'] ?? -1) === 1 || ($res['msg'] ?? '') === 'success');

            if (!$isSuccess) {
                return ['success' => false, 'message' => $res['msg'] ?? 'Lỗi kết nối API PiaProxy.'];
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

            $isSuccess = $response->successful() &&
                (($res['ret'] ?? -1) === 0 || ($res['code'] ?? -1) === 1 || ($res['msg'] ?? '') === 'success');

            if (!$isSuccess) {
                return ['success' => false, 'message' => $res['msg'] ?? 'Lỗi kết nối API PiaProxy.'];
            }

            return ['success' => true, 'data' => $res['ret_data'] ?? $res['data'] ?? $res];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => "Lỗi HTTP Exception: {$e->getMessage()}"];
        }
    }

    protected function put(string $endpoint, array $params = [], ?string $token = null): array
    {
        try {
            $http = Http::asForm();

            if ($token) $http = $http->withToken($token);

            $response = $http->put("{$this->baseUrl}/{$endpoint}", $params);

            $res = $response->json() ?? [];

            $isSuccess = $response->successful() &&
                (($res['ret'] ?? -1) === 0 || ($res['code'] ?? -1) === 1 || ($res['msg'] ?? '') === 'success');

            if (!$isSuccess) {
                return ['success' => false, 'message' => $res['msg'] ?? 'Lỗi kết nối API PiaProxy.'];
            }

            return ['success' => true, 'data' => $res['ret_data'] ?? $res['data'] ?? $res];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => "Lỗi HTTP Exception: {$e->getMessage()}"];
        }
    }
}
