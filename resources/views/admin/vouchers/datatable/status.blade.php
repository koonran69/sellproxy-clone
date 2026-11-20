<span @class([
    'badge', App\Core\Enums\Voucher\VoucherStatus::tryFrom($status)->badge()
])>{{ App\Core\Enums\Voucher\VoucherStatus::tryFrom($status)->description() }}</span>