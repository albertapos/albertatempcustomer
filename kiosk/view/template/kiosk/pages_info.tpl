<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $edit; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Cancel</a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i>Pages Display for <?php echo $DisplayTitle; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php $i=1; foreach ($pages as $page) { ?>
          <?php if($ColumnSize<5){$size = 3; } else if($ColumnSize==5 || $ColumnSize==6) {$size=2; } else { $size=1;} ?>
          <div class="col-md-<?php echo $size; ?>">
            <div class="panel panel-primary">
              <table class="table">
                <tbody>
                  <tr>
                    <td colspan="2" align="center"><?php if ($page['itemimage']) { ?>
                      <img src="data:image/jpg; base64, <?php echo $page['itemimage']; ?>" class="img-thumbnail" height="200" width="200" />
                      <?php } else { ?>
                      <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td><strong> <?php echo $page['vitemname']; ?></strong></td>
                    </tr>
                    <tr>
                    <td><strong>Price : </strong><?php echo $page['Price']; ?></td>
                  </tr>
                  <!--<tr>
                    <td><strong>Real Item :</strong><?php echo $page['RealItem']; ?></td>
                    <td><strong>More/Less Action : </strong><?php echo $page['MoreLessAction']; ?></td>
                  </tr>-->
                </tbody>
              </table>
            </div>
          </div>
          <?php $divider = ($ColumnSize<1)?'3':$ColumnSize; if($i%$divider == 0) { ?>
         	</div><div class="row">
          <?php } ?>
          <?php $i++;} ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 