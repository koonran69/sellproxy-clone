<?php

namespace App\Core\Repositories\Admin;

use App\Core\Repositories\EloquentRepositoryInterface;

interface AdminRepositoryInterface extends EloquentRepositoryInterface
{
    public function updateHasRoleAndPermission($id, array $data, array $roles = [], array $permissions = []);
    
    public function createHasRoleAndPermission(array $data, array $roles = [], array $permissions = []);
}