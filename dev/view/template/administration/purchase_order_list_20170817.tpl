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
        <div class="top_button">
          <a href="<?php echo $add; ?>" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New</a>  
        </div>
      </div>
      <div class="panel-body">
        
        <div class="row" style="clear:both;">
          <form action="<?php echo $current_url;?>" method="post" id="form_order_search">
                <div class="col-md-6">
                    <input type="text" name="searchbox" value="<?php echo isset($searchbox) ? $searchbox: ''; ?>" class="form-control" placeholder="Search...">
                </div>
                <div class="col-md-6">
                  <input type="submit" name="Filter" value="Search" class="btn btn-info">
                </div>
          </form>
        </div>
        <br>
        <form action="" method="post" enctype="multipart/form-data" id="form-purchase-order">
          
          <div class="">
            <table id="purchase_order" class="table table-bordered table-hover">
            <?php if ($purchase_orders) { ?>
              <thead>
                <tr>
                  <th style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
                  <th class="text-center"><?php echo $column_status; ?></th>
                  <th class="text-center"><?php echo $column_purchase_ord; ?></th>
                  <th class="text-center"><?php echo $column_invoice; ?></th>
                  <th class="text-center"><?php echo $column_total; ?></th>
                  <th class="text-center"><?php echo $column_vendor_name; ?></th>
                  <th class="text-center"><?php echo $column_order_type; ?></th>
                  <th class="text-center"><?php echo $column_date_created; ?></th>
                  <th class="text-center"><?php echo $column_date_received; ?></th>
                  <th class="text-center"><?php echo $column_date_lastupdate; ?></th>
                  <th class="text-center"><?php echo $column_action; ?></th>
                </tr>
              </thead>
              <tbody>
                
                <?php $purchase_order_row = 1;$i=0; ?>
                <?php foreach ($purchase_orders as $purchase_order) { ?>
                <tr id="purchase_order-row<?php echo $purchase_order_row; ?>">
                  <td data-order="<?php echo $purchase_order['ipoid']; ?>" class="text-center">
                    <span style="display:none;"><?php echo $purchase_order['ipoid']; ?></span>
                    <input type="checkbox" name="selected[]" id="purchase_order[<?php echo $purchase_order_row; ?>][select]"  value="<?php echo $purchase_order['ipoid']; ?>" />
                  </td>
                  
                  <td class="text-left">
                    <span><?php echo $purchase_order['estatus']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['vponumber']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['vinvoiceno']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['nnettotal']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['vvendorname']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['vordertype']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['dcreatedate']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['dreceiveddate']; ?></span>
                  </td>

                  <td class="text-left">
                    <span><?php echo $purchase_order['dlastupdate']; ?></span>
                  </td>

                  <td class="text-right">
                    <a href="<?php echo $purchase_order['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" ><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit
                    </a>
                  </td>
                </tr>
                <?php $purchase_order_row++; $i++;?>
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

<?php echo $footer; ?>