<?php

namespace App\Core\Enums\Order;

use App\Core\Supports\Enum;

enum OrderStatus: int
{
    use Enum;
    case PendingPayment = 10;
    //case Paid = 20;
    case Complete = 30;
    case Canceled = 40; //

    public function badge()
    {
        return match ($this) {
            OrderStatus::PendingPayment => '',
            //OrderStatus::Paid => 'bg-blue',
            OrderStatus::Complete => 'bg-green',
            OrderStatus::Canceled => 'bg-red',
        };
    }
}
