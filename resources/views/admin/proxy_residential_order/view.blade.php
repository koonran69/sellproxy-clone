@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 fs-2"> @lang('Thông tin đơn hàng')</h4>
                        </div>
                        <div class="row card-body">
                            <div class="col-12 col-md-6">
                                <h3>{{ __('Thông tin chung') }}</h3>
                                <p>{{ __('Mã đơn hàng: #:id', ['id' => $order->id]) }}</p>
                                <p>{{ __('Mã đơn hàng proxy cheap: #:partner_order_id', ['partner_order_id' => $order->partner_order_id]) }}</p>
                                <div class="mb-3">
                                    <span>@lang('Khách hàng'):</span>
                                    <a href="{{ route('admin.user.edit', $order->user_id) }}">{{ optional($order->user)->name }} </a>
                                </div>
                                <div class="mb-3 d-none">
                                    <label class="form-label">{{ __('Khách hàng') }}</label>
                                    <x-select name="user_id" :required="true" readonly="true">
                                        <x-select-option :option="$order->user_id" :value="$order->user_id"
                                                         :title="optional($order->user)->name"/>
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h3>{{ __('Thông tin khách hàng') }}</h3>
                                <div id="infoUser">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Họ và tên') }}:</label>
                                        <x-input name="customer_name" readonly
                                                 :value="old('customer_name', optional($order->user)->name ?? '')"
                                                 :placeholder="__('Họ và tên')" :required="true"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Số điện thoại') }}:</label>
                                        <x-input-phone name="customer_phone" readonly
                                                       :value="old('customer_phone', optional($order->user)->phone ?? '')"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Email nhận thông báo') }}:</label>
                                        <x-input name="email_notify" readonly
                                                 :value="old('email_notify', $order->email_notify ?? '')"
                                                 :placeholder="__('Email nhận thông báo')" :required="true"/>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 fs-2"> @lang('Danh sách Proxy')</h4>
                        </div>
                        <div class="row card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mt-4">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Thao tác</th>
                                        <th>#</th>
                                        <th>Trạng thái</th>
                                        <th>Proxy</th>
                                        <th>Network</th>
                                        <th>IP version</th>
                                        <th>Loại</th>
                                        <th>Quốc gia</th>
                                        <th>ISP</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->proxies as $index => $proxy)
                                        <tr>
                                            <td>
                                                <button class="btnChangeProtocol btn btn-warning px-2"
                                                        data-id="{{$proxy->id}}"
                                                        data-row='@json($proxy)'>
                                                    Đổi giao thức
                                                </button>
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $proxy->proxy_status }}</td>
                                            <td>
                                                @php
                                                    $ip_port = '';
                                                    $ip_port_username_pass = '';
                                                    $username_pass_ip_port = '';

                                                    if ($proxy->ipVersion === 'IPv4') {
                                                        $port = $proxy->httpPort ?? $proxy->socks5Port ?? $proxy->httpsPort;
                                                        $ip_port = "{$proxy->publicIp}:{$port}";
                                                        $ip_port_username_pass = "{$ip_port}:{$proxy->username}:{$proxy->password}";
                                                        $username_pass_ip_port = "{$proxy->username}:{$proxy->password}@{$ip_port}";
                                                    } elseif ($proxy->ipVersion === 'IPv6' && is_array($proxy->hostnames)) {
                                                        foreach ($proxy->hostnames as $key => $ipv6) {
                                                            [$ipv4, $port] = explode(':', $key);
                                                            $ipv4_with_port = "{$ipv4}:{$port}";

                                                            $ip_port .= ($ip_port ? "\n" : "") . $ipv4_with_port;
                                                            $ip_port_username_pass .= ($ip_port_username_pass ? "\n" : "") . "{$ipv4_with_port}:{$proxy->username}:{$proxy->password}";
                                                            $username_pass_ip_port .= ($username_pass_ip_port ? "\n" : "") . "{$proxy->username}:{$proxy->password}@{$ipv4_with_port}";
                                                        }
                                                    }
                                                @endphp

                                                <div class="d-flex">Proxy ID: {{ $proxy->proxy_id }}</div>
                                                <br>

                                                <div class="d-flex align-items-center gap-2">
                                                    <span>IP:PORT</span>
                                                    <button class="btn btn-sm btn-warning copy-text"
                                                            data-text="{{ $ip_port }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>

                                                <br>

                                                <div class="d-flex align-items-center gap-2">
                                                    <span>IP:PORT:USERNAME:PASSWORD</span>
                                                    <button class="btn btn-sm btn-warning copy-text"
                                                            data-text="{{ $ip_port_username_pass }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>

                                                <br>

                                                <div class="d-flex align-items-center gap-2">
                                                    <span>USERNAME:PASSWORD@IP:PORT</span>
                                                    <button class="btn btn-sm btn-warning copy-text"
                                                            data-text="{{ $username_pass_ip_port }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ $proxy->networkType }}</td>
                                            <td>{{ $proxy->ipVersion }}</td>
                                            <td>{{ $proxy->proxyType }}</td>
                                            <td>
                                                @if($proxy->order && $proxy->order->country)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ asset($proxy->order->country->feature_image) }}"
                                                             width="28" height="20"
                                                             class="rounded shadow-sm border"
                                                             alt="{{ $proxy->order->country->name }}">
                                                        <div>
                                                            <div
                                                                class="fw-semibold text-dark">{{ $proxy->order->country->name }}</div>
                                                            <div class="text-muted small">
                                                                Mã code: <span
                                                                    class="fw-medium">{{ $proxy->order->country->code }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">--</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($proxy->order && $proxy->order->country && $proxy->order->isp)
                                                    {{ config('proxyresidental')['setting']['isps'][$proxy->order->location][$proxy->order->isp]['label'] ?? ($proxy->order->isp ?? '-') }}
                                                @else
                                                    <span class="text-muted">--</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{date('H:i:s d/m/Y',strtotime($proxy->partner_expiresAt))}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalChangeProtocol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="formChangeProtocol" method="POST" data-action="{{ route('admin.proxy_residential_order.changeProtocolProxy') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Giao thức Proxy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <input type="hidden" name="id" class="form-control" value="">
                    <div class="modal-body">
                        <div class="mt-3">
                            <label class="form-label">Giao thức</label>
                            <select name="protocol" class="form-control">
                                <option value="">--Chọn giao thức--</option>
                                @foreach($availableTypes as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btnSubmitChangeProtocal" type="submit" class="btn btn-danger w-100">Cập nhật</button>
                    </div>
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-none modalLoadingOverlay"
                         style="background: rgba(255,255,255,.55); z-index: 5;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <div class="spinner-border" role="status" aria-hidden="true"></div>
                            <div class="small mt-2 text-muted">Đang xử lý, vui lòng đợi…</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('js')
    <script>
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

                        $.toast({
                            heading: 'Thành công',
                            text: res.message || 'Cập nhật thành công!',
                            icon: 'success',
                            position: 'top-right'
                        });

                        $('#modalChangeProtocol').modal('hide');

                        // Chỉ cần reload nếu bạn muốn
                        setTimeout(() => location.reload(), 600);

                    } else {

                        $.toast({
                            heading: 'Lỗi',
                            text: res.message || 'Cập nhật thất bại!',
                            icon: 'error',
                            position: 'top-right'
                        });
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
                    $.toast({
                        heading: 'Lỗi',
                        text: msg,
                        icon: 'error',
                        position: 'top-right'
                    });
                },
            });
        });
        $(document).on('click', '.btnChangeProtocol', function () {
            const $btn = $(this);

            const id = $btn.data('id');
            const row = $btn.data('row');

            const $form = $('#formChangeProtocol');

            $form.find('input[name="id"]').val(id);

            const $select = $form.find('select[name="protocol"]');
            $select.val(row.proxyType);

            if ($select.val() !== row.proxyType) {
                $select.val('');
            }

            $('#modalChangeProtocol').modal('show');
        });
        document.addEventListener('click', function (e) {
            if (e.target.closest('.copy-text')) {
                const btn = e.target.closest('.copy-text');
                const text = btn.getAttribute('data-text');
                navigator.clipboard.writeText(text).then(() => {
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="ti ti-copy"></i>';
                    }, 1000);
                });
            }
        });
    </script>
@endpush
