<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <x-core-form type="post" :validate="true" data-load-dt="true" action="{{ route('admin.deposit.store') }}"
                class="ajax-modal-form" data-table-id="deposit" type="post" >
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Nạp tiền') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-md-12">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Khách hàng')</label>
                                    <x-select name="user_id" class="select2-bs5-ajax-many drop-parent" :data-url="route('admin.user.search_select')"></x-select>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Số tiền'):</label>
                                    <x-input-number name="amount" :value="old('Số tiền')" placeholder="Vd: 50.000" :required="true" />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label class="'form-label">@lang('Ghi chú')</label>
                                    <x-textarea name="note" rows="3"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Thoát') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>
