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
    
    <div class="panel panel-default">
      <div class="panel-heading head_title">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <a class="btn btn-info pull-right show_all_btn_rotate" href="<?php echo $current_url;?>">Show All</a>
          </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
              <form action="<?php echo $current_url;?>" method="post" id="form_item_search">
                <input type="text" name="automplete-search-box" class="form-control" placeholder="Search Item..." id="automplete-product" >
                <input type="hidden" name="searchbox" id="iitemid">
              </form>
            </div>
        </div>
        <br>
        <?php if(count($plcb_products)){?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>

                <?php if(isset($order) && $order != '' && $order == 'ASC'){ ?>
                  <th><a class="show_all_btn_rotate" style="color: #fff;" href="<?php echo $current_url.'&sort=itemname&order=DESC'; ?>">Product Name</a></th>
                <?php }else{ ?>
                  <th><a class="show_all_btn_rotate" style="color: #fff;" href="<?php echo $current_url.'&sort=itemname&order=ASC'; ?>">Product Name</a></th>
                <?php } ?>
                <th>Unit</th>
                <th>Unit Value</th>
                <?php if(isset($order) && $order != '' && $order == 'ASC'){ ?>
                  <th><a class="show_all_btn_rotate" style="color: #fff;" href="<?php echo $current_url.'&sort=bucket_name&order=DESC'; ?>">Bucket Name</a></th>
                <?php }else{ ?>
                  <th><a class="show_all_btn_rotate" style="color: #fff;" href="<?php echo $current_url.'&sort=bucket_name&order=ASC'; ?>">Bucket Name</a></th>
                <?php } ?>
                <th>Previous Month beginning Qty</th>
                <th>Previous Month ending Qty</th>
                <th>Malt</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($plcb_products as $plcb_product){?>
                <tr>
                  <td>
                    <?php echo $plcb_product['vitemname'];?>
                    <input type="hidden" name="prduct_name" value="<?php echo $plcb_product['vitemname'];?>">
                    <input type="hidden" name="iitemid" value="<?php echo $plcb_product['iitemid'];?>">
                  </td>

                  <td>
                    <select name="unit_id" class="form-control" required>
                      <option value="">Select Unit</option>
                      <?php foreach($units as $unit){?>
                        <?php if($unit['id'] == $plcb_product['unit_id']){?>
                          <option value="<?php echo $unit['id'];?>" selected="selected"><?php echo $unit['unit_name']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $unit['id'];?>"><?php echo $unit['unit_name']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>

                  <td>
                    <input type="text" class="form-control" name="unit_value" id="" value="<?php echo $plcb_product['unit_value'];?>" />
                  </td>

                  <td>
                    <select name="bucket_id" class="form-control" required>
                      <option value="">Select Bucket</option>
                      <?php foreach($buckets as $bucket){?>
                        <?php if($bucket['id'] == $plcb_product['bucket_id']){?>
                          <option value="<?php echo $bucket['id']; ?>" selected="selected"><?php echo $bucket['bucket_name']; ?></option>
                        <?php } else { ?>
                          <option value="<?php echo $bucket['id']; ?>"><?php echo $bucket['bucket_name']; ?></option>
                        <?php } ?>
                      <?php } ?>
                    </select>
                  </td>

                  <td>
                    <input type="text" class="form-control" name="prev_mo_beg_qty" id="" value="<?php echo $plcb_product['prev_mo_beg_qty'];?>" />
                  </td>

                  <td>
                      <input type="text" class="form-control" name="prev_mo_end_qty" id="" value="<?php echo $plcb_product['prev_mo_end_qty'];?>" />
                  </td>

                  <td>
                    <input type="checkbox" name="malt" value="1" <?php if($plcb_product['malt'] == 1){?> checked <?php } ?> >
                  </td>

                  <td>
                    <a href="" class="btn btn-xs btn-info update_record">Save</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
          
        <?php } else {?>
          <div class="row">
            <div class="col-md-12 text-center">
              <p class="text-info"><b>Sorry we not found data!!!</b></p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="view/javascript/bootbox.min.js" defer></script>

<script type="text/javascript">
  $(document).ready(function($) {
    $("div#divLoading").addClass('show');
  });

  $(window).load(function() {
    $("div#divLoading").removeClass('show');
  });
</script>

<script type="text/javascript">
  $(document).on('keypress keyup', 'input[name="unit_value"],input[name="prev_mo_beg_qty"], input[name="prev_mo_end_qty"]', function(event) {

    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    
  }); 
</script>


<script type="text/javascript">
    $(document).on('click', '.update_record', function(event) {
    event.preventDefault();

        $("div#divLoading").addClass('show');

        var url = '<?php echo $plcb_product_update;?>';
        
        url = url.replace(/&amp;/g, '&');

        var iitemid = $(this).closest('tr').find('input[name="iitemid"]').val();
        var prduct_name = $(this).closest('tr').find('input[name="prduct_name"]').val();
        var unit_id = $(this).closest('tr').find('select[name="unit_id"]').val();
        var unit_value = $(this).closest('tr').find('input[name="unit_value"]').val();
        var bucket_id = $(this).closest('tr').find('select[name="bucket_id"]').val();
        var prev_mo_beg_qty = $(this).closest('tr').find('input[name="prev_mo_beg_qty"]').val();
        var prev_mo_end_qty = $(this).closest('tr').find('input[name="prev_mo_end_qty"]').val();

        if($(this).closest('tr').find('input[name="malt"]').prop('checked') == true){
            var malt = 1;
        }else{
            var malt = '';
        }

        if(unit_id == ''){
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Select Unit!", 
              callback: function(){}
            });
            return false;
        }

        if(unit_value == ''){
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter Unit Value!", 
              callback: function(){}
            });
            return false;
        }

        if(bucket_id == ''){
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Select Bucket!", 
              callback: function(){}
            });
            return false;
        }

        if(prev_mo_beg_qty == ''){
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter beginning Qty!", 
              callback: function(){}
            });
            return false;
        }

        if(prev_mo_end_qty == ''){
            bootbox.alert({ 
              size: 'small',
              title: "Attention", 
              message: "Please Enter End Qty!", 
              callback: function(){}
            });
            return false;
        }

        var data = {iitemid:iitemid,prduct_name:prduct_name, unit_id:unit_id, unit_value:unit_value, bucket_id:bucket_id, prev_mo_beg_qty:prev_mo_beg_qty, prev_mo_end_qty:prev_mo_end_qty, malt:malt};

        $.ajax({
            url : url,
            data : JSON.stringify(data),
            type : 'POST',
            contentType: "application/json",
            dataType: 'json',
            }).done(function(response){

                if( response.code == 1 ) {//success
                    $("div#divLoading").removeClass('show');
                    $('#successModal').modal('show');
                    setTimeout(function(){
                      $('#successModal').modal('hide');
                    }, 3000);
                    return false;
                } else if( response.code == 0 ) {//error
                    bootbox.alert({ 
                      size: 'small',
                      title: "Attention", 
                      message: "Something went wrong!", 
                      callback: function(){}
                    });
                    $("div#divLoading").removeClass('show');
                    return false;
                }
            });
        
    });
</script>

<div class="modal fade" id="successModal" role="dialog" style="z-index: 9999;">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-center">
          <p><b>PLCB Product Updated Successfully</b></p>
        </div>
      </div>
    </div>
    
  </div>
</div>

<script>
    $(function() {
        
        var url = '<?php echo $searchitem;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    window.suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vitemname,
                            value: val.vitemname,
                            id: val.iitemid
                        });
                    });
                    add(window.suggestions);
                });
            },
            select: function(e, ui) {

                $('form#form_item_search #iitemid').val(ui.item.id);
                
                if($('#iitemid').val() != ''){
                    $("div#divLoading").addClass('show');
                    $('#form_item_search').submit();
                }
            }
        });
    });
</script>
