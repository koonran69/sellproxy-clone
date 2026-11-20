<div class="col-12 col-md-3">
    <div id="blockSubmit" class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="my-3">
                <x-input-switch name="is_feature" :checked="old('is_feature')" :value="true" :label="trans('Tin nổi bật')" />
            </div>
            <div class="my-3">
                <x-input-switch name="is_hot" :checked="old('is_hot')" :value="true" :label="trans('Tin hot')" />
            </div>
        </div>
        <div class="card-body p-2">

            <div class="d-flex align-items-center h-100 gap-2">
                <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                    value="save">@lang('save')</button>
                <button type="submit" class="btn" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header justify-content-between">
            @lang('category')
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($categories as $category)
                <x-input-checkbox :depth="$category->depth" name="categories_id[]" :label="$category->name" :value="$category->id" />
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
                    <x-select-option :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="feature_image" showImage="featureImage" />
        </div>
    </div>

</div>
