<?php

namespace App\Core\Enums\Voucher;

use App\Core\Supports\Enum;

enum VoucherType: int
{
    use Enum;

    case Percentage = 10;
    case Fixed = 20;
}
