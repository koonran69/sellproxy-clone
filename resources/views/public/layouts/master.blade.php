<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('public.layouts.head')
</head>

<body>
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>
    <div class="w-full d-flex align-items-center px-3 py-2 gap-2" style="background: #6f2efe; overflow: hidden;">
        <img alt="Notification" loading="lazy" width="24" height="24" class="flex-shrink-0" src="{{ asset('public/assets/images/noti_white.png') }}">

        <div style="flex-grow: 1; overflow: hidden; white-space: nowrap; position: relative;">
            <div class="animate-marquee-custom" style="display: inline-block; padding-left: 100%; font-weight: 700; color: #fff; font-size: 14px;">
                <strong>@lang('Nghiêm cấm'):</strong> @lang('Sử dụng PROXY vào mục đích trái pháp luật, bạn sẽ phải chịu toàn bộ trách nhiệm trước pháp luật khi sử dụng dịch vụ.')
            </div>
        </div>
    </div>
    @include('public.layouts.partials.header')
    <div class="page">
        <div class="page-wrapper">

            @section('breadcrums')
                @include('public.layouts.partials.breadcrums')
            @show

            @yield('content')

            @include('public.layouts.footer')

        </div>
    </div>
    @include('public.layouts.scripts')
    <script>
        @if (session('success'))
        $(document).ready(function () {
            msgSuccess("{{ session('success') }}");
        });
        @endif
    </script>
    <div class="position-fixed top-50 end-0 translate-middle-y me-3 z-3" id="ctaBox">
        <div class="cta-buttons bg-white shadow text-center">
            <button class="cta-close-btn" onclick="document.getElementById('ctaBox').style.display = 'none'">×</button>
{{--            <a href="https://zalo.me/0708762402" target="_blank" class="cta-btn text-decoration-none mb-3 mt-3">--}}
{{--                <img src="{{ asset('public/assets/images/zalo-icon.png') }}" alt="zalo" width="32" height="32" class="mb-1">--}}
{{--                <div class="cta-text">Zalo</div>--}}
{{--            </a>--}}
{{--            <a href="https://www.facebook.com/ssh.sell.3/" target="_blank" class="cta-btn text-decoration-none mb-3 mt-3">--}}
{{--                <img src="{{ asset('public/assets/images/facebook_act.svg') }}" alt="Facebook" width="32" height="32" class="mb-1">--}}
{{--                <div class="cta-text">Facebook</div>--}}
{{--            </a>--}}
            <a href="https://t.me/nickchatdelamgi" target="_blank" class="cta-btn text-decoration-none mb-3 mt-3">
                <img src="{{ asset('public/assets/images/telegram_act.svg') }}" alt="Telegram" width="32" height="32" class="mb-1">
                <div class="cta-text">Telegram</div>
            </a>
            <a href="mailto:nickchatdelamgi@gmail.com" target="_blank" class="cta-btn text-decoration-none mb-3 mt-3">
                <img src="{{ asset('public/assets/images/email-icon.png') }}" alt="Email" width="32" height="32" class="mb-1">
                <div class="cta-text">Email</div>
            </a>
{{--            <a href="https://www.youtube.com/@sellsocks247" target="_blank" class="cta-btn text-decoration-none">--}}
{{--                <img src="{{ asset('public/assets/images/youtube_act.png') }}" alt="Youtube" width="32" height="32" class="mb-1">--}}
{{--                <div class="cta-text">Youtube</div>--}}
{{--            </a>--}}
        </div>
    </div>
</body>

</html>
