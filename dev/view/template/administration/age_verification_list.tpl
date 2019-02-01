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
              <button type="button" onclick="addAgeVerification();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_age_verification_search">
        <input type="hidden" name="searchbox" id="Id">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Age Verification..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
          
        <form action="" method="post" enctype="multipart/form-data" id="form-age-verification">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="age-verification" class="text-center table table-bordered table-hover" style="width:50%;">
            <?php if ($age_verifications) { ?>
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td style="" class="text-left"><?php echo $column_description; ?></td>
                  <td class="text-right"><?php echo $column_value; ?></td>
                  <!-- <td class="text-center"><?php echo $column_action; ?></td> -->
                </tr>
              </thead>
              <tbody>
                
                <?php $age_verification_row = 1;$i=0; ?>
                <?php foreach ($age_verifications as $age_verification) { ?>
                <?php if($age_verification['Id'] == 100){ ?>
                  <tr id="age_verification-row<?php echo $age_verification_row; ?>">
                    <td data-order="<?php echo $age_verification['Id']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $age_verification['Id']; ?></span>
                    <input type="checkbox" name="" id="" value="" />
                    </td>
                    <td class="text-left">
                      <span style="display:none;"><?php echo $age_verification['vname']; ?></span>
                      <?php echo $age_verification['vname']; ?>
                    </td>
                    <td class="text-right">
                      <?php echo $age_verification['vvalue']; ?>
                    </td>
                  </tr>
                <?php }else{ ?>

                <tr id="age_verification-row<?php echo $age_verification_row; ?>">
                  <td class="text-center"><?php if (in_array($age_verification['Id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="age_verification[<?php echo $age_verification_row; ?>][select]" value="<?php echo $age_verification['Id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="age_verification[<?php echo $age_verification_row; ?>][select]"  value="<?php echo $age_verification['Id']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $age_verification['vname']; ?></span>
                  <input type="text" maxlength="50" class="editable age_verification_c" name="age_verification[<?php echo $i; ?>][vname]" id="age_verification[<?php echo $i; ?>][vname]" value="<?php echo $age_verification['vname']; ?>" onclick='document.getElementById("age_verification[<?php echo $age_verification_row; ?>][select]").setAttribute("checked","checked");' />
        				  <input type="hidden" name="age_verification[<?php echo $i; ?>][Id]" value="<?php echo $age_verification['Id']; ?>"/>
        				  </td>
                  
                    <td class="text-right"><input type="text" class="editable age_verification_s" maxlength="50" name="age_verification[<?php echo $i; ?>][vvalue]" id="age_verification[<?php echo $i; ?>][vvalue]" value="<?php echo $age_verification['vvalue']; ?>" onclick='document.getElementById("age_verification[<?php echo $age_verification_row; ?>][select]").setAttribute("checked","checked");' style="text-align: right;"/></td>
                  
                </tr>
                <?php } ?>
                <?php $age_verification_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                <?php if($filter_menuid!=""){ ?>
                
                <?php $age_verification_row++;$i++;}else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <?php if ($age_verifications) { ?>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script src="view/javascript/bootbox.min.js" defer></script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=administration/age_verification&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/age_verification&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var age_verification_row = <?php echo $age_verification_row; ?>;

function addAgeVerification() {
	
  $('#addModal').modal('show');
	
}

//--></script> 

<!-- Modal Add -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Age Verification</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="age_verification[0][Id]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Description</label>
                  </div>
                  <div class="col-md-10">  
                    <textarea name="age_verification[0][vname]" maxlength="50" id="add_vname" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Value</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" name="age_verification[0][vvalue]" id="add_vvalue" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12 text-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal Add-->

<script type="text/javascript">
  $(document).on('submit', 'form#add_new_form', function(event) {
    
    if($('form#add_new_form #add_vname').val() == ''){
      // alert('Please enter description!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter description!", 
        callback: function(){}
      });
      return false;
    }

    if($('form#add_new_form #add_vvalue').val() == ''){
      // alert('Please enter value!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter value!", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');
    
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();

    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');

    window.check_value_arr = [0];
    
    var all_age_verification = true;
    $('.age_verification_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Description');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Description!", 
          callback: function(){}
        });
        all_age_verification = false;
        return false;
      }else{
        all_age_verification = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;
    if(all_age_verification == true){
      var all_done = true;
      $('.age_verification_s').each(function(){
        if($(this).val() == ''){
          // alert('Please Enter Age');
          bootbox.alert({ 
            size: 'small',
            title: "Attention", 
            message: "Please Enter Age", 
            callback: function(){}
          });
          all_done = false;
          return false;
        }else{
          if(!numericReg.test($(this).val())){
            // alert('Please Enter Valid Age');
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter Valid Age", 
              callback: function(){}
            });
            all_done = false;
            return false;
          }else{

            if ($.inArray(parseInt($(this).val()), window.check_value_arr) != -1){
              bootbox.alert({ 
                size: 'small',
                title: "Attention", 
                message: "Age verification value must not be same!", 
                callback: function(){}
              });

              all_done = false;
              return false;
            }else{
              all_done = true;
              window.check_value_arr.push(parseInt($(this).val()));
            }
          }
        }
      });
    }else{
      all_done = false;
    }

    if(all_done == true){
      $('#form-age-verification').attr('action', edit_url);
      $('#form-age-verification').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<script type="text/javascript">
  $(document).on('keypress keyup blur', '.age_verification_s, #add_vvalue', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 
</script>
<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchage_verification;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vname,
                            value: val.vname,
                            id: val.Id
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_age_verification_search #Id').val(ui.item.id);
                
                if($('#Id').val() != ''){
                    $('#form_age_verification_search').submit();
                    $("div#divLoading").addClass('show');
                }
            }
        });
    });

    $(function() { $('input[name="automplete-product"]').focus(); });
</script>

<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>