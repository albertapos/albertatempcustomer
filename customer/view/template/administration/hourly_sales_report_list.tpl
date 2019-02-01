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

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <a id="csv_export_btn" href="<?php echo $csv_export; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> CSV</a>
            <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right" style="margin-right:10px;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
          <a id="pdf_export_btn" href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
          </div>
        </div>
        <div class="clearfix"></div>

      <div class="row">
          <form method="post" id="filter_form">
            <div class='col-md-12'>
               
                <div class="col-md-2">
                  
                  <span> 
                        <b>Start Date: </b><input type="" class="form-control" name="start_date" value="<?php echo isset($p_start_date) ? $p_start_date : ''; ?>" id="start_date" placeholder="Date">
                  </span>
    
                </div> 
                
                <div class="col-md-2">
                  
                  <span>
                      <b>End Date: </b><input type="" class="form-control" name="end_date" value="<?php echo isset($p_end_date) ? $p_end_date : ''; ?>" id="end_date" placeholder="Date">
                  </span>
                  
                </div>
                
                <div class="col-md-2">
                  <input type="submit" class="align-self btn btn-success align-bottom" value="Generate">
                </div> 
                
            </div>
            
          </form>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Name: </b><?php echo $storename; ?></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
            </div>    
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p><b>Store Phone: </b><?php echo $storephone; ?></p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class='col-md-6'>
                <p>
                    <span>
                        <b>Start Date: </b>
                        <?php echo isset($p_start_date) ? $p_start_date : date("m-d-Y"); ?>
                    </span>
                    <span>
                        <b>End Date: </b>
                        <?php echo isset($p_end_date) ? $p_end_date : date("m-d-Y"); ?>
                    </span>
                </p>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="table-responsive">
              
            <div class="col-md-12">
                
                <div class="col-md-6">
                
                    <table class="table table-bordered table-striped table-hover">
                        
                        <tr>
                            <th>Hourly Sales</th>
                            <td class="text-right"><b>Amount</b></td>
                        </tr>


                        <?php foreach($report_hourly as $r) { ?>
                            
                            <tr>
                                <th><?php echo isset($r['Hours']) ? $r['Hours']: 0; ?></th>
                                <td class='text-right'><?php echo isset($r['Amount']) ? $r['Amount']: 0; ?></td>
                            </tr>
                        
                        
                        <?php } ?>
                        
                    </table>
                
                </div>
                
            </div>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="display:none;">
            <div class="title_div" style="width:50%;background-color: #2486c6;color: #fff;">
              <b>Hourly Sales</b>
            </div>
            <table class="table table-bordered" style="width:50%;">
              <tbody>
                <?php if(isset($report_hourly_sales) && count($report_hourly_sales) > 0){ ?>
                  <?php foreach($report_hourly_sales as $report_hourly_sale){ ?>
                  <tr>
                    <td><?php echo $report_hourly_sale['TODATE']; ?></td>
                    <td class="text-right"><?php echo $report_hourly_sale['AMT']; ?></td>
                  </tr>
                  <?php } ?>
                <?php } else { ?>
                <tr>
                  <td><b>Sorry no data found!</b></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          
        </div>
        
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

  $(document).on('submit', '#filter_form', function(event) {

    if($('#start_date').val() == ''){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Date", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');
  });
</script>

<style type="text/css">



  .title_div{
    border: 1px solid #ddd;
    padding: 5px;
  }
  
  .align-self {position: relative; margin-top: 17px;}

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
        fileName = "hourly-sales-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Hourly-sales-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Hourly-sales-Report.pdf";

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
<script>
    
    $("#pdf_export_btn1").click(function(e){
        e.preventDefault();
        var date=$("#start_date").val();
        $.ajax({
           url:"index.php?route=administration/end_of_day_report/get_pdf_day/",
           data:{date:date},
           type:"POST",
           dataType:"JSON",
           success:function(data){
               alert(data);
           },
           error:function(xhr){
               alert(xhr.responseText);
               
               
           }
            
            
            
        });
        
        
    });
    
    
</script>