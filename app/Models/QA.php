<?php

namespace App\Models;

use App\Core\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Model;

class QA extends Model
{
    //
    protected $table = 'qas';

    protected $fillable = [
        'question',
        'answer',
        'status',
        'position',
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
