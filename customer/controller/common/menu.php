<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['logged_email'] = $this->session->data['logged_email'];

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_system'] = $this->language->get('text_system');
		
		$data['text_administration'] = $this->language->get('text_administration');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_department'] = $this->language->get('text_department');
		$data['text_end_of_day_shift'] = $this->language->get('text_end_of_day_shift');
		
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_paid_out'] = $this->language->get('text_paid_out');
		$data['text_store_setting'] = $this->language->get('text_store_setting');
		$data['text_vendor'] = $this->language->get('text_vendor');
		$data['text_age_verification'] = $this->language->get('text_age_verification');
		$data['text_user_groups'] = $this->language->get('text_user_groups');
		$data['text_locations'] = $this->language->get('text_locations');
		$data['text_adjustment_reason'] = $this->language->get('text_adjustment_reason');
		$data['text_units'] = $this->language->get('text_units');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_template'] = $this->language->get('text_template');
		$data['text_group'] = $this->language->get('text_group');
		$data['text_group_slab_pricing'] = $this->language->get('text_group_slab_pricing');
		$data['text_transfer'] = $this->language->get('text_transfer');
		$data['text_adjustment_detail'] = $this->language->get('text_adjustment_detail');
		$data['text_waste_detail'] = $this->language->get('text_waste_detail');
		$data['text_physical_inventory_detail'] = $this->language->get('text_physical_inventory_detail');
		$data['text_item'] = $this->language->get('text_item');
		$data['text_inventory'] = $this->language->get('text_inventory');
		$data['text_accounting'] = $this->language->get('text_accounting');
		$data['text_aisle'] = $this->language->get('text_aisle');
		$data['text_shelf'] = $this->language->get('text_shelf');
		$data['text_shelving'] = $this->language->get('text_shelving');
		$data['text_size'] = $this->language->get('text_size');
		$data['text_purchase_order'] = $this->language->get('text_purchase_order');
		$data['text_settings'] = $this->language->get('text_settings');
		$data['text_end_of_shift_printing'] = $this->language->get('text_end_of_shift_printing');
		
		$data['text_items'] = $this->language->get('text_items');
		$data['text_edit_multiple_items'] = $this->language->get('text_edit_multiple_items');
		$data['text_last_modified_items'] = $this->language->get('text_last_modified_items');
		$data['text_quick_item'] = $this->language->get('text_quick_item');
		$data['text_update_item_price'] = $this->language->get('text_update_item_price');
		$data['text_show_item_price'] = $this->language->get('text_show_item_price');
		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_item_group'] = $this->language->get('text_item_group');
		$data['text_transactions'] = $this->language->get('text_transactions');
		$data['text_gloabal_param'] = $this->language->get('text_gloabal_param');
		
		$data['text_user'] = $this->language->get('text_user');
		$data['text_user_group'] = $this->language->get('text_user_group');
		$data['text_users'] = $this->language->get('text_users');

		$data['text_reports'] = $this->language->get('text_reports');
		$data['text_plcb_reports'] = $this->language->get('text_plcb_reports');
		$data['text_cash_sales_summary'] = $this->language->get('text_cash_sales_summary');
		$data['text_profit_loss'] = $this->language->get('text_profit_loss');
		$data['text_end_of_day_report'] = $this->language->get('text_end_of_day_report');
		$data['text_monthly_sales_report'] = $this->language->get('text_monthly_sales_report');
		$data['text_po_history_report'] = $this->language->get('text_po_history_report');
		$data['text_vendor_purchase_history_report'] = $this->language->get('text_vendor_purchase_history_report');
		$data['text_below_cost_report'] = $this->language->get('text_below_cost_report');
		$data['text_inventory_on_hand_report'] = $this->language->get('text_inventory_on_hand_report');
		$data['text_zero_movement_report'] = $this->language->get('text_zero_movement_report');
		$data['text_kiosk_item_detail_report'] = $this->language->get('text_kiosk_item_detail_report');
		$data['text_sales_report'] = $this->language->get('text_sales_report');
		$data['text_customer_report'] = $this->language->get('text_customer_report');
		$data['text_rip_report'] = $this->language->get('text_rip_report');	
		$data['text_vendor_report'] = $this->language->get('text_vendor_report');
		$data['text_scan_data_report'] = $this->language->get('text_scan_data_report');
		$data['text_sales_item_report'] = $this->language->get('text_sales_item_report');	
		$data['text_item_delete_void_report'] = $this->language->get('text_item_delete_void_report');	
		$data['text_product_listing_report'] = $this->language->get('text_product_listing_report');	
		$data['text_item_movement_report'] = $this->language->get('text_item_movement_report');
		$data['text_tax_report'] = $this->language->get('text_tax_report');
		$data['text_credit_card_report'] = $this->language->get('text_credit_card_report');
		$data['text_employee_report'] = $this->language->get('text_employee_report');
		$data['text_hourly_sales_report'] = $this->language->get('text_hourly_sales_report');
		

		$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);

		$data['category'] = $this->url->link('administration/category', 'token=' . $this->session->data['token'], true);
		$data['customer'] = $this->url->link('administration/customer', 'token=' . $this->session->data['token'], true);
		$data['department'] = $this->url->link('administration/department', 'token=' . $this->session->data['token'], true);		
		$data['tax'] = $this->url->link('administration/tax', 'token=' . $this->session->data['token'], true);
		$data['vendor'] = $this->url->link('administration/vendor', 'token=' . $this->session->data['token'], true);
		$data['paid_out'] = $this->url->link('administration/paid_out', 'token=' . $this->session->data['token'], true);
		$data['store_setting'] = $this->url->link('administration/store_setting', 'token=' . $this->session->data['token'], true);
		$data['user_groups'] = $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'], true);
		$data['age_verification'] = $this->url->link('administration/age_verification', 'token=' . $this->session->data['token'], true);
		$data['users'] = $this->url->link('administration/users', 'token=' . $this->session->data['token'], true);
		$data['location'] = $this->url->link('administration/location', 'token=' . $this->session->data['token'], true);
		$data['adjustment_reason'] = $this->url->link('administration/adjustment_reason', 'token=' . $this->session->data['token'], true);
		$data['units'] = $this->url->link('administration/units', 'token=' . $this->session->data['token'], true);
		$data['store'] = $this->url->link('administration/store', 'token=' . $this->session->data['token'], true);
		$data['template'] = $this->url->link('administration/template', 'token=' . $this->session->data['token'], true);
		$data['group'] = $this->url->link('administration/group', 'token=' . $this->session->data['token'], true);
		$data['group_slab_pricing'] = $this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'], true);
		$data['transfer'] = $this->url->link('administration/transfer/listing', 'token=' . $this->session->data['token'], true);
		$data['adjustment_detail'] = $this->url->link('administration/adjustment_detail', 'token=' . $this->session->data['token'], true);
		$data['waste_detail'] = $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'], true);
		$data['physical_inventory_detail'] = $this->url->link('administration/physical_inventory_detail', 'token=' . $this->session->data['token'], true);
		$data['items'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'], true);
		$data['edit_multiple_items'] = $this->url->link('administration/items/edit_items', 'token=' . $this->session->data['token'], true);
		$data['last_modified_items'] = $this->url->link('administration/items/last_modify_items', 'token=' . $this->session->data['token'], true);
		$data['quick_item'] = $this->url->link('administration/items/quick_item', 'token=' . $this->session->data['token'], true);
		$data['update_item_price'] = $this->url->link('administration/items/update_item_price', 'token=' . $this->session->data['token'], true);
		$data['show_item_price'] = $this->url->link('administration/items/show_item_price', 'token=' . $this->session->data['token'], true);
		$data['sale'] = $this->url->link('administration/items/sale', 'token=' . $this->session->data['token'], true);
		$data['item_group'] = $this->url->link('administration/group', 'token=' . $this->session->data['token'], true);
		$data['transactions'] = $this->url->link('administration/transactions', 'token=' . $this->session->data['token'], true);
		$data['aisle'] = $this->url->link('administration/aisle', 'token=' . $this->session->data['token'], true);
		$data['shelf'] = $this->url->link('administration/shelf', 'token=' . $this->session->data['token'], true);
		$data['shelving'] = $this->url->link('administration/shelving', 'token=' . $this->session->data['token'], true);
		$data['size'] = $this->url->link('administration/size', 'token=' . $this->session->data['token'], true);
		$data['purchase_order'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'], true);
		$data['settings'] = $this->url->link('administration/settings', 'token=' . $this->session->data['token'], true);
		$data['end_of_shift_printing'] = $this->url->link('administration/end_of_shift_printing', 'token=' . $this->session->data['token'], true);
		$data['end_of_day_shift'] = $this->url->link('administration/end_of_day_shift', 'token=' . $this->session->data['token'], true);


		$data['plcb_reports'] = $this->url->link('administration/plcb_reports', 'token=' . $this->session->data['token'], true);
		$data['cash_sales_summary'] = $this->url->link('administration/cash_sales_summary', 'token=' . $this->session->data['token'], true);
		$data['profit_loss'] = $this->url->link('administration/profit_loss', 'token=' . $this->session->data['token'], true);
		$data['end_of_day_report'] = $this->url->link('administration/end_of_day_report', 'token=' . $this->session->data['token'], true);
		$data['monthly_sales_report'] = $this->url->link('administration/monthly_sales_report', 'token=' . $this->session->data['token'], true);
		$data['po_history_report'] = $this->url->link('administration/po_history_report', 'token=' . $this->session->data['token'], true);
		$data['vendor_purchase_history_report'] = $this->url->link('administration/vendor_purchase_history_report', 'token=' . $this->session->data['token'], true);
		$data['below_cost_report'] = $this->url->link('administration/below_cost_report', 'token=' . $this->session->data['token'], true);
		$data['inventory_on_hand_report'] = $this->url->link('administration/inventory_on_hand_report', 'token=' . $this->session->data['token'], true);
		$data['zero_movement_report'] = $this->url->link('administration/zero_movement_report', 'token=' . $this->session->data['token'], true);
		$data['kiosk_item_detail'] = $this->url->link('administration/kiosk_item_detail', 'token=' . $this->session->data['token'], true);
		$data['sales_report'] = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'], true);
		$data['customer_report'] = $this->url->link('administration/customer_report', 'token=' . $this->session->data['token'], true);
		$data['rip_report'] = $this->url->link('administration/rip_report', 'token=' . $this->session->data['token'], true);
		$data['vendor_report'] = $this->url->link('administration/vendor_report', 'token=' . $this->session->data['token'], true);
		$data['scan_data_report'] = $this->url->link('administration/scan_data_report', 'token=' . $this->session->data['token'], true);
		
		$data['sales_item_report'] = $this->url->link('administration/sales_item_report', 'token=' . $this->session->data['token'], true);
		$data['item_delete_void_report'] = $this->url->link('administration/item_delete_void_report', 'token=' . $this->session->data['token'], true);
		$data['product_listing_report'] = $this->url->link('administration/product_listing_report', 'token=' . $this->session->data['token'], true);
		$data['item_movement_report'] = $this->url->link('administration/item_movement_report', 'token=' . $this->session->data['token'], true);
		$data['tax_report'] = $this->url->link('administration/tax_report', 'token=' . $this->session->data['token'], true);
		$data['credit_card_report'] = $this->url->link('administration/credit_card_report', 'token=' . $this->session->data['token'], true);
		$data['employee_report'] = $this->url->link('administration/employee_report', 'token=' . $this->session->data['token'], true);
		$data['hourly_sales_report'] = $this->url->link('administration/hourly_sales_report', 'token=' . $this->session->data['token'], true);

		
		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], true);
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true);

		$this->load->model('administration/plcb_reports');
		$plcb_reports_store = $this->model_administration_plcb_reports->getStore();

		if($plcb_reports_store['plcb_report'] == 'Y'){
			$data['plcb_reports_check'] = true;
		}else{
			$data['plcb_reports_check'] = false;
		}

		if($plcb_reports_store['kiosk'] == 'Y'){
			$data['store_kiosk_check'] = true;
		}else{
			$data['store_kiosk_check'] = false;
		}

		if($this->session->data['webadmin'] == 1){
			$data['webadmin'] = true;
		}else{
			$data['webadmin'] = false;
		}
		return $this->load->view('common/menu', $data);
	}
}
