<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-item" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a></div>
      <h1><?php echo $heading_title; ?></h1>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-item" class="form-horizontal">
        <ul class="nav nav-tabs responsive" id="myTab">
          <li class="active"><a href="#item_tab" data-toggle="tab">Item</a></li>
          <li><a href="#alias_code_tab" data-toggle="tab">Add Alias Code</a></li>
          <li><a href="#parent_tab" data-toggle="tab">Parent / Child</a></li>
          <li><a href="#lot_matrix_tab" data-toggle="tab">Lot Matrix</a></li>
          <li><a href="#vendor_tab" data-toggle="tab">Vendor</a></li>
          <li><a href="#slab_price_tab" data-toggle="tab">Slab Price</a></li>
        </ul>

        <div class="tab-content responsive">
          <div class="tab-pane active" id="item_tab">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-customer"><?php echo $entry_itemtype; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_itemtype; ?>" id="input-<?php echo $entry_itemtype; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6 required">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-account-number"><?php echo $entry_sku; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_sku; ?>" id="input-<?php echo $entry_sku; ?>" class="form-control"/>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-first-name"><?php echo $entry_itemname; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_itemname; ?>" id="input-<?php echo $entry_itemname; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-last-name"><?php echo $entry_description; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_description; ?>" id="input-<?php echo $entry_description; ?>" class="form-control" />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-address"><?php echo $entry_unit; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($units) && count($units) > 0){?>
                        <?php foreach($units as $unit){ ?>
                          <option value="<?php echo $unit['vunitcode'];?>"><?php echo $unit['vunitname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_supplier; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($suppliers) && count($suppliers) > 0){?>
                        <?php foreach($suppliers as $supplier){ ?>
                          <option value="<?php echo $supplier['vsuppliercode'];?>"><?php echo $supplier['vcompanyname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_deartment; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($departments) && count($departments) > 0){?>
                        <?php foreach($departments as $department){ ?>
                          <option value="<?php echo $department['vdepcode'];?>"><?php echo $department['vdepartmentname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group required">
                  <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_category; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($categories) && count($categories) > 0){?>
                        <?php foreach($categories as $category){ ?>
                          <option value="<?php echo $category['vcategorycode'];?>"><?php echo $category['vcategoryname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_size; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($sizes) && count($sizes) > 0){?>
                        <?php foreach($sizes as $size){ ?>
                          <option value="<?php echo $size['isizeid'];?>"><?php echo $size['vsize'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_groupname; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($itemGroups) && count($itemGroups) > 0){?>
                        <?php foreach($itemGroups as $itemGroup){ ?>
                          <option value="<?php echo $itemGroup['iitemgroupid'];?>"><?php echo $itemGroup['vitemgroupname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_wic_item; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
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
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_seq; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_seq; ?>" id="input-<?php echo $entry_seq; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_itemcolor; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($item_colors) && count($item_colors) > 0){?>
                        <?php foreach($item_colors as $item_color){ ?>
                          <option value="<?php echo $item_color;?>"><?php echo $item_color;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div style="border:1px solid #ccc;height:170px;">
                  <p style="margin-top:20px"><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_unitpercase; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_unitpercase; ?>" id="input-<?php echo $entry_unitpercase; ?>" class="form-control" style="width:50%;"/></p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_avg_case_cost; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_avg_case_cost; ?>" id="input-<?php echo $entry_avg_case_cost; ?>" class="form-control" style="width:50%;"/></p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_unitcost; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_unitcost; ?>" id="input-<?php echo $entry_unitcost; ?>" class="form-control" style="width:50%;"/></p>
                </div>
              </div>
              <div class="col-md-6">
                <div style="border:1px solid #ccc;height:170px;">
                  <p style="margin-top:20px"><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_sellingunit; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_sellingunit; ?>" id="input-<?php echo $entry_sellingunit; ?>" class="form-control" style="width:50%;"/></p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_sellingprice; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_sellingprice; ?>" id="input-<?php echo $entry_sellingprice; ?>" class="form-control" style="width:50%;"/></p>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_liability; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
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
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_salesitem; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
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
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_station; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <option value="">--Select Station--</option>
                      <?php if(isset($stations) && count($stations) > 0){?>
                        <?php foreach($stations as $station){ ?>
                          <option value="<?php echo $station['Id'];?>"><?php echo $station['stationname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_aisle; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <option value="">--Select Aisle--</option>
                      <?php if(isset($aisles) && count($aisles) > 0){?>
                        <?php foreach($aisles as $aisles){ ?>
                          <option value="<?php echo $aisle['Id'];?>"><?php echo $aisle['aislename'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_shelf; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <option value="">--Select Shelf--</option>
                      <?php if(isset($shelfs) && count($shelfs) > 0){?>
                        <?php foreach($shelfs as $shelf){ ?>
                          <option value="<?php echo $shelf['Id'];?>"><?php echo $shelf['shelfname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_shelving; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <option value="">--Select Shelving--</option>
                      <?php if(isset($shelvings) && count($shelvings) > 0){?>
                        <?php foreach($shelvings as $shelving){ ?>
                          <option value="<?php echo $shelving['Id'];?>"><?php echo $shelving['shelvingname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <hr>
    
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_qtyonhand; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" class="form-control" placeholder="<?php echo $entry_qtyonhand;?>"/>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_reorderpoint; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_reorderpoint; ?>" id="input-<?php echo $entry_reorderpoint; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_orderqtyupto; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_orderqtyupto; ?>" id="input-<?php echo $entry_orderqtyupto; ?>" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <p style="margin-top:20px"><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level2price; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_level2price; ?>" id="input-<?php echo $entry_level2price; ?>" class="form-control" style="width:50%;"/></p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level4price; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_level4price; ?>" id="input-<?php echo $entry_level4price; ?>" class="form-control" style="width:50%;"/></p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_inventoryitem; ?></label>
                    <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
                            <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </p>
                  <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_ageverification; ?></label>
                  <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($ageVerifications) && count($ageVerifications) > 0){?>
                        <?php foreach($ageVerifications as $ageVerification){ ?>
                          <option value="<?php echo $ageVerification['vvalue'];?>"><?php echo $ageVerification['vname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <p style="margin-top:20px"><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_level3price; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_level3price; ?>" id="input-<?php echo $entry_level3price; ?>" class="form-control" style="width:50%;"/></p>
                <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_discount; ?></label><input type="text" name="" value="" placeholder="<?php echo $entry_discount; ?>" id="input-<?php echo $entry_discount; ?>" class="form-control" style="width:50%;"/></p>
                <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_fooditem; ?></label>
                  <select name="" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
                            <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                </p>
                <p style=""><label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_taxable; ?></label>
                <span style="display:inline-block;margin-top: 8px;"><input style="display:inline-block;" type="checkbox" name="vtax1" value="Y" class="form-control" /><span style="display:inline-block;">&nbsp;&nbsp;<?php echo $entry_tax1;?></span></span>&nbsp;&nbsp;&nbsp;
                <span style="display:inline-block;margin-top: 8px;"><input style="display:inline-block;" type="checkbox" name="vtax2" value="Y" class="form-control" /><span style="display:inline-block;">&nbsp;&nbsp;<?php echo $entry_tax2;?></span></span>
                </p>
              </div>
              <div class="col-md-4">
                <img src="view/image/user-icon-profile.png" class="img-responsive" width="100" height="100" alt="" id="showImage"><br>
                <input type="file" name="itemimage" accept="image/x-png,image/gif,image/jpeg" onchange="showImages(this)">
                <p style=""><label class="control-label" for="input-phone"><?php echo $entry_show_image; ?></label>
                  <select name="vshowimage" class="form-control" style="width:50%;">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
                            <option value="<?php echo $array_y_n;?>" selected="selected"><?php echo $array_y_n;?></option>
                          <?php }else{?>
                            <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                </p>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_bottledeposit; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'No') {?>
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
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_barcodetype; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_barcodetype; ?>" id="input-<?php echo $entry_barcodetype; ?>" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_vintage; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_vintage; ?>" id="input-<?php echo $entry_vintage; ?>" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-country"><?php echo $text_discount; ?></label>
                  <div class="col-sm-8">
                    <select name="" class="form-control">
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $array_y_n){ ?>
                          <?php if($array_y_n == 'Yes') {?>
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
                <div class="form-group">
                  <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_rating; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="" value="" placeholder="<?php echo $entry_rating; ?>" id="input-<?php echo $entry_rating; ?>" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="alias_code_tab">
          ...content...
          </div>
          <div class="tab-pane" id="parent_tab">
          ...content...
          </div>
          <div class="tab-pane" id="lot_matrix_tab">
          ...content...
          </div>
          <div class="tab-pane" id="vendor_tab">
          ...content...
          </div>
          <div class="tab-pane" id="slab_price_tab">
          ...content...
          </div>
        </div>

          
        </form>
      </div>
    </div>
  </div>
  
</div>

<script type="text/javascript">
  $(document).on('change', 'input[name="vcustomername"]', function(event) {
    event.preventDefault();
    var name = $(this).val().toUpperCase();
    var new_name = name.substring(0, 3);
    var number = Math.floor(Math.random()*90000) + 10000;

    var ac_number = new_name+''+number;
    
    $('input[name="vaccountnumber"]').val(ac_number);
  });
</script>

<style type="text/css">
  #form-item .nav.nav-tabs .active a{
    background-color: #f05a28 !important; 
    color: #fff !important; 
  }

  #form-item .nav.nav-tabs li a{
    color: #595959 !important; 
  }

  #form-item .nav.nav-tabs li a:hover{
    color: #fff !important; 
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
<?php echo $footer; ?>