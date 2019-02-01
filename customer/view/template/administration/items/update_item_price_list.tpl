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
              <div style="display: inline-block;">
                <input type="checkbox" name="show_cost_price" value="show_cost_price" style="border: 1px solid #A9A9A9;">&nbsp;&nbsp;<span>Show Unit Cost</span>
                </div>
                <div style="display: inline-block;">
                <select class="form-control" name="item_type">
                  <?php if(isset($item_types)){?>
                    <?php foreach($item_types as $item_type){?>
                      <?php if(isset($search_item_type) && $search_item_type == $item_type){?>
                        <option value="<?php echo $item_type;?>" selected="selected"><?php echo $item_type;?></option>
                      <?php }else {?>
                        <option value="<?php echo $item_type;?>"><?php echo $item_type;?></option>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>
                </select>
                </div>
                <div style="display: inline-block;">
                <button title="Update" class="btn btn-primary" id="update_button"><i class="fa fa-save"></i>&nbsp;&nbsp;Update</button>      
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          
          
          <!-- Category and Department Filter  -->
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
            <!--<form action="<?php echo $current_url;?>" method="post" id="form_item_search">
              <div class="row">
                <div class="col-md-12" id="div_search_box">
                  <input type="hidden" name="search_item" id="item_name">
                    <input type="text" name="automplete-product" id="automplete-product" class="form-control" placeholder="Search Item...">
                </div>
              </div>
            </form>-->
        
        
          <div class="table-responsive">
            <form action="<?php echo $edit_list;?>" method="post" id="form_item_price_update">
              <input type="hidden" name="search_item_type" value="<?php echo $search_item_type;?>">
              <table id="item" class="table table-bordered table-hover">
              <?php if ($items) { ?>
                <thead>
                  <tr>
                    <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                    <th class="text-left text-uppercase"><?php echo $column_sku; ?></th>
                    <th class="text-left text-uppercase">Item</th>
                    <th class="text-left text-uppercase">Unit</th>
                    <th class="text-left text-uppercase"><?php echo $column_categorycode; ?></th>
                    <th class="text-left text-uppercase">Department</th>
                    <!--<th class="text-right text-uppercase" id="th_cost_price">Cost Price</th>-->
                    <th class="text-right text-uppercase" id="th_cost_price">Unit Cost</th>
                    <th class="text-right text-uppercase" style="width:10%;">Unit Price</th>
                    <th class="text-left text-uppercase">Tax 1</th>
                    <th class="text-left text-uppercase">Tax 2</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php foreach ($items as $i => $item) { ?>
                    <tr>
                      <td data-order="<?php echo $item['iitemid']; ?>" class="text-center">
                      <input type="checkbox" name="selected[]" id="items[<?php echo $i; ?>][select]"  value="<?php echo $item['iitemid']; ?>" />
                      <input type="hidden"  name="items[<?php echo $i; ?>][iitemid]" value="<?php echo $item['iitemid']; ?>">
                      </td>
                      
                      <td class="text-left">
                        <span><?php echo $item['vbarcode']; ?></span>
                      </td>

                      <td class="text-left">
                        <span><?php echo $item['VITEMNAME']; ?></span>
                      </td>

                      <td class="text-left">
                        <span><?php echo $item['vunitname']; ?></span>
                      </td>

                      <td class="text-left">
                        <!-- <span><?php echo $item['vcategoryname']; ?></span> -->
                        <select name="items[<?php echo $i; ?>][vcategoryname]" class="editable form-control" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;">
                            <option value="">--Select Category--</option>
                              <?php if(isset($categories) && count($categories) > 0){?>
                                <?php foreach($categories as $category){ ?>
                                <?php if(isset($item['vcategorycode']) && $item['vcategorycode'] == $category['vcategorycode']){ ?>
                                  <option value="<?php echo $category['vcategorycode'];?>" selected="selected"><?php echo $category['vcategoryname'];?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $category['vcategorycode'];?>"><?php echo $category['vcategoryname'];?></option>
                                <?php } ?>
                                <?php } ?>
                              <?php } ?>
                        </select>
                      </td>

                      <td class="text-left">
                        <!-- <span><?php echo $item['vdepartmentname']; ?></span> -->
                        <select name="items[<?php echo $i; ?>][vdepartmentname]" class="editable form-control" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;">
                            <option value="">--Select Department--</option>
                              <?php if(isset($departments) && count($departments) > 0){?>
                                <?php foreach($departments as $department){ ?>
                                <?php if(isset($item['vdepcode']) && $item['vdepcode'] == $department['vdepcode']){?>
                                  <option value="<?php echo $department['vdepcode'];?>" selected="selected"><?php echo $department['vdepartmentname'];?></option>
                                <?php } else { ?>
                                  <option value="<?php echo $department['vdepcode'];?>"><?php echo $department['vdepartmentname'];?></option>
                                <?php } ?>
                                <?php } ?>
                              <?php } ?>
                        </select>
                      </td>

                      <!--<td class="text-right td_cost_price" style="width:10%;">
                        <input type="text" class="editable class_costprice" name="items[<?php echo $i; ?>][dcostprice]" value="<?php echo $item['dcostprice']; ?>" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;" />
                      </td>-->
                      
                      <td class="text-right td_cost_price" style="width:10%;">
                        <input type="text" class="editable class_unitcost" name="items[<?php echo $i; ?>][nunitcost]" value="<?php echo $item['nunitcost']; ?>" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;" />
                      </td>

                      <td class="text-right" style="width:10%;">
                        <input type="text" class="editable class_unitprice" name="items[<?php echo $i; ?>][dunitprice]" value="<?php echo $item['dunitprice']; ?>" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;" />
                      </td>

                      <td class="text-left">
                        <select name="items[<?php echo $i; ?>][vtax1]" class="form-control" onchange='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");'>
                          <?php  if (isset($array_yes_no) && count($array_yes_no) > 0) { ?>

                            <?php foreach($array_yes_no as $k => $array_y_n){?>
                              <?php if($k == $item['vtax1']){?>
                                <option value="<?php echo $k;?>" selected="selected"><?php echo $array_y_n;?></option>
                              <?php }else{ ?>
                                <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                        </select>
                      </td>

                      <td class="text-left">
                        <select name="items[<?php echo $i; ?>][vtax2]" class="form-control" onchange='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");'>
                          <?php  if (isset($array_yes_no) && count($array_yes_no) > 0) { ?>

                            <?php foreach($array_yes_no as $k => $array_y_n){?>
                              <?php if($k == $item['vtax2']){?>
                                <option value="<?php echo $k;?>" selected="selected"><?php echo $array_y_n;?></option>
                              <?php }else{ ?>
                                <option value="<?php echo $k;?>"><?php echo $array_y_n;?></option>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                        </select>
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
            </form>
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

<script>

$(document).ready(function() {
  $('#div_search_vcategorycode').hide();
  $('#div_search_vdepcode').hide();
  $('#div_search_box').hide();
   $('#div_search_vitem_group').hide();
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
   <?php }else if(isset($search_radio) && $search_radio == 'search'){ ?>
    $('#div_search_box').show();
    $("input[name=search_radio][value='search']").prop('checked', true);
    <?php if(isset($search_find) && !empty($search_find)){ ?>
      var search_find = '<?php echo $search_find; ?>';
      $('#search_item').val(search_find);
    <?php } ?>
  <?php } ?>

});

$(document).on('change', 'input:radio[name="search_radio"]', function(event) {
  event.preventDefault();
  if ($(this).is(':checked') && $(this).val() == 'category') {
      $('#div_search_vcategorycode').show();
      $('#div_search_vdepcode').hide();;
      $('#div_search_box').hide();
      $('#div_search_vitem_group').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'department') {
      $('#div_search_vdepcode').show();
      $('#div_search_vcategorycode').hide();
      $('#div_search_box').hide();
      $('#div_search_vitem_group').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'item_group') {
      $('#div_search_vitem_group').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vcategorycode').hide();
      $('#div_search_box').hide();
  }else if ($(this).is(':checked') && $(this).val() == 'search') {
      $('#div_search_box').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_vcategorycode').hide();
      $('#div_search_vitem_group').hide();
  }else {
      $('#div_search_vcategorycode').show();
      $('#div_search_vdepcode').hide();
      $('#div_search_box').hide();
      $('#div_search_vitem_group').hide();
  }

}); 

$(document).on('click', '#update_button', function(event) {
  $('form#form_item_price_update').submit();
  $("div#divLoading").addClass('show');
});


  $(document).on('keypress keyup blur', '.class_unitprice,.class_costprice', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });  

//   $(document).on('submit', 'form#form_item_search', function(event) {
//     if($('#search_item').val() == ''){
//       alert('Please enter item name!');
//       return false;
//     }
//   });

  $(document).ready(function() {
    $('#th_cost_price, .td_cost_price').hide();
  });
  

  $(document).on('change', 'input[name="show_cost_price"]', function(event) {
    event.preventDefault();
    if($(this).is(":checked")) {
       $('#th_cost_price, .td_cost_price').show();
    }else{
      $('#th_cost_price, .td_cost_price').hide();
    }

  });
 </script>

 <script>
    $(function() {
        
        var url = '<?php echo $searchitem;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            id: val.iitemid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_item_search #item_name').val(ui.item.id);
                
                if($('#item_name').val() != ''){
                    $('#form_item_search').submit();
                    $("div#divLoading").addClass('show');
                }
            }
        });
    });

    $(document).on('change', 'select[name="item_type"]', function(event) {
      // event.preventDefault();
      var current_url = '<?php echo $current_url;?>';
        
      current_url = current_url.replace(/&amp;/g, '&');
      current_url = current_url+'&search_item_type='+$(this).val();
      window.location.href = current_url;
      $("div#divLoading").addClass('show');
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