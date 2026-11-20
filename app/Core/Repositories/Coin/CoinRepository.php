<?php

namespace App\Core\Repositories\Coin;
use App\Core\Repositories\EloquentRepository;
use App\Models\Coin;
use App\Models\QA;
use App\Models\Voucher;

class CoinRepository extends EloquentRepository implements CoinRepositoryInterface
{

    public function getModel(){
        return Coin::class;
    }
}
