<div class="gp-tab-panel" id="tab-whitelist" data-route-list="{{ route('getProxies.abcproxy.whitelist.list') }}"
    data-route-add="{{ route('getProxies.abcproxy.whitelist.add') }}"
    data-route-lock="{{ route('getProxies.abcproxy.whitelist.lock') }}"
    data-route-delete="{{ route('getProxies.abcproxy.whitelist.delete') }}"
    data-route-proxy-info="{{ route('getProxies.abcproxy.whitelist.proxyInfo') }}"
    data-route-data="{{ route('getProxies.abcproxy.useProxy.data') }}" data-flag-url="{{ asset('/public/flags') }}">

    <div class="gp-section-card mb-4">
        <div class="gp-section-header">
            <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-shield-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.46 20.846a12 12 0 0 1 -7.96 -14.846a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3a12 12 0 0 1 -.09 7.06" /><path d="M15 19l2 2l4 -4" /></svg> {{ __('Quản lý White IP') }}</div>
        </div>
        <div class="gp-section-body">
            <div class="row g-3 mb-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control" id="whitelist-ips"
                            placeholder="{{ __('Nhập IP (vd: 1.2.3.4), nhiều IP cách nhau bởi dấu phẩy') }}">
                        <button class="btn" type="button" id="btn-get-local-ip" title="{{ __('Lấy IP hiện tại') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gps"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 17l-1 -4l-4 -1l9 -4l-4 9" /></svg>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn w-100 bg-primary text-white" id="btn-add-whitelist">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                         {{ __('Thêm IP') }}
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th class="fs-5">{{ __('ĐỊA CHỈ IP') }}</th>
                            <th class="fs-5">{{ __('TRẠNG THÁI') }}</th>
                            <th class="w-1 fs-5">{{ __('THAO TÁC') }}</th>
                        </tr>
                    </thead>
                    <tbody id="whitelist-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="gp-section-card mb-4">
                <div class="gp-section-header">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-api"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 13h5" /><path d="M12 16v-8h3a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-3" /><path d="M20 8v8" /><path d="M9 16v-5.5a2.5 2.5 0 0 0 -5 0v5.5" /></svg> {{ __('Trích xuất Proxy (API)') }}</div>
                </div>
                <div class="gp-section-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Số lượng (1-500)') }}</label>
                            <input type="number" class="form-control ex-param" id="ex-num" value="1"
                                min="1" max="500">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Chế độ IP') }}</label>
                            <select class="form-select ex-param" id="ex-mode">
                                <option value="0">{{ __('Xoay vòng') }}</option>
                                <option value="1">{{ __('Cố định') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Giao thức') }}</label>
                            <select class="form-select ex-param" id="ex-protocol">
                                <option value="1">HTTP</option>
                                <option value="2">SOCKS5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Định dạng') }}</label>
                            <select class="form-select ex-param" id="ex-format">
                                <option value="json">JSON</option>
                                <option value="txt">TXT</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gp-section-card mb-0">
                <div class="gp-section-header">
                    <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M3.6 9h16.8" /><path d="M3.6 15h16.8" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 1 0 18" /></svg> {{ __('Khu vực') }}</div>
                </div>
                <div class="gp-section-body">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg></span>
                        <input type="text" class="form-control" id="ex-search-country"
                            placeholder="{{ __('Tìm quốc gia...') }}">
                    </div>
                    <div class="country-grid" id="ex-countryGrid">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="connection-info-card sticky-top" style="top: 50px; border-radius: 12px; overflow: hidden;">
                <div class="cic-header" style="background: #7c3aed; color: #fff; padding: 15px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-api me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 13h5" /><path d="M12 16v-8h3a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-3" /><path d="M20 8v8" /><path d="M9 16v-5.5a2.5 2.5 0 0 0 -5 0v5.5" /></svg>
                    {{ __('Trích xuất Proxy (API)') }}
                </div>
                <div class="cic-body" style="background: #fff; padding: 20px;">
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">{{ __('Khu vực') }}</span>
                            <span class="fw-bold d-flex align-items-center" id="sum-region">
                                <span class="flag flag-xs flag-country-us me-2"></span> US
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">{{ __('Chế độ IP') }}</span>
                            <span class="fw-bold" id="sum-mode">{{ __('Xoay vòng') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">{{ __('Số lượng') }}</span>
                            <span class="fw-bold" id="sum-num">1</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">{{ __('Giao thức') }}</span>
                            <span class="fw-bold" id="sum-protocol">HTTP</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">{{ __('Loại Proxy') }}</span>
                            <span class="fw-bold">Residential (Flow)</span>
                        </div>
                    </div>

                    <button class="btn w-100 py-2 mb-4" id="btn-extract-proxy"
                        style="background: #a855f7; color: #fff; border: none; border-radius: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                        {{ __('Trích xuất Proxy') }}
                    </button>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="cic-label" style="font-size: 12px; color: #6b7280;">API URL</label>
                            <button class="btn-copy-sm" data-target="#res-api-url"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg>
                                {{ __('Copy') }}</button>
                        </div>
                        <div id="res-api-url" class="form-control cic-textarea"
                            style="font-size: 12px; background: #f9fafb; color: #4b5563; word-break: break-all;">
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="cic-label mb-0" style="font-size: 12px; color: #6b7280;">
                                {{ __('Proxy đã trích xuất') }} <span id="extraction-count"
                                    style="display:none;">(0)</span>
                            </label>
                            <button class="btn-copy-all" id="btn-copy-all" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg> {{ __('Sao chép tất cả') }}
                            </button>
                        </div>
                        <div id="extraction-result" class="text-center py-4"
                            style="border: 1px dashed #e5e7eb; border-radius: 8px; color: #6b7280; font-size: 13px;">
                            <div id="extraction-placeholder">
                                {{ __('Nhấn "Trích xuất Proxy" để lấy danh sách proxy IP') }}
                            </div>
                            <div id="extraction-result-list" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        #tab-whitelist .country-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            max-height: 300px;
            overflow-y: auto;
            padding-right: 4px;
        }

        @media (min-width: 768px) {
            #tab-whitelist .country-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 992px) {
            #tab-whitelist .country-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        #tab-whitelist .country-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            cursor: pointer;
            transition: all .2s;
        }

        #tab-whitelist .country-item:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        #tab-whitelist .country-item.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        #tab-whitelist .country-code {
            font-weight: 500;
            margin-left: 8px;
            font-size: 12px;
        }

        #tab-whitelist .flag-country-unknown {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-world"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M3.6 9h16.8" /><path d="M3.6 15h16.8" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 0 0 18" /></svg>');
            background-size: contain;
            background-repeat: no-repeat;
        }

        #extraction-result-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .proxy-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
            transition: all 0.2s;
        }

        .proxy-item:hover {
            background: #f1f5f9;
        }

        .proxy-content {
            font-weight: 500;
            color: #334155;
            font-size: 14px;
        }

        .btn-copy-proxy {
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .btn-copy-proxy:hover {
            background: #e2e8f0;
            color: #64748b;
        }

        .btn-copy-all {
            background: #f5f3ff;
            color: #7c3aed;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-copy-all:hover {
            background: #ede9fe;
            color: #6d28d9;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            const $container = $('#tab-whitelist');
            const routes = {
                list: $container.data('route-list'),
                add: $container.data('route-add'),
                lock: $container.data('route-lock'),
                delete: $container.data('route-delete'),
                proxyInfo: $container.data('route-proxy-info'),
                data: $container.data('route-data')
            };

            let countries = [];
            let selectedCountry = 'US';

            let whitelistPage = 1;
            const whitelistSize = 15;

            function loadWhitelist(page = 1) {
                whitelistPage = page;
                const $body = $('#whitelist-table-body');
                $body.closest('table').css('opacity', '0.5');

                AjaxLibrary.post(routes.list, {
                    _token: token,
                    provider: 'abcproxy',
                    page: page,
                    size: whitelistSize
                }, function(res) {
                    $body.closest('table').css('opacity', '1');
                    if (res?.success && res.html) {
                        $body.html(res.html);
                    } else {
                        const errorMsg = res?.message || 'Lỗi tải danh sách.';
                        $body.html(
                            `<tr><td colspan="4" class="text-center py-4 text-danger">${errorMsg}</td></tr>`
                        );
                    }
                });
            }

            $(document).on('click', '.whitelist-pagination-wrapper .pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');
                if (page) loadWhitelist(page);
            });

            function loadCountries() {
                AjaxLibrary.get(
                    routes.data, {
                        provider: 'abcproxy'
                    },
                    function(res) {
                        if (res?.success) {
                            countries = res.countries || [];
                            renderCountries();
                            updateApiUrl();
                        }
                    });
            }

            function renderCountries(filter = '') {
                const $grid = $('#ex-countryGrid').empty();
                const query = filter.toLowerCase();
                const filtered = countries.filter(c =>
                    c.name.toLowerCase().includes(query) || c.code.toLowerCase().includes(query)
                );

                filtered.forEach(c => {
                    const isActive = selectedCountry === c.code;
                    const $item = $(`
                        <div class="country-item ${isActive ? 'active' : ''}" data-code="${c.code}">
                            <span class="flag flag-xs flag-country-${c.code.toLowerCase()}"></span>
                            <span class="country-code">${c.code}</span>
                        </div>
                    `);
                    $item.on('click', () => {
                        selectedCountry = c.code;
                        $('#ex-countryGrid .country-item').removeClass('active');
                        $item.addClass('active');
                        updateSummary();
                    });
                    $grid.append($item);
                });
            }

            function updateSummary() {
                const num = $('#ex-num').val();
                const modeText = $('#ex-mode option:selected').text();
                $('#sum-region').html(
                    `<span class="flag flag-xs flag-country-${selectedCountry.toLowerCase()} me-2"></span> ${selectedCountry}`
                );
                $('#sum-mode').text(modeText);
                $('#sum-num').text(num);
                $('#sum-protocol').text($('#ex-protocol option:selected').text());

                updateApiUrl();
            }

            function updateApiUrl() {
                const params = {
                    provider: 'abcproxy',
                    proxy_type: 'flow',
                    quantity: $('#ex-num').val(),
                    region_code: selectedCountry,
                    ip_mode: $('#ex-mode').val(), // 0=rotate, 1=sticky
                    protocol: $('#ex-protocol').val(), // 1=http, 2=socks5
                    format: $('#ex-format').val(),
                    status: 1, // Hardcode as per user curl
                };

                AjaxLibrary.get(routes.proxyInfo, params, function(res) {
                    if (res?.success && res?.data?.api_url) {
                        $('#res-api-url').text(res.data.api_url);
                    }
                });
            }

            $('#btn-add-whitelist').on('click', function() {
                const ips = $('#whitelist-ips').val().trim();
                if (!ips) return;

                const $btn = $(this);
                $btn.prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm me-2"></i> Thêm IP');

                AjaxLibrary.post(routes.add, {
                    _token: token,
                    provider: 'abcproxy',
                    ips
                }, (res) => {
                    $btn.prop('disabled', false).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Thêm IP');
                    if (res?.success) {
                        $('#whitelist-ips').val('');
                        loadWhitelist();
                    } else {
                        alert(res?.message || 'Lỗi khi thêm IP.');
                    }
                });
            });

            $(document).on('click', '.btn-lock-ip', function() {
                const ip = $(this).data('ip');
                const status = $(this).data('status'); // 0 = unlock, 1 = lock

                AjaxLibrary.post(routes.lock, {
                    _token: token,
                    provider: 'abcproxy',
                    ips: ip,
                    status
                }, (res) => {
                    if (res?.success) {
                        loadWhitelist();
                    } else {
                        alert(res?.message || 'Lỗi khi thay đổi trạng thái IP.');
                    }
                });
            });

            $(document).on('click', '.btn-delete-ip', function() {
                const ip = $(this).data('ip');
                if (!confirm(`Bạn có chắc muốn xóa IP ${ip} khỏi whitelist?`)) return;

                AjaxLibrary.post(routes.delete, {
                    _token: token,
                    provider: 'abcproxy',
                    ips: ip
                }, (res) => {
                    if (res?.success) {
                        loadWhitelist();
                    } else {
                        alert(res?.message || 'Lỗi khi xóa IP.');
                    }
                });
            });

            $('#btn-get-local-ip').on('click', function() {
                fetch('https://api.ipify.org?format=json')
                    .then(r => r.json())
                    .then(data => {
                        const current = $('#whitelist-ips').val();
                        $('#whitelist-ips').val(current ? `${current},${data.ip}` : data.ip);
                    });
            });

            $('.ex-param').on('change input', updateSummary);
            $('#ex-search-country').on('input', function() {
                renderCountries($(this).val());
            });

            $('#btn-extract-proxy').on('click', function() {
                const url = $('#res-api-url').text().trim();
                if (!url) return;
                const $btn = $(this);
                const original = $btn.html();
                $btn.prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm me-2"></i> {{ __('Trích xuất...') }}');

                $.get(url)
                    .done(function(res) {
                        $btn.prop('disabled', false).html(original);

                        let proxies = [];

                        // Handle new JSON format provided by user
                        if (typeof res === 'object' && res.data && Array.isArray(res.data)) {
                            proxies = res.data.map(item => `${item.ip}:${item.port}`);
                        } else if (typeof res === 'string') {
                            // Try to parse if it's a string
                            try {
                                const json = JSON.parse(res);
                                if (json.data && Array.isArray(json.data)) {
                                    proxies = json.data.map(item => `${item.ip}:${item.port}`);
                                } else {
                                    // Handle other JSON structures or plain text lines
                                    proxies = res.split(/\r?\n/).filter(line => line.trim() !== '');
                                }
                            } catch (e) {
                                // Not JSON, treat as plain text
                                proxies = res.split(/\r?\n/).filter(line => line.trim() !== '');
                            }
                        } else {
                            // Unknown format, display as is
                            $('#extraction-placeholder').html(
                                `<pre class="text-start mb-0" style="background:transparent; border:none; padding:0; color:inherit;">${JSON.stringify(res, null, 2)}</pre>`
                            );
                            return;
                        }

                        if (proxies.length > 0) {
                            renderExtractionResult(proxies);
                        } else {
                            $('#extraction-placeholder').text(
                                '{{ __('Không tìm thấy dữ liệu proxy.') }}').show();
                            $('#extraction-result-list').hide();
                            $('#extraction-count, #btn-copy-all').hide();
                        }
                    })
                    .fail(function() {
                        $btn.prop('disabled', false).html(original);
                        alert(
                            '{{ __('Lỗi khi trích xuất proxy. Vui lòng kiểm tra IP đã được whitelist chưa.') }}'
                        );
                    });
            });

            function renderExtractionResult(proxies) {
                const $list = $('#extraction-result-list').empty().show();
                const $placeholder = $('#extraction-placeholder').hide();
                $('#extraction-count').text(`(${proxies.length})`).show();
                $('#btn-copy-all').show();
                $('#extraction-result').removeClass('text-center py-4').css({
                    'border-style': 'solid',
                    'padding': '15px',
                    'text-align': 'left'
                });

                proxies.forEach(proxy => {
                    const $item = $(`
                        <div class="proxy-item">
                            <span class="proxy-content">${proxy}</span>
                            <button class="btn-copy-proxy" title="{{ __('Sao chép') }}">
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg>
                            </button>
                        </div>
                    `);

                    $item.find('.btn-copy-proxy').on('click', function() {
                        navigator.clipboard.writeText(proxy).then(() => {
                            const $icon = $(this).find('i');
                            $icon.removeClass('ti-copy').addClass('ti-check');
                            setTimeout(() => $icon.removeClass('ti-check').addClass(
                                'ti-copy'), 2000);
                        });
                    });

                    $list.append($item);
                });

                $('#btn-copy-all').off('click').on('click', function() {
                    const allText = proxies.join('\n');
                    navigator.clipboard.writeText(allText).then(() => {
                        const original = $(this).html();
                        $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg> {{ __('Đã chép') }}');
                        setTimeout(() => $(this).html(original), 2000);
                    });
                });
            }

            $(document).on('click', '.btn-copy-sm', function() {
                const target = $(this).data('target');
                const text = $(target).text().trim();
                navigator.clipboard.writeText(text).then(() => {
                    const original = $(this).html();
                    $(this).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg> Copied');
                    setTimeout(() => $(this).html(original), 2000);
                });
            });

            window.addEventListener('tab-init-whitelist', () => {
                loadWhitelist();
                loadCountries();
            });
        });
    </script>
@endpush
