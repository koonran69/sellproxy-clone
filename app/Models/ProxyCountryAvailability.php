<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyCountryAvailability extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'country_id',
        'proxy_type_id',
        'ip_version_id',
        'is_available',
    ];

    protected $table = 'proxy_country_availabilities';

    public function country()
    {
        return $this->belongsTo(ProxyCountry::class);
    }

    public function type()
    {
        return $this->belongsTo(ProxyLineType::class, 'proxy_type_id');
    }

    public function ipVersion()
    {
        return $this->belongsTo(IpVersion::class, 'ip_version_id');
    }
}
