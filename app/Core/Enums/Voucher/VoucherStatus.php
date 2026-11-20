<?php

namespace App\Core\Enums\Voucher;

use App\Core\Supports\Enum;

enum VoucherStatus: int
{
    use Enum;

    case Unused = 10; // Chưa sử dụng
    case Used = 20;   // Đang sử dụng
    case Expired = 30; // Hết hạn

    public function badge(): string
    {
        return match($this) {
            VoucherStatus::Unused => 'bg-gray',
            VoucherStatus::Used => 'bg-green',
            VoucherStatus::Expired => 'bg-red',
        };
    }
}