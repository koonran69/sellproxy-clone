<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VpsOrder extends Model
{
    use HasFactory;

    protected $table = 'vps_orders';
    protected $fillable = [
        'user_id',
        'plan_id',
        'duration',
        'auto_renew',
        'quantity',
        'os_id',
        'os_name',
        'random_password',
        'random_remote_port',
        'install_chrome',
        'install_firefox',
        'coupon',
        'range_ip',
        'state',
        'provider', //nhà mạng
        'password',
        'port',
        'nation',
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
        'random_password' => 'boolean',
        'random_remote_port' => 'boolean',
        'install_chrome' => 'boolean',
        'install_firefox' => 'boolean',
        'request' => 'array',
        'partner_price_response' => 'array',
        'partner_order_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vps()
    {
        return $this->hasMany(Vps::class, 'vps_order_id', 'id');
    }
}
