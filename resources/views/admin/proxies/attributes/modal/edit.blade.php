<div class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <x-core-form :validate="true" data-load-dt="true" type="put"
                action="{{ route('admin.proxy.attribute.update') }}" class="ajax-modal-form" data-table-id="attribute">
                <x-input name="id" type="hidden" :value="$attribute->id" />
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Sửa thuộc tính') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Tên thuộc tính')</label>
                                <x-input name="name" :value="$attribute->name" :required="true" :placeholder="@trans('Tên thuộc tính')" />
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Đường dẫn')</label>
                                <x-input name="slug" :value="$attribute->slug" :required="true" :placeholder="@trans('Đường dẫn')" />
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Vị trí'):</label>
                                <x-input name="position" type="number" value="0" />
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
