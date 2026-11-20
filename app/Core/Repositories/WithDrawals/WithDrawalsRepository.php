<?php

namespace App\Core\Repositories\WithDrawals;
use App\Core\Repositories\EloquentRepository;
use App\Models\Deposit;
use App\Models\Withdrawal;

class WithDrawalsRepository extends EloquentRepository implements WithDrawalsRepositoryInterface
{

    public function getModel(){
        return Withdrawal::class;
    }
}