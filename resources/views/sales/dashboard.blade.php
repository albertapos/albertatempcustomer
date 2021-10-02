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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Store Detail</h3>
                    <div class="pull-right" style="padding: 10px 10px 10px 10px;">
                        <a href="/sales/vendors/create" class="btn btn-success btn-md">
                        <i class="fa fa-plus-circle"></i> New Store
                        </a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Store Name</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th colspan="2">&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        @foreach ($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td><a href="{{ url('sales/vendors/view',$store->id) }}">{{ $store->name }}</a></td>
                            <td>
                            @if($store->user)
                               @foreach($store->user as $row)
                                       {{ $row->fname }}
                               @endforeach
                            @endif
                            </td>
                            <td>
                            @if($store->user)
                               @foreach($store->user as $row)
                                       {{ $row->email }}
                               @endforeach
                            @endif
                            </td>
                            <td>{{ $store->phone }}</td>
                            <td>{{ $store->address }},{{ $store->country }},<br>
                            {{ $store->state }}{{ $store->city }}{{ $store->zip }}</td>
                            <td>{{ $store->created_at->format('j-M-y g:ia') }}</td>
                            <td>{{ $store->updated_at->format('j-M-y g:ia') }}</td>
                             <td>
                                <a href="/sales/vendors/{{ $store->id }}/edit"
                                class="btn btn-xs btn-info">
                                    <i class="fa fa-pencil"></i> 
                                </a>
                            </td>
                            <td>
                                <form class="form-group delete" action="{{ url('sales/vendors', $store->id) }}" method="post" accept-charset="utf-8">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>  
</section>          
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>        
<script>
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Store?");
    });
</script>

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
<script src="{{ asset('assets/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('assets/js/flot/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('assets/js/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

</body>
</html>