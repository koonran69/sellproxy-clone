<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class IpVersion extends Model
{
    //
    use HasFactory;

    protected $table = 'ip_versions';

    public function packages()
    {
        return $this->hasMany(ProxyPackage::class);
    }

    public function availabilities()
    {
        return $this->hasMany(ProxyCountryAvailability::class);
    }
}
