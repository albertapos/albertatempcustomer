<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user-groups" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user-groups" class="form-horizontal">
          
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-group-name"><?php echo $entry_group_name; ?></label>
                <div class="col-sm-10">
                  <input type="hidden" name="ipermissiongroupid" value="<?php echo !empty($_GET['ipermissiongroupid']) ? $_GET['ipermissiongroupid'] : '';  ?>">
                  <input type="text" name="vgroupname" value="<?php echo isset($vgroupname) ? $vgroupname : ''; ?>" placeholder="<?php echo $entry_group_name; ?>" id="input-group-name<?php echo $entry_group_name; ?>" class="form-control" readonly/>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-group-permission"><?php echo $entry_permission; ?></label>
                <div class="col-sm-10">
                  <select name="vpermissioncode[]" id="input-group-permission" class="form-control" multiple='true'>
                  <?php foreach ($user_permissions as $key => $user_permission) { ?>
                  <?php $y_permissioncode = false; ?>
                    <?php foreach ($before_permissions as $before_permission) { ?>
                      <?php if($before_permission['vpermissioncode'] == $user_permission['vpermissioncode']){ 
                         $y_permissioncode = true; 
                      } ?>
                    <?php } ?>
                    <?php if($y_permissioncode == true){ ?>
                      <option value="<?php echo $user_permission['vpermissioncode']; ?>" selected="selected"><?php echo $user_permission['vdesc']; ?></option>
                    <?php }else{ ?>
                      <option value="<?php echo $user_permission['vpermissioncode']; ?>"><?php echo $user_permission['vdesc']; ?></option>
                    <?php } ?>
                  <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-group-status"><?php echo $entry_Status; ?></label>
                <div class="col-sm-10">
                <input type="text" name="estatus" value="<?php echo isset($estatus) ? $estatus : ''; ?>" id="" class="form-control" readonly/>
                </div>
              </div>
         
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?>