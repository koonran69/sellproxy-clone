<?php

namespace App\Models;

use App\Core\Enums\ProxyTypeSellVPS247;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxySellvps247Order extends Model
{
    use HasFactory;

    protected $table = 'proxy_sellvps247_orders';
    protected $fillable = [
        'user_id',
        'duration',
        'auto_renew',
        'quantity',
        'coupon',
        'range_ip',
        'nation',
        'state',
        'isp', //nhà mạng
        'username',
        'password',
        'remote_port',
        'price',
        'request',
        'partner_price_response',
        'partner_order_response',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'auto_renew' => 'boolean',
        'request' => 'array',
        'partner_price_response' => 'array',
        'partner_order_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proxies()
    {
        return $this->hasMany(ProxySellvps247::class, 'order_id', 'id');
    }
}
