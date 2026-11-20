<div class="gp-tab-panel active" id="tab-overview">

    <div class="d-flex justify-content-end mb-3">
        <button class="gp-refresh-btn" id="btnRefresh" data-route="{{ route('getProxies.abcproxy.refresh') }}"
            data-provider="{{ $provider }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg> {{ __('Làm mới') }}
        </button>
    </div>

    <div class="gp-stats-row">
        <div class="gp-stat-card gp-stat-primary">
            <div class="gp-stat-label">
                <span>{{ __('Lưu lượng còn lại') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" /><path d="M9 15l3 -3l3 3" /><path d="M12 12l0 9" /></svg>
            </div>
            <div class="gp-stat-value" id="stat-traffic-remain">{{ $data['traffic_remain'] ?? '—' }}</div>
            <div class="gp-stat-sub">{{ __('Đã dùng hôm nay') }}: <span
                    id="stat-traffic-used-today">{{ $data['traffic_used_today'] ?? '0 GB' }}</span>
            </div>
        </div>

        <div class="gp-stat-card">
            <div class="gp-stat-label">
                <span>{{ __('Số dư ví') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -8" /><path d="M3 10l18 0" /><path d="M7 15l.01 0" /><path d="M11 15l2 0" /></svg>
            </div>
            <div class="gp-stat-value" id="stat-balance">{{ $data['balance'] ?? '$0' }}</div>
            <div class="gp-stat-sub">{{ __('Tổng tiêu dùng') }}: <span
                    id="stat-total-spent">{{ $data['total_spent'] ?? '$0' }}</span></div>
        </div>

        <div class="gp-stat-card">
            <div class="gp-stat-label">
                <span>{{ __('IP động') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
            </div>
            <div class="gp-stat-value" id="stat-dynamic-ip">{{ $data['dynamic_ip'] ?? 0 }}</div>
        </div>

        <div class="gp-stat-card">
            <div class="gp-stat-label">
                <span>{{ __('Hạn sử dụng traffic') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M14 18a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
            </div>
            <div class="gp-stat-value" id="stat-expiry">{{ $data['expiry'] ?? '—' }}</div>
        </div>

        <div class="gp-stat-card">
            <div class="gp-stat-label">
                <span>{{ __('Lưu lượng Enterprise còn lại') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M14 18a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
            </div>
            <div class="gp-stat-value" id="stat-ent-flow-balance">{{ $data['ent_flow_balance'] ?? '—' }}</div>
        </div>
    </div>

    <div class="gp-section-card focus-section">
        <div class="gp-section-header">
            <div class="gp-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 10a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg> {{ __('Thông tin tài khoản') }}
            </div>
        </div>
        <div class="gp-section-body">
            <div class="gp-info-grid">
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Tên đăng nhập') }}</span>
                        <span class="gp-info-value" id="info-username">{{ $data['username'] ?? '—' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Email') }}</span>
                        <span class="gp-info-value" id="info-email">{{ $data['email'] ?? '—' }}</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Loại tài khoản') }}</span>
                        <span class="gp-info-value" id="info-account-type">{{ $data['account_type'] ?? '—' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Ngày tạo') }}</span>
                        <span class="gp-info-value" id="info-created-at">{{ $data['created_at'] ?? '—' }}</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('UID') }}</span>
                        <span class="gp-info-value" id="info-uid">{{ $data['uid'] ?? '—' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Tổng đã mua') }}</span>
                        <span class="gp-info-value" id="info-total-bought">{{ $data['total_bought'] ?? '$0' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gp-section-card">
        <div class="gp-section-header">
            <div class="gp-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.657 18c-2.572 0 -4.657 -2.007 -4.657 -4.483c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99c1.913 0 3.464 1.56 3.464 3.486c0 1.927 -1.551 3.487 -3.465 3.487h-11.878" /></svg> {{ __('Lưu lượng Residential') }}
            </div>
        </div>
        <div class="gp-section-body">
            <div class="gp-info-grid">
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Lưu lượng còn lại') }}</span>
                        <span class="gp-info-value fw-bold text-dark"
                            id="info-traffic-remain">{{ $data['traffic_remain'] ?? '—' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Tổng đã mua') }}</span>
                        <span class="gp-info-value" id="info-traffic-total">{{ $data['traffic_total'] ?? '—' }}</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Hạn sử dụng') }}</span>
                        <span class="gp-info-value" id="info-expiry">{{ $data['expiry'] ?? '—' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Đã dùng hôm nay') }}</span>
                        <span class="gp-info-value"
                            id="info-traffic-used-today">{{ $data['traffic_used_today'] ?? '0 GB' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gp-section-card">
        <div class="gp-section-header">
            <div class="gp-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-2" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /><path d="M11 8h6" /><path d="M11 16h6" /></svg> {{ __('Tài nguyên IP') }}
            </div>
        </div>
        <div class="gp-section-body">
            <div class="gp-info-grid">
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('IP động') }}</span>
                        <span class="gp-info-value">-</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('IP Data Center') }}</span>
                        <span class="gp-info-value">-</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('IP DC sắp hết hạn') }}</span>
                        <span class="gp-info-value">-</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('IP tĩnh Residential') }}</span>
                        <span class="gp-info-value">-</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('IP tĩnh sắp hết hạn') }}</span>
                        <span class="gp-info-value">-</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label"></span>
                        <span class="gp-info-value"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script>
        $(document).ready(function() {
            window.addEventListener('tab-init-overview', function() {
                $('#btnRefresh').trigger('click');
            });
        });
    </script>
@endpush
