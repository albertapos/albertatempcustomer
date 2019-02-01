<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_system'] = $this->language->get('text_system');
		
		$data['text_administration'] = $this->language->get('text_administration');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_department'] = $this->language->get('text_department');
		
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_paid_out'] = $this->language->get('text_paid_out');
		$data['text_store_setting'] = $this->language->get('text_store_setting');
		$data['text_vendor'] = $this->language->get('text_vendor');
		$data['text_age_verification'] = $this->language->get('text_age_verification');
		$data['text_user_groups'] = $this->language->get('text_user_groups');
		
		$data['text_items'] = $this->language->get('text_items');
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
		
		$data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], true);
		$data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], true);

		$this->load->model('administration/plcb_reports');
		$plcb_reports_store = $this->model_administration_plcb_reports->getStore();

		if($plcb_reports_store['plcb_report'] == 'Y'){
			$data['plcb_reports_check'] = true;
		}else{
			$data['plcb_reports_check'] = false;
		}

		return $this->load->view('common/menu', $data);
	}
}
