<?php
class ControllerCommonHeader extends Controller {
	
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		if(isset($this->session->data['db_database2']))
		{		
			$this->config->set('db_database2',$this->session->data['db_database2']);
			if(isset($this->session->data['storename'])){
				$data['storename'] = $this->session->data['storename'];
			}else{
				$data['storename'] = '';
			}
			
			if(isset($this->session->data['sid'])){
				$data['sid'] = $this->session->data['sid'];
			}else{
				$data['sid'] = '';
			}
		}
		
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->load->language('common/header');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = $this->language->get('text_logout');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', true);
		} else {
			$data['logged'] = true;
			
			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], true);
			
			$data['token'] = $this->session->data['token'];
			$this->load->model('kiosk/stores');
			$data['stores'] = array();
			if($this->session->data['store_array']){
				$data['stores'] = $this->session->data['store_array'];
			}

			$this->load->language('common/menu');

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

			$data['text_settings'] = $this->language->get('text_settings');	

			$data['settings'] = $this->url->link('administration/end_of_shift_printing', 'token=' . $this->session->data['token'], true);
			$data['dashboard_quick_links'] = $this->url->link('common/dashboard/dashboard_quick_links', 'token=' . $this->session->data['token'], true);

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
		}

		return $this->load->view('common/header', $data);
	}
	
	public function changestore($id=''){
		
		if(isset($this->request->get['id'])){
			$this->load->model('kiosk/stores');		
			$store=$this->model_kiosk_stores->getStore($this->request->get['id']);
			//print_r($store);
			
			unset($this->session->data['db2']);
			unset($this->session->data['db_hostname2']);
			unset($this->session->data['db_username2']);
			unset($this->session->data['db_password2']);
			unset($this->session->data['db_database2']);
						
			$this->session->data['db_hostname2'] = $store['db_hostname'];
			$this->session->data['db_username2'] = $store['db_username'];
			$this->session->data['db_password2'] = $store['db_password'];
			$this->session->data['db_database2'] = $store['db_name'];
			$this->session->data['db_port2'] = '3306';
			
			$this->config->set('db_database2',$store['db_name']);
			
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		 }
		 else
		 {
			// $this->registry->set('db2', new DB(DB_DRIVER2, DB_HOSTNAME2, DB_USERNAME2, DB_PASSWORD2, DB_DATABASE2, DB_PORT2));
			 //$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
	}
}
