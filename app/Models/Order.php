<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'orders';

    protected $fillable = [
        'code',
        'user_id',
        'sub_total',
        'total',
        'discount',
        'data',
        'payment_method',
        'email_notify',
        'status',
        'note',
        'voucher_id',
        'discount_amount'
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'data' => AsArrayObject::class,
            'payment_method' => PaymentMethod::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }
}
