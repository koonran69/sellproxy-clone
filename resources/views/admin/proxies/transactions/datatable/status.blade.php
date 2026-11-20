<span @class([
    'badge', App\Core\Enums\TransactionStatus::from($status)->badge()
])>{{ App\Core\Enums\TransactionStatus::from($status)->description() }}</span>