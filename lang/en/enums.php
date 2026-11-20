<?php

return [
    App\Core\Enums\DefaultStatus::class => [
        App\Core\Enums\DefaultStatus::Published->value => 'Xuất bản',
        App\Core\Enums\DefaultStatus::Draft->value => 'Bản nháp'
    ],

    App\Core\Enums\Deposit\Type::class => [
        App\Core\Enums\Deposit\Type::Banking->value => 'Chuyển khoản',
        App\Core\Enums\Deposit\Type::Provided->value => 'Admin cấp'
    ],

    App\Core\Enums\Deposit\Status::class => [
        App\Core\Enums\Deposit\Status::Pending->value => 'Chờ thanh toán',
        App\Core\Enums\Deposit\Status::Success->value => 'Đã thanh toán',
        App\Core\Enums\Deposit\Status::Fail->value => 'Thất bại',
        App\Core\Enums\Deposit\Status::Expired->value => 'Hết hạn'
    ],

    App\Core\Enums\Transaction\ReferenceType::class => [
        App\Core\Enums\Transaction\ReferenceType::Deposit->value => 'Nạp tiền',
        // App\Core\Enums\Transaction\ReferenceType::Order->value => 'Đặt hàng',
    ],

    App\Core\Enums\ProxyStatus::class => [
        App\Core\Enums\ProxyStatus::Available->value => 'Available',
        App\Core\Enums\ProxyStatus::OutOfStock->value => 'Out of stock'
    ],

    App\Core\Enums\Voucher\VoucherStatus::class => [
        App\Core\Enums\Voucher\VoucherStatus::Unused->value => 'Chưa sử dụng',
        App\Core\Enums\Voucher\VoucherStatus::Used->value => 'Đã sử dụng',
        App\Core\Enums\Voucher\VoucherStatus::Expired->value => 'Hết hạn'
    ],

    App\Core\Enums\Voucher\VoucherType::class => [
        App\Core\Enums\Voucher\VoucherType::Percentage->value => 'Phần trăm (%)',
        App\Core\Enums\Voucher\VoucherType::Fixed->value => 'Cố định (đ)',
    ],
];