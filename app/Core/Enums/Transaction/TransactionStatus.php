<?php

namespace App\Core\Enums\Transaction;

use App\Core\Supports\Enum;

enum TransactionStatus: int
{
    use Enum;

    case PendingPayment = 10;
    case Paid = 20;
    case Complete = 30;
    case Canceled = 40; //

}
