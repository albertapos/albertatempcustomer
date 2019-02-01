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
                <input type="checkbox" name="show_cost_price" value="show_cost_price" style="border: 1px solid #A9A9A9;">&nbsp;&nbsp;<span>Show Cost Price</span>
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
          
            <form action="<?php echo $current_url;?>" method="post" id="form_item_search">
              <div class="row">
                <div class="col-md-12" id="div_search_box">
                  <input type="hidden" name="search_item" id="item_name">
                    <input type="text" name="automplete-product" id="automplete-product" class="form-control" placeholder="Search Item...">
                </div>
              </div>
            </form>
        <br>
        
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
                    <th class="text-right text-uppercase" id="th_cost_price">Cost Price</th>
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
                        <span><?php echo $item['vcategoryname']; ?></span>
                      </td>

                      <td class="text-left">
                        <span><?php echo $item['vdepartmentname']; ?></span>
                      </td>

                      <td class="text-right td_cost_price" style="width:10%;">
                        <input type="text" class="editable class_costprice" name="items[<?php echo $i; ?>][dcostprice]" value="<?php echo $item['dcostprice']; ?>" onclick='document.getElementById("items[<?php echo $i; ?>][select]").setAttribute("checked","checked");' style="width:100%;text-align:right;" />
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

$(document).on('click', '#update_button', function(event) {
  $('form#form_item_price_update').submit();
  $("div#divLoading").addClass('show');
});


  $(document).on('keypress keyup blur', '.class_unitprice,.class_costprice', function(event) {

    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

  });  

  $(document).on('submit', 'form#form_item_search', function(event) {
    if($('#search_item').val() == ''){
      alert('Please enter item name!');
      return false;
    }
  });

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