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

        <div class="row" style="padding-bottom: 9px; float: right;">
          <div class="col-md-12">
            <div class="">
              <button id="save_button_group_slab_pricing" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
              <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default cancel_btn_rotate"><i class="fa fa-reply"></i>&nbsp;&nbsp;Cancel</a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <ul class="nav nav-tabs responsive" id="myTab">
          <li><a class="cancel_btn_rotate" href="<?php echo $group; ?>" style="color: #fff !important;background-color: #03A9F4;">General</a></li>
          <li class="active"><a href="<?php echo $group_slab_pricing; ?>" style="background-color: #f05a28;color: #fff !important;">Group Slab Pricing</a></li>
        </ul>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-group-slab-pricing" class="form-horizontal">
        <?php if(isset($igroupslabid)){?>
        <input type="hidden" name="igroupslabid" value="<?php echo $igroupslabid;?>">
        <?php } ?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_group_name; ?></label>
                <div class="col-sm-8">
                  <select name="iitemgroupid" id="iitemgroupid" class="form-control" required>
                    <option value="">--Please Select Group--</option>
                    <?php foreach($groups as $group){ ?>
                      <option value="<?php echo $group['iitemgroupid']; ?>" ><?php echo $group['vitemgroupname']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_slice_type; ?></label>
                <div class="col-sm-8" style="margin-top:8px;">
                  <input type='radio' name='slicetype' value='price' checked="checked">&nbsp;&nbsp;<?php echo $text_by_price; ?>&nbsp;&nbsp;
                  <input type='radio' name='slicetype' value='percentage' >&nbsp;&nbsp;<?php echo $text_by_percentage; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_qty; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="iqty" maxlength="11" value="" placeholder="<?php echo $text_qty; ?>" class="form-control iqty_class" required/>
                  <div id="iqty_validate"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="from_group_price">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_price; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="nprice" value="" placeholder="<?php echo $text_price; ?>" class="form-control nprice_class" />
                  <div id="nprice_validate"></div>
                </div>
                
              </div>
              <div class="form-group" id="from_group_percentage" style="display:none;border-top:none;">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_percentage; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="percentage" value="" placeholder="<?php echo $text_percentage; ?>" class="form-control percentage_class" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_unit_price; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="nunitprice" value="0.00" placeholder="<?php echo $text_unit_price; ?>" class="form-control nunitprice_class" readonly />
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template"><?php echo $text_status; ?></label>
                <div class="col-sm-8">
                  <select name="status" class="form-control">
                    <option value="1" selected="selected"><?php echo $Active;?></option>
                    <option value="0"><?php echo $Inactive;?></option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="input-template">Start Date</label>
                <div class="col-sm-8">
                  <input type="text" name="start_date" id="start_date" value="" placeholder="Start Date" class="form-control" style="width:45%;display:inline-block;"/>&nbsp;&nbsp;&nbsp;
                  <select name="start_time" class="form-control" style="width:48%;display:inline-block;">
                    <?php for($i=0;$i<=23;$i++){?>
                    <option value="<?php echo sprintf("%02d",$i) ;?>"><?php echo sprintf("%02d",$i) ;?></option>
                    <?php } ?>
                  </select>
                  <div id="start_date_validate"></div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="template">End Date</label>
                <div class="col-sm-8">
                  <input type="text" name="end_date" id="end_date" value="" placeholder="End Date" class="form-control" style="width:45%;display:inline-block;"/>&nbsp;&nbsp;&nbsp;
                  <select name="end_time" class="form-control" style="width:48%;display:inline-block;">
                    <?php for($i=0;$i<=23;$i++){?>
                    <option value="<?php echo sprintf("%02d",$i) ;?>"><?php echo sprintf("%02d",$i) ;?></option>
                    <?php } ?>
                  </select>
                  <div id="end_date_validate"></div>
                </div>
                
              </div>
            </div>
          </div>
 
        </form>
      </div>
    </div>
  </div>
  
</div>

<script src="view/javascript/bootbox.min.js" defer></script>

<script type="text/javascript">

$('input[name=slicetype]').on('change', function(event) {
   // alert($('input[name=radioName]:checked', '#myForm').val()); 
   event.preventDefault();

   if($('input[name=slicetype]:checked').val() == 'price'){
    $('#from_group_percentage').hide();
    $('#from_group_price').show();
   }else{
    $('#from_group_price').hide();
    $('#from_group_percentage').show();
   }
});

</script>

<link type="text/css" href="view/javascript/bootstrap-datepicker.css" rel="stylesheet" />
<script src="view/javascript/bootstrap-datepicker.js" defer></script>

<script type="text/javascript">
  $(function(){
    $("#start_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });

    $("#end_date").datepicker({
      format: 'mm-dd-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script type="text/javascript">

$(document).ready(function () {

    

});
  $(document).on('click', '#save_button_group_slab_pricing', function(event) {
    $('#form-group-slab-pricing').validate({ // initialize the plugin
        rules: {
            nprice: {
                required: true,
            },
            start_date: {
                required: true,
            },
            end_date: {
                required: true,
            },
        },
        messages: {
            nprice: "Price is Required",
            iqty: "Qty is Required",
            start_date: "Start Date is Required",
            end_date: "End Date is Required",
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_validate"));
        },
        
    });
    $('#start_date, #end_date').datepicker({
    autoclose: true,
    orientation: "bottom"
  }).on("hide",function(){
      $("#form-group-slab-pricing").data("validator").settings.ignore="";
      $(this).valid();
  }).on("focus",function(){
      $("#form-group-slab-pricing").data("validator").settings.ignore="#eventDate, :hidden";
  });
    if($('#iitemgroupid').val() == ''){
      // alert('please Select Group');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please Select Group", 
        callback: function(){}
      });
      return false;
    }else{
      $('form#form-group-slab-pricing').submit();
    //   $("div#divLoading").addClass('show');
    }
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

  $(document).on('keypress keyup', 'input[name="iqty"]', function(event) {
   
    var qty = $(this).val();
    var price = $('input[name="nprice"]').val();

    if(price != '' && qty != ''){
      var unitprice = price / qty;
      unitprice = unitprice.toFixed(2);
    }else{
      var unitprice = '0.00';
    }

    $('input[name="nunitprice"]').val(unitprice);

  });

  $(document).on('keypress keyup', 'input[name="nprice"]', function(event) {
   
    var qty = $('input[name="iqty"]').val();
    var price = $(this).val();

    if(price != '' && qty != ''){
      var unitprice = price / qty;
      unitprice = unitprice.toFixed(2);
    }else{
      var unitprice = '0.00';
    }

    $('input[name="nunitprice"]').val(unitprice);

  });

</script>

<style type="text/css">
  #myTab li:nth-child(2) a:hover{
    background-color: #f05a28 !important;
    color: #fff !important;
    cursor: pointer !important;
  }
     .error {
        color:red;
    }
    .valid {
        color:green;
    }
    
    

</style>
<?php echo $footer; ?>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>