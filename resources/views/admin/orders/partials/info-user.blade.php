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