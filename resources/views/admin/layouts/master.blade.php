<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') | AdminDVD </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="created_by" content="dvd79">
    <base href="{{ asset('') }}">
    <!-- Google Font: Roboto Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,600,700,800,900&subset=vietnamese">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/ionicons.min.css') }}">
    <link rel="icon" href="{{ asset('admin/dist/img/favicon.png') }}" type="image/x-icon"/>
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.css') }}">
    @yield('usePluginsCss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <!-- Main CSS -->
    <link href="{{ asset('admin/main/css/common.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/main/css/style.css') }}" rel="stylesheet" media="all">
    @yield('addCss')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
@include('admin.layouts.header_top')
@include('admin.layouts.header')
    <div class="content-wrapper">
        @yield('breadcrumb')
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <div class="loader" id="loader">Loading...</div>
    </div>
    @include('admin.layouts.footer')
</div>
<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/moment/locales.min.js') }}"></script>
@yield('usePluginsJs')
<!-- Toastr -->
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('admin/main/js/core.js') }}"></script>
<script src="{{ asset('admin/main/js/common.js') }}"></script>
<!-- Toastr Message In SESSION -->
<script type="text/javascript">
    toastr.options = {
        "debug": false,
        "positionClass": "toast-top-right",
        "progressBar": true,
        "onclick": null,
        "fadeIn": 300,
        "fadeOut": 100,
        "timeOut": 5000,
        "extendedTimeOut": 5000
    }
    @if (session()->has(SESSION_SUCCESS) && session()->get(SESSION_SUCCESS))
    toastr.success('{!! session()->get(SESSION_SUCCESS) !!}')
    @endif
    @if (session()->has(SESSION_FAIL) && session()->get(SESSION_FAIL))
    toastr.error('{!! session()->get(SESSION_FAIL) !!}')
    @endif
    @if (session()->has(SESSION_WARNING) && session()->get(SESSION_WARNING))
    toastr.warning('{!! session()->get(SESSION_WARNING) !!}')
    @endif
    @if (session()->has(SESSION_INFO) && session()->get(SESSION_INFO))
    toastr.info('{!! session()->get(SESSION_INFO) !!}')
    @endif
</script>
@yield('addJs')
</body>
</html>
