<?php

namespace App\Core\Enums;

use App\Core\Supports\Enum;

enum BlogType: string
{
    use Enum;

    case Blog = 'blog';

    case Tutorial = 'tutorial';

}
