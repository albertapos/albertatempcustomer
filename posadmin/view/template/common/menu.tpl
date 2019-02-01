<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
    <li><a class="parent"><i class="fa fa-bars"></i>&nbsp;&nbsp;<span><?php echo $text_reports; ?></span></a>
      <ul>
        <li><a href="<?php echo $below_cost_report; ?>"><?php echo $text_below_cost_report; ?></a></li> 
        <li><a href="<?php echo $cash_sales_summary; ?>"><?php echo $text_cash_sales_summary; ?></a></li>
        <li><a href="<?php echo $end_of_day_report; ?>"><?php echo $text_end_of_day_report; ?></a></li> 
        <li><a href="<?php echo $inventory_on_hand_report; ?>"><?php echo $text_inventory_on_hand_report; ?></a></li>
        <?php if($store_kiosk_check == true) {?>
          <li><a href="<?php echo $kiosk_item_detail; ?>"><?php echo $text_kiosk_item_detail_report; ?></a></li> 
        <?php } ?>
        <li><a href="<?php echo $monthly_sales_report; ?>"><?php echo $text_monthly_sales_report; ?></a></li>
        <?php if($plcb_reports_check == true) {?>
          <li><a href="<?php echo $plcb_reports; ?>"><?php echo $text_plcb_reports; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $po_history_report; ?>"><?php echo $text_po_history_report; ?></a></li>
        <li><a href="<?php echo $profit_loss; ?>"><?php echo $text_profit_loss; ?></a></li>
        <li style="display:none;"><a href="<?php echo $vendor_purchase_history_report; ?>"><?php echo $text_vendor_purchase_history_report; ?></a></li>
        <li><a href="<?php echo $zero_movement_report; ?>"><?php echo $text_zero_movement_report; ?></a></li>
        <li><a href="<?php echo $sales_report; ?>"><?php echo $text_sales_report; ?></a></li>
        <li><a href="<?php echo $customer_report; ?>"><?php echo $text_customer_report; ?></a></li>
      </ul>
    </li> 
</ul>
