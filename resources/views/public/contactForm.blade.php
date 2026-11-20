@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection
<style>
    .main-content{
        padding-bottom: 50px!important;
    }
</style>
@section('content')
    <div class="main-content">
        <div class="container">
            <h1 class="text-center mt-4 mb-4 fw-bold">@lang('Liên hệ hỗ trợ & hợp tác kinh doanh cùng Sellsocks247')</h1>
            <div class="row mt-6">
                <div class="col-md-7">
                    <form id="contact-form" method="POST" action="{{ route('contact.post') }}">
                        <div class="row mb-5">
                            <div class="col-md-6 mb-md-0 mb-5">
                                <label class="form-label fw-bold">@lang('Họ tên') <span class="text-danger">*</span></label>
                                <input id="fullname" name="fullname" type="text" class="gradient-border form-control rounded-4" placeholder="Nguyễn Văn A">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">@lang('Email') <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="gradient-border form-control rounded-4" placeholder="123@gmail.com">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bold">@lang('Tiêu đề') <span class="text-danger">*</span></label>
                            <input id="subject" name="subject" type="text" class="gradient-border form-control rounded-4" placeholder="@lang('Tiêu đề')">
                        </div>
                        <div class="mb-5">
                            <label class="form-label fw-bold">@lang('Thông điệp') <span class="text-danger">*</span></label>
                            <textarea id="message" name="message" class="gradient-border form-control rounded-4" rows="10" placeholder="@lang('Thông điệp')"></textarea>
                        </div>
                        <div class="container-group-btn">
                            <button class="btn-container" type="submit">
                                <div class="icon-container">
                                    <img src="{{ asset("public/assets/images/VectorRight.svg") }}">
                                </div>
                                <div class="text-container">
                                    @lang('Gửi')
                                </div>
                            </button>
                        </div>
                        @csrf
                    </form>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <div class="contact-info">
                        <h5 class="fs-2 mt-6">@lang('Liên hệ')</h5>
                        <p>Email: nickchatdelamgi@gmail.com</p>
                        <p>Telegram: @nickchatdelamgi</p>
{{--                        <h5 class="fs-2 mt-6">Open Time</h5>--}}
{{--                        <p>Monday - Friday: 10:00 - 20:00</p>--}}
{{--                        <p>Saturday - Sunday: 11:00 - 18:00</p>--}}
                        <h5 class="fs-2 mt-6">@lang('Giữ kết nối')</h5>
                        <div class="social-icons">
{{--                            <a href="https://zalo.me/0708762402" target="_blank"><img src="{{ asset("public/assets/images/zalo-icon-40.png") }}"/></a>--}}
                            <a href="https://t.me/nickchatdelamgi" target="_blank"><img src="{{ asset("public/assets/images/Telegram_logo.svg.webp") }}"/></a>
{{--                            <a href="https://www.facebook.com/ssh.sell.3/" target="_blank"><img src="{{ asset("public/assets/images/2021_Facebook_icon_40.png") }}"/></a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="banner-section-bottom-contact position-relative text-center mt-7">
            <div class="container position-relative" style="z-index: 2;">
                <div class="pb-5">
                    <h2 class="gradient-title mb-0">@lang('Bảo mật tuyệt đối')</h2>
                    <p class="gradient-title">@lang('Truy cập không giới hạn')</p>
                </div>
{{--                <a class="btn btn-contect-us mt-5" href="https://zalo.me/0708762402" target="_blank">@lang('Kết nối ngay')</a>--}}
            </div>
        </section>
        <div class="container">
            <div class="box-item-content">
                <div class="row">
                    <div class="col-md-4 d-flex mb-4 gap-4 box-contact-bottom">
                        <img src="{{ asset('public/assets/images/icon _people_.png') }}" alt="Proxy chính hãng" class="mb-2">
                        <div>
                            <h5>@lang('Proxy chính hãng')</h5>
                            <p>@lang('Kết nối ổn định, bảo mật cao, hỗ trợ mọi nhu cầu!')</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex mb-4 gap-4 box-contact-bottom">
                        <img src="{{ asset('public/assets/images/icon _crop_.png') }}" alt="Proxy tốc độ cao" class="mb-2">
                        <div>
                            <h5>@lang('Proxy tốc độ cao')</h5>
                            <p>@lang('Ẩn danh, bảo vệ dữ liệu, truy cập không giới hạn!')</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex mb-4 gap-4 box-contact-bottom">
                        <img src="{{ asset('public/assets/images/icon _circle check_.png') }}" alt="Proxy chất lượng" class="mb-2">
                        <div>
                            <h5>@lang('Proxy chất lượng')</h5>
                            <p>@lang('Giải pháp tối ưu cho doanh nghiệp & cá nhân!')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset("public/assets/js/jquery.validate.min.js") }}"></script>
    <script>
        $('#contact-form').validate({
            ignore: ".ignore",
            rules: {
                fullname: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true,
                    minlength: 5
                },
                message: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                fullname: {
                    required: "Vui lòng nhập họ tên",
                    minlength: "Họ tên phải có ít nhất 3 ký tự"
                },
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email không hợp lệ"
                },
                subject: {
                    required: "Vui lòng nhập tiêu đề",
                    minlength: "Tiêu đề phải có ít nhất 5 ký tự"
                },
                message: {
                    required: "Vui lòng nhập nội dung tin nhắn",
                    minlength: "Tin nhắn phải có ít nhất 10 ký tự"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush
