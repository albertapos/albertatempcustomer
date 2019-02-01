<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');


		$data['age_verification'] =  $this->url->link('administration/age_verification', 'token=' . $this->session->data['token'], true);
		$data['category'] =  $this->url->link('administration/category', 'token=' . $this->session->data['token'], true);
		$data['customer'] =  $this->url->link('administration/customer', 'token=' . $this->session->data['token'], true);
		$data['department'] =  $this->url->link('administration/department', 'token=' . $this->session->data['token'], true);
		$data['paid_out'] =  $this->url->link('administration/paid_out', 'token=' . $this->session->data['token'], true);
		$data['store_setting'] =  $this->url->link('administration/store_setting', 'token=' . $this->session->data['token'], true);
		$data['users'] =  $this->url->link('administration/users', 'token=' . $this->session->data['token'], true);
		$data['user_groups'] =  $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'], true);
		$data['tax'] =  $this->url->link('administration/tax', 'token=' . $this->session->data['token'], true);
		$data['vendor'] =  $this->url->link('administration/vendor', 'token=' . $this->session->data['token'], true);
		
		$data['below_cost_report'] =  $this->url->link('administration/below_cost_report', 'token=' . $this->session->data['token'], true);
		$data['cash_sales_summary'] =  $this->url->link('administration/cash_sales_summary', 'token=' . $this->session->data['token'], true);
		$data['end_of_day_report'] =  $this->url->link('administration/end_of_day_report', 'token=' . $this->session->data['token'], true);
		$data['inventory_on_hand_report'] =  $this->url->link('administration/inventory_on_hand_report', 'token=' . $this->session->data['token'], true);
		$data['kiosk_item_detail'] =  $this->url->link('administration/kiosk_item_detail', 'token=' . $this->session->data['token'], true);
		$data['monthly_sales_report'] =  $this->url->link('administration/monthly_sales_report', 'token=' . $this->session->data['token'], true);
		$data['plcb_reports'] =  $this->url->link('administration/plcb_reports', 'token=' . $this->session->data['token'], true);
		$data['po_history_report'] =  $this->url->link('administration/po_history_report', 'token=' . $this->session->data['token'], true);
		$data['profit_loss'] =  $this->url->link('administration/profit_loss', 'token=' . $this->session->data['token'], true);
		$data['zero_movement_report'] =  $this->url->link('administration/zero_movement_report', 'token=' . $this->session->data['token'], true);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		//$data['order'] = $this->load->controller('dashboard/order');
		//$data['sale'] = $this->load->controller('dashboard/sale');
		//$data['customer'] = $this->load->controller('dashboard/customer');
		//$data['online'] = $this->load->controller('dashboard/online');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->load->model('administration/plcb_reports');
		$plcb_reports_store = $this->model_administration_plcb_reports->getStore();

		if($plcb_reports_store['plcb_report'] == 'Y'){
			$data['plcb_reports_check'] = true;
		}else{
			$data['plcb_reports_check'] = false;
		}

		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}

}