<div class="list-group list-group-flush">
    @foreach($data as $item)
        <div class="list-group-item px-0 pt-2 pb-2">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="fw-medium">{{ $item['name_vi'] }}</span>
                            <small class="d-block text-muted">{{ $item['variation_name'] }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-medium text-danger">{{ number_format($item['total_price']) }}đ</div>
                            <small class="text-muted">SL: {{ $item['quantity'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>