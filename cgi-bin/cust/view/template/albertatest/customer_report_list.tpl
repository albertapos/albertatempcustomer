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
          <form action="<?php echo $current_url;?>" method="post" id="form_customer_report_search">
            <input type="hidden" name="searchbox" id="vcustomername">
            <div class="row">
                <div class="col-md-12" style="padding-left: 3%;padding-right: 3%;">
                    <input type="text" name="automplete-product" class="form-control" placeholder="Search By Customer..." id="automplete-product">
                </div>
            </div>
          </form>

          <div class="col-md-12 table-responsive">
          <br>
            <?php if($customers){?>
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
            <?php }else{ ?>
              <div class="row">          
                <div class="col-sm-12 text-center">Sorry no data found!</div>
              </div>
            <?php } ?>
          </div>
          <?php if($customers){?>
          <div class="row">          
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/jquery.printPage.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<style type="text/css">

</style>

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
<!-- <script src="view/javascript/jquery.dataTables.min.js"></script>-->
<!-- <script src="view/javascript/dataTables.bootstrap.min.js"></script> -->
<script type="text/javascript">
// $('#customer_table').DataTable({
//    "paging": true,
//     "iDisplayLength": 25,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//     "info": true,
//     "autoWidth": true,
//     "aaSorting": [[ 0, "desc" ]],
//     "oLanguage": { "sSearch": "" },
    
// });
</script> 
<style type="text/css">
  /*#customer_table_filter, #customer_table_paginate{
    float: right;
  }
  #customer_table_filter{
    margin-bottom: 5%;
  }*/
</style>
<script type="text/javascript">
  // $(document).ready(function() {
  //   $('#customer_table_length').parent().hide();
  //   $('#customer_table_info').parent().hide();

  //   $('#customer_table_filter').css('float','left');
  //   $('#customer_table_filter').css('margin-bottom','11px');
  //   $('#customer_table_paginate').css('float','left');

  //   $('#customer_table_filter').find('input[type="search"]').css('width','200%');
  //   $('#customer_table_filter').find('input[type="search"]').attr('placeholder','search...');
  //   $('#customer_table_filter').find('input[type="search"]').css('font-size','14px');
  //   $('#customer_table_filter').find('input[type="search"]').css('font-weight','normal');

  // });
</script> 
<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchcustomer;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vcustomername,
                            value: val.vcustomername,
                            id: val.icustomerid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_customer_report_search #vcustomername').val(ui.item.value);
                
                if($('#vcustomername').val() != ''){
                    $('#form_customer_report_search').submit();
                    $("div#divLoading").addClass('show');
                }
            }
        });
    });

    $(function() { $('input[name="automplete-product"]').focus(); });
</script>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>