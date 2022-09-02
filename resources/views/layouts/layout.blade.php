<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}">
    <link rel="icon" href="{{asset('assets/logo.png')}}" type="image/x-icon">

    <!-- Morris Charts CSS -->
    <link href="{{asset('vendors/bower_components/morris.js/morris.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Data table CSS -->
    <link href="{{asset('vendors/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Colorpicker CSS -->
    <link href="{{asset('vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Datetimepicker CSS -->
    <link href="{{asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Daterangepicker CSS -->
    <link href="{{asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{asset('vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css')}}" rel="stylesheet" type="text/css">

    <!-- vector map CSS -->
    <link href="{{asset('vendors/bower_components/bower-jvectormap-2/jquery-jvectormap-2.0.0.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>
@include('layouts.preloader')
<div class="wrapper theme-1-active pimary-color-red">
    @include('layouts.top')

    <div class="page-wrapper" style="margin-left: 0;">
        <div class="container-fluid pt-25" id="app">
            @yield('content')
        </div>

        @include('layouts.footer')

    </div>

</div>

<!-- jQuery -->
<script src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Moment JavaScript -->
<script type="text/javascript" src="{{asset('vendors/bower_components/moment/min/moment-with-locales.min.js')}}"></script>

<!-- Bootstrap Colorpicker JavaScript -->
<script src="{{asset('vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>

<!-- Bootstrap Datetimepicker JavaScript -->
<script type="text/javascript" src="{{asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

<!-- Bootstrap Daterangepicker JavaScript -->
<script src="{{asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- Data table JavaScript -->
<script src="{{asset('vendors/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

<!-- simpleWeather JavaScript -->
<script src="{{asset('vendors/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js')}}"></script>
<script src="{{asset('assets/js/simpleweather-data.js')}}"></script>

<!-- Progressbar Animation JavaScript -->
<script src="{{asset('vendors/bower_components/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/jquery.counterup/jquery.counterup.min.js')}}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{asset('assets/js/dropdown-bootstrap-extended.js')}}"></script>

<!-- Sparkline JavaScript -->
<script src="{{asset('vendors/sparkline.js')}}"></script>

<!-- Owl JavaScript -->
<script src="{{asset('vendors/bower_components/owl.carousel/dist/owl.carousel.min.js')}}"></script>

<!-- ChartJS JavaScript -->
<script src="{{asset('vendors/chart.js')}}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{asset('vendors/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>

<!-- Switchery JavaScript -->
<script src="{{asset('vendors/bower_components/switchery/dist/switchery.min.js')}}"></script>

<!-- Vector Maps JavaScript -->
<script src="{{asset('vendors/bower_components/bower-jvectormap-2/jquery-jvectormap-2.0.0.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/bower-jvectormap-2/jquery-jvectormap-es-merc-en.js')}}"></script>
<script src="{{asset('assets/js/jquery-jvectormap-es-mill.js')}}"></script>

<!-- Init JavaScript -->
<script src="{{asset('assets/js/init.js')}}"></script>

<!-- Custom -->
<script src="{{asset('js/app.js')}}"></script>

{{--<script src="{{asset('assets/js/dashboard-data.js')}}"></script>--}}
</body>

</html>
