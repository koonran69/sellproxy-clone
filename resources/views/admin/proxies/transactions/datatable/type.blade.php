<span @class([
    'badge', App\Core\Enums\TransactionType::from($type)->badge()
])>{{ App\Core\Enums\TransactionType::from($type)->description() }}</span>