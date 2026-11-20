<?php

namespace App\Models;

use App\Core\Enums\DefaultStatus;
use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class ProxyCategory extends BaseModel
{
    //
    use HasFactory, Sluggable, HasTranslations;
    
    protected $table = 'proxy_categories';

    protected $fillable = [
        'name',
        'slug',
        'status',
        'position',
        'feature_image',
    ];

    public $translatable = ['name'];
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
        return $this->hasMany(Proxy::class, 'category_id', 'id');
    }
}
