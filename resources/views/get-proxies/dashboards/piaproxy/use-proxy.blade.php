<div class="gp-tab-panel" id="tab-use-proxy" data-route-data="{{ route('getProxies.piaproxy.useProxy.data') }}"
    data-flag-url="{{ asset('/public/flags') }}"
    data-default-img="{{ asset('/public/core/assets/images/default-image.png') }}">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="gp-section-card mb-4">
                <div class="gp-section-header d-flex justify-content-between">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg> {{ __('Thông tin tài khoản') }}</div>
                    <button class="btn-icon-plain" id="btnRefreshUseProxy"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg></button>
                </div>
                <div class="gp-section-body">
                    <div class="input-icon">
                        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg></span>
                        <select class="form-select" id="accountSelect" style="padding: 12px 12px 12px 40px;">
                            <option value="">{{ __('Đang tải tài khoản...') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="gp-section-card mb-4">
                <div class="gp-section-header">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /></svg> {{ __('Máy chủ Proxy') }}</div>
                </div>
                <div class="gp-section-body">
                    <div class="row g-3" id="proxyServerGrid">
                    </div>
                </div>
            </div>

            <div class="gp-section-card mb-4">
                <div class="gp-section-header">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M3.6 9h16.8" /><path d="M3.6 15h16.8" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 1 0 18" /></svg> {{ __('Khu vực') }}</div>
                </div>
                <div class="gp-section-body">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg></span>
                        <input type="text" class="form-control" id="searchCountry"
                            placeholder="{{ __('Tìm quốc gia...') }}">
                    </div>
                    <div class="country-grid" id="countryGrid">
                    </div>
                </div>
            </div>

            <div class="gp-section-card mb-0">
                <div class="gp-section-header">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg> {{ __('Chế độ kết nối') }}</div>
                </div>
                <div class="gp-section-body">
                    <div class="row g-3 mb-2">
                        <div class="col-6">
                            <div class="mode-card active" data-mode="rotate">
                                <svg style="margin: 0 auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh mode-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                <div class="mode-name">{{ __('Rotate IP') }}</div>
                                <div class="mode-desc">{{ __('Đổi IP mỗi lần request') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mode-card" data-mode="sticky">
                                <svg style="margin: 0 auto"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pinned mode-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4v6l-2 4v2h10v-2l-2 -4v-6" /><path d="M12 16l0 5" /><path d="M8 4l8 0" /></svg>
                                <div class="mode-name">{{ __('Sticky IP') }}</div>
                                <div class="mode-desc">{{ __('Giữ IP trong thời gian nhất định') }}</div>
                            </div>
                        </div>
                    </div>

                    <div id="stickyOptions" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Mã phiên') }}</label>
                            <div class="input-group">
                                <input type="text" id="sessionId" class="form-control" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="btnRefreshSession">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                </button>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">{{ __('Thời gian phiên (phút)') }}</label>
                            <select id="sessionTime" class="form-select">
                                <option value="1">1 {{ __('phút') }}</option>
                                <option value="5">5 {{ __('phút') }}</option>
                                <option value="10">10 {{ __('phút') }}</option>
                                <option value="15">15 {{ __('phút') }}</option>
                                <option value="30" selected>30 {{ __('phút') }}</option>
                                <option value="60">60 {{ __('phút') }}</option>
                                <option value="90">90 {{ __('phút') }}</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="connection-info-card sticky-top" style="top: 50px;">
                <div class="cic-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg> {{ __('Thông tin kết nối') }}
                </div>
                <div class="cic-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="cic-label">{{ __('Host:Port') }}</label>
                            <button class="btn-copy-sm" data-target="#res-host-port"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg></button>
                        </div>
                        <div id="res-host-port" class="form-control cic-input"
                            style="min-height: 42px; display: flex; align-items: center;">43.159.129.54:5000</div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="cic-label">{{ __('Tên đăng nhập') }}</label>
                            <button class="btn-copy-sm" data-target="#res-username"><i
                                    class="ti ti-copy"></i></button>
                        </div>
                        <div id="res-username" class="form-control cic-input"
                            style="min-height: 42px; display: flex; align-items: center;"></div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="cic-label">{{ __('Mật khẩu') }}</label>
                            <button class="btn-copy-sm" data-target="#res-password"><i
                                    class="ti ti-copy"></i></button>
                        </div>
                        <div id="res-password" class="form-control cic-input"
                            style="min-height: 42px; display: flex; align-items: center;"></div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="cic-label">{{ __('Giao thức') }}</span>
                                <span class="fw-bold text-dark">HTTP</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="cic-label mb-1">{{ __('QUANTITY') }}</label>
                            <input type="number" id="info-quantity" class="form-control" value="1"
                                min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="cic-label mb-1">{{ __('PROXY FORMAT') }}</label>
                        <select id="info-format" class="form-select">
                            <option value="h:p:u:p">hostname:port:username:password</option>
                            <option value="u:p:h:p">username:password:hostname:port</option>
                            <option value="u:p@h:p">username:password@hostname:port</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="cic-label">{{ __('Proxy') }}</label>
                            <button class="btn-copy-sm" data-target="#info-proxy-result"><i
                                    class="ti ti-copy"></i></button>
                        </div>
                        <div id="info-proxy-result" class="form-control cic-textarea cic-cmd"
                            style="min-height: 54px; overflow-y: auto;"></div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="cic-label">{{ __('Lệnh kiểm tra') }}</label>
                            <button class="btn-copy-sm" data-target="#info-curl-command"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg>
                            </button>
                        </div>
                        <div id="info-curl-command" class="form-control cic-textarea cic-cmd"
                            style="min-height: 54px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link href="{{ asset('/public/core/templates/tabler/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <style>
        /* Container tổng thể */
        .input-icon .select2-container {
            width: 100% !important;
        }

        /* Tùy chỉnh khung chọn chính */
        .input-icon .select2-container--default .select2-selection--single {
            height: 48px !important; /* Độ cao tiêu chuẩn cho mobile dễ chạm */
            border: 1px solid #e6e9ed !important;
            border-radius: 8px !important;
            background-color: transparent !important;
            display: flex;
            align-items: center;
        }

        /* Đẩy chữ sang phải để nhường chỗ cho Icon ti-user */
        .input-icon .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 40px !important; /* Quan trọng: để không đè lên icon */
            line-height: 48px !important;
            color: #1d273b !important;
            font-size: 14px;
        }

        /* Fix icon dấu X (clear) và mũi tên không bị đè */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            margin-right: 25px !important;
            line-height: 48px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
            right: 8px !important;
        }

        /* Đảm bảo icon ti-user nằm trên cùng và đúng vị trí */
        .input-icon .input-icon-addon {
            z-index: 5;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Fix lỗi Dropdown bị tràn màn hình mobile */
        .select2-dropdown {
            border: 1px solid #e6e9ed !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            z-index: 9999 !important;
        }

        .server-card,
        .mode-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            height: 100%;
            position: relative;
        }

        .server-card:hover,
        .mode-card:hover {
            border-color: #2563eb;
            background: #f9fafb;
        }

        .server-card.active,
        .mode-card.active {
            border-color: #2563eb;
            background: #eff6ff;
            border-width: 1px;
        }

        .server-name {
            font-weight: 600;
            font-size: 14px;
            color: #111827;
            margin-bottom: 2px;
        }

        .server-ip {
            font-size: 12px;
            color: #6b7280;
        }

        .mode-icon {
            font-size: 24px;
            color: #2563eb;
            margin-bottom: 8px;
            display: block;
        }

        .mode-name {
            font-weight: 600;
            font-size: 15px;
            color: #111827;
            margin-bottom: 2px;
        }

        .mode-desc {
            font-size: 12px;
            color: #6b7280;
        }

        .country-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            max-height: 250px;
            overflow-y: auto;
            padding: 4px;
        }

        @media (max-width: 1400px) {
            .country-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1100px) {
            .country-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 800px) {
            .country-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .country-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 13px;
            border-radius: 4px;
            cursor: pointer;
            background: #f8fafc;
        }

        .country-item.active,
        .country-item:hover {
            background: #2563eb;
            color: #fff;
        }

        .country-item .flag {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .country-code {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .country-item.active .country-code {
            color: #fff;
        }


        .connection-info-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        }

        .cic-header {
            padding: 18px 24px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
        }

        .cic-body {
            padding: 24px;
        }

        .cic-label {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
        }

        .cic-input {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 8px;
            word-break: break-all;
        }

        .cic-textarea {
            background: #f1f5f9 !important;
            font-size: 12px;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .cic-cmd {
            background: #0f172a !important;
            color: #10b981 !important;
            border: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-copy-sm {
            background: #f1f5f9;
            border: none;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all .2s;
        }

        .btn-copy-sm:hover {
            background: #e2e8f0;
            color: #2563eb;
        }

        .btn-copy-sm i {
            font-size: 14px;
        }


        .btn-icon-plain {
            background: transparent;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            transition: all .2s;
        }

        .input-icon {
            position: relative;
        }

        .input-icon-addon {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }

        .input-icon .form-control {
            padding-left: 36px;
        }

        /* Scrollbar styling */
        .country-grid::-webkit-scrollbar,
        .custom-select-options::-webkit-scrollbar {
            width: 5px;
        }

        .country-grid::-webkit-scrollbar-thumb,
        .custom-select-options::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        @media (max-width: 768px) {

            .gp-section-header {
                flex-direction: row !important;
            }

            .server-card,
            .mode-card {
                padding: 12px 8px;
            }

            .mode-name {
                font-size: 13px;
            }

            .mode-desc {
                font-size: 10px;
            }

            .server-name {
                font-size: 12px;
            }

            .server-ip {
                font-size: 10px;
            }

            .country-item {
                padding: 6px 8px;
                gap: 5px;
            }

            .country-code {
                font-size: 11px;
            }

            .cic-body {
                padding: 15px;
            }

            .cic-body .d-flex.justify-content-between {
                flex-direction: row !important;
                display: flex !important;
            }

            .cic-body .row.g-2>.col-12 {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                gap: 10px;
                margin-bottom: 10px;
            }

            .cic-body .row.g-2>.col-12:last-child {
                margin-bottom: 0;
            }

            .cic-body .row.g-2>.col-12 label,
            .cic-body .row.g-2>.col-12 .cic-label {
                margin-bottom: 0 !important;
            }

            .cic-body .row.g-2>.col-12 input {
                width: auto !important;
                max-width: 60%;
            }

            .connection-info-card {
                margin-top: 20px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#accountSelect').select2({
                placeholder: "{{ __('Tìm kiếm tài khoản...') }}",
                allowClear: false,
                width: '100%',
                dropdownParent: $('#tab-use-proxy'),
            });

            const container = $('#tab-use-proxy');

            const config = {
                dataUrl: container.data('route-data'),
                flagBaseUrl: container.data('flag-url'),
                defaultImageUrl: container.data('default-img')
            };

            let state = {
                subAccounts: [],
                regions: [],
                countries: [],
                selectedAccount: null,
                selectedServer: null,
                selectedCountry: '',
                mode: 'rotate',
                sessionId: '',
                quantity: 1,
                format: 'h:p:u:p'
            };

            function generateSessionId() {
                const alphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
                return Array.from({
                    length: 8
                }, () => alphabet[Math.floor(Math.random() * alphabet.length)]).join('');
            }

            function loadData() {
                AjaxLibrary.get(config.dataUrl, {
                    provider: 'piaproxy'
                }, function(res) {
                    if (res?.success) {
                        state.subAccounts = res.sub_accounts || [];
                        state.regions = res.regions || [];
                        state.countries = res.countries || [];

                        renderSubAccounts();
                        renderServers();
                        renderCountries();

                        if (state.subAccounts.length > 0) {
                            selectAccountById(state.subAccounts[0].id);
                            $('#accountSelect').val(state.subAccounts[0].id);
                        }
                        if (state.regions.length > 0) {
                            selectServer(state.regions[0]);
                        }
                        updateConnectionInfo();
                    }
                });
            }

            function renderSubAccounts() {
                const $select = $('#accountSelect');
                $select.empty();

                if (!state.subAccounts || state.subAccounts.length === 0) {
                    $select.append('<option value="">{{ __("Chưa có tài khoản phụ") }}</option>');
                    $select.trigger('change');
                    return;
                }

                state.subAccounts.forEach(acc => {
                    const username = acc.username || 'N/A';
                    const newOption = new Option(username, acc.id, false, false);
                    $select.append(newOption);
                });

                // Kích hoạt Select2 cập nhật lại danh sách option mới
                $select.trigger('change');
            }

            function selectAccountById(id) {
                const acc = state.subAccounts.find(a => a.id == id);
                if (acc) {
                    state.selectedAccount = acc;
                    updateConnectionInfo();
                }
            }

            function renderServers() {
                const $grid = $('#proxyServerGrid').empty();
                state.regions.forEach(srv => {
                    const isActive = state.selectedServer?.id === srv.id;
                    const $card = $(`
                        <div class="col-6 col-md-3">
                            <div class="server-card ${isActive ? 'active' : ''}">
                                <div class="d-flex justify-content-center mb-2">
                                    <span class="flag flag-sm flag-country-${srv.flag}"></span>
                                </div>
                                <div class="server-name">${srv.name}</div>
                                <div class="server-ip">${srv.ip}</div>
                            </div>
                        </div>
                    `);
                    $card.on('click', () => selectServer(srv));
                    $grid.append($card);
                });
            }

            function selectServer(srv) {
                state.selectedServer = srv;
                $('#proxyServerGrid .server-card').removeClass('active');
                $(`.server-card:contains('${srv.name}')`).addClass('active');
                $('#res-host-port').html(`${srv.ip}:5000`);
                updateConnectionInfo();
            }

            function renderCountries(filter = '') {
                const $grid = $('#countryGrid').empty();
                const query = filter.toLowerCase();

                const showRandom = !query || 'random'.includes(query) || 'ngẫu nhiên'.includes(query);

                if (showRandom) {
                    const isRandomActive = !state.selectedCountry || state.selectedCountry === '' || state.selectedCountry === 'random';

                    const $randomItem = $(`
                        <div class="country-item ${isRandomActive ? 'active' : ''}" data-code="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-shuffle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 4l3 3l-3 3" /><path d="M18 20l3 -3l-3 -3" /><path d="M3 7h3a5 5 0 0 1 5 5a5 5 0 0 0 5 5h5" /><path d="M3 17h3a5 5 0 0 0 5 -5a5 5 0 0 1 5 -5h5" /></svg>
                            <span class="country-code">Random</span>
                        </div>
                    `);

                    $randomItem.on('click', () => {
                        state.selectedCountry = '';
                        $('#countryGrid .country-item').removeClass('active');
                        $randomItem.addClass('active');
                        updateConnectionInfo();
                    });

                    $grid.append($randomItem);
                }

                const filtered = state.countries.filter(c =>
                    c.name.toLowerCase().includes(query) || c.code.toLowerCase().includes(query)
                );

                filtered.forEach(c => {
                    const isActive = state.selectedCountry === c.code;
                    const $item = $(`
                        <div class="country-item ${isActive ? 'active' : ''}" data-code="${c.code}">
                            <span class="flag flag-xs flag-country-${c.code.toLowerCase()}"></span>
                            <span class="country-code">${c.code}</span>
                        </div>
                    `);
                    $item.on('click', () => {
                        state.selectedCountry = c.code;
                        $('#countryGrid .country-item').removeClass('active');
                        $item.addClass('active');
                        updateConnectionInfo();
                    });
                    $grid.append($item);
                });
            }

            function updateConnectionInfo() {
                if (!state.selectedAccount || !state.selectedServer) return;

                const user = state.selectedAccount.username || '';
                const pass = state.selectedAccount.plaintext_password || '';

                const country = state.selectedCountry.toUpperCase();
                const hostPort = $('#res-host-port').text().trim();
                const qty = parseInt($('#info-quantity').val()) || 1;
                const format = $('#info-format').val();
                const sessTime = $('#sessionTime').val();

                //Rotation IP (Global/Region) Format: user-[username]-region-[country]
                let proxyUser = `user-${user}`;
                if (country && country !== 'all') {
                    proxyUser += `-region-${country}`;
                }
                //Sticky IP, nối thêm sessid và sesstime theo chuẩn doc
                if (state.mode === 'sticky') {
                    // Docx dùng: -sessid-[id]-sesstime-[time]
                    proxyUser += `-sessid-${state.sessionId}-sesstime-${sessTime}`;
                }
                $('#res-username').text(proxyUser);
                $('#res-password').text(pass);

                const results = Array.from({
                    length: qty
                }, () => {
                    switch (format) {
                        case 'h:p:u:p':
                            return `${hostPort}:${proxyUser}:${pass}`;
                        case 'u:p:h:p':
                            return `${proxyUser}:${pass}:${hostPort}`;
                        default:
                            return `${proxyUser}:${pass}@${hostPort}`;
                    }
                });

                $('#info-proxy-result').html(results.join('<br>'));
                const curl = `curl -x ${hostPort} -U "${proxyUser}:${pass}" ipinfo.io`;
                $('#info-curl-command').html(`<span style="color: #6ee7b7;">$</span> ${curl}`);
            }

            function handleCopy($btn) {
                const $target = $($btn.data('target'));
                let text = $target.is('input, textarea') ? $target.val() : $target.text();

                text = text.replace(/^\$ /, '').trim();
                if (!text) return;

                navigator.clipboard.writeText(text).then(() => {
                    const original = $btn.html();
                    $btn.html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>');
                    setTimeout(() => $btn.html(original), 2000);
                });
            }

            $('#accountSelect').on('change', function() {
                selectAccountById($(this).val());
            });
            $('#searchCountry').on('input', function() {
                renderCountries($(this).val());
            });

            $('.mode-card').on('click', function() {
                state.mode = $(this).data('mode');
                $('.mode-card').removeClass('active');
                $(this).addClass('active');
                $('#stickyOptions')[state.mode === 'sticky' ? 'slideDown' : 'slideUp'](200);
                updateConnectionInfo();
            });

            $('#btnRefreshSession').on('click', function() {
                state.sessionId = generateSessionId();
                $('#sessionId').val(state.sessionId);
                updateConnectionInfo();
            });

            $('#sessionTime, #info-format, #info-quantity').on('change input', updateConnectionInfo);

            $('#btnRefreshUseProxy').on('click', function() {
                const $btn = $(this).addClass('spinning');
                loadData();
                setTimeout(() => $btn.removeClass('spinning'), 800);
            });

            $('.btn-copy-sm').on('click', function() {
                handleCopy($(this));
            });

            state.sessionId = generateSessionId();
            $('#sessionId').val(state.sessionId);
            window.addEventListener('tab-init-use-proxy', loadData);
        });
    </script>
@endpush
