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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        
      </div>
      <div class="panel-body">
        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>
            </div>
          </div>
        </div>

      <form action="<?php echo $current_url;?>" method="post" id="form_user_search">
        <div class="row">
            <input type="hidden" name="searchbox" id="iuserid">
            <div class="col-md-12">
                <input name="automplete-product" type="text" class="form-control" placeholder="Search User..." id="automplete-product" required>
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-users">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="users" class="table table-bordered table-hover" style="">
            <?php if ($users) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_first_name; ?></th>
                  <th class="text-left"><?php echo $column_last_name; ?></th>
                  <th class="text-right"><?php echo $column_phone; ?></th>
                  <th class="text-left"><?php echo $column_email; ?></th>
                  <th class="text-right"><?php echo $column_user_id; ?></th>
                  <th class="text-left"><?php echo $column_user_type; ?></th>
                  <th class="text-left"><?php echo $column_print_barcode; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
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

                  <td class="text-right">
                    <span><?php echo $user['vphone']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $user['vemail']; ?></span>
                  </td>

                  <td class="text-right">
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

                  <td class="text-left">
                    <a href="<?php echo $user['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
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
        <?php if ($users) { ?>
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
    // $(function() {
        
    //     var url = '<?php echo $searchuser;?>';
        
    //     url = url.replace(/&amp;/g, '&');
        
    //     $( "#automplete-product" ).autocomplete({
    //         minLength: 2,
    //         source: function(req, add) {
    //             $.getJSON(url, req, function(data) {
    //                 var suggestions = [];
    //                 $.each(data, function(i, val) {
    //                     suggestions.push({
    //                         label: val.vusername,
    //                         value: val.vusername,
    //                         id: val.iuserid
    //                     });
    //                 });
    //                 add(suggestions);
    //             });
    //         },
    //         select: function(e, ui) {
    //             $('form#form_user_search #iuserid').val(ui.item.id);
                
    //             if($('#iuserid').val() != ''){
    //                 $('#form_user_search').submit();
    //             }
    //         }
    //     });
    // });

    $(document).on('keyup', '#automplete-product', function(event) {
      event.preventDefault();
      
      $('#users tbody tr').hide();
      var txt = $(this).val().toUpperCase();
      var td1,td2,td3,td4,td5;

      if(txt != ''){
        $('#users tbody tr').each(function(){
          
          td1 = $(this).find("td")[1];
          td2 = $(this).find("td")[2];
          td3 = $(this).find("td")[3];
          td4 = $(this).find("td")[4];
          td5 = $(this).find("td")[5];

          if (td1 || td2 || td3 || td4 || td5) {
            if (td1.innerHTML.toUpperCase().indexOf(txt) > -1 || td2.innerHTML.toUpperCase().indexOf(txt) > -1 || td3.innerHTML.toUpperCase().indexOf(txt) > -1 || td4.innerHTML.toUpperCase().indexOf(txt) > -1 || td5.innerHTML.toUpperCase().indexOf(txt) > -1) {
              $(this).show();
            } else {
              $(this).hide();
            }
          }  
        });
      }else{
        $('#users tbody tr').show();
      }
    });


$(function() { $('input[name="automplete-product"]').focus(); });
</script>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>