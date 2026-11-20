<tr class="item-product product-{{ $proxy->id }} variation-{{ $variation->id }}" data-product-id="{{ $proxy->id }}"
    data-variation-id="{{ $variation->id }}">
    <td class="align-middle">
        <span class="cursor-pointer remove-item-product" data-id="0"><i class="ti ti-x"></i></span>
    </td>
    <td class="align-middle">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <img class="avatar" src="{{ asset($proxy->feature_image) }}" alt="{{ $proxy->name }}">
            </div>
            <div>
                <strong>{{ $proxy->name }}</strong>
                <div class="text-muted small">
                    ({{ $variation->variation->name }})
                </div>
            </div>
        </div>
    </td>
    <td class="text-start align-middle">
        <div class="quantity-wrapper">
            <button type="button" class="btn btn-outline-secondary change-quantity" data-type="minus">-</button>
            <input type="text" class="form-control quantity" value="1" name="data[quantity][]"
                data-price="{{ $variation->price_promotion ?: $variation->price }}">
            <button type="button" class="btn btn-outline-secondary change-quantity" data-type="plus">+</button>
        </div>
    </td>
    <td class="text-end align-middle">
        <span class="small">{{ format_price($variation->price_promotion ?: $variation->price) }}</span>
    </td>
    <td class="text-end align-middle">
        <span class="small total-price">{{ format_price($variation->price_promotion ?: $variation->price) }}</span>
    </td>

    <input type="hidden" name="data[product_id][]" value="{{ $proxy->id }}">
    <input type="hidden" name="data[variation_id][]" value="{{ $variation->id }}">
    <input type="hidden" name="data[price][]" value="{{ $variation->price }}">
    <input type="hidden" name="data[price_promotion][]" value="{{ $variation->price_promotion }}">
</tr>
