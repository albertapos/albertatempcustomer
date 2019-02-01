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
              <button type="submit" form="form-vendor" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save_btn_rotate"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-vendor" class="form-horizontal">
          <input type="hidden" name="estatus" value="Active">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-vendor-name"><?php echo $entry_vendor_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcompanyname" maxlength="50" value="<?php echo isset($vcompanyname) ? $vcompanyname : ''; ?>" placeholder="<?php echo $entry_vendor_name; ?>" id="input-vendor-name<?php echo $entry_vendor_name; ?>" class="form-control" />

                  <?php if ($error_vcompanyname) { ?>
                    <div class="text-danger"><?php echo $error_vcompanyname; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vendor-type"><?php echo $entry_vendor_type; ?></label>
                <div class="col-sm-8">
                  <select name="vvendortype" id="input-vendor-type" class="form-control">
                    <?php echo $vvendortype; if ($vvendortype==$text_vendor) { ?>
                    <option value="<?php echo $text_vendor; ?>" selected="selected"><?php echo $text_vendor; ?></option>
                    <option value="<?php echo $text_other; ?>" ><?php echo $text_other; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $text_vendor; ?>" selected="selected"><?php echo $text_vendor; ?></option>
                    <option value="<?php echo $text_other; ?>"><?php echo $text_other; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-first-name"><?php echo $entry_first_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vfnmae" maxlength="25" value="<?php echo isset($vfnmae) ? $vfnmae : ''; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-first-name<?php echo $entry_first_name; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-last-name"><?php echo $entry_last_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vlname" maxlength="25" value="<?php echo isset($vlname) ? $vlname : ''; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-last-name<?php echo $entry_last_name; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-vendor-code"><?php echo $entry_vendor_code; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcode" maxlength="20" value="<?php echo isset($vcode) ? $vcode : ''; ?>" placeholder="<?php echo $entry_vendor_code; ?>" id="input-last-name<?php echo $entry_vendor_code; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-address"><?php echo $entry_address; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress1" maxlength="100" value="<?php echo isset($vaddress1) ? $vaddress1 : ''; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address<?php echo $entry_address; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_city; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcity" maxlength="20" value="<?php echo isset($vcity) ? $vcity : ''; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city<?php echo $entry_city; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_state; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstate" maxlength="20" value="<?php echo isset($vstate) ? $vstate : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-state<?php echo $entry_state; ?>" class="form-control" />
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
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_zip; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vzip" maxlength="10" value="<?php echo isset($vzip) ? $vzip : ''; ?>" placeholder="<?php echo $entry_zip; ?>" id="input-zip<?php echo $entry_zip; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_country; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcountry" maxlength="20" value="USA" class="form-control" readonly />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-8">
                  <input type="email" name="vemail" maxlength="100" value="<?php echo isset($vemail) ? $vemail : ''; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email<?php echo $entry_email; ?>" class="form-control" />

                  <?php if ($error_vemail) { ?>
                    <div class="text-danger"><?php echo $error_vemail; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_plcb_type; ?></label>
                <div class="col-sm-8">
                  <select name="plcbtype" class="form-control">
                    <?php foreach($schedules as $schedule){ ?>
                      <?php if($schedule == $plcbtype){?>
                        <option value="<?php echo $schedule;?>" selected="selected"><?php echo $schedule;?></option>
                      <?php }else{ ?>
                        <option value="<?php echo $schedule;?>"><?php echo $schedule;?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
 
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?>

<script type="text/javascript">
  $(document).on('keypress keyup blur', 'input[name="vzip"]', function(event) {

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
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>