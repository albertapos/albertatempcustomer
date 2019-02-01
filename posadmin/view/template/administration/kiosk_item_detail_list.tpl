<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        <?php if(isset($p_start_date)){ ?>
        <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        <a href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
        <?php } ?>
      </div>
      <div class="panel-body">
        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Start Date">
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="<?php echo isset($p_end_date) ? $p_end_date : ''; ?>" id="end_date" placeholder="End Date">
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Filter">
            </div>
          </form>
        </div>
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br><br><br>
        <div class="row">
          <div class="col-md-12">
            <p><b>Date Range: </b><?php echo $p_start_date; ?> to <?php echo $p_end_date; ?></p>
          </div>
          <div class="col-md-12">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;width:40%;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th class="text-right">Total Qty</th>
                  <th class="text-right">Total Amt</th>
                  <th class="text-right">Total Up Sale Qty</th>
                  <th class="text-right">Total Up Sale Amt</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td class="text-right"><?php echo empty($value['totalqty']) ? 0 : $value['totalqty'] ; ?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalamount'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo empty($value['totalupsaleqty']) ? 0 : $value['totalupsaleqty'] ; ?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalupsaleamount'], 2, '.', '') ;?></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php }else{ ?>
          <?php if(isset($p_start_date)){ ?>
            <div class="row">
              <div class="col-md-12"><br><br>
                <div class="alert alert-info text-center">
                  <strong>Sorry no data found!</strong>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div id="divLoading"></div>

<?php echo $footer; ?>
<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/jquery.printPage.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
  $(function(){
    $("#start_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });

    $("#end_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

<script type="text/javascript">

$(document).on('submit', '#filter_form', function(event) {

  if($('#start_date').val() == ''){
    alert('Please Select Start Date');
    return false;
  }

  if($('#end_date').val() == ''){
    alert('Please Select End Date');
    return false;
  }
  
});
</script>

<style type="text/css">

  #divLoading{
    display : none;
  }
  #divLoading.show{
    display : block;
    position : fixed;
    z-index: 100;
    background-image : url('view/image/loading1.gif');
    background-color:#666;
    opacity : 0.9;
    background-repeat : no-repeat;
    background-position : center;
    left : 0;
    bottom : 0;
    right : 0;
    top : 0;
    background-size: 250px;
  }

  #loadinggif.show{
    left : 50%;
    top : 50%;
    position : absolute;
    z-index : 101;
    width : 32px;
    height : 32px;
    margin-left : -16px;
    margin-top : -16px;
  }

  div.content {
   width : 1000px;
   height : 1000px;
  }

  .table.table-bordered.table-striped.table-hover thead > tr {
    background-color: #2486c6;
    color: #fff;
  }

</style>

<script>  
$(document).ready(function() {
  $("#btnPrint").printPage();
});
</script>