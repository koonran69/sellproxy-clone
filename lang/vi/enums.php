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
        App\Core\Enums\ProxyStatus::Available->value => 'Có sẵn',
        App\Core\Enums\ProxyStatus::OutOfStock->value => 'Hết hàng'
    ],

    App\Core\Enums\Voucher\VoucherStatus::class => [
        App\Core\Enums\Voucher\VoucherStatus::Unused->value => 'Chưa sử dụng',
        App\Core\Enums\Voucher\VoucherStatus::Used->value => 'Đang sử dụng',
        App\Core\Enums\Voucher\VoucherStatus::Expired->value => 'Hết hạn'
    ],

    App\Core\Enums\Voucher\VoucherType::class => [
        App\Core\Enums\Voucher\VoucherType::Percentage->value => 'Phần trăm (%)',
        App\Core\Enums\Voucher\VoucherType::Fixed->value => 'Cố định (đ)',
    ],

    App\Core\Enums\Order\PaymentMethod::class => [
        App\Core\Enums\Order\PaymentMethod::Banking->value => 'Tài khoản ngân hàng',
        App\Core\Enums\Order\PaymentMethod::Wallet->value => 'Ví',
    ],

    App\Core\Enums\Order\OrderStatus::class => [
        App\Core\Enums\Order\OrderStatus::PendingPayment->value => 'Đang chờ thanh toán',
        //App\Core\Enums\Order\OrderStatus::Paid->value => 'Đã thanh toán',
        App\Core\Enums\Order\OrderStatus::Complete->value => 'Hoàn thành',
        App\Core\Enums\Order\OrderStatus::Canceled->value => 'Đã huỷ',
    ],

    App\Core\Enums\WithdrawalStatus::class => [
        App\Core\Enums\WithdrawalStatus::Pending->value => 'Chờ xử lý',
        App\Core\Enums\WithdrawalStatus::Approved->value => 'Đã xử lý',
        App\Core\Enums\WithdrawalStatus::Rejected->value => 'Từ chối',
    ],

    App\Core\Enums\StatusVPS::class => [
        App\Core\Enums\StatusVPS::Active->value => 'Hoạt động',
        App\Core\Enums\StatusVPS::Pause->value => 'Đang dừng',
        App\Core\Enums\StatusVPS::Unknown->value => 'Unknown'
    ],

    App\Core\Enums\VpsTypeAction::class => [
        App\Core\Enums\VpsTypeAction::reboot->value => 'Khởi động lại',
        App\Core\Enums\VpsTypeAction::pause->value => 'Tạm dừng',
        App\Core\Enums\VpsTypeAction::auto_fix->value => 'Sửa lỗi tự động'
    ],

    App\Core\Enums\GetProxy\ProxyProvider::class => [
        App\Core\Enums\GetProxy\ProxyProvider::Abc->value => '1',
        App\Core\Enums\GetProxy\ProxyProvider::NineTwoTwo->value => '2',
        App\Core\Enums\GetProxy\ProxyProvider::Pia->value => '3',
    ],
];
