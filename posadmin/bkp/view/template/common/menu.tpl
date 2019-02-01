<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  <!--<li id="catalog"><a class="parent active"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_administration; ?></span></a>
    <ul>
      <li><a href="<?php echo $age_verification; ?>"><?php echo $text_age_verification; ?></a></li>
      <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
      <li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
      <li><a href="<?php echo $department; ?>"><?php echo $text_department; ?></a></li>
      <!--<li><a href=" php echo $menu_item; ?>">< ?php echo $text_menu_item; ?></a></li>- ->
      <li><a href="<?php echo $paid_out; ?>"><?php echo $text_paid_out; ?></a></li>      
      <li><a href="<?php echo $store_setting; ?>"><?php echo $text_store_setting; ?></a></li>      
      <li><a href="<?php echo $users; ?>"><?php echo $text_users; ?></a></li>      
      <li><a href="<?php echo $user_groups; ?>"><?php echo $text_user_groups; ?></a></li>      
      <li><a href="<?php echo $tax; ?>"><?php echo $text_tax; ?></a></li>
      <li><a href="<?php echo $vendor; ?>"><?php echo $text_vendor; ?></a></li>
      
      <!-- <li><a href="<?php echo $gloabal_param; ?>"><?php echo $text_gloabal_param; ?></a></li> -- >
    </ul>
  </li>-->
 
    <li><a class="parent"><i class="fa fa-bars"></i>&nbsp;&nbsp;<span><?php echo $text_reports; ?></span></a>
      <ul>
        <li><a href="<?php echo $below_cost_report; ?>"><?php echo $text_below_cost_report; ?></a></li> 
        <li><a href="<?php echo $cash_sales_summary; ?>"><?php echo $text_cash_sales_summary; ?></a></li>
        <li><a href="<?php echo $end_of_day_report; ?>"><?php echo $text_end_of_day_report; ?></a></li> 
        <li><a href="<?php echo $inventory_on_hand_report; ?>"><?php echo $text_inventory_on_hand_report; ?></a></li>  
        <li><a href="<?php echo $kiosk_item_detail; ?>"><?php echo $text_kiosk_item_detail_report; ?></a></li>  
        <li><a href="<?php echo $monthly_sales_report; ?>"><?php echo $text_monthly_sales_report; ?></a></li>
         <?php if($plcb_reports_check == true) {?>
        <li><a href="<?php echo $plcb_reports; ?>"><?php echo $text_plcb_reports; ?></a></li> 
        <?php } ?>
        <li><a href="<?php echo $po_history_report; ?>"><?php echo $text_po_history_report; ?></a></li>
        <li><a href="<?php echo $profit_loss; ?>"><?php echo $text_profit_loss; ?></a></li>
        <li style="display:none;"><a href="<?php echo $vendor_purchase_history_report; ?>"><?php echo $text_vendor_purchase_history_report; ?></a></li>
        <li><a href="<?php echo $zero_movement_report; ?>"><?php echo $text_zero_movement_report; ?></a></li>
      </ul>
    </li> 
 
  <!--<li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
    <ul>    
      <li><a class="parent"><?php echo $text_users; ?></a>
        <ul>
          <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
          <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
        </ul>
      </li>    
    </ul>
  </li>-->
  
</ul>
