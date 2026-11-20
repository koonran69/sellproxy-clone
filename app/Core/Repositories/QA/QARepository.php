<?php

namespace App\Core\Repositories\QA;
use App\Core\Repositories\EloquentRepository;
use App\Models\QA;
use App\Models\Voucher;

class QARepository extends EloquentRepository implements QARepositoryInterface
{

    public function getModel(){
        return QA::class;
    }
}
