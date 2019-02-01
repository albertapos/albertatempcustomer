<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
        <h3 class="panel-title"><i class="fa fa-info-circle"></i><?php echo $categorys['vcategoryname']; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
            <br>          
              <table class="table table-bordered">
                  <tr>
                    <td><h4 style="font-weight:bold;">Category ID</h4></td>
                    <td><?php echo $categorys['icategoryid']; ?></td>
                  </tr>
                   <tr>
                    <td><h4 style="font-weight:bold;">Category Name</h4></td>
                    <td><?php echo $categorys['vcategoryname']; ?></td>
                  </tr>
                   <tr>
                    <td><h4 style="font-weight:bold;">Category Description</h4></td>
                    <td><?php echo $categorys['vdescription']; ?></td>
                  </tr>
                   <tr>
                    <td><h4 style="font-weight:bold;">Category Type</h4></td>
                    <td><?php echo $categorys['vcategorttype']; ?></td>
                  </tr>
                   <tr>
                    <td><h4 style="font-weight:bold;">Category Sequence</h4></td>
                    <td><?php echo $categorys['isequence']; ?></td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  table tr td:first-child{
    width: 25%;
  }
</style>
<?php echo $footer; ?> 