<?php

namespace App\Models;

use App\Core\Enums\StatusVPS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    use HasFactory;

    protected $table = 'vps';

    protected $fillable = [
        'vps_id',
        'user_id',
        'vps_order_id',
        'server_name',
        'template',
        'ram',
        'cpu',
        'ssd',
        'install_chrome',
        'install_firefox',
        'country',
        'region',
        'PlanName',
        'change_ip_time',
        'note',
        'partner_created_at',
        'partner_expired_at',
        'name',
        'ip',
        'username',
        'password',
        'remote_port',
        'amount_before',
        'amount_last',
        'auto_renew',
        'delete_data',
        'price',
        'os_id',
        'os_name',
        'state',
        'provider',
        'status',
        'partner_server_info_response',
    ];

    protected $casts = [
        'install_chrome' => 'boolean',
        'install_firefox' => 'boolean',
        'auto_renew' => 'boolean',
        'delete_data' => 'boolean',
        'partner_created_at' => 'datetime',
        'partner_expired_at' => 'datetime',
        'status' => StatusVPS::class
    ];

    protected $appends = ['status_badge'];

    public function getStatusBadgeAttribute()
    {
        // Vì $this->status là Enum (đã cast ở trên)
        return $this->status?->badge() ?? 'bg-secondary';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(VpsOrder::class, 'vps_order_id', 'id');
    }
}
