<div class="region-selector row">
    <div class="col-md-4 col-12">
        <div class="mb-3">
            <label class="form-label">@lang('Proxy')</label>
            <x-select name="proxy_id" :required="$required">
                <option value="">@lang('Chọn Proxy')</option>
                @foreach ($proxies as $proxy)
                    <x-select-option :option="$selectedProxy" :value="$proxy->id" :title="$proxy->name" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="mb-3">
            <label class="form-label">@lang('Kế hoạch')</label>
            <x-select name="variation_id" :required="$required">
                <option value="">@lang('Chọn Kế hoạch')</option>
                @foreach ($variations as $variation)
                    <x-select.option :option="$selectedVariation" :value="$variation->id" :title="$variation->name"
                    />
                @endforeach
            </x-select>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        // $('select[name="proxy_id"]').select2({
        //     language: 'vi',
        //     theme: 'bootstrap-5',
        //     allowClear: true
        // });
        // $('select[name="variation_id"]').select2({
        //     language: 'vi',
        //     theme: 'bootstrap-5',
        //     allowClear: true
        // });
        $('select[name="proxy_id"]').change(function() {
            var proxy_id = $(this).val();
            var variationSelect = $('select[name="variation_id"]');
            variationSelect.empty().append('<option value="">@lang('Chọn Kế hoạch')</option>');
            if (proxy_id) {
                $.ajax({
                    url: '{{ route('admin.cdkey.getVariationByProxy', ['proxy_id' => '__PROXY_ID__']) }}'.replace('__PROXY_ID__', proxy_id),
                    type: 'GET',
                    success: function(data) {
                        data.forEach(function(item) {
                            variationSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                        });

                    },
                    error: function(xhr) {
                        console.error('Error fetching districts:', xhr.responseText);
                    }
                });
            }
        });
    });
</script>

