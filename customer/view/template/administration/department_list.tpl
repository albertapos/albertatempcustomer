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
              <button type="button" onclick="addDepartment();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>
              <button type="button" class="btn btn-danger" id="delete_department_btn" title="Delete" style="border-radius: 0px;"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>      
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_department_search">
        <input type="hidden" name="searchbox" id="idepartmentid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Department..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-department">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="department" class="table table-bordered table-hover" style="width:80%;">
            <?php if ($departments) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="width:1px;" class="text-left"><?php echo $column_department_code; ?></th>
                  <th style="width:1px;" class="text-left"><?php echo $column_department_name; ?></th>
                  <th class="text-left"><?php echo $column_description; ?></th>
                  <th class="text-left">Start Time</th>
                  <th class="text-left">End Time</th>
                  <th class="text-left" style="display:none;"><?php echo $column_sequence; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $department_row = 1;$i=0; ?>
                <?php foreach ($departments as $department) { ?>
                <tr id="department-row<?php echo $department_row; ?>">
                  <td data-order="<?php echo $department['idepartmentid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $department['idepartmentid']; ?></span>
                  <?php if (in_array($department['idepartmentid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="department[<?php echo $department_row; ?>][select]" value="<?php echo $department['idepartmentid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="department[<?php echo $department_row; ?>][select]"  value="<?php echo $department['idepartmentid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                    <span style="display:none;"><?php echo $department['vdepcode']; ?></span>
                    <input type="text" maxlength="50" class="editable department_c" name="department[<?php echo $i; ?>][vdepcode]" id="department[<?php echo $i; ?>][vdepcode]" value="<?php echo $department['vdepcode']; ?>" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="department[<?php echo $i; ?>][idepartmentid]" value="<?php echo $department['idepartmentid']; ?>"/>
        				  </td>
                  
                  <td class="text-left">
                    <span style="display:none;"><?php echo $department['vdepartmentname']; ?></span>
                    <input type="text" maxlength="50" class="editable department_c" name="department[<?php echo $i; ?>][vdepartmentname]" id="department[<?php echo $i; ?>][vdepartmentname]" value="<?php echo $department['vdepartmentname']; ?>" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="department[<?php echo $i; ?>][idepartmentid]" value="<?php echo $department['idepartmentid']; ?>"/>
        				  </td>
                  <td class="text-left">
                    <textarea class="editable" maxlength="100" name="department[<?php echo $i; ?>][vdescription]" id="department[<?php echo $i; ?>][vdescription]" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");'><?php echo $department['vdescription']; ?></textarea>
                  </td>
                  <td class="text-left">
                    <?php
                      if(isset($department['starttime']) && !empty($department['starttime'])){
                        $starttime_string = explode(':', $department['starttime']);
                        $start_hour = $starttime_string[0];
                        $start_minute = $starttime_string[1];
                      }else{
                        $start_hour = '';
                        $start_minute = '';
                      }

                      if(isset($department['endtime']) && !empty($department['endtime'])){
                          $endtime_string = explode(':', $department['endtime']);
                          $end_hour = $endtime_string[0];
                          $end_minute = $endtime_string[1];
                        }else{
                          $end_hour = '';
                          $end_minute = '';
                        }

                    ?>

                    <select class="form-control" name="department[<?php echo $i; ?>][start_hour]" style="width:45%;display:inline-block;">
                      <option value="">hour</option>
                      <?php if(isset($hours) && count($hours) > 0) {?>
                        <?php foreach($hours as $k => $hour) { ?>
                          <?php if($start_hour == $k){?>
                            <option value="<?php echo $k;?>" selected="selected"><?php echo $hour;?></option>
                          <?php }else{ ?>
                            <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <select class="form-control" name="department[<?php echo $i; ?>][start_minute]" style="width:45%;display:inline-block;">
                      <option value="">minute</option>
                      <?php for($m=0;$m<60;$m++) { ?>
                        <?php if($start_minute == str_pad($m,2,"0",STR_PAD_LEFT)){ ?>
                          <option selected="selected" value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                        <?php }else{ ?>
                          <option value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="text-left">
                    <select class="form-control" name="department[<?php echo $i; ?>][end_hour]" style="width:45%;display:inline-block;">
                      <option value="">hour</option>
                      <?php if(isset($hours) && count($hours) > 0) {?>
                        <?php foreach($hours as $k => $hour) { ?>
                          <?php if($end_hour == $k){ ?>
                            <option value="<?php echo $k;?>" selected="selected"><?php echo $hour;?></option>
                          <?php }else{ ?>
                            <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                          <?php } ?>
                        
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <select class="form-control" name="department[<?php echo $i; ?>][end_minute]" style="width:45%;display:inline-block;">
                      <option value="">minute</option>
                      <?php for($m=0;$m<60;$m++) { ?>
                        <?php if($end_minute == str_pad($m,2,"0",STR_PAD_LEFT)){ ?>
                          <option value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>" selected="selected"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                        <?php }else{ ?>
                          <option value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                  
                    <td class="text-left" style="display:none;">
                      <input type="text" class="editable department_s" name="department[<?php echo $i; ?>][isequence]" id="department[<?php echo $i; ?>][isequence]" value="<?php echo $department['isequence']; ?>" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");' />
                    </td>
                  
                </tr>
                <?php $department_row++; $i++;?>
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
        <?php if ($departments) { ?>
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
	url = 'index.php?route=administration/department&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/department&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var department_row = <?php echo $department_row; ?>;

function addDepartment() {
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
          <h4 class="modal-title">Add New Department</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="department[0][idepartmentid]" value="0">
            <input type="hidden" name="department[0][isequence]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" name="department[0][vdepartmentname]" id="add_vdepartmentname" class="form-control">
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
                    <textarea maxlength="100" name="department[0][vdescription]" id="add_vdescription" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Start Time</label>
                  </div>
                  <div class="col-md-10">  
                    <select class="form-control" name="department[0][start_hour]" style="width:45%;display:inline-block;">
                      <option value="">hour</option>
                      <?php if(isset($hours) && count($hours) > 0) {?>
                        <?php foreach($hours as $k => $hour) { ?>
                        <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <select class="form-control" name="department[0][start_minute]" style="width:45%;display:inline-block;">
                      <option value="">minute</option>
                      <?php for($m=0;$m<60;$m++) { ?>
                      <option value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>End Time</label>
                  </div>
                  <div class="col-md-10">  
                    <select class="form-control" name="department[0][end_hour]" style="width:45%;display:inline-block;">
                      <option value="">hour</option>
                      <?php if(isset($hours) && count($hours) > 0) {?>
                        <?php foreach($hours as $k => $hour) { ?>
                        <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                    <select class="form-control" name="department[0][end_minute]" style="width:45%;display:inline-block;">
                      <option value="">minute</option>
                      <?php for($m=0;$m<60;$m++) { ?>
                      <option value="<?php echo str_pad($m,2,"0",STR_PAD_LEFT);?>"><?php echo str_pad($m,2,"0",STR_PAD_LEFT);?></option>
                      <?php } ?>
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
    
    if($('form#add_new_form #add_vdepartmentname').val() == ''){
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
    
    var all_department = true;
    $('.department_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Department Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Department Name", 
          callback: function(){}
        });
        all_department = false;
        return false;
      }else{
        all_department = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;
    if(all_department == true){
      var all_done = true;
      $('.department_s').each(function(){
        if($(this).val() != ''){
          if(!numericReg.test($(this).val())){
            // alert('Please Enter Only Number');
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter Only Number", 
              callback: function(){}
            });
            all_done = false;
            return false;
          }else{
            all_done = true;
          }
        }
      });
    }else{
      all_done = false;
    }

    if(all_done == true){
      $('#form-department').attr('action', edit_url);
      $('#form-department').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchdepartment;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vdepartmentname,
                            value: val.vdepartmentname,
                            id: val.idepartmentid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_department_search #idepartmentid').val(ui.item.id);
                
                if($('#idepartmentid').val() != ''){
                    $('#form_department_search').submit();
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

<script type="text/javascript">
  $(document).on('click', '#delete_department_btn', function(event) {
    event.preventDefault();
    var delete_department_url = '<?php echo $delete; ?>';
    delete_department_url = delete_department_url.replace(/&amp;/g, '&');
    var data = {};

    if($("input[name='selected[]']:checked").length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Select Department to Delete!', 
        callback: function(){}
      });
      return false;
    }

    $("input[name='selected[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });
    
    $("div#divLoading").addClass('show');

    $.ajax({
        url : delete_department_url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {

        if(data.success){
          $('#success_msg').html('<strong>'+ data.success +'</strong>');
          $("div#divLoading").removeClass('show');
          $('#successModal').modal('show');

          setTimeout(function(){
           $('#successModal').modal('hide');
           window.location.reload();
          }, 3000);
        }else{

          $('#error_msg').html('<strong>'+ data.error +'</strong>');
          $("div#divLoading").removeClass('show');
          $('#errorModal').modal('show');

        }


      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });
  });
</script>

<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p id="success_msg"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="errorModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger text-center">
            <p id="error_msg"></p>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
      </div>
      </div>
      
    </div>
  </div>