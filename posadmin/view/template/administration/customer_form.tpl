<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-customer" class="form-horizontal">
        <input type="hidden" name="estatus" value="Active">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcustomername" value="<?php echo isset($vcustomername) ? $vcustomername : ''; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer<?php echo $entry_customer; ?>" class="form-control" />

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
                  <input type="text" name="vaccountnumber" value="<?php echo isset($vaccountnumber) ? $vaccountnumber : ''; ?>" placeholder="<?php echo $entry_account_number; ?>" id="input-account-number<?php echo $entry_account_number; ?>" class="form-control" readonly/>

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
                  <input type="text" name="vfname" value="<?php echo isset($vfname) ? $vfname : ''; ?>" placeholder="<?php echo $entry_first_name; ?>" id="input-first-name<?php echo $entry_first_name; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-last-name"><?php echo $entry_last_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vlname" value="<?php echo isset($vlname) ? $vlname : ''; ?>" placeholder="<?php echo $entry_last_name; ?>" id="input-last-name<?php echo $entry_last_name; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-address"><?php echo $entry_address; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress1" value="<?php echo isset($vaddress1) ? $vaddress1 : ''; ?>" placeholder="<?php echo $entry_address; ?>" id="input-address<?php echo $entry_address; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-city"><?php echo $entry_city; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcity" value="<?php echo isset($vcity) ? $vcity : ''; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city<?php echo $entry_city; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-state"><?php echo $entry_state; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstate" value="<?php echo isset($vstate) ? $vstate : ''; ?>" placeholder="<?php echo $entry_state; ?>" id="input-state<?php echo $entry_state; ?>" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-zip"><?php echo $entry_zip; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vzip" value="<?php echo isset($vzip) ? $vzip : ''; ?>" placeholder="<?php echo $entry_zip; ?>" id="input-zip<?php echo $entry_zip; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-country"><?php echo $entry_country; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcountry" value="USA" class="form-control" readonly />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vphone" value="<?php echo isset($vphone) ? $vphone : ''; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone<?php echo $entry_phone; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-8">
                  <input type="email" name="vemail" value="<?php echo isset($vemail) ? $vemail : ''; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email<?php echo $entry_email; ?>" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
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
<?php echo $footer; ?>