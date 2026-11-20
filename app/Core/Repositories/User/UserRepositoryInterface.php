<?php

namespace App\Core\Repositories\User;

use App\Core\Repositories\EloquentRepositoryInterface;
use Illuminate\Support\Collection;
interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchSelect(string $keyword = '', int $limit = 10): array;
}