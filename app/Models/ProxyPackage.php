<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyPackage extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'proxy_price_tiers';

    protected $fillable = [
        'country_id',
        'proxy_type_id',
        'ip_version_id',
        'duration_days',
        'min_quantity',
        'max_quantity',
        'price_per_ip'
    ];

    public function countries()
    {
        return $this->belongsToMany(ProxyCountry::class, 'proxy_price_tier_countries','proxy_price_tier_id', 'country_id')
            ->withTimestamps();
    }

    public function proxyType()
    {
        return $this->belongsTo(ProxyLineType::class);
    }

    public function ipVersion()
    {
        return $this->belongsTo(IpVersion::class);
    }
}
