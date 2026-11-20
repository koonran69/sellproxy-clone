<?php

namespace App\Core\Repositories\Deposit;
use App\Core\Repositories\EloquentRepository;
use App\Models\Deposit;

class DepositRepository extends EloquentRepository implements DepositRepositoryInterface
{

    public function getModel(){
        return Deposit::class;
    }

    protected function getQueryBuilderFindByKey($key){
        $this->instance = $this->instance->whereAny([
            'username',
            'phone',
            'fullname',
            'email'
        ], 'LIKE', '%'.$key.'%');
    }
}
