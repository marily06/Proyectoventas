<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title> @yield('htmlheader_title', config('app.name')) </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/logo.png')}}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="manifest" href="{{asset('manifest_ecommerce.json')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('icons/180.png')}}" />
    <meta name="theme-color" content="#014AB0">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">

        @include('ecommerce.partials.factura')
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>
</body>
</html>
