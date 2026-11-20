<?php

namespace App\Models;

use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variation extends BaseModel
{
    //
    use HasFactory, Sluggable;
    protected $table = 'variations';

    protected $fillable = [
        'attr_id',
        'name',
        'slug',
        'position',
        'meta_value',
        'desc'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attr_id', 'id');
    }

    public function proxies()
    {
        return $this->belongsToMany(Proxy::class, 'proxy_variations', 'variation_id', 'proxy_id')
            ->withPivot(['id', 'price', 'price_promotion', 'duration', 'status', 'desc'])
            ->withTimestamps();
    }

}
