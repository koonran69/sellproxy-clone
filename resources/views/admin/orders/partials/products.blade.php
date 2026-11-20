@if (!isset($order))
    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
        <i class="ti ti-plus"></i> {{ __('Thêm proxy') }}
    </button>
@endif
<table id="tableProduct" class="table table-transparent table-responsive mb-0">
    <thead>
        <tr>
            <th class="text-center" style="width: 1%"></th>
            <th>{{ __('Tên mặt hàng') }}</th>
{{--            <th>{{ __('Loại tài khoản') }}</th>--}}
            <th class="text-start" style="width: 12%">{{ __('Số lượng') }}</th>
            <th class="text-end" style="width: 1%">{{ __('Giá') }}</th>
            <th class="text-end" style="width: 1%">{{ __('Thành tiền') }}</th>
        </tr>
    </thead>
    <tbody>
{{--        @each('admin.orders.partials.item-product', $order->data ?? [], 'data', 'admin.orders.partials.no-item-product')--}}
        @foreach($order->data ?? [] as $data)
            @include('admin.orders.partials.item-product', [
                'data' => $data,
                'order' => $order,
            ])
        @endforeach
        
        @empty($order->data)
            @include('admin.orders.partials.no-item-product')
        @endempty
    </tbody>
</table>

@include('admin.orders.partials.total', [
    'total' => $order->total ?? 0,
    'sub_total' => $order->sub_total ?? 0,
])
