<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <x-core-form class="ajax-modal-form block-double-click" data-load-dt="true" data-table-id="member_level" action="{{ route('admin.member_level.update') }}" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$member_level->id" />
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Sửa')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row align-items-end">
                                <div class="col-auto">
                                    <a href="#" class="avatar avatar-upload rounded">
                                        <x-input-image-ckfinder name="feature_image" showImage="featureImage" :value="$member_level->feature_image"/>
                                    </a>
                                </div>
                                <div class="col">
                                    <label class="form-label">@lang('Tên')</label>
                                    <x-input name="name"  :required="true" :placeholder="@trans('Tên')" :value="$member_level->name" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Giá trị'):</label>
                                <x-input-number name="plain_value" :value="$member_level->plain_value" :required="true"
                                    :placeholder="__('Giá trị')" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">@lang('Vị trí'):</label>
                                <x-input type="number" name="position" :value="$member_level->position" min="0" :required="true"
                                    :placeholder="__('Vị trí')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Huỷ')</button>
                    <button type="submit" class="btn btn-primary">@lang('Cập nhật')</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>