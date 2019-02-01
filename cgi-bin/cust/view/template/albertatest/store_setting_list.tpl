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
              <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-store-setting">
          <div class="table-responsive">
            <table id="table_store_setting" class="table table-bordered table-hover" style="width:60%;">
            <?php if ($store_settings) { ?>
              <thead>
                <tr>
                  <td style="" class="text-left"><?php echo $column_setting_name; ?></td>
                  <td class="text-left"><?php echo $column_setting_value; ?></td>
                </tr>
              </thead>
              <tbody>
              
                <tr>
                  <td class="text-left">
                    <b>Required Password </b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[RequiredPassword]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['RequiredPassword']) && $store_settings['RequiredPassword']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Same Product</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[SameProduct]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['SameProduct']) && $store_settings['SameProduct']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Geographical Information</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Geographical Information]" id="" class="form-control">
                      <?php if(isset($store_settings['Geographical Information']) && $store_settings['Geographical Information']['vsettingvalue'] == $None){?>
                        <option value="<?php echo $None; ?>" selected="selected"><?php echo $None; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $None; ?>"><?php echo $None; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow discount less then cost price</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Allowdiscountlessthencostprice]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['Allowdiscountlessthencostprice']) && $store_settings['Allowdiscountlessthencostprice']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow Update Qoh </b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[AllowUpdateQoh]" id="" class="form-control">
                    <?php foreach($arr_y_n as $array_y_n){ ?>
                      <?php if(isset($store_settings['AllowUpdateQoh']) && $store_settings['AllowUpdateQoh']['vsettingvalue'] == $array_y_n){?>
                        <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                      <?php } ?>
                    <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Start Time </b>
                  </td>
                  <?php
                    if(isset($store_settings['StoreTime']['vsettingvalue']) && $store_settings['StoreTime']['vsettingvalue'] != ''){
                      $s_time = explode(",",$store_settings['StoreTime']['vsettingvalue']);
                      $s_time_start = $s_time[0];
                      $s_time_end = $s_time[1];
                    }else{
                      $s_time_start = '';
                      $s_time_end = '';
                    }
                  ?>
                  <td class="text-left">
                    <select name="store_setting[StoreTime_s]" id="" class="form-control">
                      <?php if($s_time_start != ''){ ?>
                        <?php foreach ($time_arr as $t_arr) { ?>
                          <?php if($t_arr == $s_time_start){ ?>
                              <option value="<?php echo $t_arr; ?>" selected="selected"><?php echo $t_arr; ?></option>  
                          <?php }else{ ?>
                                <option value="<?php echo $t_arr; ?>" ><?php echo $t_arr; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php }else{ ?>
                        <?php foreach ($time_arr as $t_arr) { ?>
                          <?php if($t_arr == '09:00 am'){ ?>
                              <option value="<?php echo $t_arr; ?>" selected="selected"><?php echo $t_arr; ?></option>  
                          <?php }else{ ?>
                                <option value="<?php echo $t_arr; ?>" ><?php echo $t_arr; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
          
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left"><b>End Time </b></td>
                
                  <td class="text-left">
                  
                    <select name="store_setting[StoreTime_e]" id="" class="form-control">
                      <?php if($s_time_end != ''){ ?>
                        <?php foreach ($time_arr as $t_arr) { ?>
                          <?php if($t_arr == $s_time_end){ ?>
                              <option value="<?php echo $t_arr; ?>" selected="selected"><?php echo $t_arr; ?></option>  
                          <?php }else{ ?>
                                <option value="<?php echo $t_arr; ?>" ><?php echo $t_arr; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php }else{ ?>
                        <?php foreach ($time_arr as $t_arr) { ?>
                          <?php if($t_arr == '09:00 am'){ ?>
                              <option value="<?php echo $t_arr; ?>" selected="selected"><?php echo $t_arr; ?></option>  
                          <?php }else{ ?>
                                <option value="<?php echo $t_arr; ?>" ><?php echo $t_arr; ?></option>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
          
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left"><b>Default age verification date </b></td>
                
                  <td class="text-left">
                    <input type="text" class="form-control" name="store_setting[Defaultageverificationdate]" id="datePicker" value="<?php echo isset($store_settings['Defaultageverificationdate']['vsettingvalue']) ? $store_settings['Defaultageverificationdate']['vsettingvalue']: ''; ?>" />
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Tax1 seleted for new Item? </b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Tax1seletedfornewItem]" id="" class="form-control">
                      <?php foreach($arr_yes_no as $array_y_n){ ?>
                        <?php if(isset($store_settings['Tax1seletedfornewItem']) && $store_settings['Tax1seletedfornewItem']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Display low inventory warnings </b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[ShowlowlevelInventory]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['ShowlowlevelInventory']) && $store_settings['ShowlowlevelInventory']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Ask Beginning balance in dollar</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[AskBeginningbalanceindollar]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['AskBeginningbalanceindollar']) && $store_settings['AskBeginningbalanceindollar']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Ask Reason for void transaction </b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[AskReasonforvoidtransaction]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['AskReasonforvoidtransaction']) && $store_settings['AskReasonforvoidtransaction']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Update all register quick item once</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Updateallregisterquickitemonce]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['Updateallregisterquickitemonce']) && $store_settings['Updateallregisterquickitemonce']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Amount for item price confirmation</b>
                  </td>
                  <td class="text-left">
                  <?php 
                    if(isset($store_settings['AskItemPriceConfirmation']['vsettingvalue']) && $store_settings['AskItemPriceConfirmation']['vsettingvalue'] != ''){
                      $price_conf = $store_settings['AskItemPriceConfirmation']['vsettingvalue'];
                    }else{
                      $price_conf = 0;
                    }
                  ?>
                  <input type="text" name="store_setting[AskItemPriceConfirmation]" value="<?php echo $price_conf; ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Show quotation</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Showquotation]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['Showquotation']) && $store_settings['Showquotation']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td class="text-left">
                    <b>Update Inventory</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[QutaInventory]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['QutaInventory']) && $store_settings['QutaInventory']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Calculate tax</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[QutaTax]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['QutaTax']) && $store_settings['QutaTax']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Do backup when login</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[Dobackupwhenlogin]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['Dobackupwhenlogin']) && $store_settings['Dobackupwhenlogin']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Email (Separate by ;)</b>
                  </td>
                  <td class="text-left">
                  <input type="text" name="store_setting[AlertEmail]" value="<?php echo isset($store_settings['AlertEmail']['vsettingvalue']) ? $store_settings['AlertEmail']['vsettingvalue'] : ''; ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow zero item price to update?</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[ZeroItemPriceUpdate]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['ZeroItemPriceUpdate']) && $store_settings['ZeroItemPriceUpdate']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Show changeDue Dialog</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[ShowChangeDuewnd]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['ShowChangeDuewnd']) && $store_settings['ShowChangeDuewnd']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Enable Add Quick Item Screen</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[EnableQuickItemScreen]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['EnableQuickItemScreen']) && $store_settings['EnableQuickItemScreen']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Send Z ReportEmail :(Separate by ;)</b>
                  </td>
                  <td class="text-left">
                  <input type="text" name="store_setting[ZreportEmail]" value="<?php echo isset($store_settings['ZreportEmail']['vsettingvalue']) ? $store_settings['ZreportEmail']['vsettingvalue']: ''; ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Enable WICITEM</b>
                  </td>
                  <td class="text-left">
                    <select name="store_setting[EnableWicItem]" id="" class="form-control">
                      <?php foreach($arr_y_n as $array_y_n){ ?>
                        <?php if(isset($store_settings['EnableWicItem']) && $store_settings['EnableWicItem']['vsettingvalue'] == $array_y_n){?>
                          <option value="<?php echo $array_y_n; ?>" selected="selected"><?php echo $array_y_n; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $array_y_n; ?>"><?php echo $array_y_n; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
               
                <?php } else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    $('#form-store-setting').attr('action', edit_url);
    $('#form-store-setting').submit();
    $("div#divLoading").addClass('show');
    
  });
</script>

<!-- date picker -->
<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>

<script>
  $(function(){
    $("#datePicker").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>
<!-- date picker -->

<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>