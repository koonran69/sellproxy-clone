@if($reference_type == \App\Models\Order::class && isset($reference['id']))
    <a href="{{ route('admin.order.edit', ['id' => $reference['id'] ]) }}" target="_blank">{{ $code }}</a>
@else
    {{ $code }}
@endif