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
                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1 fw-bold account-main-title">Hồ sơ</h5>
                                    <p class="text-muted mb-0 account-sub-title">Quản lý hồ sơ và thông tin đăng
                                        nhập</p>
                                </div>
                            </div>
                            <form id="frmUpdateProfile" action="{{ route("account.updateProfile") }}" method="POST">
                                @csrf
                                <div class="mb-3 form-group">
                                    <label for="name" class="form-label fw-bold">Họ và tên</label>
                                    <input value="{{ $userProfile->name }}" type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên" required>
                                    @error('name') <label id="name-error" class="error" for="name">{{ $message }}</label> @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input value="{{ $userProfile->email }}" type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                                    @error('email') <label id="email-error" class="error" for="email">{{ $message }}</label> @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                                    <input value="{{ $userProfile->phone }}" type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </form>
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
        $('#frmUpdateProfile').validate({
            ignore: ".ignore",
            rules: {
                name: "required",
                email: "required",
            },
            messages: {
                email: "Email là bắt buộc",
                name: "Họ và tên là bắt buộc",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush
