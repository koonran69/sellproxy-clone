<?php

namespace App\Models;

use App\Core\Enums\DefaultStatus;
use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class ProxyType extends BaseModel
{
    //
    use HasFactory, Sluggable;
    
    protected $table = 'proxy_types';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'position',
        'feature_image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => DefaultStatus::class
        ];
    }

    public function proxies()
    {
        return $this->hasMany(Proxy::class, 'type_id', 'id');
    }
}
