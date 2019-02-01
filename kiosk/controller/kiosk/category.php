<?php
class ControllerKioskCategory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/category');

		$this->getList();
	}

	public function add() {
		$this->load->language('kiosk/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_category->addCategory($this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_category->editCategory($this->request->get['CategoryId'], $this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('kiosk/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $CategoryId) {
				$this->model_kiosk_category->deleteCategory($CategoryId);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['MenuId'])) {
				$url .= '&filter_menuid=' . $this->request->post['MenuId'];
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

			$this->response->redirect($this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function edit_list() {
		$this->load->language('kiosk/category');

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('kiosk/category');
    
		$this->load->model('kiosk/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {
			$this->model_kiosk_category->editCategoryList($this->request->post['MenuId'], $this->request->post,$this->request->files);
			
			$url = '';

			if (isset($this->request->post['MenuId'])) {
				$url .= '&filter_menuid=' . $this->request->post['MenuId'];
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	  }
	  
	protected function getList() {
		
		if (isset($this->error)) {
			$data['error'] = $this->error;
		} else {
			$data['error'] =  array();
		}
		
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
			'href' => $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/category/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('kiosk/category/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/category/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('kiosk/category/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['categories'] = array();

		$filter_data = array(
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('kiosk/menus');
		
		$data['menus'] = $this->model_kiosk_menus->getActiveMenus();

		$this->load->model('tool/image');
		
		$category_total = $this->model_kiosk_category->getTotalCategories($filter_data);

		$results = $this->model_kiosk_category->getCategories($filter_data);		
		
		if (isset($this->request->post['category'])) {		
			//print_r($this->request->post);
			foreach($this->request->post['category'] as $key=>$value){
				
				if($this->request->post['category'][$key]['imagehidden']!="")
				{
					$image=$this->request->post['category'][$key]['imagehidden'];
				}else{
					$image = base64_encode(file_get_contents($this->request->files['category']['tmp_name'][$key]['image']));
				}
				
				$data['categories'][] = array(
					'MenuId'   => $this->request->post['MenuId'],
					'image'      => $image,
					//'Title' => $this->request->post['category'][$key]['Title'],
					'CategoryId' => $this->request->post['category'][$key]['CategoryId'],
					'Category'        => $this->request->post['category'][$key]['Category'],
					//'Sequence'  => $this->request->post['category'][$key]['Sequence'],
					'Status'  => $this->request->post['category'][$key]['Status'],
					//'LastUpdate'  => $this->request->post['category'][$key]['LastUpdate'],
					'RowSize'  => $this->request->post['category'][$key]['RowSize'],
					'ColumnSize'  => $this->request->post['category'][$key]['ColumnSize'],
					//'SID'  => $this->request->post['category'][$key]['SID'],
					'view'        => $this->url->link('kiosk/category/info', 'token=' . $this->session->data['token'] . '&CategoryId=' . $this->request->post['category'][$key]['CategoryId'] . $url, true),
					'edit'        => $this->url->link('kiosk/category/edit', 'token=' . $this->session->data['token'] . '&CategoryId=' . $this->request->post['category'][$key]['CategoryId'] . $url, true),
					'delete'      => $this->url->link('kiosk/category/delete', 'token=' . $this->session->data['token'] . '&CategoryId=' . $this->request->post['category'][$key]['CategoryId'] . $url, true)
				);
			}
		} else {
			
			foreach ($results as $result) {
			
				if($result['ImageLoc']=='')
				{
					$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
					$image = file_get_contents(DIR_IMAGE.'no_image.png');
				}else{
					$image = $result['ImageLoc'];
				}
				
				$data['categories'][] = array(
					'MenuId'   => $result['MenuId'],
					'image'      => base64_encode($image),
					'Title' => $result['Title'],
					'CategoryId' => $result['CategoryId'],
					'Category'        => $result['Category'],
					'Sequence'  => $result['Sequence'],
					'Status'  => $result['Status'],
					'LastUpdate'  => $result['LastUpdate'],
					'RowSize'  => $result['RowSize'],
					'ColumnSize'  => $result['ColumnSize'],
					'SID'  => $result['SID'],
					'view'        => $this->url->link('kiosk/category/info', 'token=' . $this->session->data['token'] . '&CategoryId=' . $result['CategoryId'] . $url, true),
					'edit'        => $this->url->link('kiosk/category/edit', 'token=' . $this->session->data['token'] . '&CategoryId=' . $result['CategoryId'] . $url, true),
					'delete'      => $this->url->link('kiosk/category/delete', 'token=' . $this->session->data['token'] . '&CategoryId=' . $result['CategoryId'] . $url, true)
				);
			}
		}		
		
		if($filter_menuid=='' || count($results)==0){ 
			$data['categories'] =array();
			$category_total = 0;
			$data['category_row'] =1;	
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_Sequence'] = $this->language->get('column_Sequence');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_menu'] = $this->language->get('column_menu');

		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_rowsize'] = $this->language->get('entry_rowsize');
		$data['entry_columnsize'] = $this->language->get('entry_columnsize');

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
		
		$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
		$no_image = file_get_contents(DIR_IMAGE.'no_image.png');				
		
		$data['placeholder'] = base64_encode($no_image);


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

		$data['sort_Category'] = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . '&sort=Category' . $url, true);
		$data['sort_Sequence'] = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . '&sort=Sequence' . $url, true);

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
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/category_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['CategoryId']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');

		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sequence'] = $this->language->get('entry_sequence');
		$data['entry_menu'] = $this->language->get('entry_menu');
		$data['entry_rowsize'] = $this->language->get('entry_rowsize');
		$data['entry_columnsize'] = $this->language->get('entry_columnsize');

		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');
		
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_column'] = $this->language->get('entry_column');

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

		if (isset($this->error['sequence'])) {
			$data['error_sequence'] = $this->error['sequence'];
		} else {
			$data['error_sequence'] = array();
		}

		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
		}
		
		if (isset($this->error['rowsize'])) {
			$data['error_rowsize'] = $this->error['rowsize'];
		} else {
			$data['error_rowsize'] = '';
		}
		
		if (isset($this->error['columnize'])) {
			$data['error_columnize'] = $this->error['columnize'];
		} else {
			$data['error_columnize'] = '';
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
			'href' => $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['CategoryId'])) {
			$data['action'] = $this->url->link('kiosk/category/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/category/edit', 'token=' . $this->session->data['token'] . '&CategoryId=' . $this->request->get['CategoryId'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['CategoryId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_kiosk_category->getCategory($this->request->get['CategoryId']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('kiosk/menus');
		
		$data['menus'] = $this->model_kiosk_menus->getActiveMenus();		
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} elseif (!empty($category_info)) {
			$data['MenuId'] = $category_info['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['category'])) {
			$data['category'] = $this->request->post['category'];
		} elseif (!empty($category_info)) {
			$data['category'] = $category_info['Category'];
		} else {
			$data['category'] = '';
		}
		
		$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
		$no_image = file_get_contents(DIR_IMAGE.'no_image.png');				
		
		if (isset($this->request->post['image'])) {				
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {			
			$image = ($category_info['ImageLoc']=='')?$no_image:$category_info['ImageLoc'];			
			$data['image'] = base64_encode($image);
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image'])) {
			$data['thumb'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {			
			$image = ($category_info['ImageLoc']=='')?$no_image:$category_info['ImageLoc'];			
			$data['thumb'] = base64_encode($image);
		} else {
			$data['thumb'] = base64_encode($no_image);
		}
		
		$data['placeholder'] = base64_encode($no_image);

		if (isset($this->request->post['sequence'])) {
			$data['sequence'] = $this->request->post['sequence'];
		} elseif (!empty($category_info)) {
			$data['sequence'] = $category_info['Sequence'];
		} else {
			$data['sequence'] = '';
		}

		if (isset($this->request->post['RowSize'])) {
			$data['RowSize'] = $this->request->post['RowSize'];
		} elseif (!empty($category_info)) {
			$data['RowSize'] = $category_info['RowSize'];
		} else {
			$data['RowSize'] = 0;
		}

		if (isset($this->request->post['ColumnSize'])) {
			$data['ColumnSize'] = $this->request->post['ColumnSize'];
		} elseif (!empty($category_info)) {
			$data['ColumnSize'] = $category_info['ColumnSize'];
		} else {
			$data['ColumnSize'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['Status'];
		} else {
			$data['status'] = false;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/category_form', $data));
	}

	protected function validateForm() {
		
		$this->load->model('kiosk/category');
		
		if (!$this->user->hasPermission('modify', 'kiosk/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['RowSize'] != '')) {
			
			if($this->request->post['MenuId']!='')
			{
				list($row,$coma,$column) = $this->model_kiosk_category->ValidateRowColumnSizeByMenu($this->request->post['MenuId']);
			}
			else
			{
				$row='';
				$coma='';
				$column='';
			}
						
			if($this->request->post['RowSize'] > $row)
			{
				$this->error['rowsize']= 'Row Size must Grater then '.$row." Rows";
			}
		}
		
		if (($this->request->post['ColumnSize'] != '')) {
			
			if($this->request->post['MenuId']!='')
			{
				list($row,$coma,$column) = $this->model_kiosk_category->ValidateRowColumnSizeByMenu($this->request->post['MenuId']);
			}
			else
			{
				$row='';
				$coma='';
				$column='';
			}
			if($this->request->post['ColumnSize'] > $column)
			{
				$this->error['columnize']= 'Column Size must Grater then '.$column." Column";
			}
		}

		if (($this->request->post['MenuId'] == '')) {
			$this->error['menu']= 'Please Select Menu';
		}

		if ((utf8_strlen($this->request->post['category']) < 2) || (utf8_strlen($this->request->post['category']) > 32)) {
			$this->error['category']= $this->language->get('error_category');
		}

		if (!(is_numeric($this->request->post['sequence']))) {
			$this->error['sequence']= 'Plase Enter Numeric Value Only!';
		}
		
		if ((utf8_strlen($this->request->post['sequence']) < 1)) {
			$this->error['sequence']= 'Plase Enter Display Sequence!';
		}

		if ((utf8_strlen($this->request->post['sequence']) != '')) {
			
			$seq_check = $this->model_kiosk_category->ValidateCategorySequenceByCategory($this->request->post['MenuId'],$this->request->post['category'],$this->request->post['sequence']);
			
			if($seq_check > 0)
			{
				$this->error['sequence']= $this->language->get('error_sequence');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'kiosk/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$ids='';
		
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$ids .= $id.",";				
			}

			$count = $this->model_kiosk_category->validatedeletecategory(rtrim($ids,","));
			
			if($count > 0)
			{
				$this->error['warning'] = "Category(s) already assigned to Page Flow!";
			}
		}

		return !$this->error;
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'kiosk/category')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$image='';
		foreach($this->request->post['category'] as $key=>$value){

			if($this->request->post['category'][$key]['imagehidden']!="")
			{
				$image=base64_decode($this->request->post['category'][$key]['imagehidden']);
			}else{
				$image = file_get_contents($this->request->files['category']['tmp_name'][$key]['image']);
			}
			
			$im = imagecreatefromstring($image);
			$width = imagesx($im);
			$height = imagesy($im);
			
			if($height >= 600 || $width >= 600){
				$this->error['category'][$key]['image']= "Image size grater then its size!";
			}
			
			if(isset($this->request->files['category']['type'][$key]['image']) && $this->request->files['category']['type'][$key]['image']!="image/jpeg" && $this->request->files['category']['tmp_name'][$key]['image']!="")
			{
				$this->error['category'][$key]['image']= "Invalid image type only .jpeg allowed!";
			}
			
			if ((utf8_strlen($this->request->post['category'][$key]['Category']) < 2) || (utf8_strlen($this->request->post['category'][$key]['Category']) > 32)) {
				$this->error['category'][$key]['Category']= "Category must be between 2 and 32 characters!";				
			}
		}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
	
	public function info() {
		$this->load->model('kiosk/category');

		if (isset($this->request->get['CategoryId'])) {
			$CategoryId = $this->request->get['CategoryId'];
		} else {
			$CategoryId = 0;
		}
		$category = $this->model_kiosk_category->getCategory($CategoryId);

		$category_info = $this->model_kiosk_category->getCategoryDetailView($CategoryId);
//print_r($category_info);
		if ($category) {
			
			$this->load->language('kiosk/category');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['button_cancel'] = $this->language->get('button_cancel');

			$data['token'] = $this->session->data['token'];

			$url = '';

			if (isset($this->request->get['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->get['filter_menuid'];
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['cancel'] = $this->url->link('kiosk/category', 'token=' . $this->session->data['token'] . $url, true);

			$data['CategoryId'] = $this->request->get['CategoryId'];
		
			$data['RowSize'] = $category['RowSize'];
			$data['ColumnSize'] = $category['ColumnSize'];


			$category_name = $this->model_kiosk_category->getCategory($CategoryId);

			$data['category_name'] =$category_name['Category'];
			
			$categorys = $this->model_kiosk_category->getCategoryDetailView($CategoryId);		
			
			$data['categorys'] = array();
	
			foreach ($categorys as $category) {
					
			if($category['itemimage']=='')
			{
				$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
				$image = file_get_contents(DIR_IMAGE.'no_image.png');
			}
			else
			{
				$image = $category['itemimage'];
			}

				$data['categorys'][] = array(
					'CategoryId' => $category['CategoryId'],
					'itemimage'  => base64_encode($image),
					'Category' => $category['Category'],
					'vitemname' => $category['vitemname'],
					'DisplayPosition' => $category['DisplayPosition'],
					'Price' => $category['Price'],			
				);
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('kiosk/category_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
}
