<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <!-- <h1><?php echo $heading_title; ?></h1> -->
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
        
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a id="cancel_button" href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <ul class="nav nav-tabs responsive" id="myTab">
          <li class="active"><a href="#item_tab" data-toggle="tab">Item</a></li>
          <li><a href="#alias_code_tab" data-toggle="tab">Add Alias Code</a></li>
          <li><a href="#parent_tab" data-toggle="tab">Parent / Child</a></li>
          <li <?php if(isset($vitemtype) && $vitemtype != 'Lot Matrix'){ ?> style="pointer-events:none;" <?php } ?> ><a <?php if(isset($vitemtype) && $vitemtype != 'Lot Matrix'){ ?> style="background:#ccc;" <?php } ?> href="#lot_matrix_tab" data-toggle="tab">Lot Matrix</a></li>
          <li><a href="#vendor_tab" data-toggle="tab">Vendor</a></li>
          <li><a href="#slab_price_tab" data-toggle="tab">Slab Price</a></li>
        </ul>

        <div class="tab-content responsive">
          <div class="tab-pane active" id="item_tab">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-item" class="form-horizontal">
            <input type="hidden" name="clone_item_id" value="<?php echo $clone_item_id;?>">
          <?php if(isset($iitemid) && isset($edit_page)){?>
            <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
          <?php } ?>
          <?php if(isset($isparentchild) && isset($edit_page)){?>
            <input type="hidden" name="isparentchild" value="<?php echo !empty($isparentchild) ? $isparentchild : 0; ?>">
          <?php } ?>
          <?php if(isset($parentid) && isset($edit_page)){?>
            <input type="hidden" name="parentid" value="<?php echo !empty($parentid) ? $parentid : 0; ?>">
          <?php } ?>
          <?php if(isset($parentmasterid) && isset($edit_page)){?>
            <input type="hidden" name="parentmasterid" value="<?php echo !empty($parentmasterid) ? $parentmasterid : 0; ?>">
          <?php } ?>
          <div class="panel panel-default" style="border-top:none;margin-bottom:0px;">
            <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>Product</b></h4></div>
          </div>
          <div style="background:#fff;padding-top:1%;padding-right:1%;">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-customer"><?php echo $entry_itemtype; ?></label>
                  <div class="col-sm-8">
                    <select name="vitemtype" class="form-control">
                      <?php if(isset($item_types) && count($item_types) > 0){?>
                        <?php foreach($item_types as $item_type){ ?>
                          <?php if(isset($vitemtype) && $vitemtype == $item_type){?>
                            <option value="<?php echo $item_type;?>" selected="selected"><?php echo $item_type;?></option>
                          <?php }else{ ?>
                            <option value="<?php echo $item_type;?>"><?php echo $item_type;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_deartment; ?></label>
                  <div class="col-sm-8">
                    <select name="vdepcode" class="form-control">
                    <option value="">--Select Department--</option>
                      <?php if(isset($departments) && count($departments) > 0){?>
                        <?php foreach($departments as $department){ ?>
                        <?php if(isset($vdepcode) && $vdepcode == $department['vdepcode']){?>
                          <option value="<?php echo $department['vdepcode'];?>" selected="selected"><?php echo $department['vdepartmentname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $department['vdepcode'];?>"><?php echo $department['vdepartmentname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <span class="add_new_administrations" title="Add Department" id="add_new_department"><button class="btn btn-success btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i></button></span>
                    <?php if ($error_vdepcode) { ?>
                      <div class="text-danger"><?php echo $error_vdepcode; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_qtyonhand; ?></label>
                  <div class="col-sm-8">
    
                    <?php if(isset($edit_page)){?>
                      <?php

                        if($iqtyonhand != 0){
                          $quotient = (int)($iqtyonhand / $npack);
                          $remainder = $iqtyonhand % $npack;

                          $qty_on_hand = 'Case: '.$quotient .' ['.$remainder.']';
                        }else{
                          $qty_on_hand = 'Case: 0 [0]';
                        }
                      ?>
                      <input type="text" value="<?php echo isset($QOH) ? $QOH : ''; ?>" class="form-control" readonly>
                      <input type="hidden" name="iqtyonhand" value="<?php echo isset($iqtyonhand) ? $iqtyonhand : ''; ?>" class="form-control" placeholder="<?php echo $entry_qtyonhand;?>" <?php if((isset($isparentchild) && $isparentchild == 1) || (isset($edit_page))){?> readonly <?php } ?> />
                    <?php }else{?>
                      <input type="text" name="iqtyonhand" value="<?php echo isset($iqtyonhand) ? $iqtyonhand : ''; ?>" class="form-control" placeholder="<?php echo $entry_qtyonhand;?>" />
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4 required">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number"><?php echo $entry_sku; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="vbarcode" maxlength="50" value="<?php echo isset($vbarcode) ? $vbarcode : ''; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-<?php echo $entry_sku; ?>" class="form-control" <?php if(isset($vbarcode) && isset($edit_page)){?>readonly <?php } ?>/>
                    <?php if ($error_vbarcode) { ?>
                    <div class="text-danger"><?php echo $error_vbarcode; ?></div>
                  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_category; ?></label>
                  <div class="col-sm-8">
                    <select name="vcategorycode" class="form-control">
                    <option value="">--Select Category--</option>
                      <?php if(isset($categories) && count($categories) > 0){?>
                        <?php foreach($categories as $category){ ?>
                        <?php if(isset($vcategorycode) && $vcategorycode == $category['vcategorycode']){ ?>
                          <option value="<?php echo $category['vcategorycode'];?>" selected="selected"><?php echo $category['vcategoryname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $category['vcategorycode'];?>"><?php echo $category['vcategoryname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <span class="add_new_administrations" title="Add Category" id="add_new_category"><button class="btn btn-success btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i></button></span>
                    <?php if ($error_vcategorycode) { ?>
                      <div class="text-danger"><?php echo $error_vcategorycode; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_aisle; ?></label>
                  <div class="col-sm-8">
                    <select name="aisleid" class="form-control">
                      <option value="">--Select Aisle--</option>
                      <?php if(isset($aisles) && count($aisles) > 0){?>
                        <?php foreach($aisles as $aisle){ ?>
                          <?php if(isset($aisleid) && $aisleid == $aisle['Id']) {?>
                            <option value="<?php echo $aisle['Id'];?>" selected="selected"><?php echo $aisle['aislename'];?></option>
                          <?php } else { ?>
                            <option value="<?php echo $aisle['Id'];?>"><?php echo $aisle['aislename'];?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-first-name"><?php echo $entry_itemname; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="vitemname" maxlength="100" value="<?php echo isset($vitemname) ? $vitemname : ''; ?>" placeholder="<?php echo $entry_itemname; ?>" id="input-<?php echo $entry_itemname; ?>" class="form-control" />
                    <?php if(isset($itemparentitems) && (count($itemparentitems) > 0)){ ?>
                      <div style="margin-top:10px;"><b>Parent:</b> <?php echo $itemparentitems[0]['vitemname'];?></div>
                    <?php } ?>
                    <?php if ($error_vitemname) { ?>
                    <div class="text-danger"><?php echo $error_vitemname; ?></div>
                  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_supplier; ?></label>
                  <div class="col-sm-8">
                    <select name="vsuppliercode" class="form-control">
                    <option value="">--Select Supplier--</option>
                      <?php if(isset($suppliers) && count($suppliers) > 0){?>
                        <?php foreach($suppliers as $supplier){ ?>
                        <?php if(isset($vsuppliercode) && $vsuppliercode == $supplier['vsuppliercode']){?>
                          <option value="<?php echo $supplier['vsuppliercode'];?>" selected="selected"><?php echo $supplier['vcompanyname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $supplier['vsuppliercode'];?>"><?php echo $supplier['vcompanyname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <span class="add_new_administrations" title="Add Supplier" id="add_new_supplier"><button class="btn btn-success btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i></button></span>
                    <?php if ($error_vsuppliercode) { ?>
                        <div class="text-danger"><?php echo $error_vsuppliercode; ?></div>
                      <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_shelf; ?></label>
                  <div class="col-sm-8">
                    <select name="shelfid" class="form-control">
                      <option value="">--Select Shelf--</option>
                      <?php if(isset($shelfs) && count($shelfs) > 0){?>
                        <?php foreach($shelfs as $shelf){ ?>
                          <?php if(isset($shelfid) && $shelfid == $shelf['Id']){ ?>
                            <option value="<?php echo $shelf['Id'];?>" selected="selected"><?php echo $shelf['shelfname'];?></option>
                          <?php } else { ?>
                            <option value="<?php echo $shelf['Id'];?>"><?php echo $shelf['shelfname'];?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-last-name"><?php echo $entry_description; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="vdescription" maxlength="100" value="<?php echo isset($vdescription) ? $vdescription : ''; ?>" placeholder="<?php echo $entry_description; ?>" id="input-<?php echo $entry_description; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_groupname; ?></label>
                  <div class="col-sm-8">
                    <select name="iitemgroupid" class="form-control">
                    <option value="">--Select Group--</option>
                      <?php if(isset($itemGroups) && count($itemGroups) > 0){?>
                        <?php foreach($itemGroups as $itemGroup){ ?>
                        <?php if(isset($iitemgroupid) && $iitemgroupid == $itemGroup['iitemgroupid']){ ?>
                          <option value="<?php echo $itemGroup['iitemgroupid'];?>" selected="selected"><?php echo $itemGroup['vitemgroupname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $itemGroup['iitemgroupid'];?>"><?php echo $itemGroup['vitemgroupname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <span class="add_new_administrations" title="Add Group" id="add_new_group"><button class="btn btn-success btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i></button></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_shelving; ?></label>
                  <div class="col-sm-8">
                    <select name="shelvingid" class="form-control">
                      <option value="">--Select Shelving--</option>
                      <?php if(isset($shelvings) && count($shelvings) > 0){?>
                        <?php foreach($shelvings as $shelving){ ?>
                        <?php if(isset($shelvingid) && $shelvingid == $shelving['id']){ ?>
                          <option value="<?php echo $shelving['id'];?>" selected="selected"><?php echo $shelving['shelvingname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $shelving['id'];?>"><?php echo $shelving['shelvingname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-address"><?php echo $entry_unit; ?></label>
                  <div class="col-sm-8">
                    <select name="vunitcode" class="form-control">
                      <?php if(isset($units) && count($units) > 0){?>
                        <?php foreach($units as $unit){ ?>
                        <?php if(isset($vunitcode) && $vunitcode == $unit['vunitcode']){?>
                          <option value="<?php echo $unit['vunitcode'];?>" selected="selected"><?php echo $unit['vunitname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $unit['vunitcode'];?>"><?php echo $unit['vunitname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_vunitcode) { ?>
                    <div class="text-danger"><?php echo $error_vunitcode; ?></div>
                  <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_size; ?></label>
                  <div class="col-sm-8">
                    <select name="vsize" class="form-control">
                    <option value="">--Select Size--</option>
                      <?php if(isset($sizes) && count($sizes) > 0){?>
                        <?php foreach($sizes as $size){ ?>
                        <?php if(isset($vsize) && $vsize == $size['vsize']){ ?>
                          <option value="<?php echo $size['vsize'];?>" selected="selected"><?php echo $size['vsize'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $size['vsize'];?>"><?php echo $size['vsize'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <span class="add_new_administrations" title="Add Size" id="add_new_size"><button class="btn btn-success btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i></button></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_taxable; ?>
                  </label>
                  <div class="col-md-8">
                    <span style="display:inline-block;margin-top: 8px;">
                    <input style="display:inline-block;" type="checkbox" name="vtax1" value="Y" class="form-control" <?php if (isset($vtax1) && $vtax1 == 'Y') echo "checked";  ?>/>
                    <span style="display:inline-block;">&nbsp;&nbsp;<?php echo $entry_tax1;?></span></span>&nbsp;&nbsp;&nbsp;
                    <span style="display:inline-block;margin-top: 8px;">
                    <input style="display:inline-block;" type="checkbox" name="vtax2" value="Y" class="form-control" <?php if (isset($vtax2) && $vtax2 == 'Y') echo "checked";  ?> /><span style="display:inline-block;">&nbsp;&nbsp;<?php echo $entry_tax2;?></span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="panel panel-default" style="border-top:none;margin-bottom:0px;margin-top:1%;">
            <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>Price</b></h4></div>
          </div>
          <div style="background:#fff;padding-top:1%;padding-right:1%;">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_unitpercase; ?></label>
                  <?php 
                    if(isset($npack) && $npack != ''){
                      $npack = $npack;
                    }else{
                      $npack = 1;
                    }
                  ?>
                  <div class="col-md-8">
                    <input type="text" name="npack" value="<?php echo $npack; ?>" placeholder="<?php echo $entry_unitpercase; ?>" id="input-unitpercase" class="form-control" />
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_avg_case_cost; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="dcostprice" value="<?php echo isset($dcostprice) ? $dcostprice : ''; ?>" placeholder="<?php echo $entry_avg_case_cost; ?>" id="input-avg_case_cost" class="form-control" <?php if(isset($isparentchild) && $isparentchild == 1){?> readonly <?php } ?> />
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_unitcost; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="nunitcost" value="<?php echo isset($nunitcost) ? $nunitcost : ''; ?>" placeholder="<?php echo $entry_unitcost; ?>" id="input-unitcost" class="form-control" readonly/>
                  </div>
                </div>
              </div>
              <?php 
                if(isset($nsellunit) && $nsellunit != ''){
                  $nsellunit = $nsellunit;
                }else{
                  $nsellunit = 1;
                }
              ?>
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_sellingunit; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="nsellunit" value="<?php echo $nsellunit; ?>" placeholder="<?php echo $entry_sellingunit; ?>" id="input-sellingunit" class="form-control" <?php if(isset($vitemtype) && $vitemtype == 'Lot Matrix'){?> readonly <?php } ?> />
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_sellingprice; ?></label>
                  <div class="col-md-8">
                    <span style="display: inline-block;width: 80%;"><input type="text" name="dunitprice" value="<?php echo isset($dunitprice) ? $dunitprice : ''; ?>" placeholder="<?php echo $entry_sellingprice; ?>" id="input-Selling-Price" class="form-control"/></span>&nbsp;
                    <span style="display: inline-block;width: 10%" id="selling_price_calculation_btn"><button class="btn btn-sm btn-info">..</button></span>
                    
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_discount; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="ndiscountper" value="<?php echo isset($ndiscountper) ? $ndiscountper : ''; ?>" placeholder="<?php echo $entry_discount; ?>" id="input-<?php echo $entry_discount; ?>" class="form-control"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level2price; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="nlevel2" value="<?php echo isset($nlevel2) ? $nlevel2 : ''; ?>" placeholder="<?php echo $entry_level2price; ?>" id="input-<?php echo $entry_level2price; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level3price; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="nlevel3" value="<?php echo isset($nlevel3) ? $nlevel3 : ''; ?>" placeholder="<?php echo $entry_level3price; ?>" id="input-<?php echo $entry_level3price; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level4price; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="nlevel4" value="<?php echo isset($nlevel4) ? $nlevel4 : ''; ?>" placeholder="<?php echo $entry_level4price; ?>" id="input-<?php echo $entry_level4price; ?>" class="form-control"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone">Profit Margin(%)</label>
                  <?php 
                    if(isset($nunitcost) && isset($dunitprice)){

                      $percent = $dunitprice - $nunitcost;

                      if($percent > 0){
                        $percent = $percent;
                      }else{
                        $percent = 0;
                      }
                      
                      if($dunitprice == 0 || $dunitprice == '0.0000'){
                        $dunitprice = 1;
                      }
                     
                      $percent = (($percent/$dunitprice) * 100);
                      $percent = number_format((float)$percent, 2, '.', '');

                    }else{
                      $percent = 0.00;
                    }
                  ?>
                  <div class="col-md-8">
                    <input type="text" name="profit_margin" value="<?php echo $percent;?>" placeholder="" id="input-profit-margin" class="form-control" readonly />
                  </div>
                  
                </div>
              </div>
              <div class="col-md-4"></div>
            </div>
          </div>

            <div class="row" style="display:none;">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_seq; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="vsequence" value="<?php echo isset($vsequence) ? $vsequence : ''; ?>" placeholder="<?php echo $entry_seq; ?>" id="input-<?php echo $entry_seq; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_itemcolor; ?></label>
                  <div class="col-sm-8">
                    <select name="vcolorcode" class="form-control">
                      <?php if(isset($item_colors) && count($item_colors) > 0){?>
                        <?php foreach($item_colors as $item_color){ ?>
                          <?php if(isset($vcolorcode) && $vcolorcode == $item_color){ ?>
                            <option value="<?php echo $item_color;?>" selected="selected"><?php echo $item_color;?></option>
                          <?php } else { ?>
                            <option value="<?php echo $item_color;?>"><?php echo $item_color;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          
           <div class="panel panel-default" style="border-top:none;margin-bottom:0px;margin-top:1%;">
            <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>General</b></h4></div>
          </div>
           <div style="background:#fff;padding-top:1%;padding-right:1%;"> 
            <div class="row">
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_fooditem; ?></label>
                  <div class="col-md-8">
                    <select name="vfooditem" class="form-control">
                        <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                          <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                            <?php if($vfooditem == $k) {?>
                              <option value="<?php echo $k;?>" selected="selected"><?php echo $array_y_n;?></option>
                            <?php }else{?>
                              <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_wic_item; ?></label>
                  <div class="col-md-8">
                    <select name="wicitem" class="form-control">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <?php if($wicitem == $k) {?>
                            <option value="<?php echo $k;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_station; ?></label>
                  <div class="col-md-8">
                    <select name="stationid" class="form-control">
                      <option value="">--Select Station--</option>
                      <?php if(isset($stations) && count($stations) > 0){?>
                        <?php foreach($stations as $station){ ?>
                        <?php if(isset($stationid) && $stationid == $station['Id']){ ?>
                          <option value="<?php echo $station['Id'];?>" selected="selected"><?php echo $station['stationname'];?></option>
                        <?php } else { ?>
                          <option value="<?php echo $station['Id'];?>"><?php echo $station['stationname'];?></option>
                        <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_liability; ?></label>
                  <div class="col-md-8">
                    <select name="liability" class="form-control">
                      <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                        <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                          <?php if($liability == $k) {?>
                            <option value="<?php echo $k;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_reorderpoint; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="ireorderpoint" value="<?php echo isset($ireorderpoint) ? $ireorderpoint : ''; ?>" placeholder="<?php echo $entry_reorderpoint; ?>" id="input-<?php echo $entry_reorderpoint; ?>" class="form-control"  />
                    <span class="text-small"><b>Enter Reorder Point in Unit.</b></span>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_orderqtyupto; ?></label>
                  <div class="col-md-8">
                    <input type="text" name="norderqtyupto" value="<?php echo isset($norderqtyupto) ? $norderqtyupto : ''; ?>" placeholder="<?php echo $entry_orderqtyupto; ?>" id="input-<?php echo $entry_orderqtyupto; ?>" class="form-control" />
                    <span class="text-small"><b>Enter Order Qty Upto in Case.</b></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_inventoryitem; ?></label>
                  <div class="col-md-8">
                    <select name="visinventory" class="form-control">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <?php if($visinventory == $array_y_n) {?>
                            <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_ageverification; ?></label>
                  <div class="col-md-8">
                    <select name="vageverify" class="form-control">
                      <?php if(isset($ageVerifications) && count($ageVerifications) > 0){?>
                        <?php foreach($ageVerifications as $ageVerification){ ?>
                          <?php if(isset($vageverify) && $vageverify == $ageVerification['vvalue']) { ?>
                            <option value="<?php echo $ageVerification['vvalue'];?>" selected="selected"><?php echo $ageVerification['vname'];?></option>
                          <?php } else { ?>
                            <option value="<?php echo $ageVerification['vvalue'];?>"><?php echo $ageVerification['vname'];?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="border-top:none;">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_bottledeposit; ?></label>
                  <div class="col-md-8">
                    <input name="nbottledepositamt" value="<?php echo isset($nbottledepositamt) ? $nbottledepositamt : '0.00'; ?>" type="text" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_barcodetype; ?></label>
                    <div class="col-md-8">
                      <select name="vbarcodetype" class="form-control">
                        <?php if(isset($barcode_types) && count($barcode_types) > 0){?>
                          <?php foreach($barcode_types as $barcode_type){ ?>
                          <?php if(isset($vbarcodetype) && $vbarcodetype == $barcode_type) { ?>
                            <option value="<?php echo $barcode_type;?>" selected="selected"><?php echo $barcode_type;?></option>
                          <?php } else { ?>
                            <option value="<?php echo $barcode_type;?>"><?php echo $barcode_type;?></option>
                          <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_vintage; ?></label>
                    <div class="col-md-8">
                      <input type="text" name="vintage" maxlength="45" value="<?php echo isset($vintage) ? $vintage : ''; ?>" placeholder="<?php echo $entry_vintage; ?>" id="input-<?php echo $entry_vintage; ?>" class="form-control"  />
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_rating; ?></label>
                    <div class="col-md-8">
                      <input type="text" name="rating" maxlength="45" value="<?php echo isset($rating) ? $rating : ''; ?>" placeholder="<?php echo $entry_rating; ?>" id="input-<?php echo $entry_rating; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
            </div>
              
            <div class="row">
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-country"><?php echo $text_discount; ?></label>
                    <div class="col-md-8">
                      <select name="vdiscount" class="form-control">
                        <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                          <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                            <?php if($vdiscount == $array_y_n) {?>
                              <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                            <?php }else{?>
                              <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-country">Status</label>
                    <div class="col-md-8">
                      <select name="estatus" class="form-control">
                        <?php if(isset($array_status) && count($array_status) > 0){?>
                          <?php foreach($array_status as $k => $array_sts){ ?>
                            <?php if($estatus == $array_sts) {?>
                              <option value="<?php echo $array_sts;?>" selected="selected"><?php echo $array_sts;?></option>
                            <?php }else{?>
                              <option value="<?php echo $array_sts;?>"><?php echo $array_sts;?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_salesitem; ?></label>
                    <div class="col-md-8">
                      <select name="vshowsalesinzreport" class="form-control">
                        <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                          <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                            <?php if($vshowsalesinzreport == $array_y_n) {?>
                              <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                            <?php }else{?>
                              <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" style="border-top:none;">
                    <div class="col-md-4">
                      <p style=""><label class="control-label" for="input-phone"><?php echo $entry_show_image; ?></label>
                        <select name="vshowimage" class="form-control">
                            <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                              <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                                <?php if($vshowimage == $array_y_n) {?>
                                  <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                                <?php }else{?>
                                  <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>
                          </select>
                      </p>
                    </div>
                    <div class="col-md-8">
                      <?php if(isset($itemimage) && $itemimage != ''){?>
                        <img src="data:image/gif;base64,<?php echo $itemimage;?>" class="img-responsive" width="100" height="100" alt="" id="showImage">
                        <br>
                        <button class="btn btn-info btn-sm" id="remove_item_img">Remove</button>
                        <br><br>
                        <input type="hidden" name="pre_itemimage" value="<?php echo $itemimage;?>">
                      <?php } else { ?>
                        <img src="view/image/user-icon-profile.png" class="img-responsive" width="100" height="100" alt="" id="showImage"><br>
                        <input type="hidden" name="pre_itemimage" value="">
                      <?php } ?>
                      <input type="file" name="itemimage" accept="image/x-png,image/gif,image/jpeg" onchange="showImages(this)">
                    </div>
                  </div>
                  
                </div>
            </div>
          </div>

          <br>
          <div class="panel panel-default" style="border-top:none;margin-bottom:0px;">
            <div class="panel-body" style="padding: 10px 10px 0px 10px;"><h4><b>Options</b> &nbsp;&nbsp; <input type="checkbox" name="options_checkbox" value="1" <?php if($options_checkbox){ echo 'checked'; }?>></h4></div>
          </div>
          <div style="background:#fff;padding-top:1%;padding-right:1%;">
            <div id="options_checkbox_div" style="<?php if($options_checkbox){ echo 'display: block'; }else{ echo 'display: none'; }?>">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-phone">
                  Unit</label>
                  <div class="col-sm-8">
                    <select name="unit_id" class="form-control">
                      <option value="">-- Select Unit --</option>
                      <?php if(isset($itemsUnits) && count($itemsUnits) > 0){ ?>
                        <?php foreach($itemsUnits as $unit){ ?>
                          <?php if($unit['id'] == $unit_id) {?>
                            <option value="<?php echo $unit['id']; ?>" selected="selected"><?php echo $unit['unit_name']; ?></option>
                          <?php } else {?>
                            <option value="<?php echo $unit['id']; ?>"><?php echo $unit['unit_name']; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_unit_id) { ?>
                      <div class="text-danger"><?php echo $error_unit_id; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-phone">
                  Unit Value</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?php echo isset($unit_value) ? $unit_value : ''; ?>" name="unit_value">

                    <?php if ($error_unit_value) { ?>
                      <div class="text-danger"><?php echo $error_unit_value; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-phone">
                  Bucket</label>
                  <div class="col-sm-8">
                    <select name="bucket_id" class="form-control">
                      <option value="">-- Select Bucket --</option>
                      <?php if(isset($buckets) && count($buckets) > 0){?>
                        <?php foreach($buckets as $bucket){ ?>
                          <?php if($bucket['id'] == $bucket_id) {?>
                            <option value="<?php echo $bucket['id'];?>" selected="selected"><?php echo $bucket['bucket_name'];?></option>
                          <?php } else {?>
                            <option value="<?php echo $bucket['id'];?>"><?php echo $bucket['bucket_name'];?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <?php if ($error_bucket_id) { ?>
                      <div class="text-danger"><?php echo $error_bucket_id; ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone">
                  Malt</label>
                  <div class="col-sm-8">
                    <input style="margin-top: 10px;" type="checkbox" class="form-control" name="malt" value="1" <?php if($malt){ echo 'checked'; }?>>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
          
          </form>
          <br>
          <div class="row">
            <div class="col-md-12 text-center">
              <input type="submit" form="form-item" title="<?php echo $button_save; ?>" class="btn btn-primary save_btn_rotate" value="Save">
              <a id="cancel_button" href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
          </div>
          <div class="tab-pane" id="alias_code_tab">
            <form action="<?php echo $add_alias_code; ?>" method="post" enctype="multipart/form-data" id="form-item-alias-code" class="form-horizontal">
            <?php if(isset($iitemid)){?>
              <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
            <?php } ?>
              <div class="row">
                <div class="col-md-4">
                  <span>Alias Code:&nbsp;&nbsp;</span><span style="display:inline-block;"><input type="text" name="valiassku" maxlength="50" class="form-control" required></span>
                  <input type="hidden" name="vitemcode" value="<?php echo isset($vitemcode) ? $vitemcode : ''; ?>">
                  <input type="hidden" name="vsku" value="<?php echo isset($vbarcode) ? $vbarcode : ''; ?>">
                </div>
                <div class="col-md-4">
                  <span style="display:inline-block;"><input type="submit" name="Alias_code" value="Add Alias Code" class="btn btn-info"></span>
                </div>
              </div>
            </form>
            <br><br>
            <form action="<?php echo $alias_code_deletelist; ?>" method="post" enctype="multipart/form-data" id="form-item-alias-list" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-hover" style="width:30%;">
                    <thead>
                      <tr>
                        <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_alias\']').prop('checked', this.checked);" /></th>
                        <th>Alias sku</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($itemalias) && count($itemalias) > 0){ ?>
                      <?php foreach($itemalias as $k => $alias) { ?>
                        <tr>
                          <td><input type="checkbox" name="selected_alias[]" value="<?php echo $alias['iitemaliasid']; ?>" /></td>
                          <td><?php echo $alias['valiassku'];?></td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12 text-left">
                  <input type="submit" title="Delete" class="btn btn-danger" value="Delete" style="border-radius:0px;" <?php if(isset($itemalias) && count($itemalias) == 0){ ?> disabled="true" <?php } ?> >
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="parent_tab">
            <div class="row">
              <div class="col-md-12">
                <p><b>Item Name: </b> &nbsp;&nbsp;&nbsp;<input type="text" class="form-control" style="width:25%;display:inline-block;" value="<?php echo isset($vitemname) ? $vitemname: ''?>" readonly></p>
              </div>
            </div>
            <br>
            <div class="row">
              <form action="<?php echo $add_parent_item;?>" method="post" id="form_add_parent_item">
              <?php if(isset($iitemid)){?>
                <input type="hidden" name="child_item_id" value="<?php echo $iitemid;?>">
              <?php } ?>
                <div class="col-md-4">
                  <select name="parent_item_id" class="form-control" required>
                    <option value="">-- Select Product --</option>
                    <?php if(isset($iitemid) && isset($loadChildProducts)){?>
                      <?php foreach($loadChildProducts as $loadChildProduct){ ?>
                        <?php if($loadChildProduct['iitemid'] != $iitemid) {?>
                          <option value="<?php echo $loadChildProduct['iitemid'];?>"><?php echo $loadChildProduct['vitemname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              <div class="col-md-2">
                <input type="submit" class="btn btn-info" value="Add Parent Item" <?php if(isset($itemparentitems) && (count($itemparentitems) > 0)){ ?> disabled="true" <?php } ?> >
              </div>
              </form>
              <div class="col-md-1" style="margin-left:-5%;">
                <form action="<?php echo $action_remove_parent_item;?>" id="remove_parent_item" method="post">
                  <?php if(isset($iitemid) && isset($edit_page)){?>
                    <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
                  <?php } ?>
                  <input type="submit" value="Remove" class="btn btn-info" <?php if(isset($remove_parent_item) && count($remove_parent_item) == 0){?> <?php }else{?> disabled="true" <?php } ?> >
                </form>
              </div>
              
            </div>
            <br><br>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-hover" style="width:40%;">
                  <thead>
                    <tr>
                      <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_parent_item\']').prop('checked', this.checked);" /></th>
                      <th>Parent</th>
                      <th style="width:15%">Pack</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($itemparentitems) && (count($itemparentitems) > 0)){ ?>
                      <?php foreach($itemparentitems as $itemparentitem){ ?>
                        <tr>
                          <td><input type="checkbox" class="selected_parent_item_checkbox" name="selected_parent_item[]" value="<?php echo $itemparentitem['iitemid']; ?>" /></td>
                          <td><?php echo $itemparentitem['vitemname'] ;?></td>
                          <td><?php echo $itemparentitem['npack'] ;?></td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <br><br>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-hover" style="width:40%;">
                  <thead>
                    <tr>
                      <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_child_item\']').prop('checked', this.checked);" /></th>
                      <th>Child</th>
                      <th style="width:15%">Pack</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(isset($itemchilditems) && (count($itemchilditems) > 0)){?>
                    <?php foreach($itemchilditems as $itemchilditem){ ?>
                      <tr>
                        <td><input type="checkbox" class="selected_child_item_checkbox" name="selected_child_item[]" value="<?php echo $itemchilditem['iitemid']; ?>" /></td>
                        <td><?php echo $itemchilditem['vitemname'] ;?></td>
                        <td><?php echo $itemchilditem['npack'] ;?></td>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="lot_matrix_tab">
            <div class="row">
              <div class="col-md-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addLotItemModal">Add Lot Item</button>&nbsp;&nbsp;
                <form action="<?php echo $lot_matrix_deletelist; ?>" method="post" id="delete_lot_items" style="display: inline-block;">
                  <input type="submit" class="btn btn-danger" value="Delete Lot Item" style="border-radius:0px;">
                </form>
              </div>
            </div>
            <br><br>
            <form action="<?php echo $lot_matrix_editlist; ?>" method="post" enctype="multipart/form-data" id="form-item-lot-matrix-list" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_lot_matrix\']').prop('checked', this.checked);" /></th>
                        <th>Pack Name</th>
                        <th>Description</th>
                        <th>Unit Cost</th>
                        <th>Pack Qty</th>
                        <th>Pack Cost</th>
                        <th>Price</th>
                        <th>Sequence</th>
                        <th>Profit Margin(%)</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($itempacks) && count($itempacks) > 0){ ?>
                      <?php foreach($itempacks as $k => $itempack) { ?>
                        <tr>
                        <input type="hidden" name="itempacks[<?php echo $k; ?>][iitemid]" value="<?php echo $itempack['iitemid']; ?>">
                        <input type="hidden" name="itempacks[<?php echo $k; ?>][idetid]" value="<?php echo $itempack['idetid']; ?>">
                          <?php if($itempack['iparentid'] == 1){ ?>
                            <td><input type="checkbox" name="" value="<?php echo $itempack['idetid']; ?>" class="selected_lot_matrix_checkbox" /></td>
                          <?php } else { ?>
                            <td><input type="checkbox" class="selected_lot_matrix_checkbox" name="selected_lot_matrix[]" value="<?php echo $itempack['idetid']; ?>" /></td>
                          <?php } ?>
                          <td><?php echo $itempack['vpackname'];?></td>
                          <td><?php echo $itempack['vdesc'];?></td>
                          <td><?php echo $nunitcost;?></td>
                          <td><?php echo $itempack['ipack'];?></td>
                          <td>
                            <?php echo $itempack['npackcost'];?>
                            <input type="hidden" class="input_npackcost" value="<?php echo $itempack['npackcost'];?>">
                          </td>
                          <td>
                            <input type="text" class="editable input_npackprice" name="itempacks[<?php echo $k; ?>][npackprice]" value="<?php echo $itempack['npackprice']; ?>" />
                          </td>
                          <td><?php echo $itempack['isequence'];?></td>
                          <td>
                            <span class="npackmargins"><?php echo $itempack['npackmargin'];?></span>
                            <input class="input_npackmargins" type="hidden" name="itempacks[<?php echo $k; ?>][npackmargin]" value="<?php echo $itempack['npackmargin']; ?>" />
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" title="Update" class="btn btn-primary" value="Update" <?php if(isset($itempacks) && count($itempacks) == 0){ ?> disabled="true" <?php } ?> >
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="vendor_tab">
            <form action="<?php echo $action_vendor; ?>" method="post" enctype="multipart/form-data" id="form-item-vendor" class="form-horizontal">
            <?php if(isset($iitemid)){?>
              <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
            <?php } ?>
              <div class="row">
                <div class="col-md-4 text-center">
                  <span>Vendor Item Code:&nbsp;&nbsp;</span><span style="display:inline-block;"><input type="text" name="vvendoritemcode" maxlength="100" class="form-control" required></span>
                </div>
                <div class="col-md-4 text-center">
                  <span>Vendor:&nbsp;&nbsp;</span>
                  <span style="display:inline-block;">
                    <select name="ivendorid" class="form-control" required>
                      <option value="">--Select Vendor--</option>
                        <?php if(isset($suppliers) && count($suppliers) > 0){?>
                          <?php foreach($suppliers as $supplier){ ?>
                            <?php $already_vendor = false; ?>
                            <?php if(isset($itemvendors) && count($itemvendors) > 0){ ?>
                              <?php foreach($itemvendors as $itemvendor) { ?>
                                <?php if($itemvendor['ivendorid'] == $supplier['isupplierid']){ ?>
                                    <?php $already_vendor = true; ?>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>
                            <?php if($already_vendor == false){ ?>
                              <option value="<?php echo $supplier['vsuppliercode'];?>"><?php echo $supplier['vcompanyname'];?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                    </select>
                  </span>
                </div>
                <div class="col-md-4">
                  <span style="display:inline-block;"><input type="submit" name="Assign" value="Assign" class="btn btn-info"></span>
                </div>
              </div>
            </form>
            <br><br>
            <form action="<?php echo $action_vendor_editlist; ?>" method="post" enctype="multipart/form-data" id="form-item-vendor-list" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-hover" style="width:70%;">
                    <thead>
                      <tr>
                        <th>Vendor Name</th>
                        <th>Vendor Item Code</th>
                        <th>Address</th>
                        <th>Phone</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($itemvendors) && count($itemvendors) > 0){ ?>
                      <?php foreach($itemvendors as $k => $itemvendor) { ?>
                        <tr>
                        <input type="hidden" name="itemvendors[<?php echo $k; ?>][iitemid]" value="<?php echo $itemvendor['iitemid']; ?>">
                        <input type="hidden" name="itemvendors[<?php echo $k; ?>][ivendorid]" value="<?php echo $itemvendor['ivendorid']; ?>">
                          <td><?php echo $itemvendor['vcompanyname'];?></td>
                          <td>
                            <input type="text" class="editable" maxlength="100" name="itemvendors[<?php echo $k; ?>][vvendoritemcode]" value="<?php echo $itemvendor['vvendoritemcode']; ?>" />
                          </td>
                          <td><?php echo $itemvendor['vaddress1'];?></td>
                          <td><?php echo $itemvendor['vphone'];?></td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" title="Update" value="Update" class="btn btn-primary" <?php if(isset($itemvendors) && count($itemvendors) == 0){ ?> disabled="true" <?php } ?> >
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="slab_price_tab">
            <div class="row" style="display:inline-block;width:85%;">
                <form action="<?php echo $add_slab_price; ?>" method="post" enctype="multipart/form-data" id="form-item-add-slab-price" class="form-horizontal">
                <?php if(isset($vbarcode)){?>
                  <input type="hidden" name="vsku" value="<?php echo $vbarcode;?>">
                  <input type="hidden" name="iitemgroupid" value="0">
                <?php } ?>
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <span>Qty:&nbsp;&nbsp;</span><span style="display:inline-block;"><input type="text" name="iqty" class="form-control" required></span>
                    </div>
                    <div class="col-md-4 text-center">
                      <span>Price:&nbsp;&nbsp;</span>
                      <span style="display:inline-block;"><input type="text" name="nprice" class="form-control" required></span>
                    </div>
                    <div class="col-md-4">
                      <span style="display:inline-block;"><input type="submit" name="Assign" value="Add Item" class="btn btn-info"></span>&nbsp;&nbsp;
                    </div>
                  </div>
                </form>
            </div>
            <div class="row" style="display:inline-block;width:10%;margin-left:-18%;">
              <div class="col-md-2">
                <form action="<?php echo $slab_price_deletelist; ?>" method="post" id="delete_slab_price_items" style="display: inline-block;">
                    <input type="submit" class="btn btn-danger" value="Delete Item" style="border-radius:0px;">
                </form>
              </div>
              <div class="col-md-10"></div>
            </div>
          
            <br><br>
            <form action="<?php echo $slab_price_editlist; ?>" method="post" enctype="multipart/form-data" id="form-item-slab-price-list" class="form-horizontal">
            <?php if(isset($iitemid)){?>
              <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
            <?php } ?>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-hover" style="width:40%;">
                    <thead>
                      <tr>
                        <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_slab_price\']').prop('checked', this.checked);" /></th>
                        <th style="width:20%;">Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Unit Price</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($itemslabprices) && count($itemslabprices) > 0){ ?>
                      <?php foreach($itemslabprices as $k => $itemslabprice) { ?>
                        <tr>
                        <input type="hidden" name="itemslabprices[<?php echo $k; ?>][islabid]" value="<?php echo $itemslabprice['islabid']; ?>">
                          <td><input type="checkbox" class="selected_slab_price_checkbox" name="selected_slab_price[]" value="<?php echo $itemslabprice['islabid']; ?>" /></td>
                          <td><?php echo $itemslabprice['vsku'];?></td>
                          <td>
                            <input type="text" class="editable slab_price_iqty" name="itemslabprices[<?php echo $k; ?>][iqty]" value="<?php echo $itemslabprice['iqty']; ?>" />
                          </td>
                          <td>
                            <input type="text" class="editable slab_price_nprice" name="itemslabprices[<?php echo $k; ?>][nprice]" value="<?php echo $itemslabprice['nprice']; ?>" />
                          </td>
                          <td>
                            <span class="slab_price_nunitprice"><?php echo $itemslabprice['nunitprice'];?> </span> 
                            <input type="hidden" class="input_slab_price_nunitprice" name="itemslabprices[<?php echo $k; ?>][nunitprice]" value="<?php echo $itemslabprice['nunitprice']; ?>" /> 
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" title="Update" value="Update" class="btn btn-primary" <?php if(isset($itemslabprices) && count($itemslabprices) == 0){ ?> disabled="true" <?php } ?> >
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
</script>

<?php if(!isset($edit_page)){?>
    <style type="text/css">
      #myTab > li:nth-child(2), #myTab > li:nth-child(3),#myTab > li:nth-child(4),#myTab > li:nth-child(5),#myTab > li:nth-child(6){
        pointer-events: none;
      }
    </style>
<?php } ?>

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
      var per = sell_price - $('#input-unitcost').val();

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
      var per = sell_price - $('#input-unitcost').val();

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
      var per = sell_price - $('#input-unitcost').val();

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
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#form-item-alias-code', function(event) {
    event.preventDefault();
    
    var sid = "<?php echo $sid;?>";
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
    var sid = "<?php echo $sid;?>";
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
    <form action="<?php echo $add_lot_matrix;?>" method="post" id="add_lot_matrix">
      <?php if(isset($iitemid)){?>
        <input type="hidden" name="iitemid" value="<?php echo $iitemid;?>">
      <?php } ?>
      <?php if(isset($vbarcode)){?>
        <input type="hidden" name="vbarcode" value="<?php echo $vbarcode;?>">
      <?php } ?>
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
              <input class="form-control" type="text" id="npackcost" name="npackcost" required value="<?php echo isset($nunitcost)? number_format((float)$nunitcost, 2, '.', '') : '';?>" readonly>
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

    <?php if(isset($nunitcost)){ ?>
      var unitcost = '<?php echo $nunitcost;?>';
    <?php }else{ ?>
      var unitcost = 0;
    <?php } ?>

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
        <?php if(isset($nunitcost)){ ?>
          var npackcost = '<?php echo $nunitcost;?>';
        <?php }else{ ?>
          var npackcost = 0;
        <?php } ?>
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
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;
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
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;
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
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;
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
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;
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

    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;
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
    
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;

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
    
    if ((!!$.cookie('tab_selected')) && ($.cookie('tab_selected') != '')) {
      var tab_s = $.cookie('tab_selected');
      // have cookie
      $('#myTab li.active').removeClass('active');
      $('.tab-content div.tab-pane.active').removeClass('active');

      if(tab_s == 'alias_code_tab'){
        $('#myTab li:eq(1)').addClass('active');
        $('.tab-content #alias_code_tab').addClass('active');
      }else if(tab_s == 'parent_tab'){
        $('#myTab li:eq(2)').addClass('active');
        $('.tab-content #parent_tab').addClass('active');
      }else if(tab_s == 'lot_matrix_tab'){
        $('#myTab li:eq(3)').addClass('active');
        $('.tab-content #lot_matrix_tab').addClass('active');
      }else if(tab_s == 'vendor_tab'){
        $('#myTab li:eq(4)').addClass('active');
        $('.tab-content #vendor_tab').addClass('active');
      }else if(tab_s == 'slab_price_tab'){
        $('#myTab li:eq(5)').addClass('active');
        $('.tab-content #slab_price_tab').addClass('active');
      }
    } else {
     // no cookie

     <?php if(isset($tab_selected) && !empty($tab_selected)){?>
      $('#myTab li.active').removeClass('active');
      $('.tab-content div.tab-pane.active').removeClass('active');

      <?php if($tab_selected == 'alias_code_tab'){ ?>
        $('#myTab li:eq(1)').addClass('active');
        $('.tab-content #alias_code_tab').addClass('active');
      <?php }else if($tab_selected == 'parent_tab'){ ?>
        $('#myTab li:eq(2)').addClass('active');
        $('.tab-content #parent_tab').addClass('active');
      <?php }else if($tab_selected == 'lot_matrix_tab'){ ?>
        $('#myTab li:eq(3)').addClass('active');
        $('.tab-content #lot_matrix_tab').addClass('active');
      <?php }else if($tab_selected == 'vendor_tab'){ ?>
        $('#myTab li:eq(4)').addClass('active');
        $('.tab-content #vendor_tab').addClass('active');
      <?php }else if($tab_selected == 'slab_price_tab'){ ?>
        $('#myTab li:eq(5)').addClass('active');
        $('.tab-content #slab_price_tab').addClass('active');
      <?php }else { ?>
        $('#myTab li:eq(0)').addClass('active');
        $('.tab-content #item_tab').addClass('active');
      <?php } ?>

    <?php } ?>
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

  $(document).on('keypress keyup blur', '.slab_price_nprice,.input_npackprice', function(event) {

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

    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;

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
        var get_new_category = "<?php echo $get_new_category;?>";
        get_new_category = get_new_category.replace(/&amp;/g, '&');
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
          <form action="<?php echo $add_new_category; ?>" method="post" id="category_add_new_form">
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
                      <option value="<?php echo $Sales; ?>" selected="selected"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" ><?php echo $MISC; ?></option>
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

    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;

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
        var get_new_department = "<?php echo $get_new_department;?>";
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
          <form action="<?php echo $add_new_department; ?>" method="post" id="department_add_new_form">
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

    var sid = "<?php echo $sid;?>";
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
        var get_new_size = "<?php echo $get_new_size;?>";
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
          <form action="<?php echo $add_new_size; ?>" method="post" id="size_add_new_form">
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

    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;

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
        var get_new_group = "<?php echo $get_new_group;?>";
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
          <form action="<?php echo $add_new_group; ?>" method="post" id="group_add_new_form">
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
 
    var sid = "<?php echo $sid;?>";
    var url = $(this).attr('action')+"&sid="+sid;

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
        var get_new_supplier = "<?php echo $get_new_supplier;?>";
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
          <form action="<?php echo $add_new_supplier; ?>" method="post" id="supplier_add_new_form">
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

<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
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