<?php

namespace App\Core\Enums\Setting;

use App\Core\Supports\Enum;

enum SettingGroup: int
{
    use Enum;

    case General = 10;

    case Social = 20;

    case Product = 30;

    case BankAccount = 40;

    case ProxyFeature = 50;

    case Coin = 60;

    case TurnDelete = 70;
}
