<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('title'):</label>
                <x-input name="title" :value="$post->getTranslation('title', $lang)" :required="true" placeholder="{{ __('title') }}" />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Đường dẫn'):</label>
                <x-input name="slug" :value="$post->slug" :required="true" placeholder="{{ __('Đường dẫn') }}" />
            </div>
        </div>
        <!-- desc -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('content'):</label>
                <textarea name="content" class="ckeditor visually-hidden">{{ $post->getTranslation('content', $lang) }}</textarea>
            </div>
        </div>
        <!-- excerpt -->
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('excerpt'):</label>
                <textarea class="form-control" name="excerpt" rows="5">{{ $post->getTranslation('excerpt', $lang) }}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Tiêu đề seo'):</label>
                <x-input name="title_seo" :value="$post->getTranslation('title_seo', $lang)" :placeholder="trans('Tiêu đề seo')" />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">@lang('Mô tả seo'):</label>
                <textarea name="desc_seo" class="form-control" placeholder="@lang('Mô tả seo')">{{ $post->getTranslation('desc_seo', $lang) }}</textarea>
            </div>
        </div>
    </div>
</div>
