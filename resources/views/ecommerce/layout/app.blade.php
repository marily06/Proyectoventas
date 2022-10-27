<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield("title_page") - {{config('app.name')}} </title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{getIcono()}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500.00,700,300' rel='stylesheet' type='text/css'>

    <!-- all css here -->
    <!-- bootstrap v5.1.0 css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/bootstrap.min.css')}}">


    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/animate.min.css')}}">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/jquery-ui.min.css')}}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/meanmenu.min.css')}}">
    <!-- nivo-slider css -->
    <link rel="stylesheet" href="{{asset('ecommerce/lib/css/nivo-slider.css')}}">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/owl.carousel.css')}}">
    <!-- flaticon css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/shopick-icon.css')}}">
    <!-- pe-icon-7-stroke css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/pe-icon-7-stroke.css')}}">
    <!-- lightbox css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/lightbox.min.css')}}">
    <!-- style css -->
    <link rel="stylesheet" href="{{asset('ecommerce/style.css')}}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{asset('ecommerce/css/responsive.css')}}">
    <!-- modernizr css -->
    <script src="{{asset('ecommerce/js/vendor/modernizr-3.11.2.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/ecommerce.css')}}">

    <style>
        .footer-top {
            background: rgba(0, 0, 0, 0) url("{{asset('ecommerce/img/footer-bg.webp')}}") no-repeat scroll center center / cover !important;
            position: relative;
        }

        .page-banner-area {
            background: rgba(0, 0, 0, 0) url("{{asset('ecommerce/img/header-bg.webp')}}") no-repeat scroll center center;
        }

    </style>

    <!--App css-->
    @stack('css')


</head>
<body>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    @include('ecommerce.layout.partials.navbar')

    @yield('content')


    @include('ecommerce.layout.partials.footer')


    @routes
    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="{{asset('ecommerce/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('ecommerce/js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('ecommerce/js/bootstrap.bundle.min.js')}}"></script>
    <!-- jquery.nivo.slider js -->
    <script src="{{asset('ecommerce/lib/js/jquery.nivo.slider.js')}}"></script>
    <script src="{{asset('ecommerce/lib/home.js')}}"></script>
    <!-- owl.carousel js -->
    <script src="{{asset('ecommerce/js/owl.carousel.min.js')}}"></script>
    <!-- meanmenu js -->
    <script src="{{asset('ecommerce/js/jquery.meanmenu.js')}}"></script>
    <!-- jquery-ui js -->
    <script src="{{asset('ecommerce/js/jquery-ui.min.js')}}"></script>
    <!-- lightbox.min js -->
    <script src="{{asset('ecommerce/js/lightbox.min.js')}}"></script>
    <!-- countdon.min js -->
    <script src="{{asset('ecommerce/js/countdon.min.js')}}"></script>
    <!-- wow js -->
    <script src="{{asset('ecommerce/js/wow.min.js')}}"></script>
    <script type="text/javascript">
        new WOW().init();
    </script>
    <!-- plugins js -->
    <script src="{{asset('ecommerce/js/plugins.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('ecommerce/js/main.js')}}"></script>

    <script src="{{ asset("js/ecommerce.js") }}"></script>

    @include('partials.flash_alert')

    <!-- Scripts inyectados-->
    @stack('scripts')

</body>
</html>
