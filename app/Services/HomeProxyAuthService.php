<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeProxyAuthService
{
    private string $base;
    private int $early;
    protected string $token;

    private const K_ACCESS  = 'hp:access_token';
    private const K_REFRESH = 'hp:refresh_token';
    private const K_EXPIRES = 'hp:expires_at';
    private const K_LOCK    = 'hp:token_lock';

    public function __construct()
    {
        $this->base  = rtrim(config('proxyhome.base_url'), '/');
        $this->early = (int) config('proxyhome.early_refresh_seconds', 60);
        $this->token   = env('HOMEPROXY_BEARER_TOKEN', '');
    }

    public function charge($amount)
    {
        $response = Http::withToken($this->token)
        ->acceptJson()
        ->post($this->base . '/api/merchant/transactions', [
            'amount' => (int) $amount
        ]);

        if ($response->successful())
        {
            return $response->object();
        }

        return null;

    }

    public function getMerchant()
    {
        $response = Http::withToken($this->token)
                ->acceptJson()
                ->get($this->base . '/api/merchant/merchants');

        if (!$response->ok()) {
            return null;
        }
        return $response->object()->data[0] ?? null;
    }

    public function getAccessToken(): string
    {
        $token  = Cache::get(self::K_ACCESS);
        $expIso = Cache::get(self::K_EXPIRES);
        if ($token && $expIso) {
            $exp = Carbon::parse($expIso);
            if (now()->lt($exp->copy()->subSeconds($this->early))) {
                return $token;
            }
        }

        $lock = Cache::lock(self::K_LOCK, 10);
        return $lock->block(10, function () {
            $token  = Cache::get(self::K_ACCESS);
            $expIso = Cache::get(self::K_EXPIRES);
            if ($token && $expIso && now()->lt(Carbon::parse($expIso)->subSeconds($this->early))) {
                return $token;
            }

            $refresh = Cache::get(self::K_REFRESH);
            if ($refresh) {
                try {
                    $res = Http::acceptJson()
                        ->withToken($refresh)
                        ->timeout(15)
                        ->post($this->base.'/api/v1/auth/refresh');

                    if ($res->successful()) {
                        $this->storeTokens($res->json());
                        return Cache::get(self::K_ACCESS);
                    }
                } catch (\Throwable $e) {
                    Log::warning('[HomeProxy] refresh token fail: '.$e->getMessage());
                }
            }

            return $this->loginAndReturnToken();
        });
    }

    private function loginAndReturnToken(): string
    {
        $phone = config('proxyhome.phone');
        $pass  = config('proxyhome.password');
        if (!$phone || !$pass) {
            throw new \RuntimeException('Thiếu HOMEPROXY_PHONE/HOMEPROXY_PASSWORD.');
        }

        $res = Http::acceptJson()
            ->timeout(15)
            ->post($this->base.'/api/admin/auth/login', [
                'phone'    => $phone,
                'password' => $pass,
            ]);

        if (!$res->successful()) {
            throw new \RuntimeException('HomeProxy login thất bại: HTTP '.$res->status());
        }

        $data = $res->json();
        $this->storeTokens($data);
        return Cache::get(self::K_ACCESS);
    }

    private function storeTokens(array $data): void
    {
        $token   = Arr::get($data, 'token');
        $refresh = Arr::get($data, 'refreshToken');
        $expRaw  = Arr::get($data, 'tokenExpires');

        $expiresAt = $this->parseExpires($expRaw) ?? now()->addSeconds((int)config('proxyhome.fallback_token_ttl'));

        Cache::put(self::K_ACCESS,  $token,   $expiresAt);
        if ($refresh) {
            Cache::put(self::K_REFRESH, $refresh, now()->addDays(7));
        }
        Cache::put(self::K_EXPIRES, $expiresAt->toIso8601String(), $expiresAt);
    }

    private function parseExpires($expRaw): ?Carbon
    {
        if (!is_numeric($expRaw)) return null;
        $n = (int) $expRaw;

        if ($n > 2_500_000_000) {
            return Carbon::createFromTimestampMs($n);
        }

        if ($n > now()->subDay()->timestamp) {
            return Carbon::createFromTimestamp($n);
        }

        return now()->addSeconds($n);
    }
}
