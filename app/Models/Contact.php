<?php

namespace App\Models;

use App\Core\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $table = 'contacts';

    protected $fillable = [
        'fullname',
        'email',
        'subject',
        'message',
        'ip_address'
    ];
}
