<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum ProxyStatus: int
{
    use Enum;

    case Available = 10;

    case  OutOfStock = 20;

    public function badge()
    {
        return match ($this) {
            self::Available => 'bg-green',
            self::OutOfStock => 'bg-danger',
        };
    }
}
