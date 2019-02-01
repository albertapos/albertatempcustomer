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
        <h3 class="panel-title"><?php echo $heading_title;?></h3>
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_group" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <ul class="nav nav-tabs responsive" id="myTab">
          <li class="active"><a href="#item_tab" data-toggle="tab" style="background-color: #f05a28;color: #fff !important;pointer-events:none;">General</a></li>
          <li><a class="add_new_btn_rotate" href="<?php echo $group_slab_pricing; ?>" style="color: #fff !important;background-color: #03A9F4;<?php if(!isset($iitemgroupid)){?> pointer-events:none;<?php } ?>">Group Slab Pricing</a></li>
        </ul>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-group" class="form-horizontal">
        <?php if(isset($iitemgroupid)){?>
        <input type="hidden" name="iitemgroupid" value="<?php echo $iitemgroupid;?>">
        <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-group"><?php echo $text_group_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" maxlength="100" name="vitemgroupname" value="<?php echo isset($vitemgroupname) ? $vitemgroupname : ''; ?>" placeholder="<?php echo $text_group_name; ?>" class="form-control" required/>

                  <?php if ($error_vitemgroupname) { ?>
                    <div class="text-danger"><?php echo $error_vitemgroupname; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_item_type; ?></label>
                <div class="col-sm-8">
                  <select name="vtype" id="vtype" class="form-control" >
                    <option value="">Please Select</option>
                    <?php foreach($item_types as $item_type){ ?>
                       <option value="<?php echo $item_type; ?>" selected="selected"><?php echo $item_type; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <br><br><br>
          <div class="row">
            <div class="col-md-5">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox"/></td>
                      <td style="width:130px;"><input type="text" class="form-control itemsort1_search" placeholder="SKU" style="border:none;"></td>
                      <td style="width:242px;"><input type="text" class="form-control itemsort1_search" placeholder="Name" style="border:none;"></td>
                      <td class="text-right" style="width:100px;">Price</td>
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
            <div class="col-md-2 text-center" style="margin-top:12%;">
              <a class="btn btn-primary" style="cursor:pointer" id="add_item_btn"><i class="fa fa-arrow-right fa-3x"></i></a><br><br>
              <a class="btn btn-primary" style="cursor:pointer" id="remove_item_btn"><i class="fa fa-arrow-left fa-3x"></i></a>
              
            </div>
            <div class="col-md-5">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width:1%" class="text-center"><input type="checkbox"/></td>
                      <td style="width:242px;"><input type="text" class="form-control itemsort2_search" placeholder="Name" style="border:none;"></td>
                      <td class="text-right" style="width:100px;">Sequence</td>
                      <td class="text-right">Price</td>
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
          right_items_html += '<td class="text-center" style="width:1%;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td style="width:242px;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"><input type="hidden" name="items['+window.index_item+'][vsku]" value="'+v.vbarcode+'"></td>';
          right_items_html += '<td class="text-right" style="width:100px;"><input type="text" class="editable isequence_class" name="items['+window.index_item+'][isequence]" id="" style="width:50px;text-align:right;"></td>';
          right_items_html += '<td class="text-right">'+ v.dunitprice +'</td>';
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
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right" style="width:70px;">'+n.dunitprice+'</td>';
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

  var remove_items_2 = [];

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
      remove_items_2.push($(this).val());

      if($.inArray($(this).val(), window.checked_items1) !== -1){
        window.checked_items1.splice( $.inArray($(this).val(), window.checked_items1), 1 );
        $(this).closest('tr').remove();
      }

  });

    $.ajax({
        url : remove_items_url,
        data : {checkbox_itemsort1:window.checked_items1,remove_items_2:remove_items_2},
        type : 'POST',
    }).done(function(response){

      // var  response = $.parseJSON(response); //decode the response array

      if(response.left_items_arr){
        var left_items_html = '';
        $.each(response.left_items_arr, function(m, n) {
          left_items_html += '<tr>';
          left_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort1[]" value="'+n.iitemid+'"/></td>';
          left_items_html += '<td style="width:105px;">'+n.vbarcode+'</td>';
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right" style="width:70px;">'+n.dunitprice+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }
      $("div#divLoading").removeClass('show');
      
    });

});

//form submit
$(document).on('click', '#save_button_group', function(event) {
  if($('form#form-group input[name="vitemgroupname"]').val() == ''){
    // alert('please enter group name');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "please enter group name", 
      callback: function(){}
    });
    return false;
  }else{
    $('form#form-group').submit();
    $("div#divLoading").addClass('show');
  }
});
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', '.isequence_class', function(event) {

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

    <?php if(isset($iitemgroupid)){?>

      var iitemgroupid = '<?php echo $iitemgroupid; ?>';

      display_items_url = display_items_url+'&iitemgroupid='+iitemgroupid;
      
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
          left_items_html += '<td style="width:51%;">'+n.vitemname+'</td>';
          left_items_html += '<td class="text-right" style="width:70px;">'+n.dunitprice+'</td>';
          left_items_html += '</tr>';
        });

        $('#itemsort1 tbody').html('');
        $('#itemsort1 tbody').append(left_items_html);
      }

      if(result.edit_right_items){
        var right_items_html = '';
        $.each(result.edit_right_items, function(i, v) {
          right_items_html += '<tr>';
          right_items_html += '<td class="text-center" style="width:1%;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td style="width:242px;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"><input type="hidden" name="items['+window.index_item+'][vsku]" value="'+v.vbarcode+'"></td>';
          right_items_html += '<td class="text-right" style="width:100px;"><input type="text" class="editable isequence_class" name="items['+window.index_item+'][isequence]" value="'+v.isequence+'" id="" style="width:50px;text-align:right;"></td>';
          right_items_html += '<td class="text-right">'+ v.dunitprice +'</td>';
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

<?php echo $footer; ?>