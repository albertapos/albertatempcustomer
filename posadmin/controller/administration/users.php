<?php
class ControllerAdministrationUsers extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/users');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/users');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/users');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/users');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_users->addUser($this->request->post);

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

			$this->response->redirect($this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/users');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/users');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_administration_users->editUser($this->request->get['iuserid'],$this->request->post);

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

			$this->response->redirect($this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
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
			$sort = 'iuserid';
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
			'href' => $this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/users/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/users/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/users/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/users/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['users'] = array();

		$filter_data = array(
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');
		
		$users_total = $this->model_administration_users->getTotalUsers();

		$results = $this->model_administration_users->getUsers($filter_data);
		
		foreach ($results as $result) {
			
			$data['users'][] = array(
				'iuserid'         => $result['iuserid'],
				'vfname'          => $result['vfname'],
				'vlname'          => $result['vlname'],
				'vphone'          => $result['vphone'],
				'vemail'          => $result['vemail'],
				'vuserid'         => $result['vuserid'],
				'vusertype'       => $result['vusertype'],
				'vuserbarcode'    => $result['vuserbarcode'],
				'estatus'         => $result['estatus'],
				'edit'            => $this->url->link('administration/users/edit', 'token=' . $this->session->data['token'] . '&iuserid=' . $result['iuserid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['users'] =array();
			$users_total = 0;
			$data['users_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_first_name'] = $this->language->get('column_first_name');
		$data['column_last_name'] = $this->language->get('column_last_name');
		$data['column_phone'] = $this->language->get('column_phone');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_user_id'] = $this->language->get('column_user_id');
		$data['column_user_type'] = $this->language->get('column_user_type');
		$data['column_print_barcode'] = $this->language->get('column_print_barcode');
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
		$pagination->total = $users_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($users_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($users_total - $this->config->get('config_limit_admin'))) ? $users_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $users_total, ceil($users_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/users_list', $data));
	}
	

  	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['iuserid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_unlock'] = $this->language->get('text_unlock');

		$data['entry_first_name'] = $this->language->get('entry_first_name');
		$data['entry_last_name'] = $this->language->get('entry_last_name');
		$data['entry_address1'] = $this->language->get('entry_address1');
		$data['entry_address2'] = $this->language->get('entry_address2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_state'] = $this->language->get('entry_state');
		$data['entry_zip'] = $this->language->get('entry_zip');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_user_id'] = $this->language->get('entry_user_id');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_re_type_password'] = $this->language->get('entry_re_type_password');
		$data['entry_user_type'] = $this->language->get('entry_user_type');
		$data['entry_is_user_locked'] = $this->language->get('entry_is_user_locked');
		$data['entry_change_password_at_first_login'] = $this->language->get('entry_change_password_at_first_login');
		$data['entry_barcode'] = $this->language->get('entry_barcode');
		$data['entry_Status'] = $this->language->get('entry_Status');
		

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

		if (isset($this->error['vfname'])) {
			$data['error_vfname'] = $this->error['vfname'];
		} else {
			$data['error_vfname'] = '';
		}

		if (isset($this->error['vlname'])) {
			$data['error_vlname'] = $this->error['vlname'];
		} else {
			$data['error_vlname'] = '';
		}

		if (isset($this->error['vaddress1'])) {
			$data['error_vaddress1'] = $this->error['vaddress1'];
		} else {
			$data['error_vaddress1'] = '';
		}

		if (isset($this->error['vemail'])) {
			$data['error_vemail'] = $this->error['vemail'];
		} else {
			$data['error_vemail'] = '';
		}

		if (isset($this->error['vuserid'])) {
			$data['error_vuserid'] = $this->error['vuserid'];
		} else {
			$data['error_vuserid'] = '';
		}

		if (isset($this->error['vpassword'])) {
			$data['error_vpassword'] = $this->error['vpassword'];
		} else {
			$data['error_vpassword'] = '';
		}

		if (isset($this->error['re_vpassword'])) {
			$data['error_re_vpassword'] = $this->error['re_vpassword'];
		} else {
			$data['error_re_vpassword'] = '';
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
			'href' => $this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['iuserid'])) {
			$data['action'] = $this->url->link('administration/users/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/users/edit', 'token=' . $this->session->data['token'] . '&iuserid=' . $this->request->get['iuserid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/users', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['iuserid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$users_info = $this->model_administration_users->getUser($this->request->get['iuserid']);
		}

		$data['token'] = $this->session->data['token'];	
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['vfname'])) {
			$data['vfname'] = $this->request->post['vfname'];
		} elseif (!empty($users_info)) {
			$data['vfname'] = $users_info['vfname'];
		} else {
			$data['vfname'] = '';
		}

		if (isset($this->request->post['vlname'])) {
			$data['vlname'] = $this->request->post['vlname'];
		} elseif (!empty($users_info)) {
			$data['vlname'] = $users_info['vlname'];
		} else {
			$data['vlname'] = '';
		}

		if (isset($this->request->post['vaddress1'])) {
			$data['vaddress1'] = $this->request->post['vaddress1'];
		} elseif (!empty($users_info)) {
			$data['vaddress1'] = $users_info['vaddress1'];
		} else {
			$data['vaddress1'] = '';
		}

		if (isset($this->request->post['vaddress2'])) {
			$data['vaddress2'] = $this->request->post['vaddress2'];
		} elseif (!empty($users_info)) {
			$data['vaddress2'] = $users_info['vaddress2'];
		} else {
			$data['vaddress2'] = '';
		}

		if (isset($this->request->post['vcity'])) {
			$data['vcity'] = $this->request->post['vcity'];
		} elseif (!empty($users_info)) {
			$data['vcity'] = $users_info['vcity'];
		} else {
			$data['vcity'] = '';
		}

		if (isset($this->request->post['vstate'])) {
			$data['vstate'] = $this->request->post['vstate'];
		} elseif (!empty($users_info)) {
			$data['vstate'] = $users_info['vstate'];
		} else {
			$data['vstate'] = '';
		}

		if (isset($this->request->post['vzip'])) {
			$data['vzip'] = $this->request->post['vzip'];
		} elseif (!empty($users_info)) {
			$data['vzip'] = $users_info['vzip'];
		} else {
			$data['vzip'] = '';
		}

		if (isset($this->request->post['vcountry'])) {
			$data['vcountry'] = $this->request->post['vcountry'];
		} elseif (!empty($users_info)) {
			$data['vcountry'] = $users_info['vcountry'];
		} else {
			$data['vcountry'] = '';
		}

		if (isset($this->request->post['vphone'])) {
			$data['vphone'] = $this->request->post['vphone'];
		} elseif (!empty($users_info)) {
			$data['vphone'] = $users_info['vphone'];
		} else {
			$data['vphone'] = '';
		}

		if (isset($this->request->post['vemail'])) {
			$data['vemail'] = $this->request->post['vemail'];
		} elseif (!empty($users_info)) {
			$data['vemail'] = $users_info['vemail'];
		} else {
			$data['vemail'] = '';
		}

		if (isset($this->request->post['vuserid'])) {
			$data['vuserid'] = $this->request->post['vuserid'];
		} elseif (!empty($users_info)) {
			$data['vuserid'] = $users_info['vuserid'];
		} else {
			$data['vuserid'] = '';
		}

		if (isset($this->request->post['vpassword'])) {
			$data['vpassword'] = $this->request->post['vpassword'];
		} elseif (!empty($users_info)) {
			$data['vpassword'] = $users_info['vpassword'];
		} else {
			$data['vpassword'] = '';
		}

		if (isset($this->request->post['vusertype'])) {
			$data['vusertype'] = $this->request->post['vusertype'];
		} elseif (!empty($users_info)) {
			$data['vusertype'] = $users_info['vusertype'];
		} else {
			$data['vusertype'] = '';
		}

		if (isset($this->request->post['vlocktype'])) {
			$data['vlocktype'] = $this->request->post['vlocktype'];
		} elseif (!empty($users_info)) {
			$data['vlocktype'] = $users_info['vlocktype'];
		} else {
			$data['vlocktype'] = '';
		}

		if (isset($this->request->post['vpasswordchange'])) {
			$data['vpasswordchange'] = $this->request->post['vpasswordchange'];
		} elseif (!empty($users_info)) {
			$data['vpasswordchange'] = $users_info['vpasswordchange'];
		} else {
			$data['vpasswordchange'] = '';
		}

		if (isset($this->request->post['vuserbarcode'])) {
			$data['vuserbarcode'] = $this->request->post['vuserbarcode'];
		} elseif (!empty($users_info)) {
			$data['vuserbarcode'] = $users_info['vuserbarcode'];
		} else {
			$data['vuserbarcode'] = '';
		}
		
		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($users_info)) {
			$data['estatus'] = $users_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		$data['user_types'] = $this->model_administration_users->getUserTypes();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/users_form', $data));
	}


	protected function validateForm() {
		
		$this->load->model('administration/users');
		
		if (!$this->user->hasPermission('modify', 'administration/users')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (($this->request->post['vfname'] == '')) {
			$this->error['vfname']= 'Please Enter First Name';
		}

		if (($this->request->post['vlname'] == '')) {
			$this->error['vlname']= 'Please Enter Last Name';
		}

		if (($this->request->post['vaddress1'] == '')) {
			$this->error['vaddress1']= 'Please Enter Address';
		}

		if (($this->request->post['vemail'] == '')) {
			$this->error['vemail']= 'Please Enter Email';
		}

		$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9-_\.]+\@([a-zA-Z0-9-_\.]+\.)+[a-zA-Z]+$/";
		if (!preg_match($email_pattern, $this->request->post['vemail'])) {
			$this->error['vemail']= 'Please Enter Valid Email';
		}

		if (($this->request->post['vuserid'] == '')) {
			$this->error['vuserid']= 'Please Enter User ID';
		}

		if (!is_numeric($this->request->post['vuserid'])) {
			$this->error['vuserid']= 'Please Enter Numeric User ID';
		}

		if(strlen($this->request->post['vuserid']) < 3){
			$this->error['vuserid']= 'User ID must be three number ';
		}

		if(strlen($this->request->post['vuserid']) == 3){
			$unique_userid = $this->model_administration_users->getUserID($this->request->post['vuserid']);
			
			if(isset($this->request->get['iuserid'])){

				$users_info = $this->model_administration_users->getUser($this->request->get['iuserid']);
				
				if($this->request->post['vuserid'] != $users_info['vuserid']){
					if(count($unique_userid) > 0 ){
						$this->error['vuserid']= 'Entered the same user id';
					}
				}
			}else if(count($unique_userid) > 0){
				$this->error['vuserid']= 'Entered the same user id';
			}
		}

		if (($this->request->post['vpassword'] == '')) {
			$this->error['vpassword']= 'Please Enter Password';
		}

		if(strlen($this->request->post['vpassword']) < 4){
			$this->error['vpassword']= 'Password must be four characters ';
		}

		if(strlen($this->request->post['vpassword']) > 4){
			$this->error['vpassword']= 'Password must be four characters ';
		}

		if (($this->request->post['re_vpassword'] == '')) {
			$this->error['re_vpassword']= 'Please Enter Re-Type Password';
		}

		if(strlen($this->request->post['re_vpassword']) < 4){
			$this->error['re_vpassword']= 'Re Password must be four characters ';
		}

		if($this->request->post['vpassword'] != '' && $this->request->post['re_vpassword'] != '' && ($this->request->post['vpassword'] != $this->request->post['re_vpassword'])){
			$this->error['re_vpassword']= 'Password not match';
		}

		
		return !$this->error;
	}
	
}
