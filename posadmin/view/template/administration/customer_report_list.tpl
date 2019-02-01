<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <!-- <h1>< ?php echo $heading_title; ?></h1> -->
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
        <!--<div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="< ?php echo isset($start_date) ? $start_date : ''; ?>" id="start_date" placeholder="Start Date">
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="< ?php echo isset($end_date) ? $end_date : ''; ?>" id="end_date" placeholder="End Date">
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Filter">
            </div>
          </form>
        </div>
        <?php if(isset($customers) && count($customers) > 0){ ?>
        <br><br><br>
        <div class="row">
          <div class="col-md-12">
            <p><b>Date Range: </b>< ?php echo $start_date; ?> to < ?php echo $end_date; ?></p>
          </div>-->
          <div class="col-md-12">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;" id="customer_table">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Acc.No</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th class="text-right">Cust.Balance</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($customers as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['vaccountnumber'];?></td>
                      <td><?php echo $value['vcustomername'];?></td>
                      <td><?php echo $value['vphone'];?></td>
                      <td class="text-right"><?php echo $value['ncustbalance'];?></td>
                      <td><?php echo $value['estatus'];?></td>
                       <td><a class="btn btn-primary print-customer" id="print" data-id="<?php echo $value['icustomerid'];?>"><i class="fa fa-eye"></i>&nbsp;&nbsp;View </a></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!--<div class="row">          
          <div class="col-sm-6 text-left"><?php echo $results; ?></div>
          <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
        </div>-->
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
  $(document).on('click', '.print-customer', function(event) {
    event.preventDefault();
	
	var icustomerid =$(this).attr("data-id");

    $("div#divLoading").addClass('show');

    $.ajax({
        url : "index.php?route=administration/customer_report/customer_view&token=<?php echo $token; ?>"+'&icustomerid='+icustomerid,
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
<script> 
function openPrintDialogue(){
  $('<iframe>', {
    name: 'myiframe',
    class: 'printFrame'
  }).appendTo('body').contents().find('body').append($('#printme').html());

  window.frames['myiframe'].focus();
  window.frames['myiframe'].print();

  setTimeout(function(){$(".printFrame").remove(); }, 1000);
}; 
$(document).ready(function() {
	/*$('.btnPrint').on('click',function() {
		openPrintDialogue($("#printme").html()); 
	});*/
 
	$(".btnPrint").printPage({
		url : "index.php?route=administration/customer_report/printpage&token=<?php echo $token; ?>",
	});
	
});
 
</script>
<!-- Modal -->
  <div class="modal fade" id="view_salesdetail_model" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">        
        <div class="modal-body" id="printme">          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
        <button type="button" class="btn btn-primary btnPrint"><i class="fa fa-print"></i>&nbsp; Print</button>
      </div>
      </div>
    </div>
  </div>
 <script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#customer_table').DataTable({
   "paging": true,
    "iDisplayLength": 25,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "aaSorting": [[ 0, "desc" ]],
    "oLanguage": { "sSearch": "" },
    
});
</script> 
<style type="text/css">
  #customer_table_filter, #customer_table_paginate{
    float: right;
  }
  #customer_table_filter{
    margin-bottom: 5%;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $('#customer_table_length').parent().hide();
    $('#customer_table_info').parent().hide();

    $('#customer_table_filter').css('float','left');
    $('#customer_table_filter').css('margin-bottom','11px');
    $('#customer_table_paginate').css('float','left');

    $('#customer_table_filter').find('input[type="search"]').css('width','200%');
    $('#customer_table_filter').find('input[type="search"]').attr('placeholder','search...');
    $('#customer_table_filter').find('input[type="search"]').css('font-size','14px');
    $('#customer_table_filter').find('input[type="search"]').css('font-weight','normal');

  });
</script> 
<?php echo $footer; ?>