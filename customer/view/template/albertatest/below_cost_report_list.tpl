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
        <?php if(isset($reports) && count($reports) > 0){ ?>
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
            <div class="col-md-3">
              <select name="report_by[]" class="form-control" id="report_by" multiple="true">

              <?php if(isset($selected_byreports) && count($selected_byreports) > 0){ ?>
                    <option value="">Please Select Department</option>
                    <?php if(in_array('ALL', $selected_byreports)){ ?>
                      <option value="ALL" selected="selected">ALL</option>
                    <?php } else { ?>
                      <option value="ALL">ALL</option>
                    <?php } ?>

                    <?php foreach($byreports as $k => $v){ ?>
                      <?php $sel_report = false; ?>
                      <?php foreach($selected_byreports as $ks => $selected_byreport){ ?>
                        <?php if($selected_byreport == $v['vdepcode']){ ?>
                            <option value="<?php echo $v['vdepcode']; ?>" selected="selected"><?php echo $v['vdepartmentname']; ?></option>
                            <?php 
                              $sel_report = true;
                              break;
                            ?>
                        <?php } ?>
                      <?php } ?>
                      <?php if($sel_report == false){ ?>
                        <option value="<?php echo $v['vdepcode']; ?>"><?php echo $v['vdepartmentname']; ?></option>
                      <?php } ?>
                    <?php } ?>
                    
              <?php } else { ?>
                <option value="">Please Select Department</option>
                <option value="ALL">ALL</option>
                <?php foreach ($byreports as $key => $value){ ?>
                  <option value="<?php echo $value['vdepcode']; ?>"><?php echo $value['vdepartmentname']; ?></option>
                <?php } ?>
              <?php } ?>

              </select>
            </div>

            <div class="col-md-2">&nbsp;&nbsp;&nbsp;
              <input type="submit" class="btn btn-success" value="Generate">
            </div>
          </form>
        </div>
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br><br><br>
        <div class="row">
          <div class="col-md-12">
            <p><b>Date: </b><?php echo date("m-d-Y"); ?></p>
          </div>
          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;width:70%;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Supplier</th>
                  <th>Item</th>
                  <th>Department</th>
                  <th class="text-right">Cost</th>
                  <th class="text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                  <?php $tot_cost = 0; ?>
                  <?php $tot_price = 0; ?>
                  <?php foreach ($reports as $key => $value){ ?>
                  <tr>
                    <td><?php echo $value['suppliername']; ?></td>
                    <td><?php echo $value['itemname']; ?></td>
                    <td><?php echo $value['vname']; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['cost'], 2, '.', '') ; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['price'], 2, '.', '') ; ?></td>
                    <?php $tot_cost = $tot_cost + $value['cost']; ?>
                    <?php $tot_price = $tot_price + $value['price']; ?>
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php }else{ ?>
          <?php if(isset($reports)){ ?>
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

<script type="text/javascript">
  $(document).ready(function() {
    // $('#report_by').select2({
    //   placeholder: "Please Select Department"
    // });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by > option:selected').length == 0){
    // alert('Please Select Department');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Department", 
      callback: function(){}
    });
    return false;
  }

  if($('#report_by').val() == ''){
    // alert('Please Select Department');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Department", 
      callback: function(){}
    });
    return false;
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
        fileName = "below-cost-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Below-Cost-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Below-Cost-Report.pdf";

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