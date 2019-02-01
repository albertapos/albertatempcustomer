<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <input type="hidden" name="nlastcost" value="<?php echo $nlastcost ?>" />
          <div class="row">
            <div class="col-md-4">
              <div class="form-group required">
                <label class="control-label col-xs-4">Item Type :</label>
                <div class="col-xs-7">
                  <select name="vitemtype" class="form-control">
                    <option value="Kiosk" <?php ($vitemtype=='Kiosk')?'selected':''?> >Kiosk</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group required">
                <label class="control-label col-xs-4 ">Unit :</label>
                <div class="col-xs-7">
                  <select name="vunitcode" class="form-control">
                    <!--<option value="">-- Select Unit Code --</option>-->
                    <?php foreach ($units as $unit) { ?>
                    <?php if ($unit['vunitcode'] == $vunitcode) { ?>
                    <option value="<?php echo $unit['vunitcode']; ?>" selected="selected"><?php echo $unit['vunitname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $unit['vunitcode']; ?>"><?php echo $unit['vunitname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
             
              <div class="form-group required">
                <label class="control-label col-xs-4 ">Size :</label>
                <div class="col-xs-7">
                  <select name="vsize" class="form-control">
                    <option value="">-- Select Size --</option>
                    <?php foreach ($sizes as $size) { ?>
                    <?php if ($size['vsize'] == $vsize) { ?>
                    <option value="<?php echo $size['vsize']; ?>" selected="selected"><?php echo $size['vsize']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $size['vsize']; ?>"><?php echo $size['vsize']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="panel panel-default col-xs-12">
                <div class="panel-body">
                  
                  <div class="form-group">
                    <label class="control-label col-xs-6 ">Case Cost</label>
                    <div class="col-xs-6">
                      <input type="text" class="form-control" name="dcostprice" value="<?php echo $dcostprice ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-6 ">Unit Cost</label>
                    <div class="col-xs-6">
                      <input type="text" class="form-control" name="nunitcost" value="<?php echo $nunitcost ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group required">
                <label class="control-label col-xs-4 ">SKU :</label>
                <div class="col-xs-7">
                <?php if($vbarcode=="") {?>
                  <input type="text" class="form-control" name="vbarcode" id="vbarcode" value="<?php echo $vbarcode?>" onblur="checksku(this.value)">
                  <?php }else {?>
                  <input type="text" class="form-control" name="vbarcode" id="vbarcode" value="<?php echo $vbarcode?>" readonly="readonly">
                  <?php }?>
                </div>
              </div>
              
              <div class="form-group required">
                <label class="control-label col-xs-4 ">Supplier</label>
                <div class="col-xs-7">
                  <select name="vsuppliercode" class="form-control">
                    <option value="">-- Select Supplier --</option>
                    <?php foreach ($suppliers as $supplier) { ?>
                    <?php if ($supplier['vsuppliercode'] == $vsuppliercode) { ?>
                    <option value="<?php echo $supplier['vsuppliercode']; ?>" selected="selected"><?php echo $supplier['vcompanyname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $supplier['vsuppliercode']; ?>"><?php echo $supplier['vcompanyname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="control-label col-xs-4 ">Category</label>
                <div class="col-xs-7">
                  <select name="vcategorycode" class="form-control">
                    <!--<option value="">-- Select Cateory --</option>-->
                    <?php foreach ($cateorys as $cateory) { ?>
                    <?php if ($cateory['vcategorycode'] == $vcategorycode) { ?>
                    <option value="<?php echo $cateory['vcategorycode']; ?>" selected="selected"><?php echo $cateory['vcategoryname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $cateory['vcategorycode']; ?>"><?php echo $cateory['vcategoryname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="panel panel-default col-xs-12">
                <div class="panel-body">
                  <div class="form-group">
                    <label class="control-label col-xs-6 ">Selling Uint</label>
                    <div class="col-xs-6">
                      <input type="text" class="form-control" name="nsellunit" value="<?php echo $nsellunit ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-xs-6 ">Selling Price</label>
                    <div class="col-xs-6">
                      <input type="text" class="form-control" name="dunitprice" value="<?php echo $dunitprice ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div> 
               <div class="col-md-4">
               
               <div class="form-group required">
                <label class="control-label col-xs-4 ">Item Name :</label>
                <div class="col-xs-7">
                  <input type="text" class="form-control" name="vitemname" value="<?php echo $vitemname ?>">
                </div>
                <?php if ($error_itemname) { ?>
                <div class="text-danger"><?php echo $error_itemname; ?></div>
                <?php } ?>
              </div>
               <div class="form-group required">
                <label class="control-label col-xs-4 ">Department</label>
                <div class="col-xs-7">
                  <select name="vdepcode" class="form-control">
                    <!--<option value="">-- Select Dep. Code --</option>-->
                    <?php foreach ($departments as $department) { ?>
                    <?php if ($department['vdepcode'] == $vdepcode) { ?>
                    <option value="<?php echo $department['vdepcode']; ?>" selected="selected"><?php echo $department['vdepartmentname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $department['vdepcode']; ?>"><?php echo $department['vdepartmentname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="control-label col-xs-4 ">Group Name</label>
                <div class="col-xs-7">
                  <select name="iitemgroupid" class="form-control">
                    <option value="">-- Select Group --</option>
                    <?php foreach ($itemgroups as $itemgroup) { ?>
                    <?php if ($itemgroup['iitemgroupid'] == $iitemgroupid) { ?>
                    <option value="<?php echo $itemgroup['iitemgroupid']; ?>" selected="selected"><?php echo $itemgroup['vitemgroupname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $itemgroup['iitemgroupid']; ?>"><?php echo $itemgroup['vitemgroupname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              
               </div>         
          </div>
          
          <hr style="border-width:4px;border-color:#A9A9A9" >
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label col-xs-4 ">Qty On Hand</label>
                <div class="col-xs-7">
                  <input type="text" class="form-control" name="iqtyonhand" value="<?php echo $iqtyonhand ?>">
                </div>
              </div>
              
              
              <div class="form-group">
                <label class="control-label col-xs-4 ">Inventory Item</label>
                <div class="col-xs-7">
                  <select name="visinventory" class="form-control">
                    <option value="Yes"<?php if($visinventory=='Yes'){ echo 'selected'; } ?>>Yes</option>
                    <option value="No"<?php  if($visinventory=='No'){ echo 'selected'; } ?>>No</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-4 ">Age Verification</label>
                <div class="col-xs-7">
                  <select name="vageverify" class="form-control">
                    <option value="">-- Select Age --</option>
                    <?php foreach ($ages as $age) { ?>
                    <?php if ($age['vvalue'] == $vageverify) { ?>
                    <option value="<?php echo $age['vvalue']; ?>" selected="selected"><?php echo $age['vname']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $age['vvalue']; ?>"><?php echo $age['vname']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-4 ">Bottle Deposit</label>
                <div class="col-xs-7">
                  <select name="ebottledeposit" class="form-control">
                    <option value="Yes"<?php if($ebottledeposit=='Yes'){ echo 'selected'; } ?> >Yes</option>
                    <option value="No"<?php  if($ebottledeposit=='No'){ echo 'selected'; } ?>>No</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label col-xs-4 ">Re-Order point</label>
                <div class="col-xs-7">
                  <input type="text" class="form-control" name="ireorderpoint" value="<?php echo $ireorderpoint ?>">
                </div>
              </div>
              
              
              
              <div class="form-group">
                <label class="control-label col-xs-4 ">Taxable</label>
                <div class="col-xs-7">
                  <div class="col-xs-4">
                    <input type="hidden" class="form-control" name="vtax1" value="N">
                    <input type="checkbox" class="form-control" name="vtax1" value="Y"  <?php if($vtax1=='Y'){ echo"checked";}?>> Tax 1                    
                    </div>
                  <div class="col-xs-4">
                    <input type="hidden" class="form-control" name="vtax2" value="N">
                    <input type="checkbox" class="form-control" name="vtax2" value="Y" <?php if($vtax2=='Y'){ echo 'checked';}?>>Tax 2</div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-4 ">Barcode Type</label>
                <div class="col-xs-7">
                  <select name="vbarcodetype" class="form-control">
                    <option value="">-- Select Barcode -- </option>
                    <option value="Code 128" <?php if($vbarcodetype=='Code 128'){echo 'selected'; } ?> >Code 128</option>
                    <option value="Code 39" <?php if($vbarcodetype=='Code 39'){echo 'selected'; } ?>>Code 39</option>
                    <option value="Code 93" <?php if($vbarcodetype=='Code 93'){echo 'selected'; } ?>>Code 93</option>
                    <option value="UPC E" <?php if($vbarcodetype=='UPC E'){echo 'selected'; } ?>>UPC E</option>
                    <option value="EAN 8" <?php if($vbarcodetype=='EAN 8'){echo 'selected'; } ?>>EAN 8</option>
                    <option value="EAN 13" <?php if($vbarcodetype=='EAN 13'){echo 'selected'; } ?>>EAN 13</option>
                    <option value="UPC A" <?php if($vbarcodetype=='UPC A'){echo 'selected'; } ?>>UPC A</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-4 ">Discount</label>
                <div class="col-xs-7">
                  <select name="vdiscount" class="form-control">
                    <option value="Yes"<?php if($vdiscount=='Yes'){ echo 'selected'; } ?>>Yes</option>
                    <option value="No"<?php if($vdiscount=='No'){ echo 'selected'; } ?>>No</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label col-xs-4 ">Order Qty Upto</label>
                <div class="col-xs-7">
                  <input type="text" class="form-control" name="norderqtyupto" value="<?php echo $norderqtyupto ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">Images</label>
                <div class="col-md-6"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="data:image/jpeg; base64, <?php echo $itemimage; ?>"  height="150" width="150" /></a>
                  <input type="hidden" name="image" value="<?php echo $itemimage; ?>" id="input-image" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script><!--
function checksku(val)
{
	$.ajax({
		type: 'post',
		url: 'index.php?route=kiosk/items/validateSKU&token=<?php echo $token; ?>&vbarcode='+val,
		dataType: 'html',		
		success: function (json) {
			
			var data  = $.parseJSON(json);
			
			if(data.msg !='')
			{
				alert(data.msg);
			}
		}
	});
}
--></script>
<?php echo $footer; ?>