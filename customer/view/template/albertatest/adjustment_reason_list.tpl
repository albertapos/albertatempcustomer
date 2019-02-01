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
              <button type="button" onclick="addAdjustmentReason();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>  
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_reason_search">
        <input type="hidden" name="searchbox" id="ireasonid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Reason..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-adjustment-reason">
          
          <div class="table-responsive">
            <table id="adjustment_reason" class="table table-bordered table-hover" style="width:50%">
            <?php if ($adjustment_reasons) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_reason_name; ?></th>
                  <th class="text-left"><?php echo $column_reason_status; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $adjustment_reason_row = 1;$i=0; ?>
                <?php foreach ($adjustment_reasons as $adjustment_reason) { ?>
                <tr id="adjustment_reason-row<?php echo $adjustment_reason_row; ?>">
                  <td data-order="<?php echo $adjustment_reason['ireasonid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $adjustment_reason['ireasonid']; ?></span>
                  <?php if (in_array($adjustment_reason['ireasonid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="adjustment_reason[<?php echo $adjustment_reason_row; ?>][select]" value="<?php echo $adjustment_reason['ireasonid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="adjustment_reason[<?php echo $adjustment_reason_row; ?>][select]"  value="<?php echo $adjustment_reason['ireasonid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $adjustment_reason['vreasonename']; ?></span>
                    <input type="text" maxlength="50" class="editable" name="adjustment_reason[<?php echo $i; ?>][vreasonename]" id="adjustment_reason[<?php echo $i; ?>][vreasonename]" value="<?php echo $adjustment_reason['vreasonename']; ?>" onclick='document.getElementById("adjustment_reason[<?php echo $adjustment_reason_row; ?>][select]").setAttribute("checked","checked");' />

                    <input type="hidden" name="adjustment_reason[<?php echo $i; ?>][ireasonid]" value="<?php echo $adjustment_reason['ireasonid']; ?>" />

                  </td>

                  <td class="text-left">
                  <span><?php echo $adjustment_reason['estatus']; ?></span>
                  </td>
                </tr>
                <?php $adjustment_reason_row++; $i++;?>
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
        <?php if ($adjustment_reasons) { ?>
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
<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_adjustment_reason = true;
    
    $('.adjustment_reasons_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Reason Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Reason Name", 
          callback: function(){}
        });
        all_adjustment_reason = false;
        return false;
      }else{
        all_adjustment_reason = true;
      }
    });
    
    if(all_adjustment_reason == true){
      $('#form-adjustment-reason').attr('action', edit_url);
      $('#form-adjustment-reason').submit();
    }
  });
</script>

<script type="text/javascript"><!--
var adjustment_reason_row = <?php echo $adjustment_reason_row; ?>;

function addAdjustmentReason() {

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
          <h4 class="modal-title">Add New Reason</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="adjustment_reason[0][ireasonid]" value="0">
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" name="adjustment_reason[0][vreasonename]" id="add_vreasonename" class="form-control">
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
    
    if($('form#add_new_form #add_vreasonename').val() == ''){
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

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchreason;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vreasonename,
                            value: val.vreasonename,
                            id: val.ireasonid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_reason_search #ireasonid').val(ui.item.id);
                
                if($('#ireasonid').val() != ''){
                    $('#form_reason_search').submit();
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