<div style="text-align: right;">
    <span class="variation-price fw-bold text-danger" data-row-id="{{ $id }}">
        {{ format_price($variations[0]['pivot']['price_promotion'] ?? $variations[0]['pivot']['price'] ?? 0) }}
    </span><br>
    <small class="text-muted price-dolar">
        <img src="{{ asset('assets/images/tether.png') }}" alt="" style="width: 14px;">
        <span class="data-dolar" data-row-id="{{ $id }}">
            {{ convert_vnd_to_usd($variations[0]['pivot']['price_promotion'] ?? $variations[0]['pivot']['price'] ?? 0) }}
        </span>
    </small>
</div>
