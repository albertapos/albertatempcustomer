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
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <a href="<?php echo $print_page; ?>" id="btnPrint" class="pull-right"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
        <a href="<?php echo $pdf_save_page; ?>" class="pull-right" style="margin-right:10px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
        <?php } ?>
      </div>
      <div class="panel-body">
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
              <input type="submit" class="btn btn-success" value="Filter">
            </div>
          </form>
        </div>
        <?php if(isset($reports) && count($reports) > 0){ ?>
        <br><br><br>
        <div class="row">
          <div class="col-md-12">
            <p><b>Date: </b><?php echo date("m-d-Y"); ?></p>
          </div>
          <div class="col-md-12">
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
    }

  if($('#report_data').val() == ''){
    if($('#report_by').val() == '1'){
      alert('Please Select Category');
      return false;
    }else if($('#report_by').val() == '2'){
      alert('Please Select Department');
      return false;
    }
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