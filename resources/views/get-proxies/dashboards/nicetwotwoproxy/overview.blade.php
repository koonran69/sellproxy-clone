<div class="gp-tab-panel active" id="tab-overview">

    <div class="d-flex justify-content-end mb-3">
        <button class="gp-refresh-btn" id="btnRefresh" data-route="{{ route('getProxies.nicetwotwoproxy.refresh') }}"
            data-provider="{{ $provider }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg> {{ __('Làm mới') }}
        </button>
    </div>

    <div class="gp-section-card border-0">
        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card gp-stat-primary h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Lưu lượng Residential') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" /><path d="M9 15l3 -3l3 3" /><path d="M12 12l0 9" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-residential-traffic-mb">
                        {{ $data['residential_traffic_mb'] ?? '0.00 MB' }}
                    </div>
                    <div class="gp-stat-sub">
                        {{ __('HSD') }}: <span id="stat-residential-expire-date">{{ $data['residential_expire_date'] ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Lưu lượng DC') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building-community gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l5 5v7h-5v-4m0 4h-5v-7l5 -5m1 1v-6a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v17h-8" /><path d="M13 7l0 .01" /><path d="M17 7l0 .01" /><path d="M17 11l0 .01" /><path d="M17 15l0 .01" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-residential-business-traffic-mb">
                        {{ $data['residential_business_traffic_mb'] ?? '0.00 MB' }}
                    </div>
                    <div class="gp-stat-sub">
                        {{ __('HSD') }}: <span id="stat-residential-business-expire-date">{{ $data['residential_business_expire_date'] ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Lưu lượng Rotating') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-rotating-traffic-mb">
                        {{ $data['rotating_traffic_mb'] ?? '0.00 MB' }}
                    </div>
                    <div class="gp-stat-sub">
                        {{ __('HSD') }}: <span id="stat-rotating-expire-date">{{ $data['rotating_expire_date'] ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Số dư ví') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-balance-recharge">
                        ${{ number_format($data['balance_recharge'] ?? 0, 2) }}
                    </div>
                </div>
            </div>

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
