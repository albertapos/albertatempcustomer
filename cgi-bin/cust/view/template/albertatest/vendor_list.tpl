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

        <div class="row" style="padding-bottom: 9px;float: right;">
          <div class="col-md-12">
            <div class="">
              <a id="save_button" class="btn btn-primary" title="Save"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</a>
              <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>   
            </div>
          </div>
        </div>

      <form action="<?php echo $current_url;?>" method="post" id="form_vendor_search">
        <input type="hidden" name="searchbox" id="vendor_name">
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="automplete-product" class="form-control" placeholder="Search Vendor..." id="automplete-product">
            </div>
        </div>
      </form>
       <br>
        <form action="" method="post" enctype="multipart/form-data" id="form-vendor">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="vendor" class="table table-bordered table-hover">
            <?php if ($vendors) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_vendor_code; ?></th>
                  <th class="text-left"><?php echo $column_vendor_name; ?></th>
                  <th class="text-right"><?php echo $column_phone; ?></th>
                  <th class="text-left"><?php echo $column_email; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $vendor_row = 1;$i=0; ?>
                <?php foreach ($vendors as $vendor) { ?>
                <tr id="vendor-row<?php echo $vendor_row; ?>">
                  <td data-order="<?php echo $vendor['isupplierid']; ?>" class="text-center">
                  <span style="display:none;"><?php echo $vendor['isupplierid']; ?></span>
                  <?php if (in_array($vendor['isupplierid'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" id="vendor[<?php echo $vendor_row; ?>][select]" value="<?php echo $vendor['isupplierid']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" id="vendor[<?php echo $vendor_row; ?>][select]"  value="<?php echo $vendor['isupplierid']; ?>" />
                    <?php } ?></td>
                  
                  <td class="text-left">
                  <span style=""><?php echo $vendor['vcode']; ?></span>
                    <!-- <input type="text" class="editable" maxlength="20" name="vendor[<?php echo $i; ?>][vcode]" id="vendor[<?php echo $i; ?>][vcode]" value="<?php echo $vendor['vcode']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' /> -->
                    <input type="hidden" name="vendor[<?php echo $i; ?>][vcode]" value="<?php echo $vendor['vcode']; ?>"/>
          				  <input type="hidden" name="vendor[<?php echo $i; ?>][isupplierid]" value="<?php echo $vendor['isupplierid']; ?>"/>
        				  </td>
                  
                  <td class="text-left">
                  <span style="display:none;"><?php echo $vendor['vcompanyname']; ?></span>
                    <input type="text" class="editable vendors_c" maxlength="50" name="vendor[<?php echo $i; ?>][vcompanyname]" id="vendor[<?php echo $i; ?>][vcompanyname]" value="<?php echo $vendor['vcompanyname']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
                  </td>

                  <td class="text-right">
                    <input type="text" class="editable vendors_phone" maxlength="20" name="vendor[<?php echo $i; ?>][vphone]" id="vendor[<?php echo $i; ?>][vphone]" value="<?php echo $vendor['vphone']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' style="text-align: right;"/>
                  </td>

                  <td class="text-left">
                  <span style="display:none;"><?php echo $vendor['vemail']; ?></span>
                    <input type="email" class="editable vendors_email" maxlength="100" name="vendor[<?php echo $i; ?>][vemail]" id="vendor[<?php echo $i; ?>][vemail]" value="<?php echo $vendor['vemail']; ?>" onclick='document.getElementById("vendor[<?php echo $vendor_row; ?>][select]").setAttribute("checked","checked");' />
                  </td>

                  <td class="text-left">
                    <?php echo $vendor['estatus']; ?>
                  </td>

                  <td class="text-left">
                    <a href="<?php echo $vendor['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                    </a>
                  </td>
                </tr>
                <?php $vendor_row++; $i++;?>
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
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click', '#save_button', function(event) {
    event.preventDefault();
    var edit_url = '<?php echo $edit_list; ?>';
    
    edit_url = edit_url.replace(/&amp;/g, '&');
    
    var all_vendor = true;
    
    $('.vendors_c').each(function(){
      if($(this).val() == ''){
        alert('Please Enter Vendor Name');
        all_vendor = false;
        return false;
      }else{
        all_vendor = true;
      }
    });

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    $('.vendors_email').each(function(){
      if($(this).val() != ''){
        if (!emailReg.test($(this).val())) {
          alert('Please Enter Valid Email');
          all_vendor = false;
          return false;
        }else{
          all_vendor = true;
        }
      }
    });
    
    if(all_vendor == true){
      $('#form-vendor').attr('action', edit_url);
      $('#form-vendor').submit();
      $("div#divLoading").addClass('show');
    }
  });
</script>

<script src="view/javascript/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
  jQuery(function($){
    $(".vendors_phone").mask("999-999-9999");
  });
</script>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchvendor;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vcompanyname,
                            value: val.vcompanyname,
                            id: val.isupplierid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_vendor_search #vendor_name').val(ui.item.value);
                
                if($('#vendor_name').val() != ''){
                    $('#form_vendor_search').submit();
                }
            }
        });
    });

  $(function() { $('input[name="automplete-product"]').focus(); });
</script>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>