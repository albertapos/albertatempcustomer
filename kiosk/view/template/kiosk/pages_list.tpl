<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Pages</a> 
      <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-page').submit() : false;"><i class="fa fa-trash-o"></i> Delete</button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-page">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="width:1px;" class="text-center"><?php echo $column_pageid; ?></td>
                  
                  <td class="text-left"><?php echo $column_internaltitle; ?></td>
                  <td class="text-left"><?php echo $column_displaytitle; ?></td>
                  <td class="text-left"><?php echo $column_rowsize; ?></td>
                  <td class="text-left"><?php echo $column_columnsize; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($pages) { ?>
                <?php foreach ($pages as $page) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($page['PageId'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $page['PageId']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $page['PageId']; ?>" />
                    <?php } ?></td>
                   
                   <td class="text-left"><?php echo $page['PageId']; ?></td>                    
                   <td class="text-left"><?php echo $page['InternalTitle']; ?></td>
                  <td class="text-left"><?php echo $page['DisplayTitle']; ?></td>
                  <td class="text-left"><?php echo $page['RowSize']; ?></td>
                  <td class="text-left"><?php echo $page['ColumnSize']; ?></td>
                  <td class="text-right"><?php if($page['PageId']!=1 && $page['PageId'] !=2 && $page['PageId'] != 5){ ?> <a href="<?php echo $page['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View</a><?php } ?> <?php if($page['PageId']>'5'){ ?> <a href="<?php echo $page['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a><?php } ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
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
</div>
<?php echo $footer; ?>