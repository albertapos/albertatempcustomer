<?php
class ControllerAdministrationUserGroups extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/user_groups');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/user_groups');

		$this->getList();
	}

	public function edit() {

		$this->load->language('administration/user_groups');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/user_groups');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_administration_user_groups->editUserGroup($this->request->get['ipermissiongroupid'],$this->request->post);

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

			$this->response->redirect($this->url->link('administration/user_groups', 'token=' . $this->session->data['token'] . $url, true));
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
			$sort = 'ipermissiongroupid';
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
			'href' => $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/user_groups/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/user_groups/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/user_groups/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/user_groups/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['user_groups'] = array();

		$filter_data = array(
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');
		
		$user_groups_total = $this->model_administration_user_groups->getTotalUserGroups($filter_data);

		$results = $this->model_administration_user_groups->getUserGroups($filter_data);
		
		foreach ($results as $result) {
			
			$data['user_groups'][] = array(
				'ipermissiongroupid'  => $result['ipermissiongroupid'],
				'vgroupname'          => $result['vgroupname'],
				'estatus'             => $result['estatus'],
				'view'                => $this->url->link('administration/user_groups/info', 'token=' . $this->session->data['token'] . '&ipermissiongroupid=' . $result['ipermissiongroupid'] . $url, true),
				'edit'                => $this->url->link('administration/user_groups/edit', 'token=' . $this->session->data['token'] . '&ipermissiongroupid=' . $result['ipermissiongroupid'] . $url, true),
				'delete'              => $this->url->link('administration/user_groups/delete', 'token=' . $this->session->data['token'] . '&ipermissiongroupid=' . $result['ipermissiongroupid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['user_groups'] =array();
			$user_groups_total = 0;
			$data['user_groups_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_active'] = $this->language->get('Active');
		$data['text_inactive'] = $this->language->get('Inactive');
		
		$data['column_group_name'] = $this->language->get('column_group_name');
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
		$pagination->total = $user_groups_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($user_groups_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($user_groups_total - $this->config->get('config_limit_admin'))) ? $user_groups_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $user_groups_total, ceil($user_groups_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/user_groups_list', $data));
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

		$data['text_form'] = !isset($this->request->get['ipermissiongroupid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_group_name'] = $this->language->get('entry_group_name');
		$data['entry_permission'] = $this->language->get('entry_permission');
		$data['entry_Status'] = $this->language->get('entry_Status');
		
		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

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
			'href' => $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['ipermissiongroupid'])) {
			$data['action'] = $this->url->link('administration/user_groups/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/user_groups/edit', 'token=' . $this->session->data['token'] . '&ipermissiongroupid=' . $this->request->get['ipermissiongroupid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/user_groups', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['ipermissiongroupid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$user_groups_info = $this->model_administration_user_groups->getUserGroup($this->request->get['ipermissiongroupid']);
		}

		$data['user_permissions'] = array();

		$permissions = $this->model_administration_user_groups->getUserPermissions();

		if(count($permissions) != 0){
			foreach ($permissions as $permission) {
				$data['user_permissions'][] = array(
					'vpermissioncode'  => $permission['vpermissioncode'],
					'vdesc'            => $permission['vdesc']
				);
			}
		}

		$before_permissions = $this->model_administration_user_groups->getUserBeforePermissions($this->request->get['ipermissiongroupid']);

		$data['before_permissions'] = $before_permissions;

		$data['token'] = $this->session->data['token'];	
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['vgroupname'])) {
			$data['vgroupname'] = $this->request->post['vgroupname'];
		} elseif (!empty($user_groups_info)) {
			$data['vgroupname'] = $user_groups_info['vgroupname'];
		} else {
			$data['vgroupname'] = '';
		}
		
		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($user_groups_info)) {
			$data['estatus'] = $user_groups_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		if (isset($this->request->post['ipgroupid'])) {
			$data['ipgroupid'] = $this->request->post['ipgroupid'];
		} elseif (!empty($user_groups_info)) {
			$data['ipgroupid'] = $user_groups_info['ipgroupid'];
		} else {
			$data['ipgroupid'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/user_groups_form', $data));
	}


	protected function validateForm() {
		
		$this->load->model('administration/user_groups');
		
		if (!$this->user->hasPermission('modify', 'administration/user_groups')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
	
}
