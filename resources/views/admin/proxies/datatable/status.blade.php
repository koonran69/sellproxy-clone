<span @class([
    'badge', App\Core\Enums\ProxyStatus::tryFrom(10)->badge()
])>{{ App\Core\Enums\ProxyStatus::tryFrom(10)->description() }}</span>
