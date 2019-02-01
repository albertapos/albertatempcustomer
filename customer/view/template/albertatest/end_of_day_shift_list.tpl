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

        
        <div class="clearfix"></div>
          
        <form action="" method="post" enctype="multipart/form-data" id="form-end-of-day-shift">
          <div class="row">
            <div class="col-md-3">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>" id="select_date" placeholder="Select Start Date">
            </div>
            <div class="col-md-4">
              <select name="batch[]" class="form-control" id="batch" multiple="true">
                <option value="">-- Please Select Batch --</option>
                <?php if(isset($batches) && count($batches) > 0){?>
                  <?php foreach($batches as $batch){?>
                    <?php if(isset($selected_batch_ids) && in_array($batch['ibatchid'], $selected_batch_ids)){?>
                      <option selected="selected" value="<?php echo $batch['ibatchid']?>"><?php echo $batch['vbatchname']?></option>
                    <?php } else { ?>
                      <option value="<?php echo $batch['ibatchid']?>"><?php echo $batch['vbatchname']?></option>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4">
              <input type="submit" class="btn btn-success" name="add_end_of_shift" value="Add End of Day Shift">
            </div>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<script type="text/javascript">
  $(document).on('submit', '#form-end-of-day-shift', function(event) {

    if($('#select_date').val() == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Date", 
        callback: function(){}
      });
      return false;
    }

    if($('#batch').val() == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Batch", 
        callback: function(){}
      });
      return false;
    }

    if($('#batch :selected').length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Batch", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');

  });
</script>

<script>
  $(function(){
    $("#select_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>