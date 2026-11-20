<?php

namespace App\Models;

use App\Core\Enums\GetProxy\ProxyProvider;
use App\Core\Supports\Eloquent\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProxyLoginLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'account',
        'password',
        'status',
        'message',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [

            'status'   => 'boolean',
            'provider' => ProxyProvider::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
