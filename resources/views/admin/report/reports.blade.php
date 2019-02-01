@extends('main')
@section('content')
<section class="content-header">
	<h1>
	 Reports
	    <small>it all starts here</small>
	</h1>
	<ol class="breadcrumb">
	    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> </a></li>
	    <li><a href="#"></a></li>
	    <li class="active"></li> -->
	</ol>
</section><br>
	<div class="col-md-12">
			  @include('layouts.partials.errors')
			  @include('layouts.partials.flash')
			  @include('layouts.partials.success')
	</div>
  	<section class="content">
		<div class="row">
			<div class="col-xs-12">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Search Filter</div>
                        <div class="panel-body">
                            {!! Form::open(['url'=>'admin/report', 'method'=>'post', 'files'=> true]) !!}
                             <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    {!! Form::date('fdate', app('request')->input('fdate',\Carbon\Carbon::now()->startOfMonth()),array('class'=>"form-control")) !!}
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    {!! Form::date('tdate', app('request')->input('tdate',\Carbon\Carbon::now()->endOfMonth()),array('class'=>"form-control")); !!}
                                </div>
                                <div class="col-md-3">
                                    <label>Options</label>
                                    <select class="form-control" name="option">                                     
                                            <?php
                                            $option_array = array("Product","Category","Store");
                                            foreach($option_array as $option){
                                            ?>
                                            <option value="<?php echo ($option); ?>"><?php echo $option; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>  
                                </div>
                                <div class="col-md-3">
                                    <label>Options</label>
                                    <select class="form-control" name="option">                                     
                                            <?php
                                            $option_array = array("Product","Category","Store");
                                            foreach($option_array as $option){
                                            ?>
                                            <option value="<?php echo ($option); ?>"><?php echo $option; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>  
                                </div>
                                <div class="col-md-3">
                                <br/>
                                <button type="submit" class="btn btn-success">Generate Report</button>
                                </div>
                            </div>
                            {!!form::close() !!}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body padding15">
                                        <h5 class="md-title mt0 mb10">Category</h5>
                                         <div class="box-body chart-responsive">
                                                <div class="chart" id="report-category" style="height: 300px;"></div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>  
                </div> 
			</div>
		</div>  
    </section> 
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
<script src="{{ asset('assets/js/reports.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/js/AdminLTE/demo.js') }}" type="text/javascript"></script>      
  @stop