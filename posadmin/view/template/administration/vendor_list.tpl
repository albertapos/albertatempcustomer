<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
      <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
      <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>      
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
        <form action="" method="post" enctype="multipart/form-data" id="form-vendor">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="vendor" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-center"><?php echo $column_vendor_code; ?></th>
                  <th class="text-center"><?php echo $column_vendor_name; ?></th>
                  <th class="text-center"><?php echo $column_phone; ?></th>
                  <th class="text-center"><?php echo $column_email; ?></th>
                  <th class="text-center"><?php echo $column_status; ?></th>
                  <th class="text-center"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($vendors) { ?>
                <?php $vendor_row = 1;$i=0; ?>
                <?php foreach ($vendors as $vendor) { ?>
                <tr id="vendor-row<?php echo $vendor_row; ?>">
                  <td data-order="<?php echo $vendor['isupplierid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $vendor['isupplierid']; ?></span>
                  <?php if (in_array($vendor['isupplierid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="vendor[<?php echo $vendor_row; ?>][select]" value="<?php echo $vendor['isupplierid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="vendor[<?php echo $vendor_row; ?>][select]"  value="<?php echo $vendor['isupplierid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $vendor['vcode']; ?></span>
                    <input type="text" class="editable vendors_c" name="vendor[<?php echo $i; ?>][vcode]" id="vendor[<?php echo $i; ?>][vcode]" value="<?php echo $vendor['vcode']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="vendor[<?php echo $i; ?>][isupplierid]" value="<?php echo $vendor['isupplierid']; ?>"/>
        				  </td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $vendor['vcompanyname']; ?></span>
                    <input type="text" class="editable" name="vendor[<?php echo $i; ?>][vcompanyname]" id="vendor[<?php echo $i; ?>][vcompanyname]" value="<?php echo $vendor['vcompanyname']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
                  </td>

                  <td class="text-left">
                    <input type="text" class="editable" name="vendor[<?php echo $i; ?>][vphone]" id="vendor[<?php echo $i; ?>][vphone]" value="<?php echo $vendor['vphone']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
                  </td>

                  <td class="text-left">
                  <span style="display:none;"><?php echo $vendor['vemail']; ?></span>
                    <input type="text" class="editable" name="vendor[<?php echo $i; ?>][vemail]" id="vendor[<?php echo $i; ?>][vemail]" value="<?php echo $vendor['vemail']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
                  </td>

                  <td class="text-left">
                    <?php echo $vendor['estatus']; ?>
                  </td>

                  <td class="text-right">
                    <a href="<?php echo $vendor['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" ><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                    </a>
                  </td>
                </tr>
                <?php $vendor_row++; $i++;?>
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
	url = 'index.php?route=administration/vendor&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/vendor&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_vendor = true;
    
    $('.vendors_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Category Name');
        all_vendor = false;
        return false;
      }else{
        all_vendor = true;
      }
    });
    
    if(all_vendor == true){
      $('#form-vendor').attr('action', edit_url);
      $('#form-vendor').submit();
    }
  });
</script>

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#vendor').DataTable({
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
  #vendor_filter, #vendor_paginate{
    float: right;
  }

  #vendor_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#vendor_length').parent().hide();
    $('#vendor_info').parent().hide();

    $('#vendor_filter').css('float','left');
    $('#vendor_paginate').css('float','left');

    $('#vendor_filter').find('input[type="search"]').css('width','200%');

  });
</script>

<!-- DataTables -->

<?php echo $footer; ?>