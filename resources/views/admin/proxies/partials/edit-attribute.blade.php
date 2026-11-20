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
                    <x-select-option :value="$attr->id" :title="$attr->name" :selected="$attr->id == optional($proxy->variations->first())->attr_id" />
                @endforeach
            </x-select>
        </div>

        <div id="variation-select-container" class="variation-select-container">
            <label class="form-label">@lang('Chọn các biến thể')</label>
            <div class="variation-select-list" id="variation-options">
                @foreach ($variations[$proxy->variations->first()->attr_id ?? ''] ?? [] as $variation)
                    <div class="variation-option {{ in_array($variation->id, $proxy_variations) ? 'selected' : '' }}"
                        data-id="{{ $variation->id }}" data-name="{{ $variation->name }}">
                        <i
                            class="ti {{ in_array($variation->id, $proxy_variations) ? 'ti-circle-check' : 'ti-circle' }}"></i>
                        {{ $variation->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <div id="variation-data-container" class="variation-data-container"
            style="{{ count($proxy_variations) > 0 ? 'display: block;' : 'display: none;' }}">
            <div class="mb-3">
                <h4 class="variation-title">
                    <i class="ti ti-list me-2"></i>@lang('Nhập chi tiết cho các biến thể đã chọn')
                </h4>
            </div>
            <div id="variation-data-list">
                @foreach ($proxy->variations as $variation)
                    <div class="variation-item mb-4" data-id="{{ $variation->id }}">
                        <div class="variation-title">
                            <i class="ti ti-tags"></i> {{ $variation->name }}
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Giá')</label>
                                <x-input-number name="variations[{{ $variation->id }}][price]" :value="$variation->pivot->price" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Giá khuyến mãi')</label>
                                <x-input-number name="variations[{{ $variation->id }}][price_promotion]"
                                    :value="$variation->pivot->price_promotion" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Thời gian')</label>
                                <x-input name="variations[{{ $variation->id }}][duration]" :value="is_array(json_decode($variation->pivot->duration, true)) 
                                    ? json_decode($variation->pivot->duration, true)[$lang] ?? '' 
                                    : null" :placeholder="@trans('Ví dụ: 30 ngày')" :required="true"/>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">@lang('Trạng thái')</label>
                                <x-select name="variations[{{ $variation->id }}][status]">
                                    @foreach ($status as $key => $value)
                                        <x-select-option :option="$variation->pivot->status" :value="$key" :title="$value" />
                                    @endforeach
                                </x-select>
                            </div>
                            {{-- <div class="col-12">
                                <label class="form-label">@lang('Mô tả')</label>
                                <textarea rows="2" class="form-control" name="variations[{{ $variation->id }}][desc]">{!! $variation->pivot->desc !!}</textarea>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
