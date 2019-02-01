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
    <?php if ($error_pageflowlast) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_pageflowlast; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pages" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name<?php echo $entry_menu; ?>"><?php echo $entry_menu;?></label>
            <div class="col-sm-10">
              <select name="MenuDetailId" id="input-menu" class="form-control">
                <option value="">-- Select Menu --</option>
                <?php foreach ($menu_items as $menu_item) { ?>
                <?php if ($menu_item['MenuDetailId'] == $MenuDetailId) { ?>
                <option value="<?php echo $menu_item['MenuDetailId']; ?>" selected="selected"><?php echo $menu_item['vitemname']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $menu_item['MenuDetailId']; ?>"><?php echo $menu_item['vitemname']; ?> [<?php echo $menu_item['MenuDetailId']; ?>]</option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_menu) { ?>
              <div class="text-danger"><?php echo $error_menu; ?></div>
              <?php } ?>
            </div>
          </div>
          <div>
          <?php $pages_row = 1;?>
          <?php if(isset($pageflows) && count($pageflows) > 0 ) { ?>
          <?php $i=1;foreach($pageflows as $pageflow) { ?>
          <div class="col-md-4">
            <?php if($pageflow['PageId']==0) {?>
            <div class="panel panel-primary">
              <?php }else {?>
              <div class="panel panel-warning">
                <?php }?>
                <table class="table">
                  <tbody>
                    <tr>
                      <td><input type="hidden" name="pageflow[<?php echo $i; ?>][ReceiptPrintSeq]" value="<?php echo $i; ?>" />
                        <label>Seq No :- </label> <?php echo $i; ?></td>
                    </tr>
                    <tr>
                      <td>
                      <select name="pageflow[<?php echo $i; ?>][PageId]" class="form-control">
                          <option value="">-- Select Page --</option>
                          <?php foreach ($pages as $page) { ?>
                          <?php if ($page['PageId'] == $pageflow['PageId']) { ?>
                          <option value="<?php echo $page['PageId']; ?>" selected="selected"><?php echo addslashes($page['InternalTitle']); ?> [<?php echo $page['PageId']; ?>]</option>
                          <?php } else { ?>
                          <option value="<?php echo $page['PageId']; ?>"><?php echo addslashes($page['InternalTitle']); ?> [<?php echo $page['PageId']; ?>]</option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td><select name="pageflow[<?php echo $i; ?>][Action]" class="form-control">
                          <option value="">-- Select Action --</option>
                          <option value="Single" <?php if ($pageflow['Action'] == 'Single') { ?> selected="selected" <?php } ?> >Single</option>
                          <option value="Multi" <?php if ($pageflow['Action'] == 'Multi') { ?> selected="selected" <?php } ?> >Multi</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><label><?php echo $entry_freetopings; ?> : </label>
                        <input type="text" name="pageflow[<?php echo $i; ?>][FreeTopingsCt]" value="<?php echo $pageflow['FreeTopingsCt']; ?>" placeholder="<?php echo $entry_freetopings; ?>"/></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <?php $i++; } ?>
            <?php for($i=count($pageflows)+1;$i<=20;$i++) { $PageId=''; ?>
            <div class="col-md-4">
              <div class="panel panel-primary">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><input type="hidden" name="pageflow[<?php echo $i; ?>][ReceiptPrintSeq]" value="<?php echo $i; ?>" />
                         <label>Seq No :- </label> <?php echo $i; ?></td>
                    </tr>
                    <tr>
                      <td align="center"><select name="pageflow[<?php echo $i; ?>][PageId]" id="pageflow[<?php echo $i; ?>][PageId]" class="form-control">
                          <option value="">-- Select Page --</option>
                          <?php foreach ($pages as $page) { ?>
                          <option value="<?php echo $page['PageId']; ?>"><?php echo addslashes($page['InternalTitle']); ?> [<?php echo $page['PageId']; ?>]</option>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <tr>
                      <td align="center"><select name="pageflow[<?php echo $i; ?>][Action]" class="form-control">
                          <option value="">-- Select Action --</option>
                          <option value="Single">Single</option>
                          <option value="Multi" >Multi</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><label><?php echo $entry_freetopings; ?> : </label>
                        <input type="text" name="pageflow[<?php echo $i; ?>][FreeTopingsCt]" value="<?php echo $pageflow['FreeTopingsCt']; ?>" placeholder="<?php echo $entry_freetopings; ?>"/></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>