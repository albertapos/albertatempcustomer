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
          <form action="{{url('admin/npl-list-store')}}" method="post" id="form-item" class="form-horizontal">
     
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
                     
                    <select name="itemtype" class="form-control form-field" required>
                        <option value="Standard">Standard</option>
                        <option value="Kiosk">Kiosk</option>
                        <option value="Lot Matrix">Lot Matrix</option>
                        <option value="Lottery">Lottery</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-state">Item Name</label>
                  <div class="col-sm-8">
                      <input type="text" name="itemname" maxlength="50" value="" placeholder="Item Name" id="" class="form-control form-field" required>
                  
                  
                      <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Description</label>
                  <div class="col-sm-8">
    
                  
                      <input type="text" name="description" maxlength="50" value="" placeholder="Description" id="" class="form-control form-field" required>
                     
           
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Barcode</label>
                  <div class="col-sm-8">
                    <input type="text" name="barcode" pattern="\d*" maxlength="12" value="" placeholder="Barcode" id="" class="form-control form-field" required>
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group ">
                  <label class="col-sm-4 control-label" for="input-zip">Unit</label>
                  <div class="col-sm-8">
                       <!--<input type="text" name="unit" maxlength="50" value="" placeholder="Unit" id="" class="form-control form-field" required>-->
                        
                        <select name="unit" id="" class="form-control form-field" required >
                        
                            @foreach($units as $u)
                            
                                <option value='{{$u->vunitname}}'>{{$u->vunitname}}</option>
                            
                            @endforeach
                        
                        </select>
                        
                 
                      <div class="text-danger"></div>
                  
                  </div>
                </div>
              </div>
              
              
                <div class="col-md-4">
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="input-address">Age Verification</label>
                      <div class="col-sm-8">
                        
                        <input type="text" name="ageverification" maxlength="2" value="" placeholder="In Numerals" id="" class="form-control" required>
                        <div class="text-danger"></div>
               
                      </div>
                    </div>
                </div>                 
              
              

            </div>

            <div class="row">
                
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Department</label>
                  <div class="col-sm-8">
                      
                        <select name="dept" placeholder="Department" id="" class="form-control form-field" required >
                        
                            @foreach($departments as $d)
                            
                                <option value='{{$d->vdepartmentname}}'>{{$d->vdepartmentname}}</option>
                            
                            @endforeach
                        
                        </select>
                      
                    <!--<input type="text" name="dept" maxlength="50" value="" placeholder="Department" id="" class="form-control form-field" required >-->
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
                
                
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Category</label>
                  <div class="col-sm-8">
                    <!--<input type="text" name="category" maxlength="50" value="" placeholder="Category" id="" class="form-control form-field" required >-->
                  
                    <select name="category" placeholder="Category" id="" class="form-control form-field" required >
                        
                            @foreach($categories as $d)
                            
                                <option value='{{$d->vcategoryname}}'>{{$d->vcategoryname}}</option>
                            
                            @endforeach
                        
                    </select>
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
            
              <div class="col-md-4 ">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Sub Category</label>
                  <div class="col-sm-8">
                    <!--<input type="text" name="subcategory" maxlength="50" value="" placeholder="Sub Category" id="" class="form-control form-field" required >-->
                    
                    <select name="subcategory" id="" class="form-control form-field">
                        
                            @foreach($subcategories as $d)
                            
                                <option value='{{$d->subcat_name}}'>{{$d->subcat_name}}</option>
                            
                            @endforeach
                        
                    </select>
                    
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>
              
              <!-- <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Group</label>
                  <div class="col-sm-8">
                   
                    <input type="text" name="group" maxlength="50" value="" placeholder="Group" id="" class="form-control form-field" required >
                  </div>
                </div>
              </div> -->
              
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-last-name">Size</label>
                  <div class="col-sm-8">
       
                    <!--<input type="text" name="size" maxlength="50" value="" placeholder="Size" id="" class="form-control form-field" required >-->
                  
                    <select name="size" id="" class="form-control form-field" required >
                        
                            @foreach($sizes as $d)
                            
                                <option value='{{$d->isizeid}}'>{{$d->vsize}}</option>
                            
                            @endforeach
                        
                    </select>
                    
                    
                    <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Cost</label>
                  <div class="col-sm-8">
                  
                    <input type="number" name="cost" maxlength="50" value="0.00" placeholder="Cost" id="" class="form-control form-field" required>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Selling Price</label>
                  <div class="col-sm-8">
                 
                    <input type="number" name="sellingprice" maxlength="50" value="0.00" placeholder="Selling Price" id="" class="form-control form-field" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-address">Qty On Hand</label>
                  <div class="col-sm-8">
                
                    <input type="text" name="qtyonhand" maxlength="50" value="" placeholder="Qty On Hand" id="" class="form-control form-field" required>
                    <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Selling Unit</label>
                  <div class="col-sm-8">
                 
                    <input type="text" name="sellingunit" maxlength="50" value="" placeholder="Selling Unit" id="" class="form-control form-field" required>
                
                  </div>
                </div>
              </div>
              
              
              
              <!--<div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number">Supplier</label>
                  <div class="col-sm-8">
                    <input type="text" name="supplier" maxlength="50" value="" placeholder="supplier" id="" class="form-control form-field" required >
                  
                    <div class="text-danger"></div>
              
                  </div>
                </div>
              </div>-->
              
              
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-last-name">Manufacturer</label>
                  <div class="col-sm-8">
       
                    <!--<input type="text" name="size" maxlength="50" value="" placeholder="Size" id="" class="form-control form-field" required >-->
                  
                    <select name="manufacturer" id="" class="form-control form-field" required >
                        
                            @foreach($manufacturers as $d)
                            
                                <option value='{{$d->mfr_name}}'>{{$d->mfr_name}}</option>
                            
                            @endforeach
                        
                    </select>
                    
                    
                    <div class="text-danger"></div>
           
                  </div>
                </div>
              </div>
              
              
              
             </div>
             
             
             
             <!-- <div class="row">
                 
                 
                 
             </div>-->
             
             
             
             
             
             
             
              <div class="row">
                  
                  
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country">Food Stamp</label>
                  <div class="col-sm-8" style="margin-top:7px;">
                        
                    <input type="radio" name="foodstamp"  id="" class="form-control" value="Y">
                    <label>Yes</label>
                    <input type="radio" name="foodstamp"  id="" class="form-control" value="N" checked>
                    <label>No</label>
                   
                  </div>
                </div>
              </div>                
                
                  
                  
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-address">WIC Item</label>
                  <div class="col-sm-8" style="margin-top:5px;">
                  
                    <!--<input type="text" name="wicitem" maxlength="50" value="" placeholder="WIC Item" id="" class="form-control" >-->
                    <input type="radio" name="wicitem"  id="" class="form-control" value="Y">
                    <label>Yes</label>
                    <input type="radio" name="wicitem"  id="" class="form-control" value="N" checked>
                    <label>No</label>
              
           
                  </div>
                </div>
              </div>
         
              
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">Taxable</label>
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
          
          <br>
          <div class="row" style="padding-bottom:10px;">
            <div class="col-md-12 text-center">
              <input type="submit" form="form-item" title="" class="btn btn-primary save_btn_rotate" value="Save">
              <a id="cancel_button" href="{{ url('/admin/npl-list') }}" data-toggle="tooltip" title="" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
         
                <!--<button type="button" class="btn btn-danger" id="delete_btn" style="border-radius: 0px;float: right;"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Delete Item</button>-->
             
              <input type='submit' class='btn btn-danger pull-right' name='Save' value='Finish' placeholder='Qwerty'>
            </div>
          </div>

         
          
          </form>
    
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
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>-->





</section> 

<!-- Main content -->


</div>
@stop