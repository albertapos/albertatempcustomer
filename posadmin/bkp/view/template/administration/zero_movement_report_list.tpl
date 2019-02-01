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
                        <?php if($selected_byreport == $v['id']){ ?>
                            <option value="<?php echo $v['id']; ?>" selected="selected"><?php echo $v['name']; ?></option>
                            <?php 
                              $sel_report = true;
                              break;
                            ?>
                        <?php } ?>
                      <?php } ?>
                      <?php if($sel_report == false){ ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                    
              <?php } else { ?>
                <option value="">Please Select Department</option>
                <option value="ALL">ALL</option>
                <?php foreach ($byreports as $key => $value){ ?>
                  <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php } ?>
              <?php } ?>

              </select>
            </div>
            <div class="col-md-2" style="margin-left: 3%;">
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
            <p><b>Date Range: </b><?php echo date("m-d-Y", strtotime($p_start_date)); ?> to <?php echo date("m-d-Y", strtotime($p_end_date)); ?></p>
          </div>
          <div class="col-md-12">
          <br>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Supplier</th>
                  <th>Department</th>
                  <th>Item</th>
                  <th class="text-right">Qty On Hand</th>
                  <th class="text-right">Cost</th>
                  <th class="text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $tot_cost = 0;
                    $tot_price = 0;
                   ?>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['suppliername'];?></td>
                      <td><?php echo $value['vname'];?></td>
                      <td><?php echo $value['itemname'];?></td>
                      <td class="text-right"><?php echo $value['vqty'];?></td>
                      <td class="text-right"><?php echo number_format((float)$value['cost'], 2, '.', '') ;?></td>
                      <td class="text-right"><?php echo number_format((float)$value['price'], 2, '.', '') ;?></td>
                      <?php 
                        $tot_cost = $tot_cost + $value['cost'];
                        $tot_price = $tot_price + $value['price'];
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
  $(document).ready(function() {
    // $('#report_by').select2({
    //   placeholder: "Please Select Department"
    // });
  });

$(document).on('submit', '#filter_form', function(event) {
  
  if($('#report_by > option:selected').length == 0){
    alert('Please Select Department');
    return false;
  }
  
  if($('#report_by').val() == ''){
    alert('Please Select Department');
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