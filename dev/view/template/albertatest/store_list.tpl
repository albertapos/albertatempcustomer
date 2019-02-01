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
    <div class="panel panel-default" style="">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Store Information </h3>
        <div class="top_button">
          <button type="submit" form="form-store" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
        </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo $edit_list; ?>" method="post" enctype="multipart/form-data" id="form-store" class="form-horizontal">
        <input type="hidden" name="estatus" value="Active">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vcompanycode; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcompanycode" maxlength="20" value="" placeholder="<?php echo $text_vcompanycode; ?>" id="input-vcompanycode" class="form-control" readonly />
                  <input type="hidden" name="istoreid" value="" id="input-istoreid" />

                  <?php if ($error_vcompanycode) { ?>
                    <div class="text-danger"><?php echo $error_vcompanycode; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vstorename; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstorename" maxlength="40" value="" placeholder="<?php echo $text_vstorename; ?>" id="input-vstorename" class="form-control" />

                  <?php if ($error_vstorename) { ?>
                    <div class="text-danger"><?php echo $error_vstorename; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vstoreabbr; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstoreabbr" maxlength="50" value="" placeholder="<?php echo $text_vstoreabbr; ?>" id="input-vstoreabbr" class="form-control" />

                  <?php if ($error_vstoreabbr) { ?>
                    <div class="text-danger"><?php echo $error_vstoreabbr; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vaddress1; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vaddress1" maxlength="100" value="" placeholder="<?php echo $text_vaddress1; ?>" id="input-vaddress1" class="form-control" />

                  <?php if ($error_vaddress1) { ?>
                    <div class="text-danger"><?php echo $error_vaddress1; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vstoredesc; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstoredesc" maxlength="100" value="" placeholder="<?php echo $text_vstoredesc; ?>" id="input-vstoredesc" class="form-control" />

                  <?php if ($error_vstoredesc) { ?>
                    <div class="text-danger"><?php echo $error_vstoredesc; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vcity; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcity" maxlength="20" value="" placeholder="<?php echo $text_vcity; ?>" id="input-vcity" class="form-control" />

                  <?php if ($error_vcity) { ?>
                    <div class="text-danger"><?php echo $error_vcity; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vstate; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vstate" maxlength="20" value="" placeholder="<?php echo $text_vstate; ?>" id="input-vstate" class="form-control" />
  
                    <?php if ($error_vstate) { ?>
                      <div class="text-danger"><?php echo $error_vstate; ?></div>
                    <?php } ?>

                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vzip; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vzip" maxlength="10" value="" placeholder="<?php echo $text_vzip; ?>" id="input-vzip" class="form-control" />

                  <?php if ($error_vzip) { ?>
                    <div class="text-danger"><?php echo $error_vzip; ?></div>
                  <?php } ?>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vcountry; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcountry" maxlength="20" value="USA" placeholder="<?php echo $text_vcountry; ?>" id="input-vcountry" class="form-control" readonly/>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group required">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vphone1; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vphone1" maxlength="20" value="" placeholder="<?php echo $text_vphone1; ?>" id="input-vphone1" class="form-control" />

                  <?php if ($error_vphone1) { ?>
                    <div class="text-danger"><?php echo $error_vphone1; ?></div>
                  <?php } ?>
                  
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vphone2; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vphone2" maxlength="20" placeholder="<?php echo $text_vphone2; ?>" id="input-vphone2" class="form-control"/>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vfax1; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vfax1" maxlength="20" value="" placeholder="<?php echo $text_vfax1; ?>" id="input-vfax1" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vemail; ?></label>
                <div class="col-sm-8">
                  <input type="email" name="vemail" maxlength="30" placeholder="<?php echo $text_vemail; ?>" id="input-vemail" class="form-control"/>
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
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vwebsite; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vwebsite" maxlength="100" value="" placeholder="<?php echo $text_vwebsite; ?>" id="input-vwebsite" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vcontactperson; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vcontactperson" maxlength="25" placeholder="<?php echo $text_vcontactperson; ?>" id="input-vcontactperson" class="form-control"/>
                </div>
              </div>
            </div>
          </div>

          <div class="row" style="display: none;">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_isequence; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="isequence" value="" placeholder="<?php echo $text_isequence; ?>" id="input-isequence" class="form-control" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vmessage1; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vmessage1" maxlength="500" value="" placeholder="<?php echo $text_vmessage1; ?>" id="input-vmessage1" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-customer"><?php echo $text_vmessage2; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="vmessage2" maxlength="500" value="" placeholder="<?php echo $text_vmessage2; ?>" id="input-vmessage2" class="form-control" />
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
  $(document).ready(function($) {

    $("div#divLoading").addClass('show');

    var token = "<?php echo $token;?>";
    var sid = "<?php echo $sid;?>";
    
    $.getJSON("/index.php?route=api/store&token="+token+"&sid="+sid, function(data) {

      $('form#form-store #input-istoreid').val(data.istoreid);
      $('form#form-store #input-vcompanycode').val(data.vcompanycode);
      if(data.vstorename && data.vstorename !=''){
        $('form#form-store #input-vstorename').val(data.vstorename.replace(/&amp;/g, '&'));
      }else{
        $('form#form-store #input-vstorename').val(data.vstorename);
      }

      if(data.vstoreabbr && data.vstoreabbr != ''){
        $('form#form-store #input-vstoreabbr').val(data.vstoreabbr.replace(/&amp;/g, '&'));
      }else{
        $('form#form-store #input-vstoreabbr').val(data.vstoreabbr);
      }

      if(data.vaddress1 && data.vaddress1 != ''){
        $('form#form-store #input-vaddress1').val(data.vaddress1.replace(/&amp;/g, '&'));
      }else{
        $('form#form-store #input-vaddress1').val(data.vaddress1);
      }

      if(data.vstoredesc && data.vstoredesc != ''){
        $('form#form-store #input-vstoredesc').val(data.vstoredesc.replace(/&amp;/g, '&'));
      }else{
        $('form#form-store #input-vstoredesc').val(data.vstoredesc);
      }
      
      $('form#form-store #input-vcity').val(data.vcity);
      $('form#form-store #input-vstate').val(data.vstate);
      $('form#form-store #input-vzip').val(data.vzip);
      $('form#form-store #input-vcountry').val(data.vcountry);
      $('form#form-store #input-vphone1').val(data.vphone1);
      $('form#form-store #input-vphone2').val(data.vphone2);
      $('form#form-store #input-vfax1').val(data.vfax1);
      $('form#form-store #input-vemail').val(data.vemail);
      $('form#form-store #input-vwebsite').val(data.vwebsite);
      $('form#form-store #input-vcontactperson').val(data.vcontactperson);
      $('form#form-store #input-isequence').val(data.isequence);

      if(data.vmessage1 && data.vmessage1 != ''){
        $('form#form-store #input-vmessage1').val(data.vmessage1.replace(/&amp;/g, '&'));
      }else{
        $('form#form-store #input-vmessage1').val(data.vmessage1);
      }

    });

    $("div#divLoading").removeClass('show');
  });

  $(document).on('keypress keyup blur', 'input[name="vzip"],input[name="isequence"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

</script>

<script src="view/javascript/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $("input[name='vphone1'],input[name='vphone2']").mask("999-999-9999");
  });
</script>

<?php echo $footer; ?>