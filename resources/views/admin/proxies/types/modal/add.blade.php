<div class="modal fade" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <x-core-form type="post" :validate="true" data-load-dt="true"
                action="{{ route('admin.proxy.type.store') }}" class="ajax-modal-form" data-table-id="type"
                type="post">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Thêm loại') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-md-12">
                        <div class="row align-items-end">
                            <div class="col-auto">
                                <a href="#" class="avatar avatar-upload rounded">
                                    <x-input-image-ckfinder name="feature_image" showImage="featureImage" />
                                </a>
                            </div>
                            <div class="col">
                                <label class="form-label">@lang('Tên loại')</label>
                                <x-input name="name"  :required="true" :placeholder="@trans('Tên loại')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Trạng thái'):</label>
                                    <x-select name="status" :required="true">
                                        @foreach ($status as $key => $value)
                                            <x-select-option :value="$key" :title="$value" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Vị trí'):</label>
                                    <x-input name="position" type="number" value="0" />
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
