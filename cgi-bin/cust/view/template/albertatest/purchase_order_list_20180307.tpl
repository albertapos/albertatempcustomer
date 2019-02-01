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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
        
      </div>
      <div class="panel-body">
        <div class="row" style="padding-bottom:15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>  
              <button class="btn btn-info" data-toggle="modal" data-target="#myModalImport"><i class="fa fa-file"></i>&nbsp;&nbsp;Import EDI Invoice</button>
              <button class="btn btn-info" data-toggle="modal" data-target="#myModalImportMissingItem"><i class="fa fa-gift"></i>&nbsp;&nbsp;Import Missing Items</button>
              <button class="btn btn-danger" id="delete_po_btn" style="border-radius: 0px;"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete PO</button>
            </div>
          </div>
        </div>
        <div class="row" style="clear:both;">
          <form action="<?php echo $current_url;?>" method="post" id="form_order_search">
            <div class="col-md-12">
              <div style="display: inline-block;width:92%;">
                  <input type="text" name="searchbox" value="<?php echo isset($searchbox) ? $searchbox: ''; ?>" class="form-control" placeholder="Search...">
              </div>
              <div style="display: inline-block;">
                &nbsp;&nbsp;<input type="submit" name="Filter" value="Search" class="btn btn-info">
              </div>
            </div>
          </form>
        </div>
        <br>
        <form action="" method="post" enctype="multipart/form-data" id="form-purchase-order">
          
          <div class="table-responsive">
            <table id="purchase_order" class="table table-bordered table-hover">
            <?php if ($purchase_orders) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" id="main_checkbox" /></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_estatus;?>"><?php echo $column_status; ?></a></th>
                  <th class="text-right"><a style="color: #fff;" href="<?php echo $sort_vponumber;?>"><?php echo $column_purchase_ord; ?></a></th>
                  <th class="text-left"><?php echo $column_invoice; ?></th>
                  <th class="text-right"><?php echo $column_total; ?></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_vvendorname;?>"><?php echo $column_vendor_name; ?></a></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_vordertype;?>"><?php echo $column_order_type; ?></a></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_dcreatedate;?>"><?php echo $column_date_created; ?></a></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_dreceiveddate;?>"><?php echo $column_date_received; ?></a></th>
                  <th class="text-left"><a style="color: #fff;" href="<?php echo $sort_LastUpdate;?>"><?php echo $column_date_lastupdate; ?></a></th>
                  <th class="text-left"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $purchase_order_row = 1;$i=0; $bg = '#fff';?>
                <?php foreach ($purchase_orders as $purchase_order) { ?>

                <?php 
                  if($purchase_order['estatus'] == 'Close'){
                    $bg = '#FCEBCF';
                  } else {
                    $bg = '#fff';
                  } 
                ?>

                <tr id="purchase_order-row<?php echo $purchase_order_row; ?>">
                  <td data-order="<?php echo $purchase_order['ipoid']; ?>" class="text-center" style="background:<?php echo $bg; ?>">
                    <span style="display:none;"><?php echo $purchase_order['ipoid']; ?></span>
                    <input type="checkbox" name="selected[]" id="purchase_order[<?php echo $purchase_order_row; ?>][select]"  value="<?php echo $purchase_order['ipoid']; ?>" <?php if($purchase_order['estatus'] == 'Close'){?> disabled <?php } ?> />
                  </td>
                  
                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['estatus']; ?></span>
                  </td>

                  <td class="text-right" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['vponumber']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['vinvoiceno']; ?></span>
                  </td>

                  <td class="text-right" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['nnettotal']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['vvendorname']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['vordertype']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['dcreatedate']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['dreceiveddate']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <span><?php echo $purchase_order['dlastupdate']; ?></span>
                  </td>

                  <td class="text-left" style="background:<?php echo $bg; ?>">
                    <?php if($purchase_order['estatus'] == 'Close'){?>
                      <a href="<?php echo $purchase_order['edit']; ?>" data-toggle="tooltip" title="View" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-eye"></i>&nbsp;&nbsp;View
                    </a>
                    <?php } else {?>
                      <a href="<?php echo $purchase_order['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                    </a>
                    <?php } ?>
                  </td>
                </tr>
                <?php $purchase_order_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModalImport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Import Invoice</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $import_invoice;?>" method="post" enctype="multipart/form-data" id="form_import_invoice">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:8%;">File: </span> <span style="display:inline-block;width:85%;"><input type="file" name="import_invoice_file" class="form-control" required></span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:8%;">Vendor: </span> <span style="display:inline-block;width:85%;">
                <select name="vvendorid" class="form-control" required>
                  <?php if(isset($vendors) && count($vendors) > 0){?>
                    <?php foreach($vendors as $vendor){?>
                      <option value="<?php echo $vendor['isupplierid']; ?>"><?php echo $vendor['vcompanyname']; ?></option>
                    <?php } ?>
                  <?php } ?>
                  <option></option>
                </select>
                </span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:15%;">Check Digit: </span> <span style="display:inline-block;width:80%;"><input type="checkbox" name="check_digit" value="Y" class="form-control" ></span>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="import_invoice" value="Import Invoice">&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php echo $footer; ?>

<script type="text/javascript">
  $(document).on('submit', 'form#form_import_invoice', function(event) {
    event.preventDefault();

    $("div#divLoading").addClass('show');
    $('#myModalImport').modal('hide');

    var import_form_id = $('form#form_import_invoice');
    var import_form_action = import_form_id.attr('action');
    
    var import_formdata = false;
        
    if (window.FormData){
        import_formdata = new FormData(import_form_id[0]);
    }

    $.ajax({
            url : import_form_action,
            data : import_formdata ? import_formdata : import_form_id.serialize(),
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
        }).done(function(response){
          var  response = $.parseJSON(response); //decode the response array
          if( response.code == 1 ) {//success

            $("div#divLoading").removeClass('show');
            $('#successModal').modal('show');
            setTimeout(function(){
              window.location.reload();
              $("div#divLoading").addClass('show');
            }, 3000);
            
          } else if( response.code == 0 ) {//error
            $("div#divLoading").removeClass('show');
            // alert(response.error);
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: response.error, 
              callback: function(){}
            });
            return;
          }
      
      });
  });
</script>

<div class="modal fade" id="successModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p id="success_msg"><strong>Successfully Imported Invoice!</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModalImportMissingItem" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Import Missing Items</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $import_missing_items;?>" method="post" enctype="multipart/form-data" id="form_import_missing_items">
          <div class="row">
            <div class="col-md-10">
              <input name="itemsort_search" id="itemsort_search" placeholder="Search Item..." type="text" class="form-control">
            </div>
            <div class="col-md-1 text-right">
              <button class="btn btn-success" id="import_missing_item_btn">Import Items</button>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive" style="height:450px;">
                <?php if(isset($missing_items) && count($missing_items) > 0){?>
                  <table class="table table-bordered tabler-hover" id="missing_item_table">
                    <thead>
                      <tr>
                        <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected_missing_items\']').prop('checked', this.checked);" /></th>
                        <th class="text-left">SKU#</th>
                        <th class="text-left">Item Name</th>
                        <th class="text-left">Invoice#</th>
                        <th class="text-left">Vendor</th>
                        <th class="text-left">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($missing_items as $k => $missing_item){?>
                        <tr>
                          <td>
                            <input type="checkbox" name="selected_missing_items[]" id="$missing_item[<?php echo $k; ?>][select]"  value="<?php echo $missing_item['imitemid']; ?>" />
                          </td>
                          <td class="text-left"><?php echo $missing_item['vbarcode']; ?></td>
                          <td class="text-left"><?php echo $missing_item['vitemname']; ?></td>
                          <td class="text-left"><?php echo $missing_item['vponumber']; ?></td>
                          <td class="text-left"><?php echo $missing_item['vvendorname']; ?></td>
                          <td class="text-left"><?php echo $missing_item['estatus']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                <?php }else{ ?>
                  <div class="alert alert-info text-center">
                    <strong>Sorry no data found!</strong>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">
  $(function() { $('input[name="searchbox"]').focus(); });

  $(document).on('keyup', '#itemsort_search', function(event) {
    event.preventDefault();
    
    $('#missing_item_table tbody tr').hide();
    var txt = $(this).val();

    if(txt != ''){
      $('#missing_item_table tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#missing_item_table tbody tr').show();
    }
  });

  $(document).on('click', '#import_missing_item_btn', function(event) {
    event.preventDefault();

    var url = $('form#form_import_missing_items').attr('action');
    
    if($("input[name='selected_missing_items[]']:checked").length == 0){
      // alert('Please select items for import!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please select items for import!", 
        callback: function(){}
      });
      return false;
    }

    var data = {};
    $("input[name='selected_missing_items[]']:checked").each(function (i){
      data[i] = parseInt($(this).val());
    });

    $('#myModalImportMissingItem').modal('hide');
    $("div#divLoading").addClass('show');

    $.ajax({
      url : url,
      data : JSON.stringify(data),
      type : 'POST',
      contentType: "application/json",
      dataType: 'json',
    success: function(data) {
      $('#myModalImportMissingItem').modal('hide');
      $("div#divLoading").removeClass('show');
      $('#success_msg').html('<strong>'+ data.success +'</strong>');
      $('#successModal').modal('show');
      setTimeout(function(){
       window.location.reload();
       $("div#divLoading").addClass('show');
      }, 3000);
      
    },
    error: function(xhr) { // if error occured
      var  response_error = $.parseJSON(xhr.responseText); //decode the response array
      
      var error_show = '';

      if(response_error.error){
        error_show = response_error.error;
      }else if(response_error.validation_error){
        error_show = response_error.validation_error[0];
      }
      $('#myModalImportMissingItem').modal('hide');
      $("div#divLoading").removeClass('show');
      $('#error_msg').html('<strong>'+ error_show +'</strong>');
      $('#errorModal').modal('show');
      return false;
    }
  });

  });
</script>

<!-- Modal -->
  <div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p id="success_msg"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="errorModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger text-center">
            <p id="error_msg"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->
<script type="text/javascript">
  $(document).on('submit', '#form_order_search', function(event) {
    $("div#divLoading").addClass('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#main_checkbox', function(event) {
    if ($(this).prop('checked')==true){ 
      $('input[name="selected[]"]').not(":disabled").prop('checked', true);
    }else{
      $('input[name="selected[]"]').not(":disabled").prop('checked', false);
    }
  });


  $(document).on('click', '#delete_po_btn', function(event) {
    event.preventDefault();
    var delete_url = '<?php echo $delete; ?>';
    delete_url = delete_url.replace(/&amp;/g, '&');
    var data = {};

    if($("input[name='selected[]']:checked").length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Select PO to Delete!', 
        callback: function(){}
      });
      return false;
    }

    $("input[name='selected[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });
    
    $("div#divLoading").addClass('show');

    $.ajax({
        url : delete_url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {
       
        $('#success_msg').html('<strong>'+ data.success +'</strong>');
        $("div#divLoading").removeClass('show');
        $('#successModal').modal('show');

        setTimeout(function(){
         $('#successModal').modal('hide');
         window.location.reload();
        }, 3000);
      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_msg').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });
  });
</script>

<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p id="success_msg"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="errorModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger text-center">
            <p id="error_msg"></p>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
      </div>
      </div>
      
    </div>
  </div>