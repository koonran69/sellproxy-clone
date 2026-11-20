<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CDkey extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'cdkeys';

    protected $fillable = [
        'cdkey',
        'proxy_id',
        'variation_id',
        'attr_id',
        'is_notify',
        'is_use',
        'user_id',
        'order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id', 'id');
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }

}
