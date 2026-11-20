<?php

namespace App\Models;

use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends BaseModel
{
    //
    use HasFactory, Sluggable;
    protected $table = 'attributes';

    protected $fillable = [
        'name',
        'slug',
        'position',
        'desc',
    ];

    public function variations()
    {
        return $this->hasMany(Variation::class, 'attr_id', 'id');
    }

}
