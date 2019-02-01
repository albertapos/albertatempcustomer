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
              <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary save_btn_rotate"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
        <input type="hidden" name="estatus" value="Active">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcustomername" maxlength="50" value="<?php echo isset($vcustomername) ? $vcustomername : ''; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer<?php echo $entry_customer; ?>" class="form-control" />

                  <?php if ($error_vcustomername) { ?>
                    <div class="text-danger"><?php echo $error_vcustomername; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-account-number"><?php echo $entry_account_number; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaccountnumber" maxlength="50" value="<?php echo isset($vaccountnumber) ? $vaccountnumber : ''; ?>" placeholder="<?php echo $entry_account_number; ?>" id="input-account-number<?php echo $entry_account_number; ?>" class="form-control" readonly/>

                  <?php if ($error_vaccountnumber) { ?>
                    <div class="text-danger"><?php echo $error_vaccountnumber; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-first-name"><?php echo $entry_first_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vfname" maxlength="25" value="<?php echo isset($vfname) ? $vfname : ''; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-first-name<?php echo $entry_first_name; ?>" class="form-control" />
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
                <label class="col-sm-4 control-label" for="input-address"><?php echo $entry_address; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress1" maxlength="100" value="<?php echo isset($vaddress1) ? $vaddress1 : ''; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address<?php echo $entry_address; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_city; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcity" maxlength="20" value="<?php echo isset($vcity) ? $vcity : ''; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city<?php echo $entry_city; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_state; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstate" maxlength="20" value="<?php echo isset($vstate) ? $vstate : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-state<?php echo $entry_state; ?>" class="form-control" />
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
                  <input type="text" maxlength="20" name="vcountry" value="USA" class="form-control" readonly />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vphone" maxlength="20" value="<?php echo isset($vphone) ? $vphone : ''; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone<?php echo $entry_phone; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
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
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-email"><?php echo $entry_price_level; ?></label>
                <div class="col-sm-8">

                  <select name="pricelevel" class="form-control">
                    <?php foreach($price_levels as $m => $price_level){ ?>
                      <?php if($m == $pricelevel){ ?>
                        <option value="<?php echo $m; ?>" selected="selected"><?php echo $price_level;?></option>
                      <?php } else { ?>
                        <option value="<?php echo $m; ?>"><?php echo $price_level;?></option>
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
                <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_debit_limit; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="debitlimit" value="<?php echo isset($debitlimit) ? $debitlimit : ''; ?>" placeholder="<?php echo $entry_debit_limit; ?>" id="input-debitlimit<?php echo $entry_debit_limit; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_credit_day; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="creditday" maxlength="11" value="<?php echo isset($creditday) ? $creditday : ''; ?>" placeholder="<?php echo $entry_credit_day; ?>" id="input-creditday<?php echo $entry_credit_day; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-taxable">&nbsp;</label>
                <div class="col-sm-10">
                  <?php if(isset($vtaxable) && $vtaxable == 'Yes'){?>
                    <input type='radio' name='vtaxable' value='Yes' checked="checked">&nbsp;&nbsp;<?php echo $Taxable; ?>&nbsp;&nbsp;
                    <input type='radio' name='vtaxable' value='No' >&nbsp;&nbsp;<?php echo $nontaxable; ?>
                  <?php }else if(isset($vtaxable) && $vtaxable == 'No') { ?>
                    <input type='radio' name='vtaxable' value='Yes'>&nbsp;&nbsp;<?php echo $Taxable; ?>&nbsp;&nbsp;
                    <input type='radio' name='vtaxable' value='No' checked="checked">&nbsp;&nbsp;<?php echo $nontaxable; ?>
                  <?php }else{ ?>
                    <input type='radio' name='vtaxable' value='Yes' checked="checked">&nbsp;&nbsp;<?php echo $Taxable; ?>&nbsp;&nbsp;
                    <input type='radio' name='vtaxable' value='No' >&nbsp;&nbsp;<?php echo $nontaxable; ?>
                  <?php } ?>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-zip">Note</label>
                <div class="col-sm-8">
                  <textarea name="note" class="form-control"><?php echo isset($note) ? $note : ''; ?></textarea>
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
  $(document).on('change', 'input[name="vcustomername"]', function(event) {
    event.preventDefault();
    var name = $(this).val().toUpperCase();
    var new_name = name.substring(0, 3);
    var number = Math.floor(Math.random()*90000) + 10000;

    var ac_number = new_name+''+number;
    
    $('input[name="vaccountnumber"]').val(ac_number);
  });
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', 'input[name="vzip"],input[name="creditday"]' , function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 
  $(document).on('keypress keyup', 'input[name="debitlimit"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
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