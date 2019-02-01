<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Dashboard</title>
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

    <link href="{{ asset('assets/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-override.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui-1.10.3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.delay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pace.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toggles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">

</head>
<body class="skin-black fixed">
    @include('layouts.header')
<div class="wrapper row-offcanvas row-offcanvas-left">
<aside class="left-side sidebar-offcanvas">
    @include('layouts.sidebar')
</aside>

<aside class="right-side">
    <section class="content-header">
        <h1>
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-md-6">
            <input type="hidden" name='fdate' id= "fdate" value="{{ $fdate }}" >
            <input type="hidden" name='tdate' id= "tdate" value="{{ $tdate }}" >
            <input type="hidden" name='date' id= "date" value="{{ $date }}" >
                <!-- small box -->
                <div class="small-box bg-sales">
                    <div class="inner">
                        <h3>
                           Sales
                        </h3>
                        <p>
                        <h2>
                        @if(count($todaySale))
                            @foreach($todaySale as $today)
                            
                                Today :  $ {{ $today->total or null}}
                            @endforeach
                        @else
                               Today : $ 0 
                        @endif
                        <br></h2>
                        @if(count($yesterdaySales))
                            @foreach($yesterdaySales as $yesterday)
                                Yesterday :  $ {{ $yesterday->total or null}} <br>
                            @endforeach
                        @else
                               Yesterday : $ 0 <br>
                        @endif
                        @if(count($weeklySale))
                             @foreach($weeklySale as $week)
                                Week :  $ {{ $week->total or null}}  
                            @endforeach
                        @else
                             Week :  $ 0 <br>
                        @endif
                        </p>
                        
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-md-6">
                <!-- small box -->
                <div class="small-box bg-customer">
                    <div class="inner">
                        <h3>
                             Customer</sup>
                        </h3>
                        <p>
                        <h2>
                        Today :  {{$sale_item['customer']['today']}}
                        <br>
                        </h2>
                        Yesterday : {{$sale_item['customer']['yesterday']}}

                         <br>
                        Week : {{$sale_item['customer']['week']}} <br>
                        
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                   
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-md-6">
                <!-- small box -->
                <div class="small-box bg-void">
                    <div class="inner">
                        <h3>
                             Void</sup>
                        </h3>
                        <p>
                        <h2>
                        Today :  {{$sale_item['void']['today']}}
                        <br>
                        </h2>
                        Yesterday : {{$sale_item['void']['yesterday']}}

                         <br>
                        Week : {{$sale_item['void']['week']}} <br>
                        
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pencil"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body padding15">
                            <strong><h2 class="md-title " align="center"><sup style="font-size: 20px">Last 7 Day Sales</sup></strong></h2>
                             <div class="box-body chart-responsive">
                                <div class="chart" id="chart" style="height: 300px;"></div>

                            </div>
                        </div>  
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body padding15">
                            <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">Last 7 Day Customer</sup></strong></h2>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="line-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>      
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body padding15">
                           <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">Sales Summary ( {{ date('D M j Y',strtotime($date)) }} )</sup></strong></h2>
                             <div class="box-body chart-responsive">
                                 <div class="chart col-md-6" id="sales-chart" style="height: 350px;"></div>
                                 <div id="legend" class="donut-legend col-md-6"></div>
                            </div>
                        </div>
                    </div>
            </div>  
        <div>
       <!--  <div class="">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body padding15">
                        <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">daily Sales</sup></strong></h2>
                         <div class="box-body chart-responsive">
                            <div class="chart" id="daily-sales" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>  -->
        <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body padding15" style="padding-bottom:50px;">
                       <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">Top 5 Product</sup></strong></h2>
                         <div class="box-body chart-responsive">
                            <div class="chart" id="item-chart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
           
             <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body padding15" style="padding-bottom:50px;">
                            <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">Top 5 Category</sup></strong></h2>
                             <div class="box-body chart-responsive">
                                <div class="chart" id="bar-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
            </div> 
                
        </div>
        <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body padding15">
                        <strong><h2 class="md-title" align="center"><sup style="font-size: 20px">Past 24 Hours Customer Flow</sup></strong></h2>
                        
                         <div class="box-body chart-responsive">
                            <div class="chart" id="cust-chart" style="height: 300px;"></div>
                        </div>
                        <p class="text-center" style="font-size:14px;">Hour [EST]</p>
                    </div>
                </div>
            </div> 
        </div>
    </section>
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
<script src="{{ asset('assets/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('assets/js/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

</body>
</html>
