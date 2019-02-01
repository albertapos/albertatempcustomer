@extends('main')
@section('content')
<div class="col-md-12">
 
</div>
<section class="content-header">
	
	<ol class="breadcrumb">
	    <li><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	</ol>
</section><br>
<div class="col-md-12">
	  @include('layouts.partials.errors')
	  @include('layouts.partials.flash')
	  @include('layouts.partials.success')
</div>

<section class="content">	
    <div class="col-md-12">
        <div class="container-fluid">
            <div class="panel panel-default">
            <div class="panel-heading" >
                <h3 class="panel-title" id="group"> 
                  Products
                 </h3>
                <div class="pull-right" id="mydiv">
                        <a href="/admin/products/create" class="btn btn-success btn-md" style="margin-top: -27px;">
                        <i class="fa fa-plus-circle"></i> New Product
                        </a>
                </div>
                <div class="clearfix" ><span ></div></span>
            </div>
            <div class="panel-body" >
                <div class="table-responsive">
                    {!!Form::open(array('method' => 'get')) !!}
                        <div class="col-md-3" style="margin-left: -15px;">
                            <label>Department</label>
                            {!! Form::select('vdepcode',$department_array,Request::get('vdepcode'),['class'=>'form-control']) !!}<br>   
                        </div>
                        <div class="col-md-3">
                            <label>Category</label>
                            {!! Form::select('vcategorycode',$category_array,Request::get('vcategorycode'),['class'=>'form-control']) !!}<br>   
                        </div>
                        <div class="col-sm-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="vitemname" value="{{ Request::get('vitemname') }}"><br>

                        </div>
                        <div class="col-sm-2">
                            <label>SKU</label>
                            <input type="text" class="form-control" name="vbarcode" value="{{ Request::get('vbarcode') }}"><br>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" id="submit" class="btn btn-success" style="margin-top: 23px;">Search</button>
                        </div>
                    {!!form::close() !!}
                    <table class="table table-striped table-bordered" id="example1">
                    <thead>
                      <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Item Type</th>
                          <!--   <th>Unit Code</th> -->
                            <th>Dept Code </th>
                           <!--  <th>Size</th>
                            <th>Unit Cost</th> -->
                            <th>SKU</th>
                          <!--   <th>Decription</th> 
                            <th>Supplier Code</th>-->
                            <th>Category Code</th>
                            <!-- <th>Sell Unit</th>-->
                            <th>Price</th>
                           <!-- <th>Sequence</th>
                            <th>Color Code</th> -->
                            <th>qtyOnHand</th>
                           <!--  <th>Level2 Price</th>
                            <th>Level4 Price</th>
                            <th>Inventory Item</th>
                            <th>Age Varification</th>
                            <th>Bottle Deposit</th>
                            <th>Reorder Point</th>
                            <th>Level3 Price</th>
                            <th>Discount(%)</th>
                            <th>Tax1</th>
                            <th>Tax2</th>
                            <th>BarCode Type</th>
                            <th>Discount</th>
                            <th>OrderQtyUpTo</th> -->
                            <th colspan="2">&nbsp;&nbsp;&nbsp;Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                      <tr>
                          <td>{{ $product->iitemid }}</td>
                          <td><a href="{{ url('admin/products/view',$product->iitemid) }}">{{ $product->vitemname }}</a></td>
                            <td>{{ $product->vitemtype }}</td>
                          <!--   <td>{{ $product->vunitcode }}</td> -->
                            <td>{{ $product->vdepcode }}</td>
                           <!--  <td>{{ $product->vsize}}</td>
                            <td>{{ $product->nunitcost }}</td> -->
                            <td>{{ $product->vbarcode }}</td>
                            <!-- <td>{{ $product->vdescription }}</td>
                            <td>{{ $product->vsuppliercode }}</td> -->
                            <td>{{ $product->vcategorycode }}</td>
                           <!--  <td>{{ $product->groupName }}</td> -->
                           <!--  <td>{{ $product->nsellunit }}</td>-->
                            <td contenteditable="true" onBlur="saveToDatabase(this,'nsaleprice','{{ $product->iitemid }}')" onClick="showEdit(this);">{{ $product->dunitprice }}</td>
                            <!-- <td>{{ $product->vsequence }}</td>
                            <td>{{ $product->vcolorcode }}</td> -->
                            <!-- <td>{{ $product->salesItem }}</td> -->
                            <td>{{ $product->iqtyonhand }}</td>
                           <!--  <td>{{ $product->nlevel2 }}</td>
                            <td>{{ $product->nlevel4 }}</td>
                            <td>{{ $product->visinventory}}</td>
                            <td>{{ $product->vageverify}}</td>
                            <td>{{ $product->ebottledeposit }}</td>
                            <td>{{ $product->ireorderpoint }}</td>
                            <td>{{ $product->nlevel3 }}</td>
                            <td>{{ $product->ndiscountper }}</td> -->
                           <!--  <td>{{ $product->VFOODITEM }}</td> -->
                           <!--  <td>{{ $product->vtax1 }}</td>
                            <td>{{ $product->vtax2 }}</td>
                            <td>{{ $product->vbarcodetype }}</td>
                            <td>{{ $product->vdiscount }}</td>
                            <td>{{ $product->norderqtyupto }}</td> -->
                            @if(Auth::check()) 
                                 @foreach (Auth::user()->roles()->get() as $role)
                                     @if ($role->name == 'Admin')
                                        <td>
                                            &nbsp;<a href="/admin/products/{{ $product->iitemid }}/edit"
                                            class="btn btn-xs btn-info">
                                                <i class="fa fa-pencil"></i> 
                                            </a>
                                        </td>
                                        <!-- <td>
                                        <form class="form-group delete" action="{{ url('admin/products', $product->iitemid) }}" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                        </td> -->
                                    @endif
                                    @if ($role->name == 'Vendor')
                                        <td>
                                            &nbsp;&nbsp;&nbsp;<a href="/admin/products/{{ $product->iitemid }}/edit"
                                            class="btn btn-xs btn-info">
                                                <i class="fa fa-pencil"></i> 
                                            </a>
                                        </td>
                                    @endif
                                @endforeach
                            @endif
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="pull-left" style="margin-top: 30px;"> Showing {{($products->currentPage() * $products->perPage()) - $products->perPage() + 1}} to {{($products->lastPage() == $products->currentPage() ? $products->total() : $products->currentPage() * $products->perPage())}} of {{$products->total()}} products</div>
                <div class="dataTables_paginate pull-right">
                    {{$products->links()}}
                </div>
                <div style="clear:both"></div>
            </div>
            </div>
        </div>
    </div>
</section>	
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 

<script type="text/javascript">
    $(".delete").on("submit", function(){
        return confirm("Do you want to delete this Product?");
    });
    </script>

<script type="text/javascript">
   $("#mydiv").addClass("disabledbutton");
</script>
<style type="text/css">
    .disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
</style>
<script>
function showEdit(editableObj) {
        $(editableObj).css("background","#FFF");
} 
function saveToDatabase(editableObj,column,id) {
    $(editableObj).css("background","#FFF url({{ asset('assets/img/loaderIcon.gif') }}) no-repeat right");
    $.ajax({
        url: 'products/price/'+id,
        type: "POST",
        data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(response){
               $(editableObj).css("background","#edede8");
               bootbox.alert({
                        message: "Price is updated successfully...",
                        size: 'small'
                    });
                }      
   });
}
</script>
@stop
  