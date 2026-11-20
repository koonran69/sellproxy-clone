<?php

namespace App\Core\Supports\Auth;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use Illuminate\Support\Facades\DB;

trait Transaction
{
    public function checkBalanceAvailable(float $amount): bool
    {
        if($this->available_balance < $amount)
        {
            return false;
        }

        return true;
    }
    public function checkBalance(float $amount): bool
    {
        if($this->balance < $amount)
        {
            return false;
        }

        return true;
    }

    public function recharge(float $amount, ReferenceType $type, int $reference_id, string $note = ''): bool
    {
        $this->update([
            'balance' => DB::raw("balance + $amount")
        ]);

        $this->storeTransaction($amount, $type, $reference_id, $note);

        return true;
    }

    public function withdraw(float $amount, ReferenceType $type, int $reference_id, string $note = ''): bool
    {

        if($this->checkBalance($amount))
        {
            $this->update([
                'balance' => DB::raw("balance - $amount")
            ]);

            $this->storeTransaction(-$amount, $type, $reference_id, $note);

            return true;
        }

        return false;
    }

    public function storeTransaction(float $amount, ReferenceType $type, int $reference_id, string $note = ''): bool
    {
        if($note == '')
        {
            $note = $type->description();
        }

        $this->transactions()->create([
            'code' => 'PRX' . uniqid_real(6),
            'amount' => $amount,
            'status' => TransactionStatus::Paid,
            'reference_id' => $reference_id,
            'reference_type' => $type,
            'note' => $note
        ]);
        return true;
    }
}
