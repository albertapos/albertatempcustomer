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
              <button type="button" onclick="addUnit();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>  
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_unit_search">
        <input type="hidden" name="searchbox" id="iunitid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Unit..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-unit">
          
          <div class="table-responsive">
            <table id="unit" class="table table-bordered table-hover" style="width:70%">
            <?php if ($units) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_unit_code; ?></th>
                  <th class="text-left"><?php echo $column_unit_name; ?></th>
                  <th class="text-left"><?php echo $column_unit_description; ?></th>
                  <th class="text-left"><?php echo $column_unit_status; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $unit_row = 1;$i=0; ?>
                <?php foreach ($units as $unit) { ?>
                <tr id="unit-row<?php echo $unit_row; ?>">
                  <td data-order="<?php echo $unit['iunitid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $unit['iunitid']; ?></span>
                  <?php if (in_array($unit['iunitid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="unit[<?php echo $unit_row; ?>][select]" value="<?php echo $unit['iunitid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="unit[<?php echo $unit_row; ?>][select]"  value="<?php echo $unit['iunitid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $unit['vunitcode']; ?></span>
                    <input type="text" maxlength="20" class="editable" name="unit[<?php echo $i; ?>][vunitcode]" id="unit[<?php echo $i; ?>][vunitcode]" value="<?php echo $unit['vunitcode']; ?>" onclick='document.getElementById("unit[<?php echo $unit_row; ?>][select]").setAttribute("checked","checked");' />

                    <input type="hidden" name="unit[<?php echo $i; ?>][iunitid]" value="<?php echo $unit['iunitid']; ?>" />

                  </td>

                  <td class="text-left">
                  <span style="display:none;"><?php echo $unit['vunitname']; ?></span>
                    <input type="text" maxlength="50" class="editable" name="unit[<?php echo $i; ?>][vunitname]" id="unit[<?php echo $i; ?>][vunitname]" value="<?php echo $unit['vunitname']; ?>" onclick='document.getElementById("unit[<?php echo $unit_row; ?>][select]").setAttribute("checked","checked");' />

                  </td>

                  <td class="text-left">
                    <textarea class="editable" maxlength="100" name="unit[<?php echo $i; ?>][vunitdesc]" id="unit[<?php echo $i; ?>][vunitdesc]" onclick='document.getElementById("unit[<?php echo $unit_row; ?>][select]").setAttribute("checked","checked");'><?php echo $unit['vunitdesc']; ?></textarea>
                  </td>
                
                  <td class="text-left">
                    <select name="unit[<?php echo $i; ?>][estatus]" id="unit[<?php echo $i; ?>][estatus]" class="form-control" onchange='document.getElementById("unit[<?php echo $unit_row; ?>][select]").setAttribute("checked","checked");'>
                        <?php  if ($unit['estatus']==$Active) { ?>
                        <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option>
                        <?php } else if($unit['estatus']==$Inactive){ ?>
                          <option value="<?php echo $Active; ?>"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>" selected="selected"><?php echo $Inactive; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $Active; ?>"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>" selected="selected"><?php echo $Inactive; ?></option>
                        <?php } ?>
                      </select>
                    </td>

                </tr>
                <?php $unit_row++; $i++;?>
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
        <?php if ($units) { ?>
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
    
    var all_code_unit = true;
    var all_name_unit = true;
    
    $('.units_code_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Unit Code');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Unit Code", 
          callback: function(){}
        });
        all_code_unit = false;
        return false;
      }else{
        all_code_unit = true;
      }
    });

    if(all_code_unit == true){
      $('.units_name_c').each(function(){
        if($(this).val() == ''){
          // alert('Please Enter Unit Name');
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: "Please Enter Unit Name", 
            callback: function(){}
          });
          all_name_unit = false;
          return false;
        }else{
          all_name_unit = true;
        }
      });
    }else{
      all_code_unit = false;
      return false;
    }
    

    if(all_code_unit == true && all_name_unit == true){
      var all_unit = true;
    }else{
      var all_unit = false;
    }
    
    if(all_unit == true){
      $('#form-unit').attr('action', edit_url);
      $('#form-unit').submit();
    }
  });
</script>

<script type="text/javascript"><!--
var unit_row = <?php echo $unit_row; ?>;

function addUnit() {

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
          <h4 class="modal-title">Add New Unit</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="unit[0][iunitid]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Code</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="20" name="unit[0][vunitcode]" id="add_vunitcode" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" name="unit[0][vunitname]" id="add_vunitname" class="form-control">
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
                    <textarea name="unit[0][vunitdesc]" maxlength="100" id="add_vunitdesc" class="form-control"></textarea>
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
                    <select name="unit[0][estatus]" class="form-control ">
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
    
    if($('form#add_new_form #add_vunitcode').val() == ''){
      // alert('Please enter code!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter code!", 
        callback: function(){}
      });
      return false;
    }

    if($('form#add_new_form #add_vunitname').val() == ''){
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
        
        var url = '<?php echo $searchunit;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vunitname,
                            value: val.vunitname,
                            id: val.iunitid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_unit_search #iunitid').val(ui.item.id);
                
                if($('#iunitid').val() != ''){
                    $('#form_unit_search').submit();
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