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
        <div class="row">
          <form method="post" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>" id="start_date" placeholder="Start Date">
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>" id="end_date" placeholder="End Date">
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
            <p><b>Date Range: </b><?php echo $start_date; ?> to <?php echo $end_date; ?></p>
          </div>
          <div class="col-md-12">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>Date</th>
                  <th>Reg</th>
                  <th>Tran#</th>
                  <th class="text-right">Total</th>
                  <th class="text-right">Change</th>
                  <th class="text-right">Total Tax</th>
                  <th>Tender Type</th>
                  <th>Trn Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($reports as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['dtrandate'];?></td>
                      <td><?php echo $value['vterminalid'];?></td>
                      <td><?php echo $value['trnsalesid'];?></td>
                      <td class="text-right"><?php echo $value['nnettotal'];?></td>
                      <td class="text-right"><?php echo $value['nchange'];?></td>
                      <td class="text-right"><?php echo $value['ntaxtotal'];?></td>
                      <td><?php echo $value['vtendertype'];?></td>
                      <td><?php echo $value['vtrntype'];?></td>
                       <td><a class="btn btn-primary print-sales" id="print" data-id="<?php echo $value['isalesid'];?>"><i class="fa fa-print"></i> Print </a></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">          
          <div class="col-sm-6 text-left"><?php echo $results; ?></div>
          <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
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
  $(document).on('click', '.print-sales', function(event) {
    event.preventDefault();
	
	var salesid =$(this).attr("data-id");

    $("div#divLoading").addClass('show');

    $.ajax({
        url : "index.php?route=administration/sales_report/sales_view&token=<?php echo $token; ?>"+'&salesid='+salesid,
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
		url : "index.php?route=administration/sales_report/printpage&token=<?php echo $token; ?>",
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnPrint">Print</button>
      </div>
      </div>
    </div>
  </div>
  
<?php echo $footer; ?>