<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0 fs-2"> @lang('Thông tin đơn hàng')</h4>
        </div>
        <div class="row card-body">
            <div class="col-12 col-md-6">
                <h3>{{ __('Thông tin chung') }}</h3>
                <div class="mb-3 wrap-select2">
                    <label class="form-label">@lang('Khách hàng'):</label>
                    <x-select class="select2-bs5-ajax-many" name="user_id" :data-url="route('admin.user.search_select')" :required="true" ></x-select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Ghi chú') }}:</label>
                    <textarea name="note" rows="3" class="form-control">{{ old('note') }}</textarea>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h3>{{ __('Thông tin khách hàng') }}</h3>
                <div id="infoUser">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Họ và tên') }}:</label>
                        <x-input name="customer_name" :value="old('customer_name', $customer_name ?? '')" :placeholder="__('Họ và tên')"
                            :required="true" />
                    </div>
                    <div class="mb-3">
                            <label class="form-label">{{ __('Số điện thoại') }}:</label>
                            <x-input-phone name="customer_phone" :value="old('customer_phone', $customer_phone ?? '')" :required="true" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email nhận thông báo') }}:</label>
                        <x-input name="email_notify" :value="old('email_notify', $email_notify ?? '')" :placeholder="__('Email nhận thông báo')"
                            :required="true" />
                    </div>

                </div>
            </div>
            <!-- Thông tin giá -->
            <div class="col-12">
                @include('admin.orders.partials.products')
            </div>
        </div>
    </div>
</div>
