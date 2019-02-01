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
              <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

      <form action="<?php echo $current_url;?>" method="post" id="form_customer_search">
        <div class="row">
            <div class="col-md-11">
                <input type="text" name="searchbox" class="form-control" placeholder="Search Customer..." >
            </div>
            <div class="col-md-1">
                <input type="submit" class="btn btn-info add_new_btn_rotate" value="search" style="float: right;">
            </div>
        </div>
      </form>
       <br>
        
        <form action="" method="post" enctype="multipart/form-data" id="form-customer">
          <input type="hidden" name="MenuId" value="<?php echo $filter_menuid; ?>"/>
          <div class="table-responsive">
            <table id="customer" class="table table-bordered table-hover">
            <?php if ($customers) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-left"><?php echo $column_customer; ?></th>
                  <th class="text-left"><?php echo $column_first_name; ?></th>
                  <th class="text-left"><?php echo $column_last_name; ?></th>
                  <th class="text-right"><?php echo $column_phone; ?></th>
                  <th class="text-left"><?php echo $column_account_number; ?></th>
                  <th class="text-left"><?php echo $column_status; ?></th>
                  <th class="text-left"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $customer_row = 1;$i=0; ?>
                <?php foreach ($customers as $customer) { ?>
                <tr id="customer-row<?php echo $customer_row; ?>">
                  <td data-order="<?php echo $customer['icustomerid']; ?>" class="text-center">
                  <input type="checkbox" name="selected[]" id=""  value="" />
                  </td>
                  
                  <td class="text-left">
                    <span><?php echo $customer['vcustomername']; ?></span>
        				  </td>
                  
                  <td class="text-left">
                    <span><?php echo $customer['vfname']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $customer['vlname']; ?></span>
                  </td>
                  
                  <td class="text-right">
                    <span><?php echo $customer['vphone']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $customer['vaccountnumber']; ?></span>
                  </td>
                  
                  <td class="text-left">
                    <select name="customer[<?php echo $i; ?>][estatus]" id="" class="form-control" disabled>
                      <?php  if ($customer['estatus']==$Active) { ?>
                      <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                      <option value="<?php echo $Inactive; ?>" ><?php echo $Inactive; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $Inactive; ?>"><?php echo $Inactive; ?></option>
                      <option value="<?php echo $Active; ?>" selected="selected"><?php echo $Active; ?></option>
                      <?php } ?>
                    </select>
                  </td>

                  <td class="text-left">
                    <a href="<?php echo $customer['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a>
                  </td>
                </tr>
                <?php $customer_row++; $i++;?>
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
        alert('Please Enter Category Name');
        all_vendor = false;
        return false;
      }else{
        all_vendor = true;
      }
    });
    
    if(all_vendor == true){
      $('#form-vendor').attr('action', edit_url);
      $('#form-vendor').submit();
    }
  });

  $(function() { $('input[name="searchbox"]').focus(); });
</script>

<?php echo $footer; ?>
<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>