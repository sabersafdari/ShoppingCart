<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url()->asset('/dashboard_assets/css/myCustomCss.css')}}">
    <title>@yield('title')</title>
    @yield('css')
</head>
<body>
@include('dashboard.sections.header')
@yield('main')
@include('dashboard.sections.footer')
<script src="{{url()->asset('/dashboard_assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url()->asset('/dashboard_assets/js/jquery.min.js')}}"></script>
@yield('js')
</body>
</html>
