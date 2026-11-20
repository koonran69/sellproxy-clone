<?php

namespace App\Models;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    //
    protected $table = 'withdrawals';

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'account_info',
        'status',
        'note',
        'processed_at',
        'ip_address'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'account_info' => 'json',
            'status' => WithdrawalStatus::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }
}
