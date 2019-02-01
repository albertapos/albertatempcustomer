<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> 
      
      </div>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">

        <form action="<?php echo $current_url;?>" method="post" id="form_user_groups_search">
          <input type="hidden" name="searchbox" id="ipermissiongroupid">
          <div class="row">
              <div class="col-md-12">
                  <input type="text" name="automplete-product" class="form-control" placeholder="Search User Group..." id="automplete-product">
              </div>
          </div>
        </form>
        <br>

        <form action="" method="post" enctype="multipart/form-data" id="form-user-group">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="user_groups" class="table table-bordered table-hover" style="width:60%;">
            <?php if ($user_groups) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_group_name; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
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

                  <td class="text-left">
                    <a href="<?php echo $user_group['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
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
        <?php if ($user_groups) { ?>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <?php } ?>
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

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchuser_groups;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vgroupname,
                            value: val.vgroupname,
                            id: val.ipermissiongroupid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_user_groups_search #ipermissiongroupid').val(ui.item.id);
                
                if($('#ipermissiongroupid').val() != ''){
                    $('#form_user_groups_search').submit();
                }
            }
        });
    });

  $(function() { $('input[name="automplete-product"]').focus(); });
</script>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>