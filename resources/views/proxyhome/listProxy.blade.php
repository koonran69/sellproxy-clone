@extends("proxyhome.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Danh sách đơn hàng proxy</h3>
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
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
                            <li><a class="dropdown-item" href="#" data-field="code" data-placeholder="Order ID">Code</a></li>
                        </ul>
                    </div>

                    <input type="hidden" name="search_by" id="searchBy" value="{{ $searchBy }}">
                    <input type="hidden" name="type_proxy" id="typeProxy" value="static">

                    <input value="{{ $keyword }}" id="filterInput" name="q" class="form-control" type="search" placeholder="@switch($searchBy)
                            @case('code') Code @break
                            @default ID/IP
                          @endswitch" aria-label="Giá trị tìm kiếm">

                    <button class="btn btn-primary-bg btn-pill px-4" id="btnSearch" type="submit">
                        Search
                    </button>
                </form>

                <div class="d-flex align-items-center gap-2">
                    <button id="btnChangePassword" class="btn btn-outline-lightgray btn-pill btn-icon">
                        <i class="fa-solid fa-lock me-2"></i>Đổi password
                    </button>
                    <button id="btnRenew" class="btn btn-outline-lightgray btn-pill btn-icon">
                        <i class="fa-solid fa-calendar-days me-2"></i>Gia hạn
                    </button>
                    <button id="btnChangeProtocal" class="btn btn-outline-lightgray btn-pill btn-icon">
                        <i class="fa-solid fa-shield-halved me-2"></i>Đổi bảo mật
                    </button>
                    <a href="{{ route('proxyhome.exportProxyStatic') }}" class="btn btn-primary-bg btn-pill px-4">
                        Xuất Excel
                    </a>
                </div>

            </div>
            <div class="proxy-static-list proxy-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("proxyhome.searchProxies") }}"
                       data-search="false"
                       data-show-refresh="false"
                       data-show-toggle="false"
                       data-show-columns="false"
                       data-pagination="true"
                       data-side-pagination="server"
                       data-page-size="25"
                       data-query-params="queryParams"
                       data-cookie="true"
                       data-sort-order="desc"
                       data-cookie-id-table="proxy-index"
                       data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                >
                    <thead>
                    <tr>
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="code" data-sortable="true">Code</th>
                        <th data-field="provider" data-sortable="true">Nhà mạng</th>
                        <th data-field="proxy" data-sortable="true" data-formatter="proxyFormatter">Proxy</th>
                        <th data-field="protocol" data-sortable="true">Loại</th>
                        <th data-field="created_at" data-sortable="true" data-formatter="formatDateVN">Ngày mua</th>
                        <th data-field="expired_at" data-sortable="true" data-formatter="formatDateVN">Ngày hết hạn</th>
                        <th data-field="ip_entity_id" data-visible="false">ip_entity_id</th>
                        <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">Cập nhật IP</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('proxyhome.component.change-password')
    @include('proxyhome.component.change-protocal')
    @include('proxyhome.component.renew')
@stop

@section('script')
    <script>
        function copyText(text) {
            if (navigator.clipboard && window.isSecureContext) {
                // Dùng Clipboard API nếu trình duyệt hỗ trợ
                navigator.clipboard.writeText(text).then(() => {
                    msgSuccess(window.__trans('Copy thành công!'));
                }).catch(err => {
                    console.error('Lỗi khi copy:', err);
                });
            } else {
                // Dùng phương pháp cũ nếu Clipboard API không hỗ trợ
                var input = $('<textarea>').val(text).appendTo('body').select();
                try {
                    document.execCommand('copy');
                    msgSuccess(window.__trans('copySuccess'));
                } catch (err) {
                    console.error('Lỗi khi copy:', err);
                }
                input.remove();
            }
        }
        function formatDateVN(value) {
            if (!value) return '';
            const d = new Date(value);
            return d.toLocaleString('vi-VN');
        }
        function truncateString(str, length = 20) {
            if (!str) return '';
            return str.length > length ? str.slice(0, length) + '...' : str;
        }
        function proxyFormatter(value, row, index) {
            var detail = JSON.parse(row.partner_raw);
            // console.log(detail)
            var proxy = truncateString(`${row.ip}:${row.port}:${row.username}:${row.password}`);
            var domain = truncateString(`${detail.proxy.ipaddress.domain}:${row.port}:${row.username}:${row.password}`);
            return `
                  <div>
                    ${proxy} <button class="btn btn-sm btn-warning copy-text" data-text="${row.ip}:${row.port}:${row.username}:${row.password}"><i class="fa-solid fa-copy"></i></button><br>
                    <strong>Domain:</strong> ${domain}<button class="btn btn-sm btn-warning copy-text" data-text="${detail.proxy.ipaddress.domain}:${row.port}:${row.username}:${row.password}"><i class="fa-solid fa-copy"></i></button>
                  </div>
                `;
        }

        function actionFormatter(value, row, index)
        {
            return '<button class="btn btn-sm btn-primary btn-sync me-1" title="Cập nhật IP"><i class="fa-solid fa-cloud-arrow-down"></i></button>';
        }

        function queryParams(params) {
            params.search_by = $('#searchBy').val();
            params.type_proxy = $('#typeProxy').val();
            params.q = $('#filterInput').val();
            return params;
        }
        $(document).on("click", ".copy-text", function () {
            var text = $(this).data("text");
            copyText(text);
            alert('Copy thành công!');
        });

        window.actionEvents = {
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
                    },
                    complete: function () {
                        // setLoadingState(false);
                    }
                });
            },
        };
    </script>
    <script>
        $(function () {
            $('.dropdown-menu .dropdown-item').on('click', function (e) {
                e.preventDefault();
                const text = $(this).text().trim();
                const field = $(this).data('field');
                const ph = $(this).data('placeholder') || text;

                $('#filterByBtn').text(text);
                $('#searchBy').val(field);
                $('#filterInput').attr('placeholder', ph).focus();
            });

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
                url.searchParams.set('type_proxy', 'static');

                url.searchParams.delete('page');

                window.location.href = url.toString();
            });
        });
    </script>

    <script>
        $(function () {
            const modal = new bootstrap.Modal(document.getElementById('modalChangePwd'));

            function setLoadingState(isLoading) {
                const $btn = $('#btnSubmitChangePwd');
                if (isLoading) {
                    $btn.prop('disabled', true);
                    $btn.find('.btn-text').text('Đang cập nhật…');
                    $btn.find('.spinner-border').removeClass('d-none');
                    $('#modalLoadingOverlay').removeClass('d-none');
                    $('#formChangePwd :input').prop('readonly', true);
                    $('#formChangePwd :input[type=submit]').prop('disabled', true);
                    $(modal).find('.btn-close').prop('disabled', true);
                } else {
                    $btn.prop('disabled', false);
                    $btn.find('.btn-text').text('Cập nhật');
                    $btn.find('.spinner-border').addClass('d-none');
                    $('#modalLoadingOverlay').addClass('d-none');

                    $('#formChangePwd :input').prop('readonly', false);
                    $(modal).find('.btn-close').prop('disabled', false);
                }
            }

            $('#btnChangePassword').on('click', function () {
                const selections = $('#demo-custom-toolbar').bootstrapTable('getSelections');

                if (!selections.length) {
                    alert('Vui lòng chọn ít nhất 1 proxy');
                    return;
                }

                const lines = selections.map(o =>
                    `#${o.partner_item_id}\t${o.ip ?? ''}:${o.port}\t${o.username ?? ''}`
                );
                $('#txtSelected').val(lines.join('\n'));

                const items = selections.map(o => ({
                    id: o.id,
                    partner_item_id: o.partner_item_id
                }));
                $('#selectedItemsJson').val(JSON.stringify(items));
                setLoadingState(false);
                modal.show();
            });

            $('#btnUpdateExpired').on('click', function () {
                const selections = $('#demo-custom-toolbar').bootstrapTable('getSelections');

                if (!selections.length) {
                    alert('Vui lòng chọn ít nhất 1 proxy');
                    return;
                }

                const lines = selections.map(o =>
                    `#${o.partner_item_id}\t${o.ip ?? ''}:${o.port}\t${o.username ?? ''}`
                );
                $('#txtSelected').val(lines.join('\n'));

                const items = selections.map(o => ({
                    id: o.id,
                    partner_item_id: o.partner_item_id
                }));
                $('#selectedItemsJson').val(JSON.stringify(items));
                setLoadingState(false);
                modal.show();
            });

            $('#formChangePwd').validate({
                rules: {
                    account: { required: true, minlength: 3 },
                    password: { required: true, minlength: 9 },
                    items: { required: true }
                },
                messages: {
                    account: {
                        required: "Vui lòng nhập tài khoản",
                        minlength: "Tài khoản ít nhất 3 ký tự"
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu",
                        minlength: "Mật khẩu ít nhất 9 ký tự"
                    },
                    items: "Chưa chọn proxy nào"
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
                    setLoadingState(true);
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function (res) {
                            modal.hide();
                            toastr.success('Thay đổi thông tin thành công!', 'Thành công');
                            $('#demo-custom-toolbar').bootstrapTable('refresh');
                        },
                        error: function (xhr) {
                            alert('Có lỗi xảy ra: ' + xhr.responseText);
                        },
                        complete: function () {
                            setLoadingState(false);
                        }
                    });
                    return false;
                }
            });
        });
    </script>

    <script>
        $(function () {
            const unitPrices = @json($unitPrices);
            const PRICE_PER_MONTH_VND = 1200;
            const USE_QUOTE_API = false;
            const QUOTE_API_URL = "#";
            const modalEl = document.getElementById('modalRenew');
            const modalRenew = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false });

            function setRenewLoading(isLoading) {
                const $btn = $('#btnSubmitRenew');
                if (isLoading) {
                    $btn.prop('disabled', true);
                    $btn.find('.btn-text').text('Đang gia hạn…');
                    $btn.find('.spinner-border').removeClass('d-none');
                    $('#modalRenewLoading').removeClass('d-none');
                    $('#formRenew :input').prop('readonly', true);
                    $(modalEl).find('.btn-close').prop('disabled', true);
                } else {
                    $btn.prop('disabled', false);
                    $btn.find('.btn-text').text('Gia hạn');
                    $btn.find('.spinner-border').addClass('d-none');
                    $('#modalRenewLoading').addClass('d-none');
                    $('#formRenew :input').prop('readonly', false);
                    $(modalEl).find('.btn-close').prop('disabled', false);
                }
            }

            function formatVND(n) {
                return (n || 0).toLocaleString('vi-VN') + 'đ';
            }

            let currentSelections = [];

            $('#btnRenew').on('click', function () {
                const selections = $('#demo-custom-toolbar').bootstrapTable('getSelections');
                if (!selections.length) {
                    alert('Vui lòng chọn ít nhất 1 proxy');
                    return;
                }
                currentSelections = selections;

                const lines = selections.map(o =>
                    `#${o.partner_item_id}\t${o.ip ?? ''}:${o.port}\t${o.username ?? ''}`
                );
                $('#txtSelectedRenew').val(lines.join('\n')).removeClass('is-invalid');

                const items = selections.map(o => ({
                    id: o.id,
                    partner_item_id: o.partner_item_id
                }));

                $('#selectedItemsRenewJson').val(JSON.stringify(items));

                $('#formRenew')[0].reset();
                $('#txtSelectedRenew').val(lines.join('\n'));
                $('#totalAmount').text('0đ');

                $('#months').val(1).trigger('input');

                setRenewLoading(false);
                modalRenew.show();
            });

            let quoteTimer = null;
            function updateTotal() {
                const months = parseInt($('#months').val() || '0', 10);
                const qty = currentSelections.length;

                if (!qty || !months || months < 1) {
                    $('#totalAmount').text('0đ');
                    return;
                }

                if (!USE_QUOTE_API) {
                    // const total = qty * months * PRICE_PER_MONTH_VND;
                    let unit = 0;
                    if(months > 30)
                    {
                        const add = months - 30;
                        unit = unitPrices[30] + (600 * add);
                    }else {
                        unit = unitPrices[months];
                    }
                    $('#totalAmount').text(formatVND(unit * qty));
                    return;
                }
                clearTimeout(quoteTimer);
                quoteTimer = setTimeout(function () {
                    const payload = {
                        userProxyIds: currentSelections.map(o => o.ip_entity_id),
                        months: months,
                        autoRenew: $('#autoRenew').is(':checked') ? 1 : 0,
                    };
                    $.ajax({
                        url: QUOTE_API_URL,
                        type: 'POST',
                        data: payload,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (res) {
                            const total = res.total_vnd ?? 0;
                            $('#totalAmount').text(formatVND(total));
                        },
                        error: function () {
                            $('#totalAmount').text('0đ');
                        }
                    });
                }, 200);
            }
            $('#months, #autoRenew').on('input change', updateTotal);

            $('#formRenew').validate({
                rules: {
                    items:  { required: true },
                    months: { required: true, digits: true, min: 1 }
                },
                messages: {
                    items:  "Chưa chọn proxy nào",
                    months: {
                        required: "Vui lòng nhập thời hạn",
                        digits: "Chỉ nhận số nguyên",
                        min: "Tối thiểu 1 tháng"
                    }
                },
                errorClass: 'is-invalid',
                validClass: 'is-valid',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    if (element.parent('.input-group').length) error.insertAfter(element.parent());
                    else error.insertAfter(element);
                },
                submitHandler: function (form) {
                    setRenewLoading(true);

                    const payload = {
                        items: $('#selectedItemsRenewJson').val(),
                        days: $('#months').val(),
                        auto_renew: $('#autoRenew').is(':checked') ? 1 : 0
                    };

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: payload,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            modalRenew.hide();
                            $('#demo-custom-toolbar').bootstrapTable('refresh');
                            toastr.success('Gia hạn thành công!', 'Thành công');
                        },
                        error: function (xhr) {

                            let message = 'Có lỗi xảy ra, vui lòng thử lại';

                            if (xhr.responseJSON) {

                                // Lỗi custom trả về
                                if (xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                // Lỗi validate Laravel
                                if (xhr.responseJSON.errors) {
                                    const errors = Object.values(xhr.responseJSON.errors)
                                        .flat()
                                        .join('<br>');

                                    message = errors;
                                }
                            }

                            toastr.error(message, 'Thất bại');
                        },
                        complete: function () {
                            setRenewLoading(false);
                        }
                    });

                    return false;
                }
            });
        });
    </script>

    <script>
        $(function () {
            const modal = new bootstrap.Modal(document.getElementById('modalChangeProtocal'));

            function setLoadingState(isLoading) {
                const $btn = $('#btnSubmitChangeProtocal');
                if (isLoading) {
                    $btn.prop('disabled', true);
                    $btn.find('.btn-text').text('Đang cập nhật…');
                    $btn.find('.spinner-border').removeClass('d-none');
                    $('#modalLoadingOverlay').removeClass('d-none');
                    $('#formChangeProtocal :input').prop('readonly', true);
                    $('#formChangeProtocal :input[type=submit]').prop('disabled', true);
                    $(modal).find('.btn-close').prop('disabled', true);
                } else {
                    $btn.prop('disabled', false);
                    $btn.find('.btn-text').text('Cập nhật');
                    $btn.find('.spinner-border').addClass('d-none');
                    $('#modalLoadingOverlay').addClass('d-none');

                    $('#formChangeProtocal :input').prop('readonly', false);
                    $(modal).find('.btn-close').prop('disabled', false);
                }
            }

            $('#btnChangeProtocal').on('click', function () {
                const selections = $('#demo-custom-toolbar').bootstrapTable('getSelections');

                if (!selections.length) {
                    alert('Vui lòng chọn ít nhất 1 proxy');
                    return;
                }

                const lines = selections.map(o =>
                    `#${o.partner_item_id}\t${o.ip ?? ''}:${o.port}\t${o.username ?? ''}`
                );
                $('#txtSelectedProtocal').val(lines.join('\n'));

                const items = selections.map(o => ({
                    id: o.id,
                    partner_item_id: o.partner_item_id
                }));
                $('#selectedItemsProtocalJson').val(JSON.stringify(items));
                setLoadingState(false);
                modal.show();
            });

            $('#formChangeProtocal').validate({
                rules: {
                    protocal: { required: true },
                },
                messages: {
                    protocal: {
                        required: "Chọn giao thức",
                    },
                    items: "Chưa chọn proxy nào"
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
                    setLoadingState(true);
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function (res) {
                            modal.hide();
                            toastr.success('Thay đổi thông tin thành công!', 'Thành công');
                            $('#demo-custom-toolbar').bootstrapTable('refresh');
                        },
                        error: function (xhr) {
                            alert('Có lỗi xảy ra: ' + xhr.responseText);
                        },
                        complete: function () {
                            setLoadingState(false);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@stop
