<?php
class ControllerAdministrationVendor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/vendor');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/vendor');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_vendor->addVendor($this->request->post);

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

			$this->response->redirect($this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/vendor');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/vendor');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_vendor->editVendor($this->request->get['isupplierid'],$this->request->post);

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

			$this->response->redirect($this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true));
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
			$sort = 'isupplierid';
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

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/vendor/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/vendor/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/vendor/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/vendor/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/vendor', 'token=' . $this->session->data['token'], true);
		$data['searchvendor'] = $this->url->link('administration/vendor/search_vendor', 'token=' . $this->session->data['token'], true);
		
		$data['vendors'] = array();

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
		
		$vendor_total = $this->model_administration_vendor->getTotalVendors($filter_data);

		$results = $this->model_administration_vendor->getVendors($filter_data);
		
		foreach ($results as $result) {
			
			$data['vendors'][] = array(
				'isupplierid'  => $result['isupplierid'],
				'vcode'        => $result['vcode'],
				'vcompanyname' => $result['vcompanyname'],
				'vphone' 	   => $result['vphone'],
				'vemail'       => $result['vemail'],
				'estatus'  	   => $result['estatus'],
				'view'         => $this->url->link('administration/vendor/info', 'token=' . $this->session->data['token'] . '&isupplierid=' . $result['isupplierid'] . $url, true),
				'edit'         => $this->url->link('administration/vendor/edit', 'token=' . $this->session->data['token'] . '&isupplierid=' . $result['isupplierid'] . $url, true),
				'delete'       => $this->url->link('administration/vendor/delete', 'token=' . $this->session->data['token'] . '&isupplierid=' . $result['isupplierid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['vendors'] =array();
			$category_total = 0;
			$data['vendor_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_vendor_code'] = $this->language->get('column_vendor_code');
		$data['column_vendor_name'] = $this->language->get('column_vendor_name');
		$data['column_phone'] = $this->language->get('column_phone');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

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
		$pagination->total = $vendor_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vendor_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($vendor_total - $this->config->get('config_limit_admin'))) ? $vendor_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $vendor_total, ceil($vendor_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/vendor_list', $data));
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

		$data['text_form'] = !isset($this->request->get['isupplierid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		

		$data['entry_vendor_name'] = $this->language->get('entry_vendor_name');
		$data['entry_vendor_type'] = $this->language->get('entry_vendor_type');
		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_vendor_code'] = $this->language->get('entry_vendor_code');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_state'] = $this->language->get('entry_state');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_zip'] = $this->language->get('entry_zip');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['text_vendor'] = $this->language->get('Vendor');
		$data['text_other'] = $this->language->get('Other');
		$data['entry_plcb_type'] = $this->language->get('entry_plcb_type');

		$data['schedules'][] = 'None';
		$data['schedules'][] = $this->language->get('text_schedule_A');
		$data['schedules'][] = $this->language->get('text_schedule_B');
		$data['schedules'][] = $this->language->get('text_schedule_C');

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

		if (isset($this->error['vcompanyname'])) {
			$data['error_vcompanyname'] = $this->error['vcompanyname'];
		} else {
			$data['error_vcompanyname'] = '';
		}

		if (isset($this->error['vemail'])) {
			$data['error_vemail'] = $this->error['vemail'];
		} else {
			$data['error_vemail'] = '';
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
			'href' => $this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['isupplierid'])) {
			$data['action'] = $this->url->link('administration/vendor/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/vendor/edit', 'token=' . $this->session->data['token'] . '&isupplierid=' . $this->request->get['isupplierid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/vendor', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['isupplierid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$vendor_info = $this->model_administration_vendor->getVendor($this->request->get['isupplierid']);
		}

		$data['token'] = $this->session->data['token'];	
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['vcompanyname'])) {
			$data['vcompanyname'] = $this->request->post['vcompanyname'];
		} elseif (!empty($vendor_info)) {
			$data['vcompanyname'] = $vendor_info['vcompanyname'];
		} else {
			$data['vcompanyname'] = '';
		}
		

		if (isset($this->request->post['vvendortype'])) {
			$data['vvendortype'] = $this->request->post['vvendortype'];
		} elseif (!empty($vendor_info)) {
			$data['vvendortype'] = $vendor_info['vvendortype'];
		} else {
			$data['vvendortype'] = '';
		}

		if (isset($this->request->post['vfnmae'])) {
			$data['vfnmae'] = $this->request->post['vfnmae'];
		} elseif (!empty($vendor_info)) {
			$data['vfnmae'] = $vendor_info['vfnmae'];
		} else {
			$data['vfnmae'] = '';
		}

		if (isset($this->request->post['vlname'])) {
			$data['vlname'] = $this->request->post['vlname'];
		} elseif (!empty($vendor_info)) {
			$data['vlname'] = $vendor_info['vlname'];
		} else {
			$data['vlname'] = '';
		}

		if (isset($this->request->post['vcode'])) {
			$data['vcode'] = $this->request->post['vcode'];
		} elseif (!empty($vendor_info)) {
			$data['vcode'] = $vendor_info['vcode'];
		} else {
			$data['vcode'] = '';
		}

		if (isset($this->request->post['vaddress1'])) {
			$data['vaddress1'] = $this->request->post['vaddress1'];
		} elseif (!empty($vendor_info)) {
			$data['vaddress1'] = $vendor_info['vaddress1'];
		} else {
			$data['vaddress1'] = '';
		}

		if (isset($this->request->post['vcity'])) {
			$data['vcity'] = $this->request->post['vcity'];
		} elseif (!empty($vendor_info)) {
			$data['vcity'] = $vendor_info['vcity'];
		} else {
			$data['vcity'] = '';
		}

		if (isset($this->request->post['vstate'])) {
			$data['vstate'] = $this->request->post['vstate'];
		} elseif (!empty($vendor_info)) {
			$data['vstate'] = $vendor_info['vstate'];
		} else {
			$data['vstate'] = '';
		}

		if (isset($this->request->post['vphone'])) {
			$data['vphone'] = $this->request->post['vphone'];
		} elseif (!empty($vendor_info)) {
			$data['vphone'] = $vendor_info['vphone'];
		} else {
			$data['vphone'] = '';
		}

		if (isset($this->request->post['vzip'])) {
			$data['vzip'] = $this->request->post['vzip'];
		} elseif (!empty($vendor_info)) {
			$data['vzip'] = $vendor_info['vzip'];
		} else {
			$data['vzip'] = '';
		}

		if (isset($this->request->post['vcountry'])) {
			$data['vcountry'] = $this->request->post['vcountry'];
		} elseif (!empty($vendor_info)) {
			$data['vcountry'] = $vendor_info['vcountry'];
		} else {
			$data['vcountry'] = '';
		}

		if (isset($this->request->post['vemail'])) {
			$data['vemail'] = $this->request->post['vemail'];
		} elseif (!empty($vendor_info)) {
			$data['vemail'] = $vendor_info['vemail'];
		} else {
			$data['vemail'] = '';
		}

		if (isset($this->request->post['plcbtype'])) {
			$data['plcbtype'] = $this->request->post['plcbtype'];
		} elseif (!empty($vendor_info)) {
			$data['plcbtype'] = $vendor_info['plcbtype'];
		} else {
			$data['plcbtype'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/vendor_form', $data));
	}


	protected function validateForm() {
		
		$this->load->model('administration/vendor');
		
		if (!$this->user->hasPermission('modify', 'administration/vendor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['vcompanyname'] == '')) {
			$this->error['vcompanyname']= 'Please Enter Vendor Name';
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

	public function search_vendor(){
		$return = array();
		$this->load->model('api/vendor');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_vendor->getVendorSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['isupplierid'] = $value['isupplierid'];
				$temp['vcompanyname'] = $value['vcompanyname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
