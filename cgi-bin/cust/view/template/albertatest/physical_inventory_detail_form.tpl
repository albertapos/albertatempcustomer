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
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body" <?php if(isset($estatus) && $estatus == 'Close'){?> style="pointer-events:none;" <?php } ?> >

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_physical_inventory_detail" title="<?php echo $button_save; ?>" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){?> disabled <?php } ?> ><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <button id="calculate_post_button" title="Calculate/Post" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){?> disabled <?php } ?> ><i class="fa fa-calculator"></i>&nbsp;&nbsp;Calculate/Post</button>
              <?php if(isset($ipiid)){?>
                <button id="import_csv_button" title="Import Physical Inventory" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){?> disabled <?php } ?> ><i class="fa fa-file"></i>&nbsp;&nbsp;Import Inventory</button>
              <?php }else{ ?>
                <button id="add_invt_import_csv_button" title="Import Physical Inventory" class="btn btn-primary"><i class="fa fa-file"></i>&nbsp;&nbsp;Import Inventory</button>
              <?php } ?>
              <a style="pointer-events:all;" href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-physical_inventory-detail" class="form-horizontal">
        <?php if(isset($ipiid)){?>
        <input type="hidden" name="ipiid" value="<?php echo $ipiid;?>">
        <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_number; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vrefnumber" maxlength="30" value="<?php echo isset($vrefnumber) ? $vrefnumber : ''; ?>" placeholder="<?php echo $text_number; ?>" class="form-control" required id="vrefnumber" readonly/>

                  <?php if ($error_vrefnumber) { ?>
                    <div class="text-danger"><?php echo $error_vrefnumber; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template">Location</label>
                <div class="col-sm-8">
                  <select name="ilocid" required id="ilocid" class="form-control">
                    <option value="">please select location</option>
                    <?php if(isset($locations) && count($locations) > 0){?>
                      <?php foreach($locations as $location){ ?>
                      <?php if(isset($ilocid) && !empty($ilocid) && $ilocid == $location['ilocid']){?>
                        <option value="<?php echo $location['ilocid']; ?>" selected="selected"><?php echo $location['vlocname']; ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $location['ilocid']; ?>"><?php echo $location['vlocname']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_title; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vordertitle" maxlength="50" value="<?php echo isset($vordertitle) ? $vordertitle : ''; ?>" placeholder="<?php echo $text_title; ?>" class="form-control" id="vordertitle" required/>

                  <?php if ($error_vordertitle) { ?>
                    <div class="text-danger"><?php echo $error_vordertitle; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_created; ?></label>
                <?php
                if(isset($dcreatedate) && !empty($dcreatedate) && $dcreatedate != '0000-00-00 00:00:00'){
                  $dcreatedate =  DateTime::createFromFormat('Y-m-d H:i:s', $dcreatedate)->format('m-d-Y');
                }else{
                  $dcreatedate = '';
                }
                
                ?>
                <div class="col-sm-8">
                  <?php if(isset($ipiid) && $ipiid != ''){?>
                    <input type="text" name="dcreatedate" value="<?php echo $dcreatedate;?>" placeholder="<?php echo $text_created; ?>" class="form-control" id="dcreatedate" readonly style="pointer-events: none;" />
                  <?php } else { ?>
                    <input type="text" name="dcreatedate" value="<?php echo date('m-d-Y');?>" placeholder="<?php echo $text_created; ?>" class="form-control" id="dcreatedate" required/>
                  <?php } ?>

                  <?php if ($error_dcreatedate) { ?>
                    <div class="text-danger"><?php echo $error_dcreatedate; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_status; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="estatus" maxlength="10" value="<?php echo isset($estatus) ? $estatus : 'Open'; ?>" placeholder="<?php echo $text_status; ?>" class="form-control" readonly/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_calculated; ?></label>
                <?php
                if(isset($dcalculatedate) && !empty($dcalculatedate) && $dcalculatedate != '0000-00-00 00:00:00'){
                  $dcalculatedate =  DateTime::createFromFormat('Y-m-d H:i:s', $dcalculatedate)->format('m-d-Y');
                }else{
                  $dcalculatedate = '';
                }
                
                ?>
                <div class="col-sm-8">
                  <input type="text" name="dcalculatedate" value="<?php echo date('m-d-Y');?>" placeholder="<?php echo $text_calculated; ?>" class="form-control" id="dcalculatedate" readonly style="pointer-events: none;"/>

                  <?php if ($error_dcalculatedate) { ?>
                    <div class="text-danger"><?php echo $error_dcalculatedate; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_notes; ?></label>
                <div class="col-sm-8">
                  <textarea name="vnotes" maxlength="1000" placeholder="<?php echo $text_notes; ?>" class="form-control" ><?php echo isset($vnotes) ? $vnotes : ''; ?></textarea>
                </div>
              </div>
            </div>
          </div>
          <br><br><br>
          <div class="row">
            <div class="col-md-4" style="pointer-events: all;">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'checkbox_itemsort1\']').prop('checked', this.checked);"/></td>
                      <td style="width:185px;"><input type="text" class="form-control" id="itemsort1_search_sku" placeholder="SKU#" style="border:none;"></td>
                      <td style="width:242px;"><input type="text" class="form-control" id="itemsort1_search_item_name" placeholder="Item Name" style="border:none;"></td>
                    </tr>
                  </thead>
                </table>
                <div class="div-table-content">
                  <table class="table table-bordered table-hover" id="itemsort1" style="table-layout: fixed;">
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-1 text-center" style="margin-top:12%;">
              <a class="btn btn-primary" style="cursor:pointer" id="add_item_btn"><i class="fa fa-arrow-right fa-3x"></i></a><br><br>
              <a class="btn btn-primary" style="cursor:pointer" id="remove_item_btn"><i class="fa fa-arrow-left fa-3x"></i></a>
              
            </div>
            <div class="col-md-7" style="pointer-events: all;">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width:1%" class="text-center"><input type="checkbox" onclick="$('input[name*=\'checkbox_itemsort2\']').prop('checked', this.checked);"/></td>
                      <td style="width:16%;"><input type="text" class="form-control itemsort2_search" placeholder="SKU#" style="border:none;"></td>
                      <td style="width:20%;"><input type="text" class="form-control itemsort2_search" placeholder="Item Name" style="border:none;"></td>
                      <td class="text-right" style="width:10%;">Unit Cost</td>
                      <td class="text-right" style="width:10%;">Invt. Count</td>
                      <td class="text-right" style="width:10%;">Pack Size</td>
                      <td class="text-right" style="width:10%;">Total Unit</td>
                      <td class="text-right" style="width:10%;">Total Invt. Cost</td>
                    </tr>
                  </thead>
                </table>
                <div class="div-table-content" style="">
                  <table class="table table-bordered table-hover" id="itemsort2" style="table-layout: fixed;">
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
 
        </form>
      </div>
    </div>
  </div>
  
</div>

<script type="text/javascript">

//Item Filter
  $(document).on('keyup', '#itemsort1_search_sku', function(event) {
    event.preventDefault();
    
    // $('#itemsort1 tbody tr').hide();
    // var txt = $(this).val();

    // if(txt != ''){
    //   $('#itemsort1 tbody tr').each(function(){
    //     if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
    //       $(this).show();
    //     }
    //   });
    // }else{
    //   $('#itemsort1 tbody tr').show();
    // }

    $('#itemsort1_search_item_name').val('');

    var display_items_search_url = '<?php echo $display_items_search; ?>';
    display_items_search_url = display_items_search_url.replace(/&amp;/g, '&');

    var search_val = $(this).val();

    var data = {search_val:search_val,search_by:'vbarcode',right_items:window.checked_items2};

    if(search_val != ''){

      $.ajax({
        url : display_items_search_url,
        data : JSON.stringify(data),
        type : 'POST',
        success: function(response) {
          
          if(response.items){
            var left_items_html = [];

            for(var i=0;i<response.items.length;i++){

              left_items_html[i] ='<tr><td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+response.items[i]['iitemid']+'"/></td><td style="width:105px;">'+response.items[i]['vbarcode']+'</td><td style="width:242px;">'+response.items[i]['vitemname']+'</td></tr>';
            }

            $('#itemsort1 tbody').html('');
            $('#itemsort1 tbody').html(left_items_html.join(''));
          }
          
        },
        error: function(xhr) { // if error occured
        }
      });

    }else{
      $('#itemsort1 tbody').html('');
    }

  });


  $(document).on('keyup', '#itemsort1_search_item_name', function(event) {
    event.preventDefault();
    
    // $('#itemsort1 tbody tr').hide();
    // var txt = $(this).val();

    // if(txt != ''){
    //   $('#itemsort1 tbody tr').each(function(){
    //     if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
    //       $(this).show();
    //     }
    //   });
    // }else{
    //   $('#itemsort1 tbody tr').show();
    // }

    $('#itemsort1_search_sku').val('');

    var display_items_search_url = '<?php echo $display_items_search; ?>';
    display_items_search_url = display_items_search_url.replace(/&amp;/g, '&');

    var search_val = $(this).val();

    var data = {search_val:search_val,search_by:'vitemname',right_items:window.checked_items2};

    if(search_val != ''){

      $.ajax({
        url : display_items_search_url,
        data : JSON.stringify(data),
        type : 'POST',
        success: function(response) {
          
          if(response.items){
            var left_items_html = [];

            for(var i=0;i<response.items.length;i++){

              left_items_html[i] ='<tr><td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+response.items[i]['iitemid']+'"/></td><td style="width:105px;">'+response.items[i]['vbarcode']+'</td><td style="width:242px;">'+response.items[i]['vitemname']+'</td></tr>';
            }

            $('#itemsort1 tbody').html('');
            $('#itemsort1 tbody').html(left_items_html.join(''));
          }
          
        },
        error: function(xhr) { // if error occured
        }
      });

    }else{
      $('#itemsort1 tbody').html('');
    }

  });

  $(document).on('keyup', '.itemsort2_search', function(event) {
    event.preventDefault();
    
    $('#itemsort2 tbody tr').hide();
    var txt = $(this).val();

    if(txt != ''){
      $('#itemsort2 tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#itemsort2 tbody tr').show();
    }
  });
//Item Filter

//Items add and remove

$(document).on('click', '#add_item_btn', function(event) {
  event.preventDefault();

  window.checked_items2 = []; 

  var add_items_url = '<?php echo $add_items; ?>';
    
  add_items_url = add_items_url.replace(/&amp;/g, '&');

  if($("[name='checkbox_itemsort1[]']:checked").length == 0) {
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please select item to add", 
      callback: function(){}
    });
    return false;
  }

  $("div#divLoading").addClass('show');

  $("[name='checkbox_itemsort1[]']:checked").each(function (i) {
      
      if($.inArray($(this).val(), window.checked_items1) !== -1){
      }else{
        window.checked_items1.push($(this).val());
      }

      window.checked_items2.push($(this).val());

  });

  if(window.checked_items1.length > 0){
    $.ajax({
        url : add_items_url,
        data : {checkbox_itemsort1:window.checked_items1,checkbox_itemsort2:window.checked_items2},
        type : 'POST',
    }).done(function(response){

      // var  response = $.parseJSON(response); //decode the response array
      
      if(response.right_items_arr){
        var right_items_html = '';
        $.each(response.right_items_arr, function(i, v) {
          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+v.iitemid+'"></td>';
          right_items_html += '<td style="width:100px;">'+v.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+v.vbarcode+'"></td>';
          right_items_html += '<td style="width:20%;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">'+v.nunitcost+'<input type="hidden" class="nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="'+v.nunitcost+'" id="" style="width:60px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><input type="text" class="editable_all_selected ndebitqty_class" name="items['+window.index_item+'][ndebitqty]" value="0" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">1<input type="hidden" class="npackqty_class" name="items['+window.index_item+'][npackqty]" value="1" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><span class="text_itotalunit_class">0</span><input type="hidden" class="itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="0" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">';
          right_items_html += '<span class="text_nnettotal_class">0.00</span><input type="hidden" class="nnettotal_class" name="items['+window.index_item+'][ndebitextprice]" value="0.00" id="" >';
          right_items_html += '</td>';
          right_items_html += '</tr>';
          window.index_item++;
        });

        $('#itemsort2 tbody').append(right_items_html);
      }

      // if(response.left_items_arr){
      //   var left_items_html = '';
      //   $.each(response.left_items_arr, function(m, n) {
      //     left_items_html += '<tr>';
      //     left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
      //     left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
      //     left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
      //     left_items_html += '</tr>';
      //   });

      //   $('#itemsort1 tbody').html('');
      //   $('#itemsort1 tbody').append(left_items_html);
      // }

      $('#itemsort1 tbody').html('');

      $("div#divLoading").removeClass('show');
      
    });
  }
});

$(document).on('click', '#remove_item_btn', function(event) {
  event.preventDefault();
  
  var remove_items_url = '<?php echo $remove_items; ?>';
    
  remove_items_url = remove_items_url.replace(/&amp;/g, '&');

  if($("[name='checkbox_itemsort2[]']:checked").length == 0) {
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please select item to remove", 
      callback: function(){}
    });
    return false;
  }

  $("div#divLoading").addClass('show');

  $("[name='checkbox_itemsort2[]']:checked").each(function (i) {
      
      if($.inArray($(this).val(), window.checked_items1) !== -1){
        window.checked_items2.splice( $.inArray($(this).val(), window.checked_items2), 1 );
        $(this).closest('tr').remove();
      }

  });
  console.log(window.checked_items1);
  console.log(window.checked_items2);

    $.ajax({
        url : remove_items_url,
        data : {checkbox_itemsort1:window.checked_items1},
        type : 'POST',
    }).done(function(response){

      // var  response = $.parseJSON(response); //decode the response array

      // if(response.left_items_arr){
      //   var left_items_html = '';
      //   $.each(response.left_items_arr, function(m, n) {
      //     left_items_html += '<tr>';
      //     left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
      //     left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
      //     left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
      //     left_items_html += '</tr>';
      //   });

      //   $('#itemsort1 tbody').html('');
      //   $('#itemsort1 tbody').append(left_items_html);
      // }

      $('#itemsort1 tbody').html('');

      $("div#divLoading").removeClass('show');
      
    });

});

//form submit
$(document).on('click', '#save_button_physical_inventory_detail', function(event) {
  if($('form#form-physical_inventory-detail #vrefnumber').val() == ''){
    // alert('please enter Number');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter number", 
      callback: function(){}
    });
    $('form#form-physical_inventory-detail #vrefnumber').focus();
    return false;
  }else if($('form#form-physical_inventory-detail #vordertitle').val() == ''){
    // alert('please enter title');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter title", 
      callback: function(){}
    });
    $('form#form-physical_inventory-detail #vordertitle').focus();
    return false;
  }else if($('form#form-physical_inventory-detail #dcreatedate').val() == ''){
    // alert('please select Created Date');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please select created date", 
      callback: function(){}
    });
    $('form#form-physical_inventory-detail #dcreatedate').focus();
    return false;
  }else if($('form#form-physical_inventory-detail #dcalculatedate').val() == ''){
    // alert('please select Calculated Date');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please select calculated date", 
      callback: function(){}
    });
    $('form#form-physical_inventory-detail #dcalculatedate').focus();
    return false;
  }else{
    $("div#divLoading").addClass('show');
    $('form#form-physical_inventory-detail').submit();
  }
});
</script>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />

<script src="view/javascript/bootbox.min.js" defer></script>
<script src="view/javascript/bootstrap-datepicker.js" defer></script>

<script type="text/javascript">
  $(function(){

    $('#dcreatedate').each(function(){
        $(this).datepicker({
          format: 'mm-dd-yyyy',
          todayHighlight: true,
          autoclose: true,
        });
    });

    $('#dcalculatedate').each(function(){
        $(this).datepicker({
          format: 'mm-dd-yyyy',
          todayHighlight: true,
          autoclose: true,
        });
    });
  
  });
</script>

<script type="text/javascript">
  $(document).on('keyup', '.itotalunit_class', function(event) {
    event.preventDefault();
    
    if($(this).closest('tr').find('.nunitcost_class').val() != ''){
       var total_amt = $(this).closest('tr').find('.nunitcost_class').val() * $(this).val();
       $(this).closest('tr').find('.nnettotal_class').val(total_amt)
       $(this).closest('tr').find('.text_nnettotal_class').html(total_amt)
    }else{
      var total_amt = 0 * $(this).val();
      $(this).closest('tr').find('.nnettotal_class').val(total_amt)
      $(this).closest('tr').find('.text_nnettotal_class').html(total_amt)
    }
  });
</script>

<script type="text/javascript">
  $(document).on('keyup', '.nunitcost_class', function(event) {
    event.preventDefault();
    
    if($(this).closest('tr').find('.itotalunit_class').val() != ''){
       var total_amt = $(this).closest('tr').find('.itotalunit_class').val() * $(this).val();
       $(this).closest('tr').find('.nnettotal_class').val(total_amt)
       $(this).closest('tr').find('.text_nnettotal_class').html(total_amt)
    }else{
      var total_amt = 0 * $(this).val();
      $(this).closest('tr').find('.nnettotal_class').val(total_amt)
      $(this).closest('tr').find('.text_nnettotal_class').html(total_amt)
    }
  });
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', 'input[name="vrefnumber"], .npackqty_class, .itotalunit_class', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

  $(document).on('keypress keyup', '.nunitcost_class, .ndebitqty_class', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

    $(this).closest('tr').find('input[type="checkbox"]').prop('checked', true);
    
    var inv_count = $(this).val();
    var pack_size = $(this).closest('tr').find('.npackqty_class').val();
    var unit_cost = $(this).closest('tr').find('.nunitcost_class').val();

    if($(this).val() != ''){
      var total_unit = inv_count * pack_size;
      var total_invt_cost = total_unit * unit_cost;
      total_invt_cost = total_invt_cost.toFixed(2);
      $(this).closest('tr').find('.itotalunit_class').val(total_unit);
      $(this).closest('tr').find('.text_itotalunit_class').html(total_unit);
      $(this).closest('tr').find('.text_nnettotal_class').html(total_invt_cost);
      $(this).closest('tr').find('.nnettotal_class').val(total_invt_cost);
    }else{
      $(this).closest('tr').find('.itotalunit_class').val('0');
      $(this).closest('tr').find('.text_itotalunit_class').html('0');
      $(this).closest('tr').find('.text_nnettotal_class').html('0.00');
      $(this).closest('tr').find('.nnettotal_class').val('0.00');
    }
    
    
  });

  $(document).on('focusout', '.nunitcost_class, .ndebitqty_class', function(event) {
    event.preventDefault();

    if($(this).val() != ''){
      if($(this).val().indexOf('.') == -1){
        var new_val = $(this).val();
        $(this).val(new_val+'.00');
      }else{
        var new_val = $(this).val();
        if(new_val.split('.')[1].length == 0){
          $(this).val(new_val+'00');
        }
      }
    }
  }); 
</script>

<script type="text/javascript">
  $(document).ready(function(){

    var display_items_url = '<?php echo $display_items; ?>';
    display_items_url = display_items_url.replace(/&amp;/g, '&');

    window.checked_items2 = [];

    $("div#divLoading").addClass('show');

    <?php if(isset($ipiid)){?>

      var ipiid = '<?php echo $ipiid; ?>';

      display_items_url = display_items_url+'&ipiid='+ipiid;
      
    <?php } ?>
    
    $.getJSON(display_items_url, function(result){
      if((result.previous_items) && (result.previous_items.length) > 0){
        window.checked_items1 = result.previous_items;
        window.index_item = parseInt(result.previous_items.length);
      }else{
        window.checked_items1 = []; 
        window.index_item = 0; 
      }

      // if(result.items){
      //   var left_items_html = '';
      //   $.each(result.items, function(m, n) {
      //     left_items_html += '<tr>';
      //     left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
      //     left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
      //     left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
      //     left_items_html += '</tr>';
      //   });

      //   $('#itemsort1 tbody').html('');
      //   $('#itemsort1 tbody').append(left_items_html);
      // }

      if(result.edit_right_items){
        var right_items_html = '';
        $.each(result.edit_right_items, function(i, v) {

          window.checked_items2.push(v.iitemid);

          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+v.iitemid+'"></td>';
          right_items_html += '<td style="width:100px;">'+v.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+v.vbarcode+'"></td>';
          right_items_html += '<td style="width:20%;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">'+v.nunitcost+'<input type="hidden" class="nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="'+v.nunitcost+'" id="" style="width:60px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><input type="text" class="editable_all_selected ndebitqty_class" name="items['+window.index_item+'][ndebitqty]" value="'+v.ndebitqty+'" id="" style="width:40px;text-align:right;" ></td>';
          right_items_html += '<td class="text-right" style="width:10%;">1<input type="hidden" class="npackqty_class" name="items['+window.index_item+'][npackqty]" value="1" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><span class="text_itotalunit_class">'+ v.itotalunit +'</span><input type="hidden" class="itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="'+v.itotalunit+'" id="" style="width:40px;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">';
          right_items_html += '<span class="text_nnettotal_class">'+ v.ndebitextprice +'</span><input type="hidden" class="nnettotal_class" name="items['+window.index_item+'][ndebitextprice]" value="'+ v.ndebitextprice +'" id="" >';
          right_items_html += '</td>';
          right_items_html += '</tr>';
          window.index_item++;
        });
        
        $('#itemsort2 tbody').html('');
        $('#itemsort2 tbody').append(right_items_html);
      }

      $("div#divLoading").removeClass('show');
        
    });

  });
</script>


<script type="text/javascript">
  $(document).on('click', '#calculate_post_button', function(event) {
    event.preventDefault();

    if($('form#form-physical_inventory-detail #vrefnumber').val() == ''){
      // alert('please enter Number');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter number", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #vrefnumber').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #vordertitle').val() == ''){
      // alert('please enter title');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter title", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #vordertitle').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #dcreatedate').val() == ''){
      // alert('please select Created Date');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please select created date", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #dcreatedate').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #dcalculatedate').val() == ''){
      // alert('please select Calculated Date');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please select calculated date", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #dcalculatedate').focus();
      return false;
    }

    if($('#itemsort2 > tbody > tr').length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please add items!", 
        callback: function(){}
      });
    
      return false;
    }

    var calculate_post_check_data_url = '<?php echo $calculate_post_check_data; ?>';
    calculate_post_check_data_url = calculate_post_check_data_url.replace(/&amp;/g, '&');
    $("div#divLoading").addClass('show');

    $.ajax({
      url : calculate_post_check_data_url,
      data : $('form#form-physical_inventory-detail').serialize(),
      type : 'POST',
      success: function(data) {
        var  data = $.parseJSON(data); //decode the response array

        if(data){
          var cal_post_html = '';
          $.each(data, function(i, v) {
            cal_post_html += '<tr>';
            cal_post_html += '<td class="text-right">';
            cal_post_html += parseInt(v.ndebitqty);
            cal_post_html += '</td>';
            cal_post_html += '<td class="text-right">';
            cal_post_html += parseInt(v.sale_qty);
            cal_post_html += '</td>';
            cal_post_html += '<td class="text-right">';
            cal_post_html += parseInt(v.ndebitqty) - parseInt(v.sale_qty);
            cal_post_html += '</td>';
            cal_post_html += '</tr>';
          });

          $('#cal_post_table').empty();
          $('#cal_post_table').append(cal_post_html);
        }

        $("div#divLoading").removeClass('show');
        $('#cal_post_popup').modal('show');
        
      },
      error: function(xhr) { // if error occured
        
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        check_invoice_number = false;
        $("div#divLoading").removeClass('show');
        return false;
      }
    });

  });

  $(document).on('click', '#okay_btn_cal_post', function(event) {
    event.preventDefault();

    $('#cal_post_popup').modal('hide');

    if($('form#form-physical_inventory-detail #vrefnumber').val() == ''){
      // alert('please enter Number');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter number", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #vrefnumber').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #vordertitle').val() == ''){
      // alert('please enter title');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter title", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #vordertitle').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #dcreatedate').val() == ''){
      // alert('please select Created Date');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please select created date", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #dcreatedate').focus();
      return false;
    }
    if($('form#form-physical_inventory-detail #dcalculatedate').val() == ''){
      // alert('please select Calculated Date');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please select calculated date", 
        callback: function(){}
      });
      $('form#form-physical_inventory-detail #dcalculatedate').focus();
      return false;
    }
   
    var calculate_post_url = '<?php echo $calculate_post; ?>';
    calculate_post_url = calculate_post_url.replace(/&amp;/g, '&');
    $("div#divLoading").addClass('show');

    $.ajax({
      url : calculate_post_url,
      data : $('form#form-physical_inventory-detail').serialize(),
      type : 'POST',
      success: function(data) {

        $("div#divLoading").removeClass('show');
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#successModal').modal('show');

        var physical_inventory_list_url = '<?php echo $physical_inventory_list; ?>';
        physical_inventory_list_url = physical_inventory_list_url.replace(/&amp;/g, '&');
        
        <?php if(!isset($ipiid)){?>
          setTimeout(function(){
           window.location.href = physical_inventory_list_url;
           $("div#divLoading").addClass('show');
          }, 3000);
        <?php }else{ ?>
          setTimeout(function(){
           window.location.reload();
           $("div#divLoading").addClass('show');
          }, 3000);
        <?php } ?>
      },
      error: function(xhr) { // if error occured
        
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        check_invoice_number = false;
        $("div#divLoading").removeClass('show');
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
            <p id="success_alias"></p>
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
            <p id="error_alias"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
<?php echo $footer; ?>

<!-- Modal -->
<div id="myModalImport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Import Physical Inventory</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $import_physical_inventory;?>" method="post" enctype="multipart/form-data" id="import_physical_inventory">
          <?php if(isset($ipiid)){?>
            <input type="hidden" name="ipiid" value="<?php echo $ipiid;?>">
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:8%;">File: </span> <span style="display:inline-block;width:85%;"><input type="file" name="import_physical_inventory_file" class="form-control" required></span>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="import_invt" value="Import Physical Inventory">&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="myModalAddImport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Import Physical Inventory</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $add_new_import_physical_inventory;?>" method="post" enctype="multipart/form-data" id="add_import_physical_inventory">
          
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <span style="display:inline-block;width:8%;">File: </span> <span style="display:inline-block;width:85%;"><input type="file" name="add_import_physical_inventory_file" class="form-control" required></span>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="import_invt" value="Import Physical Inventory">&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<div class="modal fade" id="successModalImportInventory" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p id="success_msg"><strong>Successfully Imported Physical Inventory!</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click', '#import_csv_button', function(event) {
    event.preventDefault();
    $('#myModalImport').modal('show');
  });

  $(document).on('click', '#add_invt_import_csv_button', function(event) {
    event.preventDefault();
    $('#myModalAddImport').modal('show');
  });
</script>

<script type="text/javascript">
  $(document).on('submit', 'form#import_physical_inventory', function(event) {
    event.preventDefault();

    $("div#divLoading").addClass('show');
    $('#myModalImport').modal('hide');

    var import_form_id = $('form#import_physical_inventory');
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
            var res_msg = response.success;
            $("div#divLoading").removeClass('show');
            $('#success_msg').html('<strong>'+ res_msg +'/<strong>');
            $('#successModalImportInventory').modal('show');
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

  $(document).on('submit', 'form#add_import_physical_inventory', function(event) {
    event.preventDefault();

    $("div#divLoading").addClass('show');
    $('#myModalAddImport').modal('hide');

    var import_form_id = $('form#add_import_physical_inventory');
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
          var res_msg = response.success;

            if(response.items){
              var right_items_html = '';
              $.each(response.items, function(i, v) {

                if($.inArray(v.vitemid, window.checked_items2) == -1){

                  if($.inArray(v.vitemid, window.checked_items1) !== -1){
                  }else{
                    window.checked_items1.push(v.vitemid);
                  }

                  window.checked_items2.push(v.vitemid);

                  right_items_html += '<tr>';
                  right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.vitemid+'"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+v.vitemid+'"></td>';
                  right_items_html += '<td style="width:100px;">'+v.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+v.vbarcode+'"></td>';
                  right_items_html += '<td style="width:20%;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
                  right_items_html += '<td class="text-right" style="width:10%;">'+v.nunitcost+'<input type="hidden" class="nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="'+v.nunitcost+'" id="" style="width:60px;text-align:right;"></td>';
                  right_items_html += '<td class="text-right" style="width:10%;"><input type="text" class="editable_all_selected ndebitqty_class" name="items['+window.index_item+'][ndebitqty]" value="'+v.ndebitqty+'" id="" style="width:40px;text-align:right;"></td>';
                  right_items_html += '<td class="text-right" style="width:10%;">1<input type="hidden" class="npackqty_class" name="items['+window.index_item+'][npackqty]" value="1" id="" style="width:40px;text-align:right;"></td>';
                  right_items_html += '<td class="text-right" style="width:10%;"><span class="text_itotalunit_class">'+v.itotalunit+'</span><input type="hidden" class="itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="'+v.itotalunit+'" id="" style="width:40px;text-align:right;"></td>';
                  right_items_html += '<td class="text-right" style="width:10%;">';
                  right_items_html += '<span class="text_nnettotal_class">'+v.ndebitextprice+'</span><input type="hidden" class="nnettotal_class" name="items['+window.index_item+'][ndebitextprice]" value="'+v.ndebitextprice+'" id="" >';
                  right_items_html += '</td>';
                  right_items_html += '</tr>';
                  window.index_item++;
                }
              });

              $('#itemsort2 tbody').append(right_items_html);

              // var remove_items_url = '<?php echo $remove_items; ?>';
    
              // remove_items_url = remove_items_url.replace(/&amp;/g, '&');
              
              // $.ajax({
              //   url : remove_items_url,
              //   data : {checkbox_itemsort1:window.checked_items1},
              //   type : 'POST',
              // }).done(function(response){

              //   if(response.left_items_arr){
              //     var left_items_html = '';
              //     $.each(response.left_items_arr, function(m, n) {
              //       left_items_html += '<tr>';
              //       left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
              //       left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
              //       left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
              //       left_items_html += '</tr>';
              //     });

              //     $('#itemsort1 tbody').html('');
              //     $('#itemsort1 tbody').append(left_items_html);
              //   }
                
              // });

              $('#itemsort1 tbody').html('');

            }

            $("div#divLoading").removeClass('show');
            $('#success_msg').html('<strong>'+res_msg+'</strong>');
            $('#successModalImportInventory').modal('show');

            setTimeout(function(){
              $('#successModalImportInventory').modal('hide');
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

<div id="cal_post_popup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Calculate Post</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="text-right">Original</th>
                  <th class="text-right">After Inventory Sales</th>
                  <th class="text-right">Physical Count</th>
                </thead>
                <tbody id="cal_post_table">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="okay_btn_cal_post">OK</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>