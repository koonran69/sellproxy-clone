<div class="col-12 col-md-9">
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
                <div class="mb-3">
                    <p>{{ __('Hình thức thanh toán: :pm', ['pm' => $order->payment_method->description()]) }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Trạng thái') }}:</label>
                    <x-select name="status" :required="true">
                        @foreach ($status as $key => $value)
                            <x-select-option :option="$order->status->value" :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Ghi chú') }}:</label>
                    <textarea name="note" class="form-control">{{ $order->note }}</textarea>
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
                @include('admin.orders.partials.products')
            </div>
        </div>
    </div>
</div>
