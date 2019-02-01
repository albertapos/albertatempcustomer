<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
<?php if($webadmin == true){ ?>
  <li><a href="<?php echo $store; ?>"><i class="fa fa-shopping-cart fa-fw"></i> <span><?php echo $text_store; ?></span></a></li>

  <li><a class="parent active"><i class="fa fa-user fa-fw"></i> <span><?php echo $text_users; ?></span></a>
    <ul>
      <li><a href="<?php echo $users; ?>"><?php echo $text_users; ?></a></li>      
      <li><a href="<?php echo $user_groups; ?>"><?php echo $text_user_groups; ?></a></li>
    </ul>
  </li>

  <li><a href="<?php echo $vendor; ?>"><i class="fa fa-building fa-fw"></i> <span><?php echo $text_vendor; ?></span></a></li>

  <li><a href="<?php echo $customer; ?>"><i class="fa fa-child fa-fw"></i> <span><?php echo $text_customer; ?></span></a></li>

  <li><a class="parent active"><i class="fa fa-gift fa-fw"></i> <span><?php echo $text_item; ?></span></a>
    <ul>
      <li><a href="<?php echo $items; ?>"><?php echo $text_item; ?></a></li>      
      <li><a href="<?php echo $quick_item; ?>"><?php echo $text_quick_item; ?></a></li>
      <li><a href="<?php echo $sale; ?>"><?php echo $text_sale; ?></a></li>
      <li><a href="<?php echo $update_item_price; ?>"><?php echo $text_update_item_price; ?></a></li>
      <li><a href="<?php echo $item_group; ?>"><?php echo $text_item_group; ?></a></li>
      <li><a href="<?php echo $edit_multiple_items; ?>"><?php echo $text_edit_multiple_items; ?></a></li>
      <li style="display:none;"><a href="<?php echo $transactions; ?>"><?php echo $text_transactions; ?></a></li>
      <li><a href="<?php echo $last_modified_items; ?>"><?php echo $text_last_modified_items; ?></a></li>
      <li><a href="<?php echo $item_movement_report; ?>"><?php echo $text_item_movement_report; ?></a></li>
    </ul>
  </li>

  <li><a class="parent active"><i class="fa fa-sitemap fa-fw"></i> <span><?php echo $text_inventory; ?></span></a>
    <ul>
      <li><a href="<?php echo $template; ?>"><?php echo $text_template; ?></a></li>
      <li><a href="<?php echo $physical_inventory_detail; ?>"><?php echo $text_physical_inventory_detail; ?></a></li>
      <li><a href="<?php echo $waste_detail; ?>"><?php echo $text_waste_detail; ?></a></li>
      <li><a href="<?php echo $adjustment_detail; ?>"><?php echo $text_adjustment_detail; ?></a></li>
      <li><a href="<?php echo $transfer; ?>"><?php echo $text_transfer; ?></a></li>
      <li><a href="<?php echo $purchase_order; ?>"><?php echo $text_purchase_order; ?></a></li>
      <li><a href="<?php echo $location; ?>"><?php echo $text_locations; ?></a></li>
      <li><a href="<?php echo $adjustment_reason; ?>"><?php echo $text_adjustment_reason; ?></a></li>
    </ul>
  </li>

  <li><a class="parent active"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_administration; ?></span></a>
    <ul>
      <li><a href="<?php echo $units; ?>"><?php echo $text_units; ?></a></li>
      <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
      <li><a href="<?php echo $department; ?>"><?php echo $text_department; ?></a></li>
      <li><a href="<?php echo $aisle; ?>"><?php echo $text_aisle; ?></a></li>
      <li><a href="<?php echo $shelf; ?>"><?php echo $text_shelf; ?></a></li>
      <li><a href="<?php echo $shelving; ?>"><?php echo $text_shelving; ?></a></li>
      <li><a href="<?php echo $size; ?>"><?php echo $text_size; ?></a></li>
      <li><a href="<?php echo $tax; ?>"><?php echo $text_tax; ?></a></li>
      <li><a href="<?php echo $paid_out; ?>"><?php echo $text_paid_out; ?></a></li>  
      <li><a href="<?php echo $store_setting; ?>"><?php echo $text_store_setting; ?></a></li>
      <li><a href="<?php echo $age_verification; ?>"><?php echo $text_age_verification; ?></a></li>
      <li><a href="<?php echo $end_of_day_shift; ?>"><?php echo $text_end_of_day_shift; ?></a></li>
    </ul>
  </li>
<?php } ?>
  <li><a class="parent"><i class="fa fa-bars fa-fw"></i>&nbsp;&nbsp;<span><?php echo $text_reports; ?></span></a>
    <ul>
      <li><a href="<?php echo $end_of_day_report; ?>"><?php echo $text_end_of_day_report; ?></a></li>
      <li><a href="<?php echo $below_cost_report; ?>"><?php echo $text_below_cost_report; ?></a></li> 
      <li><a href="<?php echo $cash_sales_summary; ?>"><?php echo $text_cash_sales_summary; ?></a></li>
       
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
       <li><a href="<?php echo $rip_report; ?>"><?php echo $text_rip_report; ?></a></li>
       <li><a href="<?php echo $vendor_report; ?>"><?php echo $text_vendor_report; ?></a></li>
       <li><a href="<?php echo $scan_data_report; ?>"><?php echo $text_scan_data_report; ?></a></li>
       <li><a href="<?php echo $item_delete_void_report; ?>"><?php echo $text_item_delete_void_report; ?></a></li>
       <li><a href="<?php echo $product_listing_report; ?>"><?php echo $text_product_listing_report; ?></a></li>
       <li><a href="<?php echo $tax_report; ?>"><?php echo $text_tax_report; ?></a></li>
       <li><a href="<?php echo $credit_card_report; ?>"><?php echo $text_credit_card_report; ?></a></li>
       <?php if($logged_email=="admin@test.com"){?>
       <li><a href="<?php echo $sales_item_report; ?>"><?php echo $text_sales_item_report; ?></a></li>
       <?php }?>
       <li><a href="<?php echo $employee_report; ?>"><?php echo $text_employee_report; ?></a></li>
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
<?php if($webadmin == true){ ?>
  <li><a class="parent active"><i class="fa fa-cog fa-fw"></i> <span>Settings</span></a>
    <ul>
      <li><a href="<?php echo $settings; ?>">Item List Display</a></li>      
      <li><a href="<?php echo $end_of_shift_printing; ?>"><?php echo $text_end_of_shift_printing; ?></a></li>
    </ul>
  </li>
<?php }else{ ?>
  <li><a href="<?php echo $end_of_shift_printing; ?>"><i class="fa fa-cog fa-fw"></i>&nbsp;&nbsp;<span><?php echo $text_end_of_shift_printing; ?></span></a></li>
<?php } ?>
</ul>
