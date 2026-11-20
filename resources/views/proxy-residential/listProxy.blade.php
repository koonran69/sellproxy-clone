@extends("proxy-residential.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Danh sách đơn hàng proxy</h3>
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <form id="filterForm" class="d-flex align-items-center gap-2" role="search">
                    @php
                        $searchBy = request('search_by', 'id');
                        $keyword  = request('q', '');
                    @endphp
                    <div class="dropdown">
                        <button class="btn btn-outline-lightgray btn-pill dropdown-toggle" type="button" id="filterByBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            @switch($searchBy)
                                @case('code') Mã đơn hàng @break
                                @default Proxy ID/IP
                            @endswitch
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterByBtn">
                            <li><a class="dropdown-item" href="#" data-field="id" data-placeholder="Proxy ID/IP">Proxy ID/IP</a></li>
                            <li><a class="dropdown-item" href="#" data-field="code" data-placeholder="Mã đơn hàng">Mã đơn hàng</a></li>
                        </ul>
                    </div>

                    <input type="hidden" name="search_by" id="searchBy" value="{{ $searchBy }}">

                    <input value="{{ $keyword }}" id="filterInput" name="q" class="form-control" type="search" placeholder="@switch($searchBy)
                            @case('code') Mã đơn hàng @break
                            @default Proxy ID/IP
                             @endswitch" aria-label="Giá trị tìm kiếm">

                    <button class="btn btn-primary-bg btn-pill px-4" id="btnSearch" type="submit">
                        Search
                    </button>
                </form>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('proxyResidential.exportProxyStatic') }}" class="btn btn-primary-bg btn-pill px-4">
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
                       data-url="{{ route("proxyResidential.searchProxies") }}"
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
                        <th data-field="id" data-sortable="true">STT</th>
                        <th data-field="partner_order_id" data-sortable="true">Mã (Partner Order)</th>
                        <th data-field="pr_order_id" data-sortable="true">Mã đơn hàng</th>
                        <th data-field="proxy" data-sortable="true" data-formatter="proxyFormatter">Proxy</th>
                        <th data-field="networkType" data-sortable="true">Network</th>
                        <th data-field="ipVersion" data-sortable="true">IP Version</th>
                        <th data-field="proxyType" data-sortable="true">Loại</th>
                        <th data-field="location" data-sortable="true" data-formatter="locationFormatter">Quốc gia</th>
                        <th data-field="isp" data-sortable="true" data-formatter="ispFormatter">ISP</th>
                        <th data-field="partner_createdAt" data-sortable="true" data-formatter="formatDateVN">Ngày mua</th>
                        <th data-field="partner_expiresAt" data-sortable="true" data-formatter="formatDateVN">Ngày hết hạn</th>
                        <th data-field="note" data-sortable="false" data-formatter="formatNote">Ghi chú</th>
                        <th data-field="ip_entity_id" data-visible="false">ip_entity_id</th>
                        <th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">Thao tác</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('proxy-residential.component.change-auth')
    @include('proxy-residential.component.change-protocol')
    @include('proxy-residential.component.extend-proxy')
    @include('proxy-residential.component.change-note')
@stop

@section('script')
    <script>
        const vnd    = n => (Number(n)||0).toLocaleString('vi-VN') + 'đ';
        const assetBase = "{{ asset('') }}";
        const rate = @json($rate);
        const isps = @json($isps);
        function copyText(text) {
            if (navigator.clipboard && window.isSecureContext) {
                // Trình duyệt hiện đại hỗ trợ Clipboard API
                navigator.clipboard.writeText(text)
                    .then(() => {
                        alert('Copy thành công');
                    })
                    .catch(err => {
                        console.error('Lỗi khi copy:', err);
                    });
            } else {
                // Cách cũ cho trình duyệt không hỗ trợ Clipboard API
                var input = $('<textarea>').val(text).appendTo('body').select();
                try {
                    document.execCommand('copy');
                    alert('Copy thành công');
                } catch (err) {
                    console.error('Lỗi khi copy:', err);
                }
                input.remove();
            }
        }

        function ispFormatter(value, row, index) {
            if (row.order && row.order.isp) {
                const location = row.order.location;
                const ispId = row.order.isp;
                const ispItem = isps?.[location.code]?.[ispId];
                if (ispItem) {
                    return `
                        <div class="d-flex align-items-center gap-2">
                            <span>${ispItem.label}</span>
                        </div>
                    `;
                }
            }
        }
        function locationFormatter(value, row, index) {
            if (row.order && row.order.location) {
                const location = row.order.location;
                // const imgPath = assetBase + location.feature_image.replace(/^public\//, '');
                const imgPath = assetBase + location.feature_image;
                return `
                    <div class="d-flex align-items-center gap-2">
                        <img src="${imgPath}" width="28" height="20" class="rounded shadow-sm border" alt="${location.name}">
                        <div>
                            <div class="fw-semibold text-dark">${location.name}</div>
                            <div class="text-muted small">Mã code: <span class="fw-medium">${location.code ?? 'N/A'}</span></div>
                        </div>
                    </div>
                `;
            } else {
                return `<span class="text-muted fst-italic">Không có dữ liệu quốc gia</span>`;
            }
        }
        function proxyFormatter(value, row, index) {
            let ip_port = '';
            let ip_port_username_pass = '';
            let username_pass_ip_port =  '';
            if(row.ipVersion === "IPv4"){
                ip_port = `${row.publicIp}:${row.httpPort ?? row.socks5Port ?? row.httpsPort}`;
                ip_port_username_pass = `${ip_port}:${row.username}:${row.password}`;
                username_pass_ip_port = `${row.username}:${row.password}@${ip_port}`;
            }else{
                // IPv6 — nhiều địa chỉ trong object hostnames
                // Duyệt qua từng key:value
                Object.entries(row.hostnames).forEach(([key, ipv6]) => {
                    // Lấy port từ key (phần sau dấu :)
                    const ipv4 = key.split(':')[0];
                    const port = key.split(':')[1];
                    // 1. Bên thứ 3 cũng đang cho sao chép theo ipv4 nên cứ làm giống bên đó
                    const ipv4_with_port = `${ipv4}:${port}`;
                    // 2. Tạo các dạng chuỗi cần copy
                    ip_port += ipv4_with_port;
                    ip_port_username_pass += ipv4_with_port+`:${row.username}:${row.password}`;
                    username_pass_ip_port += `${row.username}:${row.password}@`+ipv4_with_port
                });
            }

            return `
                <div>
                    <div class="d-flex">Proxy ID: ${row.proxy_id}</div>
                    <br>
                    <div class="d-flex">IP:PORT
                        <button class="btn btn-sm btn-warning copy-text" data-text="${ip_port}">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                    <br>
                    <div class="d-flex">IP:PORT:USERNAME:PASSWORD
                        <button class="btn btn-sm btn-warning copy-text" data-text="${ip_port_username_pass}">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                    <br>
                    <div class="d-flex">USERNAME:PASSWORD@IP:PORT
                        <button class="btn btn-sm btn-warning copy-text" data-text="${username_pass_ip_port}">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                </div>
            `;
        }

        function formatNote(value){
            if (!value) return '-';

            // Giới hạn 10 từ
            const words = value.split(' ');
            if (words.length > 10) {
                return words.slice(0, 10).join(' ') + '...';
            }
            return value;
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

        function actionFormatter(value, row, index)
        {
            $html = '';

            if(row.order.service === 'dedicated-mobile'){
                $html += '<button class="btn btn-sm btn-primary btn-sync me-1" title="Cập nhật IP"><i class="fa-solid fa-cloud-arrow-down"></i></button>';
            }else{
                // $html += '<span class="badge bg-danger">Không hỗ trợ</span>';
            }

            $html += `<button id="btnChangeAuth" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start open-modal-form"> <i class="fa-solid fa-rotate me-2"></i>Đổi password</button>`;

            $html += `<button id="btnChangeProtocol" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start"> <i class="fa-solid fa-pen-to-square me-2"></i>Đổi giao thức</button>`;

            $html += `<button id="btnExtendproxy" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start"><i class="fa-solid fa-calendar-days me-2"></i>Gia hạn</button>`

            $html += `<button id="btnChangeNote" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start"> <i class="fa-solid fa-pen-to-square me-2"></i>Ghi chú</button>`;

            return $html;
        }

        function queryParams(params) {
            params.search_by = $('#searchBy').val();
            params.q = $('#filterInput').val();
            return params;
        }
        $(document).on("click", ".copy-text", function () {
            var text = $(this).data("text");
            copyText(text);
        });

        window.actionEvents = {
            'click .btn-sync': function (e, value, row, index) {
                $.ajax({
                    url: '{{ route('proxyResidential.sync') }}',
                    type: 'GET',
                    data: { id: row.id },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Cập nhật thành công', 'Thành công');
                            $('#demo-custom-toolbar').bootstrapTable('refresh');
                        } else {
                            toastr.error(res.message || 'Thao tác thất bại', 'Lỗi');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'Có lỗi xảy ra';
                        try {
                            const res = JSON.parse(xhr.responseText);
                            msg = res.message || res.error || msg;
                        } catch (e) {
                            if (xhr.responseText) msg = xhr.responseText;
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                    complete: function () {
                        // setLoadingState(false);
                    }
                });
            },
        };

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

                // Gán vào hidden input để queryParams() lấy được
                $('#searchBy').val(field);
                $('#filterInput').val(q);

                // Gọi reload bảng
                $('#demo-custom-toolbar').bootstrapTable('refresh', {pageNumber: 1});
            });
        });

        $(function () {
            const modalExtendProxy= new bootstrap.Modal(document.getElementById('modalExtendProxy'));
            $(document).on('click', '#btnExtendproxy', function () {
                const $btn = $(this);
                const id = $btn.data('id');
                const row = JSON.parse(decodeURIComponent($btn.data('row')));
                const $form = $('#formExtendProxy');
                const $select = $form.find('select[name="time_period"]');
                const $amount = $('#totalAmount');

                $form.find('input[name="id"]').val(id);

                function getServiceDetail() {
                    return $.ajax({
                        url: '{{ route('proxyResidential.ajaxServiceDetail') }}',
                        method: 'GET',
                        data: {
                            service_id: row.order.service,
                            plan_id: row.order.plan,
                        }
                    });
                }

                function getPeriodExtensionPrice(proxy_id, month) {
                    return $.ajax({
                        url: '{{ route('proxyResidential.ajaxPeriodExtensionPrice') }}',
                        method: 'GET',
                        data: {
                            proxy_id: proxy_id,
                            month: month,
                        }
                    });
                }

                getServiceDetail().then(res => {
                    if (res.success) {
                        const service = res.data;
                        $select.empty();
                        $select.append('<option value="">-- Chọn thời gian --</option>');
                        service.periods.months.forEach(month => {
                            $select.append(`<option value="${month}">${month} tháng</option>`);
                        });

                        // Set sẵn selected tháng hiện tại
                        if (row.order && row.order.month) {
                            $select.val(row.order.month);
                        }
                        modalExtendProxy.show();

                        //lấy giá
                        const selectedMonth = $select.val();
                        if (selectedMonth) {
                            $amount.html('<span class="spinner-border spinner-border-sm"></span>');
                            getPeriodExtensionPrice(row.proxy_id, selectedMonth)
                                .done(function (res) {
                                    if (res.success) {
                                        $amount.text(vnd(res.data.finalPrice * rate.VND));
                                    } else {
                                        $amount.text('Không xác định');
                                    }
                                })
                                .fail(() => $amount.text('0đ'));
                        } else {
                            $amount.text('0đ');
                        }
                    }
                });

                //Khi người dùng đổi option => gọi lại ajax tính giá
                $select.off('change').on('change', function () {
                    const month = $(this).val();
                    if (!month) {
                        $amount.text('0đ');
                        return;
                    }

                    $amount.html('<span class="spinner-border spinner-border-sm"></span>');
                    getPeriodExtensionPrice(row.proxy_id, month)
                        .done(function (res) {
                            if (res.success) {
                                $amount.text(vnd(res.data.finalPrice * rate.VND));
                            } else {
                                $amount.text('Không xác định');
                            }
                        })
                        .fail(() => $amount.text('0đ'));
                });
            });
            $('#formExtendProxy').on('submit', function (e) {
                e.preventDefault();
                const $form = $(this);
                const route = $form.data('action');
                const $overlay = $('.modalLoadingOverlay');

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $overlay.removeClass('d-none');
                    },
                    success: function (res) {
                        $overlay.addClass('d-none');

                        if (res.success) {
                            toastr.success(res.message || 'Gia hạn thêm thành công!', 'Thành công');
                            $('#modalExtendProxy').modal('hide');
                            $('#demo-custom-toolbar').bootstrapTable('refresh', {silent: true});
                        } else {
                            toastr.error(res.message || res.error || 'Gia hạn thất bại!', 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        // Bắt lỗi từ Laravel Validation hoặc Exception
                        let msg = 'Không kết nối được với máy chủ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Trường hợp Laravel validation
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                });
            });

            const modalProtocol = new bootstrap.Modal(document.getElementById('modalChangeProtocol'));
            $(document).on('click', '#btnChangeProtocol', function () {
                const $btn = $(this);
                const id = $btn.data('id');
                const row = JSON.parse(decodeURIComponent($btn.data('row')));
                const $form = $('#formChangeProtocol');

                $form.find('input[name="id"]').val(id);

                const $select = $form.find('select[name="protocol"]');
                $select.val(row.proxyType);

                if ($select.val() !== row.proxyType) {
                    $select.val('');
                }
                modalProtocol.show();
            });
            $('#formChangeProtocol').on('submit', function (e) {
                e.preventDefault();
                const $form = $(this);
                const route = $form.data('action');
                const $overlay = $('.modalLoadingOverlay');

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $overlay.removeClass('d-none');
                    },
                    success: function (res) {
                        $overlay.addClass('d-none');

                        if (res.success) {
                            toastr.success(res.message || 'Cập nhật thành công!', 'Thành công');
                            $('#modalChangeProtocol').modal('hide');
                            $('#demo-custom-toolbar').bootstrapTable('refresh', {silent: true});
                        } else {
                            toastr.error(res.message || res.error || 'Cập nhật thất bại!', 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        // Bắt lỗi từ Laravel Validation hoặc Exception
                        let msg = 'Không kết nối được với máy chủ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Trường hợp Laravel validation
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                });
            });

            const modalAuth = new bootstrap.Modal(document.getElementById('modalChangeAuth'));
            $(document).on('click', '#btnChangeAuth', function () {
                const $btn = $(this);
                const id = $btn.data('id');
                const row = JSON.parse(decodeURIComponent($btn.data('row')));
                const $form = $('#formChangeAuth');

                $form.find('input[name="id"]').val(id);
                $form.find('input[name="username"]').val(row.username);
                $form.find('input[name="password"]').val(row.password);
                modalAuth.show();
            });
            $('#formChangeAuth').on('submit', function (e) {
                e.preventDefault();
                const $form = $(this);
                const route = $form.data('action');
                const $overlay = $('.modalLoadingOverlay');

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $overlay.removeClass('d-none');
                    },
                    success: function (res) {
                        $overlay.addClass('d-none');

                        if (res.success) {
                            toastr.success(res.message || 'Cập nhật thành công!', 'Thành công');
                            $('#modalChangeAuth').modal('hide');
                            $('#demo-custom-toolbar').bootstrapTable('refresh', {silent: true});
                        } else {
                            toastr.error(res.message || res.error || 'Cập nhật thất bại!', 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        // Bắt lỗi từ Laravel Validation hoặc Exception
                        let msg = 'Không kết nối được với máy chủ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Trường hợp Laravel validation
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                });
            });

            const modalNote = new bootstrap.Modal(document.getElementById('modalChangeNote'));
            $(document).on('click', '#btnChangeNote', function () {
                const $btn = $(this);
                const id = $btn.data('id');
                const row = JSON.parse(decodeURIComponent($btn.data('row')));
                const $form = $('#formChangeNote');

                $form.find('input[name="id"]').val(id);
                $form.find('textarea[name="note"]').val(row.note);
                modalNote.show();
            });
            $('#formChangeNote').on('submit', function (e) {
                e.preventDefault();
                const $form = $(this);
                const route = $form.data('action');
                const $overlay = $('.modalLoadingOverlay');

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $form.serialize(),
                    beforeSend: function () {
                        $overlay.removeClass('d-none');
                    },
                    success: function (res) {
                        $overlay.addClass('d-none');

                        if (res.success) {
                            toastr.success(res.message || 'Cập nhật thành công!', 'Thành công');
                            $('#modalChangeNote').modal('hide');
                            $('#demo-custom-toolbar').bootstrapTable('refresh', {silent: true});
                        } else {
                            toastr.error(res.message || res.error || 'Cập nhật thất bại!', 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        // Bắt lỗi từ Laravel Validation hoặc Exception
                        let msg = 'Không kết nối được với máy chủ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Trường hợp Laravel validation
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                });
            });
        });

        $(function () {
            // Toggle hiển thị mật khẩu
            $(document).on('click', '.toggle-password', function () {
                const $btn = $(this);
                const $input = $btn.closest('.input-group').find('input[name="password"]');
                const $icon = $btn.find('i');
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>

@stop
