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
        <div class="modal fade" id="selectvendormodel" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-mg">
            <div class="modal-content">
              <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="cartLabel">Select Vendor</h4>
              </div>
              <div class="modal-body">
                <table class="table table-bordered table-hover" id="items-list">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                      <td class="text-left">Vendor Name</td>
                      <td class="text-left">Address</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($vendors) { ?>
                    <?php foreach ($vendors as $vendor) { ?>
                    <tr>
                      <td class="text-center"><?php if (in_array($vendor['vsuppliercode'], $venselected)) { ?>
                        <input type="checkbox" name="venselected[]" value="<?php echo $vendor['vsuppliercode']; ?>" checked="checked" />
                        <?php } else { ?>
                        <input type="checkbox" name="venselected[]" value="<?php echo $vendor['vsuppliercode']; ?>" />
                        <?php } ?></td>
                      <td class="text-left"><?php echo $vendor['vcompanyname']; ?></td>
                      <td class="text-left"><?php echo $vendor['vaddress1']." <br>".$vendor['vcity']." ".$vendor['vstate']." - ".$vendor['vzip']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="11"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
              </div>
              <!-- model body end -->
              
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnselectvendor">Select</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="additempop" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="cartLabel">Select Vendor</h4>
              </div>
              <div class="modal-body">
              <table>
              <tr>
              <td>Search</td>
              <td><input type="text" name="venserch" id="vensearch" value="<?php echo $vensearch; ?>" /></td>
              </tr>
              <tr><td><input type="radio" name="searchby" value="vendoritem" /> Vendor Item</td>
              <td><input type="radio" name="searchby" value="allitem" /> All Item</td></tr>
              </table>
                <table class="table table-bordered table-hover" id="vendor-items-list">
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selecteditem\']').prop('checked', this.checked);" /></td>
                      <td class="text-left">SKU#</td>
                      <td class="text-left">Item</td>
                      <td class="text-left">Size</td>
                      <td class="text-left">Category</td>
                      <td class="text-left">Department</td>
                      <td class="text-left">Price</td>
                      <td class="text-left">Cost</td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- model body end -->
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnselectvendor">Select</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-po" >
          <input type="hiddens" name="selected_vendor" id="selected_vendor" value="<?php echo $selected_vendor;?>" />
          <div id="potabs">
            <ul class="nav nav-tabs">
              <li class="active" id="li-general"><a href="#tab-general" data-toggle="tab">General</a></li>
              <li id="li-item"><a href="#tab-item" data-toggle="tab">Item</a></li>
            </ul>
          </div>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="tab-content">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="col-sm-4">
                          <button type="button" data-toggle="tooltip" title="Select Vendor" class="btn btn-primary" onclick="selectvendor()">Select Vendor</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="vinvoiceno" class="col-xs-4 col-form-label">Invoice</label>
                        <input type="text" name="vinvoiceno" value="<?php echo $vinvoiceno; ?>" placeholder="Invoice" id="vinvoiceno" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vponumber" class="col-xs-4 col-form-label">Number</label>
                        <input type="text" name="vponumber" value="<?php echo $vponumber; ?>" placeholder="Number" id="vponumber" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vordertitle" class="col-xs-4 col-form-label">Title</label>
                        <input type="text" name="vordertitle" value="<?php echo $vordertitle; ?>" placeholder="Title" id="vordertitle" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vorderby" class="col-xs-4 col-form-label">Order By</label>
                        <input type="text" name="vorderby" value="<?php echo $vorderby; ?>" placeholder="Order By" id="vorderby" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vnotes" class="col-xs-4 col-form-label">Notes</label>
                        <input type="text" name="vnotes" value="<?php echo $vnotes; ?>" placeholder="Notes" id="vnotes" class="form-control" />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="example-text-input" class="col-xs-4 col-form-label">Create Date</label>
                        <input type="text" name="dcreatedate" value="<?php echo $dcreatedate; ?>" placeholder="Create Date" id="dcreatedate" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="dreceiveddate" class="col-xs-4 col-form-label">Received Date</label>
                        <input type="text" name="dreceiveddate" value="<?php echo $dreceiveddate; ?>" placeholder="Received Date" id="dreceiveddate" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="example-text-input" class="col-xs-4 col-form-label">Status</label>
                        <input type="text" name="vordertitle" value="<?php echo $vordertitle; ?>" placeholder="Title" id="vordertitle" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vconfirmby" class="col-xs-4 col-form-label">Confirm By</label>
                        <input type="text" name="vconfirmby" value="<?php echo $vconfirmby; ?>" placeholder="Confirm By" id="vconfirmby" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vshipvia" class="col-xs-4 col-form-label">Ship Via</label>
                        <input type="text" name="vshipvia" value="<?php echo $vshipvia; ?>" placeholder="Ship Via" id="vshipvia" class="form-control" />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="nsubtotal" class="col-xs-3 col-form-label">Sub Total</label>
                          <div class="col-xs-6">
                            <input type="text" name="nsubtotal" value="<?php echo $nsubtotal; ?>" placeholder="Sub Total" id="nsubtotal" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr style="border-width:2px;border-color:#A9A9A9" class="col-sm-8" >
                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="vvendorname" class="col-xs-4 col-form-label">Vendor Name</label>
                        <input type="text" name="vvendorname" value="<?php echo $vvendorname; ?>" placeholder="Vendor Name" id="vvendorname" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vvendoraddress2" class="col-xs-4 col-form-label">Address2</label>
                        <input type="text" name="vvendoraddress2" value="<?php echo $vvendoraddress2; ?>" placeholder="Address2" id="vvendoraddress2" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vvendorzip" class="col-xs-4 col-form-label">Zip</label>
                        <input type="text" name="vvendorzip" value="<?php echo $vvendorzip; ?>" placeholder="Zip" id="vvendorzip" class="form-control" />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="vvendoraddress1" class="col-xs-4 col-form-label">Address1</label>
                        <input type="text" name="vvendoraddress1" value="<?php echo $vvendoraddress1; ?>" placeholder="Addresss1" id="vvendoraddress1" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vvendorstate" class="col-xs-4 col-form-label">State</label>
                        <input type="text" name="vvendorstate" value="<?php echo $vvendorstate; ?>" placeholder="State" id="vvendorstate" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vvendorphone" class="col-xs-4 col-form-label">Phone</label>
                        <input type="text" name="vvendorphone" value="<?php echo $vvendorphone; ?>" placeholder="Phone" id="vvendorphone" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <hr style="border-width:2px;border-color:#A9A9A9" class="col-sm-8" >
                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="vshpname" class="col-xs-4 col-form-label">Ship To</label>
                        <input type="text" name="vshpname" value="<?php echo $vshpname; ?>" placeholder="Ship Name" id="vshpname" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vshpaddress2" class="col-xs-4 col-form-label">Address2</label>
                        <input type="text" name="vshpaddress2" value="<?php echo $vshpaddress2; ?>" placeholder="Address2" id="vshpaddress2" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vshpzip" class="col-xs-4 col-form-label">Zip</label>
                        <input type="text" name="vshpzip" value="<?php echo $vshpzip; ?>" placeholder="Zip" id="vshpzip" class="form-control" />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group required">
                        <label for="vshpaddress1" class="col-xs-4 col-form-label">Address1</label>
                        <input type="text" name="vshpaddress1" value="<?php echo $vshpaddress1; ?>" placeholder="Address1" id="vshpaddress1" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vshpstate" class="col-xs-4 col-form-label">State</label>
                        <input type="text" name="vshpstate" value="<?php echo $vshpstate; ?>" placeholder="State" id="vshpstate" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="vshpphone" class="col-xs-4 col-form-label">Phone</label>
                        <input type="text" name="vshpphone" value="<?php echo $vshpphone; ?>" placeholder="Phone" id="vshpphone" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-item">
              <div class="tab-content">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="col-sm-4">
                          <button type="button" data-toggle="tooltip" title="Select Vendor" class="btn btn-primary">Remove Item</button>
                          <button type="button" data-toggle="tooltip" title="Add Item" class="btn btn-primary" onclick="additem();">Add Item</button>
                        </div>
                      </div>
                    </div>
                    <br />
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="items-list">
                        <thead>
                          <tr>
                            <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selecteditem\']').prop('checked', this.checked);" /></td>
                            <td class="text-left">SKU#</td>
                            <td class="text-left">Item Name</td>
                            <td class="text-left">Vendor Code</td>
                            <td class="text-right">Size</td>
                            <td class="text-left">Total Case</td>
                            <td class="text-left">Case Qty</td>
                            <td class="text-left">Total Unit</td>
                            <td class="text-left">Total A...</td>
                            <td class="text-left">Unit Cost</td>
                          </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td style="width: 1px;" class="text-center"><input type="checkbox" /></td>
                            <td class="text-left">SKU#</td>
                            <td class="text-left">Item Name</td>
                            <td class="text-left">Vendor Code</td>
                            <td class="text-right">Size</td>
                            <td class="text-left">Total Case</td>
                            <td class="text-left">Case Qty</td>
                            <td class="text-left">Total Unit</td>
                            <td class="text-left">Total A...</td>
                            <td class="text-left">Unit Cost</td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> 
<script type="text/javascript"><!--
var d = new Date();
var month = d.getMonth();
var day = d.getDate();
var year = d.getFullYear();

$('#dcreatedate,#dreceiveddate').datetimepicker({
	pickTime: false,
	defaultDate:d
});

$('#rdate').datetimepicker({
	pickDate: false
});
//--></script> 
<script type="text/javascript"><!--
$('#tab-general a:first').tab('show');

if($("#selected_vendor").val()=="")
{
	$("#li-item a").removeAttr("href");
}
else
{
	$("#li-item a").attr("href","#tab-item");
}

function selectvendor()
{
	$('#selectvendormodel').modal('toggle');	
}

$("#btnselectvendor").click(function(){
	
	$("#selected_vendor").val('');
	
	var chkcount = $('input[name="venselected[]"]:checked').length;
	
	if(chkcount == 0 )
	{
		alert("Please Select One Checkbox");
		return false;
	}
	else if(chkcount > 1)
	{
		alert("Please Select Only One Checkbox");
		return false;
	}
	else
	{		
		$('input[name*=\'venselected\']:checked').each(function() {
			
			$("#selected_vendor").val($(this).val());
		});
		
		 $('input[name*=\'venselected\']').removeAttr('checked');
		 
		$.ajax({
			type: 'post',
			url: 'index.php?route=administration/purchase_order/getVendorInfo&token=<?php echo $token; ?>',
			data : 'vendorcode='+$("#selected_vendor").val(),
			dataType: 'html',
			success: function (json) {
				
				var data  = $.parseJSON(json);
				$("#vvendorname").val(data['vvendorname']);
				$("#vvendoraddress1").val(data['vvendoraddress1']);
				$("#vvendoraddress2").val(data['vvendoraddress2']);
				$("#vvendorzip").val(data['vvendorzip']);
				$("#vvendorstate").val(data['vvendorstate']);
				$("#vvendorphone").val(data['vvendorphone']);
				$("#vshpname").val(data['vshpname']);
				$("#vshpaddress1").val(data['vshpaddress1']);
				$("#vshpaddress2").val(data['vshpaddress2']);
				$("#vshpstate").val(data['vshpstate']);
				$("#vshpzip").val(data['vshpzip']);
				$("#vshpphone").val(data['vshpphone']);		
				
				$("#li-item a").attr("href","#tab-item").tab('show');
			}
		});
	}
	
		
});

function additem(){
	/*$.ajax({
		type: 'post',
		url: 'index.php?route=administration/purchase_order/AddItemsByVendor&token=<?php echo $token; ?>',
		data : 'vendorcode='+$("#selected_vendor").val(),
		dataType: 'html',
		success: function (json) {
			
			alert(json);
			//$("#vendor-items-list tbody").append(json);
			
			$('#additempop').modal('toggle');
		}
	});*/
	
	$('#vendor-items-list').DataTable({
		"paging": true,
		"iDisplayLength": 25,
		"bInfo": true,
		"scrollX": false,
		"processing": true,
		 "serverSide": true,
		 "ajax": "index.php?route=administration/purchase_order/AddItemsByVendor&token=<?php echo $token; ?>vendorcode="+$('#selected_vendor').val()
	});
	
	$('#additempop').modal('toggle');
}
//--></script>
<script type="text/javascript">
/*$('#vendor-items-list').DataTable({
    "paging": true,
    "iDisplayLength": 25,
	"bInfo": true,
	"scrollX": false,
	"processing": true,
     "serverSide": true,
	 "ajax": "index.php?route=administration/purchase_order/AddItemsByVendor&token=<?php echo $token; ?>vendorcode='+$("#selected_vendor").val()
});*/
</script>

</div>
<?php echo $footer; ?>