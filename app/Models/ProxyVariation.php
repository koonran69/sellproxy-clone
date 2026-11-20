<?php

namespace App\Models;

use App\Core\Enums\ProxyStatus;
use App\Core\Supports\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class ProxyVariation extends BaseModel
{
    //
    use HasFactory, HasTranslations;
    
    protected $table = 'proxy_variations';

    protected $fillable = [
        'proxy_id',
        'variation_id',
        'price',
        'price_promotion',
        'duration',
        'status',
        'desc'
    ];

    public $translatable = ['duration'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProxyStatus::class
        ];
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id', 'id');
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

    public function getHasPromotionAttribute()
    {
        return !is_null($this->price_promotion) && $this->price_promotion < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->has_promotion) {
            return round((($this->price - $this->price_promotion) / $this->price) * 100);
        }
        return 0;
    }
}
