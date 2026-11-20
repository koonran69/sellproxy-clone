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
                        <h1 class="display-5 fw-bold">Đăng nhập</h1>
                        <p class="">Chào mừng bạn đã quay trở lại!</p>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="mt-4 form-register" id="formRegister" action="{{ route("auth.postLogin") }}" method="POST">
                            <div class="form-group mt-4">
                                <label class="mb-2">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control pt-2 pb-2" placeholder="Email" name="email">
                                @error('email') <label id="email-error" class="error" for="email">{{ $message }}</label> @enderror
                            </div>
                            <div class="form-group mt-4">
                                <label class="mb-2">Mật khẩu<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control pt-2 pb-2" placeholder="Mật khẩu" name="password" id="password">
                                    <div class="input-group-append">
                                        <button class="btn-show-pass toggle-password" type="button" data-destination="password">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <label id="password-error" class="error" for="password">@error('password') {{ $message }} @enderror</label>
                            </div>
                            <div class="text-end"><a href="{{ route('password.request') }}">Quên mật khẩu?</a></div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-block w-100 rounded-4">Đăng nhập</button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center position-relative w-100">
                                <hr class="w-100 my-4 border border-secondary-subtle">
                                <span class="position-absolute px-3 fw-medium text-dark">Hoặc</span>
                            </div>
                            @csrf
                        </form>
                        <div class="text-end">
                            <button id="google-login" class="btn d-flex justify-content-center align-items-center gap-2 w-100 border rounded-4 py-2 px-4 fw-medium text-lg bg-transparent hover-bg-light border-opacity-50 hover-border-dark">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo" class="w-4 h-4">
                                <span>Đăng nhập Google</span>
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-center position-relative w-100">
                            <hr class="w-100 my-4 border border-secondary-subtle">
                            <span class="position-absolute px-3 fw-medium text-dark">Hoặc</span>
                        </div>

                        <div class="text-center mt-3">
                            Chưa có tài khoản? <a href="{{ route("auth.register") }}" class="text-primary font-weight-bold">Đăng ký</a>
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
                email: "required",
                password: "required",
            },
            messages: {
                email: "Email là bắt buộc",
                password: "Mật khẩu là bắt buộc",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        document.getElementById('google-login').addEventListener('click', function() {
            google.accounts.oauth2.initTokenClient({
                client_id: "{{ config("services.google.client_id") }}",
                scope: "email profile",
                callback: (response) => {
                    if (response.access_token) {
                        fetch("{{ route('auth.google') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ token: response.access_token })
                        }).then(res => res.json()).then(data => {
                                console.log("Login success:", data);
                              window.location = data.redirect_url;
                        }).catch(err => console.error("Error:", err));
                    }
                }
            }).requestAccessToken();
        });
    </script>
@endpush
