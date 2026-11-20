<?php

namespace App\Models;

use App\Core\Enums\Order\OrderStatus;
use App\Core\Enums\Order\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProxyInstance extends Model
{
    //
    use HasFactory, HasTranslations;

    protected $table = 'proxy_instances';

    protected $fillable = [
        'proxy_order_id',
        'proxyline_id', 'ip', 'internal_ip', 'port_http', 'port_socks5',
        'username', 'password', 'country_code', 'type', 'ip_version',
        'order_id', 'date_start', 'date_end', 'raw_data',
        'comment'
    ];

    protected $casts = [
        'raw_data' => 'array',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
    ];

    public function getRemainingDaysAttribute()
    {
        if (!$this->date_end) return null;

        $now = Carbon::now();
        $end = Carbon::parse($this->date_end);

        $secondsLeft = $end->timestamp - $now->timestamp;

        $days = floor($secondsLeft / 86400);

        return max(0, $days); // Không cho âm
    }

    public function order() {
        return $this->belongsTo(ProxyOrder::class, 'proxy_order_id');
    }
}
