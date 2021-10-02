<?php
class ControllerKioskMenus extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/menus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menus');

		$this->getList();
	}

	public function add() {
		$this->load->language('kiosk/menus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_menus->addMenus($this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/menus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_menus->editMenus($this->request->get['MenuId'], $this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function edit_list() { 
		$this->load->language('kiosk/menus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && count($this->request->post) > 0) {
			$this->model_kiosk_menus->editMenusList($this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}	

	public function delete() {
		$this->load->language('kiosk/menus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/menus');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $MenuId) {
				$this->model_kiosk_menus->deleteMenus($MenuId);
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

			$this->response->redirect($this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'Sequence';
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

		$data['token'] = $this->session->data['token'];
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/menus/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/menus/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('kiosk/menus/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['menus'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$menu_total = $this->model_kiosk_menus->getTotalMenus();

		$results = $this->model_kiosk_menus->getMenus($filter_data);

		foreach ($results as $result) {
			
			if($result['ImageLoc']=='')
			{
				$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
				$image = file_get_contents(DIR_IMAGE.'no_image.png');
			}
			else
			{
				$image = $result['ImageLoc'];
			}
			
			$data['menus'][] = array(
				'MenuId' => $result['MenuId'],
				'Title'        => $result['Title'],
				'StartTime'  => $result['StartTime'],
				'EndTime'  => $result['EndTime'],
				'ImageLoc'  => base64_encode($image),
				'RowSize'  => $result['RowSize'],
				'ColumnSize'  => $result['ColumnSize'],
				//'Sequence'  => $result['Sequence'],
				'LastUpdate'  => $result['LastUpdate'],
				'Status'  => $result['Status'],
				'SID'  => $result['SID'],
				'view'        => $this->url->link('kiosk/menus/info', 'token=' . $this->session->data['token'] . '&MenuId=' . $result['MenuId'] . $url, true),
				'edit'        => $this->url->link('kiosk/menus/edit', 'token=' . $this->session->data['token'] . '&MenuId=' . $result['MenuId'] . $url, true),
				'delete'      => $this->url->link('kiosk/menus/delete', 'token=' . $this->session->data['token'] . '&MenuId=' . $result['MenuId'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');


		$data['column_title'] = $this->language->get('column_title');
		$data['column_image'] = $this->language->get('column_image');
		$data['column_store'] = $this->language->get('column_store');
		$data['column_lastupdate'] = $this->language->get('column_lastupdate');
		$data['column_starttime'] = $this->language->get('column_starttime');
		$data['column_endtime'] = $this->language->get('column_endtime');
		$data['column_rowsize'] = $this->language->get('column_rowsize');
		$data['column_columnsize'] = $this->language->get('column_columnsize');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['button_view'] = $this->language->get('button_view');
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

		$data['sort_Title'] = $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . '&sort=Title' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $menu_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($menu_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($menu_total - $this->config->get('config_limit_admin'))) ? $menu_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $menu_total, ceil($menu_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/menus_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['MenuId']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_rowsize'] = $this->language->get('entry_rowsize');
		$data['entry_columnsize'] = $this->language->get('entry_columnsize');
		
		$data['entry_title'] = $this->language->get('entry_title');		
		$data['entry_starttime'] = $this->language->get('entry_starttime');
		$data['entry_image'] = $this->language->get('entry_image');		
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_endtime'] = $this->language->get('entry_endtime');	
		$data['entry_sequence'] = $this->language->get('entry_sequence');	

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['Title'])) {
			$data['error_title'] = $this->error['Title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['page'])) {
			$data['error_page'] = $this->error['page'];
		} else {
			$data['error_page'] = '';
		}

		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
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
			'href' => $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['MenuId'])) {
			$data['action'] = $this->url->link('kiosk/menus/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/menus/edit', 'token=' . $this->session->data['token'] . '&MenuId=' . $this->request->get['MenuId'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['MenuId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$menus_info = $this->model_kiosk_menus->getMenu($this->request->get['MenuId']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} elseif (!empty($menus_info)) {
			$data['MenuId'] = $menus_info['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		//$this->load->model('kiosk/stores');
		
		//$data['stores'] = $this->model_kiosk_stores->getStores();		

		//$data['stores'] = array();
		
		if (isset($this->request->post['SID'])) {
			$data['SID'] = $this->request->post['SID'];
		} elseif (!empty($category_info)) {
			$data['SID'] = $category_info['SID'];
		} else {
			$data['SID'] = '';
		}

		if (isset($this->request->post['Title'])) {
			$data['Title'] = $this->request->post['Title'];
		} elseif (!empty($menus_info)) {
			$data['Title'] = $menus_info['Title'];
		} else {
			$data['Title'] = '';
		}

		if (isset($this->request->post['StartTime'])) {
			$data['StartTime'] = $this->request->post['StartTime'];
		} elseif (!empty($menus_info)) {
			$data['StartTime'] = $menus_info['StartTime'];
		} else {
			$data['StartTime'] = '';
		}

		if (isset($this->request->post['EndTime'])) {
			$data['EndTime'] = $this->request->post['EndTime'];
		} elseif (!empty($menus_info)) {
			$data['EndTime'] = $menus_info['EndTime'];
		} else {
			$data['EndTime'] = '';
		}

		/*$this->load->model('tool/image');

		if (isset($this->request->post['ImageLoc'])) {
			$data['thumb'] = $this->model_tool_image->resize(base64_decode($this->request->post['ImageLoc']), 100, 100);
		} elseif (!empty($category_info)) {
			$data['thumb'] = $this->model_tool_image->resize(base64_encode($category_info['ImageLoc']), 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}*/

		$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
		$no_image = file_get_contents(DIR_IMAGE.'no_image.png');				
		
		if (isset($this->request->post['ImageLoc'])) {				
			$data['ImageLoc'] = $this->request->post['ImageLoc'];
		} elseif (!empty($menus_info)) {			
			$image = ($menus_info['ImageLoc']=='')?$no_image:$menus_info['ImageLoc'];			
			$data['ImageLoc'] = base64_encode($image);
		} else {
			$data['ImageLoc'] = base64_encode($no_image);
		}

		/*if (isset($this->request->post['ImageLoc'])) {
			$data['thumb'] = $this->request->post['ImageLoc'];
		} elseif (!empty($menus_info)) {			
			$image = ($menus_info['ImageLoc']=='')?$no_image:$menus_info['ImageLoc'];			
			$data['thumb'] = base64_encode($image);
		} else {
			$data['thumb'] = base64_encode($no_image);
		}
		
		$data['placeholder'] = base64_encode($no_image);*/

		if (isset($this->request->post['RowSize'])) {
			$data['RowSize'] = $this->request->post['RowSize'];
		} elseif (!empty($menus_info)) {
			$data['RowSize'] = $menus_info['RowSize'];
		} else {
			$data['RowSize'] = 4;
		}

		if (isset($this->request->post['ColumnSize'])) {
			$data['ColumnSize'] = $this->request->post['ColumnSize'];
		} elseif (!empty($menus_info)) {
			$data['ColumnSize'] = $menus_info['ColumnSize'];
		} else {
			$data['ColumnSize'] = 4;
		}

		if (isset($this->request->post['sequence'])) {
			$data['sequence'] = $this->request->post['sequence'];
		} elseif (!empty($category_info)) {
			$data['sequence'] = $category_info['Sequence'];
		} else {
			$data['sequence'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($menus_info)) {
			$data['status'] = $menus_info['Status'];
		} else {
			$data['status'] = true;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/menus_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/menus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['Title']) < 2) || (utf8_strlen($this->request->post['Title']) > 32)) {
			$this->error['Title']= $this->language->get('error_title');
		}
		
		if($this->request->files['image']['error'] != 4){
		    $this->validateimagesize();
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'kiosk/menus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$ids='';
		
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$ids .= $id.",";				
			}
			
			$count = $this->model_kiosk_menus->validatedeletemenu(rtrim($ids,","));
			
			if($count > 0)
			{
				$this->error['warning'] = "Menu(s) already assigned to Category!";
			}
		}
		return !$this->error;
	}
	
	protected function validateimagesize(){
			
		if(isset($this->request->files['image']['tmp_name']))
		{
			$image='';
			if(is_file($this->request->files['image']['tmp_name']) && $this->request->files['image']['tmp_name']!='' && $this->request->files['image']['size'] > 0)
			{
				$fp = fopen($this->request->files['image']['tmp_name'], 'rb');
				$image = file_get_contents($this->request->files['image']['tmp_name']);
			}else{
				if(isset($this->request->post['iitemid']) && $this->request->post['iitemid']!="")
				{
					$image = base64_decode($this->request->post['image']);
				}
			}
			if($image != '')
			{
				$im = imagecreatefromstring($image);
				$width = imagesx($im);
				$height = imagesy($im);
			}
			else
			{
				$height = 0;
				$width = 0;	
			}
			if($height >= 600 || $width >= 600 || $this->request->files['image']['type']!="image/jpeg"){
				$this->error['image']= "Image size grater then its size or Invalid file type!";
			}
		}	
	}
	public function info() {
		$this->load->model('kiosk/menus');

		if (isset($this->request->get['MenuId'])) {
			$MenuId = $this->request->get['MenuId'];
		} else {
			$MenuId = 0;
		}

		$menu_info = $this->model_kiosk_menus->getMenu($MenuId);

		if ($menu_info) {
			
			$this->load->language('kiosk/menus');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['button_cancel'] = $this->language->get('button_cancel');

			$data['token'] = $this->session->data['token'];

			$url = '';

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['cancel'] = $this->url->link('kiosk/menus', 'token=' . $this->session->data['token'] . $url, true);

			$data['MenuId'] = $this->request->get['MenuId'];
	
			$data['RowSize'] = $menu_info['RowSize'];
			$data['ColumnSize'] = $menu_info['ColumnSize'];
			
			//print_r($page_info);
			
			$menus = $this->model_kiosk_menus->getMenuFlowDetailView($MenuId);			
	
			$data['menus'] = array();
	
			foreach ($menus as $menu) {
				
				if($menu['ImageLoc']=='')
				{
					$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
					$image = file_get_contents(DIR_IMAGE.'no_image.png');
				}
				else
				{
					$image = $menu['ImageLoc'];
				}
								
				$data['menus'][] = array(
					'MenuId' => $menu['MenuId'],
					'Title' => $menu['Title'],
					'Category' =>$menu['Category'],
					'ImageLoc' => base64_encode($image),					
					'Sequence' => $menu['Sequence'],
					'Status'          => $menu['Status'],
					'SID'        => $menu['SID'],
					'LastUpdate'        => $menu['LastUpdate'],
					//'EndTime'          => $menu['EndTime'],
					'RowSize'             => $menu['RowSize'],					
					'ColumnSize'        => $menu['ColumnSize']					
				);
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('kiosk/menus_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
}
