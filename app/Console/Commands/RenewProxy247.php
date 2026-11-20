<?php

namespace App\Console\Commands;

use App\Models\ProxySellvps247;
use App\Services\VPS\VPSService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenewProxy247 extends Command
{
    protected $signature = 'app:renew-proxy247';

    protected $description = 'Auto renew Proxy 247';

    public function handle(VPSService $service): int
    {
        $startedAt = microtime(true);
        $endTime = now('UTC')->addMinutes(5);

        $success = 0;
        $failed = 0;

        ProxySellvps247::query()
            ->with('user')
            ->where('auto_renew', 1)
            ->where('partner_expired_at', '<=', $endTime)
            ->chunkById(100, function ($proxies) use (
                $service,
                &$success,
                &$failed
            ) {
                foreach ($proxies as $proxy) {
                    try {
                        $service->renewProxyBySystem($proxy, 1);

                        $success++;

                        $this->info(
                            "Renew thành công Proxy #{$proxy->id}"
                        );
                    } catch (\Throwable $e) {
                        $failed++;

                        // Giữ nguyên nghiệp vụ: lỗi thì tắt auto renew
                        try {
                            $proxy->update([
                                'auto_renew' => 0,
                            ]);
                        } catch (\Throwable $updateException) {
                            Log::critical('Không thể tắt auto renew Proxy 247', [
                                'proxy_id' => $proxy->id,
                                'message' => $updateException->getMessage(),
                            ]);
                        }

                        Log::error('Auto renew Proxy 247 failed', [
                            'proxy_id' => $proxy->id,
                            'message' => $e->getMessage(),
                            'exception' => $e,
                        ]);

                        $this->error(
                            "Renew thất bại Proxy #{$proxy->id} (tắt auto renew)"
                        );
                    }
                }
            });

        Log::info('Auto renew Proxy 247 completed', [
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
