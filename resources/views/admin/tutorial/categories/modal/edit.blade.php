<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <x-core-form class="ajax-modal-form" data-load-dt="true" data-table-id="category"
                action="{{ route('admin.tutorial.category.update') }}" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$category->id" />
                    <x-input name="lang" type="hidden" :value="$lang" />
                <div class="modal-header">
                    <h3 class="modal-title">{{ __('Sửa danh mục') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 col-md-12">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('Tên danh mục'):</label>
                                            <x-input name="name" :value="$category->getTranslation('name', $lang)" :required="true"
                                                :placeholder="__('Tên danh mục')" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('Đường dẫn'):</label>
                                            <x-input name="slug" :value="$category->slug" :required="true"
                                                :placeholder="__('Đường dẫn')" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('parent'):</label>
                                            <x-select class="select2-bs5" name="parent_id">
                                                <x-select-option value="" :title="__('empty')" />
                                                @foreach ($categories as $item)
                                                    <x-select-option :selected="$category->parent_id" :value="$item->id"
                                                        :title="generate_text_depth_tree($item->depth) .
                                                            ' ' .
                                                            __($item->name)" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('position'):</label>
                                            <x-input type="number" name="position" :value="$category->position"
                                                :required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('status'):</label>
                                            <x-select name="status" :required="true">
                                                @foreach ($status as $key => $value)
                                                    <x-select-option :option="$category->status->value" :value="$key"
                                                        :title="$value" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('Mô tả'):</label>
                                            <textarea name="description" class="form-control" placeholder="@lang('Mô tả')">{{ $category->getTranslation('description', $lang) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('Tiêu đề seo'):</label>
                                            <x-input name="title_seo" :value="$category->getTranslation('title_seo', $lang)" :placeholder="__('Tiêu đề seo')" />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">@lang('Mô tả seo'):</label>
                                            <textarea name="desc_seo" class="form-control" placeholder="@lang('Mô tả seo')">{{ $category->getTranslation('desc_seo', $lang) }}</textarea>
                                        </div>
                                    </div>
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
