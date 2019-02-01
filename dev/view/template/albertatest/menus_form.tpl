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
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_title; ?>"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="Title" value="<?php echo isset($Title) ? $Title : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name<?php echo $entry_title; ?>" class="form-control" />
              <?php if ($error_title) { ?>
              <div class="text-danger"><?php echo $error_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_starttime; ?>"><?php echo $entry_starttime; ?></label>
            <div class="col-sm-10">
              <input type="text" name="StartTime" value="<?php echo isset($StartTime) ? $StartTime : ''; ?>" placeholder="<?php echo $entry_starttime; ?>" id="input-name<?php echo $entry_starttime; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_endtime; ?>"><?php echo $entry_endtime; ?></label>
            <div class="col-sm-10">
              <input type="text" name="EndTime" value="<?php echo isset($EndTime) ? $EndTime : ''; ?>" placeholder="<?php echo $entry_endtime; ?>" id="input-name<?php echo $entry_endtime; ?>" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_rowsize; ?>"><?php echo $entry_rowsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="RowSize" value="<?php echo isset($RowSize) ? $RowSize : ''; ?>" placeholder="<?php echo $entry_rowsize; ?>" id="input-name<?php echo $entry_rowsize; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group ">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_columnsize; ?>"><?php echo $entry_columnsize; ?></label>
            <div class="col-sm-10">
              <input type="text" name="ColumnSize" value="<?php echo isset($ColumnSize) ? $ColumnSize : ''; ?>" placeholder="<?php echo $entry_columnsize; ?>" id="input-name<?php echo $entry_columnsize; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="data:image/jpeg; base64, <?php echo $thumb; ?>" alt="" title="" height="100" width="100" /></a>
              <input type="hidden" name="image" value="<?php echo $ImageLoc; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status==$text_active) { ?>
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
</div>
<?php echo $footer; ?>