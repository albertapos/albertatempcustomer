@extends('main')
@section('content')
<section class="content-header">
	<h1>
	 Reports
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
                    {!! Form::open() !!}
                     <div class="col-md-12">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            {!! Form::date('fdate', app('request')->input('fdate',\Carbon\Carbon::now()->startOfMonth()),array('class'=>"form-control",'id'=>"fdate")) !!}
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            {!! Form::date('tdate', app('request')->input('tdate',\Carbon\Carbon::now()->endOfMonth()),array('class'=>"form-control",'id'=>'tdate')); !!}
                        </div>
                        <div class="col-md-3">
                            <label>Reports</label>
                            <select class="form-control" name="option1" id="option1">                                     
                                    <?php
                                    $option_array = array("Select Option","Sales","Customer","Void");
                                    foreach($option_array as $option1){
                                    ?>
                                    <option value="<?php echo ($option1); ?>"><?php echo $option1; ?></option>
                                    <?php
                                    }
                                    ?>
                            </select><br>  
                        </div>
                        <div class="col-md-3">
                            <label>Stores</label>
                            {!! Form::select('store',['0' => 'Select Store'] + $store_array,null,['class'=>'form-control','id'=>'storeId']) !!}<br>   
                        </div>
                        <div class="col-md-3">
                            <br/>
                            <button type="submit" id="submit" class="btn btn-success">Generate Report</button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row hidden" id="report-chart">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body padding15" id="charts">
                                <h5 class="md-title mt0 mb10">Report Chart</h5>
                                 <div class="box-body chart-responsive">
                                        <div class="chart" id="item-chart" style="height: 500px;"></div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="row hidden" id="alert-message">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" id="charts">
                                 <div class="box-body chart-responsive">
                                        <div class="chart">
                                             <h4 align="center" class="alert alert-warning"><strong>Sorry!!! No Result Found... </strong></h4>
                                        </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
              
                {!!form::close() !!} 
        </div> 
	</div>
</div>  
</section>   
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<!-- Morris.js charts -->
<script src="{{ asset('assets/js/reports.js') }}"></script>

@stop