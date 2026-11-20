<?php

namespace App\Core\Repositories\Voucher;
use App\Core\Repositories\EloquentRepository;
use App\Models\Voucher;

class VoucherRepository extends EloquentRepository implements VoucherRepositoryInterface
{

    public function getModel(){
        return Voucher::class;
    }
}