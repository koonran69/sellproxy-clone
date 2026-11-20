<div class="gp-tab-panel active" id="tab-overview">
    <div class="d-flex justify-content-end mb-3">
        <button class="gp-refresh-btn" id="btnRefresh" data-route="{{ route('getProxies.piaproxy.refresh') }}"
            data-provider="{{ $provider }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-reload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg> {{ __('Làm mới') }}
        </button>
    </div>
    <div class="gp-section-card border-0">
        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card gp-stat-primary h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Email') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>
                    </div>
                    <div class="gp-stat-value text-truncate" id="stat-email" style="font-size: 16px; max-width: 100%;">{{ $data['email'] ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Tài khoản phụ') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-count-child-info" style="font-size: 20px">{{ $data['count_child_info'] ?? 0 }}</div>
                    <div class="gp-stat-sub">{{ __('Tài khoản tiêu dùng') }}</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Lưu lượng Residential') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mobiledata gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 12v-8" /><path d="M8 20v-8" /><path d="M13 7l3 -3l3 3" /><path d="M5 17l3 3l3 -3" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-residential-text" style="font-size: 20px">{{ $data['residential_text'] ?? '0 / 0' }}</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="gp-stat-card h-100 mb-0">
                    <div class="gp-stat-label d-flex justify-content-between">
                        <span>{{ __('Lưu lượng DC còn lại') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-data-connection gp-stat-icon-blue"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 9.897c0 -1.714 1.46 -3.104 3.26 -3.104c.275 -1.22 1.255 -2.215 2.572 -2.611c1.317 -.397 2.77 -.134 3.811 .69c1.042 .822 1.514 2.08 1.239 3.3h.693a2.42 2.42 0 0 1 2.425 2.414a2.42 2.42 0 0 1 -2.425 2.414h-8.315c-1.8 0 -3.26 -1.39 -3.26 -3.103" /><path d="M12 13v3" /><path d="M10 18a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 18h7" /><path d="M3 18h7" /></svg>
                    </div>
                    <div class="gp-stat-value" id="stat-datacenter-text" style="font-size: 20px">{{ $data['datacenter_text'] ?? '0 / 0'}}</div>
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
                        <span class="gp-info-label">{{ __('Email') }}</span>
                        <span class="gp-info-value" id="info-email">{{ $data['email'] ?? 'N/A' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Tài khoản phụ') }}</span>
                        <span class="gp-info-value" id="info-count-child-info">{{ $data['count_child_info'] ?? 0 }}</span>
                    </div>
                </div>
                <div class="gp-info-row">
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Lưu lượng Residential') }}</span>
                        <span class="gp-info-value" id="info-residential-text">{{ $data['residential_text'] ?? '0 / 0' }}</span>
                    </div>
                    <div class="gp-info-item">
                        <span class="gp-info-label">{{ __('Lưu lượng DC còn lại') }}</span>
                        <span class="gp-info-value" id="info-datacenter-text">{{ $data['datacenter_text'] ?? '0 / 0'}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gp-section-card">
        <div class="gp-section-header d-flex justify-content-between">
            <div class="gp-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg> {{ __('Danh sách tài khoản phụ') }}
            </div>
            <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary btn-view-all-subs">
                {{ __('Xem tất cả') }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
            </a>
        </div>
        <div class="gp-section-body">
            <div class="list-group list-group-flush">
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

            // Xử lý khi click vào "Xem tất cả"
            $('.btn-view-all-subs').on('click', function(e) {
                e.preventDefault();

                const targetTab = $('.gp-tab[data-tab="sub-accounts"]');

                if (targetTab.length) {
                    targetTab.trigger('click');
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                }
            });

            //Lắng nghe sự kiện từ file chính để render danh sách tài khoản phụ
            window.addEventListener('proxy-data-updated', function(e) {
                const data = e.detail;

                //Chỉ chạy nếu có dữ liệu list_child_preview (đặc thù của Pia)
                if (data && data.list_child_preview) {
                    renderPiaSubAccounts(data.list_child_preview);
                }
            });

            function renderPiaSubAccounts(list) {
                const container = $('.list-group-flush');
                let html = '';

                if (list && list.length > 0) {
                    list.forEach(item => {
                        const statusClass = item.status === 1 ? 'bg-green-lt' : 'bg-red-lt';
                        const statusText = item.status === 1 ? '{{ __("Khả dụng") }}' : '{{ __("Khóa") }}';

                        html += `
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <div>
                                    <div class="font-weight-medium text-dark">${item.username}</div>
                                </div>
                                <div>
                                    <span class="badge ${statusClass}" style="padding: 5px 12px; border-radius: 4px;">
                                        ${statusText}
                                    </span>
                                </div>
                            </div>`;
                    });
                } else {
                    html = '<div class="text-center py-3 text-muted">{{ __("Chưa có tài khoản phụ.") }}</div>';
                }
                container.html(html);
            }
        });
    </script>
@endpush
