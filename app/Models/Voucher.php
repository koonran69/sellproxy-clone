<?php

namespace App\Models;

use App\Core\Enums\Voucher\VoucherStatus;
use App\Core\Enums\Voucher\VoucherType;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'status',
        'member_level_id',
        'user_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => VoucherType::class,
            'status' => VoucherStatus::class
        ];
    }

    public function memberLevel()
    {
        return $this->belongsTo(MemberLevel::class, 'member_level_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
