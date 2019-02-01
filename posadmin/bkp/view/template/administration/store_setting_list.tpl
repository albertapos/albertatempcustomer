<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"> <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        
        <form action="" method="post" enctype="multipart/form-data" id="form-store-setting">
          <div class="table-responsive">
            <table id="table_store_setting" class="table table-bordered table-hover" style="width:60%;">
              <thead>
                <tr>
                  <td style="" class="text-center"><?php echo $column_setting_name; ?></td>
                  <td class="text-center"><?php echo $column_setting_value; ?></td>
                </tr>
              </thead>
              <tbody>
              
                <?php if ($store_settings) { ?>
                <tr>
                  <td class="text-left">
                    <b>Required Password </b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[RequiredPassword_id]" value="<?php echo $store_settings[4]['Id']; ?>">
                    <select name="store_setting[RequiredPassword]" id="" class="form-control">
                      <?php  if ($store_settings[4]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Same Product</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[SameProduct_id]" value="<?php echo $store_settings[2]['Id']; ?>">
                    <select name="store_setting[SameProduct]" id="" class="form-control">
                      <?php  if ($store_settings[2]['vsettingvalue']==$Yes) { ?>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <option value="<?php echo $No; ?>" ><?php echo $No; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Same Product</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[SameProduct_id]" value="<?php echo $store_settings[2]['Id']; ?>">
                    <select name="store_setting[SameProduct]" id="" class="form-control">
                      <?php  if ($store_settings[2]['vsettingvalue']==$Yes) { ?>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <option value="<?php echo $No; ?>" ><?php echo $No; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Geographical Information</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Geographical_Information_id]" value="<?php echo $store_settings[3]['Id']; ?>">
                    <select name="store_setting[Geographical_Information]" id="" class="form-control">
                      <?php  if ($store_settings[3]['vsettingvalue']==$None) { ?>
                      <option value="<?php echo $None; ?>" selected="selected"><?php echo $None; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $None; ?>" selected="selected"><?php echo $None; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow discount less then cost price</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Allowdiscountlessthencostprice_id]" value="<?php echo $store_settings[7]['Id']; ?>">
                    <select name="store_setting[Allowdiscountlessthencostprice]" id="" class="form-control">
                      <?php  if ($store_settings[7]['vsettingvalue']==$Yes) { ?>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <option value="<?php echo $No; ?>" ><?php echo $No; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow Update Qoh </b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[AllowUpdateQoh_id]" value="<?php echo $store_settings[15]['Id']; ?>">
                    <select name="store_setting[AllowUpdateQoh]" id="" class="form-control">
                      <?php  if ($store_settings[15]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Start Time </b>
                  </td>
                  <?php
                    if($store_settings[1]['vsettingvalue'] != ''){
                      $s_time = explode(",",$store_settings[1]['vsettingvalue']);
                      $s_time_start = $s_time[0];
                      $s_time_end = $s_time[1];
                    }else{
                      $s_time_start = '';
                      $s_time_end = '';
                    }
                  ?>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[StoreTime_id]" value="<?php echo $store_settings[1]['Id']; ?>">
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
                    <input type="hidden" name="store_setting[Defaultageverificationdate_id]" value="<?php echo $store_settings[5]['Id']; ?>">
                    <input type="text" class="form-control" name="store_setting[Defaultageverificationdate]" id="datePicker" value="<?php echo $store_settings[5]['vsettingvalue']; ?>" />
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Tax1 seleted for new Item? </b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Tax1seletedfornewItem_id]" value="<?php echo $store_settings[8]['Id']; ?>">
                    <select name="store_setting[Tax1seletedfornewItem]" id="" class="form-control">
                      <?php  if ($store_settings[8]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Display low inventory warnings </b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[ShowlowlevelInventory_id]" value="<?php echo $store_settings[9]['Id']; ?>">
                    <select name="store_setting[ShowlowlevelInventory]" id="" class="form-control">
                      <?php  if ($store_settings[9]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Ask Beginning balance in dollar</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[AskBeginningbalanceindollar_id]" value="<?php echo $store_settings[11]['Id']; ?>">
                    <select name="store_setting[AskBeginningbalanceindollar]" id="" class="form-control">
                      <?php  if ($store_settings[11]['vsettingvalue']==$Yes) { ?>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <option value="<?php echo $No; ?>" ><?php echo $No; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Ask Reason for void transaction </b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[AskReasonforvoidtransaction_id]" value="<?php echo $store_settings[10]['Id']; ?>">
                    <select name="store_setting[AskReasonforvoidtransaction]" id="" class="form-control">
                      <?php  if ($store_settings[10]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Update all register quick item once</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Updateallregisterquickitemonce_id]" value="<?php echo $store_settings[12]['Id']; ?>">
                    <select name="store_setting[Updateallregisterquickitemonce]" id="" class="form-control">
                      <?php  if ($store_settings[12]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
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
                    if($store_settings[13]['vsettingvalue'] != ''){
                      $price_conf = $store_settings[13]['vsettingvalue'];
                    }else{
                      $price_conf = 0;
                    }
                  ?>
                  <input type="hidden" name="store_setting[AskItemPriceConfirmation_id]" value="<?php echo $store_settings[13]['Id']; ?>">
                  <input type="text" name="store_setting[AskItemPriceConfirmation]" value="<?php echo $price_conf; ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Show quotation</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Showquotation_id]" value="<?php echo $store_settings[14]['Id']; ?>">
                    <select name="store_setting[Showquotation]" id="" class="form-control">
                      <?php  if ($store_settings[14]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td class="text-left">
                    <b>Update Inventory</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[QutaInventory_id]" value="<?php echo $store_settings[21]['Id']; ?>">
                    <select name="store_setting[QutaInventory]" id="" class="form-control">
                      <?php  if ($store_settings[21]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Calculate tax</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[QutaTax_id]" value="<?php echo $store_settings[22]['Id']; ?>">
                    <select name="store_setting[QutaTax]" id="" class="form-control">
                      <?php  if ($store_settings[22]['vsettingvalue']==$Yes) { ?>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <option value="<?php echo $No; ?>" ><?php echo $No; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" selected="selected"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Do backup when login</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[Dobackupwhenlogin_id]" value="<?php echo $store_settings[16]['Id']; ?>">
                    <select name="store_setting[Dobackupwhenlogin]" id="" class="form-control">
                      <?php  if ($store_settings[16]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Email (Separate by ;)</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[AlertEmail_id]" value="<?php echo $store_settings[6]['Id']; ?>">
                  <input type="text" name="store_setting[AlertEmail]" value="<?php echo $store_settings[6]['vsettingvalue']; ?>" class="form-control">
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Allow zero item price to update?</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[ZeroItemPriceUpdate_id]" value="<?php echo $store_settings[18]['Id']; ?>">
                    <select name="store_setting[ZeroItemPriceUpdate]" id="" class="form-control">
                      <?php  if ($store_settings[18]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Show changeDue Dialog</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[ShowChangeDuewnd_id]" value="<?php echo $store_settings[19]['Id']; ?>">
                    <select name="store_setting[ShowChangeDuewnd]" id="" class="form-control">
                      <?php  if ($store_settings[19]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Enable Add Quick Item Screen</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[EnableQuickItemScreen_id]" value="<?php echo $store_settings[20]['Id']; ?>">
                    <select name="store_setting[EnableQuickItemScreen]" id="" class="form-control">
                      <?php  if ($store_settings[20]['vsettingvalue']==$No) { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>" ><?php echo $Yes; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $No; ?>" selected="selected"><?php echo $No; ?></option>
                      <option value="<?php echo $Yes; ?>"><?php echo $Yes; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">
                    <b>Send Z ReportEmail :(Separate by ;)</b>
                  </td>
                  <td class="text-left">
                  <input type="hidden" name="store_setting[ZreportEmail_id]" value="<?php echo $store_settings[0]['Id']; ?>">
                  <input type="text" name="store_setting[ZreportEmail]" value="<?php echo $store_settings[0]['vsettingvalue']; ?>" class="form-control">
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
    
  });
</script>

<!-- date picker -->
<script src="view/javascript/datepicker.js" defer></script> 
<link type="text/css" href="view/javascript/simpledatepicker.css" rel="stylesheet" />
<script type="text/javascript">
$(function(){
  $("#datePicker").appendDtpicker({
          "futureOnly": false,
          "todayButton": false,
          "dateOnly": true,
          "autodateOnStart": false,
          autoclose: true,
          "dateFormat": "MM-DD-YYYY",
        });
  });
</script>

<style type="text/css">
  .datepicker>.datepicker_header>.icon-close>div{
    margin-left: -15px !important;
  }
</style>
<!-- date picker -->

<?php echo $footer; ?>