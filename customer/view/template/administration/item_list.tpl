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
        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <span><input type="checkbox" name="disable_checkbox" <?php if($show_items == 'Inactive'){ ?> checked <?php } ?>>&nbsp;&nbsp;<b>Show Disable Items</b></span>&nbsp;&nbsp;
              <a href="<?php echo $current_url; ?>" title="Show All Items" class="btn btn-primary show_all_btn_rotate"><i class="fa fa-eye"></i>&nbsp;&nbsp;Show All Items</a>
               
                 <button type="button" class="btn btn-danger" id="delete_btn" style="border-radius: 0px;float: right;"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Delete Items</button>
             
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#importItemModal"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Import Items</button>
              <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>&nbsp;  
            </div>
          </div>
        </div>
        
       
          <div class="row">
              <div class="col-md-12">
                  <input type="text" name="automplete-search-box" class="form-control" placeholder="Search Item..." id="automplete-product" <?php if($show_items == 'Inactive'){ ?> disabled <?php } ?>>
              </div>
          </div>
        
        <br>
        <form action="" method="post" enctype="multipart/form-data" id="form-items">
          
          <div class="table-responsive">
            <table id="item" class="table table-bordered table-hover">
            <?php if ($items) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left text-uppercase"><a href="<?php echo $item_sorting;?>" style="color: #fff;" class="show_all_btn_rotate"><?php echo $column_itemname; ?></a></th>
                  <th class="text-left text-uppercase"><?php echo $column_itemtype; ?></th>
                  <th class="text-left text-uppercase"><?php echo $column_sku; ?></th>
                  <?php if(isset($itemListings) && count($itemListings)){ ?>
                    <?php foreach($itemListings as $m => $itemListing){ ?>
                       <th class="text-left text-uppercase"><?php echo $title_arr[$m];?></th>
                      <?php } ?>
                  <?php } else { ?>
                    <th class="text-left text-uppercase"><?php echo $column_deptcode; ?></th>
                    <th class="text-left text-uppercase"><?php echo $column_categorycode; ?></th>
                    <th class="text-right text-uppercase"><?php echo $column_price; ?></th>
                    <th class="text-right text-uppercase"><?php echo $column_qtyonhand; ?></th>
                  <?php } ?>
                  <!-- <th class="text-left text-uppercase"><?php echo $column_action; ?></th> -->
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($items as $item) { ?>
                  <tr>
                    <td data-order="<?php echo $item['iitemid']; ?>" class="text-center">
                    <input type="checkbox" name="selected[]" class="iitemid"  value="<?php echo $item['iitemid']; ?>" />
                    </td>
                    
                    <td class="text-left">
                      <a href="<?php echo $item['edit']; ?>" data-toggle="tooltip" title="Edit" class="edit_btn_rotate"><?php echo $item['VITEMNAME']; ?>
                      </a>
                    </td>
                    
                    <td class="text-left">
                      <span><?php echo $item['vitemtype']; ?></span>
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['vbarcode']; ?></span>
                    </td>

                    <?php if(isset($itemListings) && count($itemListings)){ ?>
                      <?php foreach($itemListings as $m => $itemListing){ ?>
                        <td class="text-left">
                          <?php if($m == 'vcategorycode'){ ?>
                            <span><?php echo $item['vcategoryname']; ?></span>
                          <?php }elseif($m == 'vdepcode'){ ?>
                            <span><?php echo $item['vdepartmentname']; ?></span>
                          <?php }elseif($m == 'vsuppliercode'){ ?>
                            <span><?php echo $item['vcompanyname']; ?></span>
                          <?php }elseif($m == 'vunitcode'){ ?>
                            <span><?php echo $item['vunitname']; ?></span>
                          <?php }elseif($m == 'stationid'){ ?>
                            <span><?php echo $item['stationname']; ?></span>
                          <?php }elseif($m == 'shelfid'){ ?>
                            <span><?php echo $item['shelfname']; ?></span>
                          <?php }elseif($m == 'aisleid'){ ?>
                            <span><?php echo $item['aislename']; ?></span>
                          <?php }elseif($m == 'shelvingid'){ ?>
                            <span><?php echo $item['shelvingname']; ?></span>
                          <?php }elseif($m == 'iqtyonhand'){ ?>
                            <span><?php echo $item['QOH']; ?></span>
                          <?php }else{ ?>
                            <span><?php echo $item[$m]; ?></span>
                          <?php } ?>
                        </td>
                      <?php } ?>
                    <?php }else{ ?>
                      <td class="text-left">
                        <span><?php echo $item['vdepartmentname']; ?></span>
                      </td>

                      <td class="text-left">
                        <span><?php echo $item['vcategoryname']; ?></span>
                      </td>

                      <td class="text-right">
                        <span><?php echo $item['dunitprice']; ?></span>
                      </td>

                      <td class="text-right">
                        <span><?php echo $item['QOH']; ?></span>
                      </td>
                    <?php } ?>

                    <!-- <td class="text-left">
                      <a href="<?php echo $item['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                      </a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="<?php echo $item['clone_item']; ?>" data-toggle="tooltip" title="Clone Item" class="btn btn-sm btn-info" ><i class="fa fa-clone">&nbsp;&nbsp;Clone</i>
                      </a>
                    </td> -->
                  </tr>
    
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

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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
                            id: val.iitemid
                        });
                    });
                    add(window.suggestions);
                });
            },
            select: function(e, ui) {
              var edit_url = "<?php echo $edit; ?>";
              edit_url = edit_url.replace(/&amp;/g, '&');
              edit_url = edit_url+'&iitemid='+ui.item.id;

              $("div#divLoading").addClass('show');
              window.location.href = edit_url;

                // $('form#form_item_search #iitemid').val(ui.item.id);
                
                // if($('#iitemid').val() != ''){
                //     $("div#divLoading").addClass('show');
                //     $('#form_item_search').submit();
                // }
            }
        });
    });
</script>

<!-- Modal -->
<div id="importItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Items</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="<?php echo $import_items;?>" id="form_item_import">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <span style="display:inline-block;width:15%;">Separated By: </span> <span style="display:inline-block;width:80%;">
                <input type="radio" name="separated_by" value="comma" checked="checked">&nbsp;&nbsp;Comma&nbsp;&nbsp;
                <input type="radio" name="separated_by" value="pipe">&nbsp;&nbsp;Pipe
              </span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <span style="display:inline-block;width:15%;">File: </span> <span style="display:inline-block;width:80%;"><input type="file" name="import_item_file" class="form-control" required></span>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <div class="form-group">
              <input type="submit" value="Import" class="btn btn-success">&nbsp;
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="successModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p id="success_msg"><strong>Items Imported Successfully!</strong></p>
        </div>
        <div class="text-center" style="display:none;">
          <a id="status_file" href="/view/template/administration/import-item-status-report.txt" download="import-item-status-report.txt">Status of Imported File</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('submit', 'form#form_item_import', function(event) {
    event.preventDefault();

    $("div#divLoading").addClass('show');
    $('#importItemModal').modal('hide');

    var import_form_id = $('form#form_item_import');
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
          console.log(response);
          var  response = $.parseJSON(response); //decode the response array
          if( response.code == 1 ) {//success

            $("div#divLoading").removeClass('show');
            $('#successModal').modal('show');
            $('#status_file')[0].click();
            
            setTimeout(function(){
              window.location.reload();
            }, 3000);
            
          } else if( response.code == 0 ) {//error
            $("div#divLoading").removeClass('show');
            alert(response.error);
            return;
          }
      
      });
  });


  $('input[name="disable_checkbox"]').change(function() {
      var current_url = "<?php echo $current_url; ?>";
      current_url = current_url.replace(/&amp;/g, '&');
      
        if($(this).is(":checked")) {
            current_url = current_url+'&show_items=Inactive';
            window.location.href = current_url;
            $("div#divLoading").addClass('show');
        }else{
          current_url = current_url+'&show_items=Active';
          window.location.href = current_url;
          $("div#divLoading").addClass('show');
        }
    });

  $(document).on('keyup, keypress', '#automplete-product', function(event) {
    // event.preventDefault();
    if(event.keyCode == 13){

      $("div#divLoading").addClass('show');

      var get_barcode_url = "<?php echo $get_barcode; ?>";
      get_barcode_url = get_barcode_url.replace(/&amp;/g, '&');

      var search_item = $('#automplete-product').val();

      if(search_item != ''){
        get_barcode_url = get_barcode_url+'&vbarcode='+search_item;
        $.getJSON(get_barcode_url, function(result){
          var edit_url = "<?php echo $edit; ?>";
          edit_url = edit_url.replace(/&amp;/g, '&');
          edit_url = edit_url+'&iitemid='+result.iitemid;

          if(result.iitemid){
            window.location.href = edit_url;
            $("div#divLoading").addClass('show');
            return false;
          }
          $("div#divLoading").removeClass('show');
          return false;
        });
      }
      return false;

    }
    
  });

  $(function() { $('[name="automplete-search-box"]').focus(); });
</script>
    <!-- Delete items -->

<script type="text/javascript">
    // $(document).on('click', 'input[name=deleteItems]', function(){
        
    //     var dataItemOrders = [];
        
    //      $('.iitemid').filter(':checked').each(function(){
    //          dataItemOrders.push($(this).parents('td').data('order'));
    //      })
    //     // console.log(dataItemOrders);
    // })
 
</script>


<script type="text/javascript">
  $(document).on('click', '#delete_btn', function(event) {
    event.preventDefault();
    
    $('#deleteItemModal').modal('show');

  });
</script>

<div id="deleteItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Item</h4>
      </div>
      <div class="modal-body">
        <p>Are you Sure?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-danger" name="deleteItems" value="Delete">
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

    var dataItemOrders = [];

     $(document).on('click', 'input[name=deleteItems]', function(){
        
        
        
         $('.iitemid').filter(':checked').each(function(){
             dataItemOrders.push($(this).parents('td').data('order'));
         });
        // console.log(dataItemOrders);
    });

    $(document).on('click', 'input[name="deleteItems"]', function(event) {
        event.preventDefault();
        var delete_url = '<?php echo $delete; ?>';
        delete_url = delete_url.replace(/&amp;/g, '&');
        
        // var data = dataItemOrders;
        // var url = '<?php echo $delete; ?>';
        // // url = url.replace(/&amp;/g, '&');
        // url = 'index.php?route=administration/items/delete&token=<?php echo $token; ?>';
    
        // <?php if(isset($iitemid) && $iitemid != ''){?>
        //   var item_id = '<?php echo $iitemid; ?>';
        //   data[0] = parseInt(item_id);
        // <?php } else { ?>
        //   bootbox.alert({ 
        //     size: 'small',
        //     title: "Attention", 
        //     message: 'Something Went Wrong!', 
        //     callback: function(){}
        //   });
        //   return false;
        // <?php } ?>
        
        $('#deleteItemModal').modal('hide');
        $("div#divLoading").addClass('show');
        
         $.ajax({
             
        url : delete_url,
        data : JSON.stringify(dataItemOrders),
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

<div class="modal fade" id="deleteItemSuccessModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p><b>Item Deleted Successfully</b></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>

<!-- Delete items -->

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>