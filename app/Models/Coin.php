<?php

namespace App\Models;

use App\Core\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    //
    protected $table = 'coins';

    protected $fillable = [
        'coin_name',
        'code',
        'icon',
        'status',
        'position'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => DefaultStatus::class
        ];
    }
}
