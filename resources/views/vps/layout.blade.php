<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('public/vps/assets/images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('public/vps/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" />
    <!-- App Css-->
    <link href="{{ asset('public/vps/assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/vps/assets/css/preloader.min.css') }}" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('public/vps/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/vps/assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/vps/assets/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="{{ asset('public/vps/assets/css/admin-custom.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <style>
        .brand {
            padding: 6px 8px;
        }
    </style>
</head>

<body>
<div id="layout-wrapper">

    @include("vps.component.header")

    @include("vps.component.right-bar")

    @include("vps.component.sidebar")

    <div class="main-content">
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    @include("vps.component.footer")
</div>
<script src="{{ asset('public/vps/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/libs/feather-icons/feather.min.js') }}"></script>
<!-- pace js -->
<script src="{{ asset('public/vps/assets/libs/pace-js/pace.min.js') }}"></script>

<script src="{{ asset('public/vps/assets/js/app.js') }}"></script>

<script src="{{ asset('public/vps/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/js/pages/moment.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/js/function.js') }}"></script>
<script src="{{ asset('public/vps/assets/js/pages/validate.min.js') }}"></script>
<script src="{{ asset('public/vps/assets/js/jquery.validate.min.js') }}"></script>
<!-- JS -->
<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/locale/bootstrap-table-vi-VN.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

</script>

@yield('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lặp qua từng group PORT
            document.querySelectorAll('.form-group').forEach(group => {
                const randomUsername = group.querySelector('input[name="status_random_username"]');
                const usernameInput = group.querySelector('input[name="username"]');

                if (randomUsername && usernameInput) {
                    const toggleUsername = () => {
                        if (randomUsername.checked) {
                            // Lưu giá trị tạm
                            if (usernameInput.value) usernameInput.dataset.prevValue = usernameInput.value;
                            usernameInput.classList.add('d-none');
                            usernameInput.value = "";
                        } else {
                            usernameInput.classList.remove('d-none');
                            if (usernameInput.dataset.prevValue) {
                                usernameInput.value = usernameInput.dataset.prevValue;
                            }
                        }
                    };
                    randomUsername.addEventListener('change', toggleUsername);
                    toggleUsername();
                }
            });
            // Lặp qua từng group MẬT KHẨU
            document.querySelectorAll('.form-group').forEach(group => {
                const randomPassword = group.querySelector('input[name="status_random_password"]');
                const passwordInput = group.querySelector('input[name="password"]');
                const togglePasswordBtn = group.querySelector('.toggle-password');

                if (randomPassword && passwordInput) {
                    const togglePasswordVisibility = () => {
                        if (randomPassword.checked) {
                            passwordInput.classList.add('d-none');
                            passwordInput.value = "";
                            togglePasswordBtn?.classList.add('d-none'); // ẩn nút eye nếu có
                        } else {
                            passwordInput.classList.remove('d-none');
                            togglePasswordBtn?.classList.remove('d-none');
                        }
                    };
                    randomPassword.addEventListener('change', togglePasswordVisibility);
                    togglePasswordVisibility();
                }
            });

            // Lặp qua từng group PORT
            document.querySelectorAll('.form-group').forEach(group => {
                const randomPort = group.querySelector('input[name="status_random_port"]');
                const portInput = group.querySelector('input[name="port"]');

                if (randomPort && portInput) {
                    const togglePort = () => {
                        if (randomPort.checked) {
                            // Lưu giá trị tạm
                            if (portInput.value) portInput.dataset.prevValue = portInput.value;
                            portInput.classList.add('d-none');
                            portInput.value = "";
                        } else {
                            portInput.classList.remove('d-none');
                            if (portInput.dataset.prevValue) {
                                portInput.value = portInput.dataset.prevValue;
                            }
                        }
                    };
                    randomPort.addEventListener('change', togglePort);
                    togglePort();
                }
            });

            // Validate tất cả form có class .order-vps-form
            document.querySelectorAll('.order-vps-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    let hasError = false;

                    // Validate PASSWORD
                    const randomPassword = form.querySelector('input[name="status_random_password"]');
                    const passwordInput = form.querySelector('input[name="password"]');
                    const passwordError = form.querySelector('.invalid-feedback-password');

                    if (randomPassword && !randomPassword.checked && passwordInput) {
                        const pwd = passwordInput.value.trim();
                        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*]).{10,}$/;

                        if (!strongRegex.test(pwd)) {
                            hasError = true;
                            passwordInput.classList.add("is-invalid");
                            if (passwordError) {
                                passwordError.textContent =
                                    "Mật khẩu phải ≥ 10 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt (~!@#$%^&*)";
                            }
                        } else {
                            passwordInput.classList.remove("is-invalid");
                            if (passwordError) passwordError.textContent = "";
                        }
                    }

                    // Validate PORT
                    const randomPort = form.querySelector('input[name="status_random_port"]');
                    const portInput = form.querySelector('input[name="port"]');
                    const portError = form.querySelector('.invalid-feedback-port');

                    if (randomPort && !randomPort.checked && portInput) {
                        const port = parseInt(portInput.value);
                        if (isNaN(port) || port < 10000 || port > 65000) {
                            hasError = true;
                            portInput.classList.add("is-invalid");
                            if (portError) portError.textContent = "Port phải nằm trong khoảng 10000 – 65000.";
                        } else {
                            portInput.classList.remove("is-invalid");
                            if (portError) portError.textContent = "";
                        }
                    }

                    if (hasError) e.preventDefault();
                });
            });
        });

        // Xử lý toggle hiển thị mật khẩu (chung)
        $(document).on('click', '.toggle-password', function () {
            const $btn = $(this);
            const $input = $btn.closest('.input-group').find('input[name="password"]');
            const $icon = $btn.find('i');

            if (!$input.length) return; // phòng trường hợp không tìm thấy input

            if ($input.prop('type') === 'password') {
                $input.prop('type', 'text');
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $input.prop('type', 'password');
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>

</body>

</html>
