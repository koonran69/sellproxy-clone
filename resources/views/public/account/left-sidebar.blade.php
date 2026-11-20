@php
    $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<div class="filter-category">
    <div class="expand-category justify-content-between align-items-center flex-row">
        <h3 data-bs-toggle="collapse" data-bs-target="#accountCollapse" class="mb-0 cursor-pointer">@lang('Menu Tài khoản')</h3>
        <!-- Arrow only shows on mobile -->
        <svg width="30" height="30" viewBox="0 0 24 24"
             class="category-arrow d-md-none cursor-pointer" data-bs-toggle="collapse"
             data-bs-target="#accountCollapse" aria-expanded="false">
            <path fill="currentColor" d="M7 10l5 5 5-5z"></path>
        </svg>
    </div>
    <div class="d-md-block collapse" id="accountCollapse">
        <ul class="list-unstyled mt-2">
            <li class="mt-1">
                <a href="{{ route('account.profile') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.profile' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/codicon_account.svg') }}" alt="">
                    <span class="cursor-pointer">Thông tin tài khoản</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.resetPassForm') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.resetPassForm' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/pepicons-pencil_rewind-time.svg') }}" alt="">
                    <span class="cursor-pointer">Cập nhật mật khẩu</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.levelShow') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.levelShow' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/si_wallet-detailed-line.svg') }}" alt="">
                    <span class="cursor-pointer">Hạng thành viên</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.proxyLineOrder') }}" class="gap-2 d-flex align-items-center {{ in_array($routeName, ['account.proxyLineOrder', 'account.proxyLineList']) ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/pepicons-pencil_rewind-time (1).svg') }}" alt="">
                    <span class="cursor-pointer">Proxy Đã Mua</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.orders') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.orders' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/pepicons-pencil_rewind-time (1).svg') }}" alt="">
                    <span class="cursor-pointer">Lịch sử đơn hàng</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.wallet') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.wallet' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/si_wallet-detailed-line.svg') }}" alt="">
                    <span class="cursor-pointer">Ví tiền</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.withdrawal') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.withdrawal' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/si_wallet-detailed-line.svg') }}" alt="">
                    <span class="cursor-pointer">Rút tiền</span>
                </a>
            </li>
            <li class="mt-1">
                <a href="{{ route('account.walletHistory') }}" class="gap-2 d-flex align-items-center {{ $routeName == 'account.walletHistory' ? 'active' : '' }}">
                    <img src="{{ asset('public/assets/images/pepicons-pencil_rewind-time (1).svg') }}" alt="">
                    <span class="cursor-pointer">Lịch sử nạp tiền</span>
                </a>
            </li>
        </ul>
    </div>
</div>
