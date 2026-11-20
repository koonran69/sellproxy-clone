<?php

namespace App\Services;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Jobs\SendCdKeyJob;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class TransactionProcessorService
{
    public function handle($transactionCode)
    {
        $transaction = Transaction::with('reference')->where('code', $transactionCode)->first();
        $reference = $transaction->reference;

        $transaction->status = TransactionStatus::Paid;
        $transaction->save();

        if ($reference instanceof Deposit) {

            $this->handleDeposit($transaction, $reference);

        } elseif ($reference instanceof Order) {

            $this->handleOrder($transaction, $reference);

        } else {

            throw new \Exception("Unknown transaction object type: " . $transaction->reference);

        }
    }

    protected function handleDeposit(Transaction $transaction, $deposit)
    {
        if($deposit->status == Status::Pending) {
            $deposit->user->recharge($deposit->amount, ReferenceType::Deposit, $deposit->id);
            $user = $deposit->user;
            $user->available_balance += $deposit->amount;
            $user->save();
            $deposit->update(['status' => Status::Success]);
        }
    }

    protected function handleOrder(Transaction $transaction, $order)
    {
        if ($order->status == OrderStatus::PendingPayment) {
            $order->status = OrderStatus::Complete;
            $order->save();
            app(OrderService::class)->updateMemberLevel($order->user_id);
            dispatch(new SendCdKeyJob($order->id));
        } else {
            Log::warning("Đơn hàng #{$order->id} không ở trạng thái pending, không thể cập nhật.");
        }
    }
}