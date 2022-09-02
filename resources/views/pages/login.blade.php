<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Admin Dashboard</title>
    <meta name="author" content="hencework"/>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- vector map CSS -->
    <link href="{{asset('vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!--/Preloader-->

<div class="wrapper pa-0">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="#">
                <img class="brand-img mr-10" src="{{asset('assets/logo.png')}}" width="20" alt="brand"/>
                <span class="brand-text">O L O L O.es</span>
            </a>
        </div>
        <div class="clearfix"></div>
    </header>

    <div class="page-wrapper pa-0 ma-0 auth-page" id="app">
        <div class="container-fluid">
            <login/>
        </div>
    </div>

</div>
<!-- /#wrapper -->

<!-- JavaScript -->

<!-- Moment JavaScript -->
<script type="text/javascript" src="{{asset('vendors/bower_components/moment/min/moment-with-locales.min.js')}}"></script>

<!-- jQuery -->
<script src="{{asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js')}}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>

<!-- Init JavaScript -->
<script src="{{asset('assets/js/init.js')}}"></script>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
