<div class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <x-core-form :validate="true" data-load-dt="true" type="put"
                action="{{ route('admin.proxy.variation.update') }}" class="ajax-modal-form" data-table-id="variation">
                <x-input name="id" type="hidden" :value="$variation->id" />
                <x-input name="attr_id" type="hidden" :value="$variation->attr_id" />
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Sửa biến thể') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Tên')</label>
                                <x-input name="name" :required="true" :value="$variation->name" :placeholder="@trans('Tên')" />
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Đường dẫn')</label>
                                <x-input name="slug" :required="true" :value="$variation->slug" :placeholder="@trans('Đường dẫn')" />
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Vị trí'):</label>
                                <x-input name="position" type="number" value="0" :value="$variation->position" />
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Mô tả'):</label>
                                <x-textarea name="desc" rows="3" :value="$variation->desc"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Thoát') }}</button>
                    <button type="submit" class="btn btn-primary">@lang('Lưu')</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>
