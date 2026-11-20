<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('public/proxyresidential/assets/images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App Css-->
    <link href="{{ asset('public/proxyresidential/assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/proxyresidential/assets/css/preloader.min.css') }}" type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="{{ asset('public/proxyresidential/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('public/proxyresidential/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/proxyresidential/assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/proxyresidential/assets/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="{{ asset('public/proxyresidential/assets/css/admin-custom.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <style>
        .brand {
            padding: 6px 8px;
        }
    </style>
</head>

<body>
<div id="layout-wrapper">

    @include("proxy-residential.component.header")

    @include("proxy-residential.component.right-bar")

    @include("proxy-residential.component.sidebar")

    <div class="main-content">
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    @include("proxy-residential.component.footer")
</div>
<script src="{{ asset('public/proxyresidential/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/libs/feather-icons/feather.min.js') }}"></script>
<!-- pace js -->
<script src="{{ asset('public/proxyresidential/assets/libs/pace-js/pace.min.js') }}"></script>

<script src="{{ asset('public/proxyresidential/assets/js/app.js') }}"></script>

<script src="{{ asset('public/proxyresidential/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/js/pages/moment.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/js/function.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/js/pages/validate.min.js') }}"></script>
<script src="{{ asset('public/proxyresidential/assets/js/jquery.validate.min.js') }}"></script>
<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css" />
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
</body>

</html>
