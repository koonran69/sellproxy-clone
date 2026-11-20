<?php

namespace App\Models;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Transaction\ReferenceType;
use App\Core\Enums\Transaction\TransactionStatus;
use App\Core\Supports\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Transaction extends BaseModel
{
    //
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'code',
        'amount',
        'status',
        'reference_id',
        'reference_type',
        'note'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reference_type' => ReferenceType::class,
            'status' => TransactionStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
