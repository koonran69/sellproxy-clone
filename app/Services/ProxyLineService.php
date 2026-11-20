<?php

namespace App\Services;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use App\Core\Repositories\Order\OrderRepositoryInterface;
use App\Models\MemberLevel;
use App\Models\Order;
use App\Models\ProxyInstance;
use App\Models\ProxyPackage;
use App\Models\Setting;
use App\Models\User;
use App\Models\VietqrBank;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProxyLineService
{
    public function placeOrderToProxyline(array $params): array
    {
        $apiKey = config('core.proxy_line_api_key');

        $payload = [
            'type' => $params['type'],
            'ip_version' => $params['ip_version'],
            'country' => $params['country'],
            'period' => $params['period'],
        ];

        if(isset($params['ip_list']) && is_array($params['ip_list'])) {
            $payload['ip_list'] = $params['ip_list'];
        } else {
            $payload['quantity'] = $params['quantity'];
        }

        if(isset($params['tags']) && is_array($params['tags'])) {
            $payload['tags'] = $params['tags'];
        }

        $response = Http::post("https://panel.proxyline.net/api/new-order/?api_key={$apiKey}", $payload);

        if (!$response->successful()) {
            throw new \Exception('ProxyLine API error: ' . $response->body());
        }
        \Log::info('proxy response', [$response->json()]);
        return $response->json();
    }

    public function orderAmount($ip_type, $ip_version, $quantity, $country, $period)
    {
        $tiers = ProxyPackage::where('proxy_type_id', $ip_type)
            ->where('ip_version_id', $ip_version)
            ->where('min_quantity', '<=', $quantity)
            ->where('max_quantity', '>=', $quantity)
            ->whereHas('countries', function ($q) use ($country) {
                $q->where('country_id', $country);
            })
            ->orderByDesc('duration_days')
            ->get();

        $tier = $tiers->firstWhere(fn($t) => $t->duration_days <= $period);

        return $tier;
    }

    public function storeProxiesFromResponse(array $response, int $internalOrderId): void
    {
        foreach ($response as $item) {
            ProxyInstance::create([
                'proxy_order_id' => $internalOrderId,
                'proxyline_id' => $item['id'],
                'ip' => $item['ip'],
                'internal_ip' => $item['internal_ip'],
                'port_http' => $item['port_http'],
                'port_socks5' => $item['port_socks5'],
                'username' => $item['username'] ?? $item['user'],
                'password' => $item['password'],
                'country_code' => $item['country'],
                'type' => (int) $item['type'],
                'ip_version' => (int) $item['ip_version'],
                'order_id' => $item['order_id'],
                'date_start' => $item['date'],
                'date_end' => $item['date_end'],
                'raw_data' => $item,
            ]);
        }
    }

    public function reNewOrder(array $params): array
    {
        $apiKey = config('core.proxy_line_api_key');

        $response = Http::post("https://panel.proxyline.net/api/renew/?api_key={$apiKey}", [
            'proxies' => $params['proxies'],
            'period' => $params['period'],
        ]);

        if (!$response->successful()) {
            throw new \Exception('ProxyLine reNewOrder API error: ' . $response->body());
        }
        \Log::info('proxy reNewOrder', [$response->json()]);
        return $response->json();
    }

    public function ipList(array $params): array
    {
        $apiKey = config('core.proxy_line_api_key');

        $response = Http::get("https://panel.proxyline.net/api/ips/?api_key=$apiKey&ip_version={$params['ip_version']}&type={$params['type']}&country={$params['country']}");

        if (!$response->successful()) {
            throw new \Exception('ipList error: ' . $response->body());
        }

        \Log::info('ipList', [$response->json()]);
        return $response->json();
    }

    public function tags(): array
    {
        $apiKey = config('core.proxy_line_api_key');

        $response = Http::get("https://panel.proxyline.net/api/tags/?api_key={$apiKey}");

        if (!$response->successful()) {
            throw new \Exception('tags error: ' . $response->body());
        }
        return $response->json();
    }
}
