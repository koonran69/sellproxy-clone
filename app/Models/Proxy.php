<?php

namespace App\Models;

use App\Core\Enums\ProxyStatus;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Proxy extends Model
{
    //
    use HasFactory, Sluggable, HasTranslations;
    protected $table = 'proxies';

    protected $fillable = [
        'category_id',
        'type_id',
        'name',
        'sub_title',
        'slug',
        'short_desc',
        'desc',
        'status',
        'feature_image',
        'price',
        'price_promotion',
        'desc',
        'features',
        'short_title_description'
    ];

    public $translatable = ['name', 'sub_title', 'short_desc', 'desc'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProxyStatus::class,
            'features' => AsArrayObject::class,
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProxyCategory::class, 'category_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ProxyType::class, 'type_id', 'id');
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class, 'proxy_variations', 'proxy_id', 'variation_id')
            ->withPivot(['id', 'price', 'price_promotion', 'duration', 'status', 'desc'])
            ->withTimestamps();
    }

    public function minVariation()
    {
        return $this->hasOne(ProxyVariation::class, 'proxy_id')
            ->where('status', ProxyStatus::Available)
            ->orderBy('price', 'asc');
    }

    public function proxyVariations()
    {
        return $this->hasMany(ProxyVariation::class, 'proxy_id')->orderBy('variation_id', 'asc');
    }
}
