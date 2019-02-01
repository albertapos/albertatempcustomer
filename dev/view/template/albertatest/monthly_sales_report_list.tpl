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
          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Date</th>
                  <th class="text-right">Sales</th>
                  <th class="text-right">Cash Added</th>
                  <th class="text-right">Subtotal</th>
                  <th class="text-right">Total Tax</th>
                  <th class="text-right">Taxable Sales</th>
                  <th class="text-right">Nontaxable Sales</th>
                  <th class="text-right">Discount</th>
                  <th class="text-right">Sale Discount</th>
                  <th class="text-right">Total Sales (Without Tax)</th>
                  <th class="text-right">Total Credit Amt</th>
                  <th class="text-right">Total Cash Sales</th>
                  <th class="text-right">Total EBT Sales</th>
                  <th class="text-right">Total Coupons Sales</th>
                  <th class="text-right">Total Paid out</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $tot_nettotal = 0;
                    $tot_nsubtotal = 0;
                    $tot_nettotalcashadded = 0;
                    $tot_ntaxtotal = 0;
                    $tot_ntaxable = 0;
                    $tot_nnontaxabletotal = 0;
                    $tot_ndiscountamt = 0;
                    $tot_ntotalsalediscount = 0;
                    $tot_totalsalewithout = 0;
                    $tot_totalcreditamt = 0;
                    $tot_ntotalcashsales = 0;
                    $tot_nnetpaidout = 0;
                    $tot_ntotalebtsales = 0;
                    $tot_ntotalcouponsales = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['date_sale'];?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nettotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nettotalcashadded'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nsubtotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntaxtotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntaxable'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nnontaxabletotal'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ndiscountamt'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalsalediscount'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalsaleswithout'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['totalcreditamt'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalcashsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalebtsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['ntotalcouponsales'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['nnetpaidout'], 2, '.', '') ;?></td>

                      <?php 
                        $tot_nettotal = $tot_nettotal + $value['nettotal'];
                        $tot_nsubtotal = $tot_nsubtotal + $value['nsubtotal'];
                        $tot_nettotalcashadded = $tot_nettotalcashadded + $value['nettotalcashadded'];
                        $tot_ntaxtotal = $tot_ntaxtotal + $value['ntaxtotal'];
                        $tot_ntaxable = $tot_ntaxable + $value['ntaxable'];
                        $tot_nnontaxabletotal = $tot_nnontaxabletotal + $value['nnontaxabletotal'];
                        $tot_ndiscountamt = $tot_ndiscountamt + $value['ndiscountamt'];
                        $tot_ntotalsalediscount = $tot_ntotalsalediscount + $value['ntotalsalediscount'];
                        $tot_totalsalewithout = $tot_totalsalewithout + $value['ntotalsaleswithout'];
                        $tot_totalcreditamt = $tot_totalcreditamt + $value['totalcreditamt'];
                        $tot_ntotalcashsales = $tot_ntotalcashsales + $value['ntotalcashsales'];
                        $tot_ntotalebtsales = $tot_ntotalebtsales + $value['ntotalebtsales'];
                        $tot_ntotalcouponsales = $tot_ntotalcouponsales + $value['ntotalcouponsales'];
                        $tot_nnetpaidout = $tot_nnetpaidout + $value['nnetpaidout'];
                      ?>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td><b>Total</b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nettotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nettotalcashadded, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nsubtotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntaxtotal, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntaxable, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nnontaxabletotal, 2, '.', '') ;?><b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ndiscountamt, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalsalediscount, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_totalsalewithout, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_totalcreditamt, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalcashsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalebtsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_ntotalcouponsales, 2, '.', '') ;?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$tot_nnetpaidout, 2, '.', '') ;?></b></td>
                  </tr>
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
  $(document).on('change', '#report_by', function(event) {
    event.preventDefault();
    var reportdata_url = '<?php echo $reportdata; ?>';
    
    reportdata_url = reportdata_url.replace(/&amp;/g, '&');

    var report_id = $(this).val();

    if($(this).val() == ''){
      $('#div_report_data').hide();
      // alert('Please Select Report');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Report", 
        callback: function(){}
      });
      $("div#divLoading").removeClass('show');
      return false;
    }

    $("div#divLoading").addClass('show');

    $.ajax({
        url : reportdata_url+'&report_by='+report_id,
        type : 'GET',
    }).done(function(response){
      
      var  response = $.parseJSON(response); //decode the response array

      if( response.code == 1 ) {//success
        $('#report_data').empty();
        var filtered_options = '';

        if(report_id == 1){
          filtered_options += '<option value="">Please Select Category</option>';
        }else if(report_id == 2){
          filtered_options += '<option value="">Please Select Department</option>';
        }else{
          filtered_options += '<option value="">Please Select Item Group</option>';
        }

        filtered_options += '<option value="ALL">All</option>';

        $.each(response.data, function(i, v) {
            filtered_options += '<option value="' + v.id + '">' + v.name + '</option>';
        });
        $('#report_data').append(filtered_options);
        if(report_id == 1){
          $('#report_data').select2({
            placeholder: "Please Select Category"
          });
        }else if(report_id == 2){
          $('#report_data').select2({
            placeholder: "Please Select Department"
          });
        }

        $('#report_data').next('span').css('width','100%');
        $('#report_data').next('span').find('input.select2-search__field').css('width','100%');
        
        $('#div_report_data').show();
        $("div#divLoading").removeClass('show');
       
        return false;
      }else if(response.code == 0){
        // alert('Something Went Wrong!!!');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Something Went Wrong!!!", 
          callback: function(){}
        });
        $("div#divLoading").removeClass('show');
        return false;
      }
      
    });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by').val() == ''){
    // alert('Please Select Report');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Report", 
      callback: function(){}
    });
    return false;
  }

  if($('#report_data').val() == ''){
    if($('#report_by').val() == '1'){
      // alert('Please Select Category');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Category", 
        callback: function(){}
      });
      return false;
    }else if($('#report_by').val() == '2'){
      // alert('Please Select Department');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Department", 
        callback: function(){}
      });
      return false;
    }else{
      // alert('Please Select Item Group');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Item Group", 
        callback: function(){}
      });
      return false;
    }
  }

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
        fileName = "sales-report.csv";

        saveData(data, fileName);
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
          window.navigator.msSaveBlob(req.response, "Sales-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Sales-Report.pdf";

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