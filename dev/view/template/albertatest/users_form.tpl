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

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save_btn_rotate"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vfname"><?php echo $entry_first_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vfname" maxlength="25" value="<?php echo isset($vfname) ? $vfname : ''; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-vfname<?php echo $entry_first_name; ?>" class="form-control" />
                  <?php if ($error_vfname) { ?>
                    <div class="text-danger"><?php echo $error_vfname; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vlname"><?php echo $entry_last_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vlname" maxlength="25" value="<?php echo isset($vlname) ? $vlname : ''; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-vlname<?php echo $entry_last_name; ?>" class="form-control" />
                  <?php if ($error_vlname) { ?>
                    <div class="text-danger"><?php echo $error_vlname; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vaddress1"><?php echo $entry_address1; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress1" maxlength="75" value="<?php echo isset($vaddress1) ? $vaddress1 : ''; ?>" placeholder="<?php echo $entry_address1; ?>" id="input-vaddress1<?php echo $entry_address1; ?>" class="form-control" />
                  <?php if ($error_vaddress1) { ?>
                    <div class="text-danger"><?php echo $error_vaddress1; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vaddress2"><?php echo $entry_address2; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress2" maxlength="75" value="<?php echo isset($vaddress2) ? $vaddress2 : ''; ?>" placeholder="<?php echo $entry_address2; ?>" id="input-vaddress2<?php echo $entry_address2; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_city; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcity" maxlength="25" value="<?php echo isset($vcity) ? $vcity : ''; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city<?php echo $entry_city; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_state; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstate" maxlength="25" value="<?php echo isset($vstate) ? $vstate : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-state<?php echo $entry_state; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_zip; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vzip" maxlength="10" value="<?php echo isset($vzip) ? $vzip : ''; ?>" placeholder="<?php echo $entry_zip; ?>" id="input-zip<?php echo $entry_zip; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_country; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcountry" maxlength="20" value="USA" class="form-control" readonly />
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vphone" maxlength="20" value="<?php echo isset($vphone) ? $vphone : ''; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone<?php echo $entry_phone; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-8">
                  <input type="email" name="vemail" maxlength="125" value="<?php echo isset($vemail) ? $vemail : ''; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email<?php echo $entry_email; ?>" class="form-control" />
                  <?php if ($error_vemail) { ?>
                    <div class="text-danger"><?php echo $error_vemail; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vuserid"><?php echo $entry_user_id; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vuserid" maxlength="3" value="<?php echo isset($vuserid) ? $vuserid : ''; ?>" placeholder="<?php echo $entry_user_id; ?>" id="input-vuserid<?php echo $entry_user_id; ?>" class="form-control" />
                  <div class="text-success" id="user-id-msg"></div>
                  <?php if ($error_vuserid) { ?>
                    <div class="text-danger"><?php echo $error_vuserid; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vpassword"><?php echo $entry_password; ?></label>
                <div class="col-sm-8">
                  <input type="password" name="vpassword" maxlength="4" value="<?php echo isset($vpassword) ? $vpassword : ''; ?>" placeholder="<?php echo $entry_password; ?>" id="input-vpassword<?php echo $entry_password; ?>" class="form-control" />
                  <?php if ($error_vpassword) { ?>
                    <div class="text-danger"><?php echo $error_vpassword; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-re-vpassword"><?php echo $entry_re_type_password; ?></label>
                <div class="col-sm-8">
                  <input type="password" name="re_vpassword" maxlength="4" value="<?php echo isset($vpassword) ? $vpassword : ''; ?>" placeholder="<?php echo $entry_re_type_password; ?>" id="input-re-vpassword<?php echo $entry_re_type_password; ?>" class="form-control" />
                  <div class="text-success" id="confirm-pass-msg"></div>
                  <?php if ($error_re_vpassword) { ?>
                    <div class="text-danger"><?php echo $error_re_vpassword; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vusertype"><?php echo $entry_user_type; ?></label>
                <div class="col-sm-8">
                  <select name="vusertype" id="input-vusertype" class="form-control">
                    <option value="">Select User Type</option>
                    <?php foreach ($user_types as $key => $user_type) {?>
                      <?php if(isset($vusertype) && $user_type['vgroupname'] == $vusertype) {?>
                        <option value="<?php echo $user_type['vgroupname']; ?>" selected="selected" ><?php echo $user_type['vgroupname']; ?></option>
                      <?php }else{ ?>
                       <option value="<?php echo $user_type['vgroupname']; ?>" ><?php echo $user_type['vgroupname']; ?></option>
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
                <label class="col-sm-4 control-label" for="input-vlocktype"><?php echo $entry_is_user_locked; ?></label>
                <div class="col-sm-8">
                  <select name="vlocktype" id="input-vlocktype" class="form-control" disabled="true">
                     <option value="<?php echo $text_unlock; ?>" ><?php echo $text_unlock; ?></option>
                  </select>
              </div>
            </div>
          </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vpasswordchange"><?php echo $entry_change_password_at_first_login; ?></label>
                <div class="col-sm-8">
                  <select name="vpasswordchange" id="input-vpasswordchange" class="form-control">
                     <option value="<?php echo $text_no; ?>" ><?php echo $text_no; ?></option>
                     <option value="<?php echo $text_yes; ?>" ><?php echo $text_yes; ?></option>
                  </select>
              </div>
            </div>
          </div>
        </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vuserbarcode"><?php echo $entry_barcode; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vuserbarcode" maxlength="25" value="<?php echo isset($vuserbarcode) ? $vuserbarcode : ''; ?>" placeholder="<?php echo $entry_barcode; ?>" id="input-vuserbarcode<?php echo $entry_barcode; ?>" class="form-control" />
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-estatus"><?php echo $entry_Status; ?></label>
                <div class="col-sm-8">
                  <select name="estatus" id="input-estatus" class="form-control">
                    <?php foreach ($status_arr as $key => $status_a) {?>
                      <?php if(isset($estatus) && $status_a == $estatus) {?>
                        <option value="<?php echo $status_a; ?>" selected="selected" ><?php echo $status_a; ?></option>
                      <?php }else{ ?>
                       <option value="<?php echo $status_a; ?>" ><?php echo $status_a; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_estatus) { ?>
                    <div class="text-danger"><?php echo $error_estatus; ?></div>
                  <?php } ?>
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
  $(document).on('keyup', 'input[name="re_vpassword"]', function(event) {
    event.preventDefault();
    var vpassword = $('input[name="vpassword"]').val();
    var re_vpassword = $(this).val();

    if(vpassword == ''){
      alert('Please Enter Password');
      return false;
    }

    if(vpassword != '' && vpassword == re_vpassword){
      $('#confirm-pass-msg').removeClass('text-danger').addClass('text-success');
      $('#confirm-pass-msg').html('Password Matched');
      return false;
    }else{
      $('#confirm-pass-msg').removeClass('text-success').addClass('text-danger');
      $('#confirm-pass-msg').html('Password Not Matched');
      return false;
    }
  });

  $(document).on('keyup', 'input[name="vuserid"]', function(event) {
    event.preventDefault();
    var vuserid = $(this).val();

    if(!vuserid.match(/^\d{3}$/)){
      $('#user-id-msg').removeClass('text-success').addClass('text-danger');
      $('#user-id-msg').html('Please Enter Numeric User ID');
      return false;
    }else{
      $('#user-id-msg').removeClass('text-success').removeClass('text-danger');
      $('#user-id-msg').html('');
    }
  });

  $(document).on('keypress keyup blur', 'input[name="vzip"],input[name="vuserid"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

</script>

<script src="view/javascript/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $("input[name='vphone']").mask("999-999-9999");
  });
</script>
<?php echo $footer; ?>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>