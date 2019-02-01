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
        <?php } ?>
      </div>
      <div class="panel-body">
        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-3">
              <select name="report_by" class="form-control" id="report_by">
                <option value="">Please Select Report</option>
                <?php foreach ($byreports as $key => $value){ ?>
                  <?php if(isset($selected_report_by) && ($selected_report_by == $key)){ ?>
                  <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                  <?php }else{ ?>
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
            <table class="table table-bordered" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Name</th>
                  <th class="text-right">Unit Cost</th>
                  <th class="text-right">Price</th>
                  <th class="text-right">Qty Sold</th>
                  <th class="text-right">Total Cost</th>
                  <th class="text-right">Total Price</th>
                  <th class="text-right">Mark Up(%)</th>
                  <th class="text-right">Gross Profit</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $grand_total_qty_sold = 0;
                    $grand_total_total_cost = 0;
                    $grand_total_total_price = 0;
                    $grand_total_mark_up = 0;
                    $grand_total_gross_profit = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td style="border:none;"><b><?php echo $key; ?></b></td>
                    </tr>
                    <?php 
                      $total_qty_sold = 0;
                      $total_total_cost = 0;
                      $total_total_price = 0;
                      $total_mark_up = 0;
                      $total_gross_profit = 0;
                    ?>
                    <?php foreach ($value as $k => $v){ ?>
                      <tr>
                        <td><?php echo $v['vITemName']; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['DCOSTPRICE'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['dUnitPrice'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo $v['TotalQty']; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['TotCostPrice'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['TOTUNITPRICE'], 2, '.', '') ; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['AmountPer'], 2, '.', '') .'%'; ?></td>
                        <td class="text-right"><?php echo number_format((float)$v['Amount'], 2, '.', '') ; ?></td>

                        <?php 
                          $total_qty_sold = $total_qty_sold + $v['TotalQty'];
                          $total_total_cost = $total_total_cost + number_format((float)$v['TotCostPrice'], 2, '.', '') ;
                          $total_total_price = $total_total_price + number_format((float)$v['TOTUNITPRICE'], 2, '.', '') ;
                          $total_mark_up = $total_mark_up + number_format((float)$v['AmountPer'], 2, '.', '') ;
                          $total_gross_profit = $total_gross_profit + number_format((float)$v['Amount'], 2, '.', '') ;
                        ?>

                      </tr>
                    <?php } ?>
                    <tr>
                      <td><b>Sub Total</b></td>
                      <td>&nbsp;&nbsp;</td>
                      <td>&nbsp;&nbsp;</td>
                      <td class="text-right"><b><?php echo $total_qty_sold; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_total_cost, 2, '.', '') ; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_total_price, 2, '.', '') ; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_mark_up, 2, '.', '') .'%'; ?></b></td>
                      <td class="text-right"><b><?php echo number_format((float)$total_gross_profit, 2, '.', '') ; ?></b></td>

                      <?php 
                        $grand_total_qty_sold = $grand_total_qty_sold + $total_qty_sold;
                        $grand_total_total_cost = $grand_total_total_cost + $total_total_cost;
                        $grand_total_total_price = $grand_total_total_price + $total_total_price;
                        $grand_total_mark_up = $grand_total_mark_up + $total_mark_up;
                        $grand_total_gross_profit = $grand_total_gross_profit + $total_gross_profit;
                      ?>

                    </tr>
                  <?php } ?>
                  <tr>
                    <td><b>Grand Total</b></td>
                    <td>&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;</td>
                    <td class="text-right"><b><?php echo $grand_total_qty_sold; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_total_cost, 2, '.', '') ; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_total_price, 2, '.', '') ; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_mark_up, 2, '.', '') .'%'; ?></b></td>
                    <td class="text-right"><b><?php echo number_format((float)$grand_total_gross_profit, 2, '.', '') ; ?></b></td>
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
                  <strong>Sorry we not found any result!!!</strong>
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
  $(document).on('change', '#report_by', function(event) {
    event.preventDefault();
    var reportdata_url = '<?php echo $reportdata; ?>';
    
    reportdata_url = reportdata_url.replace(/&amp;/g, '&');

    var report_id = $(this).val();

    if($(this).val() == ''){
      $('#div_report_data').hide();
      alert('Please Select Report');
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
        }

        // $('#report_data').next('span').css('width','100%');
        // $('#report_data').next('span').find('input.select2-search__field').css('width','100%');
        
        $('#div_report_data').show();
        $("div#divLoading").removeClass('show');
       
        return false;
      }else if(response.code == 0){
        alert('Something Went Wrong!!!');
        $("div#divLoading").removeClass('show');
        return false;
      }
      
    });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by').val() == ''){
    alert('Please Select Report');
    return false;
  }

  if($('#report_by').val() == '1'){
      if($('#report_data > option:selected').length == 0){
        alert('Please Select Category');
        return false;
      }
  }else if($('#report_by').val() == '2'){
    if($('#report_data > option:selected').length == 0){
       alert('Please Select Department');
      return false;
    }
  }else{
    if($('#report_data > option:selected').length == 0){
      alert('Please Select Item Group');
    return false;
    }
  }

  if($('#report_data').val() == ''){
    if($('#report_by').val() == '1'){
      alert('Please Select Category');
      return false;
    }else if($('#report_by').val() == '2'){
      alert('Please Select Department');
      return false;
    }else{
      alert('Please Select Item Group');
      return false;
    }
  }

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

</style>

<script>  
$(document).ready(function() {
  $("#btnPrint").printPage();
});
</script>