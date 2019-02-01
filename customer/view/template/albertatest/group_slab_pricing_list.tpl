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
        <h3 class="panel-title">Item Group</h3>
        
      </div>
      <div class="panel-body">

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary" id="save_button"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>
              <button class="btn btn-danger" id="delete_items" style="border-radius: 0px;">Delete</button> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <ul class="nav nav-tabs responsive" id="myTab">
        <li><a class="add_new_btn_rotate" href="<?php echo $group; ?>" style="color: #fff !important;background-color: #03A9F4;">General</a></li>
        <li class="active"><a href="#" style="background-color: #f05a28;color: #fff !important;pointer-events:none;">Group Slab Pricing</a></li>
      </ul>
        
        <form action="<?php echo $edit;?>" method="post" enctype="multipart/form-data" id="form-group-slab-pricing">
          <div class="table-responsive">
            <table id="group_slab_pricing" class="table table-bordered table-hover" style="">
            <?php if ($group_slab_pricings) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_group_name; ?></th>
                  <th class="text-right"><?php echo $column_qty; ?></th>
                  <th class="text-right"><?php echo $column_price; ?></th>
                  <th class="text-right"><?php echo $column_unit_price; ?></th>
                  <th class="text-right"><?php echo $column_percentage; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left"><?php echo $column_start_date; ?></th>
                  <th class="text-left"><?php echo $column_end_date; ?></th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($group_slab_pricings as $k => $group_slab_pricing) { ?>
                <tr>
                  <td data-order="<?php echo $group_slab_pricing['igroupslabid']; ?>" class="text-center">
                    <?php if (in_array($group_slab_pricing['igroupslabid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="group_slab_pricing[<?php echo $k; ?>][select]" value="<?php echo $group_slab_pricing['igroupslabid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="group_slab_pricing[<?php echo $k; ?>][select]"  value="<?php echo $group_slab_pricing['igroupslabid']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="group_slab_pricing[<?php echo $k; ?>][igroupslabid]" value="<?php echo $group_slab_pricing['igroupslabid']; ?>"/>
                  </td>
                  
                  <td class="text-left">
                    <?php foreach($groups as $group){?>
                      <?php if($group['iitemgroupid'] == $group_slab_pricing['iitemgroupid']){?>
                        <span><?php echo $group['vitemgroupname']; ?></span>
                      <?php } ?>
                    <?php } ?>
                    <input type="hidden" name="group_slab_pricing[<?php echo $k; ?>][iitemgroupid]" value="<?php echo $group_slab_pricing['iitemgroupid']; ?>"/>
                  </td>

                  <td class="text-right">
                    <input type="text" maxlength="11" class="editable iqty_class" name="group_slab_pricing[<?php echo $k; ?>][iqty]" id="group_slab_pricing[<?php echo $k; ?>][iqty]" value="<?php echo $group_slab_pricing['iqty']; ?>" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:40px;text-align: right;"/>
                  </td>

                  <td class="text-right">
                    <input type="text" class="editable nprice_class" name="group_slab_pricing[<?php echo $k; ?>][nprice]" id="group_slab_pricing[<?php echo $k; ?>][nprice]" value="<?php echo $group_slab_pricing['nprice']; ?>" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:40px;text-align: right;" <?php if($group_slab_pricing['percentage'] != '0.00'){?> readonly <?php } ?>/>
                  </td>

                  <td class="text-right">
                    <input type="text" class="editable nunitprice_class" name="group_slab_pricing[<?php echo $k; ?>][nunitprice]" id="group_slab_pricing[<?php echo $k; ?>][nunitprice]" value="<?php echo $group_slab_pricing['nunitprice']; ?>" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:40px;text-align: right;" />
                  </td>

                  <td class="text-right">
                    <input type="text" class="editable percentage_class" name="group_slab_pricing[<?php echo $k; ?>][percentage]" id="group_slab_pricing[<?php echo $k; ?>][percentage]" value="<?php echo $group_slab_pricing['percentage']; ?>" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:40px;text-align: right;" <?php if(($group_slab_pricing['nprice'] != '0.00') || (($group_slab_pricing['nprice'] == '0.00') && ($group_slab_pricing['percentage'] == '0.00'))){?> readonly <?php } ?> />

                    <?php if(($group_slab_pricing['nprice'] != '0.00') || (($group_slab_pricing['nprice'] == '0.00') && ($group_slab_pricing['percentage'] == '0.00'))){?>
                      <input type="hidden" name="group_slab_pricing[<?php echo $k; ?>][slicetype]" value="price">
                    <?php }else{ ?>
                      <input type="hidden" name="group_slab_pricing[<?php echo $k; ?>][slicetype]" value="percentage">
                    <?php } ?>
                  </td>

                  <td class="text-left">
                    <select name="group_slab_pricing[<?php echo $k; ?>][status]" id="group_slab_pricing[<?php echo $k; ?>][status]" class="form-control" onchange='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($group_slab_pricing['status'] == '0') { ?>
                      <option value="1"><?php echo $Active; ?></option>
                      <option value="0" selected="selected"><?php echo $Inactive; ?></option>
                      <?php } else { ?>
                      <option value="1" selected="selected"><?php echo $Active; ?></option>
                      <option value="0"><?php echo $Inactive; ?></option>
                      <?php } ?>
                    </select>
                  </td>

                  <td class="text-left">
                    <?php 
                      $start_date = DateTime::createFromFormat('Y-m-d H:i:s', $group_slab_pricing['startdate'])->format('m-d-Y');
                      $start_time = DateTime::createFromFormat('Y-m-d H:i:s', $group_slab_pricing['startdate'])->format('H');
                    ?>
                    <input type="text" name="group_slab_pricing[<?php echo $k; ?>][startdate]" value="<?php echo $start_date; ?>" class="start_date" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:80px;height:31px;"/>
                    &nbsp;&nbsp;&nbsp;
                    <select name="group_slab_pricing[<?php echo $k; ?>][start_time]" class="form-control" style="width:35%;display:inline-block;" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");'>
                    <?php for($i=0;$i<=23;$i++){?>
                      <?php if(sprintf("%02d",$i) == $start_time){?>
                        <option value="<?php echo sprintf("%02d",$i) ;?>" selected="selected"><?php echo sprintf("%02d",$i) ;?></option>
                      <?php } else {?>
                         <option value="<?php echo sprintf("%02d",$i) ;?>"><?php echo sprintf("%02d",$i) ;?></option>
                      <?php } ?>
                    <?php } ?>
                    </select>
                  </td>

                  <td class="text-left">
                    <?php 
                      $end_date = DateTime::createFromFormat('Y-m-d H:i:s', $group_slab_pricing['enddate'])->format('m-d-Y');
                      $end_time = DateTime::createFromFormat('Y-m-d H:i:s', $group_slab_pricing['enddate'])->format('H');
                    ?>
                    <input type="text" name="group_slab_pricing[<?php echo $k; ?>][enddate]" value="<?php echo $end_date; ?>" class="end_date" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");' style="width:80px;height:31px;"/>
                    &nbsp;&nbsp;&nbsp;
                    <select name="group_slab_pricing[<?php echo $k; ?>][end_time]" class="form-control" style="width:35%;display:inline-block;" onclick='document.getElementById("group_slab_pricing[<?php echo $k; ?>][select]").setAttribute("checked","checked");'>
                    <?php for($i=0;$i<=23;$i++){?>
                      <?php if(sprintf("%02d",$i) == $end_time){?>
                        <option value="<?php echo sprintf("%02d",$i) ;?>" selected="selected"><?php echo sprintf("%02d",$i) ;?></option>
                      <?php } else {?>
                         <option value="<?php echo sprintf("%02d",$i) ;?>"><?php echo sprintf("%02d",$i) ;?></option>
                      <?php } ?>
                    <?php } ?>
                    </select>
                  </td>
                </tr>

                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>


<!-- DataTables -->
<!-- <script src="view/javascript/dataTables.bootstrap.css"></script> -->
<script src="view/javascript/jquery.dataTables.min.js"></script>
<script src="view/javascript/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$('#group_slab_pricing').DataTable({
    "paging": true,
    "iDisplayLength": 25,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": true,
    "aaSorting": [[ 0, "desc" ]],
    "oLanguage": { "sSearch": "" },
    // 'aoColumnDefs': [{
    //     'bSortable': false,
    //     'aTargets': [4,5,9] /* 1st one, start by the right */
    // }]
    
});

</script>

<style type="text/css">
  #group_slab_pricing_filter, #group_slab_pricing_paginate{
    float: right;
  }

  #group_slab_pricing_filter{
    margin-bottom: 5%;
  }
</style>

<script type="text/javascript">
  $(document).ready(function() {
    $('#group_slab_pricing_length').parent().hide();
    $('#group_slab_pricing_info').parent().hide();

    $('#group_slab_pricing_filter').css('float','left');
    $('#group_slab_pricing_filter').css('margin-bottom','11px');
    $('#group_slab_pricing_paginate').css('float','left');

    $('#group_slab_pricing_filter').find('input[type="search"]').css('width','200%');
    $('#group_slab_pricing_filter').find('input[type="search"]').attr('placeholder','search...');
    $('#group_slab_pricing_filter').find('input[type="search"]').css('font-size','14px');
    $('#group_slab_pricing_filter').find('input[type="search"]').css('font-weight','normal');

  });
</script>

<!-- DataTables -->

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<script type="text/javascript">
  $(function(){

    $('.start_date').each(function(){
        $(this).datepicker({
          format: 'mm-dd-yyyy',
          todayHighlight: true,
          autoclose: true,
        });
    });
  
    $('.end_date').each(function(){
        $(this).datepicker({
          format: 'mm-dd-yyyy',
          todayHighlight: true,
          autoclose: true,
        });
    });
  });
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', '.iqty_class', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

  $(document).on('keypress keyup blur', '.nprice_class, .nunitprice_class, .percentage_class', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  });

  $(document).on('focusout', '.nprice_class, .nunitprice_class, .percentage_class', function(event) {
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

  $(document).on('click', '#save_button', function(event) {

    <?php if(isset($group_slab_pricings) && count($group_slab_pricings) == 0){?>
      alert('Please add group slab pricing');
      return false;
    <?php } ?>
    
    $('form#form-group-slab-pricing').submit();
    $("div#divLoading").addClass('show');
  });
 
  $(document).on('click', '#delete_items', function(event) {
    event.preventDefault();

    var delete_slab_pricing_item_url = '<?php echo $delete_slab_pricing_item; ?>';
    delete_slab_pricing_item_url = delete_slab_pricing_item_url.replace(/&amp;/g, '&');

    var data_delete_items = {};

    if($("input[name='selected[]']:checked").length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Group Slab Pricing", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');

    $("input[name='selected[]']:checked").each(function (i){
      data_delete_items[i] = parseInt($(this).val());
    });

    $.ajax({
        url : delete_slab_pricing_item_url,
        data : JSON.stringify(data_delete_items),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {
          
          $("div#divLoading").removeClass('show');
          $('#success_alias').html('<strong>'+ data.success +'</strong>');
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
          $("div#divLoading").removeClass('show');

          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: error_show, 
            callback: function(){}
          });
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

<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>