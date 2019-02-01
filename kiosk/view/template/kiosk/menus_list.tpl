<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
	  <a onclick="$('#form-menu').attr('action', '<?php echo $edit_list; ?>'); $('#form-menu').submit();" class="btn btn-primary"><i class="fa fa-save"></i> Save</a>
	 <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
     <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-menu').submit() : false;"><i class="fa fa-trash-o"></i> Delete</button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-menu">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                   <td style="width:1px;" class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php echo $column_title; ?></td>
                  <td class="text-left"><?php echo $column_starttime; ?></td>
                  <td class="text-left"><?php echo $column_endtime; ?></td>
                  <td class="text-left"><?php echo $column_rowsize; ?></td>
                  <td class="text-left"><?php echo $column_columnsize; ?></td>
				  <td class="text-left"><?php echo $column_status; ?></td>
                  <td class="text-left"><?php echo $column_lastupdate; ?></td>                  
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($menus) { ?>
                <?php foreach ($menus as $menu) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($menu['MenuId'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="menu[<?php echo $menu['MenuId']; ?>][select]"  value="<?php echo $menu['MenuId']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="menu[<?php echo $menu['MenuId']; ?>][select]" value="<?php echo $menu['MenuId']; ?>" />
                    <?php } ?></td>
                   <td class="text-center"><?php if ($menu['ImageLoc']) { ?>
                   <img src="data:image/jpeg; base64, <?php echo $menu['ImageLoc']; ?>" id="desp_image<?php echo $menu['MenuId']; ?>" height="30" width="30" style="cursor:pointer;" onclick="openbrowse('<?php echo $menu['MenuId']; ?>')"/>
                   <input type="file" name="menu[<?php echo $menu['MenuId']; ?>][image]" id="input-image<?php echo $menu['MenuId']; ?>"  style="display:none;" onchange="readURL(this,'<?php echo $menu['MenuId']; ?>')" />
                   <input type="hidden" name="menu[<?php echo $menu['MenuId']; ?>][imagehidden]" value="<?php echo $menu['ImageLoc']; ?>" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                   <td class="text-left"><input type="text" class="editable" name="menu[<?php echo $menu['MenuId']; ?>][Title]" id="menu[<?php echo $menu['MenuId']; ?>][Title]" value="<?php echo $menu['Title']; ?>" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");' />
				   <input type="hidden" name="menu[<?php echo $menu['MenuId']; ?>][MenuId]" value="<?php echo $menu['MenuId']; ?>" />
				   </td>
                  
				  <td class="text-left"><input type="text" class="editable" name="menu[<?php echo $menu['MenuId']; ?>][StartTime]" id="menu[<?php echo $menu['MenuId']; ?>][StartTime]" value="<?php echo $menu['StartTime']; ?>" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");' /></td>
                  
				  <td class="text-left"><input type="text" class="editable" name="menu[<?php echo $menu['MenuId']; ?>][EndTime]" id="menu[<?php echo $menu['MenuId']; ?>][EndTime]" value="<?php echo $menu['EndTime']; ?>" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");' /></td>
                
				  <td class="text-left"><input type="text" class="editable" name="menu[<?php echo $menu['MenuId']; ?>][RowSize]" id="menu[<?php echo $menu['MenuId']; ?>][RowSize]" value="<?php echo $menu['RowSize']; ?>" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");' /></td>
                 
				  <td class="text-left"><input type="text" class="editable" name="menu[<?php echo $menu['MenuId']; ?>][ColumnSize]" id="menu[<?php echo $menu['MenuId']; ?>][ColumnSize]" value="<?php echo $menu['ColumnSize']; ?>" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");' /></td>
                  
				  <td class="text-left"><select name="menu[<?php echo $menu['MenuId']; ?>][Status]" id="menu[<?php echo $menu['MenuId']; ?>][Status]" class="form-control" onchange='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($menu['Status']==$text_active) { ?>
                      <option value="<?php echo $text_active; ?>" selected="selected"><?php echo $text_active; ?></option>
                      <option value="<?php echo $text_inactive; ?>" ><?php echo $text_inactive; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $text_active; ?>"><?php echo $text_active; ?></option>
                      <option value="<?php echo $text_inactive; ?>" selected="selected"><?php echo $text_inactive; ?></option>
                      <?php } ?>
                    </select></td>
                  <td class="text-left"><?php echo $menu['LastUpdate']; ?></td>
				  <td class="text-right"><a class="btn btn-sm btn-success up" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");'><i class="fa fa-arrow-up"></i> Up</a> <a class="btn btn-sm btn-warning down" onclick='document.getElementById("menu[<?php echo $menu['MenuId']; ?>][select]").setAttribute("checked","checked");'><i class="fa fa-arrow-down"></i> Down</a> <a href="<?php echo $menu['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View</a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
                </tr>
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
}
function openbrowse(id)
{
	 $('#input-image'+id).css("display","");	
}
</script> 
</div>
<?php echo $footer; ?>