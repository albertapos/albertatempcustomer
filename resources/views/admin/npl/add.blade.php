@extends('main')
@section('content')


<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 9999;
    background-image : url('/assets/img/loading1.gif');
    background-color:#666;
    opacity : 0.9;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
    background-size: 250px;
  }

  #loadinggif.show{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 101;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
  }

  div.content {
   width : 1000px;
   height : 1000px;
  }
  body.fixed .wrapper{
      margin-top:0px;
  }
.panel-default>.panel-heading{
        background-color:#fff !important;
        border-top: 2px solid #c1c1c1;
    }
.panel-title{
        font-size:20px !important;
    }
.control-label{
    font-size:12px;
}
</style>
<div class="wrapper row-offcanvas row-offcanvas-left">


<link href="{{ asset('/assets/js/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
<div class="col-md-12">
      @include('layouts.partials.errors')
      @include('layouts.partials.flash')
      @include('layouts.partials.success')
</div>

<section class="content-header">

<div id="content">
  <div class="page-header">

  </div>
  <div class="container-fluid">
 
  

    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title" >Add Items</h3>
        
      </div>
      <div class="panel-body">

        <!--<div class="row" style="padding-bottom: 9px;float: right;">-->
        <!--  <div class="col-md-12">-->
        <!--    <div class="">-->
        <!--      <button class="btn btn-info save_btn_rotate" onclick="" form="form-item">Save</button>-->

                <!--<a href="" data-toggle="tooltip" title="Clone Item" class="btn btn-info add_new_btn_rotate"><i class="fa fa-clone"></i>&nbsp;&nbsp;Clone</a>-->
           
        <!--      <a id="cancel_button" href="{{ url('/admin/npl-list') }}" data-toggle="tooltip" title="" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <div class="clearfix"></div>

        <!--<ul class="nav nav-tabs responsive" id="myTab">-->
        <!--  <li class="active"><a href="#item_tab" data-toggle="tab">Item</a></li>-->
        <!--  <li><a href="#alias_code_tab" data-toggle="tab">Add Alias Code</a></li>-->
        <!--  <li><a href="#parent_tab" data-toggle="tab">Parent / Child</a></li>-->
        <!--  <li><a  href="#lot_matrix_tab" data-toggle="tab">Lot Matrix</a></li>-->
        <!--  <li><a href="#vendor_tab" data-toggle="tab">Vendor</a></li>-->
        <!--  <li><a href="#slab_price_tab" data-toggle="tab">Slab Price</a></li>-->
        <!--</ul>-->

        <div class="tab-content responsive">
          <div class="tab-pane active" id="item_tab">
          <form action="{{url('admin/npl-list-store/')}}" method="post" enctype="multipart/form-data" id="form-item" class="form-horizontal">
     
            <!--<input type="hidden" name="iitemid" value="">-->
   
       
            <!--<input type="hidden" name="isparentchild" value="">-->
        
            <!--<input type="hidden" name="parentid" value="">-->
     
            <!--<input type="hidden" name="parentmasterid" value="">-->

          <div class="panel panel-default" style="border-top:none;margin-bottom:0px;">
            <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>Product</b></h4></div>
          </div>
          <div style="background:#fff;padding-top:1%;padding-right:1%;">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-customer"> Item Type</label>
                  <div class="col-sm-8">
                     
                     <input type="text" name="itemtype" maxlength="50" value="" placeholder="Item Type" id="" class="form-control" >
                
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-state">Item Name</label>
                  <div class="col-sm-8">
                      <input type="text" name="itemname" maxlength="50" value="" placeholder="Item Name" id="" class="form-control" >
                  
                  
                      <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Description</label>
                  <div class="col-sm-8">
    
                  
                      <input type="text" name="description" maxlength="50" value="" placeholder="Description" id="" class="form-control" >
                     
           
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Barcode</label>
                  <div class="col-sm-8">
                    <input type="text" name="barcode" maxlength="50" value="" placeholder="Barcode" id="" class="form-control" >
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group ">
                  <label class="col-sm-4 control-label" for="input-zip">Unit</label>
                  <div class="col-sm-8">
                       <input type="text" name="unit" maxlength="50" value="" placeholder="Unit" id="" class="form-control" onkeypress="return isNumberKey(event)" >
                  
                 
                      <div class="text-danger"></div>
                  
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Department</label>
                  <div class="col-sm-8">
                    <input type="text" name="dept" maxlength="50" value="" placeholder="Department" id="" class="form-control" >
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Category</label>
                  <div class="col-sm-8">
                    <input type="text" name="category" maxlength="50" value="" placeholder="Category" id="" class="form-control" >
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
            
              <div class="col-md-4 ">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Supplier</label>
                  <div class="col-sm-8">
                    <input type="text" name="supplier" maxlength="50" value="" placeholder="supplier" id="" class="form-control" >
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Group</label>
                  <div class="col-sm-8">
                   
                    <input type="text" name="group" maxlength="50" value="" placeholder="Group" id="" class="form-control" >
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-last-name">Size</label>
                  <div class="col-sm-8">
       
                    <input type="text" name="size" maxlength="50" value="" placeholder="Size" id="" class="form-control" >
                  
                      <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Cost</label>
                  <div class="col-sm-8">
                  
                    <input type="text" name="cost" maxlength="50" value="" placeholder="Cost" id="" class="form-control" onkeypress="return isNumberKey(event)" >
                   
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Selling Price</label>
                  <div class="col-sm-8">
                 
                    <input type="text" name="sellingprice" maxlength="50" value="" placeholder="Selling Price" id="" class="form-control" onkeypress="return isNumberKey(event)" >
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-address">Qty On Hand</label>
                  <div class="col-sm-8">
                
                    <input type="text" name="qtyonhand" maxlength="50" value="" placeholder="Qty On Hand" id="" class="form-control" onkeypress="return isNumberKey(event)" >
                    <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Selling Unit</label>
                  <div class="col-sm-8">
                 
                    <input type="text" name="sellingunit" maxlength="50" value="" placeholder="Selling Unit" id="" class="form-control" onkeypress="return isNumberKey(event)" >
                
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Food Stamp</label>
                  <div class="col-sm-8" style="margin-top:7px;">
                        
                    <input type="radio" name="foodstamp"  id="" class="form-control" value="Y">
                    <label>Yes</label>
                    <input type="radio" name="foodstamp"  id="" class="form-control" value="N">
                    <label>No</label>
                   
                  </div>
                </div>
              </div>
             </div>
              <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-address">WIC Item</label>
                  <div class="col-sm-8" style="margin-top:5px;">
                  
                    <!--<input type="text" name="wicitem" maxlength="50" value="" placeholder="WIC Item" id="" class="form-control" >-->
                    <input type="radio" name="wicitem"  id="" class="form-control" value="Y">
                    <label>Yes</label>
                    <input type="radio" name="wicitem"  id="" class="form-control" value="N">
                    <label>No</label>
              
           
                  </div>
                </div>
              </div>
         
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-address">Age Verification</label>
                  <div class="col-sm-8">
                    
                    <input type="text" name="ageverification" maxlength="50" value="" placeholder="Age Verification" id="" class="form-control" >
                    <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Taxable
                  </label>
                  <div class="col-md-8">
                    <span style="display:inline-block;margin-top: 8px;">
                    <input style="display:inline-block;" type="checkbox" name="vtax1" value="Y" class="form-control" />
                    <span style="display:inline-block;">&nbsp;&nbsp;Tax 1</span></span>&nbsp;&nbsp;&nbsp;
                    <span style="display:inline-block;margin-top: 8px;">
                    <input style="display:inline-block;" type="checkbox" name="vtax2" value="Y" class="form-control"  />
                    <span style="display:inline-block;">&nbsp;&nbsp;Tax 2</span></span>
                  </div>
                </div>
              </div>
              
              
              
              
            </div>
          </div>
          
          <!--<div class="panel panel-default" style="border-top:none;margin-bottom:0px;margin-top:1%;">-->
          <!--  <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>Price</b></h4></div>-->
          <!--</div>-->
          <!--<div style="background:#fff;padding-top:1%;padding-right:1%;">-->
          <!--  <div class="row">-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Unit Per Case</label>-->
                
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="npack" value="1" placeholder="" id="input-unitpercase" class="form-control" />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Selling Unit</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="dcostprice" value="1" placeholder="" id="input-avg_case_cost" class="form-control" ? />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Level 2 Price</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="nunitcost" value="" placeholder="Level 2 Price" id="input-unitcost" class="form-control" readonly/>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
             
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Avg. Case Cost</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="nsellunit" value="" placeholder="Avg. Case Cost" id="input-sellingunit" class="form-control"  />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Selling Price</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <span style="display: inline-block;width: 80%;"><input type="text" name="dunitprice" value="" placeholder="Selling Price" id="input-Selling-Price" class="form-control"/></span>&nbsp;-->
          <!--          <span style="display: inline-block;width: 10%" id="selling_price_calculation_btn"><button class="btn btn-sm btn-info">..</button></span>-->
                    
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Level 3 Price</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="ndiscountper" value="" placeholder="Level 3 Price" id="" class="form-control"/>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Unit Cost</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="nlevel2" value="" placeholder="Unit Cost" id="" class="form-control" />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Buydown</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="nlevel3" value="" placeholder="Buydown" id="" class="form-control" />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Level 4 Price</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="nlevel4" value="" placeholder="Level 4 Pric" id="" class="form-control"/>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--  </div>-->
            <!-- ============================================================== Include Last Cost =======================================================-->
          <!--  <div class="row">-->
          <!--    <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Last Cost</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="last_costprice" value="" placeholder="Last Cost" id="input-lastcost" class="form-control" readonly/>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Profit Margin(%)</label>-->
                
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="profit_margin" value="0.00" placeholder="" id="input-profit-margin" class="form-control" readonly />-->
          <!--        </div>-->
                  
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4"></div>-->
          <!--  </div>-->
            
            <!-- =================================== Include New Cost Price===============================================-->
          <!--  <div class="row">-->
          <!--    <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
                      

                      
          <!--        <label class="col-sm-4 control-label" for="input-phone">New Cost</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="new_costprice" value="" placeholder="" id="input-new-cost" class="form-control" readonly/>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
              
          <!--  </div>-->
            
          <!--</div>-->

          <!--  <div class="row" style="display:none;">-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone"></label>-->
          <!--        <div class="col-sm-8">-->
          <!--          <input type="text" name="vsequence" value="" placeholder="" id="" class="form-control" />-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone"></label>-->
          <!--        <div class="col-sm-8">-->
          <!--          <select name="vcolorcode" class="form-control">-->
                     
          <!--                  <option value="" selected="selected"></option>-->
                         
          <!--                  <option value=""></option>-->
                       
          <!--          </select>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--  </div>-->
          
          <!-- <div class="panel panel-default" style="border-top:none;margin-bottom:0px;margin-top:1%;">-->
          <!--  <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>General</b></h4></div>-->
          <!--</div>-->
          <!-- <div style="background:#fff;padding-top:1%;padding-right:1%;"> -->
          <!--  <div class="row">-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Food Item</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <select name="vfooditem" class="form-control">-->
                
          <!--                    <option value="" selected="selected">NO</option>-->
                      
          <!--                    <option value="">YES</option>-->
                           
          <!--            </select>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-country">Liability</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <select name="wicitem" class="form-control">-->
                   
          <!--                  <option value="" selected="selected">YES</option>-->
               
          <!--                  <option value="">NO</option>-->
                   
          <!--          </select>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Station</label>-->
          <!--        <div class="col-md-8">-->
        
                    
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-country">WCI Item</label>-->
          <!--        <div class="col-md-8">-->

          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Re-Order Point</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="ireorderpoint" value="" placeholder="Re-Order Point" id="" class="form-control"  />-->
          <!--          <span class="text-small"><b>Enter Reorder Point in Unit.</b></span>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Order Qty Upto</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input type="text" name="norderqtyupto" value="" placeholder="Order Qty Upto" id="" class="form-control" />-->
          <!--          <span class="text-small"><b>Enter Order Qty Upto in Case.</b></span>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="col-md-4">-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Inventory Item </label>-->
          <!--        <div class="col-md-8">-->
                   

          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-phone">Age Verification</label>-->
          <!--        <div class="col-md-8">-->

          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="form-group" style="border-top:none;">-->
          <!--        <label class="col-sm-4 control-label" for="input-country">Bottle Deposit</label>-->
          <!--        <div class="col-md-8">-->
          <!--          <input name="nbottledepositamt" value="0.00" type="text" class="form-control">-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
          <!--  </div>-->

          <!--  <div class="row">-->
          <!--      <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--          <label class="col-sm-4 control-label" for="input-phone">Barcode Type</label>-->
          <!--          <div class="col-md-8">-->
          <!--            <select name="vbarcodetype" class="form-control">-->
                    
          <!--                  <option value="" selected="selected"></option>-->
                       
          <!--                  <option value=""></option>-->
                         
          <!--            </select>-->
          <!--          </div>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--          <label class="col-sm-4 control-label" for="input-phone">Vintage</label>-->
          <!--          <div class="col-md-8">-->
          <!--            <input type="text" name="vintage" maxlength="45" value="" placeholder="Vintage" id="" class="form-control"  />-->
          <!--          </div>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--          <label class="col-sm-4 control-label" for="input-phone">Rating</label>-->
          <!--          <div class="col-md-8">-->
          <!--            <input type="text" name="rating" maxlength="45" value="" placeholder="Rating" id="" class="form-control" />-->
          <!--          </div>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--  </div>-->
              
          <!--  <div class="row">-->
          <!--      <div class="col-md-4">-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--          <label class="col-sm-4 control-label" for="input-country">Discount</label>-->
          <!--          <div class="col-md-8">-->

          <!--          </div>-->
          <!--        </div>-->
          <!--        <div class="form-group" style="border-top:none;">-->
          <!--          <label class="col-sm-4 control-label" for="input-country">Status</label>-->

          <!--          </div>-->

         
          
          </form>
          <br>
          <div class="row" style="padding-bottom:10px;">
            <div class="col-md-12 text-center">
              <input type="submit" form="form-item" title="" class="btn btn-primary save_btn_rotate" value="Save">
              <a id="cancel_button" href="{{ url('/admin/npl-list') }}" data-toggle="tooltip" title="" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
         
                <button type="button" class="btn btn-danger" id="delete_btn" style="border-radius: 0px;float: right;"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Delete Item</button>
             
            </div>
          </div>
          </div>
      
        </div>

      </div>
    </div>
  </div>
  
</div>
<style type="text/css">

 .nav.nav-tabs .active a{
    background-color: #f05a28 !important; 
    color: #fff !important; 
  }

  .nav.nav-tabs li a{
    color: #fff !important; 
    background-color: #03A9F4; 
  }

  .nav.nav-tabs li a:hover{
    color: #fff !important; 
    background-color: #f05a28 !important; 
  }

  .nav.nav-tabs li a:hover{
    color: #fff !important; 
  }

  .add_new_administrations{
    float: right;
    margin-right: -35px;
    margin-top: -30px;
    cursor: pointer !important; 
    position: relative;
    z-index: 10;
  }
  .add_new_administrations i{
    cursor: pointer !important; 
  }
</style>

<script type="text/javascript">
  function showImages(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#showImage')
                .attr('src', e.target.result)
                .width(100)
                .height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
  }
  
  function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (((charCode != 46) && (charCode > 31)) && ((charCode < 48) || (charCode > 57)))
                return false;
            return true;
        };
</script>


    <style type="text/css">
      #myTab > li:nth-child(2), #myTab > li:nth-child(3),#myTab > li:nth-child(4),#myTab > li:nth-child(5),#myTab > li:nth-child(6){
        pointer-events: none;
      }
    </style>


<script type="text/javascript">
  $(document).on('change', 'select[name="vitemtype"]', function(event) {
    event.preventDefault();
    if($(this).val() == 'Lot Matrix'){
      $('#input-sellingunit').attr('readonly', 'readonly');
    }else{
      $('#input-sellingunit').removeAttr('readonly');
    }
  });

  $(document).on('keyup', '#input-unitpercase', function(event) {
    event.preventDefault();

    var unitpercase = $(this).val();

    if($('select[name="vitemtype"]').val() == 'Lot Matrix'){
      if(unitpercase == ''){
        $('#input-sellingunit').val('');
        unitpercase = 1;
      }else{
        $('#input-sellingunit').val($(this).val());
      }
    }

    var avg_case_cost = $('#input-avg_case_cost').val();

    if(avg_case_cost == ''){
      avg_case_cost = 0;
    }

    var unitcost = '0.0000';
    if(unitpercase != ''){
      var unitcost = avg_case_cost / unitpercase;
      unitcost = unitcost.toFixed(4);
    }

    $('#input-unitcost').val(unitcost);
    //input-profit-margin

    if(unitpercase!= '' && avg_case_cost != '' && $('#input-Selling Price').val() !=''){
      var sell_price = $('#input-Selling-Price').val();
      var buyDown = $('#input-Buydown').val();
      var per = sell_price - ($('#input-unitcost').val()-buyDown);

      if(sell_price == 0 || sell_price == ''){
        sell_price = 1;
      }

      if(per > 0){
        per = per;
      }else{
        per = 0;
      }

      var pro_margin = ((per/sell_price) * 100).toFixed(2);
      $('#input-profit-margin').val(pro_margin);
    }

  });

  $(document).on('keyup', '#input-avg_case_cost', function(event) {
    event.preventDefault();
    
    var avg_case_cost = $(this).val();

    if(avg_case_cost == ''){
      avg_case_cost = 0;
    }

    var unitpercase = $('#input-unitpercase').val();

    if(unitpercase == ''){
      unitpercase = 0;
    }

    var unitcost = '0.0000';
    if(avg_case_cost != ''){
      var unitcost = avg_case_cost / unitpercase  ;
      unitcost = unitcost.toFixed(4);
    }

    $('#input-unitcost').val(unitcost);

    if(unitpercase!= '' && avg_case_cost != '' && $('#input-Selling Price').val() !=''){
      var sell_price = $('#input-Selling-Price').val();
      var buyDown = $('#input-Buydown').val();
      var per = sell_price - ($('#input-unitcost').val()-buyDown);

      if(sell_price == 0 || sell_price == ''){
        sell_price = 1;
      }

      if(per > 0){
        per = per;
      }else{
        per = 0;
      }

      var pro_margin = ((per/sell_price) * 100).toFixed(2);
      $('#input-profit-margin').val(pro_margin);
    }

  });

  $(document).on('keyup', '#input-Selling-Price', function(event) {
    event.preventDefault();

    var input_Selling_Price = $(this).val();
    var unitpercase = $('#input-unitpercase').val();
    var avg_case_cost = $('#input-avg_case_cost').val();

    if(input_Selling_Price == ''){
      input_Selling_Price = 0;
      $('#input-profit-margin').val('0.00');
      return false;
    }

    if(unitpercase!= '' && avg_case_cost != '' && input_Selling_Price !=''){
      var sell_price = $('#input-Selling-Price').val();
      var buyDown = $('#input-Buydown').val();
      
      console.log("Selling: "+buyDown);

      if(buyDown != ''){
          var per = sell_price - ($('#input-unitcost').val()-buyDown);
      } else {
          var per = sell_price - $('#input-unitcost').val();
      }
      
      
      

      if(sell_price == 0 || sell_price == ''){
        sell_price = 1;
      }

      if(per > 0){
        per = per;
      }else{
        per = 0;
      }

      var pro_margin = ((per/sell_price) * 100).toFixed(2);
      $('#input-profit-margin').val(pro_margin);
    }

  });
  
  
  
  
    //buy down
  
  $(document).on('keyup', '#input-Buydown', function(event) {
    event.preventDefault();

    var input_Selling_Price = $('#input-Selling-Price').val();
    var unitpercase = $('#input-unitpercase').val();
    var avg_case_cost = $('#input-avg_case_cost').val();

    if(input_Selling_Price == ''){
      input_Selling_Price = 0;
      $('#input-profit-margin').val('0.00');
      return false;
    }

    if(unitpercase!= '' && avg_case_cost != '' && input_Selling_Price !=''){
      var sell_price = $('#input-Selling-Price').val();
      var buyDown = $('#input-Buydown').val();
      console.log("Buy Down: "+buyDown);
      var per = sell_price - ($('#input-unitcost').val()-buyDown);

      if(sell_price == 0 || sell_price == ''){
        sell_price = 1;
      }

      if(per > 0){
        per = per;
      }else{
        per = 0;
      }

      var pro_margin = ((per/sell_price) * 100).toFixed(2);
      $('#input-profit-margin').val(pro_margin);
    }
    
    
    
    //buy down



  });
  
  
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#form-item-alias-code', function(event) {
    event.preventDefault();
    
 
    var url = $(this).attr('action')+"&sid="+sid;
    var data = {};

    data['vitemcode']  = $(this).find('input[name=vitemcode]').val();
    data['vsku']  = $(this).find('input[name=vsku]').val();
    data['valiassku']  = $(this).find('input[name=valiassku]').val();

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {
      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'alias_code_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      var error_show = '';
      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>

<!-- Modal -->
  <div class="modal fade" id="successAliasModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p id="success_alias"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="errorAliasModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger text-center">
            <p id="error_alias"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  
<script type="text/javascript">
  $(document).on('submit', 'form#form-item-alias-list', function(event) {
    event.preventDefault();
   
    var url = $(this).attr('action')+"&sid="+sid;
    var data = {};

    if($("input[name='selected_alias[]']:checked").length == 0){
      $('#error_alias').html('<strong>Select Aliassku to delete</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }

    $("input[name='selected_alias[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {

      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'alias_code_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>

<!-- Modal -->
<div id="addLotItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="" method="post" id="add_lot_matrix">
  
        <input type="hidden" name="iitemid" value="">
   
        <input type="hidden" name="vbarcode" value="">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Item Pack</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Pack Name:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" name="vpackname" maxlength="30" required>
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Description:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" name="vdesc" maxlength="50" >
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Pack Qty:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" name="ipack" id="ipack" required>
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Cost Price:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" id="npackcost" name="npackcost" required value="" readonly>
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Price:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" id="npackprice" name="npackprice">
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Sequence:&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" name="isequence">
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3 text-center">
              <span><b>Profit Margin(%):&nbsp;&nbsp;&nbsp;</b></span>
            </div>
            <div class="col-md-5">
              <input class="form-control" type="text" id="npackmargin" name="npackmargin" readonly>
            </div>
            <div class="col-md-3"></div>
          </div>
          <br>
          
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-success" value="Add">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  $(document).on('keyup', '#ipack', function(event) {
    event.preventDefault();


    var ipack = $('#ipack').val();
    if(ipack == ''){
      var ipack = 0;
      $('#npackcost').val(unitcost);
      return false;
    }
    
    var npackcost = 0;

    if(ipack != '' && unitcost != ''){
      npackcost = unitcost * ipack;
    }

    $('#npackcost').val(npackcost.toFixed(2));

    if($('#npackprice').val() != ''){

      var npackcost = $('#npackcost').val();
      var npackprice = $('#npackprice').val();
      
      var percent = npackprice - npackcost;

      if(npackprice == '' || npackprice == 0 ){
        npackprice = 1;
      }

      if(percent > 0){
        percent = percent;
      }else{
        percent = 0;
      }
        
      // percent = (percent/(npackprice*100)).toFixed(2);
      percent = ((percent/npackprice)*100).toFixed(2);

      $('#npackmargin').val(percent);
    }

  });

  $(document).on('keyup', '#npackprice', function(event) {
    event.preventDefault();
    var npackprice = $('#npackprice').val();

    if(npackprice != ''){
      if(npackprice == ''){
        var npackprice = 0;
      }

      var npackcost = $('#npackcost').val();

      if(npackcost == ''){
     
      }

    var percent = npackprice - npackcost;

    if(npackprice == '' || npackprice == 0 ){
      npackprice = 1;
    }

    if(percent > 0){
      percent = percent;
    }else{
      percent = 0;
    }

    percent = ((percent/npackprice)*100).toFixed(2);
    // percent = (percent/(npackprice*100)).toFixed(2);
    
    $('#npackmargin').val(percent);
  }else{
    $('#npackmargin').val('');
  }
  
  });


$(document).on('keyup', '.input_npackprice', function(event) {
    event.preventDefault();
    $(this).closest('tr').find('.selected_lot_matrix_checkbox').attr('checked', 'checked');

    var input_npackprice = $(this).val();

    var input_npackcost = $(this).closest('tr').find('.input_npackcost').val();

    var input_npackmargins = input_npackprice - input_npackcost;

    if(input_npackprice == '' || input_npackprice == 0 ){
      input_npackprice = 1;
    }

    input_npackmargins = ((input_npackmargins/input_npackprice) * 100);

    input_npackmargins = input_npackmargins.toFixed(2);

    $(this).closest('tr').find('.input_npackmargins').val(input_npackmargins);
    $(this).closest('tr').find('.npackmargins').html(input_npackmargins);

});

</script>


<script type="text/javascript">
  $(document).on('submit', 'form#add_lot_matrix', function(event) {
    event.preventDefault();
  
    var data = {};

    data['iitemid'] = $('form#add_lot_matrix').find('input[name="iitemid"]').val();
    data['vbarcode'] = $('form#add_lot_matrix').find('input[name="vbarcode"]').val();
    data['vpackname'] = $('form#add_lot_matrix').find('input[name="vpackname"]').val();
    data['vdesc'] = $('form#add_lot_matrix').find('input[name="vdesc"]').val();
    data['ipack'] = $('form#add_lot_matrix').find('input[name="ipack"]').val();
    data['npackcost'] = $('form#add_lot_matrix').find('input[name="npackcost"]').val();
    data['npackprice'] = $('form#add_lot_matrix').find('input[name="npackprice"]').val();
    data['isequence'] = $('form#add_lot_matrix').find('input[name="isequence"]').val();
    data['npackmargin'] = $('form#add_lot_matrix').find('input[name="npackmargin"]').val();
    
    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {
      
      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#addLotItemModal').modal('hide');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'lot_matrix_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';
      
      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#delete_lot_items', function(event) {
    event.preventDefault();
 
    var data = {};

    if($("input[name='selected_lot_matrix[]']:checked").length == 0){
      $('#error_alias').html('<strong>Select Lot Items to delete</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }

    $("input[name='selected_lot_matrix[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {

      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'lot_matrix_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>


<script type="text/javascript">
  $(document).on('submit', 'form#form-item-add-slab-price', function(event) {
    event.preventDefault();
 
    var data = {};

    var slab_price_vsku = $(this).find('input[name="vsku"]').val();
    var slab_price_iitemgroupid = $(this).find('input[name="iitemgroupid"]').val();
    var slab_price_iqty = $(this).find('input[name="iqty"]').val();
    var slab_price_nprice = $(this).find('input[name="nprice"]').val();

    data['vsku'] = slab_price_vsku;
    data['iitemgroupid'] = slab_price_iitemgroupid;
    data['iqty'] = slab_price_iqty;
    data['nprice'] = slab_price_nprice;

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {

      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'slab_price_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>

<script type="text/javascript">
  $(document).on('keyup', '.slab_price_iqty', function(event) {
    event.preventDefault();
    $(this).closest('tr').find('.selected_slab_price_checkbox').attr('checked', 'checked');
    var slab_price_iqty = $(this).val();
    var slab_price_nprice = $(this).closest('tr').find('.slab_price_nprice').val();

    if(slab_price_iqty != ''){
      if(slab_price_nprice == ''){
        slab_price_nprice = 0;
      }

      var slab_price_nunitprice = slab_price_nprice / slab_price_iqty;
      slab_price_nunitprice = slab_price_nunitprice.toFixed(2);
      $(this).closest('tr').find('.slab_price_nunitprice').html(slab_price_nunitprice);
      $(this).closest('tr').find('.input_slab_price_nunitprice').val(slab_price_nunitprice);

    }
  });

  $(document).on('keyup', '.slab_price_nprice', function(event) {
    event.preventDefault();
    $(this).closest('tr').find('.selected_slab_price_checkbox').attr('checked', 'checked');

    var slab_price_nprice = $(this).val();
    var slab_price_iqty = $(this).closest('tr').find('.slab_price_iqty').val();

    if(slab_price_nprice != ''){
      if(slab_price_iqty == ''){
        slab_price_iqty = 0;
      }

      var slab_price_nunitprice = slab_price_nprice / slab_price_iqty;
      slab_price_nunitprice = slab_price_nunitprice.toFixed(2);
      $(this).closest('tr').find('.slab_price_nunitprice').html(slab_price_nunitprice);
      $(this).closest('tr').find('.input_slab_price_nunitprice').val(slab_price_nunitprice);

    }
  });
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#delete_slab_price_items', function(event) {
    event.preventDefault();

    var data = {};

    if($("input[name='selected_slab_price[]']:checked").length == 0){
      $('#error_alias').html('<strong>Select Items to delete</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }

    $("input[name='selected_slab_price[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {

      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'slab_price_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });
    return false;
  });
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#form_add_parent_item', function(event) {
    event.preventDefault();

    var data = {};
    
    var parent_item_id = $(this).find('select[name="parent_item_id"]').val();
    var child_item_id = $(this).find('input[name="child_item_id"]').val();

    data['parent_item_id'] = parent_item_id;
    data['child_item_id'] = child_item_id;
    
    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {

      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'parent_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });

});
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#remove_parent_item', function(event) {
    event.preventDefault();
    
   

    var data = {};
    var selected_parent_item = []

    var iitemid = $(this).find('input[name="iitemid"]').val();

    if($("input[name='selected_parent_item[]']:checked").length == 0){
      $('#error_alias').html('<strong>Select Items to Remove</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }

    $("input[name='selected_parent_item[]']:checked").each(function (i)
    {
      selected_parent_item[i] = parseInt($(this).val());
    });

    var selected_parent_item_id =selected_parent_item[0];

    data['iitemid'] = iitemid;
    data['selected_parent_item_id'] = selected_parent_item_id;
    
    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {
      
      $('#success_alias').html('<strong>'+ data.success +'</strong>');
      $('#successAliasModal').modal('show');
      $.cookie("tab_selected", 'parent_tab'); //set cookie tab
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }

      $('#error_alias').html('<strong>'+ error_show +'</strong>');
      $('#errorAliasModal').modal('show');
      return false;
    }
  });

});
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    

    }

});

</script>

<script type="text/javascript">
  $(document).on('submit', 'form#form-item', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('submit', 'form#form-item-lot-matrix-list', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('submit', 'form#form-item-vendor', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('submit', 'form#form-item-vendor-list', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('submit', 'form#form-item-slab-price-list', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('click', '#cancel_button, #menu li a, .breadcrumb li a', function() {
    $.cookie("tab_selected", ''); //set cookie tab
  });

  $(document).on('keypress keyup blur', '#input-unitpercase', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

  $(document).on('keypress keyup blur', '.slab_price_iqty', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  });

  $(document).on('keypress keyup blur', 'input[name="nbottledepositamt"], .slab_price_nprice,.input_npackprice', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  });  

  $(document).on('keypress keyup blur', 'input[name="iqtyonhand"], input[name="norderqtyupto"],input[name="iqty"],input[name="ipack"],input[name="ireorderpoint"],input[name="isequence"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

  $(document).on('keypress keyup blur', 'input[name="dcostprice"],input[name="nlevel2"],input[name="nlevel3"],input[name="nlevel4"],input[name="dunitprice"],input[name="ndiscountper"],input[name="nprice"],input[name="npackprice"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });

  $(document).on('focusout', 'input[name="dcostprice"],input[name="nlevel2"],input[name="nlevel3"],input[name="nlevel4"],input[name="dunitprice"],input[name="ndiscountper"],input[name="nprice"],input[name="npackprice"]', function(event) {
    event.preventDefault();

    if($(this).val() != ''){
      if($(this).val().indexOf('.') == -1){
        var new_val = $(this).val();
        $(this).val(new_val+'.00');
      }else{
        var new_val = $(this).val();
        if(new_val.split('.')[1].length == 0){
          $(this).val(new_val+'00');
        }
      }
    }
  });

  $(document).on('focusout', '.slab_price_nprice,.input_npackprice', function(event) {
    event.preventDefault();

    if($(this).val() != ''){
      if($(this).val().indexOf('.') == -1){
        var new_val = $(this).val();
        $(this).val(new_val+'.00');
      }else{
        var new_val = $(this).val();
        if(new_val.split('.')[1].length == 0){
          $(this).val(new_val+'00');
        }
      }
    }
  });  

</script>

<style type="text/css">
  .tab-content.responsive{
      background: #f1f1f1;
      padding-top: 2%;
      padding-bottom: 2%;
      padding-left: 1%;
      padding-right: 2%;
  }
  .nav-tabs{
      margin-bottom:0px;
  }

  .select2-container--default .select2-selection--single{
    border-radius: 0px !important;
    height: 35px !important;
  }
  .select2.select2-container.select2-container--default{
  width: 100% !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 35px !important;
  }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('select[name="vitemtype"]').select2();
  $('select[name="vdepcode"]').select2();
  $('select[name="vcategorycode"]').select2();
  $('select[name="aisleid"]').select2();
  $('select[name="vsuppliercode"]').select2();
  $('select[name="shelfid"]').select2();
  $('select[name="vunitcode"]').select2();
  $('select[name="iitemgroupid"]').select2();
  $('select[name="shelvingid"]').select2();
  $('select[name="vsize"]').select2();
  $('select[name="vageverify"]').select2();
  $('select[name="stationid"]').select2();
  $('select[name="vbarcodetype"]').select2();
</script>

<script type="text/javascript">
  $(document).on('click', '#remove_item_img', function(event) {
    event.preventDefault();
    $('#showImage').attr('src', 'view/image/user-icon-profile.png');
    $('input[name="pre_itemimage"]').val('');
    $(this).hide();
    $('select[name="vshowimage"]').val('No');

  });
</script>

<script type="text/javascript">
  $(document).on('click', '#add_new_category', function(event) {
    event.preventDefault();

    $('form#category_add_new_form').find('#add_vcategoryname').val('');
    $('form#category_add_new_form').find('#category_add_vdescription').val('');

    $('#addModalCatogory').modal('show');
  });

  $(document).on('submit', 'form#category_add_new_form', function(event) {
    event.preventDefault();
    
    if($(this).find('#add_vcategoryname').val() == ''){
      alert('Please enter category name!');
      return false;
    }



    var data = new Array();

    data[0]={};
    data[0]['vcategoryname'] = $(this).find('#add_vcategoryname').val();
    data[0]['vdescription'] = $(this).find('#category_add_vdescription').val();
    data[0]['vcategorttype'] = $(this).find('select[name="vcategorttype"]').val();
    data[0]['isequence'] = $(this).find('input[name="isequence"]').val();
    
      $.ajax({
        url : url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#addModalCatogory').modal('hide');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
      setTimeout(function(){
      
        get_new_category = get_new_category+"&sid="+sid;

        $.getJSON(get_new_category, function(datas) {
          $('select[name="vcategorycode"]').empty();
          var category_html = '';
          $.each(datas, function(index,v) {
            category_html += '<option value="'+ v.icategoryid +'">'+ v.vcategoryname +'</option>';
          });
          $('select[name="vcategorycode"]').append(category_html);
        });
      }, 3000);
  });
</script>

<!-- Modal Add -->
  <div class="modal fade" id="addModalCatogory" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Category</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="category_add_new_form">
            <input type="hidden" name="isequence" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vcategoryname" name="vcategoryname">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Description</label>
                  </div>
                  <div class="col-md-10">  
                    <textarea maxlength="100" name="vdescription" id="category_add_vdescription" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Type</label>
                  </div>
                  <div class="col-md-10">  
                    <select name="vcategorttype" id="" class="form-control ">
                      <option value="" selected="selected"></option>
                      <option value="" ></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('click', '#add_new_department', function(event) {
    event.preventDefault();

    $('form#department_add_new_form').find('#add_vdepartmentname').val('');
    $('form#department_add_new_form').find('#category_add_vdescription').val('');

    $('#addModalDepartment').modal('show');
  });

  $(document).on('submit', 'form#department_add_new_form', function(event) {
    event.preventDefault();
    
    if($(this).find('#add_vdepartmentname').val() == ''){
      alert('Please enter department name!');
      return false;
    }

  

    var data = new Array();

    data[0]={};
    data[0]['vdepartmentname'] = $(this).find('#add_vdepartmentname').val();
    data[0]['vdescription'] = $(this).find('#department_add_vdescription').val();
    data[0]['isequence'] = $(this).find('input[name="isequence"]').val();
    
      $.ajax({
        url : url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#addModalDepartment').modal('hide');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
      setTimeout(function(){
 
        get_new_department = get_new_department.replace(/&amp;/g, '&');
        get_new_department = get_new_department+"&sid="+sid;

        $.getJSON(get_new_department, function(datas) {
          $('select[name="vdepcode"]').empty();
          var department_html = '';
          $.each(datas, function(index,v) {
            department_html += '<option value="'+ v.vdepcode +'">'+ v.vdepartmentname +'</option>';
          });
          $('select[name="vdepcode"]').append(department_html);
        });
      }, 3000);
  });
</script>

<!-- Modal Add -->
  <div class="modal fade" id="addModalDepartment" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Department</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="department_add_new_form">
            <input type="hidden" name="isequence" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vdepartmentname" name="vdepartmentname">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Description</label>
                  </div>
                  <div class="col-md-10">  
                    <textarea maxlength="100" name="vdescription" id="department_add_vdescription" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('click', '#add_new_size', function(event) {
    event.preventDefault();

    $('form#size_add_new_form').find('#add_vsize').val('');

    $('#addModalSize').modal('show');
  });

  $(document).on('submit', 'form#size_add_new_form', function(event) {
    event.preventDefault();
    
    if($(this).find('#add_vsize').val() == ''){
      alert('Please enter size!');
      return false;
    }

    var url = $(this).attr('action')+"&sid="+sid;

    var data = new Array();

    data[0]={};
    data[0]['vsize'] = $(this).find('#add_vsize').val();
    
      $.ajax({
        url : url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#addModalSize').modal('hide');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
      setTimeout(function(){
       
        get_new_size = get_new_size.replace(/&amp;/g, '&');
        get_new_size = get_new_size+"&sid="+sid;

        $.getJSON(get_new_size, function(datas) {
          $('select[name="vsize"]').empty();
          var size_html = '';
          $.each(datas, function(index,v) {
            size_html += '<option value="'+ v.vsize +'">'+ v.vsize +'</option>';
          });
          $('select[name="vsize"]').append(size_html);
        });
      }, 3000);
  });
</script>

<!-- Modal Add -->
  <div class="modal fade" id="addModalSize" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Size</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="size_add_new_form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vsize" name="vsize">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('click', '#add_new_group', function(event) {
    event.preventDefault();

    $('form#group_add_new_form').find('#add_vitemgroupname').val('');

    $('#addModalGroup').modal('show');
  });

  $(document).on('submit', 'form#group_add_new_form', function(event) {
    event.preventDefault();
    
    if($(this).find('#add_vitemgroupname').val() == ''){
      alert('Please enter group name!');
      return false;
    }

  

    var data = new Array();

    data[0]={};
    data[0]['vitemgroupname'] = $(this).find('#add_vitemgroupname').val();
    data[0]['etransferstatus'] = '';
    
      $.ajax({
        url : url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#addModalGroup').modal('hide');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
      setTimeout(function(){
       
        get_new_group = get_new_group.replace(/&amp;/g, '&');
        get_new_group = get_new_group+"&sid="+sid;

        $.getJSON(get_new_group, function(datas) {
          $('select[name="iitemgroupid"]').empty();
          var group_html = '';
          $.each(datas, function(index,v) {
            group_html += '<option value="'+ v.iitemgroupid +'">'+ v.vitemgroupname +'</option>';
          });
          $('select[name="iitemgroupid"]').append(group_html);
        });
      }, 3000);
  });
</script>

<!-- Modal Add -->
  <div class="modal fade" id="addModalGroup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Group</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="group_add_new_form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vitemgroupname" name="vitemgroupname">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('click', '#add_new_supplier', function(event) {
    event.preventDefault();

    $('form#supplier_add_new_form').find('#add_vcompanyname').val('');
    $('form#supplier_add_new_form').find('input[name="vfnmae"]').val('');
    $('form#supplier_add_new_form').find('input[name="vlname"]').val('');
    $('form#supplier_add_new_form').find('input[name="vcode"]').val('');
    $('form#supplier_add_new_form').find('input[name="vaddress1"]').val('');
    $('form#supplier_add_new_form').find('input[name="vcity"]').val('');
    $('form#supplier_add_new_form').find('input[name="vstate"]').val('');
    $('form#supplier_add_new_form').find('input[name="vphone"]').val('');
    $('form#supplier_add_new_form').find('input[name="vzip"]').val('');
    $('form#supplier_add_new_form').find('input[name="vemail"]').val('');

    $('#addModalSupplier').modal('show');
  });

  $(document).on('submit', 'form#supplier_add_new_form', function(event) {
    event.preventDefault();
    
    if($(this).find('#add_vcompanyname').val() == ''){
      alert('Please enter vendor name!');
      return false;
    }
 
   
    var data = new Array();

    data[0]={};
    data[0]['vcompanyname'] = $(this).find('#add_vcompanyname').val();
    data[0]['vvendortype'] = $(this).find('select[name="vvendortype"]').val();
    data[0]['vfnmae'] = $(this).find('input[name="vfnmae"]').val();
    data[0]['vlname'] = $(this).find('input[name="vlname"]').val();
    data[0]['vcode'] = $(this).find('input[name="vcode"]').val();
    data[0]['vaddress1'] = $(this).find('input[name="vaddress1"]').val();
    data[0]['vcity'] = $(this).find('input[name="vcity"]').val();
    data[0]['vstate'] = $(this).find('input[name="vstate"]').val();
    data[0]['vphone'] = $(this).find('input[name="vphone"]').val();
    data[0]['vzip'] = $(this).find('input[name="vzip"]').val();
    data[0]['vcountry'] = $(this).find('input[name="vcountry"]').val();
    data[0]['vemail'] = $(this).find('input[name="vemail"]').val();
    data[0]['plcbtype'] = $(this).find('select[name="plcbtype"]').val();
    data[0]['estatus'] = 'Active';

      $.ajax({
        url : url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#addModalSupplier').modal('hide');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
      setTimeout(function(){
    
        get_new_supplier = get_new_supplier.replace(/&amp;/g, '&');
        get_new_supplier = get_new_supplier+"&sid="+sid;

        $.getJSON(get_new_supplier, function(datas) {
          $('select[name="vsuppliercode"]').empty();
          var supplier_html = '';
          $.each(datas, function(index,v) {
            supplier_html += '<option value="'+ v.vsuppliercode +'">'+ v.vcompanyname +'</option>';
          });
          $('select[name="vsuppliercode"]').append(supplier_html);
        });
      }, 3000);

  });

  $(document).on('keypress keyup blur', '#add_vzip', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 
</script>

<!-- Modal Add -->
  <div class="modal fade" id="addModalSupplier" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Supplier</h4>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="supplier_add_new_form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Vendor Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vcompanyname" name="vcompanyname">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Vendor Type</label>
                  </div>
                  <div class="col-md-10">  
                    <select name="vvendortype" class="form-control"> 
                      <option value="Vendor">Vendor</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>First Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="25" class="form-control" id="add_vfnmae" name="vfnmae">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Last Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="25" class="form-control" id="add_vlname" name="vlname">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Vendor Code</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" class="form-control" id="add_vcode" name="vcode">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Address&nbsp;&nbsp;</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="100" class="form-control" id="add_vaddress1" name="vaddress1">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>City</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" class="form-control" id="add_vcity" name="vcity">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>State</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" class="form-control" id="add_vstate" name="vstate">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Phone</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" class="form-control" id="add_vphone" name="vphone">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Zip</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="10" class="form-control" id="add_vzip" name="vzip">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Country</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" class="form-control" id="add_vcountry" name="vcountry" value="USA" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Email</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="email" maxlength="100" class="form-control" id="add_vemail" name="vemail">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>PLCB Type</label>
                  </div>
                  <div class="col-md-10">  
                    <select name="plcbtype" class="form-control">
                      <option value="None">None</option>
                      <option value="Schedule A">Schedule A</option>
                      <option value="Schedule B">Schedule B</option>
                      <option value="Schedule C">Schedule C</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script src="view/javascript/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $("input[name='vphone']").mask("999-999-9999");
  });
</script>

<script type="text/javascript">
  $(document).on('change', 'select[name="visinventory"]', function(event) {
    event.preventDefault();
    if($(this).val() == 'No'){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Your existing inventory is zero!", 
        callback: function(){}
      });
    }
  });
</script>

<script>
    $(function() {
        
     
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#search_parent_sku" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                    
                      if(present_iitemid != val.iitemid){
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            id: val.iitemid
                        });
                      }
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
              $('form#form_add_parent_item select[name="parent_item_id"]').val(ui.item.id);
              $('#form_add_parent_item').submit();
            }
        });
    });
</script>


<!-- Delete items -->

<script type="text/javascript">
  $(document).on('click', '#delete_btn', function(event) {
    event.preventDefault();
    
    $('#deleteItemModal').modal('show');

  });
</script>

<div id="deleteItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Item</h4>
      </div>
      <div class="modal-body">
        <p>Are you Sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-danger" name="deleteItems" value="Delete">
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).on('click', 'input[name="deleteItems"]', function(event) {
    event.preventDefault();
    
    var data = {};
 
    url = url.replace(/&amp;/g, '&');

 
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Something Went Wrong!', 
        callback: function(){}
      });
      return false;
  
    
    $('#deleteItemModal').modal('hide');
    $("div#divLoading").addClass('show');
    
    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
      success: function(data) {
        
        if(data.error){
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: data.error, 
            callback: function(){}
          });

          $("div#divLoading").removeClass('show');
          return false;

        }else{
          $("div#divLoading").removeClass('show');
          $('#deleteItemSuccessModal').modal('show');

          setTimeout(function(){
           
            url_redirect = url_redirect.replace(/&amp;/g, '&');
            window.location.href = url_redirect;
           
          }, 3000);
        }
        
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: error_show, 
          callback: function(){}
        });

        $("div#divLoading").removeClass('show');

        return false;
      }
    });


  });
</script>

<div class="modal fade" id="deleteItemSuccessModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p><b>Item Deleted Successfully</b></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>

<!-- Delete items -->

<script src="view/javascript/bootbox.min.js" defer></script>

<script type="text/javascript">
  $(document).on('click', '#form-item-vendor-submit-btn', function(event) {
    event.preventDefault();

    var item_id = $('form#form-item-vendor').find('input[name="iitemid"]').val();
    var vvendoritemcode = $('form#form-item-vendor').find('input[name="vvendoritemcode"]').val();
    var ivendorid = $('form#form-item-vendor').find('select[name="ivendorid"]').val();
    var ivendorid_name = $('form#form-item-vendor').find('select[name="ivendorid"] option:selected').text();

    if(vvendoritemcode == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Enter Vendor Item Code', 
        callback: function(){}
      });
      return false;
    }

    if(ivendorid == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Select Vendor', 
        callback: function(){}
      });
      return false;
    }

    var post_data = {iitemid:item_id,vvendoritemcode:vvendoritemcode,ivendorid:ivendorid};

  
    check_vendor_item_code_url = check_vendor_item_code_url.replace(/&amp;/g, '&');

    $.ajax({
      url : check_vendor_item_code_url,
      data : JSON.stringify(post_data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
      success: function(data) {
        
        if(data.error){
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: 'Vendor Item Code "'+vvendoritemcode+'" Already Exist For '+ivendorid_name+' Vendor', 
            callback: function(){}
          });
          return false;

        }else{
         $('form#form-item-vendor').submit();
        }
        
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: error_show, 
          callback: function(){}
        });

        $("div#divLoading").removeClass('show');

        return false;
      }
    });

    return false;
  });
</script>


<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#delete_item_vendor_btn', function(event) {
    event.preventDefault();
    var delete_vendor_code_url = '';
    delete_vendor_code_url = delete_vendor_code_url.replace(/&amp;/g, '&');
    var data = {};

    if($("input[name='selected_vendor_code[]']:checked").length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Select Vendor Code to Delete!', 
        callback: function(){}
      });
      return false;
    }

    $("input[name='selected_vendor_code[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });
    
    $("div#divLoading").addClass('show');

    $.ajax({
        url : delete_vendor_code_url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
        
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $("div#divLoading").removeClass('show');
        $('#successAliasModal').modal('show');

        setTimeout(function(){
         $('#successAliasModal').modal('hide');
         window.location.reload();
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorAliasModal').modal('show');
        return false;
      }
    });
  });
</script>

<script type="text/javascript">

  $(document).on('keypress keyup blur', 'input[name="percent_selling_price"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });

  $(document).on('click', '#selling_price_calculation_btn', function(event) {
    event.preventDefault();
    $('#sellingPercentageModal').modal('show');
  });


  $(document).on('click', '#selling_percent_calculate_btn', function(event) {
    event.preventDefault();

    if($("input[name='percent_selling_price']").val() == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Enter Profit Margin!', 
        callback: function(){}
      });
      return false;
    }

    var per = parseFloat($("input[name='percent_selling_price']").val());
    var prof_mar = parseFloat($("input[name='percent_selling_price']").val());

    if(per == '0' || per == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Profit Margin Should not be Zero!', 
        callback: function(){}
      });
      return false;
    }

     per = 100 - per;
     if (per == 0){
      per = 100;
     }
     var nUnitCost = parseFloat($('input[name="nunitcost"]').val());
     var revenue = (100/per)*nUnitCost;

     revenue = revenue.toFixed(2);

     $('input[name="dunitprice"]').val(revenue);
     $('input[name="profit_margin"]').val(prof_mar.toFixed(2));

     $('#sellingPercentageModal').modal('hide');

  });
</script>

<!-- Modal -->
<div id="sellingPercentageModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Calculate Selling Price</h4>
      </div>
      <div class="modal-body">
        <p class="text-center"><strong>Enter Your Profit Margin and it will Calculate Your Selling Price.</strong></p>
        <p class="text-center"><span style="display: inline-block;"><input type="text" name="percent_selling_price" class="form-control"></span>&nbsp;<span><b>%</b></span></p>
        <p class="text-center">
          <button type="button" class="btn btn-info" id="selling_percent_calculate_btn">Calculate</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </p>
        
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).on('change', 'input[name="options_checkbox"]', function(event) {
    event.preventDefault();
    if ($(this).prop('checked')==true){ 
        $('#options_checkbox_div').show('slow');
    }else{
      $('#options_checkbox_div').hide('slow');
    }
  });
</script>

<script type="text/javascript">
  /*$('input[name="vitemname"]').keypress(function(event) {
    var character = String.fromCharCode(event.keyCode);
    var t = isValid(character); 
      if(!t){
        event.preventDefault();
      }    
  });*/

</script>
</section> 

<!-- Main content -->


</div>
@stop
