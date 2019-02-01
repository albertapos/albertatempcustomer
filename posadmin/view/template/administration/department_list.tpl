<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
        <button type="button" onclick="addDepartment();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>        
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
        
        <form action="" method="post" enctype="multipart/form-data" id="form-department">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="department" class="table table-bordered table-hover" style="width:60%;">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="width:1px;" class="text-center"><?php echo $column_department_name; ?></th>
                  <th class="text-center"><?php echo $column_description; ?></th>
                  <th class="text-center"><?php echo $column_sequence; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($departments) { ?>
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
                    <span style="display:none;"><?php echo $department['vdepartmentname']; ?></span>
                    <input type="text" class="editable department_c" name="department[<?php echo $i; ?>][vdepartmentname]" id="department[<?php echo $i; ?>][vdepartmentname]" value="<?php echo $department['vdepartmentname']; ?>" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");' />
          				  <input type="hidden" name="department[<?php echo $i; ?>][idepartmentid]" value="<?php echo $department['idepartmentid']; ?>"/>
        				  </td>
                  <td class="text-left">
                    <textarea class="editable" name="department[<?php echo $i; ?>][vdescription]" id="department[<?php echo $i; ?>][vdescription]" onclick='document.getElementById("department[<?php echo $department_row; ?>][select]").setAttribute("checked","checked");'><?php echo $department['vdescription']; ?></textarea>
                  </td>
                  
                    <td class="text-left">
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
	
		html  = '<tr id="department-row' + department_row + '">';

		  html += '  <td class="text-left"><input type="checkbox" name="selected[]" id="department['+ department_row +'][select]"/></td>';
      html += ' <input type="hidden" name="department[' + department_row + '][idepartmentid]" value="0"/>';

		 html += '  <td class="text-right"><input type="text" name="department[' + department_row + '][vdepartmentname]" value="" placeholder="<?php echo $entry_department_name; ?>" class="form-control department_c" /></td>';
		html += '  <td class="text-right"><textarea name="department[' + department_row + '][vdescription]" placeholder="<?php echo $entry_description; ?>" class="form-control" ></textarea></td>';

    html += '  <td class="text-right"><input type="text" name="department[' + department_row + '][isequence]" value="" placeholder="<?php echo $entry_sequence; ?>" class="form-control department_s" /></td>';
		
		html += '  <td class="text-right">   <button type="button" onclick="$(\'#department-row' + department_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-sm btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
	
		$('#department tbody').append(html);
	
		department_row++;
	
}

//--></script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();

    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_department = true;
    $('.department_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Department Name');
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
            alert('Please Enter Only Number');
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
    }
  });
</script>

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#department').DataTable({
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
  #department_filter, #department_paginate{
    float: right;
  }
  #department_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#department_length').parent().hide();
    $('#department_info').parent().hide();

    $('#department_filter').css('float','left');
    $('#department_paginate').css('float','left');

    $('#department_filter').find('input[type="search"]').css('width','200%');

  });
</script>

<!-- DataTables -->
<?php echo $footer; ?>