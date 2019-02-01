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
              <button type="button" onclick="addLocation();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>    
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_location_search">
        <input type="hidden" name="searchbox" id="ilocid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Location..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-location">
          
          <div class="table-responsive">
            <table id="location" class="table table-bordered table-hover" style="width:50%">
            <?php if ($locations) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_location_name; ?></th>
                  <th class="text-left"><?php echo $column_location_description; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $location_row = 1;$i=0; ?>
                <?php foreach ($locations as $location) { ?>
                <tr id="location-row<?php echo $location_row; ?>">
                  <td data-order="<?php echo $location['ilocid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $location['ilocid']; ?></span>
                  <?php if (in_array($location['ilocid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="location[<?php echo $location_row; ?>][select]" value="<?php echo $location['ilocid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="location[<?php echo $location_row; ?>][select]"  value="<?php echo $location['ilocid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $location['vlocname']; ?></span>
                    <input type="text" maxlength="50" class="editable" name="location[<?php echo $i; ?>][vlocname]" id="location[<?php echo $i; ?>][vlocname]" value="<?php echo $location['vlocname']; ?>" onclick='document.getElementById("location[<?php echo $location_row; ?>][select]").setAttribute("checked","checked");' />

                    <input type="hidden" name="location[<?php echo $i; ?>][ilocid]" value="<?php echo $location['ilocid']; ?>" />

                  </td>

                  <td class="text-left">
                    <textarea class="editable" maxlength="100" name="location[<?php echo $i; ?>][vlocdesc]" id="location[<?php echo $i; ?>][vlocdesc]" onclick='document.getElementById("location[<?php echo $location_row; ?>][select]").setAttribute("checked","checked");'><?php echo $location['vlocdesc']; ?></textarea>
                  </td>
                </tr>
                <?php $location_row++; $i++;?>
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
        <?php if ($locations) { ?>
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
    
    var all_location = true;
    
    $('.locations_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Location Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Location Name", 
          callback: function(){}
        });
        all_location = false;
        return false;
      }else{
        all_location = true;
      }
    });
    
    if(all_location == true){
      $('#form-location').attr('action', edit_url);
      $('#form-location').submit();
    }
  });
</script>

<script type="text/javascript"><!--
var location_row = <?php echo $location_row; ?>;

function addLocation() {

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
          <h4 class="modal-title">Add New Location</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="location[0][ilocid]" value="0">
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group required">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" name="location[0][vlocname]" id="add_vlocname" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Description</label>
                  </div>
                  <div class="col-md-10">  
                    <textarea maxlength="100" name="location[0][vlocdesc]" class="form-control"></textarea>
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
    
    if($('form#add_new_form #add_vlocname').val() == ''){
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
        
        var url = '<?php echo $searchlocation;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vlocname,
                            value: val.vlocname,
                            id: val.ilocid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_location_search #ilocid').val(ui.item.id);
                
                if($('#ilocid').val() != ''){
                    $('#form_location_search').submit();
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