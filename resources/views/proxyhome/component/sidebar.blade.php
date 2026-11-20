@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div class="navbar-brand-box d-lg-none d-block">
            <a href="{{ route('home') }}" class="logo logo-dark d-flex justify-content-center align-items-center">
                            <span class="logo-sm">
                                <img src="{{ asset('public/assets/images/logo_desktop.png') }}" alt="" height="24">
                            </span>
                <span class="logo-lg">
                                <img src="{{ asset('public/assets/images/logo_desktop.png') }}" alt="" height="36">
                            </span>
            </a>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
           <div class="brand">
            @if (auth()->check())
                <div class="wallet-card border-0 rounded-4 shadow-sm">
                   <div class="card-body d-flex align-items-center justify-content-between p-3">
                       <div>
                           <div class="small text-muted mb-1">Ví tiền của bạn</div>
                           <div class="fw-bold" style="line-height:1;">
                                <span class="text-primary-bg">
                                  {{ number_format($user->available_balance ?? 0) }}đ
                                </span>
                           </div>
                       </div>
                       <div class="icon-badge">
                           <img src="{{ asset('public/assets/images/wallet-bold.svg') }}" alt="">
                       </div>
                   </div>
               </div>
               <a href="{{ route('account.wallet') }}" class="btn btn-primary-bg w-100 mt-3 py-2 fw-semibold rounded-3">
                   Nạp tiền
               </a>
            @else
                <a href="{{ route('auth.login') }}" class="btn btn-primary-bg w-100 mt-3 py-2 fw-semibold rounded-3">
                   Đăng nhập
               </a>
            @endif

           </div>
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fa-solid fa-house"></i>
                        <span data-key="t-airplay">Overview</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('proxyhome.proxyStaticList') }}">Proxy Tĩnh</a>
                        </li>
                        <li>
                            <a href="{{ route('proxyhome.proxyRotateList') }}">Proxy Xoay</a>
                        </li>
                        <li>
                            <a href="{{ route('proxyhome.keyRotateList') }}">Key Xoay</a>
                        </li>
                        <li>
                            <a href="{{ route('proxyhome.proxyDatacenterList') }}">Proxy Datacenter</a>
                        </li>
                        <li>
                            <a href="{{ route('proxyhome.comboProxyList') }}">Combo Proxy</a>
                        </li>
                    </ul>
                </li>
                @if (auth()->check())
                <li>
                    <a href="{{ route('proxyhome.listProxies') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Đơn hàng Proxy tĩnh</span>
                    </a>
                </li>

                    <li>
                        <a href="{{ route('proxyhome.listProxyDatacenter') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Đơn hàng Proxy Datacenter</span>
                        </a>
                    </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span data-key="t-airplay">Đơn hàng Xoay</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('proxyhome.listRotateProxies') }}">Proxy Xoay</a>
                        </li>
                        <li>
                            <a href="{{ route('proxyhome.listKeyRotate') }}">Key Xoay</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('proxyhome.listProxyOrders') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Lịch sử mua hàng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('proxyhome.transactionHistory') }}">
                        <i class="fa-solid fa-tent-arrow-left-right"></i>
                        <span>Lịch sử giao dịch</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
