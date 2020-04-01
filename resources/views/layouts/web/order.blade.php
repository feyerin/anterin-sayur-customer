<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('public/templates/web/css/style.css')}}">
    @yield('styles')
</head>
<body class="goto-here">

    @include('layouts.web.header')

    <section class="ftco-section">
        @yield('content')
    </section>

    @include('layouts.web.footer')

    <script src="{{asset('public/templates/web/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery-migrate-3.0.1.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/popper.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery.stellar.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/aos.js')}}"></script>
    <script src="{{asset('public/templates/web/js/jquery.animateNumber.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('public/templates/web/js/scrollax.min.js')}}"></script>
    <script src="{{asset('public/templates/web/js/main.js')}}"></script>
    
    @yield('scripts')
</body>
</html>