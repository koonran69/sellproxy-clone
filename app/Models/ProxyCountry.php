<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyCountry extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'code', 'feature_image'];

    protected $table = 'proxy_countries';

    public function packages()
    {
        return $this->hasMany(ProxyPackage::class, 'country_id');
    }

    public function availabilities()
    {
        return $this->hasMany(ProxyCountryAvailability::class, 'country_id');
    }

    public function proxyPackages()
    {
        return $this->belongsToMany(ProxyPackage::class, 'proxy_price_tier_countries')
            ->withTimestamps();
    }
}
