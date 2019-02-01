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
            <button type="button" onclick="addCategory();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</button>        
            <button type="button" class="btn btn-danger" id="delete_category_btn" title="Delete" style="border-radius: 0px;"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</button>        
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_category_search">
        <input type="hidden" name="searchbox" id="icategoryid">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Category..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-category">
        <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="category" class="table table-bordered table-hover" style="width:60%;">
            <?php if ($categories) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th style="width:1px;" class="text-left"><?php echo $column_category_code; ?></th>
                  
                  <th style="width:1px;" class="text-left"><?php echo $column_category_name; ?></th>
                  <th class="text-left"><?php echo $column_description; ?></th>
                  <th class="text-left"><?php echo $column_category_type; ?></th>
                  <th class="text-left" style="display:none;"><?php echo $column_sequence; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $category_row = 1;$i=0; ?>
                <?php foreach ($categories as $category) { ?>
                <tr id="category-row<?php echo $category_row; ?>">
                  <td data-order="<?php echo $category['icategoryid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $category['icategoryid']; ?></span>
                  <?php if (in_array($category['icategoryid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $category_row; ?>][select]" value="<?php echo $category['icategoryid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="category[<?php echo $category_row; ?>][select]"  value="<?php echo $category['icategoryid']; ?>" />
                    <?php } ?>
                  </td>
                  
                  <td class="text-left">
                    <span style="display:none;"><?php echo $category['vcategorycode']; ?></span>
                    <input type="text" maxlength="50" class="editable categories_c" name="category[<?php echo $i; ?>][vcategorycode]" id="category[<?php echo $i; ?>][vcategorycode]" value="<?php echo $category['vcategorycode']; ?>" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");' />
        				    <input type="hidden" name="category[<?php echo $i; ?>][icategoryid]" value="<?php echo $category['icategoryid']; ?>"/>
        				  </td>
                  
                  <td class="text-left">
                    <span style="display:none;"><?php echo $category['vcategoryname']; ?></span>
                    <input type="text" maxlength="50" class="editable categories_c" name="category[<?php echo $i; ?>][vcategoryname]" id="category[<?php echo $i; ?>][vcategoryname]" value="<?php echo $category['vcategoryname']; ?>" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");' />
        				    <input type="hidden" name="category[<?php echo $i; ?>][icategoryid]" value="<?php echo $category['icategoryid']; ?>"/>
        				  </td>
                  <td class="text-left"><textarea maxlength="100" class="editable" name="category[<?php echo $i; ?>][vdescription]" id="category[<?php echo $i; ?>][vdescription]" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");'><?php echo $category['vdescription']; ?></textarea></td>
                  
                  <td class="text-left">
                  <select name="category[<?php echo $i; ?>][vcategorttype]" id="category[<?php echo $i; ?>][vcategorttype]" class="form-control" onchange='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");'>
                      <?php  if ($category['vcategorttype']==$Sales) { ?>
                      <option value="<?php echo $Sales; ?>" selected="selected"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" ><?php echo $MISC; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $Sales; ?>"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" selected="selected"><?php echo $MISC; ?></option>
                      <?php } ?>
                    </select></td>
                    <td class="text-left" style="display:none;"><input type="text" class="editable categories_s" name="category[<?php echo $i; ?>][isequence]" id="category[<?php echo $i; ?>][isequence]" value="<?php echo $category['isequence']; ?>" onclick='document.getElementById("category[<?php echo $category_row; ?>][select]").setAttribute("checked","checked");' /></td>
                </tr>
                <?php $category_row++; $i++;?>
                <?php } ?>
                <?php } else { ?>
                  <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <?php if ($categories) { ?>
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
	url = 'index.php?route=administration/category&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
});
function filterpage(){
	url = 'index.php?route=administration/category&token=<?php echo $token; ?>';
	
	var filter_menuid = $('select[name=\'MenuId\']').val();
	
	if (filter_menuid) {
		url += '&filter_menuid=' + encodeURIComponent(filter_menuid);
	}
	
	location = url;
}

//--></script> 
<script type="text/javascript"><!--
var category_row = <?php echo $category_row; ?>;

function addCategory() {
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
          <h4 class="modal-title">Add New Category</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo $edit_list; ?>" method="post" id="add_new_form">
            <input type="hidden" name="category[0][icategoryid]" value="0">
            <input type="hidden" name="category[0][isequence]" value="0">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Name</label>
                  </div>
                  <div class="col-md-10">  
                    <input type="text" maxlength="50" class="form-control" id="add_vcategoryname" name="category[0][vcategoryname]">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Description</label>
                  </div>
                  <div class="col-md-10">  
                    <textarea maxlength="100" name="category[0][vdescription]" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-2">
                    <label>Type</label>
                  </div>
                  <div class="col-md-10">  
                    <select name="category[0][vcategorttype]" id="" class="form-control ">
                      <option value="<?php echo $Sales; ?>" selected="selected"><?php echo $Sales; ?></option>
                      <option value="<?php echo $MISC; ?>" ><?php echo $MISC; ?></option>
                    </select>
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
    
    if($('form#add_new_form #add_vcategoryname').val() == ''){
      // alert('Please enter name!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter name!", 
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
    
    var all_category = true;
    
    $('.categories_c').each(function(){
      if($(this).val() == ''){
        // alert('Please Enter Category Name');
        bootbox.alert({ 
          size: 'small',
          title: "Attention", 
          message: "Please Enter Category Name", 
          callback: function(){}
        });
        all_category = false;
        return false;
      }else{
        all_category = true;
      }
    });

    var numericReg = /^[0-9]*(?:\.\d{1,2})?$/;

    if(all_category == true){
      var all_done = true;
      $('.categories_s').each(function(){
        if($(this).val() != ''){
          if(!numericReg.test($(this).val())){
            // alert('Please Enter Only Number');
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter Only Number", 
              callback: function(){}
            });
            all_done = false;
            return false;
          }else{
            all_done = true;
          }
        }
      });
    }else{
      all_done = false;
    }
    

    if(all_done == true){
      $('#form-category').attr('action', edit_url);
      $('#form-category').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchcategory;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vcategoryname,
                            value: val.vcategoryname,
                            id: val.icategoryid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_category_search #icategoryid').val(ui.item.id);
                
                if($('#icategoryid').val() != ''){
                    $('#form_category_search').submit();
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

<script type="text/javascript">
  $(document).on('click', '#delete_category_btn', function(event) {
    event.preventDefault();
    var delete_category_url = '<?php echo $delete; ?>';
    delete_category_url = delete_category_url.replace(/&amp;/g, '&');
    var data = {};

    if($("input[name='selected[]']:checked").length == 0){
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: 'Please Select Category to Delete!', 
        callback: function(){}
      });
      return false;
    }

    $("input[name='selected[]']:checked").each(function (i)
    {
      data[i] = parseInt($(this).val());
    });
    
    $("div#divLoading").addClass('show');

    $.ajax({
        url : delete_category_url,
        data : JSON.stringify(data),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
      success: function(data) {

        if(data.success){
          $('#success_msg').html('<strong>'+ data.success +'</strong>');
          $("div#divLoading").removeClass('show');
          $('#successModal').modal('show');

          setTimeout(function(){
           $('#successModal').modal('hide');
           window.location.reload();
          }, 3000);
        }else{

          $('#error_msg').html('<strong>'+ data.error +'</strong>');
          $("div#divLoading").removeClass('show');
          $('#errorModal').modal('show');

        }


      },
      error: function(xhr) { // if error occured
        var  response_error = $.parseJSON(xhr.responseText); //decode the response array
        
        var error_show = '';

        if(response_error.error){
          error_show = response_error.error;
        }else if(response_error.validation_error){
          error_show = response_error.validation_error[0];
        }

        $('#error_alias').html('<strong>'+ error_show +'</strong>');
        $('#errorModal').modal('show');
        return false;
      }
    });
  });
</script>

<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success text-center">
            <p id="success_msg"></p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="errorModal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger text-center">
            <p id="error_msg"></p>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
      </div>
      </div>
      
    </div>
  </div>