<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-page" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-menu" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_menu; ?>"><?php echo $entry_menu; ?></label>
            <div class="col-sm-10">
              <select name="MenuId" id="input-menu" class="form-control">
                <option value="">-- Select Menu --</option>
                <?php foreach ($menus as $menu) { ?>
                <?php if ($menu['MenuId'] == $MenuId) { ?>
                <option value="<?php echo $menu['MenuId']; ?>" selected="selected"><?php echo $menu['Title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $menu['MenuId']; ?>"><?php echo $menu['Title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            
            <?php if ($error_menu) { ?>
            <div class="text-danger"><?php echo $error_menu; ?></div>
            <?php } ?></div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_category; ?>"><?php echo $entry_category; ?></label>
            <div class="col-sm-10">
              <select name="CategoryId" class="form-control">
                <option value="">-- Select Category --</option>
                <?php foreach ($categorys as $category) { ?>
                <?php if ($category['CategoryId'] == $CategoryId) { ?>
                <option value="<?php echo $category['CategoryId']; ?>" selected="selected"><?php echo $category['Category']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $category['CategoryId']; ?>"><?php echo $category['Category']; ?></option>
                <?php } ?>
                <?php }?>
              </select>
           
            <?php if ($error_category) { ?>
            <div class="text-danger"><?php echo $error_category; ?></div>
            <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_itemname; ?>"><?php echo $entry_itemname; ?></label>
            <div class="col-sm-10">
              <select name="iitemid" class="form-control">
                <option value="">-- Select Item --</option>
                <?php foreach ($items as $item) { ?>
                <?php if ($item['iitemid'] == $iitemid) { ?>
                <option value="<?php echo $item['iitemid']; ?>" selected="selected"><?php echo $item['vitemname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $item['iitemid']; ?>"><?php echo $item['vitemname']; ?> [<?php echo $item['iitemid']; ?>]</option>
                <?php } ?>
                <?php }?>
              </select>
           
            <?php if ($error_item) { ?>
            <div class="text-danger"><?php echo $error_item; ?></div>
            <?php } ?> </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_displayposition; ?>"><?php echo $entry_displayposition; ?></label>
            <div class="col-sm-10">
              <input type="text" name="DisplayPosition" value="<?php echo isset($DisplayPosition) ? $DisplayPosition : ''; ?>" placeholder="<?php echo $entry_displayposition; ?>" id="input-name<?php echo $entry_displayposition; ?>" class="form-control" />
            <input type="hidden" name="old_DisplayPosition" value="<?php echo isset($DisplayPosition) ? $DisplayPosition : ''; ?>" />
            <?php if ($error_position) { ?>
            <div class="text-danger"><?php echo $error_position; ?></div>
            <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_price; ?>"><?php echo $entry_price; ?></label>
            <div class="col-sm-10">
              <input type="text" name="Price" value="<?php echo isset($Price) ? $Price : ''; ?>" placeholder="<?php echo $entry_price; ?>" id="input-name<?php echo $entry_price; ?>" class="form-control number" />
            </div>
          </div>
          <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-page" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
    </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#input-menu').on('change', function() {
	 
	/*var option = $(this).find('option:selected').val();
	 alert(option);
	$.ajax({
		type: 'post',
		url: 'index.php?route=kiosk/menu_item&token=<?php echo $token; ?>',
		dataType: 'html',
		success: function (html) {
			alert(html);	
		}
	});*/
});
//--></script> 
<?php echo $footer; ?>