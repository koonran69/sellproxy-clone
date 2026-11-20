<?php

namespace App\Core\Repositories\Contact;
use App\Core\Repositories\EloquentRepository;
use App\Models\Contact;
use App\Models\QA;
use App\Models\Voucher;

class ContactRepository extends EloquentRepository implements ContactRepositoryInterface
{

    public function getModel(){
        return Contact::class;
    }
}
