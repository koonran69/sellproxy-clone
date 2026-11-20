<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum WithdrawalStatus: string
{
    use Enum;

    case Pending = 'pending';

    case  Approved = 'approved';

    case  Rejected = 'rejected';

    public function badge()
    {
        return match ($this) {
            self::Approved => 'bg-green',
            self::Rejected => 'bg-danger',
            self::Pending => 'bg-default',
        };
    }
}
