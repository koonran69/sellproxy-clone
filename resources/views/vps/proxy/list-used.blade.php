@extends("vps.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Danh sách {{$by_time}}</h3>
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
                    <input type="hidden" name="by_time" id="by_time" value="{{ request('by_time', 'all') }}">

                    <input value="{{ $keyword }}" id="filterInput" name="q" class="form-control" type="search" placeholder="@switch($searchBy)
                        @case('code') Mã đơn hàng @break
                        @default  ID/IP
                        @endswitch" aria-label="Giá trị tìm kiếm">

                    <button class="btn btn-primary-bg btn-pill px-4" id="btnSearch" type="submit">
                        Search
                    </button>
                </form>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('vps.proxy.exportProxy') }}" class="btn btn-primary-bg btn-pill px-4">
                        Xuất Excel
                    </a>
                </div>

            </div>
            <div class="vps-static-list vps-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("vps.proxy.searchProxyManagement") }}"
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
                       data-cookie-id-table="vps-index"
                       data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                >
                    <thead>
                    <tr>
                        <th data-field="action" data-formatter="actionFormatter">Thao tác</th>
                        <th data-field="auto_renew" data-sortable="false" data-formatter="formatAutoExtend" data-events="actionEvents">Tự động gia hạn</th>
                        <th data-field="id" data-sortable="true">STT</th>
                        <th data-field="name" data-sortable="true">Tên</th>
                        <th data-field="status" data-sortable="false" data-formatter="formatStatus">Trạng thái</th>
                        <th data-field="ip" data-sortable="true" data-formatter="formatInfoProxy">Thông tin Proxy</th>
                        <th data-field="proxy_type_name" data-sortable="false">Loại</th>
                        <th data-field="proxy_id" data-sortable="true">Proxy ID (Partner)</th>
                        <th data-field="order_id" data-sortable="true">Mã đơn hàng</th>
                        <th data-field="server_name" data-sortable="true">Tên server</th>
                        <th data-field="ram" data-sortable="true" data-formatter="formatConfigProxy">Thông tin cấu hình Proxy</th>
                        <th data-field="country" data-sortable="true" data-formatter="formatCountry">Quốc gia</th>
                        <th data-field="state" data-sortable="true" data-formatter="formatState">Bang/Nhà mạng</th>
                        <th data-field="change_ip_time" data-sortable="true">Số lần thay đổi IP</th>
                        <th data-field="price" data-sortable="true" data-formatter="formatPriceVND">Giá (VNĐ)</th>
                        <th data-field="partner_created_at" data-sortable="true" data-formatter="formatDateVN">Ngày tạo</th>
                        <th data-field="partner_expired_at" data-sortable="true" data-formatter="formatDateVN">Ngày hết hạn</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('vps.proxy.component.modal-change-ip')
    @include('vps.proxy.component.modal-confirm-action')
    @include('vps.proxy.component.modal-renew')
    @include('vps.proxy.component.modal-re-setting')
@stop

@section('script')
    <script>
        const vnd    = n => (Number(n)||0).toLocaleString('vi-VN') + 'đ';
        const assetBase = "{{ asset('') }}";
        const regions = @json($regions);
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

        //resetting
        const modalReSetting = new bootstrap.Modal(document.getElementById('modalReSetting'));
        $('#formReSetting').on('submit', function (e) {
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
                        modalReSetting.hide();
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
                complete: function () {
                    $form.find('.modalLoadingOverlay').addClass('d-none');
                }
            });
        });
        $(document).on('click', '#btnReSetting', function () {
            const $btn = $(this);
            const id = $btn.data('id');
            const row = JSON.parse(decodeURIComponent($btn.data('row')));

            const $form = $('#formReSetting');
            $form.find('input[name="id"]').val(id);

            modalReSetting.show();
        });

        const modalRenew = new bootstrap.Modal(document.getElementById('modalRenew'));
        $('#formRenew').on('submit', function (e) {
            e.preventDefault();
            const $form = $(this);
            const id = $form.find('input[name="id"]').val();

            const $activeTab = $form.find('.nav-link.active');
            const month = $activeTab.data('month');

            const route = $form.data('action');
            const $overlay = $('.modalLoadingOverlay');

            $.ajax({
                url: route,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    month: month
                },
                beforeSend: function () {
                    $overlay.removeClass('d-none');
                },
                success: function (res) {
                    $overlay.addClass('d-none');
                    if (res.success) {
                        toastr.success(res.message || 'Cập nhật thành công!', 'Thành công');
                        modalRenew.hide();
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
                complete: function () {
                    $form.find('.modalLoadingOverlay').addClass('d-none');
                }
            });
        });
        function fetchRenewPrice(id, duration) {
            const $info = $('#modalRenew .calculate-info');
            $info.html(`
                <div class="text-center p-3 text-muted small">
                    <div class="spinner-border spinner-border-sm me-2"></div> Đang tính giá...
                </div>
            `);

            $.ajax({
                url: '{{route('vps.proxy.ajaxRenewCalculateProxy')}}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    month: duration
                },
                success: function (res) {
                    if (res.success) {
                        $info.html(`
                                <div class="text-danger mt-3">
                                    <h3 class="fw-bold mb-2">Thông tin gia hạn</h3>
                                    <p class="mb-1">Ngày hết hạn hiện tại: ${res.data.old_expired_day}</p>
                                    <p class="mb-1">Thời gian gia hạn: ${duration}</p>
                                    <p class="mb-1">Số tiền thanh toán: ${res.data.expense}</p>
                                    <p class="mb-1">Ngày hết hạn sau khi gian hạn: ${res.data.new_expired_day}</p>
                                </div>
                            `);
                    }
                },
                error: function (xhr) {
                    $info.html(`
                    <div class="p-3 text-danger small">Lỗi khi lấy thông tin giá. Vui lòng thử lại.</div>
                `);
                }
            });
        }
        $(document).on('shown.bs.tab', '#modalRenew .nav-link', function (e) {
            const $form = $('#formRenew');
            const id = $form.find('input[name="id"]').val();

            const $tab = $(e.target);
            const duration= $tab.data('month');
            fetchRenewPrice(id, duration);
        });
        $(document).on('click', '#btnExtend', function () {
            const $btn = $(this);
            const id = $btn.data('id');

            const $form = $('#formRenew');
            $form.find('input[name="id"]').val(id);

            const $firstTab = $('#modalRenew .nav-link').first();
            $firstTab.addClass('active');
            const targetPane = $firstTab.attr('href');
            $(targetPane).addClass('active show');
            const month = $firstTab.data('month');

            fetchRenewPrice(id, month);

            modalRenew.show();
        });
        const modalChangeIP = new bootstrap.Modal(document.getElementById('modalChangeIP'));
        $('#formChangeIP').on('submit', function (e) {
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
                        modalChangeIP.hide();
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
                complete: function () {
                    $form.find('.modalLoadingOverlay').addClass('d-none');
                }
            });
        });
        $(document).on('click', '#btnChangeIP', function () {
            const $btn = $(this);
            const id = $btn.data('id');
            const row = JSON.parse(decodeURIComponent($btn.data('row')));

            const $form = $('#formChangeIP');
            $form.find('input[name="id"]').val(id);
            $form.find('span.count_change').text(row.change_ip_time);

            $.ajax({
                url: '{{ route('vps.proxy.ajaxGetChangeIPProxy') }}',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function (res) {
                    if (res.success) {
                        const $selectIp = $form.find('select[name="range_ip"]');
                        $selectIp.empty();
                        res.data.range_ip.forEach(function(data) {
                            $selectIp.append(
                                $('<option>', {
                                    value: data,
                                    text: data
                                })
                            );
                        });
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

            modalChangeIP.show();
        });
        const modalConfirmAction = new bootstrap.Modal(document.getElementById('psConfirmAction'));
        $(document).on('click', '#psConfirmAction .js-confirm-action', function(){
            const $btn = $(this);
            $btn.prop('disabled', true).text('Đang xử lý...');

            const $modal = $('#psConfirmAction');
            const ctx = $modal.data('ctx');
            $.ajax({
                url: "{{ route('vps.proxy.confirmActionProxy') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: ctx.id,
                    type: ctx.type
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message || 'Thành công!', 'Thành công');
                        modalConfirmAction.hide();
                        $('#demo-custom-toolbar').bootstrapTable('refresh', {silent: true});
                    } else {
                        toastr.error(res.message || res.error || 'Thất bại!', 'Lỗi');
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
                complete: function() {
                    $btn.prop('disabled', false).text('Đồng ý');
                }
            });
        });
        const $modalConfirmAction = $('#psConfirmAction');
        $(document).on('click', '#btnAutoFixError', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const id = $btn.data('id');
            const row = JSON.parse(decodeURIComponent($btn.data('row')));
            const type = 'auto_fix';

            $modalConfirmAction.data('ctx', { id, row, type });
            $modalConfirmAction.find('.ps-label').text(`Proxy này sẽ được sửa lỗi tự động.`);

            modalConfirmAction.show();
        });
        $(document).on('click', '#btnPause', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const id = $btn.data('id');
            const row = JSON.parse(decodeURIComponent($btn.data('row')));
            const type = 'pause';

            $modalConfirmAction.data('ctx', { id, row, type });
            $modalConfirmAction.find('.ps-label').text(`Proxy này sẽ tạm dừng.`);

            modalConfirmAction.show();
        });
        $(document).on('click', '#btnReboot', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const id = $btn.data('id');
            const row = JSON.parse(decodeURIComponent($btn.data('row')));
            const type = 'reboot';

            $modalConfirmAction.data('ctx', { id, row, type });
            $modalConfirmAction.find('.ps-label').text(`Proxy này sẽ được khởi động lại.`);

            modalConfirmAction.show();
        });
        window.actionEvents = {
            'click .btnAutoExtend input[type="checkbox"]': function (e, value, row, index) {
                $.ajax({
                    url: '{{ route('vps.proxy.ajaxAutoExtendProxy') }}',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: row.id
                    },
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
        function formatState(value,row){
            if(row.state){
                return 'Bang: '+row.state;
            }else if(row.isp){
                return 'Nhà mạng: '+row.isp;
            }else{
                return '-';
            }
        }
        function formatAutoExtend(value, row, index){
            return `
                <label class="toggle-switch btnAutoExtend" data-id="${row.id}">
                  <input type="checkbox" name="auto_renew" ${value ? 'checked' : ''}>
                  <span class="switch-slider">
                    <span class="switch-label" data-on="ON" data-off="OFF"></span>
                  </span>
                </label>
               `;
        }
        function formatPriceVND(value){
            return vnd(value);
        }
        function formatConfigProxy(value,row){
            return `
                <div>
                    <div class="d-flex">Plan: ${row.PlanName}</div>
                    <br>
                    <div class="d-flex">Ram: ${row.ram} GB</div>
                    <br>
                    <div class="d-flex">CPU: ${row.cpu} Cores</div>
                    <br>
                    <div class="d-flex">SSD: ${row.ssd} GB</div>
                </div>
            `;
        }
        function formatStatus(value, row) {
            return `
                <span class="badge ${row.status_badge}">
                    ${value}
                </span>
            `;
        }
        function formatInfoProxy(value, row){
            let ip_port = '';
            let ip_port_username_pass = '';
            let username_pass_ip_port =  '';
            ip_port = `${row.ip}:${row.remote_port}`;
            ip_port_username_pass = `${ip_port}:${row.username}:${row.password}`;
            username_pass_ip_port = `${row.username}:${row.password}@${ip_port}`;
            return `
                <div>
                    <div class="d-flex">IP: ${row.ip}</div>
                    <br>
                    <div class="d-flex">PORT: ${row.remote_port}</div>
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
        function formatCountry(value){
            if(value === 'VNR'){
                value = 'VN';
            }
            return `
            <div class="d-flex align-items-center gap-2">
                <img src="data:image/png;base64,${regions[value].flag}" width="28" height="20" class="rounded shadow-sm border" alt="${regions[value].name}">
                <div>
                    <div class="fw-semibold text-dark">${regions[value].name}</div>
                    <div class="text-muted small">Mã code: <span class="fw-medium">${regions[value].symbol}</span></div>
                </div>
            </div>
            `;
        }
        function formatCheckbox(value) {
            return `<div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" ${value ? 'checked' : ''} disabled>
                     </div>`;
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
            $html = `<div class="dropdown">
                       <button id="btnSetting" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear" style="font-size: 1.5rem;"></i></button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">`;
            $html += `
                    <li><button id="btnReboot" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"><i class="fa-solid fa-power-off me-2"></i>Khởi động lại</button></li>
                    <li><button id="btnPause" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"><i class="fa-solid fa-pause me-2"></i>Tạm dừng</button></li>
                    <li><button id="btnAutoFixError" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"><i class="fa-solid fa-wrench me-2"></i>Sửa lỗi tự động</button></li>
                    <li><button id="btnChangeIP" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"> <i class="fa-solid fa-pen-to-square me-2"></i>Đổi IP</button></li>
                    <li><button id="btnExtend" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"><i class="fa-solid fa-rotate-right me-2"></i>Gia hạn</button></li>
                    <li><button id="btnReSetting" data-id="${row.id}" data-row="${encodeURIComponent(JSON.stringify(row))}" class="btn btn-outline-lightgray btn-pill btn-icon text-start dropdown-item open-modal-form"><i class="fa-solid fa-server me-2"></i>Cài đặt lại Proxy</button></li>
                    `;
            $html += `</ul>
                    </div>`;
            return $html;
        }
        function queryParams(params) {
            params.search_by = $('#searchBy').val();
            params.q = $('#filterInput').val();
            params.by_time = $('#by_time').val();
            return params;
        }
        $(document).on("click", ".copy-text", function () {
            var text = $(this).data("text");
            copyText(text);
        });
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
                const by_time = $('#by_time').val();

                if (!q) {
                    $('#filterInput').focus();
                    return;
                }

                // Gán vào hidden input để queryParams() lấy được
                $('#searchBy').val(field);
                $('#by_time').val(by_time);
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
        });
    </script>

@stop
