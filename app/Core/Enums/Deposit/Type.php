<?php

namespace App\Core\Enums\Deposit;

use App\Core\Supports\Enum;

enum Type: int
{
    use Enum;

    case Banking = 10;

    case Provided = 20;
}
