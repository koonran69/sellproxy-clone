<div class="col-12 col-md-9">
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="mb-0 fs-2"><i class="ti ti-info-circle"></i> @lang('Thông tin cơ bản')</h4>
        </div>
        <div class="row card-body">
            <div class="col-12 col-md-12 mb-3">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <a href="#" class="avatar avatar-upload rounded">
                            <x-input-image-ckfinder name="feature_image" showImage="featureImage" />
                        </a>
                    </div>
                    <div class="col">
                        <label class="form-label">@lang('Tên proxy'):</label>
                        <x-input name="name" :required="true" :placeholder="@trans('Tên proxy')" />
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Tiêu đề phụ'):</label>
                    <x-input name="sub_title" :placeholder="@trans('Tiêu đề phụ')" />
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả ngắn tiêu đề phụ'):</label>
                    <x-input name="short_title_description" :placeholder="@trans('Mô tả ngắn tiêu đề phụ')" />
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả ngắn'):</label>
                    <textarea name="short_desc" class="ckeditor visually-hidden">{{ old('short_desc') }}</textarea>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="mb-3 desc">
                    <label class="form-label">@lang('Mô tả'):</label>
                    <textarea name="desc" class="ckeditor visually-hidden">{{ old('short_desc') }}</textarea>
                </div>
            </div>
        </div>
    </div>


    @include('admin.proxies.partials.create-attribute')
</div>
