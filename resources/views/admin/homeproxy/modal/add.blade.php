<div id="modalCharge" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div id="modalChargeContent" class="modal-content">
            <x-core-form id="formCharge" class="block-double-click" type="post" :validate="true" action="{{ route('admin.homeproxy.handle_charge') }}">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Nạp tiền') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">@lang('Số tiền'):</label>
                        <x-input type="number" name="amount" min="1000" :value="old('Số tiền')" placeholder="Vd: 50.000" :required="true" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Thoát') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Nạp') }}</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>
