<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <x-core-form type="post" :validate="true" data-load-dt="true" :action="route('admin.tutorial.category.store')" data-table-id="category"
                type="post" class="ajax-modal-form">
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('add') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Tên danh mục'):</label>
                                    <x-input name="name" :value="old('name')" :required="true" :placeholder="__('Tên danh mục')" />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('parent'):</label>
                                    <x-select class="select2-bs5" name="parent_id">
                                        <x-select-option value="" :title="__('empty')" />
                                        @foreach ($categories as $category)
                                            <x-select-option :value="$category->id" :title="generate_text_depth_tree($category->depth) .
                                                ' ' .
                                                __($category->name)" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('position'):</label>
                                    <x-input type="number" name="position" :value="old('position', 0)" :required="true" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('status'):</label>
                                    <x-select name="status" :required="true">
                                        @foreach ($status as $key => $value)
                                            <x-select-option :value="$key" :title="$value" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Mô tả'):</label>
                                    <textarea name="description" class="form-control" placeholder="@lang('Mô tả')">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Tiêu đề seo'):</label>
                                    <x-input name="title_seo" :value="old('title_seo')"
                                        :placeholder="__('Tiêu đề seo')" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Mô tả seo'):</label>
                                    <textarea name="desc_seo" class="form-control" placeholder="@lang('Mô tả seo')">{{ old('desc_seo') }}</textarea>
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
