<?php

namespace App\Models;

use App\Core\Supports\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLevel extends BaseModel
{
    use HasFactory;

    protected $table ='member_levels';

    protected $fillable = [
        'name',
        'plain_value',
        'position',
        'feature_image'
    ];
}
