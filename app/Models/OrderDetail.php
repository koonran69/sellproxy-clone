<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OrderDetail extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'proxy_id',
        'variation_id',
        'proxy_variation_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function proxy() {
        return $this->belongsTo(Proxy::class, 'proxy_id', 'id');
    }

    public function variation() {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

    public function proxyVariation() {
        return $this->belongsTo(ProxyVariation::class, 'proxy_variation_id', 'id');
    }
}
