<?php

namespace App\Services\VPS;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;

class AuthTokenService
{

    static $endpointLoginToken    = 'api/token'; //Login
    static $endpointRefreshToken    = 'o/token/'; //Refresh
    protected string $host_api_server;
    protected string $host_api;
    protected string $clientId;
    protected string $username;
    protected string $password;

    const CACHE_KEY = 'vps_auth_token';

    public function __construct()
    {
        $this->host_api_server = config('core.vps_key.host_api_server');
        $this->host_api = config('core.vps_key.host_api');
        $this->clientId = config('core.vps_key.client_id');
        $this->username = config('core.vps_key.api_account_username');
        $this->password = config('core.vps_key.api_account_password');
    }

    /**
     * Lấy access token (tự refresh nếu cần)
     */
    public function getAccessToken()
    {
        $token = Cache::get(self::CACHE_KEY);

        if ($token && now()->lt($token['expires_at'])) {
            return $token['access_token'];
        }

        if ($token && isset($token['refresh_token'])) {
            return $this->refreshToken($token['refresh_token']);
        }

        return $this->login();
    }
    /**
     * Refresh token khi hết hạn
     */
    protected function refreshToken(string $refreshToken)
    {

        $response = Http::asForm()->post($this->host_api_server . self::$endpointRefreshToken, [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id'     => $this->clientId,
        ]);

        if (!$response->successful()) {
            // Nếu refresh fail → login lại
            return $this->login();
        }

        return $this->storeToken($response->json());
    }

    /**
     * Gọi API login và lưu cache
     */
    protected function login()
    {
        $response = Http::asForm()->post($this->host_api_server . self::$endpointLoginToken, [
            'grant_type' => 'password',
            'username' => $this->username,
            'password' => $this->password,
            'client_id' => $this->clientId,
        ]);

        if (!$response->successful()) {
            throw new Exception("Login VPS API error: " . $response->body());
        }

        $data = $response->json();
        return $this->storeToken($data);
    }

    /**
     * Lưu token vào cache
     */
    protected function storeToken(array $data)
    {
        $accessToken  = $data['access_token'];
        $refreshToken = $data['refresh_token'] ?? null;
        $expiresIn    = $data['expires_in']; // giây

        $expiresAt = now()->addSeconds($expiresIn - 60); // trừ 60s tránh sai số

        Cache::put(self::CACHE_KEY, [
            'access_token'  => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_at'    => $expiresAt,
        ], $expiresIn - 60);

        return $accessToken;
    }
}

