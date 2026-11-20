<header>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('public/assets/images/logo_desktop.png') }}" alt="Logo" class="main-logo">
            </a>

            <!-- Mobile toggle button -->
            <div class="d-flex align-items-center gap-3 order-lg-3">
                <!-- Cart icon for mobile -->
                <a href="{{ route("cart.getCart") }}" class="position-relative">
                    <img src="{{ asset('public/assets/images/cart.svg') }}" alt="">
                    <span class="wishlist-products-counter"
                          id="cart_count_total">{{ Cart::content()->count() ?? "0" }}</span>
                </a>

                <!-- Language dropdown for mobile -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                       aria-label="Open language menu" aria-expanded="false">
                        <img src="{{ asset('public/assets/images/lang_' . app()->getLocale() . '.svg') }}" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow p-1">
                        <a href="{{ route('change-locale', 'en') }}" class="nav-link d-flex gap-2 lh-1 text-reset p-2">
                            <img src="{{ asset('public/assets/images/lang_en.svg') }}" alt="">
                            <span>@lang('English')</span>
                        </a>
                        <a href="{{ route('change-locale', 'vi') }}" class="nav-link d-flex gap-2 lh-1 text-reset p-2">
                            <img src="{{ asset('public/assets/images/lang_vi.svg') }}" alt="">
                            <span>@lang('Tiếng Việt')</span>
                        </a>
                    </div>
                </div>

                <!-- User dropdown for mobile -->
                @if(Auth::check())
                    <div class="nav-item dropdown user-dropdown">
                        <a href="javascript:void(0)" class="nav-link d-flex lh-1 text-reset p-0 dropdown-toggle"
                           data-bs-toggle="dropdown"
                           aria-label="Open user menu" aria-expanded="false">
                            <img src="{{ asset('public/assets/images/user.svg') }}" alt="">
                            <span class="d-none d-sm-inline ms-1">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow p-1">
                            <a href="{{ route("account.profile") }}" class="nav-link d-flex gap-2 lh-1 text-reset p-2">
                                <img src="{{ asset('public/assets/images/profile.png') }}" alt="">
                                <span>@lang('Tài khoản của tôi')</span>
                            </a>
                            <a href="{{ route("account.orders") }}" class="nav-link d-flex gap-2 lh-1 text-reset p-2">
                                <img src="{{ asset('public/assets/images/history.png') }}" alt="">
                                <span>@lang('Lịch sử mua hàng')</span>
                            </a>
                            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="nav-link d-flex gap-2 lh-1 text-reset p-2">
                                <img src="{{ asset('public/assets/images/logout.png') }}" alt="">
                                <span class="cursor-pointer">@lang('Đăng xuất')</span>
                            </a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <a href="{{ route("auth.login") }}"
                           class="fw-bold text-secondary text-decoration-none">@lang('Đăng nhập')</a>
                        <a class="btn btn-linear-primary text-decoration-none"
                           href="{{ route("auth.register") }}">@lang('Đăng ký')</a>
                    </div>
                @endif

                <!-- Hamburger menu button -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Collapsible navigation -->
            <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
                <ul class="navbar-nav">
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="{{ route("home") }}">@lang('Trang chủ')</a>--}}
                    {{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('proxy.list') }}">@lang('Danh sách proxy')</a>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="{{ route('getProxies.index') }}">@lang('Get Proxies')</a>--}}
                    {{--                    </li>--}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                           data-bs-auto-close="outside" role="button">
                            @lang('Proxy nước ngoài')
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('proxyline.newOrder') }}"> Datacenter </a>
                            <a class="dropdown-item" href="{{ route('proxyResidential.proxyStaticList') }}">
                                Residential (Dân cư)
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('proxyhome.proxyRotateList') }}">@lang('Proxy Việt Nam')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vps.buying',['nation'=>'VN']) }}">@lang('VPS')</a>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="#">@lang('Đối tác')</a>--}}
                    {{--                    </li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.index') }}">@lang('Hướng dẫn')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ asset('/assets/files/dieukhoandichvu.pdf') }}" target="_blank" rel="noopener noreferrer"> @lang('Điều khoản') </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('aboutPage') }}">@lang('Giới thiệu')</a>
                    </li> --}}
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a class="nav-link" href="{{ route('contact.form') }}">@lang('Liên hệ')</a>--}}
                    {{--                    </li>--}}
                </ul>

                <!-- Mobile-only login/register buttons -->
                @if(!Auth::check())
                    <div class="d-flex d-sm-none flex-column gap-2 mt-3">
                        <a href="{{ route("auth.login") }}" class="fw-bold text-secondary text-decoration-none"
                           id="btn-mobile-primary">@lang('Đăng nhập')</a>
                        <a class="btn btn-linear-primary text-decoration-none"
                           href="{{ route("auth.register") }}">@lang('Đăng ký')</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</header>
