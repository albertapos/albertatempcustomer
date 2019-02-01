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
      <div class="panel-body">

        <div class="row" style="padding-bottom: 9px; float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_sale" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sale" class="form-horizontal">
        <?php if(isset($isalepriceid)){?>
        <input type="hidden" name="isalepriceid" value="<?php echo $isalepriceid;?>">
        <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-sale"><?php echo $text_sale_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="vsalename" value="<?php echo isset($vsalename) ? $vsalename: ''; ?>" required>

                  <?php if ($error_vsalename) { ?>
                    <div class="text-danger"><?php echo $error_vsalename; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-sale"><?php echo $text_sale_type; ?></label>
                <div class="col-sm-8">
                  <select name="vsaletype" id="vsaletype" class="form-control" required>
                    <option value="">--- Sale Type --</option>
                    <?php foreach($sale_types as $sale_type){ ?>
                      <?php if(isset($vsaletype) && $vsaletype == $sale_type){ ?>
                        <option value="<?php echo $sale_type; ?>" selected="selected"><?php echo $sale_type; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $sale_type; ?>" ><?php echo $sale_type; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-sale">Sale By</label>
                <div class="col-sm-8" style="margin-top:8px;">
                  <input type="radio" name="vsaleby" value="Discount" <?php if(isset($vsaleby) && (($vsaleby == 'Discount' && $vsaleby != 'Price') || ($vsaleby == ''))){?> checked <?php } ?>/>&nbsp;&nbsp;Discount(%)&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="vsaleby" value="Price" <?php if(isset($vsaleby) && ($vsaleby != 'Discount' && $vsaleby == 'Price')){?> checked <?php } ?> />&nbsp;&nbsp;Sale Price
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-sale"><p id="p_discount">Enter Discount(%)</p><p id="p_price">Enter Sale Price($)</p></label>
                <div class="col-sm-8">
                  <input type="text" name="ndiscountper" value="<?php echo isset($ndiscountper) ? $ndiscountper : '0.00'; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6" style="padding-top:10px;" id="div_date">
              <div class="form-group">
                <?php
                  if(isset($dstartdatetime) && !empty($dstartdatetime)){
                    $starttime_string = strtotime($dstartdatetime);
                    $start_hour = date('H', $starttime_string);
                    $start_date = date('m-d-Y', $starttime_string);
                  }else{
                    $start_hour = '';
                    $start_date = '';
                  }

                  if(isset($denddatetime) && !empty($denddatetime)){
                      $endtime_string = strtotime($denddatetime);
                      $end_hour = date('H', $endtime_string);
                      $end_date = date('m-d-Y', $endtime_string);
                    }else{
                      $end_hour = '';
                      $end_date = '';
                    }
                ?>

                <p style="text-align:right;margin-right:3%;"><b>Start Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="dstartdatetime_date" id="start_date" value="<?php echo isset($start_date) ? $start_date: '';?>" class="form-control" style="width:32%;display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;<b>Time</b>&nbsp;&nbsp;
                  <select class="form-control" name="dstartdatetime_hour" style="width:20%;display:inline-block;">
                    <?php if(isset($hours) && count($hours) > 0) {?>
                      <?php foreach($hours as $k => $hour) { ?>
                        <?php if($start_hour == $k){?>
                          <option value="<?php echo $k;?>" selected="selected"><?php echo $hour;?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </p>

                <p style="text-align:right;margin-right:3%;"><b>End Date</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="end_date" name="denddatetime_date" value="<?php echo isset($end_date) ? $end_date: '';?>" class="form-control" style="width:32%;display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;<b>Time</b>&nbsp;&nbsp;
                  <select class="form-control" name="denddatetime_hour" style="width:20%;display:inline-block;">
                    <?php if(isset($hours) && count($hours) > 0) {?>
                      <?php foreach($hours as $k => $hour) { ?>
                        <?php if($end_hour == $k){?>
                          <option value="<?php echo $k;?>" selected="selected"><?php echo $hour;?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $k;?>"><?php echo $hour;?></option>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group" style="padding-top:10px;margin-left:1px;" id="div_buy_qty">
                <label class="col-sm-4 control-label" for="input-sale"><?php echo $text_buy_qty; ?></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nbuyqty" value="<?php echo isset($nbuyqty) ? $nbuyqty: '0.00'; ?>">
                </div>
              </div>
              <div class="form-group" style="border-top:none;padding-top:10px;">
                <label class="col-sm-4 control-label" for="input-sale"><?php echo $text_status; ?></label>
                <div class="col-sm-8">
                  <select class="form-control" name="estatus">
                    <?php if(isset($status_array) && count($status_array) > 0) {?>
                      <?php foreach($status_array as $k => $status_arr) { ?>
                        <?php if($status_arr == $estatus){?>
                          <option value="<?php echo $status_arr;?>" selected="selected"><?php echo $status_arr;?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $status_arr;?>"><?php echo $status_arr;?></option>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <br><br>
          <div class="row">
            <div class="col-md-5">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox"/></td>
                      <td style="width:130px;"><input type="text" class="form-control itemsort1_search" placeholder="Item Code" style="border:none;"></td>
                      <td style="width:242px;"><input type="text" class="form-control itemsort1_search" placeholder="Item Name" style="border:none;"></td>
                      <td class="text-right" style="width:85px;">Price</td>
                    </tr>
                  </thead>
                </table>
                <div class="div-table-content">
                  <table class="table table-bordered table-hover" id="itemsort1" style="table-layout: fixed">
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-2 text-center" style="margin-top:12%;">
              <a class="btn btn-primary" style="cursor:pointer" id="add_item_btn"><i class="fa fa-arrow-right fa-3x"></i></a><br><br>
              <a class="btn btn-primary" style="cursor:pointer" id="remove_item_btn"><i class="fa fa-arrow-left fa-3x"></i></a>
              
            </div>
            <div class="col-md-5">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width:1px" class="text-center"><input type="checkbox"/></td>
                      <td style="width:130px;"><input type="text" class="form-control itemsort2_search" placeholder="Item Code" style="border:none;"></td>
                      <td style="width:242px;"><input type="text" class="form-control itemsort2_search" placeholder="Item Name" style="border:none;"></td>
                      <td class="text-right" >Price</td>
                      <td class="text-right" id="td_discount" style="width:5px">Discount(%)</td>
                      <td class="text-right" id="td_sale" style="width:5px">Sale($)</td>
                    </tr>
                  </thead>
                </table>
                <div class="div-table-content" style="">
                  <table class="table table-bordered table-hover" id="itemsort2">
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

<style type="text/css">

  div.content {
   width : 1000px;
   height : 1000px;
  }

</style>

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

  var input_ndiscountper = $('input[name="ndiscountper"]').val();
  var input_vsaleby = $('input[name="vsaleby"]:checked').val();

  if(input_ndiscountper == ''){
    if(input_vsaleby == 'Discount'){
      // alert('Please Enter Discount(%)');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Enter Discount(%)", 
        callback: function(){}
      });
    }else{
      // alert('Please Enter Sale Price($)');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Enter Sale Price($)", 
        callback: function(){}
      });
    }
    return false;
  }

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

          var display_nsaleprice = '0.00';
          if(input_vsaleby == 'Price'){
            display_nsaleprice = v.dunitprice - input_ndiscountper;
          }else{
            display_nsaleprice = v.dunitprice - ((v.dunitprice * input_ndiscountper)/100);
          }
          display_nsaleprice = display_nsaleprice.toFixed(2);

          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:1px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td>'+v.vitemcode+'<input type="hidden" name="items['+window.index_item+'][vitemcode]" value="'+v.vitemcode+'"><input type="hidden" name="items['+window.index_item+'][vunitcode]" value="'+v.vunitcode+'"><input type="hidden" name="items['+window.index_item+'][vitemtype]" value="'+v.vitemtype+'"><input type="hidden" name="items['+window.index_item+'][iitemid]" value="'+v.iitemid+'"><input type="hidden" name="items['+window.index_item+'][Id]" value="0"></td>';
          right_items_html += '<td>'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right">'+v.dunitprice+'<input type="hidden" name="items['+window.index_item+'][dunitprice]" class="i_dunitprice" value="'+v.dunitprice+'"></td>';
          right_items_html += '<td class="text-right"><span class="s_nsaleprice">'+display_nsaleprice+'</span><input type="hidden" name="items['+window.index_item+'][nsaleprice]" class="i_nsaleprice" value="'+ display_nsaleprice +'"></td>';
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
          left_items_html += '<td style="width:105px;">'+n.vitemcode+'</td>';
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right">'+n.dunitprice+'</td>';
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
          left_items_html += '<td style="width:105px;">'+n.vitemcode+'</td>';
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right">'+n.dunitprice+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

      $("div#divLoading").removeClass('show');
      
    });

});

//form submit
$(document).on('click', '#save_button_template', function(event) {
  if($('form#form-template input[name="vtemplatename"]').val() == ''){
    // alert('please enter template name');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter template name", 
      callback: function(){}
    });
    return false;
  }else{
    $('form#form-template').submit();
  }
});
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', 'input[name="isequence"], .editable', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 
</script>

<script type="text/javascript">
  $(document).ready(function(){

    var display_items_url = '<?php echo $display_items; ?>';
    display_items_url = display_items_url.replace(/&amp;/g, '&');

    $("div#divLoading").addClass('show');

    <?php if(isset($isalepriceid)){?>

      var isalepriceid = '<?php echo $isalepriceid; ?>';

      display_items_url = display_items_url+'&isalepriceid='+isalepriceid;
      
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
          left_items_html += '<td style="width:105px;">'+n.vitemcode+'</td>';
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right">'+n.dunitprice+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

      if(result.edit_right_items){
        var right_items_html = '';
        $.each(result.edit_right_items, function(i, v) {
          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:1px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td >'+v.vitemcode+'<input type="hidden" name="items['+window.index_item+'][vitemcode]" value="'+v.vitemcode+'"><input type="hidden" name="items['+window.index_item+'][vunitcode]" value="'+v.vunitcode+'"><input type="hidden" name="items['+window.index_item+'][vitemtype]" value="'+v.vitemtype+'"><input type="hidden" name="items['+window.index_item+'][iitemid]" value="'+v.iitemid+'"><input type="hidden" name="items['+window.index_item+'][Id]" value="'+ v.Id +'"></td>';
          right_items_html += '<td>'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right">'+v.dunitprice+'<input type="hidden" name="items['+window.index_item+'][dunitprice]" class="i_dunitprice" value="'+v.dunitprice+'"></td>';
          right_items_html += '<td class="text-right"><span class="s_nsaleprice">'+v.nsaleprice+'</span><input type="hidden" name="items['+window.index_item+'][nsaleprice]" class="i_nsaleprice" value="'+v.nsaleprice+'"></td>';
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
  $(document).on('change', 'input[name="vsaleby"]', function(event) {
    event.preventDefault();
    if($(this).val() == 'Price'){
      $('#p_discount').hide();
      $('#p_price').show();
      $('#td_discount').hide();
      $('#td_sale').show();
    }else{
      $('#p_discount').show();
      $('#p_price').hide();
      $('#td_discount').show();
      $('#td_sale').hide();
    }
    var saleby = $(this).val();
    var discountper = $('input[name="ndiscountper"]').val();
    // calculate price
    calculate_price(saleby,discountper);

  });

  $(document).ready(function() {
    <?php if(isset($vsaletype) && $vsaletype == 'Buy Get Free'){?>
      $('#div_date,#div_buy_qty').css('background','#fff');
      $('#div_date,#div_buy_qty').css('pointer-events','all');
    <?php } else if(isset($vsaletype) && $vsaletype == 'Time Duration'){?>
      $('#div_date').css('background','#fff');
      $('#div_date').css('pointer-events','all');
      $('#div_buy_qty').css('background','#ccc');
      $('#div_buy_qty').css('pointer-events','none');
    <?php } else if(isset($vsaletype) && $vsaletype == 'On Going'){?>
      $('#div_date,#div_buy_qty').css('background','#ccc');
      $('#div_date,#div_buy_qty').css('pointer-events','none');
    <?php } else { ?>
      $('#div_date,#div_buy_qty').css('background','#ccc');
      $('#div_date,#div_buy_qty').css('pointer-events','none');
    <?php } ?>

    <?php if(isset($vsaleby) && $vsaleby == 'Discount'){?>
      $('#td_discount').show();
      $('#td_sale').hide();
      $('#p_discount').show();
      $('#p_price').hide();
    <?php }elseif(isset($vsaleby) && $vsaleby == 'Price'){ ?>
      $('#td_discount').hide();
      $('#td_sale').show();
      $('#p_discount').hide();
      $('#p_price').show();
    <?php }else{ ?>
      $('#td_discount').show();
      $('#td_sale').hide();
      $('#p_discount').show();
      $('#p_price').hide();
    <?php } ?>
  });

  $(document).on('change', 'select[name="vsaletype"]', function(event) {
    event.preventDefault();
    if($(this).val() == 'Buy Get Free'){
      $('#div_date,#div_buy_qty').css('background','#fff');
      $('#div_date,#div_buy_qty').css('pointer-events','all');
    }else if($(this).val() == 'Time Duration'){
      $('#div_date').css('background','#fff');
      $('#div_date').css('pointer-events','all');
      $('#div_buy_qty').css('background','#ccc');
      $('#div_buy_qty').css('pointer-events','none');
    }else if($(this).val() == 'On Going'){
      $('#div_date,#div_buy_qty').css('background','#ccc');
      $('#div_date,#div_buy_qty').css('pointer-events','none');
    }else{
      $('#div_date,#div_buy_qty').css('background','#ccc');
      $('#div_date,#div_buy_qty').css('pointer-events','none');
    }
  });
</script>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>

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

  $(document).on('keypress keyup blur', 'input[name="ndiscountper"]', function(event) {
    
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

    var saleby = $('input[name="vsaleby"]:checked').val();
    var discountper = $(this).val();
    // calculate price
    calculate_price(saleby,discountper);

  });

  $(document).on('keypress keyup blur', 'input[name="nbuyqty"]', function(event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });

  // $(document).on('keypress', 'input[name="ndiscountper"]', function(event) {
  //   event.preventDefault();
  //   console.log($(this).val());
  // });

  var calculate_price = function(vsaleby,ndiscountper){

    if(vsaleby != '' && ndiscountper != ''){
      if($('#itemsort2 tbody tr').length > 0){
        $('#itemsort2 tbody tr').each(function() {
          var i_dunitprice = $(this).find('.i_dunitprice').val();

          var display_nsaleprice = '0.00';
          if(vsaleby == 'Price'){
            display_nsaleprice = i_dunitprice - ndiscountper;
          }else{
            display_nsaleprice = i_dunitprice - ((i_dunitprice * ndiscountper)/100);
          }
          display_nsaleprice = display_nsaleprice.toFixed(2);

          $(this).find('.i_nsaleprice').val(display_nsaleprice);
          $(this).find('.s_nsaleprice').html(display_nsaleprice);

        });
      }
    }
  }

  $(document).on('click', '#save_button_sale', function(event) {

    if($('input[name="vsalename"]').val() == ''){
      // alert('Please Enter Sale Name');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Enter Sale Name", 
        callback: function(){}
      });
      return false;
    }

    if($('select[name="vsaletype"]').val() == ''){
      // alert('Please Select Sale Type');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Sale Type", 
        callback: function(){}
      });
      return false;
    }

    if($('#itemsort2 tbody tr').length == 0){
      // alert('Please Add Items');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Add Items", 
        callback: function(){}
      });
      return false;
    }

    $('form#form-sale').submit();
    $("div#divLoading").addClass('show');
  }); 
</script>
<?php echo $footer; ?>