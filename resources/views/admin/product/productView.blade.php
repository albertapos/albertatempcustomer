@extends('main')
@section('content')
<section class="content-header">
    <h1>
       Edit Product
    </h1>
</section><br>
<div class="col-md-12">
          @include('layouts.partials.errors')
          @include('layouts.partials.flash')
          @include('layouts.partials.success')
</div>
    <section class="content">
            <div class="container box box-body "><br>
                 <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Item</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Type :</label>
                                    <div class="col-xs-7 control-label">
                                    {{ $product->vitemtype or '-'}}                            
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Name :</label>
                                    <div class="col-xs-7 control-label">
                                        {{ $product->vitemname}}<br>                                   
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Unit :</label>
                                    <div class="col-xs-7 control-label">
                                        {{ $product->vunitcode or '-'}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Department</label>
                                    <div class="col-xs-7 control-label">
                                            {{ $product->vdepcode or '-'}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Size :</label>
                                    <div class="col-xs-7 control-label">
                                        {{ $product->vsize or '-' }}                                        
                                    </div>
                                </div><br>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Per Case :</label>
                                                <div class="col-xs-6 control-label">
                                                   {{ $product->npack }}
                                                </div>
                                            </div><br>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Case Cost :</label>
                                                <div class="col-xs-6 control-label">
                                                  {{ $product->dcostprice }}<br>
                                                </div>
                                            </div><br>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Cost :</label>
                                                <div class="col-xs-6 control-label">
                                                   {{ $product->nunitcost }}<br>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"><br>
                               <div class="form-group">
                                    <label class="control-label col-xs-4 ">SKU :</label>
                                    <div class="col-xs-7">
                                         {{ $product->vbarcode}}
                                    </div>
                                </div><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Description</label>
                                    <div class="col-xs-7">
                                         {{ $product->vdescription }}
                                    </div>
                                </div><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Supplier</label>
                                    <div class="col-xs-7">
                                        {{ $product->vsuppliercode or '-'}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">category</label>
                                    <div class="col-xs-7">
                                        {{ $product->vcategorycode or '-'}}<br>   
                                    </div>
                                </div><br>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Uint</label>
                                                <div class="col-xs-6">
                                                    {{ $product->nsellunit }} <br>
                                                </div>
                                            </div><br>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Price</label>
                                                <div class="col-xs-6">
                                                    {{ $product->nsaleprice }}<br>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div>
                                    <div class="panel panel-default col-xs-12" style="background-color:#D3D3D3">
                                        <strong>Profit margin: 100.00 %</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Sequence</label>
                                    <div class="col-xs-7">
                                         {{ $product->vsequence }} 
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Color</label>
                                    <div class="col-xs-7">
                                        {{ $product->vcolorcode or '-' }}
                                    </div>
                                </div><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Sales Item</label>
                                    <div class="col-xs-7">
                                        {{$product->vshowsalesinzreport  or '-'}}   
                                    </div>
                                </div><br>
                            </div>
                        </div>
                        <hr style="border-width:4px;border-color:#A9A9A9" >
                        <div class="row">
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Qty On Hand :</label>
                                    <div class="col-xs-6">
                                         {{ $product->iqtyonhand }}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Level 2 Price :</label>
                                    <div class="col-xs-6">
                                         {{ $product->nlevel2 }}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Level 4 Price :</label>
                                    <div class="col-xs-6">
                                         {{ $product->nlevel4 }}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Inventory Item :</label>
                                    <div class="col-xs-6">
                                        {{ $product->visinventory or '-' }}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Age Verification :</label>
                                    <div class="col-xs-6">
                                        {{ $product->vageverify or '-' }}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Bottle Deposit :</label>
                                    <div class="col-xs-6">
                                            {{$product->ebottledeposit  or  '-'}}
                                    </div>
                                </div><br>  
                            </div>
                            <div class="col-md-4"><br>
                               <div class="form-group">
                                    <label class="control-label col-xs-6 ">Re-Order point</label>
                                    <div class="col-xs-5">
                                         {{ $product->ireorderpoint }}
                                    </div>
                                </div><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-6 ">Level 3 Price</label>
                                    <div class="col-xs-5">
                                         {{ $product->nlevel3 }}
                                    </div>
                                </div><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-6 ">Discount(%)</label>
                                    <div class="col-xs-5">
                                         {{ $product->ndiscountper or '-'}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Food Item</label>
                                    <div class="col-xs-5">
                                        {{ $product->vfooditem or '-'}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Taxable</label>
                                    <div class="col-xs-5">
                                       {{ $product->vtax1 }}
                                                
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Barcode Type</label>
                                    <div class="col-xs-5">
                                        {{ $product->vbarcodetype or '-'}}<br>   
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Discount</label>
                                    <div class="col-xs-5">                                  
                                          {{ $product->vdiscount or '-' }}
                                     </div>
                                </div><br>
                                
                            </div>
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-6 ">Order Qty Upto</label>
                                    <div class="col-xs-6">
                                        {{ $product->norderqtyupto}}
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Images</label>
                                </div><br>
                                <div class="form-group">
                                    <div class="col-md-6">
                                    
                                        <img src = "{{ asset($product->itemimage) }}" height="150" width="200"/>
                                    </div>
                                </div> <br>  
                            </div>
                        </div>            
                     </div>
                </div>
            </div>
        </div>
</section>  
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>        
<script>
$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
});
</script>
<script type="text/javascript">
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop