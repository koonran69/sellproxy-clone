<?php

namespace App\Services;

use App\Models\ProxyHomeOrder;
use App\Models\ProxyHomeProxy;
use Illuminate\Support\Facades\Http;

class ProxyHomePricingService
{
    public function unitPrice(string $provider): int
    {
        $map = config('proxyhome.unit_prices', []);
        return (int)($map[strtoupper($provider)] ?? 0);
    }

    //Update tính renew theo giá mua
    public function totalForProxies($proxies, int $days = 1): array
    {
        $days = max(1, (int)$days);
        $proxies = collect($proxies);

        $breakdown = [];
        $total = 0;
        $unitPrices = config('proxyhome.unit_price_static', []);

        foreach ($proxies as $p) {
            if($days > 30)
            {
                $add = $days - 30;
                $unit = $unitPrices[30] + (600 * $add);
            }else {
                $unit = $unitPrices[$days];
            }
            if ($unit === null) {
                throw new \RuntimeException('Không tìm thấy đơn giá cho nhà mạng');
            }

            $provider = strtoupper($p->provider ?? '');
//            $unit = $this->unitPrice($provider);
//            $sum  = $unit * $days;
//            $total += $sum;
            $total += $unit;

            $breakdown[] = [
                'proxy_id' => (int)$p->id,
                'provider' => $provider,
                'unit'     => $unit,
                'months'   => $days,
                'sum'      => $unit,
            ];
        }

        return ['total' => $total, 'breakdown' => $breakdown];
    }
}
