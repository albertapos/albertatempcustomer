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
        <?php if(isset($p_start_date)){ ?>
        <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        <a href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
        <?php } ?>
      </div>
      <div class="panel-body">
        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-3">
              <select name="report_by[]" class="form-control" id="report_by" multiple="true">

              <?php if(isset($selected_byreports) && count($selected_byreports) > 0){ ?>
                    <option value="">Please Select Vendor</option>
                    <?php if(in_array('ALL', $selected_byreports)){ ?>
                      <option value="ALL" selected="selected">ALL</option>
                    <?php } else { ?>
                      <option value="ALL">ALL</option>
                    <?php } ?>

                    <?php foreach($byreports as $k => $v){ ?>
                      <?php $sel_report = false; ?>
                      <?php foreach($selected_byreports as $ks => $selected_byreport){ ?>
                        <?php if($selected_byreport == $v['vsuppliercode']){ ?>
                            <option value="<?php echo $v['vsuppliercode']; ?>" selected="selected"><?php echo $v['vcompanyname']; ?></option>
                            <?php 
                              $sel_report = true;
                              break;
                            ?>
                        <?php } ?>
                      <?php } ?>
                      <?php if($sel_report == false){ ?>
                        <option value="<?php echo $v['vsuppliercode']; ?>"><?php echo $v['vcompanyname']; ?></option>
                      <?php } ?>
                    <?php } ?>
                    
              <?php } else { ?>
                <option value="">Please Select Vendor</option>
                <option value="ALL">ALL</option>
                  <?php foreach ($byreports as $key => $value){ ?>
                  <option value="<?php echo $value['vsuppliercode']; ?>"><?php echo $value['vcompanyname']; ?></option>
                  <?php } ?>
              <?php } ?>
              </select>
            </div>
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
            <table class="table table-bordered table-striped table-hover" style="border:none;width: 50%;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Vendor</th>
                  <th>Date</th>
                  <th class="text-right">Net Total</th>
                  <th>View Item</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $total_nnettotal = 0;
                  ?>
                  <?php foreach ($reports as $key => $value){ ?>
                  <tr>
                    <td class="text-left"><?php echo $value['vvendorname']; ?></td>
                    <td class="text-left"><?php echo $value['dcreatedate']; ?></td>
                    <td class="text-right"><?php echo number_format((float)$value['nnettotal'], 2, '.', '') ; ?></td>
                    <td class="text-left"><button data-id="<?php echo $value['vvendorid']; ?>" data-name="<?php echo $value['vvendorname']; ?>" data-date="<?php echo $value['dcreatedate'] ;?>" class="btn btn-info btn-sm view_item_btn"><i class="fa fa-eye" aria-hidden="true"></i> view</button></td>
                    <?php 
                      $total_nnettotal = $total_nnettotal + $value['nnettotal'];
                    ?>
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
  $(document).ready(function() {
    // $('#report_by').select2({
    //   placeholder: "Please Select Vendor"
    // });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by > option:selected').length == 0){
    alert('Please Select Vendor');
    return false;
  }

  if($('#report_by').val() == ''){
    alert('Please Select Vendor');
    return false;
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
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
  }

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

<script type="text/javascript">
  $(document).on('click', '.view_item_btn', function(event) {
    event.preventDefault();

    var view_item_url = '<?php echo $view_item; ?>';
    
    view_item_url = view_item_url.replace(/&amp;/g, '&');

    var vendor_id = $(this).attr('data-id');
    var vendor_name = $(this).attr('data-name');
    var vendor_date = $(this).attr('data-date');

    $("div#divLoading").addClass('show');

    $.ajax({
        url : view_item_url+'&vendor_id='+vendor_id+'&vendor_date='+vendor_date,
        type : 'GET',
    }).done(function(response){
      
      var  response = $.parseJSON(response); //decode the response array
      
      if( response.code == 1 ) {//success
        $('#item_table_body').empty();

        var html_item_table = '';

        $.each(response.data, function(i, v) {
            html_item_table += '<tr>';
            html_item_table += '<td>'+v.vbarcode+'</td>';
            html_item_table += '<td>'+v.vitemname+'</td>';
            html_item_table += '<td>'+v.vvendorname+'</td>';
            html_item_table += '<td>'+v.vsize+'</td>';
            html_item_table += '<td>'+v.nordqty+'</td>';
            html_item_table += '<td>'+v.npackqty+'</td>';
            html_item_table += '<td>'+v.itotalunit+'</td>';
            html_item_table += '<td>'+v.nordextprice+'</td>';
            html_item_table += '<td class="text-right">'+parseFloat(v.nunitcost).toFixed(2)+'</td>';
            html_item_table += '</tr>';
        });

        $('#item_table_body').append(html_item_table);

        $('#modal_title').html('Items of '+vendor_name);
        $("div#divLoading").removeClass('show');
        $('#view_item_modal').modal('show');
        return false;
      }else if(response.code == 0){
        alert('Something Went Wrong!!!');
        $("div#divLoading").removeClass('show');
        return false;
      }
      
    });

  });
</script>


<!-- Modal -->
  <div class="modal fade" id="view_item_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-uppercase" id="modal_title">Modal Header</h4>
        </div>
        <div class="modal-body" style="overflow-x:scroll !important;">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>SKU#</th>
                <th>Item Name</th>
                <th>Vendor Code</th>
                <th>Size</th>
                <th>Total Case</th>
                <th>Case Qty</th>
                <th>Total Unit</th>
                <th>Total Amt</th>
                <th class="text-right">Unit Cost</th>
              </tr>
            </thead>
            <tbody id="item_table_body">
              <tr>
                <td>test</td>
                <td>10.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>