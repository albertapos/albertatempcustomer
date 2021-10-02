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
              <a href="<?php echo $add; ?>" class="btn btn-primary add_new_btn_rotate"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>     
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <form action="<?php echo $current_url;?>" method="post" id="form_physical_search">
          <input type="hidden" name="searchbox" id="vordertitle">
          <div class="row">
              <div class="col-md-12">
                  <input type="text" name="automplete-product" class="form-control" placeholder="Search Physical Inventory..." id="automplete-product">
              </div>
          </div>
        </form>
        <br>
        
          <div class="table-responsive">
            <table id="physical_inventory_detail" class="table table-bordered table-hover" style="">
            <?php if ($physical_inventory_details) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-right"><?php echo $text_number; ?></th>
                  <th class="text-left">Location</th>
                  <th class="text-left"><?php echo $text_created; ?></th>
                  <th class="text-left"><?php echo $text_calculated; ?></th>
                  <th class="text-left"><?php echo $text_title; ?></th>
                  <th class="text-left"><?php echo $text_status; ?></th>
                  <th class="text-left">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($physical_inventory_details as $physical_inventory_detail) { ?>
                <tr>
                  <td data-order="<?php echo $physical_inventory_detail['ipiid']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $physical_inventory_detail['ipiid']; ?></span>
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                  </td>
                  
                  <td class="text-right">
                    <span><?php echo $physical_inventory_detail['vrefnumber']; ?></span>
                  </td>

                  <td class="text-left">
                    <?php if(isset($locations) && count($locations) > 0){?>
                      <?php foreach($locations as $location){?>
                        <?php if($location['ilocid'] == $physical_inventory_detail['ilocid']){?>
                          <span><?php echo $location['vlocname']; ?></span>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </td>

                  <td class="text-left">
                    <?php

                      if(isset($physical_inventory_detail['dcreatedate']) && !empty($physical_inventory_detail['dcreatedate']) && $physical_inventory_detail['dcreatedate'] != '0000-00-00 00:00:00'){
                        $dcreatedate =  DateTime::createFromFormat('Y-m-d H:i:s', $physical_inventory_detail['dcreatedate'])->format('m-d-Y');
                      }else{
                        $dcreatedate = '';
                      }
                    
                    ?>
                    <span><?php echo $dcreatedate; ?></span>
                  </td>

                  <td class="text-left">
                    <?php

                      if(isset($physical_inventory_detail['dcalculatedate']) && !empty($physical_inventory_detail['dcalculatedate']) && $physical_inventory_detail['dcalculatedate'] != '0000-00-00 00:00:00'){
                        $dcalculatedate =  DateTime::createFromFormat('Y-m-d H:i:s', $physical_inventory_detail['dcalculatedate'])->format('m-d-Y');
                      }else{
                        $dcalculatedate = '';
                      }
                    
                    ?>
                    <span><?php echo $dcalculatedate; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $physical_inventory_detail['vordertitle']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $physical_inventory_detail['estatus']; ?></span>
                  </td>

                  <td class="text-left">
                    <a href="<?php echo $physical_inventory_detail['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info edit_btn_rotate" ><i class="fa fa-pencil">&nbsp;&nbsp;Edit</i>
                    </a>
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
          <?php if ($physical_inventory_details) { ?>
          <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
          </div>
          <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    $(function() {
        
        var url = '<?php echo $searchphysical;?>';
        
        url = url.replace(/&amp;/g, '&');
        
        $( "#automplete-product" ).autocomplete({
            minLength: 2,
            source: function(req, add) {
                $.getJSON(url, req, function(data) {
                    var suggestions = [];
                    $.each(data, function(i, val) {
                        suggestions.push({
                            label: val.vordertitle,
                            value: val.vordertitle,
                            id: val.ipiid
                        });
                    });
                    add(suggestions);
                });
            },
            select: function(e, ui) {
                $('form#form_physical_search #vordertitle').val(ui.item.id);
                
                if($('#vordertitle').val() != ''){
                    $('#form_physical_search').submit();
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