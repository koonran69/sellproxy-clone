<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyOrder extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'proxy_orders';

    protected $fillable = [
        'user_id', 'external_order_id', 'country_id', 'ip_version_id',
        'type_id', 'quantity', 'period_days', 'total_amount',
        'code', 'date_start', 'date_end'
    ];

    protected array $dates = ['date_start'];

    protected $appends = ['remaining_days'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    public function proxyType()
    {
        return $this->belongsTo(ProxyLineType::class, 'type_id');
    }

    public function ipVersion()
    {
        return $this->belongsTo(IpVersion::class);
    }

    public function country()
    {
        return $this->belongsTo(ProxyCountry::class);
    }

    public function proxyInstances()
    {
        return $this->hasMany(ProxyInstance::class, 'proxy_order_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $lastOrder = self::orderBy('id', 'desc')->first();
            $lastCode = $lastOrder ? intval($lastOrder->code) : 0;
            $order->code = str_pad($lastCode + 1, 7, '0', STR_PAD_LEFT);
        });
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->date_end) return null;

        $now = Carbon::now();
        $end = Carbon::parse($this->date_end);

        $secondsLeft = $end->timestamp - $now->timestamp;

        $days = floor($secondsLeft / 86400);

        return max(0, $days); // Không cho âm
    }
}
