<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url()->asset('/assets/css/myCustomCss.css')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    @yield('css')
</head>
<body>
@include('website.sections.header')
@yield('main')
@include('website.sections.footer')
<script src="{{url()->asset('/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url()->asset('/assets/js/jquery.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
</body>
</html>
