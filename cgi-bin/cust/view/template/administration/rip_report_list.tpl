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
        <form action="<?php echo $current_url;?>" method="post" id="form_rip_report_search">
          <input type="hidden" name="vendorid" id="vvendorid">
          <div class="row">
              <div class="col-md-12" style="padding-left: 3%;padding-right: 3%;">
                  <input type="text" name="automplete-product" class="form-control" placeholder="Search By Vendor..." id="automplete-product">
              </div>
          </div>
        </form>
        <br>
        <div class="col-md-12">
          <div class="row">
            <form method="post" action="<?php echo $current_url;?>" id="filter_form">
            <div class="col-md-2">
              <input type="" class="form-control" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>" id="start_date" placeholder="Start Date" readonly>
            </div>
            <div class="col-md-2">
              <input type="" class="form-control" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>" id="end_date" placeholder="End Date" readonly>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success" value="Generate">
            </div>
          </form>
          </div>
        </div>
          <?php if($rips) {?>
          <div class="col-md-12 table-responsive">
          <br>
            <table class="table table-bordered table-striped table-hover" style="border:none;" id="rip_table">
              <thead>
                <tr style="border-top: 1px solid #ddd;">
                  <th>PO Number</th>
                  <th>Vendor Name</th>
                  <th class="text-right">Rip Total</th>
                  <th class="text-right">Received Amt</th>
                  <th class="text-right">Pending Amt</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach ($rips as $key => $value){ ?>
                    <tr>
                      <td><?php echo $value['ponumber'];?></td>
                      <td><?php echo $value['vcompanyname'];?></td>
                      <td class="text-right"><?php echo $value['riptotal'];?></td>
                      <td class="text-right"><?php echo $value['receivedtotalamt'];?></td>
                      <td class="text-right"><?php echo $value['pendingtotalamt'];?></td>
                       <td><a class="btn btn-primary print-rip" id="print" data-id="<?php echo $value['id'];?>"><i class="fa fa-eye"></i>&nbsp;&nbsp;View </a>  <a class="btn btn-primary" id="addrip" data-id="<?php echo $value['id'];?>"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add </a></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
          <?php }else{ ?>
          <br><br>
            <div class="row" style="margin-top: 20px;">
              <div class="col-md-12 alert alert-info">
                <div class="text-center">
                  <strong>Sorry no data found!</strong>
                </div>
              </div>
            </div>
        <?php } ?>

        <?php if ($rips) { ?>
          <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
          <?php } ?>

        </div>
      </div>
    </div>
  
</div>

<div id="divLoading"></div>
<!-- Modal -->
  <div class="modal fade" id="view_rip_model" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">        
        <div class="modal-body" id="printme">          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
      </div>
      </div>
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modal fade" id="add_rip_model" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content"> 
      <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Rip Detail</h4>
            </div>       
        <div class="modal-body" id="printrip"> 
        <form action="index.php?route=administration/rip_report/rip_add&token=<?php echo $token; ?>" method="post" enctype="multipart/form-data" id="form-model_addrip"  class="form-horizontal"> 
        <input type="hidden" name="ripheaderid" id="ripheaderid" value="" />             
                <div class="form-group">
                  <label class="col-sm-3 control-label" >Check Number<span data-toggle="tooltip" title="Max 25 Character"></span></label>
                  <div class="col-sm-6">
                    <input type="text" name="checknumber" id="checknumber" maxlength="25" class="form-control"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" >Check Amount</label>
                  <div class="col-sm-6">
                    <input type="text" name="checkamt" id="checkamt" placeholder="0.00" class="form-control"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Check Desc# <span data-toggle="tooltip" title="Max 50 Character"></span></label>
                  <div class="col-sm-6">
                    <input type="text" name="checkdesc" id="checkdesc" maxlength="50" class="form-control"/>
                  </div>
                </div>                
              </form>         
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
        <button type="button" class="btn btn-primary" id="saverip"><i class="fa fa-save"></i>&nbsp; Save</button>
      </div>
      </div>
    </div>
  </div>
<script src="view/javascript/jquery.printPage.js"></script>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
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

  $(document).on('submit', '#filter_form', function(event) {
  
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
  $(document).on('click', '.print-rip', function(event) {
    event.preventDefault();
	
	var ripheaderid =$(this).attr("data-id");

    $("div#divLoading").addClass('show');

    $.ajax({
        url : "index.php?route=administration/rip_report/rip_view&token=<?php echo $token; ?>"+'&ripheaderid='+ripheaderid,
        type : 'GET',
    }).done(function(response){
		var  response = $.parseJSON(response); //decode the response array
      
		if(response.code == 1 ){
			$("div#divLoading").removeClass('show');
			$('#printme').html(response.data);
			$('#view_rip_model').modal('show');
		
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
  
$(document).on('click', '#addrip', function(event) {
 	
	var ripheaderid =$(this).attr("data-id");
 
	$('#add_rip_model').modal('show');
	$('#ripheaderid').val(ripheaderid);
	
});

$(document).on('click', '#saverip', function(event) {
	var checknumber = $("#checknumber").val();
	var checkamt = $("#checkamt").val();
	var checkdesc = $("#checkdesc").val();
	
	if(checknumber==""){
		// alert("Please Enter Check Number");
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Enter Check Number", 
      callback: function(){}
    });
		$("#checknumber").focus();
		return false;
	}else if(checkamt==""){
		// alert("Please Enter Check Amount");
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please Enter Check Amount", 
      callback: function(){}
    });
		$("#checkamt").focus();
		return false;
	}else{
		$("#form-model_addrip").submit();	
	}	
});
</script> 
<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchvendor;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vcompanyname,
                            value: val.vcompanyname,
                            id: val.isupplierid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_rip_report_search #vvendorid').val(ui.item.id);
                
                if($('#vvendorid').val() != ''){
                    $('#form_rip_report_search').submit();
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