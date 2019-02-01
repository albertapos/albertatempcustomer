<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<?php foreach ($styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<link rel="stylesheet" href="view/stylesheet/jquery-ui.css">
<script src="view/javascript/jquery/jquery-ui.js"></script>

<style>
.dropbtn {
    background-color: #f05a28;
    color: white;
    padding: 13px;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    overflow-y: auto;
    height: 150px;
}

.dropdown-content span {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content span:hover {background-color: #f05a28;cursor: pointer;color:#fff;}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #f05a28;
}
</style>

</head>
<body>
<div id="divLoading" class="show"></div>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header">
    <?php if ($logged) { ?>
    <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
    <?php } ?>
    <a href="<?php echo $home; ?>" class="navbar-brand">Alberta Inc. POS</a></div>    
  <?php if ($logged) { ?>
  
  <ul class="nav pull-right">
    <li><a href="" title="Store" onClick="openNavStore()" class="di_store_name" style="border-left:none;"><?php echo $storename;?>&nbsp;<i class="fa fa-chevron-down"></i></a></li>   
    <li><a href="" title="Reports" onClick="openNavReports()" class="di_reports"><i class="fa fa-bar-chart"></i></a></li>  	
    <li><a href="<?php echo $settings; ?>" title="Settings"><i class="fa fa-cog"></i></a></li>
    <li><a href="<?php echo $dashboard_quick_links; ?>" title="Quick Links"><i class="fa fa-external-link"></i></a></li>
    <li><a href="<?php echo $logout; ?>" title="Logout"><i class="fa fa-sign-out fa-lg"></i></a></li>
  </ul>
  
  <div id="mySidenavStore" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onClick="closeNavStore()">&times;</a>
      <div class="side_content_div">
        <h5>Stores</h5>
        <div class="side_inner_content_div">
          <p><input type="text" name="" placeholder="search store" style="width:75%;" class="form-control" id="store_search"></p><br>
          <?php if(isset($stores) && count($stores) > 0){ ?>
          <?php foreach($stores as $store){ ?>
            <p style="color:#fff;cursor:pointer;line-height:12px; font-size:13px;" data-store-id="<?php echo $store['id'];?>" class="change_store"><?php echo $store['name'].' ['.$store['id'].']';?></p>
          <?php } ?>
        <?php } ?>
        </div>
      </div>
  </div>

  <div id="mySidenavReports" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onClick="closeNavReports()">&times;</a>
      <div class="side_content_div">
        <h5>Reports</h5>
        <div class="side_inner_content_div">
          <input type="text" name="" placeholder="search report" style="width:75%;" class="form-control" id="report_search"><br>
          <p><a class="report_name" href="<?php echo $below_cost_report; ?>"><?php echo $text_below_cost_report; ?></a></p> 
          <p><a class="report_name" href="<?php echo $cash_sales_summary; ?>"><?php echo $text_cash_sales_summary; ?></a></p>
          <p><a class="report_name" href="<?php echo $end_of_day_report; ?>"><?php echo $text_end_of_day_report; ?></a></p> 
          <p><a class="report_name" href="<?php echo $inventory_on_hand_report; ?>"><?php echo $text_inventory_on_hand_report; ?></a></p>
          <?php if($store_kiosk_check == true) {?>
            <p><a class="report_name" href="<?php echo $kiosk_item_detail; ?>"><?php echo $text_kiosk_item_detail_report; ?></a></p> 
          <?php } ?>
          <p><a class="report_name" href="<?php echo $monthly_sales_report; ?>"><?php echo $text_monthly_sales_report; ?></a></p>
          <?php if($plcb_reports_check == true) {?>
            <p><a class="report_name" href="<?php echo $plcb_reports; ?>"><?php echo $text_plcb_reports; ?></a></p>
          <?php } ?>
          <p><a class="report_name" href="<?php echo $po_history_report; ?>"><?php echo $text_po_history_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $profit_loss; ?>"><?php echo $text_profit_loss; ?></a></p>
          <p style="display:none;"><a class="report_name" href="<?php echo $vendor_purchase_history_report; ?>"><?php echo $text_vendor_purchase_history_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $zero_movement_report; ?>"><?php echo $text_zero_movement_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $sales_report; ?>"><?php echo $text_sales_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $customer_report; ?>"><?php echo $text_customer_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $rip_report; ?>"><?php echo $text_rip_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $vendor_report; ?>"><?php echo $text_vendor_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $scan_data_report; ?>"><?php echo $text_scan_data_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $item_delete_void_report; ?>"><?php echo $text_item_delete_void_report; ?></a></p>
          <p><a class="report_name" href="<?php echo $product_listing_report; ?>"><?php echo $text_product_listing_report; ?></a></p>
        </div>
      </div>
  </div>

  <!-- <div style="border:0px solid #000; width:200px; margin-left:45%; margin-top:10px; font-size:18px; color:#F30; font-weight:bold;"><?php echo $storename;?></div> -->
  <?php } ?>
</header>
