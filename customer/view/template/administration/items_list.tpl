<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-items').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-items">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                     <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                     <td class="text-left">Image</td>
                     <td class="text-left"><?php echo $column_itemid; ?></td>
                     <td class="text-left"><?php echo $column_itemname; ?></td>
                     <td class="text-left"><?php echo $column_itemtype; ?></td>
                     <td class="text-left"><?php echo $column_deptcode; ?></td>
                     <td class="text-left"><?php echo $column_sku; ?></td>
                     <td class="text-left"><?php echo $column_categorycode; ?></td>
                     <td class="text-left"><?php echo $column_price; ?></td>
                     <td class="text-left"><?php echo $column_qtyonhand; ?></td>
                     <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($items) { ?>
                <?php foreach ($items as $item) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($item['iitemid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $item['iitemid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $item['iitemid']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($item['image']) { ?>
                    <img src="data:image/jpeg; base64, <?php echo $item['image']; ?>" class="img-thumbnail" height="40" width="40" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $item['iitemid']; ?></td>
                  <td class="text-left"><?php echo $item['vitemname']; ?></td> 
                  <td class="text-left"><?php echo $item['vitemtype']; ?></td>
                  <td class="text-left"><?php echo $item['vdepcode']; ?></td>
                  <td class="text-left"><?php echo $item['vbarcode']; ?></td> 
                  <td class="text-left"><?php echo $item['vcategorycode']; ?></td>
                  <td class="text-left"><?php echo $item['dunitprice']; ?></td>
                  <td class="text-left"><?php echo $item['iqtyonhand']; ?></td>                  
                  <td class="text-right"><a href="<?php echo $item['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a></td>
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
</div>
<?php echo $footer; ?>