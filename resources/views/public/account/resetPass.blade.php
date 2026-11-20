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
                                    <h5 class="card-title mb-1 fw-bold account-main-title">Đổi mật khẩu</h5>
                                    <p class="text-muted mb-0 account-sub-title">Thử mật khẩu với các ký tự đặt biệt để tăng tính bảo mật</p>
                                </div>
                            </div>
                            <form id="frmUpdateProfile" action="{{ route("account.resetPass") }}" method="POST">
                                @csrf
                                <div class="mb-3 form-group">
                                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                    <input value="" type="password" class="form-control" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                                    @error('current_password') <label id="current_password-error" class="error" for="current_password">{{ $message }}</label> @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                                    <input value="" type="password" class="form-control" id="new_password" name="new_password" placeholder="Mật khẩu mới" required>
                                    @error('new_password') <label id="new_password-error" class="error" for="new_password">{{ $message }}</label> @enderror
                                </div>
                                <div class="mb-3 form-group">
                                    <label for="new_password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                                    <input value="" type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
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
                current_password: "required",
                new_password: "required",
                new_password_confirmation: "required",
            },
            messages: {
                current_password: "Mật khẩu là bắt buộc",
                new_password: "Mật khẩu mới là bắt buộc",
                new_password_confirmation: "Nhập lại mật khẩu mới là bắt buộc"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    </script>
@endpush
