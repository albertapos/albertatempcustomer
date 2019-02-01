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
                {!! Form::open(['files'=> true, 'method'=>'put','url'=>['admin/products', $products->iitemid]]) !!}
                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Type :</label>
                                    <div class="col-xs-7">
                                    <select name="vitemtype" class="form-control">
                                            <option value="Statndard"{{$products->vitemtype=='Statndard'?'selected':''}}>Statndard</option>
                                            <option value="LotMartix"{{$products->vitemtype=='LotMartix'?'selected':''}}>Lot Martix</option>
                                            <option value="Lotterry"{{$products->vitemtype=='Lotterry'?'selected':''}}>Lotterry</option>
                                    </select> <br>                                     
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Name :</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="vitemname" value="{{ $products->vitemname }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Unit :</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vunitcode',$unit_array,$products->vunitcode,['class'=>'form-control']) !!}<br>   

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Department</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vdepcode',$department_array,$products->vdepcode,['class'=>'form-control']) !!}<br>   

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Size :</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vsize',$size_array,$products->vsize,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Per Case</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="npack" value="{{ $products->npack }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Case Cost</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="dcostprice" value="{{ $products->dcostprice }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Cost</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nunitcost" value="{{ $products->nunitcost }}"><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-md-4"><br>
                               <div class="form-group">
                                    <label class="control-label col-xs-4 ">SKU :</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="vbarcode" value="{{ $products->vbarcode}}" readonly><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Description</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="vdescription" value="{{ $products->vdescription }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Supplier</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vsuppliercode',$supplier_array,$products->vsuppliercode,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">category</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vcategorycode',$category_array,$products->vcategorycode,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Group Name</label>
                                    <div class="col-xs-7">
                                  </div>
                                </div>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Uint</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nsellunit" value="{{ $products->nsellunit }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Price</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nsaleprice" value="{{ $products->nsaleprice }}"><br>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Price</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="dunitprice" value="{{ $products->dunitprice }}"><br>
                                                </div>
                                            </div>
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
                                         <input type="text" class="form-control" name="vsequence" value="{{ $products->vsequence }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Color</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vcolorcode',$color_array,$products->vcolorcode,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Sales Item</label>
                                    <div class="col-xs-7">
                                        <select name="salesItem" class="form-control">
                                            <option value="Yes"{{$products->vshowsalesinzreport=='Yes'?'selected':''}}>Yes</option>
                                            <option value="No"{{$products->vshowsalesinzreport=='No'?'selected':''}}>No</option>
                                        </select> <br>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="border-width:4px;border-color:#A9A9A9" >
                        <div class="row">
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Qty On Hand</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="iqtyonhand" value="{{ $products->iqtyonhand }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 2 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel2" value="{{ $products->nlevel2 }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 4 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel4" value="{{ $products->nlevel4 }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Inventory Item</label>
                                    <div class="col-xs-7">
                                        <select name="discount" class="form-control">
                                            <option value="Yes"{{$products->visinventory=='Yes'?'selected':''}}>Yes</option>
                                            <option value="No"{{$products->visinventory=='No'?'selected':''}}>No</option>
                                        </select> <br>  
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Age Verification</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vageverify',$ageVerification_array,$products->vageverify,['class'=>'form-control']) !!}<br>   

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Bottle Deposit</label>
                                    <div class="col-xs-7">
                                         <select name="discount" class="form-control">
                                            <option value="Yes"{{$products->ebottledeposit=='Yes'?'selected':''}}>Yes</option>
                                            <option value="No"{{$products->ebottledeposit=='No'?'selected':''}}>No</option>
                                        </select> 
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4"><br>
                               <div class="form-group">
                                    <label class="control-label col-xs-4 ">Re-Order point</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="ireorderpoint" value="{{ $products->ireorderpoint }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 3 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel3" value="{{ $products->nlevel3 }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Discount(%)</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="ndiscountper" value="{{ $products->ndiscountper }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Food Item</label>
                                    <div class="col-xs-7">
                                        <select name="discount" class="form-control">
                                            <option value="Yes"{{$products->vfooditem=='Yes'?'selected':''}}>Yes</option>
                                            <option value="No"{{$products->vfooditem=='No'?'selected':''}}>No</option>
                                        </select> <br> 

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Taxable</label>
                                    <div class="col-xs-7">
                                        <input type="checkbox" class="form-control" name="vtax1" id="vtax1" value="Y"{{$products->vtax1=='Y'?'checked':''}}>Tax 1<br>
                                        <input type="checkbox" class="form-control" name="vtax2" id="vtax2" value="N"{{$products->vtax2=='N'?'checked':''}}>Tax 2<br><br> 
                                                
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Barcode Type</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vbarcodetype',$barcode_type_array,$products->vbarcodetype,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Discount</label>
                                    <div class="col-xs-7">                                  
                                        <select name="discount" class="form-control">
                                            <option value="Yes"{{$products->vdiscount=='Yes'?'selected':''}}>Yes</option>
                                            <option value="No"{{$products->vdiscount=='No'?'selected':''}}>No</option>
                                        </select>  
                                     </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Order Qty Upto</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="norderqtyupto" value="{{ $products->norderqtyupto}}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Images</label>
                                    <div class="col-md-6">
                                    <br>
                                       {!! Form::file('file',array('multiple'=>'true','onchange'=>"readURL(this)")) !!}<br>
                                        <img src ="data:image/jpeg;base64, {{ base64_encode( $products->itemimage  ) }}"  id="blah"  height="150" width="150"/>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="box-footer">
                           <div class="col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                <i class="fa fa-disk-o"></i>
                                    Save
                                </button>
                                <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/admin/products') }}">Cancel</a><br><br>

                            </div> 
                            <div class="col-md-offset-5">
                            </div>         
                        </div>
                    </div>
                 {!! Form::close() !!}
                </div>
            </div>

      <!--   </div>/.box -->
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