<?php

namespace App\Core\Repositories\Page;
use App\Core\Repositories\EloquentRepository;
use App\Models\Coin;
use App\Models\Page;
use App\Models\QA;
use App\Models\Voucher;

class PageRepository extends EloquentRepository implements PageRepositoryInterface
{

    public function getModel(){
        return Page::class;
    }
}
