<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Cancel</a></div>
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
        <h3 class="panel-title"><i class="fa fa-info-circle"></i>Menu Display</h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <?php $i=1;foreach ($menus as $menu) { ?>
          <?php if($ColumnSize<5){$size = 3; } else if($ColumnSize==5 || $ColumnSize==6) {$size=2; } else { $size=1;} ?>
          <div class="col-md-<?php echo $size; ?>">
            <div class="panel panel-primary">
              <table class="table">
                <tbody>
                  <tr>
                    <td colspan="2" align="center"><?php if ($menu['ImageLoc']) { ?>
                      <img src="data:image/jpg; base64, <?php echo $menu['ImageLoc']; ?>" class="img-thumbnail" height="200" width="200" />
                      <?php } else { ?>
                      <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                      <?php } ?></td>

                  </tr>
                  <tr>
                    <td><strong>Menu - </strong><?php echo $menu['Title']; ?> </td>
                    <td><strong>Category  -</strong> <?php echo $menu['Category']; ?></td>                    
                    </tr>
				  <tr>
                    <td><strong>Status -</strong> <?php echo $menu['Status']; ?></td>
                    <td><strong>Sequence -</strong> <?php echo $menu['Sequence']; ?></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <?php if($i% $ColumnSize == 0) { ?>
         	</div><div class="row">
          <?php  } ?>
          <?php $i++;} ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 