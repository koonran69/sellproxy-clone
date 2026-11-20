<?php

namespace App\Models;

use App\Core\Enums\StatusProxy;
use App\Core\Enums\StatusVPS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxySellvps247 extends Model
{
    use HasFactory;

    protected $table = 'proxy_sellvps247';

    protected $fillable = [
        'proxy_id',
        'user_id',
        'order_id',
        'server_name',
        'template',
        'ram',
        'cpu',
        'ssd',
        'country',
        'region',
        'PlanName',
        'change_ip_time',
        'note',
        'partner_created_at',
        'partner_expired_at',
        'networkType',
        'publicIp',
        'connectIp',
        'httpPort',
        'httpsPort',
        'socks5Port',
        'name',
        'ip',
        'username',
        'password',
        'remote_port',
        'amount_before',
        'amount_last',
        'price',
        'auto_renew',
        'state',
        'isp',
        'status',
        'partner_server_info_response',
    ];

    protected $casts = [
        'auto_renew' => 'boolean',
        'partner_created_at' => 'datetime',
        'partner_expired_at' => 'datetime',
        'status' => StatusProxy::class
    ];

    protected $appends = ['status_badge', 'proxy_type_name'];

    public function getProxyTypeNameAttribute()
    {
        $config = config('vps.proxy_type');
        return $config[$this->networkType] ?? null;
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status?->badge() ?? 'bg-secondary';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(ProxySellvps247Order::class, 'order_id', 'id');
    }
}
