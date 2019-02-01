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
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">

        <?php if(isset($p_start_date)){ ?>
        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <a id="csv_export_btn" href="<?php echo $csv_export; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV</a>
            <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right" style="margin-right:10px;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
            <a id="pdf_export_btn" href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
          </div>
        </div>
        <?php } ?>
        <div class="clearfix"></div>

        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Start Date" readonly>
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="<?php echo isset($p_end_date) ? $p_end_date : ''; ?>" id="end_date" placeholder="End Date" readonly>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Generate">
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
            <p style="font-size: 14px;"><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
          <div class="col-md-12">
            <p style="font-size: 14px;"><b>Store Address: </b><?php echo $storeaddress; ?></p>
          </div>
          <div class="col-md-12">
            <p style="font-size: 14px;"><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
          
          <div class="col-md-12 table-responsive">
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
    // alert('Please Select Start Date');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Start Date", 
      callback: function(){}
    });
    return false;
  }

  if($('#end_date').val() == ''){
    // alert('Please Select End Date');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select End Date", 
      callback: function(){}
    });
    return false;
  }

  if($('input[name="start_date"]').val() != '' && $('input[name="end_date"]').val() != ''){

    var d1 = Date.parse($('input[name="start_date"]').val());
    var d2 = Date.parse($('input[name="end_date"]').val()); 

    if(d1 > d2){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Start date must be less then end date!", 
        callback: function(){}
      });
    return false;
    }
  }

  $("div#divLoading").addClass('show');
  
});
</script>

<style type="text/css">

  

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

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">

  const saveData = (function () {
    const a = document.createElement("a");
    document.body.appendChild(a);
    a.style = "display: none";
    return function (data, fileName) {
        const blob = new Blob([data], {type: "octet/stream"}),
            url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = fileName;
        a.click();
        window.URL.revokeObjectURL(url);
    };
  }());

  $(document).on("click", "#csv_export_btn", function (event) {

    event.preventDefault();

    $("div#divLoading").addClass('show');

      var csv_export_url = '<?php echo $csv_export; ?>';
    
      csv_export_url = csv_export_url.replace(/&amp;/g, '&');

      $.ajax({
        url : csv_export_url,
        type : 'GET',
      }).done(function(response){
        
        const data = response,
        fileName = "kiosk-item-detail-report.csv";

        saveData(data, fileName);
        $("div#divLoading").removeClass('show');
        
      });
    
  });

  $(document).on("click", "#pdf_export_btn", function (event) {

    event.preventDefault();

    $("div#divLoading").addClass('show');

      var pdf_export_url = '<?php echo $pdf_save_page; ?>';
    
      pdf_export_url = pdf_export_url.replace(/&amp;/g, '&');

      $.ajax({
        url : pdf_export_url,
        type : 'GET',
      }).done(function(response){
       const data = response,
      fileName = "Kiosk-Item-Detail-Report.pdf";

        saveData2(data, fileName);
        $("div#divLoading").removeClass('show');
        
      });
    
  });

  $(document).on("click", "#pdf_export_btn", function (event) {

    event.preventDefault();

    $("div#divLoading").addClass('show');

    var pdf_export_url = '<?php echo $pdf_save_page; ?>';
  
    pdf_export_url = pdf_export_url.replace(/&amp;/g, '&');

    var req = new XMLHttpRequest();
    req.open("GET", pdf_export_url, true);
    req.responseType = "blob";
    req.onreadystatechange = function () {
      if (req.readyState === 4 && req.status === 200) {

        if (typeof window.navigator.msSaveBlob === 'function') {
          window.navigator.msSaveBlob(req.response, "Kiosk-Item-Detail-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Kiosk-Item-Detail-Report.pdf";

          // append the link to the document body

          document.body.appendChild(link);

          link.click();
        }
      }
      $("div#divLoading").removeClass('show');
    };
    req.send();
    
  });
</script>

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">
  $(document).on('change', 'input[name="start_date"],input[name="end_date"]', function(event) {
    event.preventDefault();

    if($('input[name="start_date"]').val() != '' && $('input[name="end_date"]').val() != ''){

      var d1 = Date.parse($('input[name="start_date"]').val());
      var d2 = Date.parse($('input[name="end_date"]').val()); 

      if(d1 > d2){
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Start date must be less then end date!", 
          callback: function(){}
        });
      return false;
      }
    }
  });
</script>