<x-select class="variation-select" data-row-id="{{ $id }}">
    @foreach ($variations as $variation)
        <option value="{{ $variation['id'] }}" 
                data-price="{{ $variation['pivot']['price_promotion'] ?? $variation['pivot']['price'] }}">
            {{ $variation['name'] }}
        </option>
    @endforeach
</x-select>
