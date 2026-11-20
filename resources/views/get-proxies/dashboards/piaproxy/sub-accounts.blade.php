@push('css')
    <style>
        /* Container chứa phân trang */
        #sub-account-pagination {
            padding: 1rem 0;
            border-top: 1px solid #f1f1f1;
            background: #fff;
        }

        /* Style cơ bản cho các nút */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 5px; /* Khoảng cách giữa các nút */
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            text-decoration: none;
            background-color: #f8fafb;
            border: 1px solid #e6e9ed;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        /* Trạng thái Hover */
        .pagination .page-link:hover {
            color: #206bc4; /* Màu xanh thương hiệu */
            background-color: #f0f7ff;
            border-color: #d0e3ff;
        }

        /* Trang đang được chọn (Active) */
        .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #206bc4;
            border-color: #206bc4;
            box-shadow: 0 2px 4px rgba(32, 107, 196, 0.25);
        }

        /* Nút bị vô hiệu hóa (Disabled) */
        .pagination .page-item.disabled .page-link {
            color: #ccd1d9;
            pointer-events: none;
            background-color: #fcfdfe;
            border-color: #f1f3f5;
        }

        /* Icon bên trong nút (chevron) */
        .pagination .page-link i {
            font-size: 16px;
        }

        /* CSS cho trạng thái Active */
        #sub-account-pagination .page-item.active .page-link {
            background-color: #206bc4 !important; /* Màu xanh thương hiệu */
            color: #ffffff !important;
            border-color: #206bc4 !important;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(32, 107, 196, 0.3);
            z-index: 3;
        }

        /* Hover cho các trang thường */
        #sub-account-pagination .page-link:hover {
            background-color: #f0f7ff;
            color: #206bc4;
        }

        /* Responsive cho Mobile */
        @media (max-width: 576px) {
            .pagination .page-link {
                min-width: 28px;
                height: 28px;
                font-size: 12px;
            }
        }
    </style>
@endPush
<div class="gp-tab-panel" id="tab-sub-accounts">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2 gp-sub-header">
        <h4 class="fw-bold mb-0" style="font-size: 18px;">{{ __('Danh sách tài khoản phụ') }}</h4>
        <div class="d-flex gap-2">
            <button class="gp-refresh-btn" onclick="window.refreshSubAccounts()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg> {{ __('Làm mới') }}
            </button>
        </div>
    </div>

    <div class="gp-section-card">
        <div class="table-responsive gp-table-wrapper">
            <table class="gp-table table-vcenter">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="text-nowrap">{{ __('TÊN TÀI KHOẢN PHỤ') }}</th>
                        <th class="text-nowrap">{{ __('MẬT KHẨU') }}</th>
                        <th class="text-nowrap">{{ __('LƯU LƯỢNG RESIDENTIAL') }}</th>
                        <th class="text-nowrap">{{ __('LƯU LƯỢNG DC CÒN LẠI') }}</th>
                        <th class="text-nowrap">{{ __('TRẠNG THÁI') }}</th>
                        <th class="text-nowrap">{{ __('GHI CHÚ') }}</th>
                    </tr>
                </thead>
                <tbody id="sub-account-list" data-provider="{{ $provider }}" data-url-list="{{ route('getProxies.piaproxy.subAccounts.index') }}">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            {{ __('Đang tải dữ liệu...') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="sub-account-pagination" class="mt-3 d-flex justify-content-center"></div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            const container = $('#sub-account-list');
            const paginationContainer = $('#sub-account-pagination');

            if (!container.length) return;

            const config = {
                provider: container.data('provider'),
                routes: {
                    list: container.data('url-list')
                },
                lang: {
                    loading: window.__trans('Đang tải dữ liệu...'),
                    noData: window.__trans('Chưa có tài khoản phụ nào.'),
                    fetchError: window.__trans('Lỗi kết nối máy chủ.'),
                }
            };

            // Hàm lấy dữ liệu chính (Duy nhất 1 hàm này)
            function fetchSubAccounts(page = 1) {
                container.html(`
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            ${config.lang.loading}
                        </td>
                    </tr>
                `);
                paginationContainer.html('');

                AjaxLibrary.get(
                    config.routes.list,
                    {
                        provider: config.provider,
                        page: page,
                        size: 20
                    },
                    function(res) {
                        if (res.success && res.html) {
                            container.html(res.html);
                            // Render phân trang nếu tổng số trang > 1
                            if (res.total_pages > 1) {
                                renderPagination(res.current_page, res.total_pages);
                            }
                        } else {
                            const msg = res.message || res.msg || config.lang.fetchError;
                            container.html(`<tr><td colspan="7" class="text-center py-4 text-danger">${msg}</td></tr>`);
                        }
                    }
                );
            }

            function renderPagination(current, total) {
                // Ép kiểu về số để so sánh chính xác
                current = parseInt(current);
                total = parseInt(total);

                let html = '<ul class="pagination pagination-sm mb-0">';

                // Nút Trước (Previous)
                html += `<li class="page-item ${current === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" data-page="${current - 1}">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                    </a>
                 </li>`;

                // Render các trang số
                for (let i = 1; i <= total; i++) {
                    // Chỉ hiện trang đầu, cuối và các trang xung quanh hiện tại
                    if (i === 1 || i === total || (i >= current - 2 && i <= current + 2)) {
                        // Kiểm tra Active ở đây
                        const activeClass = (i === current) ? 'active' : '';
                        html += `<li class="page-item ${activeClass}">
                        <a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a>
                     </li>`;
                    } else if (i === current - 3 || i === current + 3) {
                        html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                // Nút Sau (Next)
                html += `<li class="page-item ${current === total ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" data-page="${current + 1}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                    </a>
                 </li>`;

                html += '</ul>';
                $('#sub-account-pagination').html(html);
            }

            // Sự kiện click phân trang
            $(document).on('click', '#sub-account-pagination .page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) fetchSubAccounts(page);
            });

            function bindEvents() {
                container.on('click', '.btn-view-pass', function() {
                    const $span = $(this).siblings('.sub-pass-val');
                    const realPass = $span.data('real-pass');

                    if ($(this).hasClass('ti-eye')) {
                        $(this).removeClass('ti-eye').addClass('ti-eye-off');
                        $span.text(realPass);
                    } else {
                        $(this).removeClass('ti-eye-off').addClass('ti-eye');
                        $span.text('••••••••');
                    }
                });
            }

            bindEvents();

            window.addEventListener('tab-init-sub-accounts', function() {
                fetchSubAccounts();
            });

            window.refreshSubAccounts = function() {
                fetchSubAccounts(1);
            };
        });
    </script>
@endpush
