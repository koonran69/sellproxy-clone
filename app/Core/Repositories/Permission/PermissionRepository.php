<?php

namespace App\Core\Repositories\Permission;
use App\Core\Repositories\EloquentRepository;
use App\Core\Repositories\Permission\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository extends EloquentRepository implements PermissionRepositoryInterface
{

    public function getModel(){
        return Permission::class;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {
        $this->instance = $this->model;
        $this->instance = $this->instance->where('name', 'LIKE', '%'.$keySearch.'%');
        $this->applyFilters($meta);
        
        return $this->instance->limit($limit)->get();
    }
}