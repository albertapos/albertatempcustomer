<?php
class ControllerAdministrationStoreSetting extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('administration/store_setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/store_setting');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/store_setting');
    
		$this->load->model('administration/store_setting');
		$this->load->model('api/store_setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$datas = $this->request->post['store_setting'];
			// $this->model_administration_store_setting->editStoreSettingList($this->request->post);
			$this->model_api_store_setting->editlistStoreSettings($datas);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/store_setting', 'token=' . $this->session->data['token'] . $url, true));
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
			$sort = 'Id';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/store_setting', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/store_setting/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/store_setting/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/store_setting/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/store_setting/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['store_settings'] = array();

		$filter_data = array(
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/store_setting');

		// $results = $this->model_administration_store_setting->getStoreSettings($filter_data);
		$results = $this->model_api_store_setting->getStoreSettings();

		$data['store_settings'] = array();

		foreach ($results as $key => $result) {
			$data['store_settings'][$result['vsettingname']] = $result;
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_setting_name'] = $this->language->get('column_setting_name');
		$data['column_setting_value'] = $this->language->get('column_setting_value');

		// $data['Yes'] = $this->language->get('text_yes');
		// $data['No'] = $this->language->get('text_no');
		$data['arr_y_n'][] = $this->language->get('text_no');
		$data['arr_y_n'][] = $this->language->get('text_yes');

		$data['None'] = $this->language->get('text_none');

		$data['time_arr'] = array("12:00 am","01:00 am","02:00 am","03:00 am","04:00 am","05:00 am","06:00 am","07:00 am","08:00 am","09:00 am","10:00 am","11:00 am","12:00 pm","01:00 pm","02:00 pm","03:00 pm","04:00 pm","05:00 pm","06:00 pm","07:00 pm","08:00 pm","09:00 pm","10:00 pm","11:00 pm");

		
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/store_setting_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/tax')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
	
}
