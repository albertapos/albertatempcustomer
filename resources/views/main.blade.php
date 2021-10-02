<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="{{ asset('assets/css/morris/morris.css') }} " rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="{{ asset('assets/css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Date Picker -->
    <link href="{{ asset('assets/css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="{{ asset('assets/css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{{ asset('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    @yield('head')

</head>
<body class="skin-black fixed">
<!-- header logo: style can be found in header.less -->
    @include('layouts.header')
<div class="wrapper row-offcanvas row-offcanvas-left">
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    @include('layouts.sidebar')

</aside>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">

    @yield('content')

</aside>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script> 

<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('assets/js/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/js/plugins/jqueryKnob/jquery.knob.js') }}" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<!-- datepicker -->
<script src="{{ asset('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('assets/js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets/js/AdminLTE/app.js') }}" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

@yield('scripts')

</body>
</html>
