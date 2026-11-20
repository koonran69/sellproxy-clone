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
                                <div class="mb-3">
                                    <span>@lang('Khách hàng'):</span>
                                    <a href="{{ route('admin.user.edit', $order->user_id) }}">{{ optional($order->user)->name }} </a>
                                </div>
                                <div class="mb-3 d-none">
                                    <label class="form-label">{{ __('Khách hàng') }}</label>
                                    <x-select name="user_id" :required="true" readonly="true">
                                        <x-select-option :option="$order->user_id" :value="$order->user_id" :title="optional($order->user)->name" />
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h3>{{ __('Thông tin khách hàng') }}</h3>
                                <div id="infoUser">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Họ và tên') }}:</label>
                                        <x-input name="customer_name" readonly :value="old('customer_name', optional($order->user)->name ?? '')" :placeholder="__('Họ và tên')" :required="true" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Số điện thoại') }}:</label>
                                        <x-input-phone name="customer_phone" readonly :value="old('customer_phone', optional($order->user)->phone ?? '')" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Email nhận thông báo') }}:</label>
                                        <x-input name="email_notify" readonly :value="old('email_notify', $order->email_notify ?? '')" :placeholder="__('Email nhận thông báo')" :required="true" />
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
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Trạng thái</th>
                                        <th>Thông tin Proxy</th>
                                        <th>Loại</th>
                                        <th>Proxy ID (Partner)</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Tên server</th>
                                        <th>Thông tin cấu hình Proxy</th>
                                        <th>Quốc gia</th>
                                        <th>Bang/Nhà mạng</th>
                                        <th>Số lần thay đổi IP</th>
                                        <th>Giá (VNĐ)</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->proxies as $index => $proxy)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $proxy->name }}</td>
                                            <td><span class="badge {{$proxy->status_badge}}">{{$proxy->status}}</span></td>
                                            <td>
                                                @php
                                                    $ip_port = '';
                                                    $ip_port_username_pass = '';
                                                    $username_pass_ip_port = '';

                                                    $port = $proxy->remote_port;
                                                    $ip_port = "{$proxy->ip}:{$port}";
                                                    $ip_port_username_pass = "{$ip_port}:{$proxy->username}:{$proxy->password}";
                                                    $username_pass_ip_port = "{$proxy->username}:{$proxy->password}@{$ip_port}";
                                                @endphp
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>{{$ip_port}}</span>
                                                    <button class="btn btn-sm btn-warning copy-text" data-text="{{ $ip_port }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>
                                                <br>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>IP:PORT:USERNAME:PASSWORD</span>
                                                    <button class="btn btn-sm btn-warning copy-text" data-text="{{ $ip_port_username_pass }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>
                                                <br>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>USERNAME:PASSWORD@IP:PORT</span>
                                                    <button class="btn btn-sm btn-warning copy-text" data-text="{{ $username_pass_ip_port }}">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ $proxy->proxy_type_name }}</td>
                                            <td>{{ $proxy->proxy_id }}</td>
                                            <td>{{ $proxy->order_id }}</td>
                                            <td>{{ $proxy->server_name }}</td>
                                            <td>
                                                <div>
                                                    <div class="d-flex">Plan: {{$proxy->PlanName}}</div>
                                                    <br>
                                                    <div class="d-flex">Ram: {{$proxy->ram}} GB</div>
                                                    <br>
                                                    <div class="d-flex">CPU: {{$proxy->cpu}} Cores</div>
                                                    <br>
                                                    <div class="d-flex">SSD: {{$proxy->ssd}} GB</div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                    $regions = app(\App\Services\VPS\VPSService::class)->listRegion();
                                                    $regions = collect($regions)->keyBy('symbol')->toArray();
                                                    if($proxy->country === 'VNR'){
                                                        $proxy->country = 'VN';
                                                    }
                                                ?>
                                                <div class="d-block">
                                                    <img src="data:image/png;base64,{{$regions[$proxy->country]['flag']}}" width="28" height="20" class="rounded shadow-sm border" alt="{{$regions[$proxy->country]['name']}}">
                                                    <div>
                                                        <div class="fw-semibold text-dark">{{$regions[$proxy->country]['name']}}</div>
                                                        <div class="text-muted small">Mã code: <span class="fw-medium">{{$regions[$proxy->country]['symbol']}}</span></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($proxy->state)
                                                    Bang: {{$proxy->state}}
                                                @elseif($proxy->isp)
                                                    Nhà mạng: {{$proxy->isp}}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>{{ $proxy->change_ip_time }}</td>
                                            <td>{{ number_format($proxy->price).'đ' }}</td>
                                            <td>
                                                {{date('H:i:s d/m/Y',strtotime($proxy->partner_created_at))}}
                                            </td>
                                            <td>
                                                {{date('H:i:s d/m/Y',strtotime($proxy->partner_expired_at))}}
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
@endsection

@push('libs-js')
<!-- button in datatable -->
<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('js')
    <script>
        document.addEventListener('click', function(e) {
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
