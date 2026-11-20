<div class="list-group-item">
    <div class="row align-items-center">
        <div class="col-auto">
            <img class="avatar" src="{{ asset($product->feature_image) }}" alt="">
        </div>
        <div class="col text-truncate d-flex justify-content-between gap-2 align-items-end">
            <div class="flex-grow-1">
                <span class="d-block">{{ $product->name }}</span>
                <select class="form-select form-select-sm mt-1" name="proxy_variation">
                    @foreach ($product->variations as $variation)
                        <option value="{{ $variation->pivot->id }}">
                            {{ $variation->name }} -
                            {{ $variation->pivot->price_promotion
                                ? format_price($variation->pivot->price_promotion)
                                : format_price($variation->pivot->price) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn add-product btn-sm btn-outline-primary"
                data-product-id="{{ $product->id }}">
                <i class="ti ti-plus"></i>
                {{ __('Thêm') }}
            </button>
        </div>
    </div>
</div>
