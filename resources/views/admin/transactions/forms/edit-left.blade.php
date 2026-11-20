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
            <!-- Fullname -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('fullname'):</label>
                    <x-input name="fullname" :value="$user->fullname" :required="true"
                        :placeholder="__('fullname')" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('phone'):</label>
                    <x-input-phone name="phone" :value="$user->phone" :required="true" />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('identity number'):</label>
                    <x-input-number name="identity_number" :value="$user->identity_number" :placeholder="@trans('identity number')"/>
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('password'):</label>
                    <x-input-password name="password"/>
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
                    <label class="form-label">@lang('address'):</label>
                    <x-input name="address" :value="$user->address" :placeholder="@trans('address')"/>
                </div>
            </div>
        </div>
    </div>
</div>
