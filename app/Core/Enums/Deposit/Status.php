<?php

namespace App\Core\Enums\Deposit;

use App\Core\Supports\Enum;

enum Status: int
{
    use Enum;

    case Pending = 10;

    case Success = 20;

    case Fail = 30;

    case Expired = 40;

    public function badge()
    {
        return match ($this) {
            self::Pending => 'bg-yellow',
            self::Success => 'bg-green',
            self::Fail => 'bg-danger',
            self::Expired => 'bg-red',
        };
    }
}
