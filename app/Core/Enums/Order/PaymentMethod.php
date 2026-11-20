<?php

namespace App\Core\Enums\Order;

use App\Core\Supports\Enum;

enum PaymentMethod: int
{
    use Enum;

    case Banking = 10;

    case Wallet = 20;

    case Coin = 30;
    case Heleket = 40;
}
