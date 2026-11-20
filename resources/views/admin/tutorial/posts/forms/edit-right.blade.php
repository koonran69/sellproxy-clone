<div class="col-12 col-md-3">
    <div id="blockSubmit" class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 ">
            <div class="mb-3">
                <x-input-switch name="is_feature" :checked="$post->is_feature" :value="true" :label="trans('Nổi bật')" />
            </div>
            <div class="my-3">
                <x-input-switch name="is_hot" :checked="$post->is_hot" :value="true" :label="trans('Tin hot')" />
            </div>
        </div>
        <div class="card-body p-2 ">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center h-100 gap-2">
                    <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                        value="save">@lang('save')</button>
                    <button type="submit" class="btn" name="submitter" value="saveAndExit">
                        @lang('save&exit')
                    </button>
                </div>
                <button type="button" class="btn btn-danger open-modal-delete"
                    data-route="{{ route('admin.tutorial.post.delete', $post->id) }}" data-target="#modalDelete">
                    @lang('delete')
                </button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('category')
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($categories as $category)
                <x-input-checkbox :checked="$post->categories->pluck('id')->toArray()" :depth="$category->depth" name="categories_id[]" :label="$category->name"
                    :value="$category->id" />
            @endforeach


        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$post->status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="feature_image" showImage="featureImage" :value="$post->feature_image" />
        </div>
    </div>
</div>
