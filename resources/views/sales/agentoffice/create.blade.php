@extends('main')
@section('content')
<section class="content-header">
	<h1>
	  New Agent
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
			    <div class="box">
			        <div class="box-body col-xs-offset-1">
                      {!! Form::open(['url'=>'sales/agentoffice', 'method'=>'Post', 'files'=> true]) !!}
                       <div class="row">
                           <div class="form-group col-xs-5">
                                <label class="control-label">Agent Office Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-4  text-center">
                                <button type="submit" class="btn btn-primary btn-md" id="save">
                                <i class="fa fa-disk-o"></i>
                                    Save
                                </button>
                                <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/sales/agentoffice') }}">Cancel</a><br><br>
                            </div>
                        </div><br><br><br>
                    {!! Form::close() !!}
                </div>
			    </div>
			</div>
		</div>  
    </section> 
  @stop

  