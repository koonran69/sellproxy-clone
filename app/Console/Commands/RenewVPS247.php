<?php

namespace App\Console\Commands;

use App\Models\Vps;
use App\Services\VPS\VPSService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenewVPS247 extends Command
{
    protected $signature = 'app:renew-v-p-s247';

    protected $description = 'Auto renew VPS';

    public function handle(VPSService $service): int
    {
        $startedAt = microtime(true);

        $endTime = Carbon::now('UTC')->addMinutes(5);

        $success = 0;
        $failed = 0;

        Vps::query()
            ->with('user')
            ->where('auto_renew', 1)
            ->where('partner_expired_at', '<=', $endTime)
            ->chunkById(100, function ($vpsList) use (
                $service,
                &$success,
                &$failed
            ) {
                foreach ($vpsList as $vps) {
                    try {
                        $service->renewVpsBySystem($vps, 1);

                        $success++;

                    } catch (\Throwable $e) {
                        $failed++;

                        // Giữ nguyên nghiệp vụ: lỗi thì tắt auto renew
                        try {
                            $vps->update([
                                'auto_renew' => 0,
                            ]);
                        } catch (\Throwable $updateException) {
                            Log::critical('Không thể tắt auto renew VPS', [
                                'vps_id' => $vps->id,
                                'message' => $updateException->getMessage(),
                            ]);
                        }

                        Log::error('Auto renew VPS failed', [
                            'vps_id' => $vps->id,
                            'message' => $e->getMessage(),
                        ]);

                        $this->error(
                            "Renew thất bại VPS #{$vps->id}"
                        );
                    }
                }
            });

        Log::info('Auto renew VPS completed', [
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
