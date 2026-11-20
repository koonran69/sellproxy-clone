<span @class([
    'badge', \App\Core\Enums\WithdrawalStatus::from($status)->badge()
])>{{ \App\Core\Enums\WithdrawalStatus::from($status)->description() }}</span>