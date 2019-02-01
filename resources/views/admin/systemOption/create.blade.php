@extends('main')
@section('content')
<section class="content-header">
	<h1>
	  System Option
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
                      {!! Form::open(['url'=>'admin/systemOption', 'method'=>'Post', 'files'=> true]) !!}
                       <div class="row"><br>
                            <div class="form-group col-xs-5">
                                <label class=" control-label">Option Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group col-xs-5">
                                <label class=" control-label">Option Value</label>
                                <div class=>
                                    <input type="text" class="form-control" name="value" value="{{ old('value') }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-4 col-md-offset-3 text-center">
                                <button type="submit" class="btn btn-primary btn-md">
                                <i class="fa fa-disk-o"></i>
                                    Save
                                </button>
                                <input class="btn btn-primary btn-md"  style="margin-left: 20px;" type="reset" value="Cancel" ><br><br>
                            </div>
                        </div><br><br><br>
                    {!! Form::close() !!}
                </div>
			    </div>
			</div>
		</div>  
    </section>       
@stop

  