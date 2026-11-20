<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <x-core-form type="post" :validate="true" data-load-dt="true" :action="route('admin.cdkey.import')" data-table-id="category"
                type="post" class="ajax-modal-form">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('import') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">@lang('Chọn sản phẩm') <span class="text-danger">(*)</span></label>
                                <x-select.proxy-variation :required="true"
                                                          selectedProxy="{{old('proxy_id')}}"
                                                          selectedVariation="{{old('variation_id')}}"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">@lang('Danh sách CD Key') <span class="text-danger">(*)</span></label>
                            <textarea class="form-control" name="cdkeys" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-secondary me-auto"
                        data-bs-dismiss="modal">{{ __('Thoát') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('import') }}</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>
