<?php

namespace App\Core\Repositories\Transaction;
use App\Core\Repositories\EloquentRepository;
use App\Models\Transaction;

class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    public function getModel(){
        return Transaction::class;
    }
}