<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <!-- <h1><?php echo $heading_title; ?></h1> -->
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
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
          
        <form action="<?php echo $edit;?>" method="post" enctype="multipart/form-data" id="form-end-of-shift-printing">
          <div class="row">
            <div class="col-md-12">
              <fieldset class="the_fieldset">
                <legend class="the_legend">POS Setting</legend>
                <p><b>Enable End of Shift Printing:&nbsp;&nbsp;&nbsp;</b><input style="top: 4px;" value="1" type="checkbox" name="EndOfShiftPrinting" <?php if(isset($EndOfShiftPrinting) && isset($EndOfShiftPrinting['variablename']) && $EndOfShiftPrinting['variablevalue'] == 1){?> checked <?php } ?> ></p>
              </fieldset>
            </div>
          </div>
          <br>
          <br>
          <fieldset class="the_fieldset">
            <legend class="the_legend">Kiosk Setting</legend>
          <div class="row">
            <div class="col-md-12">
              <p><b>Enable Print Delivery Station:&nbsp;&nbsp;&nbsp;</b><input style="top: 4px;" value="1" type="checkbox" name="PrintDeliveryStation" <?php if(isset($PrintDeliveryStation) && isset($PrintDeliveryStation['variablename']) && $PrintDeliveryStation['variablevalue'] == 1){?> checked <?php } ?> ></p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <p><b>Enable Print Deli Itemwise:&nbsp;&nbsp;&nbsp;</b><input style="top: 4px;" value="1" type="checkbox" name="PrintDeliItemwise" <?php if(isset($PrintDeliItemwise) && isset($PrintDeliItemwise['variablename']) && $PrintDeliItemwise['variablevalue'] == 1){?> checked <?php } ?> ></p>
            </div>
          </div>
          </fieldset>
        </form>
        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    $('#form-end-of-shift-printing').submit();
    $("div#divLoading").addClass('show');
  });
</script>

<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>