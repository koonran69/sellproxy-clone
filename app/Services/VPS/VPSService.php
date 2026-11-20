<?php

namespace App\Services\VPS;

use App\Core\Enums\Transaction\TransactionStatus;
use App\Models\ProxySellvps247;
use App\Models\Transaction;
use App\Models\Vps;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VPSService
{
    static $endpointListRegion = 'api/plan/region';
    static $endpointListPackageOfRegion = 'api/plan/vps';
    static $endpointListPackageGPU = 'api/plan/gpu';
    static $endpointSupportPlan = 'api/server/vps/support';
    static $endpointSupportGPU = 'api/server/gpu/support';
    static $endpointCalculate = 'api/server/create/calculate';
    static $endpointmakeOrder = 'api/server/create';
    static $endpointVpsinfo = 'api/server/info';
    static $endpointStatusAutoRenew = 'api/server/auto-renew';
    static $endpointGetUpgradePlan = 'api/server/upgrade/plans';
    static $endpointUpgradeCalculate = 'api/server/upgrade/calculate';
    static $endpointUpgradePlan = 'api/server/upgrade';
    static $endpointGetChangeIP = 'api/server/change-ip-params';
    static $endpointChangeIP = 'api/server/change-ip';
    static $endpointReboot = 'api/server/reboot';
    static $endpointPause = 'api/server/pause';
    static $endpointAutoFix = 'api/server/auto-fix';
    static $endpointRenewCalculate = 'api/server/renew/calculate';
    static $endpointRenew = 'api/server/renew';
    static $endpointSupportOS = 'api/server/vps/support/os';
    static $endpointReInstall = 'api/server/reinstall';

    //=======================proxy======================
    static $endpointProxySupport = 'api/server/proxy/support';

    protected string $host_api_server;
    protected string $host_api;
    protected string $clientId;
    protected string $username;
    protected string $password;

    protected $auth;
    const CACHE_VPS_REGIONS = 'vps_get_regions';
    const CACHE_VPS_PACKAGES_OF_REGION = 'vps_get_packages_of_region';
    const CACHE_VPS_PACKAGES_GPU = 'vps_get_packages_gpu';

    public function __construct(AuthTokenService $authService)
    {
        $this->host_api_server = config('core.vps_key.host_api_server');
        $this->host_api = config('core.vps_key.host_api');
        $this->clientId = config('core.vps_key.client_id');
        $this->username = config('core.vps_key.api_account_username');
        $this->password = config('core.vps_key.api_account_password');

        $this->auth = $authService;
    }
    //============================PROXY==========================

    public function proxyCalculate($payload = [])
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointCalculate;
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    public function proxySupport($nation, $state=null, $isp=null)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointProxySupport;
        $query = http_build_query(['nation'=>$nation,'state'=>$state,'isp'=>$isp]);
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint ."?". $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    //============================VPS==========================
    public function reSetting($data = [])
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointReInstall;
        $payload = $data;

        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function supportOS($is_gpu = false)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointSupportOS;
        $query = $is_gpu ? '?' . http_build_query(['country'=>'GPU']) : '';
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function renewVPS($sid, $month)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointRenew;
        $payload = ['month' => $month, 'sid' => $sid];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function renewCalculate($sid, $month)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointRenewCalculate;
        $payload = ['month' => $month, 'sid' => $sid];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function autoFixError($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointAutoFix;
        $payload = ['sid' => $vps_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function pause($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointPause;
        $payload = ['sid' => $vps_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function reboot($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointReboot;
        $payload = ['sid' => $vps_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function changeIP($data = [])
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointChangeIP;
        $payload = $data;
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function getChangeIP($ip, $isp = null, $has_state = null)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointGetChangeIP;
        $query = http_build_query(['ip' => $ip, 'isp' => $isp, 'has_state' => $has_state]);
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . '?' . $query);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function upgradeVPS($vps_id, $plan_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointUpgradePlan;
        $payload = ['sid' => $vps_id, 'plan_id' => $plan_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            Log::error(json_encode($response->body()));
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function upgradeCalculate($vps_id, $plan_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointUpgradeCalculate;
        $payload = ['sid' => $vps_id, 'plan_id' => $plan_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function getUpgradePlan($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointGetUpgradePlan;
        $payload = ['sid' => $vps_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function statusAutoRenew($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointStatusAutoRenew;
        $payload = ['sid' => $vps_id];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("error: " . $response->body());
        }
        return $response->json();
    }

    public function vpsInfo($vps_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointVpsinfo;
        $query = http_build_query(['sid' => $vps_id]);
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . '?' . $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function makeOrder($data = [])
    {
        $data['auto_renew'] = false; //luôn luôn tắt auto renew qua bên gốc
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointmakeOrder;
        $payload = array_filter($data, function ($value) {
            // Loại bỏ nếu là null hoặc ""
            return !is_null($value) && $value !== '';
        });
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            Log::error(json_encode($response->body()));
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function calculate($coupon, $duration, $plan_id, $quantity = 0)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointCalculate;
        $payload = ['coupon' => $coupon, 'duration' => $duration, 'plan_id' => $plan_id, 'quantity' => $quantity];
        $response = Http::withHeaders($this->headers($token))
            ->post($this->host_api_server . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function supportGPU($plan_id)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointSupportGPU;
        $query = http_build_query(['plan_id' => $plan_id]);
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . '?' . $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function supportPlan($plan_id, $state = null, $provider = null)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointSupportPlan;
        if ($state) {
            $query = http_build_query(['plan_id' => $plan_id, 'state' => $state]);
        } elseif ($provider) {
            $query = http_build_query(['plan_id' => $plan_id, 'provider' => $provider]);
        } else {
            $query = http_build_query(['plan_id' => $plan_id]);
        }
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . '?' . $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function getPackageGPU()
    {
        return Cache::rememberForever(self::CACHE_VPS_PACKAGES_GPU, function () {
            $token = $this->auth->getAccessToken();
            $endpoint = self::$endpointListPackageGPU;
            $response = Http::withHeaders($this->headers($token))
                ->get($this->host_api_server . $endpoint);
            if (!$response->successful()) {
                throw new Exception("Error: " . $response->body());
            }
            return $response->json();
        });
    }
    //Lấy packages và tính giá phải thanh toán lại luôn lưu cache để load web không chậm
    public function getPackageWithPrice($nation)
    {
        $cacheKey = "vps_packages_with_price_{$nation}";
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($nation) {
            $packages = $this->getPackageOfNation($nation);
            foreach ($packages as &$package) {
                $res = $this->calculate("", 1, $package['id'], 1);
                $package['price'] = $res['must_pay'] ?? 0;
            }
            return $packages;
        });
    }
    public function getPackageOfNation($nation)
    {
        $token = $this->auth->getAccessToken();
        $endpoint = self::$endpointListPackageOfRegion;
        $query = http_build_query(['region' => $nation]);
        $response = Http::withHeaders($this->headers($token))
            ->get($this->host_api_server . $endpoint . '?' . $query);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }

    public function listRegion()
    {
        return Cache::rememberForever(self::CACHE_VPS_REGIONS, function () {
            $token = $this->auth->getAccessToken();
            $endpoint = self::$endpointListRegion;
            $response = Http::withHeaders($this->headers($token))
                ->asForm()
                ->get($this->host_api_server . $endpoint);

            if (!$response->successful()) {
                throw new Exception("Error: " . $response->body());
            }

            return $response->json();
        });
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

    public function renewProxyBySystem($proxy, $month = 1)
    {
        $user = $proxy->user;

        if (!$user) {
            throw new \RuntimeException("Proxy {$proxy->id} không có user");
        }

        $getPriceRenewRes = $this->renewCalculate($proxy->proxy_id, $month);
        $getPriceRenew = $getPriceRenewRes['result']['success'][$proxy->ip];

        $finalPrice = floatval(str_replace([',', ' VND'], '', $getPriceRenew['expense']));

        if ($user->available_balance < $finalPrice) {
            throw new \RuntimeException("User {$user->id} không đủ tiền");
        }

        $new_expired_day = date('Y-m-d', strtotime($getPriceRenew['new_expired_day']));
        $old_time_expired = date('H:i:s', strtotime($proxy->partner_expired_at));
        $expired_at = $new_expired_day . ' ' . $old_time_expired;

        $res_make_order = $this->renewVPS($proxy->proxy_id, $month);
        $make_order = $res_make_order['result']['success'][$proxy->ip];

        DB::beginTransaction();
        try {
            $user->update([
                'available_balance' => $user->available_balance - $finalPrice,
                'balance' => $user->balance - $finalPrice,
                'updated_at' => now(),
            ]);

            $proxy->update([
                'price' => $finalPrice,
                'partner_expired_at' => $expired_at,
                'amount_before' => floatval(str_replace([',', ' VND'], '', $make_order['old_balance'])),
                'amount_last' => floatval(str_replace([',', ' VND'], '', $make_order['new_balance'])),
                'partner_server_info_response' => json_encode($res_make_order),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'code' => 'PROXY' . uniqid(),
                'amount' => -$finalPrice,
                'status' => TransactionStatus::Paid,
                'reference_id' => $proxy->id,
                'reference_type' => ProxySellvps247::class,
                'note' => 'Tự động gia hạn Proxy #' . $proxy->id
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function renewVpsBySystem($vps, $month = 1)
    {
        $user = $vps->user;

        $getPriceRenewRes = $this->renewCalculate($vps->vps_id, $month);
        $getPriceRenew = $getPriceRenewRes['result']['success'][$vps->ip];

        $expense = floatval(str_replace([',', ' VND'], '', $getPriceRenew['expense']));
        $finalPrice = $expense + ($expense * config('app.fee_percent') / 100);

        if ($user->available_balance < $finalPrice) {
            throw new \RuntimeException("User {$user->id} không đủ tiền");
        }

        $new_expired_day = date('Y-m-d', strtotime($getPriceRenew['new_expired_day']));
        $old_time_expired = date('H:i:s', strtotime($vps->partner_expired_at));
        $expired_at = $new_expired_day . ' ' . $old_time_expired;

        $res_make_order = $this->renewVPS($vps->vps_id, $month);
        $make_order = $res_make_order['result']['success'][$vps->ip];

        DB::beginTransaction();
        try {
            $user->update([
                'available_balance' => $user->available_balance - $finalPrice,
                'balance' => $user->balance - $finalPrice,
                'updated_at' => now(),
            ]);

            $vps->update([
                'price' => $finalPrice,
                'partner_expired_at' => $expired_at,
                'amount_before' => floatval(str_replace([',', ' VND'], '', $make_order['old_balance'])),
                'amount_last' => floatval(str_replace([',', ' VND'], '', $make_order['new_balance'])),
                'partner_server_info_response' => json_encode($res_make_order),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'code' => 'VPS' . uniqid_real(6),
                'amount' => -$finalPrice,
                'status' => TransactionStatus::Paid,
                'reference_id' => $vps->id,
                'reference_type' => Vps::class,
                'note' => 'Tự động gia hạn VPS #' . $vps->id
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
