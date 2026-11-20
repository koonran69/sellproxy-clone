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
                    <a href="{{ route('account.wallet') }}"
                       class="btn btn-primary-bg w-100 mt-3 py-2 fw-semibold rounded-3">
                        Nạp tiền
                    </a>
                @else
                    <a href="{{ route('auth.login') }}"
                       class="btn btn-primary-bg w-100 mt-3 py-2 fw-semibold rounded-3">
                        Đăng nhập
                    </a>
                @endif

            </div>
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span data-key="t-airplay">Mua VPS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="label mb-3">
                            <span>Theo khu vực</span>
                        </li>
                        @foreach($vpsRegions as $region)
                            {{--                                EU thuộc PTU mục đich--}}
                            @if($region['symbol'] != 'EU')
                                <li class="mb-3">
                                    <a href="{{ route('vps.buying',['nation'=>$region['symbol']]) }}">
                                        <img src="data:image/png;base64,{{$region['flag']}}" alt="vps"
                                             class="w-[24px] ant-menu-item-icon">
                                        {{$region['name']}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        <li class="label my-2">
                            <span>Theo mục đích</span>
                        </li>
                        @foreach($purposes as $purpose)
                            @if($purpose['symbol'] == 'GPU')
                                <li>
                                    <a href="{{ route('vps.buyingGPU') }}">
                                        <svg viewBox="64 64 896 896" focusable="false" data-icon="hdd" width="2em"
                                             height="1em" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M832 64H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32zm-600 72h560v208H232V136zm560 480H232V408h560v208zm0 272H232V680h560v208zM496 208H312c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM312 544h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8H312c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8zm328 244a40 40 0 1080 0 40 40 0 10-80 0z"></path>
                                        </svg>
                                        {{$purpose['name']}}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('vps.buying',['nation'=>$purpose['symbol']]) }}">
                                        <svg viewBox="64 64 896 896" focusable="false" data-icon="hdd" width="2em"
                                             height="1em" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M832 64H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V96c0-17.7-14.3-32-32-32zm-600 72h560v208H232V136zm560 480H232V408h560v208zm0 272H232V680h560v208zM496 208H312c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM312 544h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8H312c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8zm328 244a40 40 0 1080 0 40 40 0 10-80 0z"></path>
                                        </svg>
                                        {{$purpose['name']}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                @if (auth()->check())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fa-solid fa-server"></i>
                            <span data-key="t-airplay">Quản lý VPS</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('vps.listVpsManagement',['by_time'=>'using']) }}">Đang sử dụng</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.listVpsManagement',['by_time'=>'due']) }}">Còn hạn dưới 3
                                    ngày</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.listVpsManagement',['by_time'=>'expired']) }}">Đã hết hạn</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.listVpsManagement',['by_time'=>'all']) }}">Tất cả dịch vụ</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fa-solid fa-list"></i>
                            <span data-key="t-airplay">Lịch sử mua VPS</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('vps.listVpsOrders') }}">
                                    Mua hàng
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vps.transactionHistory') }}">
                                    Giao dịch
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li>
                    <a href="{{ route('vps.proxy.getProxyOrderBuy') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span data-key="t-airplay">Mua Proxy</span>
                    </a>
                </li>
                @if (auth()->check())
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fa-solid fa-network-wired"></i>
                            <span data-key="t-airplay">Quản lý Proxy</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('vps.proxy.listProxyManagement',['by_time'=>'using']) }}">Đang sử
                                    dụng</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.proxy.listProxyManagement',['by_time'=>'due']) }}">Còn hạn dưới 3
                                    ngày</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.proxy.listProxyManagement',['by_time'=>'expired']) }}">Đã hết
                                    hạn</a>
                            </li>
                            <li>
                                <a href="{{ route('vps.proxy.listProxyManagement',['by_time'=>'all']) }}">Tất cả dịch
                                    vụ</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fa-solid fa-list"></i>
                            <span data-key="t-airplay">Lịch sử mua Proxy</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('vps.proxy.listProxyOrders') }}">
                                    Mua hàng
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vps.proxy.transactionProxyHistory') }}">
                                    Giao dịch
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
