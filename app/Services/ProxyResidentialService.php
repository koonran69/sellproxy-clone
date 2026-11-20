<?php

namespace App\Services;

use App\Models\ProxyResidentialProxy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ProxyResidentialService
{
    static $endpointListServices     = 'v2/order';
    static $endpointServiceDetails   = 'v2/order/:serviceId';
    static $endpointPriceDetails     = 'v2/order/:serviceId/price';
    static $endpointMakeAnOrder      = 'v2/order/:serviceId/execute';

    static $endpointOrderDetail    = 'orders/:id';
    static $endpointProxiesThisOrder     = 'orders/:id/proxies';
    static $endpointRotateIP     = 'proxies/:id/rotate-ip';
    static $endpointdetailProxy     = 'proxies/:id';
    static $endpointdetailProxyV2     = 'services/proxies/:id';  //check trên trang bên thứ 3 chứ docx api không có
    static $endpointChangeAuthProxy    = 'proxies/:id/regenerate-credentials';
    static $endpointChangeProtocol    = 'proxies/:id/change-protocol';
    static $endpointCalculatePeriodExtensionPrice    = 'proxies/:id/period-extension-price';
    static $endpointExtendProxy = 'proxies/:id/extend-period';

    protected string $host;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct()
    {
        $this->host = config('core.proxy_residential_key.host');
        $this->apiKey = config('core.proxy_residential_key.api_key');
        $this->apiSecret = config('core.proxy_residential_key.api_secret_key');
    }
    public function extendProxy($proxy, $month){
        $endpoint = str_replace(':id', $proxy->proxy_id, self::$endpointExtendProxy);

        $payload = ['periodInMonths' => $month];

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint,$payload);

        if (!$response->successful()) {
            Log::error(json_encode($response->body()));
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    public function calculatePeriodExtensionPrice(string $proxy_id,int $periodInMonths)
    {
        $endpoint = str_replace(':id', $proxy_id, self::$endpointCalculatePeriodExtensionPrice);
        $payload = ['periodInMonths' => $periodInMonths];

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint,$payload);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    public function detailService(string $serviceId, string $planId = null, $withMetadata = true){
        $endpoint = str_replace(':serviceId', $serviceId, self::$endpointServiceDetails);
        if ($withMetadata) {
            $endpoint .= '?withMetadata=true';
        }

        if(empty($planId)) $planId = null;
        $payload = ['planId' => $planId];

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint,$payload);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    public function changeProtocol($proxy, $protocol){
        $endpoint = str_replace(':id', $proxy->proxy_id, self::$endpointChangeProtocol);

        $payload = ['newType' => $protocol];

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint,$payload);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        $getDetail = $this->proxyDetailV2($proxy->proxy_id);

        if($getDetail){
            $proxy->update([
                'proxy_status' => $getDetail['status'],
                'networkType' => $getDetail['networkType'],
                'authentication' => $getDetail['authentication'],
                'username' => $getDetail['authentication']['username'],
                'password' => $getDetail['authentication']['password'],
                'connection' => $getDetail['connection'],
                'publicIp' => $getDetail['connection']['publicIp'],
                'connectIp' => $getDetail['connection']['connectIp'],
                'httpPort' => $getDetail['connection']['httpPort'],
                'httpsPort' => $getDetail['connection']['httpsPort'],
                'ipVersion' => $getDetail['connection']['ipVersion'],
                'socks5Port' => $getDetail['connection']['socks5Port'],
                'hostnames' => $getDetail['connection']['hostnames'] ?? null,
                'proxyType' => $getDetail['proxyType'],
                'partner_createdAt' => Carbon::parse($getDetail['createdAt'])->format('Y-m-d H:i:s'),
                'partner_expiresAt' => Carbon::parse($getDetail['expiresAt'])->format('Y-m-d H:i:s'),
                'metadata' => $getDetail['metadata'],
                'partner_proxies_response' => $getDetail,
            ]);
            return true;
        }
        return false;
    }
    public function changeAuthProxy($proxy){
        $endpoint = str_replace(':id', $proxy->proxy_id, self::$endpointChangeAuthProxy);

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        $getDetail = $this->proxyDetailV2($proxy->proxy_id);
        if($getDetail){
            $proxy->update([
                'proxy_status' => $getDetail['status'],
                'networkType' => $getDetail['networkType'],
                'authentication' => $getDetail['authentication'],
                'username' => $getDetail['authentication']['username'],
                'password' => $getDetail['authentication']['password'],
                'connection' => $getDetail['connection'],
                'publicIp' => $getDetail['connection']['publicIp'],
                'connectIp' => $getDetail['connection']['connectIp'],
                'httpPort' => $getDetail['connection']['httpPort'],
                'httpsPort' => $getDetail['connection']['httpsPort'],
                'ipVersion' => $getDetail['connection']['ipVersion'],
                'socks5Port' => $getDetail['connection']['socks5Port'],
                'hostnames' => $getDetail['connection']['hostnames'] ?? null,
                'proxyType' => $getDetail['proxyType'],
                'partner_createdAt' => Carbon::parse($getDetail['createdAt'])->format('Y-m-d H:i:s'),
                'partner_expiresAt' => Carbon::parse($getDetail['expiresAt'])->format('Y-m-d H:i:s'),
                'metadata' => $getDetail['metadata'],
                'partner_proxies_response' => $getDetail,
            ]);
            return true;
        }
        return false;
    }
    public function proxyDetailV2(string $id){
        $endpoint = str_replace(':id', $id, self::$endpointdetailProxyV2);
        $response = Http::withHeaders($this->headers())->get($this->host . $endpoint);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        return $response->json();
    }
    public function proxyDetail(string $id){
        $endpoint = str_replace(':id', $id, self::$endpointdetailProxy);
        $response = Http::withHeaders($this->headers())->get($this->host . $endpoint);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        return $response->json();
    }
    public function syncProxy($proxy)
    {
        $endpoint = str_replace(':id', $proxy->proxy_id, self::$endpointRotateIP);
        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

       //Gọi lấy lại thông tin proxy detail để update lại vì $response gọi thành công không trả dữ liệu về
        $getDetail = $this->proxyDetailV2($proxy->proxy_id);
        if($getDetail){
            $proxy->update([
                'proxy_status' => $getDetail['status'],
                'networkType' => $getDetail['networkType'],
                'authentication' => $getDetail['authentication'],
                'username' => $getDetail['authentication']['username'],
                'password' => $getDetail['authentication']['password'],
                'connection' => $getDetail['connection'],
                'publicIp' => $getDetail['connection']['publicIp'],
                'connectIp' => $getDetail['connection']['connectIp'],
                'httpPort' => $getDetail['connection']['httpPort'],
                'httpsPort' => $getDetail['connection']['httpsPort'],
                'ipVersion' => $getDetail['connection']['ipVersion'],
                'socks5Port' => $getDetail['connection']['socks5Port'],
                'hostnames' => $getDetail['connection']['hostnames'] ?? null,
                'proxyType' => $getDetail['proxyType'],
                'partner_createdAt' => Carbon::parse($getDetail['createdAt'])->format('Y-m-d H:i:s'),
                'partner_expiresAt' => Carbon::parse($getDetail['expiresAt'])->format('Y-m-d H:i:s'),
                'metadata' => $getDetail['metadata'],
                'partner_proxies_response' => $getDetail,
            ]);

            return true;
        }
        return $getDetail;
    }
    public function proxiesThisOrder(string $idOrder){
        $endpoint = str_replace(':id', $idOrder, self::$endpointProxiesThisOrder);
        $response = Http::withHeaders($this->headers())->get($this->host . $endpoint);

        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        return $response->json();
    }
    public function makeAnOrder(string $serviceId, string $planId = null, int $traffic = 0, string $country = null, string $isp = null, int $quantity = 0, int $months = 0, string $packageId = null, bool $isEnabled = false): array
    {
        $endpoint = str_replace(':serviceId', $serviceId, self::$endpointMakeAnOrder);

        if($traffic > 0){
            $payload = [
                'traffic' => $traffic,
                'autoExtend' => [
                    "isEnabled" => $isEnabled
                ]
            ];
        }elseif($packageId){
            $payload = [
                'packageId'=> $packageId,
                'period' => [
                    'value' => $months,
                    'unit'  => 'months'
                ],
                'autoExtend' => [
                    "isEnabled" => $isEnabled
                ]
            ];
        }else{
            $payload = [
                'planId' => $planId,
                'country' => $country,
                'ispId' => $isp,
                'quantity' => $quantity,
                'period' => [
                    'value' => $months,
                    'unit'  => 'months'
                ],
                'autoExtend' => [
                    "isEnabled" => $isEnabled
                ]
            ];
        }
        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint, $payload);
        if (!$response->successful()) {
            Log::error(json_encode($response->body()));
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    public function getPrice(string $serviceId, string $planId = null, int $traffic = 0, string $country = null, string $isp = null, int $quantity = 0, int $months = 0, string $package = null, $withMetadata = true): array
    {
        $endpoint = str_replace(':serviceId', $serviceId, self::$endpointPriceDetails);
        if ($withMetadata) {
            $endpoint .= '?withMetadata=true';
        }

        if($traffic > 0){
            $payload = [
                'traffic' => $traffic,
            ];
        }elseif($package){
            $payload = [
                'packageId'=> $package,
                'period' => [
                    'value' => $months,
                    'unit'  => 'months'
                ],
            ];
        }else{
            $payload = [
                'planId' => $planId,
                'country' => $country,
                'ispId' => $isp,
                'quantity' => $quantity,
                'period' => [
                    'value' => $months,
                    'unit'  => 'months'
                ],
            ];
        }

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }
        return $response->json();
    }
    /** Lấy toàn bộ dịch vụ */
    public function getAllServices($withMetadata = true, $withNonOrderable = true): array
    {
        $endpointListServices = self::$endpointListServices;
        $params = [];

        if ($withMetadata) {
            $params[] = 'withMetadata=true';
        }
        if ($withNonOrderable) {
            $params[] = 'withNonOrderable=true';
        }

        if (!empty($params)) {
            $endpointListServices .= '?' . implode('&', $params);
        }

        $response = Http::withHeaders($this->headers())
            ->get($this->host . $endpointListServices);

        if (!$response->successful()) {
            throw new Exception('Error: ' . $response->body());
        }

        return $response->json();
    }

    /**Gọi song song chi tiết & giá plan */
    public function getServiceFullData(string $serviceId, string $planId, bool $withMetadata = true, string $country = null, array $period = ['unit' => 'months', 'value' => 1]): array
    {
        $endpointDetails = str_replace(':serviceId', $serviceId, self::$endpointServiceDetails);
        $endpointPrice   = str_replace(':serviceId', $serviceId, self::$endpointPriceDetails);

        if ($withMetadata) {
            $endpointDetails .= '?withMetadata=true';
        }

        $payloadDetails = ['planId' => $planId];
        $payloadPrice   = [
            'planId'   => $planId,
            'quantity' => 1,
            'country'  => $country,
            'period'   => $period,
        ];

        $responses = Http::pool(fn ($pool) => [
            $pool->as('details')->withHeaders($this->headers())->post($this->host . $endpointDetails, $payloadDetails),
            $pool->as('price')->withHeaders($this->headers())->post($this->host . $endpointPrice, $payloadPrice),
        ]);

        return [
            'info'  => $responses['details']->json() ?? [],
            'price' => $responses['price']->json() ?? [],
        ];
    }

    /**Lấy giá cho các service không có plan */
    public function getSimpleServicePrice(string $serviceId, array $payload = [], bool $withMetadata = true): array
    {
        $endpoint = str_replace(':serviceId', $serviceId, self::$endpointPriceDetails);
        if ($withMetadata) {
            $endpoint .= '?withMetadata=true';
        }

        $response = Http::withHeaders($this->headers())->post($this->host . $endpoint, $payload);
        if (!$response->successful()) {
            throw new Exception("Error: " . $response->body());
        }

        return $response->json();
    }

    /** Headers dùng chung */
    protected function headers(): array
    {
        return [
            'Content-Type'   => 'application/json',
            'Accept'         => 'application/json',
            'X-Api-Key'      => $this->apiKey,
            'X-Api-Secret'   => $this->apiSecret,
        ];
    }
}
