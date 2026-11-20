<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyHomeProxy extends Model
{
    //
    use HasFactory;

    protected $table = 'proxy_home_proxies';

    protected $fillable = [
        'partner_order_id',
        'partner_item_id',
        'protocol',
        'username',
        'password',
        'ip',
        'port',
        'location',
        'provider',
        'category_type_slug',
        'category_type_name',
        'ip_entity_id',
        'change_ip_at',
        'ttl',
        'status_id',
        'status_name',
        'expired_at',
        'auto_renew',
        'partner_created_at',
        'partner_updated_at',
        'partner_raw',
        'user_id',
        'code',
        'rotate_interval'
    ];

    protected $casts = [
        'change_ip_at'       => 'datetime',
        'expired_at'         => 'datetime',
        'partner_created_at' => 'datetime',
        'partner_updated_at' => 'datetime',
        'auto_renew'         => 'boolean',
    ];

    protected function provider(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $value == 'HOMEPROXY' ? 'SELLSOCK247' : $value
        );
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(ProxyHomeOrder::class, 'partner_order_id', 'partner_order_id');
    }

        public function isExpired()
        {
            return now()->greaterThan($this->expired_at);
        }
}
