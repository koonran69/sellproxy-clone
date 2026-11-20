<?php

namespace App\Models;

use App\Core\Enums\Deposit\Status;
use App\Core\Enums\Deposit\Type;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    protected $table = 'deposits';

    protected $fillable = [
        'code',
        'user_id',
        'type',
        'amount',
        'status',
        'note',
        'data',
        'last_check'
    ];

    protected function casts(): array
    {
        return [
            'type' => Type::class,
            'status' => Status::class,
            'data' => AsArrayObject::class,
            'last_check' => 'datetime'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }
}
