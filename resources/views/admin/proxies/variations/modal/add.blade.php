<div class="modal fade" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <x-core-form type="post" :validate="true" data-load-dt="true"
                action="{{ route('admin.proxy.variation.store') }}" class="ajax-modal-form" data-table-id="variation"
                type="post">
                <x-input type="hidden" name="attr_id" :value="$attri_id" />
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Thêm biến thể') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Tên')</label>
                                <x-input name="name" :required="true" :placeholder="@trans('Tên')" />
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Vị trí'):</label>
                                <x-input name="position" type="number" value="0" />
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Mô tả'):</label>
                                <x-textarea name="desc" rows="3" />
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
