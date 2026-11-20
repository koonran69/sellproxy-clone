<?php

namespace App\Core\Repositories\Permission;

use App\Core\Repositories\EloquentRepositoryInterface;

interface PermissionRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $limit = 10);
}