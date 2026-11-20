<span @class([
    'badge', App\Core\Enums\Deposit\Status::from($status)->badge()
])>{{ App\Core\Enums\Deposit\Status::from($status)->description() }}</span>