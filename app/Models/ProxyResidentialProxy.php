<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxyResidentialProxy extends Model
{
    use HasFactory;

    protected $table = 'proxy_residential_proxies';

    protected $fillable = [
        'partner_order_id',
        'user_id',
        'pr_order_id',
        'proxy_id',
        'proxy_status',
        'networkType',
        'authentication',
        'username',
        'password',
        'connection',
        'publicIp',
        'connectIp',
        'httpPort',
        'httpsPort',
        'ipVersion',
        'socks5Port',
        'hostnames',
        'proxyType',
        'partner_createdAt',
        'partner_expiresAt',
        'metadata',
        'partner_proxies_response',
        'note'
    ];

    protected $casts = [
        'partner_createdAt' => 'datetime',
        'partner_expiresAt' => 'datetime',
        'partner_proxies_response' => 'array',
        'authentication' => 'array',
        'connection' => 'array',
        'metadata' => 'array',
        'hostnames' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(ProxyResidentialOrder::class, 'pr_order_id', 'id');
    }

}
