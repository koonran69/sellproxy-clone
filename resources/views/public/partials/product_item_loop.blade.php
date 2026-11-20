<div class="col-6 col-md-3 col-sm-6 mb-4">
    <div class="card product-card position-relative">
        <a href="{{ route("proxy.detail", [ "slug" => $proxy->slug ]) }}" title="{{ $proxy->name }}">
            <img src="{{ asset($proxy->feature_image) }}" class="product-img" alt="9proxy">
            <div class="card-body">
                <h5 class="card-title mb-1"><h5 class="card-title mb-1">{{ Str::limit($proxy->name, 50, '...') }}</h5></h5>
                @if($proxy->minVariation)
                    <p class="text-muted small">{{ $proxy->minVariation->variation->name ?? "" }} {{ $proxy->minVariation->duration }}</p>
                @endif
                @if ($proxy->minVariation && $proxy->minVariation->has_promotion)
                    <p class="price-new">{{ number_format($proxy->minVariation->price_promotion) }}₫ <span class="usd-price">≈ {{ convert_vnd_to_usd($proxy->minVariation->price_promotion) }}</span></p>
                    <p class="price-old">{{ number_format($proxy->minVariation->price) }}₫</p>
                    <span class="discount-badge">-{{ $proxy->minVariation->discount_percentage }}%</span>
                @else
                    <p class="price-new">{{ number_format($proxy->minVariation->price) }}₫ <span class="usd-price">≈ {{ convert_vnd_to_usd($proxy->minVariation->price) }}</span></p>
                @endif
            </div>
        </a>
    </div>
</div>
