<?php

namespace App\Console\Commands;

use App\Models\ProxyHomeProxy;
use App\Services\ProxyStaticOrderService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenewProxyHome extends Command
{
    protected $signature = 'app:renew-proxy-home';

    protected $description = 'Auto renew Proxy Home';

    public function handle(ProxyStaticOrderService $service): int
    {
        $startedAt = microtime(true);

        $nowUTC = Carbon::now('UTC');
        $renewBefore = $nowUTC->copy()->addHours(2);

        $success = 0;
        $failed = 0;

        ProxyHomeProxy::query()
            ->with(['user', 'order'])
            ->where('auto_renew', 1)
            ->whereBetween('expired_at', [$nowUTC, $renewBefore])
            ->chunkById(100, function ($proxies) use (
                $service,
                &$success,
                &$failed
            ) {
                foreach ($proxies as $proxy) {
                    try {
                        $service->renewProxyBySystem($proxy);

                        $success++;
                    } catch (\Throwable $e) {
                        $failed++;

                        // Giữ nguyên nghiệp vụ: lỗi thì tắt auto renew
                        try {
                            $proxy->update([
                                'auto_renew' => 0,
                            ]);
                        } catch (\Throwable $updateException) {
                            Log::critical('Không thể tắt auto renew', [
                                'proxy_id' => $proxy->id,
                                'message' => $updateException->getMessage(),
                            ]);
                        }

                        Log::error('Auto renew Proxy Home failed', [
                            'proxy_id' => $proxy->id,
                            'message' => $e->getMessage(),
                        ]);

                        $this->error(
                            "Renew thất bại Proxy Home #{$proxy->id}"
                        );
                    }
                }
            });

        Log::info('Auto renew Proxy Home completed', [
            'success' => $success,
            'failed' => $failed,
            'duration_seconds' => round(
                microtime(true) - $startedAt,
                2
            ),
        ]);

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
