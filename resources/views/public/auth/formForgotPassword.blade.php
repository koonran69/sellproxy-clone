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
                        <h1 class="display-5 fw-bold">Quên mật khẩu</h1>
                        <p class="">Chúng tôi sẽ gửi email cho bạn một liên kết để đặt lại mật khẩu của bạn.</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="mt-4 form-register" id="formRegister" action="{{ route("password.email") }}" method="POST">
                            <div class="form-group mt-4">
                                <label class="mb-2">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control pt-2 pb-2" placeholder="Email" name="email">
                                @error('email') <label id="email-error" class="error" for="email">{{ $message }}</label> @enderror
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block w-100 rounded-4">Gửi</button>
                            </div>
                            @csrf
                        </form>


                        <div class="text-center mt-3">
                            Quay lại <a href="{{ route("auth.login") }}" class="text-primary font-weight-bold">Đăng nhập</a>
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
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Vui lòng nhập email",
                    email: "Email không đúng định dạng"
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush
