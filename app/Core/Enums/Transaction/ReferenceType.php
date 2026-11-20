<?php

namespace App\Core\Enums\Transaction;

use App\Core\Supports\Enum;
use App\Models\ProxyHomeOrder;
use App\Models\ProxyOrder;
use App\Models\ProxyResidentialOrder;
use App\Models\ProxySellvps247;
use App\Models\ProxySellvps247Order;
use App\Models\Vps;
use App\Models\VpsOrder;
use App\Models\Withdrawal;

enum ReferenceType: string
{
    use Enum;

    case Deposit = \App\Models\Deposit::class;

    case Order = \App\Models\Order::class;

    case Withdrawal = Withdrawal::class;

    case OrderProxy = ProxyOrder::class;

    case OrderProxyHome = ProxyHomeOrder::class;

    case ProxyResidentialOrder = ProxyResidentialOrder::class;

    case VpsOrder = VpsOrder::class;
    case Vps = Vps::class;
    case ProxySellvps247Order = ProxySellvps247Order::class;
    case ProxySellvps247 = ProxySellvps247::class;

}
