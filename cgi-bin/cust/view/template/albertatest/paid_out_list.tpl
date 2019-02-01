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

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
              <button type="button" onclick="addPaidOut();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_paid_out_search">
        <input type="hidden" name="searchbox" id="ipaidoutid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Paid Out..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-paid-out">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="paid_out" class="table table-bordered table-hover" style="width:50%;">
            <?php if ($paidouts) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="" class="text-left"><?php echo $column_paid_out; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                </tr>
              </thead>
              <tbody>
                
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
                    <input type="text" maxlength="100" class="editable paidouts_c" name="paidout[<?php echo $i; ?>][vpaidoutname]" id="paidout[<?php echo $i; ?>][vpaidoutname]" value="<?php echo $paidout['vpaidoutname']; ?>" onclick='document.getElementById("paidout[<?php echo $paid_out_row; ?>][select]").setAttribute("checked","checked");' />
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
        <?php if ($paidouts) { ?>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script src="view/javascript/bootbox.min.js" defer></script>
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
	 
   $('#addModal').modal('show');
	
}

//--></script> 

<!-- Modal Add -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New paid Out</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="paidout[0][ipaidoutid]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="100" name="paidout[0][vpaidoutname]" id="add_vpaidoutname" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Status</label>
                  </div>
                  <div class="col-md-10">  
                    <select name="paidout[0][estatus]" class="form-control ">
                      <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                      <option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('submit', 'form#add_new_form', function(event) {
    
    if($('form#add_new_form #add_vpaidoutname').val() == ''){
      // alert('Please enter name!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter name!", 
        callback: function(){}
      });
      return false;
    }
    $("div#divLoading").addClass('show');
    
  });
</script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_paid_out = true;
    
    $('.paidouts_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Paid Out Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Paid Out Name", 
          callback: function(){}
        });
        all_paid_out = false;
        return false;
      }else{
        all_paid_out = true;
      }
    });
    

    if(all_paid_out == true){
      $('#form-paid-out').attr('action', edit_url);
      $('#form-paid-out').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchpaid_out;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vpaidoutname,
                            value: val.vpaidoutname,
                            id: val.ipaidoutid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_paid_out_search #ipaidoutid').val(ui.item.id);
                
                if($('#ipaidoutid').val() != ''){
                    $('#form_paid_out_search').submit();
                    $("div#divLoading").addClass('show');
                }
            }
        });
    });

    $(function() { $('input[name="automplete-product"]').focus(); });
</script>

<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>