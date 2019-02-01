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
        
        <form action="" method="post" enctype="multipart/form-data" id="form-tax">
          <div class="table-responsive">
            <table id="table_tax" class="table table-bordered table-hover" style="width:50%;">
              <thead>
                <tr>
                  <td style="" class="text-center">Tax 1</td>
                  <td class="text-center">Tax 2</td>
                </tr>
              </thead>
              <tbody>
              
                <?php if ($taxes) { ?>
                <tr>
                  <td class="text-left"><b>Name : </b>&nbsp;&nbsp;<input type="text" class="editable tax_name" name="vtaxtype1" id="" value="<?php echo $taxes[0]['vtaxtype']; ?>" /></td>
                  <td class="text-left"><b>Name : </b>&nbsp;&nbsp;<input type="text" class="editable tax_name" name="vtaxtype2" id="" value="<?php echo $taxes[1]['vtaxtype']; ?>" /></td>
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

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_tax_name = true;
    $('.tax_name').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Name');
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
          alert('Please Enter Rate');
          all_tax_rate = false;
          return false;
        }else{
          if(!numericReg.test($(this).val())){
            alert('Please Enter Valid Rate');
            all_tax_rate = false;
            return false;
          }else{
            all_tax_rate = true;
          }
        }
      });
    }else{
      all_tax_rate = false;
    }
    
    if(all_tax_rate == true){
      $('#form-tax').attr('action', edit_url);
      $('#form-tax').submit();
    }
  });
</script>
<?php echo $footer; ?>