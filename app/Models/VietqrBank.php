<?php

namespace App\Models;

use App\Core\Supports\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VietqrBank extends BaseModel
{
    use HasFactory;

    protected $table = 'vietqr_banks';

    protected $fillable = [
        'name', 'code', 'bin', 'shortName', 'logo', 'short_name', 'support', 'isTransfer', 'swift_code', 'transferSupported', 'lookupSupported'
    ];
}
