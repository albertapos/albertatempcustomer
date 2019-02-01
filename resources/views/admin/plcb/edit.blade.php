@extends('main')
@section('content')
<section class="content-header">
	<h1>
	   PLCB Product Edit
	</h1>
	<ol class="breadcrumb">
	</ol>
</section><br>
<div class="col-md-12">
		  @include('layouts.partials.errors')
		  @include('layouts.partials.flash')
		  @include('layouts.partials.success')
</div>
<section class="content">
	<div class="container" style="width:100%;">
        {!! Form::open(['files'=> true, 'method'=>'put','url'=>['admin/plcb-products', $plcb_product->iitemid]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>PLCB Product Edit</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <span><b>Product Name: </b></span><span><input class="form-control" type="text" name="prduct_name" value="{{ $plcb_product->vitemname or '' }}" readonly></span>
                    </div>
                    <div class="col-md-6">
                        <span><b>Unit Value: </b></span><span><input class="form-control" type="text" name="unit_value" id="unit_value" value="{{ $plcb_product->unit_value or '' }}" required></span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <span><b>Unit: </b></span>
                        <span>
                        <select name="unit_id" class="form-control" required>
                            <option value="">---------- Please Select Unit ----------</option>
                            @foreach($units as $unit)
                                @if($unit->id == $plcb_product->unit_id)
                                    <option value="{{$unit->id}}" selected="selected">{{$unit->unit_name}}</option>
                                @else
                                    <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <span><b>Bucket: </b></span>
                        <span>
                            <select name="bucket_id" class="form-control" required>
                                <option value="">---------- Please Select Bucket ----------</option>
                                @foreach($buckets as $bucket)
                                    @if($bucket->id == $plcb_product->bucket_id)
                                        <option value="{{$bucket->id}}" selected="selected">{{$bucket->bucket_name}}</option>
                                    @else
                                        <option value="{{$bucket->id}}">{{$bucket->bucket_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </span>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <span><b>Previous Month Beginning Qty: </b></span><span><input class="form-control" type="text" name="prev_mo_beg_qty" id="prev_mo_beg_qty" value="{{ $plcb_product->prev_mo_beg_qty or '' }}" required></span>
                    </div>
                    <div class="col-md-6">
                        <span><b>Previous Month End Qty: </b></span><span><input class="form-control" type="text" name="prev_mo_end_qty" id="prev_mo_end_qty" value="{{ $plcb_product->prev_mo_end_qty or '' }}"></span>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <span><b>Product Malt: </b></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><input class="form-control" type="checkbox" name="malt" id="malt" value="1" {{$plcb_product->malt==1?'checked':''}}></span>
                    </div>
                    <div class="col-md-6">
                        <p>&nbsp;</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
      </div>
        {!! Form::close() !!}
	</div>  
</section>  
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


@stop