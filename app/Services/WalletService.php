<?php

namespace App\Services;

use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function checkAndDebit(int $userId, int $amount, array $meta = []): bool
    {
        return DB::transaction(function () use ($userId, $amount, $meta) {
            $user = DB::table('users')->where('user_id', $userId)->lockForUpdate()->first();

            if (!$user) {
                throw new \RuntimeException('Không tìm thấy người dùng');
            }
            if ($user->available_balance < $amount) {
                return false;
            }

            DB::table('users')->where('user_id', $userId)->update([
                'available_balance' => $user->available_balance - $amount,
                'balance' => $user->balance - $amount,
                'updated_at' => now(),
            ]);

            Transaction::create([
                'code' => 'PRX' . uniqid_real(6),
                'amount' => $amount,
                'status' => TransactionStatus::Paid,
                'reference_id' => $meta['order_id'],
                'reference_type' => ReferenceType::OrderProxyHome,
                'note' => 'Thanh toán ví đơn hàng ProxyHome ' . $meta['order_id']
            ]);
            return true;
        });
    }
}