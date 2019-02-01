<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
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
        <form action="" method="post" enctype="multipart/form-data" id="form-users">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="users" class="table table-bordered table-hover" style="">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-center"><?php echo $column_first_name; ?></th>
                  <th class="text-center"><?php echo $column_last_name; ?></th>
                  <th class="text-center"><?php echo $column_phone; ?></th>
                  <th class="text-center"><?php echo $column_email; ?></th>
                  <th class="text-center"><?php echo $column_user_id; ?></th>
                  <th class="text-center"><?php echo $column_user_type; ?></th>
                  <th class="text-center"><?php echo $column_print_barcode; ?></th>
                  <th class="text-center"><?php echo $column_status; ?></th>
                  <th class="text-center"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($users) { ?>
                <?php $users_row = 1;$i=0; ?>
                <?php foreach ($users as $user) { ?>
                <tr id="users-row<?php echo $users_row; ?>">
                  <td data-order="<?php echo $user['iuserid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $user['iuserid']; ?></span>
                  <?php if (in_array($user['iuserid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="user[<?php echo $users_row; ?>][select]" value="<?php echo $user['iuserid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="user[<?php echo $users_row; ?>][select]"  value="<?php echo $user['iuserid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                    <span><?php echo $user['vfname']; ?></span>
        				  </td>

                  <td class="text-left">
                    <span><?php echo $user['vlname']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vphone']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vemail']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vuserid']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vusertype']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vuserbarcode']; ?></span>
                  </td>
                  
                  <td class="text-left">
                    <?php echo $user['estatus'];;?>
                  </td>

                  <td class="text-right">
                    <a href="<?php echo $user['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a>
                  </td>
                </tr>
                <?php $users_row++; $i++;?>
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

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#users').DataTable({
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
  #users_filter, #users_paginate{
    float: right;
  }

  #users_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#users_length').parent().hide();
    $('#users_info').parent().hide();

    $('#users_filter').css('float','left');
    $('#users_paginate').css('float','left');

    $('#users_filter').find('input[type="search"]').css('width','200%');

  });
</script>

<!-- DataTables -->

<?php echo $footer; ?>