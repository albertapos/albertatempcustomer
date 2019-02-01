<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a onclick="$('#form-category').attr('action', '<?php echo $edit_list; ?>'); $('#form-category').submit();" class="btn btn-primary"><i class="fa fa-save"></i> Save</a>
        <button type="button" onclick="addCategory();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>    
        
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-category').submit() : false;"><i class="fa fa-trash-o"></i> Delete</button>    
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
        <div class="well">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-inline">
                <label class="control-label" for="input-customer-group">Menu : </label>
                <select name="MenuId" id="MenuId" class="form-control" onchange="filterpage()">
                  <option value="">-- Select Menu --</option>
                  <?php foreach ($menus as $menu) { ?>
                  <?php if ($menu['MenuId'] == $filter_menuid) { ?>
                  <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-category">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
          <p style="color:#900; font-weight:bold; font-size:12px;">For Image max file size 600(h) or 600(w) and only .jpeg file type allowed</p>
            <table id="category" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="width: 163px;" class="text-left"><?php echo $column_image; ?><br /></td>
                  <td class="text-left"><?php echo $column_category; ?></td>
                  <td class="text-left">Row Size</td>
                  <td class="text-left">Column Size</td>
                  <td class="text-left"><?php echo $column_status; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($categories) { ?>
                <?php $category_row = 0;$i=0; ?>
                <?php foreach ($categories as $key=>$category) { ?>
                <tr id="category-row<?php echo $category_row; ?>">
                  <td class="text-center"><?php if (in_array($category['CategoryId'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $i; ?>][select]" value="<?php echo $category['CategoryId']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $i; ?>][select]"  value="<?php echo $category['CategoryId']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($category['image']) { ?>
                  <img src="data:image/jpeg; base64, <?php echo $category['image']; ?>" id="desp_image<?php echo $i; ?>" height="30" width="30" style="cursor:pointer;" onclick="openbrowse('<?php echo $i; ?>')"/>
                  
                   <input type="file" name="category[<?php echo $i; ?>][image]" id="input-image<?php echo $i; ?>"  style="display:none;" onchange="readURL(this,'<?php echo $i; ?>')" />
                   <input type="hidden" name="category[<?php echo $i; ?>][imagehidden]" id="hidden-image<?php echo $i; ?>" value="<?php echo $category['image']; ?>" />
                  <?php if(isset($error['category'][$key]['image'])) { ?>
                  <div class="text-danger"><?php echo $error['category'][$key]['image']; ?></div>
                  <?php } ?>
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><input type="text" class="editable" name="category[<?php echo $i; ?>][Category]" id="category[<?php echo $i; ?>][Category]" value="<?php echo $category['Category']; ?>" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");' />
				  <input type="hidden" name="category[<?php echo $i; ?>][CategoryId]" value="<?php echo $category['CategoryId']; ?>"/>
				  </td>
                  <td class="text-left"><input type="text" class="editable" name="category[<?php echo $i; ?>][RowSize]" id="category[<?php echo $i; ?>][RowSize]" value="<?php echo $category['RowSize']; ?>" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");' /></td>
                  <td class="text-left"><input type="text" class="editable" name="category[<?php echo $i; ?>][ColumnSize]" id="category[<?php echo $i; ?>][ColumnSize]" value="<?php echo $category['ColumnSize']; ?>" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");' /></td>
                  <td class="text-right">
                  <select name="category[<?php echo $i; ?>][Status]" id="category[<?php echo $i; ?>][Status]" class="form-control" onchange='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($category['Status']==$text_active) { ?>
                      <option value="<?php echo $text_active; ?>" selected="selected"><?php echo $text_active; ?></option>
                      <option value="<?php echo $text_inactive; ?>" ><?php echo $text_inactive; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $text_active; ?>"><?php echo $text_active; ?></option>
                      <option value="<?php echo $text_inactive; ?>" selected="selected"><?php echo $text_inactive; ?></option>
                      <?php } ?>
                    </select></td>
                  <td class="text-right"><a class="btn btn-sm btn-success up" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");'><i class="fa fa-arrow-up"></i> Up</a> <a class="btn btn-sm btn-warning down"><i class="fa fa-arrow-down"></i> Down</a> <a href="<?php echo $category['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-sm btn-info" onclick='document.getElementById("category[<?php echo $category['CategoryId']; ?>][select]").setAttribute("checked","checked");'><i class="fa fa-eye"></i> View</a></td>
                </tr>
                <?php $category_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                <?php if($filter_menuid!=""){ ?>
                 <?php $category_row = 1;$i=0; ?>
                <tr id="category-row<?php echo $category_row; ?>">
                  <td class="text-center"><input type="checkbox" name="selected[]" /></td>
                  <td class="text-center">
                  
                  <img src="data:image/jpeg; base64, <?php echo $category['image']; ?>" id="desp_image<?php echo $i; ?>" height="30" width="30" style="cursor:pointer;" onclick="openbrowse('<?php echo $i; ?>')"/>
                  
                   <input type="file" name="category[<?php echo $i; ?>][image]" id="input-image<?php echo $i; ?>"  style="display:none;" onchange="readURL(this,'<?php echo $i; ?>')" />
                   <input type="hidden" name="category[<?php echo $i; ?>][imagehidden]" id="hidden-image<?php echo $i; ?>" value="<?php echo $category['image']; ?>" />
                   
                  
                  
                  <td class="text-left"><input type="text" name="category[<?php echo $i; ?>][Category]" class="form-control" placeholder="<?php echo $entry_category; ?>"/>
                  <input type="hidden" name="category[<?php echo $i; ?>][CategoryId]" value=""/>
                  </td>
                  <td class="text-left"><input type="text" name="category[<?php echo $i; ?>][RowSize]" value="4"  class="form-control" placeholder="<?php echo $entry_rowsize; ?>"/></td>
                  <td class="text-left"><input type="text"  name="category[<?php echo $i; ?>][ColumnSize]"  value="4" class="form-control" placeholder="<?php echo $entry_columnsize; ?>"/></td>
                  <td class="text-right"><select name="category[<?php echo $i; ?>][Status]" class="form-control" onchange="">
                      <option value="<?php echo $text_active; ?>" selected="selected"><?php echo $text_active; ?></option>
                      <option value="<?php echo $text_inactive; ?>" ><?php echo $text_inactive; ?></option>
                    </select></td>
                  <td class="text-right"></td>
                </tr>
                <?php $category_row++;$i++;}else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=kiosk/category&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=kiosk/category&token=<?php echo $token; ?>';
	
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
	var menuidval= $("#MenuId option:selected").val();
	
	if(menuidval=="")
	{
		alert("Please select menu.");
		return false;	
	}
	else
	{	
		html  = '<tr id="category-row' + category_row + '">';

		  html += '  <td class="text-left"><input type="checkbox" name="selected[]" id="category['+ category_row +'][select]"/></td>';
		 
		 html += '  <td class="text-center"><img src="data:image/jpeg; base64, <?php echo $placeholder; ?>" id="desp_image' + category_row + '" height="40" width="40" /><input type="file" name="category[' + category_row + '][image]" id="input-image' + category_row + '"   onchange="readURL(this,' + category_row + ')" /><input type="hidden" name="category[' + category_row + '][imagehidden]" value="" id="input-image' + category_row + '" /></td>';
			
		html += '  <td class="text-right"><input type="text" name="category[' + category_row + '][Category]" value="" placeholder="<?php echo $entry_category; ?>" class="form-control" /><input type="hidden" name="category[' + category_row + '][CategoryId]" value=""/></td>';
		html += '  <td class="text-right"><input type="text" name="category[' + category_row + '][RowSize]" value="4" placeholder="<?php echo $entry_rowsize; ?>" class="form-control" /></td>';
		html += '  <td class="text-right"><input type="text" name="category[' + category_row + '][ColumnSize]" value="4" placeholder="<?php echo $entry_columnsize; ?>" class="form-control" /></td>';
		
		html += '  <td class="text-right"><select name="category[' + category_row + '][Status]" id="category[' + category_row + '][Status]" class="form-control "><option value="<?php echo $text_active; ?>" selected="selected"><?php echo $text_active; ?></option><option value="<?php echo $text_inactive; ?>" ><?php echo $text_inactive; ?></option></select></td>';
		
		html += '  <td class="text-right">   <button type="button" onclick="$(\'#category-row' + category_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-sm btn-danger"><i class="fa fa-minus-circle"></i> Delete Row</button></td>';
		html += '</tr>';
	
		$('#category tbody').append(html);
	
		category_row++;
	}
}

//--></script>
<script>
function readURL(input,id) {
var brimage='';

	if (input.files && input.files[0]) {
		var reader = new FileReader();
	
		reader.onload = function (e) {
			$('#desp_image'+id).attr('src', e.target.result);
			
		}	
		brimage =input.files[0];
		reader.readAsDataURL(input.files[0]);
	}
	
	 $('#input-image'+id).css("display","none");
	 $('#hidden-image'+id).val("");
}
function openbrowse(id)
{
	 $('#input-image'+id).css("display","");	
}
</script>  
<?php echo $footer; ?>