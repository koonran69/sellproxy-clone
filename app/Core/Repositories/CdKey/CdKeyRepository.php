<?php

namespace App\Core\Repositories\CdKey;
use App\Core\Repositories\EloquentRepository;
use App\Models\CDkey;
use App\Models\QA;
use App\Models\Voucher;

class CdKeyRepository extends EloquentRepository implements CdKeyRepositoryInterface
{

    public function getModel(){
        return CDkey::class;
    }
}
