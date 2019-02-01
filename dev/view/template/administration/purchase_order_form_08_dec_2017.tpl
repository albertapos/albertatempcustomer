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
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button type="submit" form="form-vendor" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){ ?> disabled <?php } ?>><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default" id="cancel_button"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-purchase-order" class="form-horizontal">
        <?php if(isset($ipoid)){ ?>
          <input type="hidden" name="ipoid" value="<?php echo $ipoid; ?>">
        <?php } ?>
        <input type="hidden" name="receive_po" id="receive_po" value="">
          <ul class="nav nav-tabs responsive" id="myTab">
            <li class="active"><a href="#general_tab" data-toggle="tab">General</a></li>
            <li><a href="#item_tab" data-toggle="tab">Item</a></li>
          </ul>

          <div class="tab-content responsive">
            <div class="tab-pane active" id="general_tab" <?php if(isset($estatus) && $estatus == 'Close'){ ?> style="pointer-events:none;" <?php } ?> >
              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group required">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_invoice; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vinvoiceno" maxlength="50" value="<?php echo isset($vinvoiceno) ? $vinvoiceno : ''; ?>" placeholder="<?php echo $entry_invoice; ?>" id="input-<?php echo $entry_invoice; ?>" class="form-control" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group required">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_created; ?></label>
                        <div class="col-sm-8">
                          <?php 
                            if(isset($dcreatedate)){
                              $dcreatedate = DateTime::createFromFormat('Y-m-d H:i:s', $dcreatedate);
                              $dcreatedate = $dcreatedate->format('m-d-Y');
                            }
                          ?>
                          <input type="text" name="dcreatedate" value="<?php echo isset($dcreatedate) ? $dcreatedate : date('m-d-Y'); ?>" placeholder="<?php echo $entry_created; ?>" id="input-<?php echo $entry_created; ?>" class="form-control" required/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_number; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vponumber" maxlength="30" value="<?php echo isset($vponumber) ? $vponumber : ''; ?>" placeholder="<?php echo $entry_number; ?>" id="input-<?php echo $entry_number; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group required">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_received; ?></label>
                        <div class="col-sm-8">
                          <?php 
                            if(isset($dreceiveddate)){
                              $dreceiveddate = DateTime::createFromFormat('Y-m-d H:i:s', $dreceiveddate);
                              $dreceiveddate = $dreceiveddate->format('m-d-Y');
                            }
                          ?>
                          <input type="text" name="dreceiveddate" value="<?php echo isset($dreceiveddate) ? $dreceiveddate : date('m-d-Y'); ?>" placeholder="<?php echo $entry_received; ?>" id="input-<?php echo $entry_received; ?>" class="form-control" required/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_title; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vordertitle" maxlength="50" value="<?php echo isset($vordertitle) ? $vordertitle : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-<?php echo $entry_title; ?>" class="form-control" required/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_status; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="estatus" maxlength="10" value="<?php echo isset($estatus) ? $estatus : 'Open'; ?>" placeholder="<?php echo $entry_status; ?>" id="input-<?php echo $entry_status; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_order_by; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vorderby" maxlength="30" value="<?php echo isset($vorderby) ? $vorderby : ''; ?>" placeholder="<?php echo $entry_order_by; ?>" id="input-<?php echo $entry_order_by; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_confirm_by; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vconfirmby" maxlength="30" value="<?php echo isset($vconfirmby) ? $vconfirmby : ''; ?>" placeholder="<?php echo $entry_confirm_by; ?>" id="input-<?php echo $entry_confirm_by; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_notes; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vnotes" maxlength="1000" value="<?php echo isset($vnotes) ? $vnotes : ''; ?>" placeholder="<?php echo $entry_notes; ?>" id="input-<?php echo $entry_notes; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_ship_vai; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshipvia" maxlength="30" value="<?php echo isset($vshipvia) ? $vshipvia : ''; ?>" placeholder="<?php echo $entry_ship_vai; ?>" id="input-<?php echo $entry_ship_vai; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"></label>
                        <div class="col-sm-8">
                          <select <?php if(isset($ipoid)){?> disabled <?php } ?> name="" class="form-control" id="loaded_vendor">
                          <option value="">-- Select Vendor --</option>
                          <?php if(isset($vendors) && count($vendors) > 0){?>
                            <?php foreach($vendors as $vendor){?>
                              <option value="<?php echo $vendor['isupplierid']; ?>"><?php echo $vendor['vcompanyname']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr style="margin-top:0px;">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_vendor_name; ?></label>
                        <div class="col-sm-8">
                          <input type="hidden" name="vvendorid" value="<?php echo isset($vvendorid) ? $vvendorid : ''; ?>">
                          <input type="text" name="vvendorname" maxlength="50" value="<?php echo isset($vvendorname) ? $vvendorname : ''; ?>" placeholder="<?php echo $entry_vendor_name; ?>" id="input-<?php echo $entry_vendor_name; ?>" class="form-control"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_address1; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vvendoraddress1" maxlength="100" value="<?php echo isset($vvendoraddress1) ? $vvendoraddress1 : ''; ?>" placeholder="<?php echo $entry_address1; ?>" id="input-<?php echo $entry_address1; ?>" class="form-control"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_address2; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vvendoraddress2" maxlength="100" value="<?php echo isset($vvendoraddress2) ? $vvendoraddress2 : ''; ?>" placeholder="<?php echo $entry_address2; ?>" id="input-<?php echo $entry_address2; ?>" class="form-control"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_state; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vvendorstate" maxlength="20" value="<?php echo isset($vvendorstate) ? $vvendorstate : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-<?php echo $entry_state; ?>" class="form-control"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_zip; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vvendorzip" maxlength="10" value="<?php echo isset($vvendorzip) ? $vvendorzip : ''; ?>" placeholder="<?php echo $entry_zip; ?>" id="input-<?php echo $entry_zip; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vvendorphone" maxlength="20" value="<?php echo isset($vvendorphone) ? $vvendorphone : ''; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-<?php echo $entry_phone; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr style="margin-top:0px;">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_ship_to; ?></label>
                        <div class="col-sm-8">
                          <input type="hidden" name="vshpid" value="<?php echo isset($store['istoreid']) ? $store['istoreid'] : ''; ?>">
                          <input type="text" name="vshpname" maxlength="50" value="<?php echo isset($store['vstorename']) ? $store['vstorename'] : ''; ?>" placeholder="<?php echo $entry_ship_to; ?>" id="input-<?php echo $entry_ship_to; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_address1; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshpaddress1" maxlength="100" value="<?php echo isset($store['vaddress1']) ? $store['vaddress1'] : ''; ?>" placeholder="<?php echo $entry_address1; ?>" id="input-<?php echo $entry_address1; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_address2; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshpaddress2" maxlength="100" value="" placeholder="<?php echo $entry_address2; ?>" id="input-<?php echo $entry_address2; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_state; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshpstate" maxlength="20" value="<?php echo isset($store['vstate']) ? $store['vstate'] : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-<?php echo $entry_state; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_zip; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshpzip" maxlength="10" value="<?php echo isset($store['vzip']) ? $store['vzip'] : ''; ?>" placeholder="<?php echo $entry_zip; ?>" id="input-<?php echo $entry_zip; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="vshpphone" maxlength="26" value="<?php echo isset($store['vphone1']) ? $store['vphone1'] : ''; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-<?php echo $entry_phone; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4" style="margin-top:10%;">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_subtotal; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="nsubtotal" maxlength="50" value="<?php echo isset($nsubtotal) ? $nsubtotal : '0.00'; ?>" placeholder="<?php echo $entry_subtotal; ?>" id="input-<?php echo $entry_subtotal; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_tax; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="ntaxtotal" maxlength="50" value="<?php echo isset($ntaxtotal) ? $ntaxtotal : '0.00'; ?>" placeholder="<?php echo $entry_tax; ?>" id="input-<?php echo $entry_tax; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_frieght; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="nfreightcharge" maxlength="50" value="<?php echo isset($nfreightcharge) ? $nfreightcharge : '0.00'; ?>" placeholder="<?php echo $entry_frieght; ?>" id="input-<?php echo $entry_frieght; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_deposite; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="ndeposittotal" maxlength="50" value="<?php echo isset($ndeposittotal) ? $ndeposittotal : '0.00'; ?>" placeholder="<?php echo $entry_deposite; ?>" id="input-<?php echo $entry_deposite; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_return; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="nreturntotal" maxlength="50" value="<?php echo isset($nreturntotal) ? $nreturntotal : '0.00'; ?>" placeholder="<?php echo $entry_return; ?>" id="input-<?php echo $entry_return; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_discount; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="ndiscountamt" maxlength="50" value="<?php echo isset($ndiscountamt) ? $ndiscountamt : '0.00'; ?>" placeholder="<?php echo $entry_discount; ?>" id="input-<?php echo $entry_discount; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_rips; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="nripsamt" maxlength="50" value="<?php echo isset($nripsamt) ? $nripsamt : '0.00'; ?>" placeholder="<?php echo $entry_rips; ?>" id="input-<?php echo $entry_rips; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_net_total; ?></label>
                        <div class="col-sm-8">
                          <input type="text" name="nnettotal" maxlength="50" value="<?php echo isset($nnettotal) ? $nnettotal : '0.00'; ?>" placeholder="<?php echo $entry_net_total; ?>" id="input-<?php echo $entry_net_total; ?>" class="form-control" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="item_tab">
              <div class="row" <?php if(isset($estatus) && $estatus == 'Close'){ ?> style="pointer-events:none;" <?php } ?>>
                <div class="" style="display: none;">
                  <input type="text" placeholder="Add New Item" id="automplete-product" class="form-control">
                </div>
                <div class="col-md-6">
                  <button class="btn btn-info" style="border-radius:0px;" id="add_item_btn">Item History</button>&nbsp;&nbsp;
                  <button class="btn btn-danger" style="border-radius:0px;" id="remove_item_btn">Remove Item</button>&nbsp;&nbsp;
                  <button type="button" class="btn btn-success" style="border-radius:0px;<?php if(isset($estatus) && $estatus == 'Close'){ ?> background-color: #ccc;border-color: #ccc; <?php } ?>" id="save_receive_check">Save/Receive</button>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-3">
                  <input type="text" class="form-control" id="search_item_box" placeholder="Search Item...">
                </div>
                <div class="col-md-4" <?php if(isset($estatus) && $estatus == 'Close'){ ?> style="pointer-events:none;" <?php } ?>>
                  <input type="checkbox" name="update_pack_qty" value="Yes" class="form-control" id="update_pack_qty" style="display:inline-block;"> <span style="display:inline-block;font-size:14px;margin-top:12px;">&nbsp; Update pack qty in item</span>
                </div>
              </div>
              <br>
              <div class="row" <?php if(isset($estatus) && $estatus == 'Close'){ ?> style="pointer-events:none;" <?php } ?>>
                <div class="col-md-12">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_purchase_item\']').prop('checked', this.checked);" /></th>
                        <th style="width:20%;">SKU#</th>
                        <th style="width:20%;">Item Name</th>
                        <th style="width:20%;">Vendor Code</th>
                        <th style="width:10%;">Size</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">QOH</th>
                        <th class="text-right">Total Case</th>
                        <th class="text-right">Case Qty</th>
                        <th class="text-right">Total Unit</th>
                        <th class="text-right">Total Amt</th>
                        <th class="text-right">Unit Cost</th>
                        <th class="text-right">Rip Amt</th>
                      </tr>
                    </thead>
                    <tbody id="purchase_order_items">
                      <?php $total_amt = '0.0000';?>
                      <?php if(isset($items) && count($items) > 0){?>
                        <?php foreach($items as $k => $item){ 
                        $total_amt +=$item['nordextprice']; 
                        ?>
                          <tr id="tab_tr_<?php echo $item['vitemid']; ?>">
                            <td class="text-center">
                              <input type="checkbox" name="selected_purchase_item[]" value="<?php echo $item['ipodetid']; ?>"/>
                              <input type="hidden" name="selected_added_item[]" value="<?php echo $item['vitemid']; ?>"/>
                              <input type="hidden" name="items[<?php echo $k; ?>][vitemid]" value="<?php echo $item['vitemid']; ?>">
                              <input type="hidden" name="items[<?php echo $k; ?>][nordunitprice]" value="<?php echo $item['nordunitprice']; ?>">
                              <input type="hidden" name="items[<?php echo $k; ?>][vunitcode]" value="<?php echo $item['vunitcode']; ?>">
                              <input type="hidden" name="items[<?php echo $k; ?>][vunitname]" value="<?php echo $item['vunitname']; ?>">
                              <input type="hidden" name="items[<?php echo $k; ?>][ipodetid]" value="<?php echo $item['ipodetid']; ?>">
                            </td>

                            <td style="width:20%;" class="vbarcode_class">
                              <?php echo $item['vbarcode']; ?>
                              <input type="hidden" name="items[<?php echo $k; ?>][vbarcode]" value="<?php echo $item['vbarcode']; ?>">
                            </td>

                            <td style="width:20%;" class="vitemname_class">
                              <?php echo $item['vitemname']; ?>
                              <input type="hidden" name="items[<?php echo $k; ?>][vitemname]" value="<?php echo $item['vitemname']; ?>">
                            </td>

                            <?php if(!empty($item['vvendoritemcode'])){ ?>
                              <td style="width:20%;">
                              <input type="text" class="editable_text vvendoritemcode_class" name="items[<?php echo $k; ?>][vvendoritemcode]" value="<?php echo $item['vvendoritemcode']; ?>" id="" style="width:100px;">
                              </td>
                            <?php } else { ?>
                              <td style="width:20%;">
                                <input type="text" class="editable_text vvendoritemcode_class" name="items[<?php echo $k; ?>][vvendoritemcode]" value="" id="" style="width:100px;">
                              </td>
                            <?php } ?>

                            <?php if(!empty($item['vsize'])){ ?>
                              <td style="width:10%;">
                              <?php echo $item['vsize']; ?>
                              <input type="hidden" class="editable_text vsize_class" name="items[<?php echo $k; ?>][vsize]" value="<?php echo $item['vsize']; ?>" id="" >
                              </td>
                            <?php } else { ?>
                              <td style="width:10%;">
                                <input type="hidden" class="editable_text vsize_class" name="items[<?php echo $k; ?>][vsize]" value="" id="" >
                              </td>
                            <?php } ?>

                            <td class="text-right">
                              <input type="hidden" class="" name="items[<?php echo $k; ?>][dunitprice]" id="" value="<?php echo $item['dunitprice']; ?>">
                              <input type="text" class="editable_text nnewunitprice_class" name="items[<?php echo $k; ?>][dunitprice]" id="" style="width:60px;text-align: right;" value="<?php echo $item['dunitprice']; ?>">
                            </td>

                            <td class="text-right">
                              <?php echo $item['iqtyonhand'];?>
                              <input type="hidden" name="items[<?php echo $k; ?>][nitemqoh]" value="<?php echo $item['iqtyonhand'];?>">
                            </td>

                            <td class="text-right">
                              <input type="text" class="editable_text nordqty_class" name="items[<?php echo $k; ?>][nordqty]" id="" style="width:60px;text-align: right;" value="<?php echo $item['nordqty']; ?>">
                            </td>

                            <td class="text-right">
                              <input type="text" class="editable_text npackqty_class" name="items[<?php echo $k; ?>][npackqty]" value="<?php echo $item['npackqty']; ?>" id="" style="width:60px;text-align: right;">
                            </td>

                            <td class="text-right">
                            <span class="itotalunit_span_class"><?php echo $item['itotalunit']; ?></span>
                            <input type="hidden" class="editable_text itotalunit_class" name="items[<?php echo $k; ?>][itotalunit]" value="<?php echo $item['itotalunit']; ?>" id="" style="width:80px;text-align: right;">
                            </td>

                            <td class="text-right">
                              <input type="text" class="editable_text nordextprice_class" name="items[<?php echo $k; ?>][nordextprice]" value="<?php echo $item['nordextprice']; ?>" id="" style="width:80px;text-align: right;">
                            </td>

                            <td class="text-right">
                              <input type="text" class="editable_text nunitcost_class" name="items[<?php echo $k; ?>][nunitcost]" value="<?php echo $item['nunitcost']; ?>" id="" style="width:80px;text-align: right;">
                            </td>
                            <td class="text-right">
                              <input type="text" class="editable_text nripamount_class" name="items[<?php echo $k; ?>][nripamount]" value="<?php echo $item['nripamount']; ?>" id="" style="width:50px;text-align: right;">
                            </td>

                          </tr>
                        <?php } ?>
                        
                      <?php } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-right"><b>Total</b></td>
                        <td class="text-right"><b><span class="total_amount"><?php echo number_format((float)$total_amt, 4, '.', '') ;?></span></b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</div>

<div id="divLoading"></div>

<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 100;
    background-image : url('view/image/loading1.gif');
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

</style>
<?php echo $footer; ?>

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

</style>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/bootbox.min.js" defer></script>
<script>
  $(function(){
    $('input[name="dcreatedate"]').datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });

    $('input[name="dreceiveddate"]').datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

<script type="text/javascript">
  $(document).on('keyup', '#search_item_box', function(event) {
    event.preventDefault();
    
    $('#purchase_order_items tr').hide();
    var txt = $('#search_item_box').val();
    
    if(txt != ''){
      $('#purchase_order_items tr').each(function(){
        
        if($(this).find('td.vitemname_class').text().toUpperCase().indexOf(txt.toUpperCase()) != -1 || $(this).find('td.vbarcode_class').text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#purchase_order_items tr').show();
    }
  });
</script>


<script type="text/javascript">
  // $(document).on('keyup', '.nordqty_class, .npackqty_class, .itotalunit_class', function(event) {
    $('.nordqty_class, .npackqty_class, .itotalunit_class').keypress(function(event) {
      
   
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  });

  // $(document).on("keyup", 'input[name="ntaxtotal"], input[name="nfreightcharge"], input[name="ndeposittotal"], input[name="nreturntotal"], input[name="ndiscountamt"], input[name="nripsamt"], .nordextprice_class, .nunitcost_class', function(event) {

    $('input[name="ntaxtotal"], input[name="nfreightcharge"], input[name="ndeposittotal"], input[name="nreturntotal"], input[name="ndiscountamt"], input[name="nripsamt"], .nordextprice_class, .nunitcost_class,.nnewunitprice_class').keypress(function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  });   
</script>

<script src="view/javascript/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $("input[name='vvendorphone']").mask("999-999-9999");
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#select_vendor_btn', function(event) {
    event.preventDefault();
    $('#selectVendorModal').modal('show');
  });
</script>

<!-- Modal -->
<div class="modal fade" id="selectVendorModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Vendor</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Select</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    if($('input[name="vvendorname"]').val() == ''){
      $('#myTab li:eq(1)').css('pointer-events','none');
    }
  });

  $(document).on('change', '#loaded_vendor', function(event) {
    event.preventDefault();

    var get_vendor_url = '<?php echo $get_vendor; ?>';
    get_vendor_url = get_vendor_url.replace(/&amp;/g, '&');

    if($(this).val() != ''){
      get_vendor_url = get_vendor_url+'&isupplierid='+ $(this).val();
      $.getJSON(get_vendor_url, function(result){
        if(result.vendor){
          $('input[name="vvendorid"]').val(result.vendor.isupplierid);
          $('input[name="vvendorname"]').val(result.vendor.vcompanyname);
          $('input[name="vvendoraddress1"]').val(result.vendor.vaddress1);
          $('input[name="vvendorstate"]').val(result.vendor.vstate);
          $('input[name="vvendorzip"]').val(result.vendor.vzip);
          $('input[name="vvendorphone"]').val(result.vendor.vphone);

          $('#myTab li:eq(1)').css('pointer-events','all');
        }
      });

      // Get Vendor Items
      var get_vendor_item_url = '<?php echo $get_vendor_item; ?>';
      get_vendor_item_url = get_vendor_item_url.replace(/&amp;/g, '&');
      get_vendor_item_url = get_vendor_item_url+'&isupplierid='+ $(this).val();
      
      $.getJSON(get_vendor_item_url, function(datas){
        
        $('tbody#purchase_order_items tr').not(':last').empty();
        var html_purchase_item = '';
        if(datas){

          $.each(datas, function(index, item) {
            html_purchase_item += '<tr id="tab_tr_'+item.iitemid+'">';
            html_purchase_item += '<td class="text-center"><input type="checkbox" name="selected_purchase_item[]" value="0"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+item.iitemid+'"><input type="hidden" name="items['+window.index_item+'][nordunitprice]" value="'+item.dunitprice+'"><input type="hidden" name="items['+window.index_item+'][vunitcode]" value="'+item.vunitcode+'"><input type="hidden" name="items['+window.index_item+'][vunitname]" value="'+item.vunitname+'"><input type="hidden" name="items['+window.index_item+'][ipodetid]" value="0"><input type="hidden" name="selected_added_item[]" value="'+item.iitemid+'"/></td>';
            html_purchase_item += '<td style="width:20%;" class="vbarcode_class">'+item.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+item.vbarcode+'"></td>';
            html_purchase_item += '<td style="width:20%;" class="vitemname_class">'+item.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+item.vitemname+'"></td>';

            if(item.vvendoritemcode != null){
              html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="'+item.vvendoritemcode+'" id="" style="width:100px;"></td>';
            }else{
              html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="" id="" style="width:100px;"></td>';
            }

            if(item.vsize != null){
              html_purchase_item += '<td style="width:10%;">'+item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="'+item.vsize+'" id="" ></td>';
            }else{
              html_purchase_item += '<td style="width:10%;">'+item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="" id="" ></td>';
            }

            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nnewunitprice_class" name="items['+window.index_item+'][dunitprice]" id="" style="width:60px;text-align:right;" value="'+ item.dunitprice +'"></td>';
            html_purchase_item += '<td class="text-right">'+ item.iqtyonhand +'<input type="hidden" name="items['+window.index_item+'][nitemqoh]" value="'+ item.iqtyonhand +'"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordqty_class" name="items['+window.index_item+'][nordqty]" id="" style="width:60px;text-align:right;" value="'+ item.total_case_qty+'"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text npackqty_class" name="items['+window.index_item+'][npackqty]" value="'+item.case_qty+'" id="" style="width:60px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><span class="itotalunit_span_class">0</span><input type="hidden" class="editable_text itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="0" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordextprice_class" name="items['+window.index_item+'][nordextprice]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nripamount_class" name="items['+window.index_item+'][nripamount]" value="0.0000" id="" style="width:50px;text-align:right;"></td>';
            html_purchase_item += '</tr>';
            window.index_item++;
          });
        }
        $('tbody#purchase_order_items').prepend(html_purchase_item);

      });


    }else{
      $('input[name="vvendorid"]').val('');
      $('input[name="vvendorname"]').val('');
      $('input[name="vvendoraddress1"]').val('');
      $('input[name="vvendorstate"]').val('');
      $('input[name="vvendorzip"]').val('');
      $('input[name="vvendorphone"]').val('');
      $('#myTab li:eq(1)').css('pointer-events','none');
    }

  });
</script>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        <?php if(isset($items) && count($items) > 0){?>
          window.index_item = '<?php echo count($items);?>';
        <?php }else{ ?>
          window.index_item = 0;
        <?php } ?>

        <?php if(isset($items_id) && count($items_id) > 0){?>
          window.items_added = '<?php echo json_encode($items_id);?>';
          window.items_added = $.parseJSON(window.items_added);
        <?php }else{ ?>
          window.items_added = [];
        <?php } ?>
        
        var get_search_items_url = '<?php echo $get_search_items; ?>';
        get_search_items_url = get_search_items_url.replace(/&amp;/g, '&');

        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(get_search_items_url, req, function(data) {
                    var suggestions = [];
                    $.each(data.items, function(i, val) {
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            id: val.iitemid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {

                var get_search_item_url = '<?php echo $get_search_item; ?>';
                get_search_item_url = get_search_item_url.replace(/&amp;/g, '&');
                var ivendorid = $('input[name="vvendorid"]').val();

                get_search_item_url = get_search_item_url+'&iitemid='+ui.item.id+'&ivendorid='+ivendorid;

                if ($.inArray(ui.item.id, window.items_added) != -1){
                  $('#error_alias').html('<strong>Item Already Added!</strong>');
                  $('#errorModal').modal('show');
                  return false;
                }else{
                  window.items_added.push(ui.item.id);
                }

                $("div#divLoading").addClass('show');
                
                $.getJSON(get_search_item_url, function(result){
                  var html_purchase_item = '';
                  if(result.item){
                    
                      html_purchase_item += '<tr>';
                      html_purchase_item += '<td class="text-center"><input type="checkbox" name="selected_purchase_item[]" value="0"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+result.item.iitemid+'"><input type="hidden" name="items['+window.index_item+'][nordunitprice]" value="'+result.item.dunitprice+'"><input type="hidden" name="items['+window.index_item+'][vunitcode]" value="'+result.item.vunitcode+'"><input type="hidden" name="items['+window.index_item+'][vunitname]" value="'+result.item.vunitname+'"><input type="hidden" name="items['+window.index_item+'][ipodetid]" value="0"><input type="hidden" name="selected_added_item[]" value="'+result.item.iitemid+'"/></td>';
                      html_purchase_item += '<td style="width:20%;" class="vbarcode_class">'+result.item.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+result.item.vbarcode+'"></td>';
                      html_purchase_item += '<td style="width:20%;" class="vitemname_class">'+result.item.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+result.item.vitemname+'"></td>';

                      if(result.item.vvendoritemcode != null){
                        html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="'+result.item.vvendoritemcode+'" id="" style="width:100px;"></td>';
                      }else{
                        html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="" id="" style="width:100px;"></td>';
                      }

                      if(result.item.vsize != null){
                        html_purchase_item += '<td style="width:10%;">'+result.item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="'+result.item.vsize+'" id="" ></td>';
                      }else{
                        html_purchase_item += '<td style="width:10%;">'+result.item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="" id="" ></td>';
                      }

                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nnewunitprice_class" name="items['+window.index_item+'][nnewunitprice]" id="" style="width:60px;text-align:right;" value="'+ result.item.dunitprice +'"></td>';
                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordqty_class" name="items['+window.index_item+'][nordqty]" id="" style="width:60px;text-align:right;" value="0"></td>';
                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text npackqty_class" name="items['+window.index_item+'][npackqty]" value="'+result.item.npack+'" id="" style="width:60px;text-align:right;"></td>';
                      html_purchase_item += '<td class="text-right"><span class="itotalunit_span_class">0</span><input type="hidden" class="editable_text itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="0" id="" style="width:80px;text-align:right;"></td>';
                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordextprice_class" name="items['+window.index_item+'][nordextprice]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
                      html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nripamount_class" name="items['+window.index_item+'][nripamount]" value="0.0000" id="" style="width:50px;text-align:right;"></td>';
                      html_purchase_item += '</tr>';
                      window.index_item++;
                    
                  }
                  $('tbody#purchase_order_items').prepend(html_purchase_item);
                  $("div#divLoading").removeClass('show');
                });
            }
        });
    });
</script>

<script type="text/javascript">
  $(document).on('keyup', '.nordqty_class', function(event) {
    event.preventDefault();
    
    var nordqty = $(this).val();
    var npackqty = $(this).closest('tr').find('.npackqty_class').val();
    var itotalunit = $(this).closest('tr').find('.itotalunit_class').val();
    var nordextprice = $(this).closest('tr').find('.nordextprice_class').val();
    var nunitcost = $(this).closest('tr').find('.nunitcost_class').val();

    if(npackqty != ''){
      npackqty = npackqty;
    }else{
      npackqty = 0;
    }

    if(itotalunit != ''){
      itotalunit = itotalunit;
    }else{
      itotalunit = 0;
    }

    if(nordextprice != ''){
      nordextprice = nordextprice;
    }else{
      nordextprice = 0.0000;
    }

    if(nunitcost != ''){
      nunitcost = nunitcost;
    }else{
      nunitcost = 0.0000;
    }

    var closest_itotalunit = nordqty * npackqty;
    var closest_nunitcost = nordextprice / closest_itotalunit;

    if(isNaN(closest_nunitcost)) {
      closest_nunitcost = 0.0000;
    }else{
      closest_nunitcost = closest_nunitcost.toFixed(4);
    }

    var closest_nordextprice = closest_itotalunit * closest_nunitcost;

    if(isNaN(closest_nordextprice)) {
      closest_nordextprice = 0.0000;
    }else{
      closest_nordextprice = closest_nordextprice.toFixed(4);
    }

    $(this).closest('tr').find('.itotalunit_span_class').html(closest_itotalunit);
    $(this).closest('tr').find('.itotalunit_class').val(closest_itotalunit);
    $(this).closest('tr').find('.nunitcost_class').val(closest_nunitcost);
    $(this).closest('tr').find('.nordextprice_class').val(closest_nordextprice);

    var subtotal = 0.00;
    $('.nordextprice_class').each(function() {
      subtotal = parseFloat(subtotal) + parseFloat($(this).val());
    });
    $('input[name="nsubtotal"]').val(subtotal.toFixed(2));

    //net total value;
    nettotal();
    total_amount();
  });

  $(document).on('keyup', '.npackqty_class', function(event) {
    event.preventDefault();
    
    var npackqty = $(this).val();
    var nordqty = $(this).closest('tr').find('.nordqty_class').val();
    var itotalunit = $(this).closest('tr').find('.itotalunit_class').val();
    var nordextprice = $(this).closest('tr').find('.nordextprice_class').val();
    var nunitcost = $(this).closest('tr').find('.nunitcost_class').val();

    if(nordqty != ''){
      nordqty = nordqty;
    }else{
      nordqty = 0;
    }

    if(itotalunit != ''){
      itotalunit = itotalunit;
    }else{
      itotalunit = 0;
    }

    if(nordextprice != ''){
      nordextprice = nordextprice;
    }else{
      nordextprice = 0.0000;
    }

    if(nunitcost != ''){
      nunitcost = nunitcost;
    }else{
      nunitcost = 0.0000;
    }

    var closest_itotalunit = nordqty * npackqty;
    var closest_nunitcost = nordextprice / closest_itotalunit;

    if(isNaN(closest_nunitcost)) {
      closest_nunitcost = 0.0000;
    }else{
      closest_nunitcost = closest_nunitcost.toFixed(4);
    }

    var closest_nordextprice = closest_itotalunit * closest_nunitcost;

    if(isNaN(closest_nordextprice)) {
      closest_nordextprice = 0.0000;
    }else{
      closest_nordextprice = closest_nordextprice.toFixed(4);
    }

    $(this).closest('tr').find('.itotalunit_span_class').html(closest_itotalunit);
    $(this).closest('tr').find('.itotalunit_class').val(closest_itotalunit);
    $(this).closest('tr').find('.nunitcost_class').val(closest_nunitcost);
    $(this).closest('tr').find('.nordextprice_class').val(closest_nordextprice);

    var subtotal = 0.00;
    $('.nordextprice_class').each(function() {
      subtotal = parseFloat(subtotal) + parseFloat($(this).val());
    });
    $('input[name="nsubtotal"]').val(subtotal.toFixed(2));

    //net total value;
    nettotal();
    total_amount();

  });

  $(document).on('keyup', '.nordextprice_class', function(event) {
    event.preventDefault();
    
    var nordextprice = $(this).val();
    var npackqty = $(this).closest('tr').find('.npackqty_class').val();
    var nordqty = $(this).closest('tr').find('.nordqty_class').val();
    var itotalunit = $(this).closest('tr').find('.itotalunit_class').val();
    var nunitcost = $(this).closest('tr').find('.nunitcost_class').val();

    if(npackqty != ''){
      npackqty = npackqty;
    }else{
      npackqty = 0;
    }

    if(nordqty != ''){
      nordqty = nordqty;
    }else{
      nordqty = 0;
    }

    if(itotalunit != ''){
      itotalunit = itotalunit;
    }else{
      itotalunit = 0;
    }

    if(nunitcost != ''){
      nunitcost = nunitcost;
    }else{
      nunitcost = 0.0000;
    }

    if(nordextprice != ''){
      nordextprice = nordextprice;
    }else{
      nordextprice = 0.0000;
    }

    var closest_itotalunit = nordqty * npackqty;
    var closest_nunitcost = nordextprice / closest_itotalunit;

    if(isNaN(closest_nunitcost)) {
      closest_nunitcost = 0.0000;
    }else{
      closest_nunitcost = closest_nunitcost.toFixed(4);
    }

    $(this).closest('tr').find('.nunitcost_class').val(closest_nunitcost);

    var subtotal = 0.00;
    $('.nordextprice_class').each(function() {
      subtotal = parseFloat(subtotal) + parseFloat($(this).val());
    });
    $('input[name="nsubtotal"]').val(subtotal.toFixed(2));

    //net total value;
    nettotal();
    total_amount();

  });

$(document).on('keyup', '.nunitcost_class', function(event) {
    event.preventDefault();
    
    var nunitcost = $(this).val();
    var nordextprice = $(this).closest('tr').find('.nordextprice_class').val();
    var npackqty = $(this).closest('tr').find('.npackqty_class').val();
    var nordqty = $(this).closest('tr').find('.nordqty_class').val();
    var itotalunit = $(this).closest('tr').find('.itotalunit_class').val();

    if(npackqty != ''){
      npackqty = npackqty;
    }else{
      npackqty = 0;
    }

    if(nordqty != ''){
      nordqty = nordqty;
    }else{
      nordqty = 0;
    }

    if(itotalunit != ''){
      itotalunit = itotalunit;
    }else{
      itotalunit = 0;
    }

    if(nunitcost != ''){
      nunitcost = nunitcost;
    }else{
      nunitcost = 0.0000;
    }

    if(nordextprice != ''){
      nordextprice = nordextprice;
    }else{
      nordextprice = 0.0000;
    }

    var closest_itotalunit = nordqty * npackqty;
    
    var closest_nordextprice = nunitcost * closest_itotalunit;

    if(isNaN(closest_nordextprice)) {
      closest_nordextprice = 0.0000;
    }else{
      closest_nordextprice = closest_nordextprice.toFixed(4);
    }

    $(this).closest('tr').find('.nordextprice_class').val(closest_nordextprice);

    var subtotal = 0.00;
    $('.nordextprice_class').each(function() {
      subtotal = parseFloat(subtotal) + parseFloat($(this).val());
    });
    $('input[name="nsubtotal"]').val(subtotal.toFixed(2));

    //net total value;
    nettotal();
    total_amount();

  });
</script>

<script type="text/javascript">
  var nettotal = function() {
            var nsubtotal = $('input[name="nsubtotal"]').val();
            var ntaxtotal = $('input[name="ntaxtotal"]').val();
            var nfreightcharge = $('input[name="nfreightcharge"]').val();
            var ndeposittotal = $('input[name="ndeposittotal"]').val();
            var nreturntotal = $('input[name="nreturntotal"]').val();
            var ndiscountamt = $('input[name="ndiscountamt"]').val();
            var nripsamt = $('input[name="nripsamt"]').val();
            
            var nettotal = parseFloat(nsubtotal) + parseFloat(ntaxtotal) + parseFloat(nfreightcharge) + parseFloat(ndeposittotal) - parseFloat(nreturntotal) - parseFloat(ndiscountamt) - parseFloat(nripsamt);
            
            $('input[name="nnettotal"]').val(nettotal.toFixed(2));
        }

  $(document).on('keyup', 'input[name="ntaxtotal"], input[name="nfreightcharge"], input[name="ndeposittotal"], input[name="nreturntotal"], input[name="ndiscountamt"], input[name="nripsamt"]', function(event) {

      nettotal();

  });
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#form-purchase-order', function(event) {
    event.preventDefault();

    var post_url = $(this).attr('action');
    var check_invoice_number = true;
    var check_invoice_number_with_prev = true;

    if($('input[name="vinvoiceno"]').val() == ''){
      // alert('Please Enter Invoice!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Enter Invoice!", 
        callback: function(){}
      });
      $('input[name="vinvoiceno"]').focus();
      return false;
    }

    if($('input[name="dcreatedate"]').val() == ''){
      // alert('Please Select Created Date!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Created Date!", 
        callback: function(){}
      });
      $('input[name="dcreatedate"]').focus();
      return false;
    } 

    if($('input[name="dreceiveddate"]').val() == ''){
      // alert('Please Select Received Date!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Received Date!", 
        callback: function(){}
      });
      $('input[name="dreceiveddate"]').focus();
      return false;
    } 

    // if($('input[name="vordertitle"]').val() == ''){
    //   alert('Please Enter Order Title!');
    //   return false;
    // }

    if($('input[name="vvendorid"]').val() == ''){
      // alert('Please Select Vendor!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Vendor!", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');
    var data_invoice = {}
    var check_invoice_url = '<?php echo $check_invoice; ?>';
    var sid = '<?php echo $sid; ?>';
        check_invoice_url = check_invoice_url.replace(/&amp;/g, '&');
        check_invoice_url = check_invoice_url+'&sid='+sid;

    data_invoice['invoice'] = $('input[name="vinvoiceno"]').val();

    <?php if(isset($vinvoiceno)){ ?>
      var previous_invoice = '<?php echo $vinvoiceno; ?>';
      if(previous_invoice != $('input[name="vinvoiceno"]').val()){
        check_invoice_number_with_prev = true;
      }else{
        check_invoice_number_with_prev = false;
      }
    <?php } ?>

    if(check_invoice_number_with_prev == true){
      $.ajax({
        url : check_invoice_url,
        data : JSON.stringify(data_invoice),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {
          
          check_invoice_number = true;
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
          $('#errorModal').modal('show');
          check_invoice_number = false;
          $("div#divLoading").removeClass('show');
          return false;
        }
      });
    }
    
    setTimeout(function(){
      if(check_invoice_number){

        $.ajax({
            url : post_url,
            data : $('form#form-purchase-order').serialize(),
            type : 'POST',
          success: function(data_response) {
            
            $("div#divLoading").removeClass('show');
            $('#success_alias').html('<strong>'+ data_response.success +'</strong>');
            $('#successModal').modal('show');

            var purchase_order_list_url = '<?php echo $purchase_order_list; ?>';
            purchase_order_list_url = purchase_order_list_url.replace(/&amp;/g, '&');
            
            <?php if(!isset($ipoid)){?>
              setTimeout(function(){
               window.location.href = purchase_order_list_url;
              }, 3000);
            <?php }else{ ?>
              setTimeout(function(){
               window.location.reload();
              }, 3000);
            <?php } ?>
          },
          error: function(xhr) { // if error occured

            var  response_error = $.parseJSON(xhr.responseText); //decode the response array
            
            var error_show = '';

            if(response_error.error){
              error_show = response_error.error;
            }else if(response_error.validation_error){
              error_show = response_error.validation_error[0];
            }
            $("div#divLoading").removeClass('show');
            $('#error_alias').html('<strong>'+ error_show +'</strong>');
            $('#errorModal').modal('show');
            return false;
          }
        });
      }
     
    
    }, 3000);
  });
</script>

<!-- Modal -->
  <div class="modal fade" id="successModal" role="dialog">
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
  <div class="modal fade" id="errorModal" role="dialog" style="z-index: 9999;">
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
  
  <style type="text/css">
  .editable_text {
    color: #000;
    border: none;
    background: none;
    cursor: pointer;
}</style>
<script type="text/javascript">
$('.editable_text').focus(function() {
  $(this).addClass("focusField");   
    if (this.value == this.defaultValue){
      this.select();
    }
    if(this.value != this.defaultValue){
      this.select();
    }
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#remove_item_btn', function(event) {
    event.preventDefault();
   
    var delete_purchase_order_item_url = '<?php echo $delete_purchase_order_item; ?>';
    var sid = '<?php echo $sid; ?>';
        delete_purchase_order_item_url = delete_purchase_order_item_url.replace(/&amp;/g, '&');
        delete_purchase_order_item_url = delete_purchase_order_item_url+'&sid='+sid;

        var data_delete_items = {};
        var data_selected_added_item = {};

        if($("input[name='selected_purchase_item[]']:checked").length == 0){
          $('#error_alias').html('<strong>Please Select Items to Delete!</strong>');
          $('#errorModal').modal('show');
          return false;
        }

        $("div#divLoading").addClass('show');

        $("input[name='selected_purchase_item[]']:checked").each(function (i)
        {
          data_delete_items[i] = parseInt($(this).val());
          data_selected_added_item[i] = $(this).next('input[type="hidden"]').val();
        });

        $.ajax({
        url : delete_purchase_order_item_url,
        data : JSON.stringify(data_delete_items),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {

          $.each(data_selected_added_item, function (i, selected_item){
            $('#tab_tr_'+selected_item).fadeOut(400, function(){ $(this).remove();});
          });

          $("div#divLoading").removeClass('show');
          $('#success_alias').html('<strong>'+ data.success +'</strong>');
          $('#successModal').modal('show');

          setTimeout(function(){
            $('#successModal').modal('hide');
          }, 3000);

          return false;

          // setTimeout(function(){
          //   window.location.reload();
          // }, 3000);
        },
        error: function(xhr) { // if error occured
          var  response_error = $.parseJSON(xhr.responseText); //decode the response array
          
          var error_show = '';

          if(response_error.error){
            error_show = response_error.error;
          }else if(response_error.validation_error){
            error_show = response_error.validation_error[0];
          }
          $("div#divLoading").removeClass('show');
          $('#error_alias').html('<strong>'+ error_show +'</strong>');
          $('#errorModal').modal('show');
          return false;
        }
      });

  });
</script>

<div class="modal fade" id="saveReceiveModal" role="dialog" style="z-index: 9999;">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <h4>To Send this PO to Warehouse Please click on "Send to Warehouse", receive PO to Store Click on "Receive to Store"</h4>
        </div>
      </div>
      <div class="modal-footer" style="border-top:none;">
        <input type="button" class="btn btn-success" id="save_receive_btn" value="Receive to Store">
        <input type="button" class="btn btn-success" id="save_receive_btn_to_warehouse" value="Send to Warehouse">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click', '#save_receive_check', function(event) {
    event.preventDefault();
    var check_save_receive = true;
    $('tbody#purchase_order_items tr').find('td').css('background-color','#fff');

    $('tbody#purchase_order_items tr').not(':last').each(function() {
      var current_nnewunitprice = parseFloat($(this).find('.nnewunitprice_class').val());
      var current_nunitcost = parseFloat($(this).find('.nunitcost_class').val());
      
      if(current_nnewunitprice < current_nunitcost){
        check_save_receive = false;
        $(this).find('td').css('background-color','#f0ad4e');
        // alert('price required more then unit cost');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "price required more then unit cost", 
          callback: function(){}
        });
        return false;
      }
    });
   
    if(check_save_receive){
      if($('tbody#purchase_order_items tr').length == 0){
        // alert('Please add items');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please add items", 
          callback: function(){}
        });
        return false;
      }else{
        $('#saveReceiveModal').modal('show');
      }
    } 

  });


  $(document).on('click', '#save_receive_btn', function(event) {
    event.preventDefault();
    $('#receive_po').val('receivetostore');
    $("div#divLoading").addClass('show');
    $('#saveReceiveModal').modal('hide');
    var save_receive_item_url = '<?php echo $save_receive_item; ?>';
   
    save_receive_item_url = save_receive_item_url.replace(/&amp;/g, '&');

    $.ajax({
      url : save_receive_item_url,
      data : $('form#form-purchase-order').serialize(),
      type : 'POST',
      success: function(data) {
        $('#saveReceiveModal').modal('hide');
        $("div#divLoading").removeClass('show');
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#successModal').modal('show');

        var purchase_order_list_url = '<?php echo $purchase_order_list; ?>';
        purchase_order_list_url = purchase_order_list_url.replace(/&amp;/g, '&');
        
        <?php if(!isset($ipoid)){?>
          setTimeout(function(){
           window.location.href = purchase_order_list_url;
          }, 3000);
        <?php }else{ ?>
          setTimeout(function(){
           window.location.reload();
          }, 3000);
        <?php } ?>
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }
        $('#saveReceiveModal').modal('hide');
        $("div#divLoading").removeClass('show');
        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });

  });

  $(document).on('click', '#save_receive_btn_to_warehouse', function(event) {
    event.preventDefault();
    $('#receive_po').val('POtoWarehouse');
    var save_receive_item_url = '<?php echo $save_receive_item; ?>';
   
    save_receive_item_url = save_receive_item_url.replace(/&amp;/g, '&');

    //check warehouse invoice
    var check_warehouse_invoice_url = '<?php echo $check_warehouse_invoice; ?>';

    var transfer_vinvnum = $('input[name="vinvoiceno"]').val();
    
    check_warehouse_invoice_url = check_warehouse_invoice_url.replace(/&amp;/g, '&');
    $('#saveReceiveModal').modal('hide');

    $.ajax({
    url : check_warehouse_invoice_url,
    data : { invoice : transfer_vinvnum },
    dataType: 'json',
    type : 'POST',
    success: function(data) {
      if(data.error){
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Invoice Already Exist!", 
          callback: function(){
            $('#saveReceiveModal').modal('show');
          }
        });
        return false;
      }else{

        $("div#divLoading").addClass('show');
        $('#saveReceiveModal').modal('hide');

        $.ajax({
          url : save_receive_item_url,
          data : $('form#form-purchase-order').serialize(),
          type : 'POST',
          success: function(data) {
            
            $('#saveReceiveModal').modal('hide');
            $("div#divLoading").removeClass('show');
            $('#success_alias').html('<strong>'+ data.success +'</strong>');
            $('#successModal').modal('show');

            var purchase_order_list_url = '<?php echo $purchase_order_list; ?>';
            purchase_order_list_url = purchase_order_list_url.replace(/&amp;/g, '&');
            
            <?php if(!isset($ipoid)){?>
              setTimeout(function(){
               window.location.href = purchase_order_list_url;
              }, 3000);
            <?php }else{ ?>
              setTimeout(function(){
               window.location.reload();
              }, 3000);
            <?php } ?>
          },
          error: function(xhr) { // if error occured
            var  response_error = $.parseJSON(xhr.responseText); //decode the response array
            
            var error_show = '';

            if(response_error.error){
              error_show = response_error.error;
            }else if(response_error.validation_error){
              error_show = response_error.validation_error[0];
            }
            $('#saveReceiveModal').modal('hide');
            $("div#divLoading").removeClass('show');
            $('#error_alias').html('<strong>'+ error_show +'</strong>');
            $('#errorModal').modal('show');
            return false;
          }
        });
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
    }
  });
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    if ((!!$.cookie('tab_selected_po')) && ($.cookie('tab_selected_po') != '')) {
      var tab_s = $.cookie('tab_selected_po');

      $('#myTab li.active').removeClass('active');
      $('.tab-content div.tab-pane.active').removeClass('active');

      if(tab_s == 'item_tab'){
        $('#myTab li:eq(1)').addClass('active');
        $('.tab-content #item_tab').addClass('active');
      }else{
        $('#myTab li:eq(0)').addClass('active');
        $('.tab-content #general_tab').addClass('active');
      }
    }
  });

  $(document).on('click', '#myTab li a', function() {
    
    if($(this).attr('href') == '#item_tab'){
      $.cookie("tab_selected_po", 'item_tab'); //set cookie tab
    }else{
      $.cookie("tab_selected_po", 'general_tab'); //set cookie tab
    }
    
  });

  $(document).on('click', '#cancel_button, #menu li a, .breadcrumb li a', function() {
    $.cookie("tab_selected_po", ''); //set cookie tab
  });
</script>

<script type="text/javascript">
  function total_amount(){
    var tot_amt = 0.0000;
    $(".nordextprice_class").each(function(){
      tot_amt = parseFloat(tot_amt) + parseFloat($(this).val());
    });
    $('span.total_amount').html(parseFloat(tot_amt).toFixed(4));
  }
</script>
<style type="text/css">
  .sortable{
    cursor: pointer;
  }
</style>
<!-- Modal -->
<div id="myAddItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom: 2px;padding-top: 3px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Items</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="search_item_history" class="form-control" id="search_item_history" placeholder="search item...">
          </div>
          <div class="col-md-1 text-center">
           <p style="margin-top:9px;"><b>OR</b></p> 
          </div>
          <div class="col-md-4">
            <input type="text" name="search_vendor_item_code" class="form-control" id="search_vendor_item_code" placeholder="search Vendor Item Code...">
          </div>
          <div class="col-md-3">
            <button class="btn btn-success" id="add_selected_items">Add to PO</button>
          </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" style="height: 250px;">
              <table class="table table-bordered" id="table_history_items">
                <thead>
                  <tr>
                    <th style="width:1px;"><input type="checkbox" name="" id="head_checkbox"></th>
                    <th class="sortable">SKU</th>
                    <th class="sortable">Name</th>
                    <th class="sortable">Size</th>
                    <th class="sortable text-right">QOH</th>
                    <th class="sortable text-right">Cost</th>
                    <th class="sortable text-right">Price</th>
                    <th style="width:10%; ">Action</th>
                  </tr>
                </thead>
                <tbody id="history_items">
                  
                </tbody>
              </table>
              <div class="text-center" id="rotating_logo">
                <img src="view/image/loading1.gif" alt="">
              </div>
              <div class="alert alert-info text-center" id="item_history_err_div">
                <strong id="item_history_err">Sorry no data found!</strong>
              </div>
            </div>
          </div>
        </div>
        
        <hr style="border-top: 2px solid #808080;">
        <div id="item_history_section">
          <div class="row">
            <div class="col-md-2">
              <h4 class="text-left"><b>Item History :</b></h4>
            </div>
            <div class="col-md-10">
              <input type="radio" name="radio_search_by" value="pre_week" checked>&nbsp; Previous Week&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio_search_by" value="pre_month">&nbsp;Previous Month&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio_search_by" value="pre_quarter">&nbsp; Previous Quarter&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio_search_by" value="pre_year">&nbsp; Previous Year&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="radio_search_by" value="pre_ytd">&nbsp; YTD
            </div>
          </div>
          <p></p>
          <div class="row">
            <div class="col-md-12">
              <p>
                <span><b>Name: </b></span><span id="item_history_vitemname"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Items Sold: </b></span><span id="item_history_items_sold"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span><b>Average Selling Price: </b></span><span id="item_history_average_selling_price"></span>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive" style="height: 250px;">
                <table class="table table-bordered" id="table_show_item_history">
                  <thead>
                    <tr>
                      <th class="text-left">Purchase Date</th>
                      <th class="text-right">Quantity</th>
                      <th class="text-right">Cost Price</th>
                      <th class="text-right">Item Cost</th>
                      <th>Vendor</th>
                    </tr>
                  </thead>
                  <tbody id="show_item_history">
                    
                  </tbody>
                </table>
                <div class="text-center" id="rotating_logo_item_history">
                  <img src="view/image/loading1.gif" alt="">
                </div>
                <div class="alert alert-info text-center" id="below_item_history_err_div">
                  <strong>Sorry no data found!</strong>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  $(document).on('click', '#add_item_btn', function(event) {
    event.preventDefault();
    $('#myAddItemModal').modal('show');
    $('#item_history_err_div').show();
    $('#rotating_logo').hide();
    $('tbody#history_items').empty();
    $('#search_item_history').val('');
    $('#search_vendor_item_code').val('');
    $('#search_item_history').focus();

    $('#rotating_logo_item_history').hide();
    $('#item_history_section').hide();
  });

  $(document).on('keyup', '#search_item_history', function(event) {
    $('tbody#history_items').empty();
    $('#item_history_err_div').hide();
    $('#rotating_logo').show();
    var search_item_history_url = '<?php echo $get_search_item_history; ?>';
    var item_search = $(this).val();
    var ivendorid = $('input[name="vvendorid"]').val();
    search_item_history_url = search_item_history_url.replace(/&amp;/g, '&');

    $('#item_history_section').hide();
    $('#rotating_logo_item_history').hide();
    
    if(item_search != ''){
      var pre_items_id = {};
      $('tbody#purchase_order_items > tr').not(':last').each(function(index_val, val) {
        pre_items_id[index_val] = $('input[name^="items['+index_val+'][vitemid]"]').val();
      });

      $.ajax({
        url : search_item_history_url+'&search_item='+item_search+'&ivendorid='+ivendorid,
        data : JSON.stringify(pre_items_id),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {
          $('tbody#history_items').empty();
          if(data.items.length > 0){
            
            var search_table_html = '';
            $.each(data.items, function(i, value) {
              
              search_table_html += '<tr>';
              search_table_html += '<td><input type="checkbox" name="selected_search_history_items[]" value="'+ value.iitemid +'"></td>';
              search_table_html += '<td>';
              search_table_html += value.vbarcode;
              search_table_html += '</td>';
              search_table_html += '<td>';
              search_table_html += value.vitemname;
              search_table_html += '</td>';
              search_table_html += '<td>';
              if(value.vsize != null){
                search_table_html += value.vsize;
              }else{
                search_table_html += '';
              }
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.QOH;
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.dcostprice;
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.dunitprice;
              search_table_html += '</td>';
              search_table_html += '<td>';
              search_table_html += '<button data-vitemcode="'+ value.vitemcode +'" data-vitemname="'+ value.vitemname +'" data-iitemid="'+ value.iitemid +'" class="btn btn-info btn-sm item_history_btn">Item History</button>';
              search_table_html += '</td>';

              search_table_html += '</tr>';
                
            });

            $('tbody#history_items').append(search_table_html).show('slow');
            $('#rotating_logo').hide();
            return false;
            
          }else{
            $('tbody#history_items').empty();
            $('#rotating_logo').hide();
            $('#item_history_err_div').show();
            $('#item_history_err').html('Sorry no data found! please search again');
            return false;
          }
        },
        error: function(xhr) { // if error occured
          $('#rotating_logo').hide();
          var  response_error = $.parseJSON(xhr.responseText); //decode the response array
          
          var error_show = '';

          if(response_error.error){
            error_show = response_error.error;
          }else if(response_error.validation_error){
            error_show = response_error.validation_error[0];
          }

          // alert(error_show);
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: error_show, 
            callback: function(){}
          });
          return false;
        }
      });
    }else{
      $('#rotating_logo').hide();
      $('tbody#history_items').empty();
      $('#item_history_err_div').show();
      $('#item_history_err').html('Sorry no data found! please search again');
      return false;
    }

  });

  $(document).on('keyup', '#search_vendor_item_code', function(event) {
    $('tbody#history_items').empty();
    $('#item_history_err_div').hide();
    $('#rotating_logo').show();
    var search_vendor_item_code_url = '<?php echo $search_vendor_item_code; ?>';
    var item_search = $(this).val();
    var ivendorid = $('input[name="vvendorid"]').val();
    search_vendor_item_code_url = search_vendor_item_code_url.replace(/&amp;/g, '&');

    $('#item_history_section').hide();
    $('#rotating_logo_item_history').hide();
    
    if(item_search != ''){
      var pre_items_id = {};
      $('tbody#purchase_order_items > tr').not(':last').each(function(index_val, val) {
        pre_items_id[index_val] = $('input[name^="items['+index_val+'][vitemid]"]').val();
      });

      $.ajax({
        url : search_vendor_item_code_url+'&search_item='+item_search+'&ivendorid='+ivendorid,
        data : JSON.stringify(pre_items_id),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {
          $('tbody#history_items').empty();
          if(data.items.length > 0){
            
            var search_table_html = '';
            $.each(data.items, function(i, value) {
              
              search_table_html += '<tr>';
              search_table_html += '<td><input type="checkbox" name="selected_search_history_items[]" value="'+ value.iitemid +'"></td>';
              search_table_html += '<td>';
              search_table_html += value.vbarcode;
              search_table_html += '</td>';
              search_table_html += '<td>';
              search_table_html += value.vitemname;
              search_table_html += '</td>';
              search_table_html += '<td>';
              if(value.vsize != null){
                search_table_html += value.vsize;
              }else{
                search_table_html += '';
              }
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.QOH;
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.dcostprice;
              search_table_html += '</td>';
              search_table_html += '<td class="text-right">';
              search_table_html += value.dunitprice;
              search_table_html += '</td>';
              search_table_html += '<td>';
              search_table_html += '<button data-vitemcode="'+ value.vitemcode +'" data-vitemname="'+ value.vitemname +'" data-iitemid="'+ value.iitemid +'" class="btn btn-info btn-sm item_history_btn">Item History</button>';
              search_table_html += '</td>';

              search_table_html += '</tr>';
                
            });

            $('tbody#history_items').append(search_table_html).show('slow');
            $('#rotating_logo').hide();
            return false;
            
          }else{
            $('tbody#history_items').empty();
            $('#rotating_logo').hide();
            $('#item_history_err_div').show();
            $('#item_history_err').html('Sorry no data found! please search again');
            return false;
          }
        },
        error: function(xhr) { // if error occured
          $('#rotating_logo').hide();
          var  response_error = $.parseJSON(xhr.responseText); //decode the response array
          
          var error_show = '';

          if(response_error.error){
            error_show = response_error.error;
          }else if(response_error.validation_error){
            error_show = response_error.validation_error[0];
          }

          // alert(error_show);
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: error_show, 
            callback: function(){}
          });
          return false;
        }
      });
    }else{
      $('#rotating_logo').hide();
      $('tbody#history_items').empty();
      $('#item_history_err_div').show();
      $('#item_history_err').html('Sorry no data found! please search again');
      return false;
    }

  });

  function OrderBy(a,b,n) {
    if (n) return a-b;
    if (a < b) return -1;
    if (a > b) return 1;
    return 0;
  }

  $(".sortable").click(function(){
    var $th = $(this).closest('th');
    $th.toggleClass('selected');
    var isSelected = $th.hasClass('selected');
    var isInput= $th.hasClass('input');
    var column = $th.index();
    var $table = $th.closest('table');
    var isNum= $table.find('tbody > tr').children('td').eq(column).hasClass('num');
    var rows = $table.find('tbody > tr').get();
    rows.sort(function(rowA,rowB) {
        if (isInput) {
            var keyA = $(rowA).children('td').eq(column).children('input').val().toUpperCase();
            var keyB = $(rowB).children('td').eq(column).children('input').val().toUpperCase();
        } else {
            var keyA = $(rowA).children('td').eq(column).text().toUpperCase();
            var keyB = $(rowB).children('td').eq(column).text().toUpperCase();
        }
        if (isSelected) return OrderBy(keyA,keyB,isNum);
        return OrderBy(keyB,keyA,isNum);
    });
    $.each(rows, function(index,row) {
        $table.children('tbody').append(row);
    });
    return false;
  });

  $(document).on('click', '#head_checkbox', function(event) {

    if ($(this).prop('checked')==true){ 
      $('input[name="selected_search_history_items[]"]').prop('checked',true);
    }else{
      $('input[name="selected_search_history_items[]"]').prop('checked',false);
    }

  });

  $(document).on('click', '#add_selected_items', function(event) {
    event.preventDefault();
    
      var add_purchase_order_item_url = '<?php echo $add_purchase_order_item; ?>';
      var sid = '<?php echo $sid; ?>';
      add_purchase_order_item_url = add_purchase_order_item_url.replace(/&amp;/g, '&');
      add_purchase_order_item_url = add_purchase_order_item_url+'&sid='+sid;

      var data_add_items = {};
      var ivendorid = $('input[name="vvendorid"]').val();

      if($("input[name='selected_search_history_items[]']:checked").length == 0){
        $('#error_alias').html('<strong>Please Select Items to Add!</strong>');
        $('#errorModal').modal('show');
        return false;
      }

      $("div#divLoading").addClass('show');
      $('#myAddItemModal').modal('hide');

      $("input[name='selected_search_history_items[]']:checked").each(function (i)
      {
        data_add_items[i] = parseInt($(this).val());
      });

      var pre_items_id = {};
      $('tbody#purchase_order_items > tr').not(':last').each(function(index_val, val) {
        pre_items_id[index_val] = $('input[name^="items['+index_val+'][vitemid]"]').val();
      });

      var send_post_data = {};
      send_post_data['items_id'] = data_add_items;
      send_post_data['pre_items_id'] = pre_items_id;
      send_post_data['ivendorid'] = ivendorid;

      $.ajax({
      url : add_purchase_order_item_url,
      data : JSON.stringify(send_post_data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
      success: function(result) {

        var html_purchase_item = '';
        if(result.items){
          $.each(result.items, function(index, item) {
            html_purchase_item += '<tr id="tab_tr_'+item.iitemid+'">';
            html_purchase_item += '<td class="text-center"><input type="checkbox" name="selected_purchase_item[]" value="0"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+item.iitemid+'"><input type="hidden" name="items['+window.index_item+'][nordunitprice]" value="'+item.dunitprice+'"><input type="hidden" name="items['+window.index_item+'][vunitcode]" value="'+item.vunitcode+'"><input type="hidden" name="items['+window.index_item+'][vunitname]" value="'+item.vunitname+'"><input type="hidden" name="items['+window.index_item+'][ipodetid]" value="0"><input type="hidden" name="selected_added_item[]" value="'+item.iitemid+'"/></td>';
            html_purchase_item += '<td style="width:20%;" class="vbarcode_class">'+item.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+item.vbarcode+'"></td>';
            html_purchase_item += '<td style="width:20%;" class="vitemname_class">'+item.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+item.vitemname+'"></td>';

            if(item.vvendoritemcode != null){
              html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="'+item.vvendoritemcode+'" id="" style="width:100px;"></td>';
            }else{
              html_purchase_item += '<td style="width:20%;"><input type="text" class="editable_text vvendoritemcode_class" name="items['+window.index_item+'][vvendoritemcode]" value="" id="" style="width:100px;"></td>';
            }

            if(item.vsize != null){
              html_purchase_item += '<td style="width:10%;">'+item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="'+item.vsize+'" id="" ></td>';
            }else{
              html_purchase_item += '<td style="width:10%;">'+item.vsize+'<input type="hidden" class="editable_text vsize_class" name="items['+window.index_item+'][vsize]" value="" id="" ></td>';
            }

            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nnewunitprice_class" name="items['+window.index_item+'][dunitprice]" id="" style="width:60px;text-align:right;" value="'+ item.dunitprice +'"></td>';
            html_purchase_item += '<td class="text-right">'+ item.iqtyonhand +'<input type="hidden" name="items['+window.index_item+'][nitemqoh]" value="'+ item.iqtyonhand +'"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordqty_class" name="items['+window.index_item+'][nordqty]" id="" style="width:60px;text-align:right;" value="'+ item.total_case_qty+'"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text npackqty_class" name="items['+window.index_item+'][npackqty]" value="'+item.case_qty+'" id="" style="width:60px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><span class="itotalunit_span_class">0</span><input type="hidden" class="editable_text itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="0" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nordextprice_class" name="items['+window.index_item+'][nordextprice]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="0.0000" id="" style="width:80px;text-align:right;"></td>';
            html_purchase_item += '<td class="text-right"><input type="text" class="editable_text nripamount_class" name="items['+window.index_item+'][nripamount]" value="0.0000" id="" style="width:50px;text-align:right;"></td>';
            html_purchase_item += '</tr>';
            window.index_item++;
          });
        }
        $('tbody#purchase_order_items').prepend(html_purchase_item);
        $("div#divLoading").removeClass('show');
        $('#success_alias').html('<strong>Items Added Successfully</strong>');
        $('#successModal').modal('show');
        setTimeout(function(){
         $('#successModal').modal('hide');
        }, 3000);
        return false;
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }
        
        $("div#divLoading").removeClass('show');
        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });
  });
</script>

<script type="text/javascript">
  $(document).on('click', '.item_history_btn', function(event) {
    event.preventDefault();
    var get_item_history_url = '<?php echo $get_item_history; ?>';
    get_item_history_url = get_item_history_url.replace(/&amp;/g, '&');

    window.iitemid = $(this).attr('data-iitemid');
    window.vitemcode = $(this).attr('data-vitemcode');
    window.vitemname = $(this).attr('data-vitemname');

    var radio_search_by = $('input[name=radio_search_by]:checked').val();

    // $("input[name=radio_search_by][value=pre_week]").prop('checked', true);

    get_item_history_url = get_item_history_url+'&iitemid='+ window.iitemid +'&vitemcode='+ window.vitemcode +'&radio_search_by='+radio_search_by;
    
    $('#item_history_section').show();
    $('#rotating_logo_item_history').show();
    $('#below_item_history_err_div').hide();
    $('tbody#show_item_history').empty();

    $.ajax({
      url : get_item_history_url,
      type : 'GET',
      success: function(result) {
        $('tbody#show_item_history').empty();

        if(result.item_detail){
          $('span#item_history_vitemname').html(window.vitemname);
          $('span#item_history_items_sold').html(parseInt(result.item_detail.items_sold));
          var total_selling_price1 = parseFloat(result.item_detail.total_selling_price);
          var items_sold1 = parseInt(result.item_detail.items_sold);

          if(total_selling_price1 == 0){
            var dis_average_selling_price = 0.00;
          }else{
            var dis_average_selling_price = total_selling_price1 / items_sold1;
          }
          
          $('span#item_history_average_selling_price').html('$'+dis_average_selling_price.toFixed(2));
        }

        if(result.purchase_items){
          var item_history_html = '';
          if(radio_search_by == 'pre_ytd'){
            $.each(result.purchase_items, function(i, item) {

              // item_history_html += '<tr>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '<b>'+i+'</b>';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '</tr>';

              $.each(item, function(index, purchase_item) {
                item_history_html += '<tr>';
                item_history_html += '<td>';
                item_history_html += purchase_item.purchase_date;
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += purchase_item.total_quantity;
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += purchase_item.total_cost_price;
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += purchase_item.nunitcost;
                item_history_html += '</td>';
                item_history_html += '<td>';
                item_history_html += purchase_item.vvendorname;
                item_history_html += '</td>';
                item_history_html += '</tr>';
              });
            });
          }else{
            $.each(result.purchase_items, function(index, purchase_item) {
              item_history_html += '<tr>';
              item_history_html += '<td>';
              item_history_html += purchase_item.purchase_date;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.total_quantity;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.total_cost_price;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.nunitcost;
              item_history_html += '</td>';
              item_history_html += '<td>';
              item_history_html += purchase_item.vvendorname;
              item_history_html += '</td>';
              item_history_html += '</tr>';
            });
          }

          if(item_history_html == ''){
            $('#rotating_logo_item_history').hide();
            $('#below_item_history_err_div').show();
          }
          $('tbody#show_item_history').append(item_history_html);
          $('#rotating_logo_item_history').hide();

        }else{
          $('#rotating_logo_item_history').hide();
          $('#below_item_history_err_div').show();
        }

        return false;
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }
        
        $("div#divLoading").removeClass('show');
        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });
  });

  $(document).on('change', 'input[name="radio_search_by"]', function(event) {
    event.preventDefault();

    var get_item_history_url = '<?php echo $get_item_history; ?>';
    get_item_history_url = get_item_history_url.replace(/&amp;/g, '&');
    var radio_search_by = $(this).val();

    get_item_history_url = get_item_history_url+'&iitemid='+ window.iitemid +'&vitemcode='+ window.vitemcode +'&radio_search_by='+radio_search_by;
    
    $('#item_history_section').show();
    $('#rotating_logo_item_history').show();
    $('#below_item_history_err_div').hide();
    $('tbody#show_item_history').empty();

    $.ajax({
      url : get_item_history_url,
      type : 'GET',
      success: function(result) {
        
        $('tbody#show_item_history').empty();

        if(result.item_detail){
          $('span#item_history_vitemname').html(window.vitemname);
          $('span#item_history_items_sold').html(parseInt(result.item_detail.items_sold));
          
          var total_selling_price1 = parseFloat(result.item_detail.total_selling_price);
          var items_sold1 = parseInt(result.item_detail.items_sold);
          
          if(total_selling_price1 == 0){
            var dis_average_selling_price = 0.00;
          }else{
            var dis_average_selling_price = total_selling_price1 / items_sold1;
          }

          $('span#item_history_average_selling_price').html('$'+dis_average_selling_price.toFixed(2));
        }
        if(result.purchase_items){
          var item_history_html = '';
          if(radio_search_by == 'pre_ytd'){
            $.each(result.purchase_items, function(i, item) {

              // item_history_html += '<tr>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '<b>'+i+'</b>';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '<td style="border:none;">';
              // item_history_html += '&nbsp;';
              // item_history_html += '</td>';
              // item_history_html += '</tr>';

              $.each(item, function(index, purchase_item) {
                item_history_html += '<tr>';
                item_history_html += '<td>';
                item_history_html += purchase_item.purchase_date;
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += purchase_item.total_quantity;
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += parseFloat(purchase_item.total_cost_price).toFixed(2);
                item_history_html += '</td>';
                item_history_html += '<td class="text-right">';
                item_history_html += parseFloat(purchase_item.nunitcost).toFixed(2);
                item_history_html += '</td>';
                item_history_html += '<td>';
                item_history_html += purchase_item.vvendorname;
                item_history_html += '</td>';
                item_history_html += '</tr>';
              });
            });
          }else{
            $.each(result.purchase_items, function(index, purchase_item) {
              item_history_html += '<tr>';
              item_history_html += '<td>';
              item_history_html += purchase_item.purchase_date;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.total_quantity;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.total_cost_price;
              item_history_html += '</td>';
              item_history_html += '<td class="text-right">';
              item_history_html += purchase_item.nunitcost;
              item_history_html += '</td>';
              item_history_html += '<td>';
              item_history_html += purchase_item.vvendorname;
              item_history_html += '</td>';
              item_history_html += '</tr>';
            });
          }

          if(item_history_html == ''){
            $('#rotating_logo_item_history').hide();
            $('#below_item_history_err_div').show();
          }
          $('tbody#show_item_history').append(item_history_html);
          $('#rotating_logo_item_history').hide();

        }else{
          $('#rotating_logo_item_history').hide();
          $('#below_item_history_err_div').show();
        }

        return false;
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }
        
        $("div#divLoading").removeClass('show');
        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });

  });
</script>