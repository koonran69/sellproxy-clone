<div class="col-12 col-md-9">
    <div class="row">
        <!-- title -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('title'):</label>
                <x-input name="title" :value="old('title')" :required="true" :placeholder="__('title')" />
            </div>
        </div>
        <!-- content -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('content'):</label>
                <textarea name="content" class="ckeditor visually-hidden">{{ old('content') }}</textarea>
            </div>
        </div>
        <!-- excerpt -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Tóm tắt'):</label>
                <textarea class="form-control" name="excerpt" rows="5">{{ old('excerpt') }}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Tiêu đề Seo'):</label>
                <x-input name="title_seo" :value="old('title_seo')" :placeholder="trans('Tiêu đề Seo')" />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Mô tả Seo'):</label>
                <textarea name="desc_seo" class="form-control" placeholder="@lang('Mô tả seo')">{{ old('desc_seo') }}</textarea>
            </div>
        </div>
    </div>
</div>
