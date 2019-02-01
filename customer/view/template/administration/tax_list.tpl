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
        
        <form action="" method="post" enctype="multipart/form-data" id="form-tax">
          <div class="table-responsive">
            <table id="table_tax" class="table table-bordered table-hover" style="width:50%;">
            <?php if ($taxes) { ?>
              <thead>
                <tr>
                  <td style="" class="text-left">Tax 1</td>
                  <td class="text-left">Tax 2</td>
                </tr>
              </thead>
              <tbody>
              
                
                <tr>
                  <td class="text-left"><b>Name : </b>&nbsp;&nbsp;<input type="text" class="editable tax_name" name="vtaxtype1" maxlength="50" id="" value="<?php echo $taxes[0]['vtaxtype']; ?>" /></td>
                  <td class="text-left"><b>Name : </b>&nbsp;&nbsp;<input type="text" class="editable tax_name" name="vtaxtype2" maxlength="50" id="" value="<?php echo $taxes[1]['vtaxtype']; ?>" /></td>
                </tr>
                <tr>
                  <td class="text-left"><b>Rate&nbsp;&nbsp; : </b>&nbsp;&nbsp;<input type="text" class="editable tax_rate" name="ntaxrate1" id="" value="<?php echo $taxes[0]['ntaxrate']; ?>" /></td>
                  <td class="text-left"><b>Rate&nbsp;&nbsp; : </b>&nbsp;&nbsp;<input type="text" class="editable tax_rate" name="ntaxrate2" id="" value="<?php echo $taxes[1]['ntaxrate']; ?>" /></td>
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

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_tax_name = true;
    $('.tax_name').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Name", 
          callback: function(){}
        });
        all_tax_name = false;
        return false;
      }else{
        all_tax_name = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;
    if(all_tax_name == true){
      var all_tax_rate = true;
      $('.tax_rate').each(function(){
        if($(this).val() == ''){
          // alert('Please Enter Rate');
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: "Please Enter Rate", 
            callback: function(){}
          });
          all_tax_rate = false;
          return false;
        }
        // }else{
        //   if(numericReg.test($(this).val())){
        //     // alert('Please Enter Valid Rate');
        //     bootbox.alert({ 
        //       size: 'small',
        //       title: "Attention", 
        //       message: "Please Enter Valid Rate", 
        //       callback: function(){}
        //     });
        //     all_tax_rate = false;
        //     return false;
        //   }else{
        //     all_tax_rate = true;
        //   }
        // }
      });
    }else{
      all_tax_rate = false;
    }
    
    if(all_tax_rate == true){
      $('#form-tax').attr('action', edit_url);
      $('#form-tax').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<script type="text/javascript">
  
  $(document).on('keypress keyup blur', 'input[name="ntaxrate1"], input[name="ntaxrate2"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  }); 

  $(document).on('focusout', 'input[name="ntaxrate1"], input[name="ntaxrate2"]', function(event) {
    event.preventDefault();

    if($(this).val() != ''){
      if($(this).val().indexOf('.') == -1){
        var new_val = $(this).val();
        $(this).val(new_val+'.0000');
      }else{
        var new_val = $(this).val();
        if(new_val.split('.')[1].length == 0){
          $(this).val(new_val+'0000');
        }
      }
    }
  });   
</script>
<?php echo $footer; ?>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>