<?php
class ControllerKioskMenuItem extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/menu_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menu_item');

		$this->getList();
	}

	public function add() {
		$this->load->language('kiosk/menu_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menu_item');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_menu_item->addMenuItem($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/menu_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menu_item');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_menu_item->editMenuItem($this->request->get['MenuDetailId'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function editList() { 
		$this->load->language('kiosk/menu_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menu_item');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_menu_item->editMenuItemList($this->request->get['MenuDetailId'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	  
	public function delete() {
		$this->load->language('kiosk/menu_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menu_item');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $MenuDetailId) {
				$this->model_kiosk_menu_item->deleteMenuItem($MenuDetailId);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'MenuDetailId';
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
			'href' => $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/menu_item/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/menu_item/delete', 'token=' . $this->session->data['token'] . $url, true);
		
		
		$data['menuitems'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$menu_item_total = $this->model_kiosk_menu_item->getTotalMenuItem();

		$results = $this->model_kiosk_menu_item->getMenuItems($filter_data);

		foreach ($results as $result) {
			
			$data['menuitems'][] = array(
				'MenuDetailId' => $result['MenuDetailId'],
				'MenuId'        => $result['Title'],
				'CategoryId'  => $result['Category'],
				'iitemid'  => $result['vitemname'],
				'DisplayPosition'  => $result['DisplayPosition'],
				'Price'  => $result['Price'],
				'LastUpdate'  => $result['LastUpdate'],
				'SID'  => $result['SID'],
				'edit'        => $this->url->link('kiosk/menu_item/edit', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $result['MenuDetailId'] . $url, true),
				'delete'      => $this->url->link('kiosk/menu_item/delete', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $result['MenuDetailId'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_menu'] = $this->language->get('column_menu');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_itemname'] = $this->language->get('column_itemname');
		$data['column_displayposition'] = $this->language->get('column_displayposition');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_store'] = $this->language->get('column_store');
		$data['column_lastupdate'] = $this->language->get('column_lastupdate');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$data['sort_Title'] = $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . '&sort=Title' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $menu_item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($menu_item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($menu_item_total - $this->config->get('config_limit_admin'))) ? $menu_item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $menu_item_total, ceil($menu_item_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/menu_item_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['MenuDetailId']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');
		
		$data['entry_menu'] = $this->language->get('entry_menu');		
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_itemname'] = $this->language->get('entry_itemname');		
		$data['entry_displayposition'] = $this->language->get('entry_displayposition');
		$data['entry_price'] = $this->language->get('entry_price');		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['menu'])) {
			$data['error_menu'] = $this->error['menu'];
		} else {
			$data['error_menu'] = '';
		}

		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
		}

		if (isset($this->error['item'])) {
			$data['error_item'] = $this->error['item'];
		} else {
			$data['error_item'] = '';
		}

		if (isset($this->error['Title'])) {
			$data['error_title'] = $this->error['Title'];
		} else {
			$data['error_title'] = '';
		}


		if (isset($this->error['position'])) {
			$data['error_position'] = $this->error['position'];
		} else {
			$data['error_position'] = '';
		}

		if (isset($this->error['page'])) {
			$data['error_page'] = $this->error['page'];
		} else {
			$data['error_page'] = '';
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
			'href' => $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['MenuDetailId'])) {
			$data['action'] = $this->url->link('kiosk/menu_item/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/menu_item/edit', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $this->request->get['MenuDetailId'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/menu_item', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['MenuDetailId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$menu_item_info = $this->model_kiosk_menu_item->getMenuItem($this->request->get['MenuDetailId']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['MenuDetailId'])) {
			$data['MenuDetailId'] = $this->request->post['MenuDetailId'];
		} elseif (!empty($menu_item_info)) {
			$data['MenuDetailId'] = $menu_item_info['MenuDetailId'];
		} else {
			$data['MenuDetailId'] = '';
		}

		//$this->load->model('kiosk/stores');
		
		//$data['stores'] = $this->model_kiosk_stores->getStores();		

		//$data['stores'] = array();
		
		$this->load->model('kiosk/menus');
		$data['menus'] = $this->model_kiosk_menus->getMenus();

		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} elseif (!empty($menu_item_info)) {
			$data['MenuId'] = $menu_item_info['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		$this->load->model('kiosk/category');
		$data['categorys'] = $this->model_kiosk_category->getActiveCategories();
		//$data['categorys'] = array();
		
		if (isset($this->request->post['CategoryId'])) {
			$data['CategoryId'] = $this->request->post['CategoryId'];
		} elseif (!empty($menu_item_info)) {
			$data['CategoryId'] = $menu_item_info['CategoryId'];
		} else {
			$data['CategoryId'] = '';
		}
		
		$this->load->model('kiosk/items');		
		$data['items'] = $this->model_kiosk_items->getItems();		

		if (isset($this->request->post['iitemid'])) {
			$data['iitemid'] = $this->request->post['iitemid'];
		} elseif (!empty($menu_item_info)) {
			$data['iitemid'] = $menu_item_info['iitemid'];
		} else {
			$data['iitemid'] = '';
		}

		if (isset($this->request->post['old_DisplayPosition'])) {
			$data['old_DisplayPosition'] = $this->request->post['old_DisplayPosition'];
		}elseif (!empty($menu_item_info)) {
			$data['old_DisplayPosition'] = $menu_item_info['DisplayPosition'];
		} else {
			$data['old_DisplayPosition'] = '';
		}
		
		if (isset($this->request->post['DisplayPosition'])) {
			$data['DisplayPosition'] = $this->request->post['DisplayPosition'];
		} elseif (!empty($menu_item_info)) {
			$data['DisplayPosition'] = $menu_item_info['DisplayPosition'];
		} else {
			$data['DisplayPosition'] = '';
		}

		if (isset($this->request->post['Price'])) {
			$data['Price'] = $this->request->post['Price'];
		} elseif (!empty($menu_item_info)) {
			$data['Price'] = $menu_item_info['Price'];
		} else {
			$data['Price'] = '0.00';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/menu_item_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/menu_item')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['MenuId'] == '')) {
			$this->error['menu']= 'Please Select Menu';
		}

		if (($this->request->post['CategoryId'] == '')) {
			$this->error['category']= 'Please Select Category';
		}

		if (($this->request->post['iitemid'] == '')) {
			$this->error['item']= 'Plase Select Item';
		}

		if (!(is_numeric($this->request->post['DisplayPosition']))) {
			$this->error['position']= 'Plase Enter Numeric Value Only!';
		}
		
		if ((utf8_strlen($this->request->post['DisplayPosition']) < 1)) {
			$this->error['position']= 'Plase Enter Display Position!';
		}
		
		if ((utf8_strlen($this->request->post['DisplayPosition']) != '') && ($this->request->post['DisplayPosition']!= $this->request->post['old_DisplayPosition']) ) {

			$this->load->model('kiosk/menu_item');		
			
			$seq_check = $this->model_kiosk_menu_item->ValidateDisplayPosition($this->request->post['MenuId'],$this->request->post['CategoryId'],$this->request->post['DisplayPosition']);
			
			if($seq_check==1)
			{
				$this->error['position']= $this->language->get('error_position');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'kiosk/menu_item')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
