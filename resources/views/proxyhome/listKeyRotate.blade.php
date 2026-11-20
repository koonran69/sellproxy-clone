@extends("proxyhome.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">Danh sách đơn hàng key xoay</h3>

            <!-- Bộ lọc tìm kiếm & Thao tác -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <form id="filterForm" class="d-flex align-items-center gap-2" role="search">
                    @php
                        $searchBy = $search_by ?? 'id';
                        $keyword  = $q ?? '';
                    @endphp
                    <div class="dropdown">
                        <button class="btn btn-outline-lightgray btn-pill dropdown-toggle" type="button" id="filterByBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            @switch($searchBy)
                                @case('code') Code @break
                                @default ID/IP
                            @endswitch
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterByBtn">
                            <li><a class="dropdown-item" href="#" data-field="id" data-placeholder="ID">ID/IP</a></li>
                            <li><a class="dropdown-item" href="#" data-field="code" data-placeholder="Code">Code</a></li>
                        </ul>
                    </div>

                    <input type="hidden" name="search_by" id="searchBy" value="{{ $searchBy }}">
                    <input type="hidden" name="type_proxy" id="typeProxy" value="key-rotate">

                    <input value="{{ $keyword }}" id="filterInput" name="q" class="form-control" type="search" placeholder="@switch($searchBy)
                            @case('code') Order Code @break
                            @default ID/IP
                          @endswitch" aria-label="Giá trị tìm kiếm">

                    <button class="btn btn-primary-bg btn-pill px-4" id="btnSearch" type="submit">
                        Search
                    </button>
                </form>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('proxyhome.exportProxyRotate', ['type'=>'key-rotate']) }}" class="btn btn-primary-bg btn-pill px-4">
                        Xuất Excel
                    </a>
                </div>
            </div>

            <!-- Bảng danh sách -->
            <div class="proxy-static-list proxy-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("proxyhome.searchRotateProxies") }}"
                       data-search="false"
                       data-show-refresh="false"
                       data-show-toggle="false"
                       data-show-columns="false"
                       data-pagination="true"
                       data-side-pagination="server"
                       data-page-size="25"
                       data-query-params="queryParams"
                       data-cookie="false"
                       data-sort-order="desc"
                       data-cookie-id-table="proxy-index"
                >
                    <thead>
                    <tr>
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="code">Code</th>
                        <th data-field="key" data-sortable="false" data-formatter="keyFormatter">Key</th>
                        <th data-field="protocol" data-formatter="protocolFormat" data-sortable="true">Loại</th>
                        <th data-field="expired_at" data-sortable="true" data-formatter="formatDateVNExiperd" data-events="actionEvents">Ngày hết hạn</th>
                        <th data-field="partner_created_at" data-sortable="true" data-formatter="formatDateVN">Ngày mua</th>
                        <th data-field="ip_entity_id" data-visible="false">ip_entity_id</th>
                        <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">Cập nhật</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Các Modal liên quan -->
    @include('proxyhome.component.change-password-rotate')
    @include('proxyhome.component.confirm-renew')
@stop

@section('script')
    <script>
        // ==========================================
        // 1. CÁC HÀM TIỆN ÍCH & FORMAT DỮ LIỆU
        // ==========================================
        function formatVND(n) {
            return (n || 0).toLocaleString('vi-VN') + 'đ';
        }

        function formatDateVN(value) {
            if (!value) return '';
            return new Date(value).toLocaleString('vi-VN');
        }

        function truncateString(str, length = 25) {
            if (!str) return '';
            return str.length > length ? str.slice(0, length) + '...' : str;
        }

        function copyText(text) {
            if (!text) {
                toastr.warning('Không có nội dung để copy!');
                return;
            }
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    toastr.success('Copy '+text+' thành công!');
                }).catch(err => {
                    console.error('Lỗi khi copy:', err);
                });
            } else {
                var input = $('<textarea>').val(text).appendTo('body').select();
                try {
                    document.execCommand('copy');
                    toastr.success('Copy '+text+' thành công!');
                } catch (err) {
                    console.error('Lỗi khi copy:', err);
                }
                input.remove();
            }
        }

        function keyFormatter(value, row, index) {
            const uniqueId = row.id || row.partner_item_id;
            const containerId = `key-container-${uniqueId}`;

            setTimeout(() => {
                fetchKeyToken(row, containerId);
            }, index * 80);

            return `
                <div id="${containerId}" class="d-flex align-items-center gap-1">
                    <span class="text-muted spinner-border spinner-border-sm" role="status"></span>
                    <span class="ms-1 small text-secondary">Đang tải key...</span>
                </div>
            `;
        }

        // Hàm thực hiện gọi AJAX lấy token key rotate
        function fetchKeyToken(row, containerId) {
            const $container = $(`#${containerId}`);
            if ($container.data('loaded')) return;

            const url = `{{ route('proxyhome.generateTokenKeyRotate', ':id') }}`.replace(':id', row.partner_item_id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    const token = res.token || '';
                    if (token) {
                        $container.data('loaded', true);
                        $container.html(`
                            <span class="font-monospace text-dark" title="${token}">${truncateString(token, 20)}</span>
                            <button class="btn btn-sm btn-warning copy-text py-0 px-1" data-text="${token}" title="Copy Key">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        `);
                    } else {
                        $container.html('<span class="text-danger small">Không có key</span>');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Lỗi tải key';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    $container.html(`<span class="text-danger small" title="${errorMsg}">${errorMsg}</span>`);
                }
            });
        }

        function protocolFormat(value, row, index) {
            return 'HTTP/SOCKS5';
        }

        function formatDateVNExiperd(value, row, index) {
            return `
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <span>${formatDateVN(value)}</span>
                    <button class="btn btn-sm btn-warning btn-renew text-nowrap">Gia hạn</button>
                </div>
            `;
        }

        function actionFormatter(value, row, index) {
            var route = '{{ route('proxyhome_free_rotate') }}' + '?id=' + row.id;
            var fullProxyStr = `${row.ip || ''}:${row.port || ''}:${row.username || ''}:${row.password || ''}`;
            return `
                <button class="btn btn-sm btn-secondary copy-text m-1" data-text="${fullProxyStr}" title="Xem proxy hiện tại"><i class="fa-solid fa-eye"></i></button>
                <button class="btn btn-sm btn-primary btn-sync m-1" title="Cập nhật Proxy"><i class="fa-solid fa-cloud-arrow-down"></i></button>
                <button class="btn btn-sm btn-info btn-rotate m-1" title="Xoay Proxy"><i class="fa-solid fa-rotate-right"></i></button>
                <button class="btn btn-sm btn-warning copy-text m-1" data-text="${route}" title="Link API"><i class="fa-solid fa-copy"></i></button>
            `;
        }

        function queryParams(params) {
            params.search_by = $('#searchBy').val();
            params.type_proxy = $('#typeProxy').val();
            params.q = $('#filterInput').val();
            return params;
        }

        // ==========================================
        // 3. KHAI BÁO SỰ KIỆN CHO CÁC NÚT TRONG BẢNG (ACTION EVENTS)
        // ==========================================
        window.actionEvents = {
            'click .btn-rotate': function (e, value, row, index) {
                $.ajax({
                    url: '{{ route('proxyhome.actionRotate') }}',
                    type: 'GET',
                    data: { id: row.id },
                    success: function (res) {
                        toastr.success('Xoay thành công', 'Thành công');
                        $('#demo-custom-toolbar').bootstrapTable('refresh');
                    },
                    error: function (xhr) {
                        alert('Có lỗi xảy ra: ' + xhr.responseText);
                    }
                });
            },

            'click .btn-sync': function (e, value, row, index) {
                $.ajax({
                    url: '{{ route('proxyhome.sync') }}',
                    type: 'GET',
                    data: { id: row.id },
                    success: function (res) {
                        toastr.success('Cập nhật thành công', 'Thành công');
                        $('#demo-custom-toolbar').bootstrapTable('refresh');
                    },
                    error: function (xhr) {
                        alert('Có lỗi xảy ra: ' + xhr.responseText);
                    }
                });
            },

            'click .btn-renew': function (e, value, row, index) {
                const $modal = $('#modalConfirmRenew');
                const days = row.order?.days || 1;
                let unitPrice = 0;

                if (row.order) {
                    const originalAmount = parseFloat(row.order.amount) || 0;
                    const originalDays = parseInt(row.order.days) || 1;
                    unitPrice = originalAmount / originalDays;
                }

                const totalPrice = Math.round(unitPrice * days);

                // Gắn dữ liệu trực tiếp vào modal xác nhận
                $modal.find('.js-renew-ip').text(row.code ? `Code: ${row.code}` : `#${row.partner_item_id}`);
                $modal.find('.js-renew-days').text(`${days} ngày`);
                $modal.find('.js-renew-price').text(formatVND(totalPrice));

                // Lưu dữ liệu row tạm thời vào modal
                $modal.data('row', row);

                new bootstrap.Modal(document.getElementById('modalConfirmRenew')).show();
            }
        };

        // ==========================================
        // 4. KHỞI TẠO DOM & XỬ LÝ SỰ KIỆN TOÀN CỤC
        // ==========================================
        $(function () {
            // Dropdown chọn bộ lọc tìm kiếm
            $('.dropdown-menu .dropdown-item').on('click', function (e) {
                e.preventDefault();
                const text = $(this).text().trim();
                const field = $(this).data('field');
                const ph = $(this).data('placeholder') || text;

                $('#filterByBtn').text(text);
                $('#searchBy').val(field);
                $('#filterInput').attr('placeholder', ph).focus();
            });

            // Submit form tìm kiếm
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                const field = $('#searchBy').val();
                const q = $('#filterInput').val().trim();

                if (!q) {
                    $('#filterInput').focus();
                    return;
                }

                const url = new URL(window.location.href);
                url.searchParams.set('search_by', field);
                url.searchParams.set('q', q);
                url.searchParams.set('type_proxy', 'key-rotate');
                url.searchParams.delete('page');

                window.location.href = url.toString();
            });

            // Sự kiện click copy nội dung (sử dụng Event Delegation)
            $(document).on("click", ".copy-text", function () {
                copyText($(this).data("text"));
            });

            // Xử lý xác nhận gia hạn từ Modal
            $(document).on('click', '#btnConfirmRenewAction', function() {
                var $modal = $('#modalConfirmRenew');
                var row = $modal.data('row');
                var $btn = $(this);

                if (!row) return;

                $btn.prop('disabled', true).text('Đang xử lý...');

                $.ajax({
                    url: '{{ route('proxyhome.bulkRenew') }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        items: JSON.stringify([row]),
                        days: row.order.days,
                        cat_type_id: 2
                    },
                    success: function (res) {
                        toastr.success('Gia hạn thành công', 'Thành công');
                        $('#demo-custom-toolbar').bootstrapTable('refresh');
                        bootstrap.Modal.getInstance(document.getElementById('modalConfirmRenew')).hide();
                    },
                    error: function (xhr) {
                        alert('Có lỗi xảy ra: ' + (xhr.responseJSON?.message || xhr.responseText));
                    },
                    complete: function () {
                        $btn.prop('disabled', false).text('Xác nhận gia hạn');
                    }
                });
            });

            // Xử lý Validate form đổi mật khẩu (Change Password) nếu tồn tại
            const modalChangePwdEl = document.getElementById('modalChangePwd');
            const modalChangePwdObj = modalChangePwdEl ? new bootstrap.Modal(modalChangePwdEl) : null;

            if ($('#formChangePwd').length) {
                $('#formChangePwd').validate({
                    rules: {
                        password: { required: true, minlength: 9 },
                        rowId: { required: true }
                    },
                    messages: {
                        password: {
                            required: "Vui lòng nhập mật khẩu",
                            minlength: "Mật khẩu ít nhất 9 ký tự"
                        }
                    },
                    errorClass: 'is-invalid',
                    validClass: 'is-valid',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            url: $(form).attr('action'),
                            type: 'POST',
                            data: $(form).serialize(),
                            success: function (res) {
                                if (modalChangePwdObj) modalChangePwdObj.hide();
                                toastr.success('Thay đổi thông tin thành công!', 'Thành công');
                                $('#demo-custom-toolbar').bootstrapTable('refresh');
                            },
                            error: function (xhr) {
                                alert('Có lỗi xảy ra: ' + xhr.responseText);
                            }
                        });
                        return false;
                    }
                });
            }
        });
    </script>
@stop
