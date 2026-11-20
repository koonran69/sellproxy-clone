<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyHomeOrder extends Model
{
    //
    use HasFactory;

    protected $table = 'proxy_home_orders';

    protected $fillable = [
        'user_id',
        'type',
        'code',
        'provider',
        'protocol',
        'location',
        'days',
        'quantity',
        'amount',
        'partner_response',
        'status',
        'partner_order_id'
    ];

    public function proxies()
    {
        return $this->hasMany(ProxyHomeProxy::class, 'partner_order_id', 'partner_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
