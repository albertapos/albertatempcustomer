<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>POS2020 | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section> 

<!-- Main content -->

</aside>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
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

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/js/AdminLTE/dashboard.js') }}" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/js/AdminLTE/demo.js') }}" type="text/javascript"></script>

</body>
</html>
