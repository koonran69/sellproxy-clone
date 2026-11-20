<div class="col-12 col-md-3">
    <div class="card mb-3" id="blockSubmit">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                @adminaccessroutename('admin.user.update')
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
            {{ __('Ngôn ngữ') }}
        </div>
        <div class="card-body p-4">
            @if ($lang === 'vi')
                <a class="gap-2 d-flex align-items-center text-decoration-none"
                    href="{{ route('admin.proxy.edit', ['id' => $proxy->id, 'lang' => 'en']) }}">
                    <span class="flag-en"></span>
                    <span>@lang('Tiếng Anh') <i class="ti ti-edit"></i></span>
                </a>
            @else
                <a class="gap-2 d-flex align-items-center text-decoration-none"
                    href="{{ route('admin.proxy.edit', ['id' => $proxy->id, 'lang' => 'vi']) }}">
                    <span class="flag-vi"></span>
                    <span>@lang('Tiếng Việt') <i class="ti ti-edit"></i></span>
                </a>
            @endif
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-header">
            {{ __('Danh mục') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($proxy_categories as $category)
                <x-input-radio :checked="$proxy->category?->id" name="category_id" :label="$category->name" :value="$category->id" />
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Loại') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($proxy_types as $type)
                <x-input-radio :checked="$proxy->type?->id" name="type_id" :label="$type->name" :value="$type->id" />
            @endforeach
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Tính năng') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($setting_features as $setting_feature)
                <x-input-checkbox :checked="in_array($setting_feature->setting_key,(array) $proxy->features ?? [])"
                                  name="features[]" :label="$setting_feature->plain_value" :value="$setting_feature->setting_key" />
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
                    <x-select-option :value="$key" :title="$value" :option="$proxy->status->value" />
                @endforeach
            </x-select>
        </div>
    </div>
</div>
