<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum ProxyTypeSellVPS247: string
{
    use Enum;

    case Proxy = 'proxy';

    case Proxy_Residential = 'proxy_residential';
}
