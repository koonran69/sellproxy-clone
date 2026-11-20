<?php

namespace App\Services\VPS;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProxyService
{

    protected string $host_api_server;
    protected string $host_api;
    protected string $clientId;
    protected string $username;
    protected string $password;

    protected $auth;
    const CACHE_VPS_REGIONS = 'vps_get_regions';
    public function __construct(AuthTokenService $authService)
    {
        $this->host_api_server = config('core.vps_key.host_api_server');
        $this->host_api = config('core.vps_key.host_api');
        $this->clientId = config('core.vps_key.client_id');
        $this->username = config('core.vps_key.api_account_username');
        $this->password = config('core.vps_key.api_account_password');

        $this->auth = $authService;
    }

    /** Headers dùng chung */
    protected function headers($token): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
    }
}
