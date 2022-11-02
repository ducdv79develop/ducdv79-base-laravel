<!DOCTYPE html>
<html lang="vi">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta http-equiv="content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- ================= Page description ================== -->

    @yield('addCss')
</head>
<body>
<div class="page-body">
    @include('frontend.layouts.header')

    @yield('content')

    @include('frontend.layouts.footer')
    @yield('addJs')
</div>
</body>
</html>
