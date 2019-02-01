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

        <?php if(isset($reports) && count($reports['item_data']) > 0){ ?>
        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right" style="margin-right:10px;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
            <a id="pdf_export_btn" href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
          </div>
        </div>
        <?php } ?>
        <div class="clearfix"></div>

        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-4">
                <input type="text" name="report_by" class="form-control" placeholder="Search Item..." id="automplete-product" value="<?php echo isset($report_by) ? $report_by : ''; ?>">

                <input type="hidden" name="search_iitemid" id="search_iitemid" value="<?php echo isset($search_iitemid) ? $search_iitemid : ''; ?>">
                <input type="hidden" name="search_vbarcode" id="search_vbarcode" value="<?php echo isset($search_vbarcode) ? $search_vbarcode : ''; ?>">
              </select>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Generate">
            </div>
          </form>
        </div>
        <?php if(isset($reports) && count($reports['item_data']) > 0){ ?>
        <br><br>
        <div class="row">
          <div class="col-md-8">
            <div class="table-responsive">
              <table class="table" style="border: 1px solid #ccc;">
                <thead>
                  <tr>
                    <th colspan="6" class="text-center text-uppercase"><b style="font-size: 16px;"><?php echo $reports['item_data']['vitemname']; ?> [QOH: CASE <?php echo $reports['item_data']['IQTYONHAND']; ?> ]</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $current_year = date('Y'); 
                    $previous_year = date("Y",strtotime("-1 year"));
                  ?>
                  <tr>
                    <td colspan="2" style="background-color: #fff;"></td>
                    <td colspan="2" class="text-left" style="background-color: #fff;border-top: none;">
                      <b class="text-uppercase text-info" style="font-size: 14px;">
                      <?php echo $previous_year;?> YTD SOLD - 
                      <?php 
                        echo !empty($reports['year_arr_sold'][$previous_year]['total_sold']) ? $reports['year_arr_sold'][$previous_year]['total_sold'] : '0' ;
                      ?>
                    </b>
                      </td>
                    <td colspan="2" class="text-left" style="background-color: #fff;border-top: none;">
                      <b class="text-uppercase text-info" style="font-size: 14px;">
                      <?php echo $previous_year; ?> YTD RECEIVE -  
                      <?php
                        echo !empty($reports['year_arr_receive'][$previous_year]['total_receive']) ? $reports['year_arr_receive'][$previous_year]['total_receive']: '0' ;
                      ?>
                      </b>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="background-color: #fff;border-top: none;"></td>
                    <td colspan="2" class="text-left" style="background-color: #fff;border-top: none;">
                      <b class="text-uppercase text-danger" style="font-size: 14px;">
                      <?php echo $current_year;?> YTD SOLD - 
                      <?php 
                        echo !empty($reports['year_arr_sold'][$current_year]['total_sold']) ? $reports['year_arr_sold'][$current_year]['total_sold'] : '0' ;
                      ?>
                    </b>
                      </td>
                    <td colspan="2" class="text-left" style="background-color: #fff;border-top: none;">
                      <b class="text-uppercase text-danger" style="font-size: 14px;">
                      <?php echo $current_year; ?> YTD RECEIVE - 
                      <?php
                        echo !empty($reports['year_arr_receive'][$current_year]['total_receive']) ? $reports['year_arr_receive'][$current_year]['total_receive']: '0' ;
                      ?>
                      </b>
                      </td>
                  </tr>
                  
                  <?php for($i = 1; $i <= 12; ++$i){ ?>
                    <tr>
                      <td colspan="2">
                        <b><?php echo DateTime::createFromFormat('!m', $i)->format('F'); ?></b>
                        </td>
                      <td colspan="2">
                        <?php if(!empty($reports['month_year_arr_sold'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold']) || !empty($reports['month_year_arr_receive'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive'])){?>
                          (<?php echo $previous_year;?>)&nbsp;
                        <?php } ?>

                        <?php if(!empty($reports['month_year_arr_sold'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold'])){ ?>

                          SOLD (<?php echo (int)$reports['month_year_arr_sold'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold']; ?>)
                          

                        <?php } else { ?>
                          &nbsp;
                        <?php } ?>

                        <?php if(!empty($reports['month_year_arr_receive'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive'])){ ?>

                          &nbsp;
                          Receive (<?php echo (int)$reports['month_year_arr_receive'][$previous_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive']; ?>)
                          

                        <?php } else { ?>
                          &nbsp;
                        <?php } ?>

                      </td>
                      <td colspan="2">
                        <?php if(!empty($reports['month_year_arr_sold'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold']) || !empty($reports['month_year_arr_receive'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive'])){?>
                          (<?php echo $current_year;?>)&nbsp;
                        <?php } ?>

                        <?php if(!empty($reports['month_year_arr_sold'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold'])){ ?>

                          SOLD (<?php echo (int)$reports['month_year_arr_sold'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_sold']; ?>)
                          
                          
                        <?php } ?>

                        <?php if(!empty($reports['month_year_arr_receive'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive'])){ ?>

                          &nbsp;
                          Receive (<?php echo (int)$reports['month_year_arr_receive'][$current_year][str_pad($i,2,"0",STR_PAD_LEFT)]['total_receive']; ?>)
                          

                        <?php } else { ?>
                          &nbsp;
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                  
                </tbody>
                
              </table>
            </div>
          </div>
        </div>
        
        <br>
        <br>
        <div class="row">
          <div class="col-md-8" id="item_movement_by_date_selection" >
            <h3 class="text-danger">Item Movement By Date</h3>
            <div class="row">
              <div class="col-md-2">
                <input type="" class="form-control" name="start_date" value="" id="start_date" placeholder="Start Date" readonly>
              </div>
              <div class="col-md-2">
                <input type="" class="form-control" name="end_date" value="" id="end_date" placeholder="End Date" readonly>
              </div>
              <div class="col-md-2">
                <select class="form-control" name="search_by_item">
                  <option value="sold">Sold</option>
                  <option value="receive">Receive</option>
                </select>
              </div>
              <div class="col-md-2">
                <input type="button" class="btn btn-success item_movement_btn" value="Search">
              </div>
            </div>
            <br>
            <div class="table-responsive">
              <table class="table table-bordered" id="item_movement_by_date_selection_table" style="display: none;">
                <thead>
                  <tr>
                    <th id="first_th">Print Receipt</th>
                    <th>Action</th>
                    <th>Date</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Pack Qty</th>
                    <th class="text-right">Size</th>
                    <th class="text-right">Price</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
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
  
  if($('#report_by').val() == ''){
    // alert('Please Select Department');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Select Item", 
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
        fileName = "item-movement-report.csv";

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
          window.navigator.msSaveBlob(req.response, "Item-Movement-Report.pdf");
        } else {
          var blob = req.response;
          var link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = "Item-Movement-Report.pdf";

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

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

<script>
    $(function() {
        
        var url = '<?php echo $searchitem;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    window.suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            vbarcode: val.vbarcode,
                            id: val.iitemid
                        });
                    });
                    add(window.suggestions);
                });
            },
            select: function(e, ui) {
              $('#search_iitemid').val(ui.item.id);
              $('#search_vbarcode').val(ui.item.vbarcode);
            }
        });
    });
</script>

<script type="text/javascript">
  $(document).on('click', '.item_movement_btn', function(event) {
    event.preventDefault();

    var vbarcode = $('#search_vbarcode').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var data_by = $('select[name="search_by_item"]').val();

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
    
    var item_movement_data_url = '<?php echo $item_movement_data; ?>';
  
    item_movement_data_url = item_movement_data_url.replace(/&amp;/g, '&');

    item_movement_data_url = item_movement_data_url + '&vbarcode='+ vbarcode +'&start_date='+start_date+'&end_date='+end_date+'&data_by='+data_by;

    $.getJSON(item_movement_data_url, function(result){
      
      $("div#divLoading").addClass('show');

      var html = '';
      $('#item_movement_by_date_selection_table > tbody').empty();

      if(result.length){

        $.each(result,function(i, v) {
          html += '<tr>';
          if(data_by == 'sold'){
            html += '<td><button data-idettrnid="'+ v.idettrnid +'" data-isalesid="'+ v.isalesid +'" class="btn btn-info print-sales"><i class="fa fa-print"></i> Print</button></td>';
          }
          html += '<td>';
          if(data_by == 'sold'){
            html += 'Sales';
          }else{
            html += 'Receive';
          }
          html += '</td>';
          html += '<td>';
          html += v.ddate;
          html += '</td>';
          html += '<td class="text-right">';
          html += parseInt(v.items_count);
          html += '</td>';
          html += '<td class="text-right">';
          html += parseInt(v.npack);
          html += '</td>';
          html += '<td class="text-right">';
          html += v.size;
          html += '</td>';
          html += '<td class="text-right">';
          html += parseFloat(v.total_price).toFixed(4);
          html += '</td>';
          html += '<tr>';
        });
        $('#item_movement_by_date_selection_table > tbody').append(html);

      }else{
        
        $('#item_movement_by_date_selection_table > tbody').append('<tr><td class="text-center" colspan="6">Sorry no data found!</td> </tr>');
      }
      $('#item_movement_by_date_selection').show();
      $('#item_movement_by_date_selection_table').show();

      $("div#divLoading").removeClass('show');

    });

  });

  $(document).on('change', 'select[name="search_by_item"]', function(event) {
    event.preventDefault();
    
    if($(this).val() == 'sold'){
      $('#item_movement_by_date_selection_table').hide();
      $('#item_movement_by_date_selection_table #first_th').show();
    }else{
      $('#item_movement_by_date_selection_table').hide();

      $('#item_movement_by_date_selection_table #first_th').hide();
    }
  });
</script>

<script type="text/javascript">
  $(document).on('click', '.print-sales', function(event) {
    event.preventDefault();
  
    var isalesid =$(this).attr("data-isalesid");
    var idettrnid =$(this).attr("data-idettrnid");

    var item_movement_print_data_url = '<?php echo $item_movement_print_data; ?>';
  
    item_movement_print_data_url = item_movement_print_data_url.replace(/&amp;/g, '&');

    item_movement_print_data_url = item_movement_print_data_url+"&isalesid="+isalesid+"&idettrnid="+idettrnid;

    $("div#divLoading").addClass('show');

    $.ajax({
        url : item_movement_print_data_url,
        type : 'GET',
    }).done(function(response){

    var  response = $.parseJSON(response); //decode the response array
      
    if(response.code == 1 ){
      $("div#divLoading").removeClass('show');
      $('.modal-body').html(response.data);
      $('#view_salesdetail_model').modal('show');
    
    }else if(response.code == 0){
      alert('Something Went Wrong!!!');
      $("div#divLoading").removeClass('show');
      return false;
      }   
  });

  });
</script>

<div class="modal fade" id="view_salesdetail_model" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">        
      <div class="modal-body" id="printme">          
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="itemBtnPrint">Print</button>
    </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var printpage_url = '<?php echo $printpage; ?>';
    printpage_url = printpage_url.replace(/&amp;/g, '&');

    $("#itemBtnPrint").printPage({
      url : printpage_url,
    });
  });
</script>