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
              <select name="report_by" class="form-control" id="report_by">
                <option value="">Please Select Report</option>
                <?php foreach ($byreports as $key => $value){ ?>
                  <?php if(isset($selected_report) && ($selected_report == $key)){?>
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
                <?php if($selected_report == 1) { ?>
                  <option value="">Please Select Category</option>
                <?php } else { ?>
                  <option value="">Please Select Department</option>
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
              <input type="submit" class="btn btn-success" value="Generate">
            </div>
          </form>
        </div>

        <br>
        <div class="row">
          <div class="col-md-12">
            <p style="font-size: 14px;"><b>Date: </b><?php echo date("m-d-Y"); ?></p>
          </div>
          

          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;width:80%;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Supplier</th>
                  <th>Category</th>
                  <th>Item</th>
                  <th class="text-right">QOH</th>
                  <th class="text-right">Cost Value</th>
                  <th class="text-right">Total Cost Value</th>
                  <th class="text-right">Retail Value</th>
                  <th class="text-right">Total Retail Value</th>
                </tr>
              </thead>
              <tbody id="inventory_on_hand_report_table">
                
                
              </tbody>
            </table>
          </div>
        </div>

        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br>
        <div class="row">
          <div class="col-md-12">
            <p style="font-size: 14px;"><b>Date: </b><?php echo date("m-d-Y"); ?></p>
          </div>
          <div class="col-md-12">
            <!-- <p style="font-size: 14px;"><span><b>Total Quantity On Hand - </b><?php echo $total_qoh;?></span></p> -->
            <p style="font-size: 14px;"><span><b>Total Cost Value - </b>$ <?php echo number_format((float)$toal_value, 2) ;?></span></p>
            <p style="font-size: 14px;"><span><b>Total Retail Value - </b>$ <?php echo number_format((float)$total_retail_value, 2) ;?></span></p>
            <p><span class="text-danger">*</span>Excludes Non-Inventory items and items with zero or negative QOH</p>
          </div>

          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;width:80%;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Supplier</th>
                  <?php if(isset($selected_report) && $selected_report == 1){ ?>
                  <th>Category</th>
                  <?php } else {?>
                    <th>Department</th>
                  <?php } ?>
                  <th>Item</th>
                  <th class="text-right">QOH</th>
                  <th class="text-right">Cost Value</th>
                  <th class="text-right">Total Cost Value</th>
                  <th class="text-right">Retail Value</th>
                  <th class="text-right">Total Retail Value</th>
                </tr>
              </thead>
              <tbody id="inventory_on_hand_report_table">
                
                <?php foreach ($reports as $key => $value){ ?>

                  <tr class="add_space"><th></th></tr>
                  <tr class="header expand">
                    <th colspan="8" class="text-uppercase"><?php echo $key; ?> <span class="sign"></span></th>
                  </tr>
                  <?php 
                    $total_qty = 0;
                    $total_total_cost = 0;
                    $total_total_value = 0;
                    $total_total_retail_value = 0;
                  ?>
                  <?php foreach ($value as $k => $v){
                    $tot_value = $v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', '');
                    $tot_ret_value = $v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', '');

                    $total_total_retail_value = $total_total_retail_value + $tot_ret_value;

                    $total_qty = $total_qty + $v['iqtyonhand'];
                    $total_total_cost = $total_total_cost + number_format((float)$v['cost'], 2, '.', '');
                    $total_total_value = $total_total_value + $tot_value;

                  ?>
                    <tr>
                      <td><?php echo $v['suppliername'];?></td>
                      <td><?php echo $v['vname'];?></td>
                      <td><?php echo $v['itemname'];?></td>
                      <td class="text-right"><?php echo $v['iqtyonhand'];?></td>
                      <td class="text-right"><?php echo number_format((float)$v['cost'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$tot_value, 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$v['price'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$tot_ret_value, 2, '.', '') ;?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>Total</b></td>
                    <td class="text-right"><b><?php echo $total_qty;?></b></td>
                    <td></td>
                    <td class="text-right"><b>$ <?php echo number_format((float)$total_total_value, 2) ;?></b></td>
                    <td class="text-right"></td>
                    <td class="text-right"><b>$ <?php echo number_format((float)$total_total_retail_value, 2) ;?></b></td>
                  </tr>
                <?php } ?>
                  <tr class="add_space"><th></th></tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>Grand Total</b></td>
                    <td class="text-right"><b><?php echo $total_qoh;?></b></td>
                    <td></td>
                    <td class="text-right"><b>$ <?php echo number_format((float)$toal_value, 2) ;?></b></td>
                    <td class="text-right"></td>
                    <td class="text-right"><b>$ <?php echo number_format((float)$total_retail_value, 2) ;?></b></td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php }else{ ?>
          <?php if(isset($total_qoh)){ ?>
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
        }

        // $('#report_data').next('span').css('width','100%');
        // $('#report_data').next('span').find('input.select2-search__field').css('width','100%');
        
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

  $('.header').toggleClass('expand').nextUntil('tr.add_space').slideUp(100);
});



$(document).on('click', '.header', function(event) {
  $(this).toggleClass('expand').nextUntil('tr.add_space').slideToggle(100);
});
</script>

<style type="text/css">
  tr.header{
    cursor:pointer;
  }

  tr.header > th{
    background-color: #DCDCDC;
    border: 1px solid #808080 !important;
  }

  tr.header > th, tr.header > th > span{
    font-size: 15px;
  }

  tr.header > th > span{
    float: right;
  }

  .header .sign:after{
    content:"+";
    display:inline-block;      
  }
  .header.expand .sign:after{
    content:"-";
  }

  tr.add_space th {
    border: none !important;
    padding: 2px !important;
  }
</style>

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
        fileName = "inventory-on-hand-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Inventory-On-Hand-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Inventory-On-Hand-Report.pdf";

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
  $(document).on("submit", "#filter_form", function (event) {

    event.preventDefault();
$("div#divLoading").removeClass('show');
    var get_json_data_url = '<?php echo $get_json_data; ?>';
  
    get_json_data_url = get_json_data_url.replace(/&amp;/g, '&');

    $.ajax({
      url : get_json_data_url,
      type : 'POST',
    }).done(function(response){
      
      var res_data = JSON.parse(response);
      
      if(res_data.reports){
        var table_html = '';
        $('tbody#inventory_on_hand_report_table').empty();
        for (var key in res_data.reports){
          table_html += '<tr class="add_space"><th></th></tr>';
          table_html += '<tr class="header">';
          table_html += '<th colspan="8" class="text-uppercase">'+ key +' <span class="sign"></span></th>';
          table_html += '</tr>';

          var total_qty = 0;
          var total_total_cost = 0;
          var total_total_value = 0;
          var total_total_retail_value = 0;
          for (var k in res_data.reports[key]){

            var tot_value = res_data.reports[key][k]['iqtyonhand'] * res_data.reports[key][k]['cost'];
            var tot_ret_value = res_data.reports[key][k]['iqtyonhand'] * res_data.reports[key][k]['price'];

            var total_total_retail_value = total_total_retail_value + tot_ret_value;

            var total_qty = total_qty + res_data.reports[key][k]['iqtyonhand'];
            var total_total_cost = total_total_cost + res_data.reports[key][k]['cost'];
            var total_total_value = total_total_value + tot_value;

            table_html += '<tr>';
            table_html += '<td>'+ res_data.reports[key][k]['suppliername'] +'</td>';
            table_html += '<td>'+ res_data.reports[key][k]['vname'] +'</td>';
            table_html += '<td>'+ res_data.reports[key][k]['itemname'] +'</td>';
            table_html += '<td class="text-right">'+ res_data.reports[key][k]['iqtyonhand'] +'</td>';
            table_html += '<td class="text-right">'+ res_data.reports[key][k]['cost'] +'</td>';
            table_html += '<td class="text-right">'+ tot_value.toFixed(2) +'</td>';
            table_html += '<td class="text-right">'+ res_data.reports[key][k]['price'] +'</td>';
            table_html += '<td class="text-right">'+ tot_ret_value.toFixed(2) +'</td>';
            table_html += '</tr>';

          }

          table_html += '<tr>';
          table_html += '<td></td><td></td>';
          table_html += '<td class="text-right"><b>Total</b></td>';
          table_html += '<td class="text-right"><b>'+ 1 +'</b></td>';
          table_html += '<td></td>';
          table_html += '<td class="text-right"><b>$ '+ 1 +'</b></td>';
          table_html += '<td class="text-right"></td>';
          table_html += '<td class="text-right"><b>$ '+ 1 +'</b></td>';
          table_html += '</tr>';
          $('tbody#inventory_on_hand_report_table').append(table_html);
        }

        table_html1 ='';
        table_html1 += '<tr class="add_space"><th></th></tr>';
        table_html1 += '<tr>';
        table_html1 += '<td></td><td></td>';
        table_html1 += '<td class="text-right"><b>Grand Total</b></td>';
        table_html1 += '<td class="text-right"><b>'+ 1 +'</b></td>';
        table_html1 += '<td></td>';
        table_html1 += '<td class="text-right"><b>$ '+ 1 +'</b></td>';
        table_html1 += '<td class="text-right"></td>';
        table_html1 += '<td class="text-right"><b>$ '+ 1 +'</b></td>';
        table_html1 += '</tr>';

        $('tbody#inventory_on_hand_report_table').append(table_html1);
        // $('.header').trigger('click');
      }
      
    });
    
  });
</script>