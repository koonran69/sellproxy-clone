@extends('public.layouts.master')

@push('css')
    <style>
        .get-proxies-page {
            padding-top: 130px;
            padding-bottom: 50px;
        }

        .get-proxies-page .info-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #eef2ff;
            border: 1px solid #c7d2f7;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 20px;
            font-size: 13.5px;
            color: #3547b4;
        }

        .get-proxies-page .info-banner i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .get-proxies-page .info-banner a {
            margin-left: auto;
            flex-shrink: 0;
            background: #4a6cf7;
            color: #fff !important;
            padding: 6px 14px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .get-proxies-page .info-banner a:hover {
            opacity: .88;
        }

        @media (max-width: 768px) {
            .get-proxies-page .info-banner {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .get-proxies-page .info-banner a {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }
        }

        .get-proxies-page .login-card-wrapper {
            display: flex;
            justify-content: center;
            padding: 10px 0 30px;
        }

        .get-proxies-page .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .08);
            padding: 40px 44px;
            width: 100%;
            max-width: 500px;
        }

        .get-proxies-page .login-card .provider-logo {
            text-align: center;
            margin-bottom: 18px;
        }

        .get-proxies-page .login-card .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: #2563eb;
            font-family: monospace;
            letter-spacing: -.5px;
        }

        .get-proxies-page .login-card h4 {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #1a1f36;
            margin-bottom: 6px;
        }

        .get-proxies-page .login-card .subtitle {
            text-align: center;
            font-size: 13.5px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .get-proxies-page .login-card label {
            font-size: 13.5px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .get-proxies-page .login-card .input-group-text {
            background: #f9fafb;
            color: #9ca3af;
        }

        .get-proxies-page .login-card .form-control {
            background: #f9fafb;
            font-size: 14px;
        }

        .get-proxies-page .login-card .form-control:focus {
            box-shadow: none;
            border-color: #4a6cf7;
        }

        .get-proxies-page .btn-connect {
            background: #374151;
            color: #fff;
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            margin-top: 6px;
            transition: opacity .18s;
            cursor: pointer;
        }

        .get-proxies-page .btn-connect:hover {
            opacity: .9;
        }

        .get-proxies-page .provider-panel {
            display: none;
        }

        .get-proxies-page .provider-panel.active {
            display: block;
        }

        .get-proxies-page .toggle-password {
            pointer-events: auto !important;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container get-proxies-page">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">{{ __('Bảng điều khiển Proxy') }}</h2>
            <p class="text-muted mb-0">{{ __('Kết nối và quản lý tài khoản nhà cung cấp proxy') }}
            </p>
        </div>

        @include('get-proxies.partials.tabs', ['activeProvider' => $activeProvider])

        @foreach ($providers as $key => $p)
            <div class="provider-panel {{ $activeProvider == $key ? 'active' : '' }}" id="panel-{{ $key }}">
                <div class="info-banner">
                    <i class="ti ti-info-circle"></i>
                    <span>{{ __('Vui lòng đăng nhập bằng tài khoản') }} <strong>{{ $p['label'] }}</strong>
                        {{ __('của bạn. Nếu bạn chưa có tài khoản, hãy liên hệ qua Telegram để được hỗ trợ cấp tài khoản nhanh chóng.') }}</span>
                    <a href="https://t.me/nickchatdelamgi" target="_blank">
                        <i class="ti ti-brand-telegram"></i> &#64;nickchatdelamgi
                    </a>
                </div>

                <div class="login-card-wrapper">
                    <div class="login-card">
                        <div class="provider-logo">
                            <img src="{{ $p['logo_card'] }}" alt="{{ $p['label'] }}" class="provider-card-logo mb-0">
                        </div>
                        <h4 class="mb-2">{{ __('Đăng nhập') }} {{ $p['label'] }}</h4>
                        <p class="subtitle">{{ __('Nhập thông tin tài khoản') }} {{ $p['label'] }}
                            {{ __('để quản lý proxy của bạn') }}</p>

                        @php
                            $connectRoute = 'getProxies.' . $p['slug'] . '.connect';
                        @endphp
                        <x-core-form id="form-{{ $key }}"
                            data-route="{{ Route::has($connectRoute) ? route($connectRoute) : '#' }}">
                            <input type="hidden" name="provider" value="{{ $key }}">
                            <div class="mb-3">
                                <label for="{{ $key }}_username">{{ __('Email hoặc tên đăng nhập') }}</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <x-input name="username" id="{{ $key }}_username" :placeholder="__('Email hoặc tên đăng nhập')" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="{{ $key }}_password">{{ __('Mật khẩu') }}</label>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-lock"></i>
                                    </span>
                                    <x-input-password name="password" id="{{ $key }}_password"
                                        :placeholder="__('Mật khẩu')" />
                                    <span class="input-icon-addon toggle-password" style="left:auto;right:0;cursor:pointer;"
                                        data-target="{{ $key }}_password">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn-connect">{{ __('Kết nối') }}</button>
                        </x-core-form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@push('js')
    <script src="{{ asset('public/core/assets/js/lib-ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {

                const target = $('#' + $(this).data('target'));

                if (!target.length) return;

                const isPass = target.attr('type') === 'password';

                target.attr('type', isPass ? 'text' : 'password');

                const icon = $(this).find('i');

                icon.toggleClass('ti-eye', !isPass).toggleClass('ti-eye-off', isPass);
            });

            @json(array_keys($providers)).forEach(provider => {

                const form = $('#form-' + provider);

                if (!form.length) return;

                form.on('submit', function(e) {

                    e.preventDefault();

                    const btn = $(this).find('.btn-connect');

                    const route = $(this).data('route');
                    if (route === '#') {
                        msgError(window.__trans('Dịch vụ này đang được phát triển.'));
                        btn.prop('disabled', false).text(window.__trans('Kết nối'));
                        return;
                    }

                    const data = $(this).serialize() + '&_token=' + token;

                    AjaxLibrary.post(
                        route,
                        data,
                        function(res) {
                            if (res.success) {
                                msgSuccess(window.__trans('Kết nối thành công!'));
                                if (res.redirect) window.location.href = res.redirect;
                            } else {
                                msgError(res.message || window.__trans('Kết nối thất bại!'));
                            }
                        },
                        null,
                        function() {
                            btn.prop('disabled', false).text(window.__trans('Kết nối'));
                        }
                    );
                });
            });
        });
    </script>
@endpush
