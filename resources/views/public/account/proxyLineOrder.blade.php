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
                            <th>@lang('Số Proxies')</th>
                            <th>@lang('Loại')</th>
                            <th>@lang('Quốc gia')</th>
                            <th>@lang('Ngày tạo')</th>
                            <th>@lang('Ngày còn lại')</th>
                            <th>@lang('Tổng tiền')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $k => $order)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>#{{ $order->code }}</td>
                            <td>{{ $order->proxy_instances_count }}</td>
                            <td>{{ $order->proxyType->name }}, {{ $order->ipVersion->version }}</td>
                            <td><img src="{{ asset($order->country->feature_image) }}" alt=""> {{ $order->country->name }}</td>
                            <td>{{ $order->date_start }}</td>
                            <td>{{ $order->remaining_days }} ngày</td>
                            <td>{{ number_format($order->total_amount) }}đ</td>
                            <td>
                                <a href="{{ route('account.proxyLineList', ['order_id' => $order->code ]) }}">Xem</a>
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
