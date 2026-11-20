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
                                <p>{{ __('Mã đơn hàng: #:id', ['id' => $order->code]) }}</p>
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
                                        <th>#</th>
                                        <th>IP</th>
                                        <th>HTTP Port</th>
                                        <th>SOCKS Port</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Country</th>
                                        <th>IP Version</th>
                                        <th>Start</th>
                                        <th>End</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->proxyInstances as $index => $proxy)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $proxy->ip }}</td>
                                            <td>{{ $proxy->port_http }}</td>
                                            <td>{{ $proxy->port_socks5 }}</td>
                                            <td>{{ $proxy->username }}</td>
                                            <td>{{ $proxy->password }}</td>
                                            <td>{{ strtoupper($proxy->country_code) }}</td>
                                            <td>{{ $proxy->ip_version === 4 ? 'IPv4' : 'IPv6' }}</td>
                                            <td>{{ $proxy->date_start }}</td>
                                            <td>{{ $proxy->date_end }}</td>
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
