<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum StatusProxy: string
{
    use Enum;

    case Pause = 'Pause';
    case Active = 'Active';
    case Unknown = 'Unknown';

    public function badge()
    {
        return match ($this) {
            self::Active => 'bg-success',
            self::Pause => 'bg-warning',
            self::Unknown => 'bg-danger',
        };
    }
}
