<span @class([
    'badge', App\Core\Enums\Order\OrderStatus::tryFrom($status)->badge()
])>{{ App\Core\Enums\Order\OrderStatus::tryFrom($status)->description() }}</span>