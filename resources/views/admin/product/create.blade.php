@extends('main')
@section('content')
<section class="content-header">
	<h1>
	   Product Create
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
            <div class="container box box-body "><br>
                 <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Item</a></li>
                  </ul>
                 {!! Form::open(['url'=>'admin/products', 'method'=>'Post', 'files'=> true]) !!}
                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4"><br>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Type :</label>
                                    <div class="col-xs-7">
                                         <select class="form-control" name="vitemtype">                                     
                                            <?php
                                            $item_array = array("Statndard","Lot Martix","Lotterry","Kiosk");
                                            foreach($item_array as $itemType){
                                            ?>
                                            <option value="<?php echo ($itemType); ?>"><?php echo $itemType; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Name :</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="vitemname" value="{{ old('vitemname') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Unit :</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vunitcode',['0' => 'Select Unit'] + $unit_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Department</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vdepcode',['0' => 'Select Department'] + $department_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Size :</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vsize',['0' => 'Select Size']+$size_array ,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Per Case</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="npack" value="{{ old('npack') }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Case Cost</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="dcostprice" value="{{ old('dcostprice') }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Unit Cost</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nunitcost" value="{{ old('nunitcost') }}"><br>
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
                                         <input type="text" class="form-control" name="vbarcode" value="{{ old('vbarcode') }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Description</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="vdescription" value="{{ old('vdescription') }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Supplier</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vsuppliercode',['0' => 'Select Supplier'] + $supplier_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">category</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vcategorycode',['0' => 'Select Category'] + $category_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Group Name</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('groupName',['0' => 'Select Group'] + $group_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                   <div class="panel panel-default col-xs-12">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Unit</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nsellunit" value="{{ old('nsellunit') }}"><br>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-6 ">Selling Price</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" name="nsaleprice" value="{{ old('nsaleprice') }}"><br>
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
                                         <input type="text" class="form-control" name="vsequence" value="{{ old('vsequence') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Item Color</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vcolorcode',['0' => 'Select Color'] + $color_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Sales Item</label>
                                    <div class="col-xs-7">
                                        <select class="form-control" name="vshowsalesinzreport">                                     
                                            <?php
                                            $sales_array = array("Yes", "No");
                                            foreach($sales_array as $salesItem){
                                            ?>
                                            <option value="<?php echo ($salesItem); ?>"><?php echo $salesItem; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>                                    
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
                                         <input type="text" class="form-control" name="iqtyonhand" value="{{ old('iqtyonhand') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 2 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel2" value="{{ old('nlevel2') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 4 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel4" value="{{ old('nlevel4') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Inventory Item</label>
                                    <div class="col-xs-7">
                               
                                         <select class="form-control" name="visinventory">                                     
                                            <?php
                                            $inventory_array = array("Yes", "No");
                                            foreach($inventory_array as $inventoryItem){
                                            ?>
                                            <option value="<?php echo strtolower($inventoryItem); ?>"><?php echo $inventoryItem; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Age Verification</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vageverify',['0' => 'Select Age'] + $ageVerification_array,null,['class'=>'form-control']) !!}<br>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Bottle Deposit</label>
                                    <div class="col-xs-7">                                    
                                         <select class="form-control" name="ebottledeposit">                                     
                                            <?php
                                            $bottle_array = array("Yes", "No");
                                            foreach($bottle_array as $bottleDeposit){
                                            ?>
                                            <option value="<?php echo strtolower($bottleDeposit); ?>"><?php echo $bottleDeposit; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4"><br>
                               <div class="form-group">
                                    <label class="control-label col-xs-4 ">Re-Order point</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="ireorderpoint" value="{{ old('ireorderpoint') }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Level 3 Price</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="nlevel3" value="{{ old('nlevel3') }}"><br>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Discount(%)</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="ndiscountper" value="{{ old('ndiscountper') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Food Item</label>
                                    <div class="col-xs-7">                                    
                                         <select class="form-control" name="vfooditem">                                     
                                            <?php
                                            $food_array = array("Y", "N");
                                            foreach($food_array as $foodItem){
                                            ?>
                                            <option value="<?php echo strtolower($foodItem); ?>"><?php echo $foodItem; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   <br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Taxable</label>
                                    <div class="col-xs-7">
                                        <input type="checkbox" class="form-control" name="vtax1" id="vtax1" value="Y">Tax 1<br>
                                        <input type="checkbox" class="form-control" name="vtax2" id="vtax2" value="N">Tax 2 <br><br>                                 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Barcode Type</label>
                                    <div class="col-xs-7">
                                        {!! Form::select('vbarcodetype',['0' => 'Select Food'] + $barcode_type_array,null,['class'=>'form-control']) !!}<br>   

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4 ">Discount</label>
                                    <div class="col-xs-7">
<!--                                                 {!! Form::select('discount',['0' => 'Select Discount'] + $discount_array,null,['class'=>'form-control']) !!}<br>   -->                                                  
                                         <select class="form-control" name="vdiscount">
                                           
                                            <?php
                                            $discount_array = array("Yes", "No");
                                            foreach($discount_array as $discount){
                                            ?>
                                            <option value="<?php echo ($discount); ?>"><?php echo $discount; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   
                                     </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4"><br>
                                 <div class="form-group">
                                    <label class="control-label col-xs-4 ">Order Qty Upto</label>
                                    <div class="col-xs-7">
                                         <input type="text" class="form-control" name="norderqtyupto" value="{{ old('norderqtyupto') }}"><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Image</label>
                                    <div class="col-md-6">
                                       {!! Form::file('file[]',array('multiple'=>'true','onchange'=>"readURL(this)")) !!}<br>

                                        <img id="blah" src="#" alt="your image" height="150" width="250" />
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
                                <a class="btn  btn-close btn btn-primary" style="margin-left: 20px;" href="{{ url('/admin/products') }}">Cancel</a>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="form-control col-md-offset-3" name="checkStore" id="checkStore" checked = "checked" value="Y">Multiple Store<br>

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