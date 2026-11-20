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
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1 fw-bold account-main-title">Lịch sử mua hàng</h5>
                                    <p class="text-muted mb-0 account-sub-title">Hướng dẫn nạp CDkey <a href="#">Tại đây</a></p>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>@lang('Mã')</th>
                                    <th>@lang('Loại')</th>
                                    <th>@lang('Số tiền')</th>
                                    <th>@lang('Trạng thái')</th>
                                    <th>@lang('Ngày tạo')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deposits as $deposit)
                                    <tr>
                                        <td>#{{ $deposit->code }}</td>
                                        <td>{{ App\Core\Enums\Deposit\Type::from($deposit->type->value)->description()}}</td>
                                        <td>{{ number_format($deposit->amount) }}đ</td>
                                        <td>
                                            <label class="badge {{ App\Core\Enums\Deposit\Status::from($deposit->status->value)->badge() }}">
                                                {{ App\Core\Enums\Deposit\Status::from($deposit->status->value)->description() }}
                                            </label>
                                        </td>
                                        <td>{{ $deposit->created_at->format("d/m/Y") }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            let navbarToggler = document.querySelector(".navbar-toggler");
            let navbar = document.querySelector("header .navbar");
            let btnLoginMobile = document.getElementById("btn-mobile-primary");
            navbarToggler.addEventListener("click", function () {
                if (navbarToggler.getAttribute("aria-expanded") === "true") {
                    navbar.style.borderRadius = "10px";
                    btnLoginMobile.classList.add("btn-linear-primary");
                    btnLoginMobile.style.textAlign = "center";
                } else {
                    navbar.style.borderRadius = "200px"; // Reset to default
                }
            });
        });
    </script>
@endpush
