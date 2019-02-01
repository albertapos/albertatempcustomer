<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
        <button type="button" onclick="addPaidOut();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>        
      </div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        
        <form action="" method="post" enctype="multipart/form-data" id="form-paid-out">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="paid_out" class="table table-bordered table-hover" style="width:50%;">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="" class="text-center"><?php echo $column_paid_out; ?></th>
                  <th class="text-center"><?php echo $column_status; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($paidouts) { ?>
                <?php $paid_out_row = 1;$i=0; ?>
                <?php foreach ($paidouts as $paidout) { ?>
                <tr id="paid-out-row<?php echo $paid_out_row; ?>">
                  <td data-order="<?php echo $paidout['ipaidoutid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $paidout['ipaidoutid']; ?></span>
                  <?php if (in_array($paidout['ipaidoutid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="paidout[<?php echo $paid_out_row; ?>][select]" value="<?php echo $paidout['ipaidoutid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="paidout[<?php echo $paid_out_row; ?>][select]"  value="<?php echo $paidout['ipaidoutid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $paidout['vpaidoutname']; ?></span>
                    <input type="text" class="editable paidouts_c" name="paidout[<?php echo $i; ?>][vpaidoutname]" id="paidout[<?php echo $i; ?>][vpaidoutname]" value="<?php echo $paidout['vpaidoutname']; ?>" onclick='document.getElementById("paidout[<?php echo $paid_out_row; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="paidout[<?php echo $i; ?>][ipaidoutid]" value="<?php echo $paidout['ipaidoutid']; ?>"/>
        				  </td>
                  
                  <td class="text-left">
                  <select name="paidout[<?php echo $i; ?>][estatus]" id="paidout[<?php echo $i; ?>][estatus]" class="form-control" onchange='document.getElementById("paidout[<?php echo $paid_out_row; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($paidout['estatus']==$Active) { ?>
                      <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                      <option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $Active; ?>"><?php echo $Active; ?></option>
                      <option value="<?php echo $Inactive; ?>" selected="selected"><?php echo $Inactive; ?></option>
                      <?php } ?>
                    </select></td>
                   
                </tr>
                <?php $paid_out_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <!-- <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div> -->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=administration/paid_out&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/paid_out&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var paid_out_row = <?php echo $paid_out_row; ?>;

function addPaidOut() {
	
		html  = '<tr id="paid-out-row' + paid_out_row + '">';

		  html += '  <td class="text-left"><input type="checkbox" name="selected[]" id="paidout['+ paid_out_row +'][select]"/></td>';
      html += ' <input type="hidden" name="paidout[' + paid_out_row + '][ipaidoutid]" value="0"/>';

		 html += '  <td class="text-right"><input type="text" name="paidout[' + paid_out_row + '][vpaidoutname]" value="" placeholder="<?php echo $entry_paid_out; ?>" class="form-control paidouts_c" /></td>';
		
		html += '  <td class="text-right"><select name="paidout[' + paid_out_row + '][estatus]" id="paidout[' + paid_out_row + '][estatus]" class="form-control "><option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option><option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option></select></td>';
		
		html += '  <td class="text-right">   <button type="button" onclick="$(\'#paid-out-row' + paid_out_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-sm btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
	
		$('#paid_out tbody').append(html);
	
		paid_out_row++;
	
}

//--></script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_paid_out = true;
    
    $('.paidouts_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Paid Out Name');
        all_paid_out = false;
        return false;
      }else{
        all_paid_out = true;
      }
    });
    

    if(all_paid_out == true){
      $('#form-paid-out').attr('action', edit_url);
      $('#form-paid-out').submit();
    }
  });
</script>

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#paid_out').DataTable({
    "paging": true,
    "iDisplayLength": 25,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "aaSorting": [[ 0, "desc" ]],
    // 'aoColumnDefs': [{
    //     'bSortable': false,
    //     'aTargets': [4,5,9] /* 1st one, start by the right */
    // }]
    
});

</script>

<style type="text/css">
  #paid_out_filter, #paid_out_paginate{
    float: right;
  }

  #paid_out_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#paid_out_length').parent().hide();
    $('#paid_out_info').parent().hide();

    $('#paid_out_filter').css('float','left');
    $('#paid_out_paginate').css('float','left');

    $('#paid_out_filter').find('input[type="search"]').css('width','200%');

  });
</script>

<!-- DataTables -->

<?php echo $footer; ?>