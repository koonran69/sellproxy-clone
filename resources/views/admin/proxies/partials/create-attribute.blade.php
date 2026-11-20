<div class="card">
    <div class="card-header">
        <h4 class="mb-0 fs-2"><i class="ti ti-tags"></i> @lang('Thuộc tính và biến thể')</h4>
    </div>
    <div class="row card-body">
        <div class="mb-4">
            <label class="form-label">@lang('Chọn thuộc tính')</label>
            <x-select name="attri" id="attribute-select">
                <option value="">@lang('Chọn một thuộc tính')</option>
                @foreach ($attrs as $attr)
                    <x-select-option :value="$attr->id" :title="$attr->name" />
                @endforeach
            </x-select>

        </div>
        <div id="variation-select-container" class="variation-select-container">
            <label class="form-label">@lang('Chọn các biến thể')</label>
            <div class="variation-select-list" id="variation-options">

            </div>
        </div>

        <div id="variation-data-container" class="variation-data-container">
            <div class="mb-3">
                <h4 class="variation-title">
                    <i class="ti ti-list me-2"></i>@lang('Nhập chi tiết cho các biến thể đã chọn')
                </h4>
            </div>
            <div id="variation-data-list">
            </div>
        </div>

    </div>
</div>
