<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
        <button type="button" onclick="addCategory();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>        
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
        
        <form action="" method="post" enctype="multipart/form-data" id="form-category">
        <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="">
            <table id="category" class="table table-bordered table-hover" style="width:60%;">
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="width:1px;" class="text-center"><?php echo $column_category_name; ?></th>
                  <th class="text-center"><?php echo $column_description; ?></th>
                  <th class="text-center"><?php echo $column_category_type; ?></th>
                  <th class="text-center"><?php echo $column_sequence; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($categories) { ?>
                <?php $category_row = 1;$i=0; ?>
                <?php foreach ($categories as $category) { ?>
                <tr id="category-row<?php echo $category_row; ?>">
                  <td data-order="<?php echo $category['icategoryid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $category['icategoryid']; ?></span>
                  <?php if (in_array($category['icategoryid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $category_row; ?>][select]" value="<?php echo $category['icategoryid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $category_row; ?>][select]"  value="<?php echo $category['icategoryid']; ?>" />
                    <?php } ?>
                  </td>
                  
                  <td class="text-left">
                    <span style="display:none;"><?php echo $category['vcategoryname']; ?></span>
                    <input type="text" class="editable categories_c" name="category[<?php echo $i; ?>][vcategoryname]" id="category[<?php echo $i; ?>][vcategoryname]" value="<?php echo $category['vcategoryname']; ?>" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");' />
        				    <input type="hidden" name="category[<?php echo $i; ?>][icategoryid]" value="<?php echo $category['icategoryid']; ?>"/>
        				  </td>
                  <td class="text-left"><textarea class="editable" name="category[<?php echo $i; ?>][vdescription]" id="category[<?php echo $i; ?>][vdescription]" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");'><?php echo $category['vdescription']; ?></textarea></td>
                  
                  <td class="text-right">
                  <select name="category[<?php echo $i; ?>][vcategorttype]" id="category[<?php echo $i; ?>][vcategorttype]" class="form-control" onchange='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($category['vcategorttype']==$Sales) { ?>
                      <option value="<?php echo $Sales; ?>" selected="selected"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" ><?php echo $MISC; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $Sales; ?>"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" selected="selected"><?php echo $MISC; ?></option>
                      <?php } ?>
                    </select></td>
                    <td class="text-left"><input type="text" class="editable categories_s" name="category[<?php echo $i; ?>][isequence]" id="category[<?php echo $i; ?>][isequence]" value="<?php echo $category['isequence']; ?>" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");' /></td>
                </tr>
                <?php $category_row++; $i++;?>
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
	url = 'index.php?route=administration/category&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/category&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var category_row = <?php echo $category_row; ?>;

function addCategory() {
	
		html  = '<tr id="category-row' + category_row + '">';

		  html += '  <td class="text-left"><input type="checkbox" name="selected[]" id="category['+ category_row +'][select]"/></td>';
      html += ' <input type="hidden" name="category[' + category_row + '][icategoryid]" value="0"/>';

		 html += '  <td class="text-right"><input type="text" name="category[' + category_row + '][vcategoryname]" value="" placeholder="<?php echo $entry_category_name; ?>" class="form-control categories_c" /></td>';
		html += '  <td class="text-right"><textarea name="category[' + category_row + '][vdescription]" placeholder="<?php echo $entry_description; ?>" class="form-control" ></textarea></td>';
		
		html += '  <td class="text-right"><select name="category[' + category_row + '][vcategorttype]" id="category[' + category_row + '][vcategorttype]" class="form-control "><option value="<?php echo $Sales; ?>" selected="selected"><?php echo $Sales; ?></option><option value="<?php echo $MISC; ?>" ><?php echo $MISC; ?></option></select></td>';

    html += '  <td class="text-right"><input type="text" name="category[' + category_row + '][isequence]" value="" placeholder="<?php echo $entry_sequence; ?>" class="form-control categories_s" /></td>';
		
		html += '  <td class="text-right">   <button type="button" onclick="$(\'#category-row' + category_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-sm btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
	
		$('#category tbody').append(html);
	
		category_row++;
	
}

//--></script> 

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_category = true;
    
    $('.categories_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Category Name');
        all_category = false;
        return false;
      }else{
        all_category = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;

    if(all_category == true){
      var all_done = true;
      $('.categories_s').each(function(){
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
      $('#form-category').attr('action', edit_url);
      $('#form-category').submit();
    }
  });
</script>

<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#category').DataTable({
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
  #category_filter, #category_paginate{
    float: right;
  }
  #category_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#category_length').parent().hide();
    $('#category_info').parent().hide();

    $('#category_filter').css('float','left');
    $('#category_paginate').css('float','left');

    $('#category_filter').find('input[type="search"]').css('width','200%');

  });
</script>
<!-- DataTables -->
<?php echo $footer; ?>