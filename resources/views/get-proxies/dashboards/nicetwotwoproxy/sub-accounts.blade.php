<div class="gp-tab-panel" id="tab-sub-accounts">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2 gp-sub-header">
        <h4 class="fw-bold mb-0" style="font-size: 18px;">{{ __('Danh sách tài khoản phụ') }}</h4>
        <div class="d-flex gap-2">
            <button class="gp-btn-secondary" onclick="window.refreshSubAccounts()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg> {{ __('Làm mới') }}
            </button>
            <button class="gp-btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSubAccount">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> {{ __('Thêm tài khoản phụ') }}
            </button>
        </div>
    </div>

    <div class="gp-section-card">
        <div class="gp-table-wrapper">
            <table class="gp-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('TÊN TÀI KHOẢN PHỤ') }}</th>
                        <th>{{ __('MẬT KHẨU') }}</th>
                        <th>{{ __('GIỚI HẠN LƯU LƯỢNG') }}</th>
                        <th>{{ __('ĐÃ SỬ DỤNG') }}</th>
                        <th>{{ __('TRẠNG THÁI') }}</th>
                        <th style="text-align: right;">{{ __('THAO TÁC') }}</th>
                    </tr>
                </thead>
                <tbody id="sub-account-list" data-provider="{{ $provider }}"
                    data-url-list="{{ route('getProxies.nicetwotwoproxy.subAccounts.index') }}"
                    data-url-add="{{ route('getProxies.nicetwotwoproxy.subAccounts.add') }}"
                    data-url-delete="{{ route('getProxies.nicetwotwoproxy.subAccounts.delete') }}"
                    data-url-update="{{ route('getProxies.nicetwotwoproxy.subAccounts.update') }}">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            {{ __('Đang tải dữ liệu...') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('get-proxies.dashboards.nicetwotwoproxy.sub-accounts-modals')

@push('js')
    <script>
        $(document).ready(function() {

            const container = $('#sub-account-list');

            if (!container.length) return;

            const config = {
                provider: container.data('provider'),
                routes: {
                    list: container.data('url-list'),
                    add: container.data('url-add'),
                    delete: container.data('url-delete'),
                    update: container.data('url-update'),
                },
                lang: {
                    loading: window.__trans('Đang tải dữ liệu...'),
                    noData: window.__trans('Chưa có tài khoản phụ nào.'),
                    fetchError: window.__trans('Lỗi kết nối máy chủ.'),
                    confirmDelete: window.__trans('Bạn có chắc chắn muốn xóa tài khoản phụ này?'),
                    addSuccess: window.__trans('Thêm tài khoản phụ thành công!'),
                    deleteSuccess: window.__trans('Xóa tài khoản phụ thành công!'),
                    updateSuccess: window.__trans('Cập nhật tài khoản phụ thành công!'),
                    changePass: window.__trans('Đổi mật khẩu'),
                    delete: window.__trans('Xóa'),
                    available: window.__trans('Khả dụng'),
                    disabled: window.__trans('Vô hiệu hóa')
                }
            };


            function fetchSubAccounts(page = 1) {
                container.html(`
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            ${config.lang.loading}
                        </td>
                    </tr>
                `);

                AjaxLibrary.get(
                    config.routes.list, {
                        provider: config.provider,
                        page: page
                    },

                    function(res) {
                        if (res.success && res.html) {
                            container.html(res.html);
                        } else {
                            const msg = res.message || res.msg || config.lang.fetchError;
                            container.html(
                                `<tr><td colspan="6" class="text-center py-4 text-danger">${msg}</td></tr>`
                            );
                        }
                    });
            }

            function addSubAccount(formData) {
                AjaxLibrary.post(
                    config.routes.add, formData + '&provider=' + config.provider + '&_token=' + token,
                    function(res) {
                        if (res.success) {
                            msgSuccess(config.lang.addSuccess);
                            $('#modalAddSubAccount').modal('hide');
                            $('#formAddSubAccount')[0].reset();
                            fetchSubAccounts();
                        } else {
                            msgError(res.message);
                        }
                    });
            }

            let deleteSubAccount = null;

            $('#confirm-delete-sub').on('click', function() {
                if (!deleteSubAccount) return;

                const $btn = $(this);
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                AjaxLibrary.post(
                    config.routes.delete, {
                        account: deleteSubAccount,
                        provider: config.provider,
                        _token: token
                    },
                    function(res) {
                        $btn.prop('disabled', false).text("{{ __('Xoá') }}");
                        $('#modalDeleteSubAccount').modal('hide');
                        if (res.success) {
                            msgSuccess(config.lang.deleteSuccess);
                            fetchSubAccounts();
                            deleteSubAccount = null;
                        } else {
                            deleteSubAccount = null;
                            msgError(res.message);
                        }
                    });
            });

            function updateSubAccount(formData) {

                AjaxLibrary.post(config.routes.update, formData + '&provider=' + config.provider + '&_token=' +
                    token,
                    function(res) {
                        if (res.success) {
                            msgSuccess(config.lang.updateSuccess);
                            $('#modalUpdateSubAccount').modal('hide');
                            fetchSubAccounts();
                        } else {
                            msgError(res.message);
                        }
                    });
            }

            function bindEvents() {
                $('#formAddSubAccount').on('submit', function(e) {
                    e.preventDefault();
                    addSubAccount($(this).serialize());
                });

                $('#formUpdateSubAccount').on('submit', function(e) {
                    e.preventDefault();
                    updateSubAccount($(this).serialize());
                });
                // Sử dụng cho cả table và modal
                $(document).on('click', '.btn-view-pass', function() {
                    const $btn = $(this);
                    // Tìm container gần nhất bọc cả nút và trường pass
                    const $container = $btn.closest('.gp-password-field, .position-relative');
                    // Tìm field pass (có thể là span trong table hoặc input trong modal)
                    const $field = $container.find('.sub-pass-val, input[name="password"]');

                    if ($btn.hasClass('ti-eye')) {
                        // Chuyển sang trạng thái HIỆN
                        $btn.removeClass('ti-eye').addClass('ti-eye-off');

                        if ($field.is('input')) {
                            // Xử lý cho Modal (Input)
                            $field.attr('type', 'text');
                        } else {
                            // Xử lý cho Table (Span)
                            const realPass = $field.data('real-pass');
                            $field.text(realPass);
                        }
                    } else {
                        // Chuyển sang trạng thái ẨN
                        $btn.removeClass('ti-eye-off').addClass('ti-eye');

                        if ($field.is('input')) {
                            // Xử lý cho Modal (Input)
                            $field.attr('type', 'password');
                        } else {
                            // Xử lý cho Table (Span)
                            $field.text('••••••••');
                        }
                    }
                });

                container.on('click', '.btn-delete-sub', function() {
                    const item = $(this).data('subaccount');
                    const $modal = $('#modalDeleteSubAccount');
                    deleteSubAccount = item.account;
                    $modal.find('.account-delete').text(item.account);
                    $modal.modal('show');
                });

                container.on('click', '.btn-edit-sub', function() {
                    const item = $(this).data('subaccount');
                    const $modal = $('#modalUpdateSubAccount');
                    const $form = $('#formUpdateSubAccount');
                    $form[0].reset();
                    $modal.find('input[name="original_account"]').val(item.account);
                    $modal.find('input[name="username"]').val(item.account);
                    $modal.find('input[name="password"]').val(item.password);
                    $modal.find('input[name="limit"]').val(item.traffic_limit);
                    $modal.find('textarea[name="remark"]').val(item.remark || '');
                    $modal.modal('show');
                });

                window.toggleModalPass = function(inputId) {
                    const $input = $(`#${inputId}`);
                    $input.attr('type', $input.attr('type') === 'password' ? 'text' : 'password');
                };
            }

            bindEvents();

            window.addEventListener('tab-init-sub-accounts', function() {
                fetchSubAccounts();
            });

            window.refreshSubAccounts = fetchSubAccounts;
        });
    </script>
@endpush
