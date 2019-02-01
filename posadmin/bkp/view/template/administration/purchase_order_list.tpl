<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>       </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-items">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        <div class="pull-right"><input type="text" name="searchbox" id="searchbox" value="<?php echo $searchbox;?>" class="form-control input-sm" placeholder="Search"/><input type="hidden" name="searchboxid" id="searchboxid"/></div>
      </div>
      <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="items-list">
              <thead>
                <tr>
                     <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                     <td class="text-left"><?php echo $column_status; ?></td>
                     <td class="text-left"><?php echo $column_po; ?></td>
                     <td class="text-left"><?php echo $column_invoice; ?></td>
                     <td class="text-right"><?php echo $column_total; ?></td>
                     <td class="text-left"><?php echo $column_vendorname; ?></td>
                     <td class="text-left"><?php echo $column_order_type; ?></td>
                     <td class="text-left"><?php echo $column_cdate; ?></td>
                     <td class="text-left"><?php echo $column_rdate; ?></td>
                     <td class="text-left"><?php echo $column_udate; ?></td>
                     <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($pos) { ?>
                <?php foreach ($pos as $po) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($po['ipoid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $po['ipoid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $po['ipoid']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $po['estatus']; ?></td>
                  <td class="text-left"><?php echo $po['vponumber']; ?></td>
                   <td class="text-left"><?php echo $po['vinvoiceno']; ?></td>  
                  <td class="text-right"><?php echo $po['nnettotal']; ?></td>
                  <td class="text-left"><?php echo $po['vvendorname']; ?></td>
                  <td class="text-left"><?php echo $po['vordertype']; ?></td> 
                  <td class="text-left"><?php echo $po['dcreatedate']; ?></td>
                  <td class="text-left"><?php echo $po['dreceiveddate']; ?></td>
                  <td class="text-left"><?php echo $po['LastUpdate']; ?></td>                 
                  <td class="text-right"><a href="<?php echo $po['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="11"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
       
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
     </form>
    
  </div>
</div>
<script><!--
$('input[name=\'searchbox\']').autocomplete({
	/*minLength: 1,
	'source': function(request, response) {
		$.ajax({
			type: 'post',
			url: 'index.php?route=administration/purchase_order/autocomplete&token=<?php echo $token; ?>&searchbox='+$('input[name=\'searchbox\']').val(),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['vitemname'],
						value: item['iitemid']
					}
				}));
			}
		});
	},
	'select': function(event, ui) {
		$('input[name=\'searchbox\']').val(ui.item.label);
		$('input[name=\'searchboxid\']').val(ui.item.value);
		
		$('#form-items').attr('action', 'index.php?route=kiosk/items&token=<?php echo $token; ?>');
		$('#form-items').submit();

		return false;
	}*/
});
--></script>
<?php echo $footer; ?>