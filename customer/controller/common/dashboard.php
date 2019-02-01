<?php
class ControllerCommonDashboard extends Controller {
	public function index() {

		//change store
		if($this->request->server['REQUEST_METHOD'] == 'POST'){
			$userid = $this->session->data['user_id'];
			$roleid = $this->session->data['role_id'];
			$storeid = $this->request->post['change_store_id'];

			$this->user->changeStore($userid,$roleid,$storeid);

			$this->session->data['sid'] = $storeid;
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
		//change store

		$username = $this->session->data['logged_email'];
		$pass = $this->session->data['logged_password'];
		$store_id = $this->session->data['sid'];
		$api = 'https://portal.insloc.com';
		$url = $api.'/authenticate?email='.$username.'&password='.$pass;
  	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_POST => 1
		));
		$data1 = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);

		$data1 = json_decode($data1);

		$token = $data1->token;

      	$data['dashboard_charts_token'] = $token;
      	$data['sid'] = $this->session->data['sid'];
      	$data['api'] = $api;

      	$this->load->model('common/dashboard');

      	//EST time Zone
      	date_default_timezone_set('US/Eastern');
   		
      	$date = date('Y-m-d');
        $fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));

        $data['date'] = $date;
        $data['fdate'] = $fdate;
        $data['tdate'] = $tdate;

        $sales = $this->model_common_dashboard->getSales($date);
        $customers = $this->model_common_dashboard->getCustomers($date);
        $void = $this->model_common_dashboard->getVoid($date);

        $url_7daysales = $api.'/api/admin/7daysSales?fdate='.$fdate.'&tdate='.$tdate.'&token='.$token.'&sid='.$store_id;

        $sevendaysales = $this->model_common_dashboard->getchartsValues($url_7daysales);

        $url_7daysCustomer = $api.'/api/admin/7daysCustomer?fdate='.$fdate.'&tdate='.$tdate.'&token='.$token.'&sid='.$store_id;

        $sevendaysCustomer = $this->model_common_dashboard->getchartsValues($url_7daysCustomer);

        $url_topCategory = $api.'/api/admin/topCategory?fdate='.$fdate.'&tdate='.$tdate.'&token='.$token.'&sid='.$store_id;

        $topCategory = $this->model_common_dashboard->getchartsValues($url_topCategory);

        $url_topItem = $api.'/api/admin/topItem?fdate='.$fdate.'&tdate='.$tdate.'&token='.$token.'&sid='.$store_id;

        $topItem = $this->model_common_dashboard->getchartsValues($url_topItem);

        $url_dailySummary = $api.'/api/admin/dailySummary?fdate='.$date.'&tdate='.$date.'&token='.$token.'&sid='.$store_id;

        $dailySummary = $this->model_common_dashboard->getchartsValues($url_dailySummary);
        
        $url_customer = $api.'/api/admin/customer?fdate='.$fdate.'&tdate='.$tdate.'&token='.$token.'&sid='.$store_id;

        $customer = $this->model_common_dashboard->getchartsValues($url_customer);

        $data['sales'] = $sales;
        $data['customers'] = $customers;
        $data['void'] = $void;

        $data['sevendaysales'] = $sevendaysales;
        $data['sevendaysCustomer'] = $sevendaysCustomer;
        $data['topCategory'] = $topCategory;
        $data['topItem'] = $topItem;
        $data['dailySummary'] = $dailySummary;
        $data['customer'] = $customer;

		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');

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

		$data['dashboard_quick_links'] = $this->url->link('common/dashboard/dashboard_quick_links', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}

	public function dashboard_quick_links() {
		
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
		$data['items'] =  $this->url->link('administration/items', 'token=' . $this->session->data['token'], true);
        $data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
		
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
        $data['sales_report'] = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'], true);
	$data['item_movement_report'] = $this->url->link('administration/item_movement_report', 'token=' . $this->session->data['token'], true);

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

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('common/dashboard_quick_links', $data));
	}

}
