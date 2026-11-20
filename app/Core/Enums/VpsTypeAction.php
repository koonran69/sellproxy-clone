<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum VpsTypeAction: string
{
    use Enum;

    case reboot = 'reboot';
    case pause = 'pause';
    case auto_fix = 'auto_fix';
}
