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
            <div class="col-md-3">
              <select name="report_by" class="form-control" id="report_by">
                <option value="">Please Select Report</option>
                <?php foreach ($byreports as $key => $value){ ?>
                  <?php if(isset($selected_report_by) && ($selected_report_by == $key)){ ?>
                    <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <?php if(isset($selected_report_data) && count($selected_report_data) > 0){ ?>
            <div class="col-md-3" id="div_report_data">
              <select name="report_data[]" class="form-control" id="report_data" multiple="true">
                <?php if($selected_report_by == 1) { ?>
                  <option value="">Please Select Category</option>
                <?php }else if($selected_report_by == 2) { ?>
                  <option value="">Please Select Department</option>
                <?php } else { ?>
                  <option value="">Please Select Item Group</option>
                <?php } ?>
                <?php if(in_array('ALL', $selected_report_data)){ ?>
                  <option value="ALL" selected="selected">ALL</option>
                <?php } else { ?>
                  <option value="ALL">ALL</option>
                <?php } ?>
                <?php if(isset($drop_down_datas)){ ?>
                  <?php foreach($drop_down_datas as $drop_down_data){ ?>
                    <?php $sel_report = false; ?>
                    <?php foreach($selected_report_data as $selected_report_d){ ?>
                      <?php if($drop_down_data['id'] == $selected_report_d){ ?>
                        <option value="<?php echo $drop_down_data['id']?>" selected="selected"><?php echo $drop_down_data['name']?></option>
                        <?php 
                          $sel_report = true;
                          break;
                        ?>
                       <?php } ?>
                    <?php } ?>
                    <?php if($sel_report == false){ ?>
                      <option value="<?php echo $drop_down_data['id']?>"><?php echo $drop_down_data['name']?></option>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <?php } else { ?>
              <div class="col-md-3" style="display:none;" id="div_report_data">
                <select name="report_data[]" class="form-control" id="report_data" multiple="true">
                  <option value="">Please Select</option>
                </select>
              </div>
            <?php } ?>
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
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <p><b>Store Name: </b><?php echo $storename; ?></p>
            <p><b>Store Address: </b><?php echo $storeaddress; ?></p>
            <p><b>Store Phone: </b><?php echo $storephone; ?></p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="width:100%;">
              <thead>
                <tr>
                  <th style="width: 15%;"><?php echo $desc_title; ?></th>
                  <th style="width: 15%;">Supplier</th>
                  <th style="width: 15%;">Item</th>
                  <th style="width: 10%;" class="text-right">QOH</th>
                  <th style="width: 10%;" class="text-right">Cost</th>
                  <th style="width: 10%;" class="text-right">Price</th>
                  <th style="width: 10%;">Shelf</th>
                  <th style="width: 10%;">Shelving</th>
                  <th style="width: 10%;">Aisle</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $tot_cost = 0;
                    $tot_price = 0;
                    $tot_qoh = 0;
                   ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>

                      <td colspan="9" style="padding: 0px;">
                        <table class="table" style="width: 100%;margin-bottom: 0px;">
                          <thead>
                            <tr class="search_header" style="cursor: pointer;" data-cat="<?php echo $value['name'];?>">
                              <th style="width: 15%;"><?php echo $value['name'];?></th>
                              <th style="width: 15%;"></th>
                              <th style="width: 15%;"></th>
                              <th style="width: 10%;" class="text-right"><?php echo $value['total_iqtyonhand'];?></th>
                              <th style="width: 10%;" class="text-right">$<?php echo number_format((float)$value['total_cost'], 2, '.', '') ;?></th>
                              <th style="width: 10%;" class="text-right">$<?php echo number_format((float)$value['total_price'], 2, '.', '') ;?></th>
                              <th style="width: 10%;"></th>
                              <th style="width: 10%;"></th>
                              <th style="width: 10%;"></th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                      </td>
                      <?php 
                        $tot_cost = $tot_cost + $value['total_cost'];
                        $tot_price = $tot_price + $value['total_price'];
                        $tot_qoh = $tot_qoh + $value['total_iqtyonhand'];
                       ?>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td style="width: 15%;">&nbsp;</td>
                    <td style="width: 15%;">&nbsp;</td>
                    <td style="width: 15%;"><b>Total</b></td>
                    <td style="width: 10%;" class="text-right"><b><?php echo $tot_qoh ;?></b></td>
                    <td style="width: 10%;" class="text-right"><b>$<?php echo number_format((float)$tot_cost, 2, '.', '') ;?></b></td>
                    <td style="width: 10%;" class="text-right"><b>$<?php echo number_format((float)$tot_price, 2, '.', '') ;?></b></td>
                    <td style="width: 10%;">&nbsp;</td>
                    <td style="width: 10%;">&nbsp;</td>
                    <td style="width: 10%;">&nbsp;</td>
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
  $(document).ready(function() {
    // $('#report_by').select2({
    //   placeholder: "Please Select Department"
    // });
  });

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
        message: "Please Select Report!", 
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
          // $('#report_data').select2({
          //   placeholder: "Please Select Category"
          // });
        }else if(report_id == 2){
          // $('#report_data').select2({
          //   placeholder: "Please Select Department"
          // });
        }else{
          // $('#report_data').select2({
          //   placeholder: "Please Select Item Group"
          // });
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

  if($('#report_by').val() == '1'){
      if($('#report_data > option:selected').length == 0){
        // alert('Please Select Category');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Select Category", 
          callback: function(){}
        });
        return false;
      }
  }else if($('#report_by').val() == '2'){
    if($('#report_data > option:selected').length == 0){
       // alert('Please Select Department');
       bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Department", 
        callback: function(){}
      });
      return false;
    }
  }else{
    if($('#report_data > option:selected').length == 0){
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
        fileName = "zero-movement-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Zero-Movement-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Zero-Movement-Report.pdf";

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
  var report_pull_by = $(this).attr('data-cat');
  var report_by = $('#report_by').val();
  
  var data_post = {start_date:start_date,end_date:end_date,report_pull_by:report_pull_by,report_by:report_by};

  data_post= JSON.stringify(data_post);

  var report_ajax_data_url = '<?php echo $report_ajax_data; ?>';
  report_ajax_data_url = report_ajax_data_url.replace(/&amp;/g, '&');

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
          var tot_qoh = 0;
          var tot_cost = 0;
          var tot_price = 0;
          $.each(response,function(i,v){

            tot_qoh = (tot_qoh + parseInt(v.iqtyonhand));
            tot_cost = (tot_cost + parseFloat(v.cost));
            tot_price = (tot_price + parseFloat(v.price));

            html += '<tr>';
            html += '<td>';
            html += v.vname;
            html += '</td>';
            html += '<td>';
            html += v.suppliername;
            html += '</td>';
            html += '<td>';
            html += v.itemname;
            html += '</td>';
            html += '<td class="text-right">';
            html += v.iqtyonhand;
            html += '</td>';
            html += '<td class="text-right">';
            html += parseFloat(v.cost).toFixed(2);
            html += '</td>';
            html += '<td class="text-right">';
            html += v.price;
            html += '</td>';
            html += '<td>';
            if(v.shelf){
            html += v.shelf;
            }else{
            html += '';
            }
            html += '</td>';
            html += '<td>';
            if(v.shelving){
              html += v.shelving;
            }else{
              html += '';
            }
            html += '</td>';
            html += '<td>';
            if(v.aisle){
              html += v.aisle;
            }else{
              html += '';
            }
            html += '</td>';
            html += '</tr>';
          });

          html += '<tr>';
          html += '<td></td>';
          html += '<td></td>';
          html += '<td><b>Total</b></td>';
          html += '<td class="text-right">'+ tot_qoh +'</td>';
          html += '<td class="text-right">$'+ tot_cost.toFixed(2) +'</td>';
          html += '<td class="text-right">$'+ tot_price.toFixed(2) +'</td>';
          html += '<td></td>';
          html += '<td></td>';
          html += '<td></td>';
          html += '<tr>';

          current_header.parent().parent().find('tbody').append(html);
          current_header.parent().parent().find('tbody').show();
        }
    });
  }
  
  if(!$(this).hasClass('expand')){
    $(this).parent().parent().find('tbody').empty();
  }

});

</script>