<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Code -->
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Tên trang'):</label>
                    <input type="text" class="form-control" value="{{ $page->name }}" disabled readonly>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Đường dẫn'):</label>
                    <x-input :disabled="true" name="slug" :value="$page->slug" :required="true" placeholder="{{ __('Đường dẫn') }}" />
                </div>
            </div>
            <!-- desc -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('content'):</label>
                    <textarea name="content" class="ckeditor visually-hidden">{{ $page->content }}</textarea>
                </div>
            </div>
    
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Tiêu đề seo'):</label>
                    <x-input name="title_seo" :value="$page->title_seo" :placeholder="trans('Tiêu đề seo')" />
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Mô tả seo'):</label>
                    <textarea name="desc_seo" class="form-control" placeholder="@lang('Mô tả seo')">{{ $page->desc_seo }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
