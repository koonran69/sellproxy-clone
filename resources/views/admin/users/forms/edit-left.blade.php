<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Email Address -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('email'):</label>
                    <x-input-email name="email" :value="$user->email" :required="true" />
                </div>
            </div>
            <!-- name -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('name'):</label>
                    <x-input name="name" :value="$user->name" :required="true" :placeholder="__('name')" />
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('password'):</label>
                    <x-input-password name="password" />
                </div>
            </div>
            <!-- new password confirmation-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('passwordConfirm'):</label>
                    <x-input-password name="password_confirmation"
                        data-parsley-equalto="input[name='password']"
                        data-parsley-equalto-message="{{ trans('passwordMismatch') }}" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('phone'):</label>
                    <x-input-phone name="phone" :value="$user->phone" />
                </div>
            </div>
        </div>

    </div>
</div>
