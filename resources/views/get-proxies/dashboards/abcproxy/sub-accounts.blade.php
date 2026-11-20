<div class="gp-tab-panel" id="tab-sub-accounts">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2 gp-sub-header">
        <h4 class="fw-bold mb-0" style="font-size: 18px;">{{ __('Danh sách tài khoản phụ') }}</h4>
        <div class="d-flex gap-2">
            <button class="gp-btn-secondary" onclick="window.refreshSubAccounts()">
                <i class="ti ti-refresh"></i> {{ __('Làm mới') }}
            </button>
            <button class="gp-btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSubAccount">
                <i class="ti ti-plus"></i> {{ __('Thêm tài khoản phụ') }}
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
                        <th>{{ __('TRẠNG THÁI') }}</th>
                        <th style="text-align: right;">{{ __('THAO TÁC') }}</th>
                    </tr>
                </thead>
                <tbody id="sub-account-list" data-provider="{{ $provider }}"
                    data-url-list="{{ route('getProxies.abcproxy.subAccounts.index') }}"
                    data-url-add="{{ route('getProxies.abcproxy.subAccounts.add') }}"
                    data-url-toggle="{{ route('getProxies.abcproxy.subAccounts.toggle') }}"
                    data-url-delete="{{ route('getProxies.abcproxy.subAccounts.delete') }}"
                    data-url-update="{{ route('getProxies.abcproxy.subAccounts.update') }}">
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

@include('get-proxies.dashboards.abcproxy.sub-accounts-modals')

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
                    toggle: container.data('url-toggle'),
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
                    toggleStatus: window.__trans('Bật/Tắt'),
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

            function toggleSubAccountStatus(id, status) {
                AjaxLibrary.post(
                    config.routes.toggle, {
                        id: id,
                        status: status,
                        provider: config.provider,
                        _token: token
                    },
                    function(res) {
                        if (res.success) {
                            fetchSubAccounts();
                        } else {
                            msgError(res.message);
                        }
                    });
            }

            let deleteId = null;

            function deleteSubAccount(id, status) {
                if (status == 1) {
                    msgError(
                        '{{ __('Tài khoản đang hoạt động, vui lòng đổi trạng thái sang [Không khả dụng] trước khi xóa.') }}'
                    );
                    return;
                }
                deleteId = id;
                $('#modalDeleteSubAccount').modal('show');
            }

            $('#confirm-delete-sub').on('click', function() {
                if (!deleteId) return;

                const $btn = $(this);
                $btn.prop('disabled', true);

                AjaxLibrary.post(
                    config.routes.delete, {
                        id: deleteId,
                        provider: config.provider,
                        _token: token
                    },
                    function(res) {
                        $btn.prop('disabled', false);
                        $('#modalDeleteSubAccount').modal('hide');
                        if (res.success) {
                            msgSuccess(config.lang.deleteSuccess);
                            fetchSubAccounts();
                            deleteId = null;
                        } else {
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


            function openEditModal(account, state) {
                const $modal = $('#modalUpdateSubAccount');
                $modal.find('input[name="account"]').val(account);
                $modal.find('#update-sub-display-name').text(account);
                $modal.find('input[name="state"]').val(state);
                $modal.find('#update-sub-pass').val('');
                $modal.modal('show');
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
                container.on('click', '.btn-view-pass', function() {
                    const $span = $(this).siblings('.sub-pass-val');
                    const realPass = $span.data('real-pass');
                    $span.text($span.text() === '••••••••' ? realPass :
                        realPass);

                    if ($(this).hasClass('ti-eye')) {
                        $(this).removeClass('ti-eye').addClass('ti-eye-off');
                        $span.text(realPass);
                    } else {
                        $(this).removeClass('ti-eye-off').addClass('ti-eye');
                        $span.text('••••••••');
                    }
                });

                container.on('click', '.btn-toggle-sub', function() {
                    toggleSubAccountStatus($(this).data('id'), $(this).data('status'));
                });

                container.on('click', '.btn-delete-sub', function() {
                    deleteSubAccount($(this).data('id'), $(this).data('status'));
                });

                container.on('click', '.btn-edit-sub', function() {
                    openEditModal($(this).data('account'), $(this).data('state'));
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
