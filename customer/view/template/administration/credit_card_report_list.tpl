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
        <div class="clearfix"></div>

        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Start Date">
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="<?php echo isset($p_end_date) ? $p_end_date : ''; ?>" id="end_date" placeholder="End Date">
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="credit_card_number" value="<?php echo isset($credit_card_number) ? $credit_card_number : ''; ?>" id="credit_card_number" maxlength="4" placeholder="Credit Card Number">
            </div>
            <div class="col-md-2">
              <input type="text" class="form-control" name="credit_card_amount" value="<?php echo isset($credit_card_amount) ? $credit_card_amount : ''; ?>" id="credit_card_amount" placeholder="Credit Card Amount">
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
            <p><b>Store Name: </b><?php echo $storename; ?></p>
          </div>
          <div class="col-md-12">
            <p><b>Store Address: </b><?php echo storeaddress; ?></p>
          </div>
          <div class="col-md-12">
            <p><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="width:60%;">
              <thead>
                <th style="width: 50%;">Name</th>
                <th class="text-right" style="width: 30%;">Transaction Number</th>
                <th class="text-right" style="width: 20%;">Amount</th>
              </thead>
              <tbody>
                <?php 
                  $grand_total_transaction_number= 0;
                  $grand_total_nauthamount= 0;

                ?>
                <?php foreach($reports as $report){ ?>
                  <tr >
                    <td colspan="3" style="padding: 0px;">
                      <table class="table" style="width: 100%;margin-bottom: 0px;">
                        <thead>
                          <tr class="search_header" style="cursor: pointer;" data-cardtype="<?php echo $report['vcardtype'];?>">
                            <th class="text-uppercase" style="width: 50%;"><?php echo $report['vcardtype'];?> TOTAL</th>
                            <th class="text-right" style="width: 30%;"><?php echo $report['transaction_number'];?></th>
                            <th class="text-right" style="width: 20%;">$<?php echo $report['nauthamount'];?></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </td>

                  </tr>
                  <?php 

                    $grand_total_transaction_number = $grand_total_transaction_number + $report['transaction_number'];
                    $grand_total_nauthamount = $grand_total_nauthamount + $report['nauthamount'];

                  ?>
                <?php } ?>
                <tr>
                  <td><b>GRAND TOTAL</b></td>
                  <td class="text-right"><b><?php echo $grand_total_transaction_number;?></b></td>
                  <td class="text-right"><b>$ <?php echo number_format((float)$grand_total_nauthamount, 2) ;?></b></td>
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

<a href="" id="btnPrint" style="display: hidden;"></a>
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

  if($('#start_date').val() == '' && $('#credit_card_number').val() == ''){
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Start Date OR Enter Card Number!", 
      callback: function(){}
    });
    return false;
  }

  if($('#start_date').val() != '' && $('#end_date').val() == ''){
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select End Date!", 
      callback: function(){}
    });
    return false;
  }

  if($('#start_date').val() == '' && $('#end_date').val() != ''){
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Start Date!", 
      callback: function(){}
    });
    return false;
  }

  
  // if($('#start_date').val() == ''){
  //   // alert('Please Select Start Date');
  //   bootbox.alert({ 
  //     size: 'small',
  //     title: "Attention", 
  //     message: "Please Select Start Date", 
  //     callback: function(){}
  //   });
  //   return false;
  // }

  // if($('#end_date').val() == ''){
  //   // alert('Please Select End Date');
  //   bootbox.alert({ 
  //     size: 'small',
  //     title: "Attention", 
  //     message: "Please Select End Date", 
  //     callback: function(){}
  //   });
  //   return false;
  // }

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
        fileName = "credit-card-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Credit-Card-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Credit-Card-Report.pdf";

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

<script type="text/javascript">
  $(document).on('click', '.search_header', function(event) {
  event.preventDefault();
  $(this).toggleClass('expand');

  var current_header = $(this);

  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  var credit_card_number = $('#credit_card_number').val();
  var credit_card_amount = $('#credit_card_amount').val();
  var report_pull_by = $(this).attr('data-cardtype');
  
  var data_post = {start_date:start_date,end_date:end_date,report_pull_by:report_pull_by,credit_card_number:credit_card_number,credit_card_amount:credit_card_amount};

  data_post= JSON.stringify(data_post);

  var report_ajax_data_url = '<?php echo $report_ajax_data; ?>';
  report_ajax_data_url = report_ajax_data_url.replace(/&amp;/g, '&');

  var print_receipt_url = '<?php echo $print_receipt; ?>';
  print_receipt_url = print_receipt_url.replace(/&amp;/g, '&');

  if($(this).hasClass('expand')){
    $.ajax({
      url : report_ajax_data_url,
      data : data_post,
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
      }).done(function(response){
        
        current_header.parent().parent().find('tbody').empty();
        var html = '';
        if(response){

          html += '';
          html += '<tr>';
          html += '<td colspan="3" style="padding: 0px;">';
          html += '<table class="table" style="margin-bottom: 0px;">';
          html += '<thead>';
          html += '<tr>';
          html += '<th>DATE</th>';
          html += '<th>TIME</th>';
          html += '<th class="text-right">LAST FOUR OF CC</th>';
          html += '<th class="text-right">APPROVAL CODE</th>';
          html += '<th class="text-right">AMOUNT</th>';
          html += '<th>CARD TYPE</th>';
          html += '<th>ACTION</th>';
          html += '</tr>';
          html += '</thead>';
          html += '<tbody>';
          $.each(response,function(i,v){

           var receipt_url = print_receipt_url+'&id='+v.id+'&by=mpstender';

            html += '<tr>';
            html += '<td>';
            html += v.date;
            html += '</td>';
            html += '<td>';
            html += v.time;
            html += '</td>';
            html += '<td class="text-right">';
            html += v.last_four_of_cc;
            html += '</td>';
            html += '<td class="text-right">';
            html += v.approvalcode;
            html += '</td>';
            html += '<td class="text-right">';
            html += v.amount;
            html += '</td>';
            html += '<td>';
            html += v.vcardtype;
            html += '</td>';
            html += '<td>';
            html += '<a href="'+ receipt_url +'" class="btn btn-info printMe"><i class="fa fa-print"></i> Print</a>';
            html += '</td>';
            html += '</tr>';
          });

          html += '</tbody>';
          html += '</table>';
          html += '</td>';
          html += '</tr>';

          current_header.parent().parent().find('tbody').append(html);
          current_header.parent().parent().find('tbody').show();
        }
    });
  }
  
  if(!$(this).hasClass('expand')){
    $(this).parent().parent().find('tbody').empty();
  }

});

  $(document).on('click', '.printMe', function(event) {
    event.preventDefault();
    
    var href = $(this).attr('href');


    $.ajax({
        url : href,
        type : 'GET',
    }).done(function(response){
      
        $('#printme_modal').html(response);
        $('#popupbtnPrint').attr('data-href',href);

        $('#view_salesdetail_model').modal('show');
         
    });
   
  });

  $(document).on('click', '#popupbtnPrint', function(event) {
    event.preventDefault();
    
    var href = $(this).attr('data-href');
    
    $('#btnPrint').attr('href', href);

    $('#btnPrint').trigger('click');
  });
</script>

<!-- Modal -->
  <div class="modal fade" id="view_salesdetail_model" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">        
        <div class="modal-body" id="printme_modal">          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="popupbtnPrint">Print</button>
      </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
   $(document).on('keypress keyup blur', 'input[name="credit_card_number"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  });

  $(document).on('keypress keyup blur', 'input[name="credit_card_amount"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  });  
</script>