<?php
class ControllerAdministrationCustomer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/customer');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_customer->addCustomer($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/customer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_customer->editCustomer($this->request->get['icustomerid'],$this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/vendor');
    
		$this->load->model('administration/vendor');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$this->model_administration_vendor->editVendorList($this->request->post);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	 }
	  
	protected function getList() {
		
		if (isset($this->request->get['filter_menuid'])) {
			$filter_menuid = $this->request->get['filter_menuid'];
			$data['filter_menuid'] = $this->request->get['filter_menuid'];
		}else if (isset($this->request->post['filter_menuid'])) {
			$filter_menuid = $this->request->post['filter_menuid'];
			$data['filter_menuid'] = $this->request->post['filter_menuid'];
		}else {
			$filter_menuid = null;
			$data['filter_menuid'] = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'icustomerid';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_menuid'])) {
			$url .= '&filter_menuid=' . urlencode(html_entity_decode($this->request->get['filter_menuid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/customer/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/customer/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/customer/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/customer/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/customer', 'token=' . $this->session->data['token'], true);
		$data['searchcustomer'] = $this->url->link('administration/customer/search_customer', 'token=' . $this->session->data['token'], true);
		
		$data['customers'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');
		
		$customer_total = $this->model_administration_customer->getTotalCustomers($filter_data);

		$results = $this->model_administration_customer->getCustomers($filter_data);
		
		foreach ($results as $result) {
			
			$data['customers'][] = array(
				'icustomerid'     => $result['icustomerid'],
				'vcustomername'   => $result['vcustomername'],
				'vfname'          => $result['vfname'],
				'vlname' 	      => $result['vlname'],
				'vphone'          => $result['vphone'],
				'vaccountnumber'  => $result['vaccountnumber'],
				'estatus'  	      => $result['estatus'],
				'view'            => $this->url->link('administration/customer/info', 'token=' . $this->session->data['token'] . '&icustomerid=' . $result['icustomerid'] . $url, true),
				'edit'            => $this->url->link('administration/customer/edit', 'token=' . $this->session->data['token'] . '&icustomerid=' . $result['icustomerid'] . $url, true),
				'delete'          => $this->url->link('administration/customer/delete', 'token=' . $this->session->data['token'] . '&icustomerid=' . $result['icustomerid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['customers'] =array();
			$customer_total = 0;
			$data['customer_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_first_name'] = $this->language->get('column_first_name');
		$data['column_last_name'] = $this->language->get('column_last_name');
		$data['column_phone'] = $this->language->get('column_phone');
		$data['column_account_number'] = $this->language->get('column_account_number');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');
		
		$data['button_edit_list'] = 'Update Selected';
		$data['text_special'] = '<strong>Special:</strong>';
		
		$data['token'] = $this->session->data['token'];


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['filter_menuid'])) {
			$url .= '&filter_menuid=' . urlencode(html_entity_decode($this->request->get['filter_menuid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customer_total - $this->config->get('config_limit_admin'))) ? $customer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customer_total, ceil($customer_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/customer_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/vendor')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}


  	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['icustomerid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		

		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_account_number'] = $this->language->get('entry_account_number');
		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_state'] = $this->language->get('entry_state');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_zip'] = $this->language->get('entry_zip');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_price_level'] = $this->language->get('entry_price_level');
		$data['entry_debit_limit'] = $this->language->get('entry_debit_limit');
		$data['entry_credit_day'] = $this->language->get('entry_credit_day');

		$data['Taxable'] = $this->language->get('Taxable');
		$data['nontaxable'] = $this->language->get('nontaxable');

		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['price_levels'] = array(
									'0' => '0',
									'2' => 'Level 2',
									'3' => 'Level 3',
									'4' => 'Level 4'
								);

		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['vcustomername'])) {
			$data['error_vcustomername'] = $this->error['vcustomername'];
		} else {
			$data['error_vcustomername'] = '';
		}

		if (isset($this->error['vemail'])) {
			$data['error_vemail'] = $this->error['vemail'];
		} else {
			$data['error_vemail'] = '';
		}

		if (isset($this->error['vaccountnumber'])) {
			$data['error_vaccountnumber'] = $this->error['vaccountnumber'];
		} else {
			$data['error_vaccountnumber'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['icustomerid'])) {
			$data['action'] = $this->url->link('administration/customer/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/customer/edit', 'token=' . $this->session->data['token'] . '&icustomerid=' . $this->request->get['icustomerid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/customer', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['icustomerid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_info = $this->model_administration_customer->getCustomer($this->request->get['icustomerid']);
		}

		$data['token'] = $this->session->data['token'];	
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['vcustomername'])) {
			$data['vcustomername'] = $this->request->post['vcustomername'];
		} elseif (!empty($customer_info)) {
			$data['vcustomername'] = $customer_info['vcustomername'];
		} else {
			$data['vcustomername'] = '';
		}

		if (isset($this->request->post['vaccountnumber'])) {
			$data['vaccountnumber'] = $this->request->post['vaccountnumber'];
		} elseif (!empty($customer_info)) {
			$data['vaccountnumber'] = $customer_info['vaccountnumber'];
		} else {
			$data['vaccountnumber'] = '';
		}

		if (isset($this->request->post['vfname'])) {
			$data['vfname'] = $this->request->post['vfname'];
		} elseif (!empty($customer_info)) {
			$data['vfname'] = $customer_info['vfname'];
		} else {
			$data['vfname'] = '';
		}

		if (isset($this->request->post['vlname'])) {
			$data['vlname'] = $this->request->post['vlname'];
		} elseif (!empty($customer_info)) {
			$data['vlname'] = $customer_info['vlname'];
		} else {
			$data['vlname'] = '';
		}

		if (isset($this->request->post['vaddress1'])) {
			$data['vaddress1'] = $this->request->post['vaddress1'];
		} elseif (!empty($customer_info)) {
			$data['vaddress1'] = $customer_info['vaddress1'];
		} else {
			$data['vaddress1'] = '';
		}

		if (isset($this->request->post['vcity'])) {
			$data['vcity'] = $this->request->post['vcity'];
		} elseif (!empty($customer_info)) {
			$data['vcity'] = $customer_info['vcity'];
		} else {
			$data['vcity'] = '';
		}

		if (isset($this->request->post['vstate'])) {
			$data['vstate'] = $this->request->post['vstate'];
		} elseif (!empty($customer_info)) {
			$data['vstate'] = $customer_info['vstate'];
		} else {
			$data['vstate'] = '';
		}

		if (isset($this->request->post['vzip'])) {
			$data['vzip'] = $this->request->post['vzip'];
		} elseif (!empty($customer_info)) {
			$data['vzip'] = $customer_info['vzip'];
		} else {
			$data['vzip'] = '';
		}

		if (isset($this->request->post['vcountry'])) {
			$data['vcountry'] = $this->request->post['vcountry'];
		} elseif (!empty($customer_info)) {
			$data['vcountry'] = $customer_info['vcountry'];
		} else {
			$data['vcountry'] = '';
		}

		if (isset($this->request->post['vphone'])) {
			$data['vphone'] = $this->request->post['vphone'];
		} elseif (!empty($customer_info)) {
			$data['vphone'] = $customer_info['vphone'];
		} else {
			$data['vphone'] = '';
		}

		if (isset($this->request->post['vemail'])) {
			$data['vemail'] = $this->request->post['vemail'];
		} elseif (!empty($customer_info)) {
			$data['vemail'] = $customer_info['vemail'];
		} else {
			$data['vemail'] = '';
		}

		if (isset($this->request->post['vemail'])) {
			$data['vemail'] = $this->request->post['vemail'];
		} elseif (!empty($customer_info)) {
			$data['vemail'] = $customer_info['vemail'];
		} else {
			$data['vemail'] = '';
		}

		if (isset($this->request->post['pricelevel'])) {
			$data['pricelevel'] = $this->request->post['pricelevel'];
		} elseif (!empty($customer_info)) {
			$data['pricelevel'] = $customer_info['pricelevel'];
		} else {
			$data['pricelevel'] = '0';
		}

		if (isset($this->request->post['debitlimit'])) {
			$data['debitlimit'] = $this->request->post['debitlimit'];
		} elseif (!empty($customer_info)) {
			$data['debitlimit'] = $customer_info['debitlimit'];
		} else {
			$data['debitlimit'] = '0.00';
		}

		if (isset($this->request->post['creditday'])) {
			$data['creditday'] = $this->request->post['creditday'];
		} elseif (!empty($customer_info)) {
			$data['creditday'] = $customer_info['creditday'];
		} else {
			$data['creditday'] = '0';
		}

		if (isset($this->request->post['note'])) {
			$data['note'] = $this->request->post['note'];
		} elseif (!empty($customer_info)) {
			$data['note'] = $customer_info['note'];
		} else {
			$data['note'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/customer_form', $data));
	}


	protected function validateForm() {
		
		$this->load->model('administration/customer');
		
		if (!$this->user->hasPermission('modify', 'administration/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['vcustomername'] == '')) {
			$this->error['vcustomername']= 'Please Enter Customer';
		}

		if (($this->request->post['vcustomername'] != '')) {
			$len = strlen($this->request->post['vcustomername']);
			
			if($len < 3){
				$this->error['vcustomername']= 'customer must be greater than 3 characters!';
			}
			
		}

		if(isset($this->request->get['icustomerid']) && $this->request->get['icustomerid'] != ''){
			$cstmr = $this->model_administration_customer->getCustomer($this->request->get['icustomerid']);
			if($cstmr['vaccountnumber'] != $this->request->post['vaccountnumber']){
				$ac_number = $this->model_administration_customer->getAcNumber($this->request->post['vaccountnumber']);
				if($ac_number > 0){
					$this->error['vaccountnumber']= 'Account Number Already Exist';
				}
			}
		}else{
			$ac_number = $this->model_administration_customer->getAcNumber($this->request->post['vaccountnumber']);
				if($ac_number > 0){
					$this->error['vaccountnumber']= 'Account Number Already Exist';
				}
		}

		if (($this->request->post['vemail'] != '')) {
			if (!filter_var($this->request->post['vemail'], FILTER_VALIDATE_EMAIL)) {
			  $this->error['vemail']= 'Please Enter Valid Email Address';
			}
		}

		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	public function search_customer(){
		$return = array();
		$this->load->model('api/customer');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_customer->getCustomersSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['icustomerid'] = $value['icustomerid'];
				$temp['vcustomername'] = $value['vcustomername'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
