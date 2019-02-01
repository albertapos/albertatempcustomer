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
      <div class="panel-body" <?php if(isset($estatus) && $estatus == 'Close'){?> style="pointer-events:none;" <?php } ?>>

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_waste_detail" title="<?php echo $button_save; ?>" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){?> disabled <?php } ?> ><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <button id="calculate_post_button" title="Calculate/Post" class="btn btn-primary" <?php if(isset($estatus) && $estatus == 'Close'){?> disabled <?php } ?> ><i class="fa fa-calculator"></i>&nbsp;&nbsp;Calculate/Post</button>
              <a style="pointer-events:all;" href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-waste-detail" class="form-horizontal">
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
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_status; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="estatus" maxlength="10" value="<?php echo isset($estatus) ? $estatus : 'Open'; ?>" placeholder="<?php echo $text_status; ?>" class="form-control" readonly />
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
                      <td style="width:185px;"><input type="text" class="form-control itemsort1_search" placeholder="SKU#" style="border:none;"></td>
                      <td style="width:242px;"><input type="text" class="form-control itemsort1_search" placeholder="Item Name" style="border:none;"></td>
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
                      <td class="text-right" style="width:10%;">Pack Qty</td>
                      <td class="text-right" style="width:10%;">Waste Qty</td>
                      <td class="text-right" style="width:10%;">Total Unit</td>
                      <td class="text-right" style="width:10%;">Total Amt</td>
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

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">

//Item Filter
  $(document).on('keyup', '.itemsort1_search', function(event) {
    event.preventDefault();
    
    $('#itemsort1 tbody tr').hide();
    var txt = $(this).val();

    if(txt != ''){
      $('#itemsort1 tbody tr').each(function(){
        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
          $(this).show();
        }
      });
    }else{
      $('#itemsort1 tbody tr').show();
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
          right_items_html += '<td class="text-right" style="width:10%;">'+v.nunitcost+'<input type="hidden" class="editable nunitcost_class" name="items['+window.index_item+'][nunitcost]" id="" style="width:40px;text-align:right;" value="'+v.nunitcost+'"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">'+v.npack+'<input type="hidden" class="editable npackqty_class" name="items['+window.index_item+'][npackqty]" value="'+v.npack+'" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><input type="text" class="editable_all_selected ndebitqty_class" name="items['+window.index_item+'][ndebitqty]" id="" value="0.00" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><span class="text_itotalunit_class">0</span><input type="hidden" class="editable itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="0" id="" style="width:40px;text-align:right;"></td>';
          
          right_items_html += '<td class="text-right" style="width:10%;">';
          right_items_html += '<span class="text_nnettotal_class">0.00</span><input type="hidden" class="nnettotal_class" name="items['+window.index_item+'][nnettotal]" id="" value="0.00">';
          right_items_html += '</td>';
          right_items_html += '</tr>';
          window.index_item++;
        });

        $('#itemsort2 tbody').append(right_items_html);
      }

      if(response.left_items_arr){
        var left_items_html = '';
        $.each(response.left_items_arr, function(m, n) {
          left_items_html += '<tr>';
          left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
          left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
          left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

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
        window.checked_items1.splice( $.inArray($(this).val(), window.checked_items1), 1 );
        $(this).closest('tr').remove();
      }

  });

    $.ajax({
        url : remove_items_url,
        data : {checkbox_itemsort1:window.checked_items1},
        type : 'POST',
    }).done(function(response){

      // var  response = $.parseJSON(response); //decode the response array

      if(response.left_items_arr){
        var left_items_html = '';
        $.each(response.left_items_arr, function(m, n) {
          left_items_html += '<tr>';
          left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
          left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
          left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

      $("div#divLoading").removeClass('show');
      
    });

});

//form submit
$(document).on('click', '#save_button_waste_detail', function(event) {
  if($('form#form-waste-detail #vrefnumber').val() == ''){
    // alert('please enter Number');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter number", 
      callback: function(){}
    });
    $('form#form-waste-detail #vrefnumber').focus();
    return false;
  }else if($('form#form-waste-detail #dcreatedate').val() == ''){
    // alert('please select Date');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please select date", 
      callback: function(){}
    });
    $('form#form-waste-detail #dcreatedate').focus();
    return false;
  }else if($('form#form-waste-detail #vordertitle').val() == ''){
    // alert('please enter title');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter title", 
      callback: function(){}
    });
    $('form#form-waste-detail #vordertitle').focus();
    return false;
  }else{
    $("div#divLoading").addClass('show');
    $('form#form-waste-detail').submit();
  }
});
</script>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
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
    
    var waste_qty = $(this).val();
    var pack_size = $(this).closest('tr').find('.npackqty_class').val();
    var unit_cost = $(this).closest('tr').find('.nunitcost_class').val();

    if($(this).val() != ''){
      var total_unit = waste_qty * pack_size;
      var total_amt = total_unit * unit_cost;
      total_amt = total_amt.toFixed(2);
      $(this).closest('tr').find('.itotalunit_class').val(total_unit);
      $(this).closest('tr').find('.text_itotalunit_class').html(total_unit);
      $(this).closest('tr').find('.text_nnettotal_class').html(total_amt);
      $(this).closest('tr').find('.nnettotal_class').val(total_amt);
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

      if(result.items){
        var left_items_html = '';
        $.each(result.items, function(m, n) {
          left_items_html += '<tr>';
          left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
          left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
          left_items_html += '<td style="width:242px;">'+n.vitemname+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

      if(result.edit_right_items){
        var right_items_html = '';
        $.each(result.edit_right_items, function(i, v) {
          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/><input type="hidden" name="items['+window.index_item+'][vitemid]" value="'+v.iitemid+'"></td>';
          right_items_html += '<td style="width:100px;">'+v.vbarcode+'<input type="hidden" name="items['+window.index_item+'][vbarcode]" value="'+v.vbarcode+'"></td>';
          right_items_html += '<td style="width:20%;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">'+v.nunitcost+'<input type="hidden" class="editable nunitcost_class" name="items['+window.index_item+'][nunitcost]" value="'+v.nunitcost+'" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;">'+v.npackqty+'<input type="hidden" class="editable npackqty_class" name="items['+window.index_item+'][npackqty]" value="'+v.npackqty+'" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><input type="text" class="editable_all_selected ndebitqty_class" name="items['+window.index_item+'][ndebitqty]" value="'+v.ndebitqty+'" id="" style="width:40px;text-align:right;"></td>';
          right_items_html += '<td class="text-right" style="width:10%;"><span class="text_itotalunit_class">'+ v.itotalunit +'</span><input type="hidden" class="editable itotalunit_class" name="items['+window.index_item+'][itotalunit]" value="'+v.itotalunit+'" id="" style="width:40px;text-align:right;"></td>';
          
          right_items_html += '<td class="text-right" style="width:10%;">';
          right_items_html += '<span class="text_nnettotal_class">'+ (v.nunitcost * v.itotalunit).toFixed(2) +'</span><input type="hidden" class="nnettotal_class" name="items['+window.index_item+'][nnettotal]" value="'+ (v.nunitcost * v.itotalunit).toFixed(2) +'" id="" >';
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

    if($('form#form-waste-detail #vrefnumber').val() == ''){
      // alert('please enter Number');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter number", 
        callback: function(){}
      });
      $('form#form-waste-detail #vrefnumber').focus();
      return false;
    }
    if($('form#form-waste-detail #dcreatedate').val() == ''){
      // alert('please select Date');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please select date", 
        callback: function(){}
      });
      $('form#form-waste-detail #dcreatedate').focus();
      return false;
    }
    if($('form#form-waste-detail #vordertitle').val() == ''){
      // alert('please enter title');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "please enter title", 
        callback: function(){}
      });
      $('form#form-waste-detail #vordertitle').focus();
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
   
    var calculate_post_url = '<?php echo $calculate_post; ?>';
    calculate_post_url = calculate_post_url.replace(/&amp;/g, '&');
    $("div#divLoading").addClass('show');

    $.ajax({
      url : calculate_post_url,
      data : $('form#form-waste-detail').serialize(),
      type : 'POST',
      success: function(data) {

        $("div#divLoading").removeClass('show');
        $('#success_alias').html('<strong>'+ data.success +'</strong>');
        $('#successModal').modal('show');

        var waste_list_url = '<?php echo $waste_list; ?>';
        waste_list_url = waste_list_url.replace(/&amp;/g, '&');
        
        <?php if(!isset($ipiid)){?>
          setTimeout(function(){
           window.location.href = waste_list_url;
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