<div class="col-12 col-md-3">
    <div class="card mb-3" id="blockSubmit">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                @adminaccessroutename('admin.customer.store')
                    <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                        value="save">@lang('save')</button>
                    <button type="submit" class="btn" name="submitter" value="saveAndExit">
                        @lang('save&exit')
                    </button>
                @endadminaccessroutename
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Danh mục') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($proxy_categories as $category)
                <x-input-radio :checked="$proxy_categories->first()->id" name="category_id" :label="$category->name" :value="$category->id" />
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Loại') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($proxy_types as $type)
                <x-input-radio :checked="$proxy_types->first()->id" name="type_id" :label="$type->name" :value="$type->id" />
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Tính năng') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($setting_features as $setting_feature)
                <x-input-checkbox name="features[]" :label="$setting_feature->plain_value" :value="$setting_feature->setting_key" />
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Trạng thái') }}
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
</div>
