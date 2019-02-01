<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Cancel</a></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          
                <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-menu"><?php echo $entry_menu; ?></label>
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
                      <?php } ?>
                </div>
              </div>
              
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $entry_category; ?>"><?php echo $entry_category; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category" value="<?php echo isset($category) ? $category : ''; ?>" placeholder="<?php echo $entry_category; ?>" id="input-name<?php echo $entry_category; ?>" class="form-control" />
                      <?php if ($error_category) { ?>
                      <div class="text-danger"><?php echo $error_category; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $entry_sequence; ?>"><?php echo $entry_sequence; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="sequence" value="<?php echo isset($sequence) ? $sequence : ''; ?>" placeholder="<?php echo $entry_sequence; ?>" id="input-name<?php echo $entry_sequence; ?>" class="form-control" />
                      <?php if ($error_sequence) { ?>
                      <div class="text-danger"><?php echo $error_sequence; ?></div>
                      <?php } ?>
                    </div>                      
                  
                  </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_rowsize; ?>"><?php echo $entry_rowsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="RowSize" value="<?php echo isset($RowSize) ? $RowSize : ''; ?>" placeholder="<?php echo $entry_rowsize; ?>" id="input-name<?php echo $entry_rowsize; ?>" class="form-control" />
              <?php if ($error_rowsize) { ?>
              <div class="text-danger"><?php echo $error_rowsize; ?></div>
              <?php } ?>
               
            </div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_columnsize; ?>"><?php echo $entry_columnsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="ColumnSize" value="<?php echo isset($ColumnSize) ? $ColumnSize : ''; ?>" placeholder="<?php echo $entry_columnsize; ?>" id="input-name<?php echo $entry_columnsize; ?>" class="form-control" />
              <?php if ($error_columnize) { ?>
              <div class="text-danger"><?php echo $error_columnize; ?></div>
              <?php } ?>
            </div>
          </div>
                  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="data:image/jpeg; base64, <?php echo $thumb; ?>" alt="" title=""  height="100" width="100"/></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>
              
                  
                <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php echo $status; if ($status==$text_active) { ?>
                    <option value="<?php echo $text_active; ?>" selected="selected"><?php echo $text_active; ?></option>
                    <option value="<?php echo $text_inactive; ?>" ><?php echo $text_inactive; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $text_active; ?>"><?php echo $text_active; ?></option>
                    <option value="<?php echo $text_inactive; ?>" selected="selected"><?php echo $text_inactive; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
                
               
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=akiosk/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					category_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=kiosk/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#category-filter' + item['value']).remove();

		$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script> 
</div>
<?php echo $footer; ?>