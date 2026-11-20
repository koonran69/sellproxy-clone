<?php

namespace App\Services\GetProxy;

use Illuminate\Support\Facades\Http;

class AbcProxyService
{
    protected string $baseUrl = 'http://43.153.36.127:8061/open/v1';

    public function connect(array $credentials): array
    {
        $res = $this->post('get_abc_sercret', [
            'username' => $credentials['username'] ?? '',
            'password' => $credentials['password'] ?? '',
        ]);

        if (!$res['success']) return $res;

        $appSecret = $res['data']['app_secret'] ?? null;

        if (!$appSecret) return ['success' => false, 'message' => 'Không tìm thấy app_secret.'];

        $res = $this->post('get_access_token', ['appsecret' => $appSecret]);

        if (!$res['success']) return $res;

        $token = $res['data']['access_token'] ?? null;

        if (!$token) return ['success' => false, 'message' => 'Không tìm thấy access_token.'];

        return ['success' => true, 'token' => $token];
    }

    public function getUserInfo(string $token, array $credentials = []): array
    {
        $params = array_filter([
            'username' => $credentials['username'] ?? null,
            'password' => $credentials['password'] ?? null
        ]);

        $res = $this->post('user_info', $params, $token);

        if (!$res['success'] || empty($res['data'])) return $res;

        $data = $res['data'];

        $mapping = [
            'wallet'          => ['balance', '$'],
            'all_buy'         => ['total_spent', '$'],
            'wallet_all_buy'  => ['total_bought', '$'],
            'flow_balance'    => ['traffic_remain', ' GB'],
            'flow_all_buy'    => ['traffic_total', ' GB'],
            'flow_used_today' => ['traffic_used_today', ' GB'],
            'ent_flow_balance' => ['ent_flow_balance', ' GB']
        ];

        $info = [
            'username'     => $data['username'] ?? '—',
            'email'        => $data['email'] ?? '—',
            'uid'          => $data['uid'] ?? '—',
            'dynamic_ip'   => $data['ips_balance'] ?? 0,
            'account_type' => ($data['user_type'] ?? '') == 2 ? 'Residential Proxies CDK' : 'Normal',
            'created_at'   => format_timestamp($data['created_at'] ?? null, 'd/m/Y'),
            'expiry'       => format_timestamp($data['flow_expire_time'] ?? null, 'd/m/Y'),
        ];

        foreach ($mapping as $apiKey => [$infoKey, $unit]) {

            $val = $data[$apiKey] ?? 0;

            $info[$infoKey] = $unit === '$' ? "$unit$val" : "$val$unit";
        }

        return ['success' => true, 'data' => $info];
    }

    public function subAccountList(string $token, int $page = 1, int $size = 10): array
    {
        return $this->post('sub_account_list', [
            'page' => (string) $page,
            'size' => (string) $size,
        ], $token);
    }

    public function addSubAccount(string $token, string $username, string $password, int $limit = 0): array
    {
        return $this->post('add_sub_account', [
            'username'   => $username,
            'password'   => $password,
            'limit_flow' => $limit,
        ], $token);
    }

    public function changeSubAccountState(string $token, string $id, int $status): array
    {
        return $this->post('change_sub_account_state', [
            'id'     => (string) $id,
            'status' => $status,
        ], $token);
    }

    public function deleteSubAccount(string $token, int $id): array
    {
        return $this->post('del_sub_account', [
            'id' => $id,
        ], $token);
    }

    public function updateSubAccount(string $token, string $username, string $password, int $state): array
    {
        return $this->post('update_sub_account', [
            'account'  => $username,
            'password' => $password,
            'state'    => (string) $state,
        ], $token);
    }

    public function generateCdk(string $token, string $num, string $cdkNum, string $type): array
    {
        return $this->post('generate_cdk', [
            'num'     => $num,
            'cdk_num' => $cdkNum,
            'type'    => $type,
        ], $token);
    }

    public function exchangeCdk(string $token, string $cdk): array
    {
        return $this->post('exchange_cdk', [
            'cdk' => $cdk,
        ], $token);
    }

    public function getCdkList(string $token, int $page = 1, int $size = 10, int $type = 2, ?string $cdk = null, ?int $status = null): array
    {
        $params = [
            'page' => (string) $page,
            'size' => (string) $size,
            'type' => $type,
        ];

        if ($cdk !== null) $params['cdk'] = $cdk;
        if ($status !== null) $params['status'] = $status;

        return $this->post('get_cdk_list', $params, $token);
    }

    public function getMultiTypeCdkList(string $token, array $types, int $page = 1, int $size = 50): array
    {
        $poolResults = Http::pool(fn($pool) => array_map(function ($type) use ($pool, $token, $page, $size) {

            return $pool->asForm()->withToken($token)
                ->post("{$this->baseUrl}/get_cdk_list", [
                    'page' => (string) $page,
                    'size' => (string) $size,
                    'type' => $type,
                ]);
        }, $types));

        $results = [];

        foreach ($types as $index => $type) {

            $response = $poolResults[$index];

            $res = $response->json() ?? [];

            $isSuccess = $response->successful() && (($res['ret'] ?? -1) === 0 || ($res['code'] ?? -1) === 1);

            if ($isSuccess) {

                $data = $res['ret_data'] ?? $res['data'] ?? $res;

                $results[$type] = ['success' => true, 'data' => $data];
            } else {
                $results[$type] = ['success' => false, 'message' => $res['msg'] ?? 'Error fetching type ' . $type];
            }
        }

        return $results;
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
                return ['success' => false, 'message' => $res['msg'] ?? 'Lỗi kết nối API ABCProxy.'];
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
                return ['success' => false, 'message' => $res['msg'] ?? 'Lỗi kết nối API ABCProxy.'];
            }

            return ['success' => true, 'data' => $res['ret_data'] ?? $res['data'] ?? $res];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => "Lỗi HTTP Exception: {$e->getMessage()}"];
        }
    }
}
