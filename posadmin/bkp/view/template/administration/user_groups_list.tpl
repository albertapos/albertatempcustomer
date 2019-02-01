<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
      
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
        <form action="" method="post" enctype="multipart/form-data" id="form-user-group">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="user_groups" class="table table-bordered table-hover" style="width:60%;">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-center"><?php echo $column_group_name; ?></th>
                  <th class="text-center"><?php echo $column_status; ?></th>
                  <th class="text-center"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($user_groups) { ?>
                <?php $user_groups_row = 1;$i=0; ?>
                <?php foreach ($user_groups as $user_group) { ?>
                <tr id="user-groups-row<?php echo $user_groups_row; ?>">
                  <td data-order="<?php echo $user_group['ipermissiongroupid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $user_group['ipermissiongroupid']; ?></span>
                  <?php if (in_array($user_group['ipermissiongroupid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="user_group[<?php echo $user_groups_row; ?>][select]" value="<?php echo $user_group['ipermissiongroupid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="user_group[<?php echo $user_groups_row; ?>][select]"  value="<?php echo $user_group['ipermissiongroupid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                    <span><?php echo $user_group['vgroupname']; ?></span>
                    
        				  </td>
                  
                  <td class="text-left">
                    <?php echo $user_group['estatus'];;?>
                  </td>

                  <td class="text-right">
                    <a href="<?php echo $user_group['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a>
                  </td>
                </tr>
                <?php $user_groups_row++; $i++;?>
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
$('#user_groups').DataTable({
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
  #user_groups_filter, #user_groups_paginate{
    float: right;
  }

  #user_groups_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#user_groups_length').parent().hide();
    $('#user_groups_info').parent().hide();

    $('#user_groups_filter').css('float','left');
    $('#user_groups_paginate').css('float','left');

    $('#user_groups_filter').find('input[type="search"]').css('width','200%');

  });
</script>

<!-- DataTables -->

<?php echo $footer; ?>