<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxyResidentialOrder extends Model
{
    use HasFactory;

    protected $table = 'proxy_residential_orders';

    protected $fillable = [
        'partner_order_id',
        'user_id',
        'type',
        'service',
        'plan',
        'protocol',
        'location',
        'isp',
        'traffic',
        'package',
        'month',
        'quantity',
        'amount',
        'rate_vnd',
        'request',
        'partner_price_response',
        'partner_order_response',
        'partner_proxies_response',
        'status'
    ];

    protected $casts = [
        'request' => 'array',
        'partner_price_response' => 'array',
        'partner_order_response' => 'array',
        'partner_proxies_response' => 'array',
    ];

    protected $appends = ['service_name'];

    public function getServiceNameAttribute()
    {
        $services = config('proxyresidental');
        $key = $this->service;

        return $services[$key]['name'] ?? $key;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function location()
    {
        return $this->belongsTo(ProxyCountry::class, 'location', 'code');
    }

    public function country()
    {
        return $this->hasOne(ProxyCountry::class, 'code', 'location');
    }
    public function proxies()
    {
        return $this->hasMany(ProxyResidentialProxy::class, 'pr_order_id', 'id');
    }
    public function proxy()
    {
        return $this->hasOne(ProxyResidentialProxy::class, 'pr_order_id', 'id');
    }
}
