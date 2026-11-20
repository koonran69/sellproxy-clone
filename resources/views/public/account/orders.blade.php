@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

    <div class="main-content">
        <section class="container px-md-5 px-3 pb-5">
            <div class="row g-4">
                <div class="col-md-3 col-12 d-md-block">
                    @include("public.account.left-sidebar")
                </div>
                <div class="col-md-9 col-12 d-md-block">
                    <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>@lang('Mã đơn hàng')</th>
                            <th>@lang('Khách hàng')</th>
                            <th>@lang('Ngày mua')</th>
                            <th>@lang('Tổng tiền')</th>
                            <th>@lang('Trạng thái')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $k => $order)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>#{{ $order->code }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format("d/m/Y") }}</td>
                            <td>{{ number_format($order->total) }}đ</td>
                            <td>
                                @if($order->status == \App\Core\Enums\Order\OrderStatus::Complete)
                                <span class="badge bg-success">@lang('Hoàn thành')</span>
                                @elseif($order->status == \App\Core\Enums\Order\OrderStatus::PendingPayment)
                                <span class="badge bg-warning">@lang('Chờ thanh toán')</span>
                                @elseif($order->status == \App\Core\Enums\Order\OrderStatus::Canceled)
                                <span class="badge bg-danger">@lang('Đã hủy')</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#orderDetail{{ $order->code }}">
                                    Xem chi tiết
                                </button>
                            </td>
                        </tr>
                        
                        <tr class="collapse" id="orderDetail{{ $order->code }}">
                            <td colspan="7">
                                <div class=" bg-white rounded">
                                    <h5 class="fs-4">Danh sách Proxy</h5>
                                    @foreach($order->data as $item)
                                        @php
                                            $cdKeys = \App\Models\CDkey::where('user_id', $order->user_id)
                                            ->where('proxy_id', $item['product_id'])
                                            ->where('variation_id', $item['variation_id'])
                                            ->where('order_id', $order->id)
                                            ->get();
                                        @endphp
                                    <div class="mb-4 border rounded p-3">
                                        <p><strong>Sản phẩm:</strong> {{ $item['name_vi'] }}</p>
                                        <p><strong>Kế hoạch: </strong> {{ $item["variation_name"] }}</p>
                                        <p><strong>Số lượng:</strong> {{ $item["quantity"] }}</p>
                                        <p><strong>Đơn giá:</strong> {{ number_format($item["price"]) }}đ</p>
                                        <p><strong>Thành tiền:</strong> {{ number_format($item["price"] * $item["quantity"]) }}đ</p>
                                        <p><strong>CDKEYs:</strong></p>
                                        @if($cdKeys)
                                        <ul class="list-group mb-2">
                                            @foreach($cdKeys as $cdKey)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $cdKey->cdkey }}
                                                <button class="btn btn-sm btn-outline-secondary btn-copy" data-key="{{ $cdKey->cdkey }}">Copy</button>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset("public/assets/js/jquery.validate.min.js") }}"></script>
    <script>
        // $('#frmUpdateProfile').validate({
        //     ignore: ".ignore",
        //     rules: {
        //         name: "required",
        //         email: "required",
        //     },
        //     messages: {
        //         email: "Email là bắt buộc",
        //         name: "Họ và tên là bắt buộc",
        //     },
        //     submitHandler: function (form) {
        //         $(form).submit();
        //     }
        // });
    </script>
    <script>
        document.querySelectorAll('.btn-copy').forEach(btn => {
            btn.addEventListener('click', function () {
                const textToCopy = this.getAttribute('data-key');

                // Sao chép vào clipboard
                navigator.clipboard.writeText(textToCopy).then(() => {
                    this.innerText = "Đã copy!";
                    setTimeout(() => this.innerText = "Copy", 1500);
                }).catch(err => {
                    console.error('Lỗi khi copy: ', err);
                });
            });
        });
    </script>
@endpush
