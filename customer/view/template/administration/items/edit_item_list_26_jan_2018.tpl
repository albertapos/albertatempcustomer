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
              <!-- <button title="Update" class="btn btn-primary" id="update_button"><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>       -->
              <button title="Update" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-save"></i>&nbsp;&nbsp;Edit multiple item</button>      
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="panel panel-default">
          <div class="panel-body">
            <form action="<?php echo $current_url;?>" method="post" id="form_item_search">
              <div class="row">
                  <div class="col-md-2" style="width:12%;">
                      <input type="radio" name="search_radio" value="category">&nbsp;&nbsp;<span style="margin-top:3px;postion:absolute;">Category</span>
                  </div>
                  <div class="col-md-2" style="width:12%;">
                      <input type="radio" name="search_radio" value="department">&nbsp;&nbsp;<span style="margin-top:3px;postion:absolute;">Department</span>
                  </div>
                  <div class="col-md-2" style="width:12%;">
                      <input type="radio" name="search_radio" value="item_group">&nbsp;&nbsp;<span style="margin-top:3px;postion:absolute;">Item Group</span>
                  </div>
                  <div class="col-md-2" style="width:12%;">
                      <input type="radio" name="search_radio" value="food_stamp">&nbsp;&nbsp;<span style="margin-top:3px;postion:absolute;">Food Stamp</span>
                  </div>
                  <div class="col-md-2" style="width:12%;">
                      <input type="radio" name="search_radio" value="search">&nbsp;&nbsp;<span style="margin-top:3px;postion:absolute;">Search</span>
                  </div>
              </div><br><br>
              <div class="row">
                  <div class="col-md-4" id="div_search_vcategorycode">
                    <span style="display:inline-block;width:20%;"><b>Category</b></span>&nbsp;&nbsp;<select name="search_vcategorycode" id="search_vcategorycode" class="form-control" style="display:inline-block;width:70%;">
                      <?php if(isset($categories) && count($categories) > 0){?>
                        <?php foreach($categories as $category){?>
                          <option value="<?php echo $category['vcategorycode']; ?>"><?php echo $category['vcategoryname']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4" id="div_search_vdepcode">
                    <span style="display:inline-block;width:25%;"><b>Department</b></span>&nbsp;&nbsp;<select name="search_vdepcode" id="search_vdepcode" class="form-control" style="display:inline-block;width:60%;">
                      <?php if(isset($departments) && count($departments) > 0){?>
                        <?php foreach($departments as $department){?>
                          <option value="<?php echo $department['vdepcode']; ?>"><?php echo $department['vdepartmentname']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4" id="div_search_vitem_group">
                    <span style="display:inline-block;width:25%;"><b>Item Group</b></span>&nbsp;&nbsp;<select name="search_vitem_group_id" id="search_vitem_group_id" class="form-control" style="display:inline-block;width:60%;">
                      <?php if(isset($itemGroups) && count($itemGroups) > 0){?>
                        <?php foreach($itemGroups as $itemGroup){ ?>
                          <option value="<?php echo $itemGroup['iitemgroupid'];?>"><?php echo $itemGroup['vitemgroupname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4" id="div_search_vfood_stamp">
                    <span style="display:inline-block;width:25%;"><b>Food Stamp</b></span>&nbsp;&nbsp;<select name="search_vfood_stamp" id="search_vfood_stamp" class="form-control" style="display:inline-block;width:60%;">
                        <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                          <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                            <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4" id="div_search_box">
                    <span style="display:inline-block;width:25%;"><b>Search Item</b></span>&nbsp;&nbsp;<input name="search_item" id="search_item" class="form-control" style="display:inline-block;width:60%;">
                  </div>
                  <div class="col-md-2">
                  <input type="submit" name="search_filter" value="Filter" class="btn btn-info">
                </div>
              </div>
            </form>
          </div>
        </div>        
        <br>
        
          <div class="table-responsive">
            <table id="item" class="table table-bordered table-hover">
            <?php if ($items) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" name="selected_items_id[]" value="" onclick="$('input[name*=\'selected_items_id\']').prop('checked', this.checked);" /></th>
                  <th class="text-left text-uppercase"><?php echo $column_sku; ?></th>
                  <th class="text-left text-uppercase"><?php echo $column_itemname; ?></th>
                  <th class="text-left text-uppercase"><?php echo $column_categorycode; ?></th>
                  <th class="text-left text-uppercase"><?php echo $column_deptcode; ?></th>
                  <th class="text-right text-uppercase">Cost</th>
                  <th class="text-right text-uppercase">Price</th>
                  <th class="text-left text-uppercase">Tax 1</th>
                  <th class="text-left text-uppercase">Tax 2</th>
                  <th class="text-left text-uppercase">Supplier Name</th>
                  <th class="text-left text-uppercase">Inventory Product</th>
                  <th class="text-right text-uppercase">QOH</th>
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($items as $item) { ?>
                  <tr>
                    <td data-order="<?php echo $item['iitemid']; ?>" class="text-center">
                      <?php if(isset($items_total_ids) && count($items_total_ids) > 0 && in_array($item['iitemid'], $items_total_ids)){?>
                        <input type="checkbox" name="selected_items_id[]" id=""  value="<?php echo $item['iitemid']; ?>" checked/>
                      <?php } else { ?>
                        <input type="checkbox" name="selected_items_id[]" id=""  value="<?php echo $item['iitemid']; ?>" />
                      <?php } ?>
                    
                    </td>
                    
                    <td class="text-left">
                      <span><?php echo $item['vbarcode']; ?></span>
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['VITEMNAME']; ?></span>
                    </td>

                    <td class="text-left">
                      <?php if(isset($categories) && count($categories) > 0){?>
                        <?php foreach($categories as $category){?>
                          <?php if($category['vcategorycode'] == $item['vcategorycode']){?>
                            <span><?php echo $category['vcategoryname']; ?></span>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </td>

                    <td class="text-left">
                      <?php if(isset($departments) && count($departments) > 0){?>
                        <?php foreach($departments as $department){?>
                          <?php if($department['vdepcode'] == $item['vdepcode']){?>
                            <span><?php echo $department['vdepartmentname']; ?></span>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </td>

                    <td class="text-right">
                      <span><?php echo $item['dcostprice']; ?></span>
                    </td>

                    <td class="text-right">
                      <span><?php echo $item['dunitprice']; ?></span>
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['vtax1'];?></span>
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['vtax2'];?></span>
                    </td>

                    <td class="text-left">
                      <?php if(isset($suppliers) && count($suppliers) > 0){?>
                        <?php foreach($suppliers as $supplier){?>
                          <?php if($supplier['vsuppliercode'] == $item['vsuppliercode']){?>
                            <span><?php echo $supplier['vcompanyname']; ?></span>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    </td>

                    <td class="text-left">
                      <span><?php echo $item['visinventory'];?></span>
                    </td>

                    <td class="text-right">
                      <span><?php echo $item['QOH'];?></span>
                    </td>
                  </tr>
    
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td colspan="7" class="text-center"><?php echo $text_no_results;?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>
<style type="text/css">
  .span_field span{
    display: inline-block;
  }
</style>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="view/javascript/bootbox.min.js" defer></script>
<script>

$(document).ready(function() {
  $('#div_search_vcategorycode').hide();
  $('#div_search_vdepcode').hide();
  $('#div_search_box').hide();
  $('#div_search_vitem_group').hide();
  $('#div_search_vfood_stamp').hide();

  <?php if(isset($search_radio) && $search_radio == 'category'){ ?>
    $('#div_search_vcategorycode').show();
    $("input[name=search_radio][value='category']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      $('#search_vcategorycode').val(search_find);
    <?php } ?>
  <?php }else if(isset($search_radio) && $search_radio == 'department'){ ?>
    $('#div_search_vdepcode').show();
    $("input[name=search_radio][value='department']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      $('#search_vdepcode').val(search_find);
    <?php } ?>
  <?php }else if(isset($search_radio) && $search_radio == 'item_group'){ ?>
    $('#div_search_vitem_group').show();
    $("input[name=search_radio][value='item_group']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      $('#search_vitem_group_id').val(search_find);
    <?php } ?>
  <?php }else if(isset($search_radio) && $search_radio == 'food_stamp'){ ?>
    $('#div_search_vfood_stamp').show();
    $("input[name=search_radio][value='food_stamp']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      console.log(search_find);
      $('#search_vfood_stamp').val(search_find);
    <?php } ?>
  <?php }else if(isset($search_radio) && $search_radio == 'search'){ ?>
    $('#div_search_box').show();
    $("input[name=search_radio][value='search']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      $('#search_item').val(search_find);
    <?php } ?>
  <?php }else{ ?>
    //$('#div_search_vcategorycode').show();
    //$("input[name=search_radio][value='category']").prop('checked', true);
  <?php } ?>

});

$(document).on('change', 'input:radio[name="search_radio"]', function(event) {
  event.preventDefault();
  if ($(this).is(':checked') && $(this).val() == 'category') {
      $('#div_search_vcategorycode').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vitem_group').hide();
      $('#div_search_vfood_stamp').hide();
      $('#div_search_box').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'department') {
      $('#div_search_vdepcode').show();
      $('#div_search_vcategorycode').hide();
      $('#div_search_vitem_group').hide();
      $('#div_search_vfood_stamp').hide();
      $('#div_search_box').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'item_group') {
      $('#div_search_vitem_group').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vcategorycode').hide();
      $('#div_search_vfood_stamp').hide();
      $('#div_search_box').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'food_stamp') {
      $('#div_search_vfood_stamp').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vcategorycode').hide();
      $('#div_search_vitem_group').hide();
      $('#div_search_box').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'search') {
      $('#div_search_box').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vitem_group').hide();
      $('#div_search_vfood_stamp').hide();
      $('#div_search_vcategorycode').hide();
  }else {
      $('#div_search_vcategorycode').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vitem_group').hide();
      $('#div_search_vfood_stamp').hide();
      $('#div_search_box').hide();
  }

}); 

 $('[data-target="#myModal"]').click(function(event) {
    var checked_items_val = [];
    $('input[name="selected_items_id[]"]:checked').each(function(i){
      checked_items_val[i] = $(this).val();
    });
    var checked_items_val_string = JSON.stringify(checked_items_val);

	$('input[name="items_id_array"]').val(checked_items_val);
    //$('input[name="items_id_array"]').val(checked_items_val_string);

  });

$(document).on('submit', 'form#form_item_update', function(event) {

  if($('input[name="update_dcostprice"]').val() == ''){
    // alert('Please enter cost!');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please enter cost!", 
      callback: function(){}
    });
    return false;
  }

  if($('input[name="update_dunitprice"]').val() == ''){
    // alert('Please enter price!');
    bootbox.alert({ 
      size: 'small',
      title: "Attention", 
      message: "Please enter price!", 
      callback: function(){}
    });
    return false;
  }
 
  if($('input[name="update_npack_checkbox"]').is(':checked')){
    if($('input[name="update_npack"]').val() == ''){
      // alert('Please enter pack!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please enter pack!", 
        callback: function(){}
      });
      return false;
    }
  }
  $("div#divLoading").addClass('show');
  // $('form#form_item_update').submit();
});

$(document).on('keypress keyup blur', 'input[name="update_dcostprice"],input[name="update_dunitprice"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
    
  });

  $(document).on('keypress keyup blur', 'input[name="update_npack"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  });

  $(document).on('keypress keyup blur', 'input[name="update_iqtyonhand"], input[name="update_norderqtyupto"],input[name="update_iqty"],input[name="update_ipack"],input[name="update_ireorderpoint"],input[name="update_isequence"]', function(event) {

    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 

  $(document).on('keypress keyup blur', 'input[name="update_dcostprice"],input[name="update_nlevel2"],input[name="update_nlevel3"],input[name="update_nlevel4"],input[name="update_dunitprice"],input[name="update_ndiscountper"],input[name="update_nprice"],input[name="update_npackprice"]', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });  

  $(document).on('submit', 'form#form_item_search', function(event) {
    if($('input:radio[name="search_radio"]').is(':checked') == false){
      // alert('Please select filter type!');
      bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please select filter type!", 
        callback: function(){}
      });
      return false;
    }

    $("div#divLoading").addClass('show');

  });
 </script>

 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?php echo $edit_list;?>" method="post" id="form_item_update">
        <input type="hidden" name="items_id_array" value=''>
        <input type="hidden" name="search_radio_btn" value="<?php echo isset($search_radio)? $search_radio: ''; ?>">
        <input type="hidden" name="search_find_btn" value="<?php echo isset($search_find)? $search_find: ''; ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Multiple Items</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-heading"><b>Product</b></div>
            <div class="panel-body">
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p>
                  <span style="width:22%;">Item Type:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vitemtype" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($item_types) && count($item_types) > 0){?>
                        <?php foreach($item_types as $item_type){ ?>
                          <option value="<?php echo $item_type;?>"><?php echo $item_type;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Category:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vcategorycode" id="update_vcategorycode" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($categories) && count($categories) > 0){?>
                        <?php foreach($categories as $category){?>
                          <option value="<?php echo $category['vcategorycode']; ?>"><?php echo $category['vcategoryname']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Unit:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vunitcode" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($units) && count($units) > 0){?>
                        <?php foreach($units as $unit){ ?>
                          <option value="<?php echo $unit['vunitcode'];?>"><?php echo $unit['vunitname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                <span style="width:22%;">Size:</span>&nbsp;&nbsp;
                <span style="width:70%;">
                    <select name="update_vsize" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($sizes) && count($sizes) > 0){?>
                        <?php foreach($sizes as $size){ ?>
                          <option value="<?php echo $size['vsize'];?>"><?php echo $size['vsize'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                <span style="width:22%;">Group:</span>&nbsp;&nbsp;
                <span style="width:70%;">
                    <select name="update_iitemgroupid" class="form-control">
                    <option value="no-update">-- No Update --</option>
                      <?php if(isset($itemGroups) && count($itemGroups) > 0){?>
                        <?php foreach($itemGroups as $itemGroup){ ?>
                          <option value="<?php echo $itemGroup['iitemgroupid'];?>"><?php echo $itemGroup['vitemgroupname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
              </div>
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p><span style="width:22%;">Department:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vdepcode" id="update_vdepcode" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($departments) && count($departments) > 0){?>
                        <?php foreach($departments as $department){?>
                          <option value="<?php echo $department['vdepcode']; ?>"><?php echo $department['vdepartmentname']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                <span style="width:22%;">Supplier:</span>&nbsp;&nbsp;
                <span style="width:70%;">
                    <select name="update_vsuppliercode" id="update_vsuppliercode" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($suppliers) && count($suppliers) > 0){?>
                        <?php foreach($suppliers as $supplier){ ?>
                          <option value="<?php echo $supplier['vsuppliercode'];?>"><?php echo $supplier['vcompanyname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                
                <p>
                  <span style="width:22%;">Tax1:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vtax1" id="update_vtax1" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                        <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                          <option value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Tax2:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vtax2" id="update_vtax2" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                        <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                          <option value="<?php echo $k;?>"><?php echo $k;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
              </div>
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p><span style="width:10%;">QOH:</span>&nbsp;&nbsp;<span style="width:40%;"><input type="text" name="update_iqtyonhand" value="0" class="form-control" disabled></span>&nbsp;&nbsp;<span style="width:45%;"><input type="checkbox" name="update_iqtyonhand" value="Y" disabled>&nbsp;Update Zero QOH</span></p>
                <p>
                  <span style="width:22%;">Aisle:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_aisleid" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($aisles) && count($aisles) > 0){?>
                        <?php foreach($aisles as $aisle){ ?>
                          <option value="<?php echo $aisle['Id'];?>"><?php echo $aisle['aislename'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Shelf:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_shelfid" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($shelfs) && count($shelfs) > 0){?>
                        <?php foreach($shelfs as $shelf){ ?>
                          <option value="<?php echo $shelf['Id'];?>"><?php echo $shelf['shelfname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Shelving:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_shelvingid" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($shelvings) && count($shelvings) > 0){?>
                        <?php foreach($shelvings as $shelving){ ?>
                          <option value="<?php echo $shelving['id'];?>"><?php echo $shelving['shelvingname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
              </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><b>Price</b></div>
            <div class="panel-body">
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p><span style="width:10%;">Pack:</span>&nbsp;&nbsp;<span style="width:40%;"><input type="text" name="update_npack" value="1" class="form-control"></span>&nbsp;&nbsp;<span style="width:45%;"><input type="checkbox" name="update_npack_checkbox" value="Y">&nbsp;Update Pack Qty</span></p>
                <p>
                  <span style="width:10%;">Cost:</span>&nbsp;&nbsp;<span style="width:40%;"><input type="text" name="update_dcostprice" value="0" class="form-control"></span>&nbsp;&nbsp;
                  <span style="width:42%;"><input type="checkbox" name="update_dcostprice_checkbox" value="Y">&nbsp;Update Zero Cost</span>
                </p>
                <p>
                  <input type="hidden" name="update_dcostprice_select" value="set as cost">
                  <input type="checkbox" value="Y" name="update_dcostprice_increment">&nbsp;&nbsp;increment cost
                <br>OR<br>
                  <input type="checkbox" value="Y" name="update_dcostprice_increment_percent">&nbsp;&nbsp;increment cost by %
                </p>
                
              </div>
              <div class="col-md-5 span_field" style="padding-left:0px;padding-right:0px;">
                <p><span style="width:20%;">Selling Unit:</span>&nbsp;&nbsp;<span style="width:30%;"><input type="text" name="update_nsellunit" value="1" class="form-control"></span>&nbsp;&nbsp;<span style="width:45%;"><input type="checkbox" name="update_nsellunit_checkbox" value="Y">&nbsp;Update Zero Unit</span></p>
                <p>
                  <span style="width:20%;">Price:</span>&nbsp;&nbsp;<span style="width:30%;"><input type="text" name="update_dunitprice" value="0" class="form-control"></span>&nbsp;&nbsp;
                  <span style="width:45%;"><input type="checkbox" name="update_dunitprice_checkbox" value="Y">&nbsp;Update Zero Price</span>
                </p>
                <p>
                  <span style="width:40%;">
                    <input type="hidden" name="update_dunitprice_select" value="set as price">
                    <input type="checkbox" value="Y" name="update_dunitprice_increment">&nbsp;&nbsp;increment price<br>OR<br>
                    <input type="checkbox" value="Y" name="update_dunitprice_increment_percent">&nbsp;&nbsp;increment price by %
                  </span>&nbsp;&nbsp;
                  <span style="width:20%;">Discount(%):</span>&nbsp;&nbsp;<span style="width:30%;"><input type="text" name="update_ndiscountper" value="" class="form-control"></span>
                </p>
              </div>
              <div class="col-md-3 span_field" style="padding-left:0px;padding-right:0px;">
                <p><span style="width:35%;">Level 2 Price:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_nlevel2" value="" class="form-control"></span></p>
                <p><span style="width:35%;">Level 3 Price:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_nlevel3" value="" class="form-control"></span></p>
                <p><span style="width:35%;">Level 4 Price:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_nlevel4" value="" class="form-control"></span></p>
              </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><b>General</b></div>
            <div class="panel-body">
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p>
                  <span style="width:22%;">Food Item:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                      <select name="update_vfooditem" id="update_vfooditem" class="form-control">
                        <option value="no-update">-- No Update --</option>
                        <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                          <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                            <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </span>
                  </p>
                <p>
                  <span style="width:22%;">WCI Item:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_wicitem" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Station:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_stationid" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($stations) && count($stations) > 0){?>
                        <?php foreach($stations as $station){ ?>
                          <option value="<?php echo $station['Id'];?>"><?php echo $station['stationname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Barcode Type:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vbarcodetype" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($barcode_types) && count($barcode_types) > 0){?>
                        <?php foreach($barcode_types as $barcode_type){ ?>
                          <option value="<?php echo $barcode_type;?>"><?php echo $barcode_type;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:22%;">Discount:</span>&nbsp;&nbsp;
                  <span style="width:70%;">
                    <select name="update_vdiscount" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
              </div>
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p>
                  <span style="width:30%;">Liability:</span>&nbsp;&nbsp;
                  <span style="width:60%;">
                    <select name="update_liability" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($array_yes_no) && count($array_yes_no) > 0){?>
                        <?php foreach($array_yes_no as $k => $array_y_n){ ?>
                          <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p><span style="width:31%;">Re-Order Point:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_ireorderpoint" value="" class="form-control"></span></p>
                <p><span style="width:31%;"></span>&nbsp;&nbsp;<span style="width:60%;"><span style="font-size: 10px;" class="text-small"><b>Enter Reorder Point in Unit.</b></span></span></p>
                <p><span style="width:31%;">Order Qty Upto:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_norderqtyupto" value="" class="form-control"></span></p>
                <p><span style="width:31%;"></span>&nbsp;&nbsp;<span style="width:60%;"><span style="font-size: 10px;" class="text-small"><b>Enter Order Qty Upto in Case.</b></span></span></p>
                <p><span style="width:31%;">Vintage:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_vintage" value="" class="form-control"></span></p>
              </div>
              <div class="col-md-4 span_field" style="padding-left:0px;padding-right:0px;">
                <p>
                  <span style="width:30%;">Inventory Item:</span>&nbsp;&nbsp;
                  <span style="width:60%;">
                    <select name="update_visinventory" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:30%;">Age Verification:</span>&nbsp;&nbsp;
                  <span style="width:60%;">
                    <select name="update_vageverify" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($ageVerifications) && count($ageVerifications) > 0){?>
                        <?php foreach($ageVerifications as $ageVerification){ ?>
                          <option value="<?php echo $ageVerification['vvalue'];?>"><?php echo $ageVerification['vname'];?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
                <p>
                  <span style="width:30%;">Bottle Deposit:</span>&nbsp;&nbsp;
                  <span style="width:60%;">
                    <input name="update_nbottledepositamt" value="" type="text" class="form-control">
                  </span>
                </p>
                <p><span style="width:30%;">Rating:</span>&nbsp;&nbsp;<span style="width:60%;"><input type="text" name="update_rating" value="" class="form-control"></span></p>
                <p>
                  <span style="width:30%;">Sales Item:</span>&nbsp;&nbsp;
                  <span style="width:60%;">
                    <select name="update_vshowsalesinzreport" class="form-control">
                      <option value="no-update">-- No Update --</option>
                      <?php if(isset($arr_y_n) && count($arr_y_n) > 0){?>
                        <?php foreach($arr_y_n as $k => $array_y_n){ ?>
                          <option value="<?php echo $array_y_n;?>"><?php echo $array_y_n;?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </span>
                </p>
              </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-info" value="Update">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    // $('input[name="selected_items_id[]"]').prop( 'checked', true );
  });

  $(document).on('change', 'input[name="selected_items_id[]"]', function(event) {
    event.preventDefault();
    var main_arr = {};
    var add_items_id = {};
    var remove_items_id = {};

    $("input[name='selected_items_id[]']").each(function (i){
      if($(this).val() != ''){
        if($(this).is(":checked")){
          add_items_id[i] = parseInt($(this).val());
        }else{
          remove_items_id[i] = parseInt($(this).val());
        }
      }
    });

    main_arr.add = add_items_id;
    main_arr.remove = remove_items_id;

      var add_remove_ids_url = '<?php echo $add_remove_ids_url; ?>';
      add_remove_ids_url = add_remove_ids_url.replace(/&amp;/g, '&');

      $.ajax({
        url : add_remove_ids_url,
        data : JSON.stringify(main_arr),
        type : 'POST',
        contentType: "application/json",
        dataType: 'json',
        success: function(data) {
        },
        error: function(xhr) { // if error occured
        }
      });


  });

  $(document).on('click', '#cancel_button, .breadcrumb li a, #header > li:not(:eq(0)) > a, #mySidenavStore > div.side_content_div > div.side_inner_content_div > p:not(:eq(0)), #mySidenavReports > div.side_content_div > div.side_inner_content_div > p:not(:eq(0))', function() {

    var unset_session_value_url = '<?php echo $unset_session_value; ?>';
    unset_session_value_url = unset_session_value_url.replace(/&amp;/g, '&');

    $.getJSON(unset_session_value_url, function(datas) {
    });
  });

  $(document).on('click', '#menu li a', function(event) {
    if (!$(this).hasClass("parent")) {
      var unset_session_value_url = '<?php echo $unset_session_value; ?>';
      unset_session_value_url = unset_session_value_url.replace(/&amp;/g, '&');

      $.getJSON(unset_session_value_url, function(datas) {
    });
    }
  });
</script>

<script type="text/javascript">
  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">
  $(document).on('click', 'input[name="update_dcostprice_increment"],input[name="update_dcostprice_increment_percent"]', function(event) {
    //event.preventDefault();

    if($('input[name="update_dcostprice_increment"]').is(':checked') && $('input[name="update_dcostprice_increment_percent"]').is(':checked')){
        bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please check only one!", 
        callback: function(){}
      });
      return false;
    }
    
  });

  $(document).on('click', 'input[name="update_dunitprice_increment"],input[name="update_dunitprice_increment_percent"]', function(event) {
    //event.preventDefault();

    if($('input[name="update_dunitprice_increment"]').is(':checked') && $('input[name="update_dunitprice_increment_percent"]').is(':checked')){
        bootbox.alert({ 
        size: 'small',
        title: "Attention", 
        message: "Please check only one!", 
        callback: function(){}
      });
      return false;
    }
    
  });
</script>