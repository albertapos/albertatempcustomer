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

        <div class="row" style="padding-bottom: 15px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_template" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-template" class="form-horizontal">
        <?php if(isset($itemplateid)){?>
        <input type="hidden" name="itemplateid" value="<?php echo $itemplateid;?>">
        <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_template_type; ?></label>
                <div class="col-sm-8">
                  <select name="vtemplatetype" id="vtemplatetype" class="form-control" >
                    <?php foreach($temp_types as $temp_type){ ?>
                      <?php if(isset($vtemplatetype) && $vtemplatetype == $temp_type){ ?>
                        <option value="<?php echo $temp_type; ?>" selected="selected"><?php echo $temp_type; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $temp_type; ?>" ><?php echo $temp_type; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>

                  <?php if ($error_vtemplatetype) { ?>
                    <div class="text-danger"><?php echo $error_vtemplatetype; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_inventory_type; ?></label>
                <div class="col-sm-8">
                  <select name="vinventorytype" id="vinventorytype" class="form-control" >
                    <?php foreach($temp_invent_types as $temp_invent_type){ ?>
                      <?php if(isset($vinventorytype) && $vinventorytype == $temp_invent_type){ ?>
                        <option value="<?php echo $temp_invent_type; ?>" selected="selected"><?php echo $temp_invent_type; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $temp_type; ?>" ><?php echo $temp_invent_type; ?></option>
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
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_template_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vtemplatename" maxlength="50" value="<?php echo isset($vtemplatename) ? $vtemplatename : ''; ?>" placeholder="<?php echo $text_template_name; ?>" class="form-control" required/>

                  <?php if ($error_vtemplatename) { ?>
                    <div class="text-danger"><?php echo $error_vtemplatename; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_template_sequence; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="isequence" maxlength="11" value="<?php echo isset($isequence) ? $isequence : ''; ?>" placeholder="<?php echo $text_template_sequence; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_template_status; ?></label>
                <div class="col-sm-8">
                  <select name="estatus" id="estatus" class="form-control" >
                        <?php  if (isset($estatus) && $estatus == $Active) { ?>
                        <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option>
                        <?php } elseif((isset($estatus) && $estatus == $Inactive)) { ?>
                        <option value="<?php echo $Active; ?>"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>" selected="selected"><?php echo $Inactive; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $Active; ?>"><?php echo $Active; ?></option>
                        <option value="<?php echo $Inactive; ?>"><?php echo $Inactive; ?></option>
                        <?php } ?>
                      </select>

                  <?php if ($error_vtemplatetype) { ?>
                    <div class="text-danger"><?php echo $error_vtemplatetype; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <br><br><br>
          <div class="row">
            <div class="col-md-5" style="pointer-events: all;">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'checkbox_itemsort1\']').prop('checked', this.checked);"/></td>
                      <td style="width:105px;"><input type="text" class="form-control itemsort1_search" placeholder="Item Code" style="border:none;"></td>
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
            <div class="col-md-2 text-center" style="margin-top:12%;">
              <a class="btn btn-primary" style="cursor:pointer" id="add_item_btn"><i class="fa fa-arrow-right fa-3x"></i></a><br><br>
              <a class="btn btn-primary" style="cursor:pointer" id="remove_item_btn"><i class="fa fa-arrow-left fa-3x"></i></a>
              
            </div>
            <div class="col-md-5" style="pointer-events: all;">
              <div class="table-responsive" >
                <table class="table table-bordered table-hover" style="padding:0px; margin:0px;" >
                  <thead>
                    <tr>
                      <td style="width:1%" class="text-center"><input type="checkbox" onclick="$('input[name*=\'checkbox_itemsort2\']').prop('checked', this.checked);"/></td>
                      <td style="width:110px;"><input type="text" class="form-control itemsort2_search" placeholder="Item Code" style="border:none;"></td>
                      <td style="width:210px;"><input type="text" class="form-control itemsort2_search" placeholder="Item Name" style="border:none;"></td>
                      <td class="text-right">Seq</td>
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
          right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td style="width:100px;">'+v.vitemcode+'<input type="hidden" name="items['+window.index_item+'][vitemcode]" value="'+v.vitemcode+'"></td>';
          right_items_html += '<td style="width:220px;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right"><input type="text" class="editable" name="items['+window.index_item+'][isequence]" id="" style="width:25px;text-align:right;"></td>';
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
          left_items_html += '<td style="width:105px;">'+n.vitemcode+'</td>';
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
    $("div#divLoading").addClass('show');
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

    <?php if(isset($itemplateid)){?>

      var itemplateid = '<?php echo $itemplateid; ?>';

      display_items_url = display_items_url+'&itemplateid='+itemplateid;
      
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
          right_items_html += '<td class="text-center" style="width:30px;"><input type="checkbox" name="checkbox_itemsort2[]" value="'+v.iitemid+'"/></td>';
          right_items_html += '<td style="width:100px;">'+v.vitemcode+'<input type="hidden" name="items['+window.index_item+'][vitemcode]" value="'+v.vitemcode+'"></td>';
          right_items_html += '<td style="width:220px;">'+v.vitemname+'<input type="hidden" name="items['+window.index_item+'][vitemname]" value="'+v.vitemname+'"></td>';
          right_items_html += '<td class="text-right"><input type="text" class="editable" name="items['+window.index_item+'][isequence]" value="'+v.isequence+'" id="" style="width:25px;text-align:right;"></td>';
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