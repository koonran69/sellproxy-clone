@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

    <div class="main-content">
        <section class="container justify-content-center">
            <div class="row w-100 align-items-center">
                <!-- Hình nền -->
                <div class="col-lg-7 d-flex justify-content-center mb-4 mb-lg-0">
                    <img src="{{ asset("public/assets/images/OBJECTS.png") }}" class="img-fluid" style="max-height: 353px; object-fit: contain;">
                </div>
                <!-- Form đăng ký -->
                <div class="col-lg-5">
                    <div class="card shadow-lg p-4">
                        <h1 class="display-5 fw-bold">Đăng ký</h1>
                        <p class="">Trở thành thành viên để tiến hành giao dịch dễ dàng hơn!</p>
                        <form class="mt-4 form-register block-double-click" id="formRegister" action="{{ route("auth.postRegister") }}" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="mb-2">Họ và tên<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control pt-2 pb-2" placeholder="Họ và tên" name="name" id="name">
                                    @error('name') <label id="name-error" class="error" for="name">{{ $message }}</label> @enderror
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label class="mb-2">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control pt-2 pb-2" placeholder="Email" name="email" id="email">
                                @error('email') <label id="email-error" class="error" for="email">{{ $message }}</label> @enderror
                            </div>
                            <div class="form-group mt-4">
                                <label class="mb-2">Mật khẩu<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control pt-2 pb-2" placeholder="Mật khẩu" name="password" id="password">
                                    <div class="input-group-append">
                                        <button class="btn-show-pass toggle-password" type="button"  data-destination="password">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <label id="password-error" class="error" for="password">@error('password') {{ $message }} @enderror</label>
                            </div>
                            <div class="form-group mt-4">
                                <label class="mb-2">Xác nhận mật khẩu<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control pt-2 pb-2" placeholder="Xác nhận mật khẩu" name="repassword" id="repassword">
                                    <div class="input-group-append">
                                        <button class="btn-show-pass toggle-password" type="button" data-destination="repassword">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <label id="repassword-error" class="error" for="repassword">@error('repassword') {{ $message }} @enderror</label>
                            </div>
                            <div class="form-group form-check mt-4">
                                <input type="checkbox" class="form-check-input" name="accept_terms" id="accept_terms">
                                <label class="form-check-label">
                                    Tôi đồng ý với <a href="{{ asset('/assets/files/dieukhoandichvu.pdf') }}" target="_blank" rel="noopener noreferrer" class="text-primary font-weight-bold">Điều khoản dịch vụ</a> của {{ env('APP_NAME') }}.
                                </label>
                                <label id="accept_terms-error" class="error" for="accept_terms">@error('accept_terms') {{ $message }} @enderror</label>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                            </div>
                            @csrf
                        </form>
                        <div class="text-center mt-3">
                            Đã có tài khoản? <a href="{{ route("auth.login") }}" class="text-primary font-weight-bold">Đăng nhập</a>
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
        $('#formRegister').validate({
            ignore: ".ignore",
            rules: {
                name: "required",
                email: "required",
                password: "required",
                repassword: {
                    required: true,
                    equalTo: "#password"
                },
                accept_terms: "required"
            },
            messages: {
                name: "Họ và tên là bắt buộc",
                email: "Email là bắt buộc",
                password: "Mật khẩu là bắt buộc",
                repassword: {
                    required: "Nhập lại mật khẩu là bắt buộc",
                    equalTo: "Mật khẩu nhập lại không khớp"
                },
                accept_terms: "Vui lòng xác nhận đồng ý với điều khoản bảo mật và chính sách bảo mật"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush
