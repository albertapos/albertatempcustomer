<?php
class ControllerKioskPageFlow extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		$this->getList(); 
	}
	
	public function add() {
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_page_flow->addPageFlow($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['MenuId'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['CategoryId'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function addItems() {
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_page_flow->addItems($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['MenuId'])) {
				$url .= '&filter_menuid=' . $this->request->post['MenuId'];
			}

			if (isset($this->request->post['CategoryId'])) {
				$url .= '&filter_categoryid=' . $this->request->post['CategoryId'];
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
//echo $url;
//exit;
			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_kiosk_page_flow->editPageFlow($this->request->get['MenuDetailId'], $this->request->post);

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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function updatePageflow() { 
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_kiosk_page_flow->updatePageFlow($this->request->post['MenuDetailId'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['MenuId'])) {
				$url .= '&filter_menuid=' . $this->request->post['MenuId'];
			}

			if (isset($this->request->post['CategoryId'])) {
				$url .= '&filter_categoryid=' . $this->request->post['CategoryId'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function delete() {
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $MenuDetailId) {
				$this->model_kiosk_page_flow->deletePageFlow($MenuDetailId);
			}			
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['filter_categoryid'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_menuid'])) {
			$filter_menuid = $this->request->get['filter_menuid'];			
			$data['filter_menuid'] = $this->request->get['filter_menuid'];
			$MenuId = $this->request->get['filter_menuid'];
			$data['MenuId'] = $this->request->get['filter_menuid'];
		}else if (isset($this->request->post['filter_menuid'])) {
			$filter_menuid = $this->request->post['filter_menuid'];
			$data['filter_menuid'] = $this->request->post['filter_menuid'];
			$MenuId = $this->request->post['filter_menuid'];
			$data['MenuId'] = $this->request->post['filter_menuid'];
		}else {
			$filter_menuid = null;
			$data['filter_menuid'] = null;
			$MenuId = null;
			$data['MenuId'] = null;
		}

		if (isset($this->request->get['filter_categoryid'])) {
			$filter_categoryid = $this->request->get['filter_categoryid'];
			$data['filter_categoryid'] = $this->request->get['filter_categoryid'];
			$CategoryId = $this->request->get['filter_menuid'];
			$data['CategoryId'] = $this->request->get['filter_menuid'];
		}else if (isset($this->request->post['filter_categoryid'])) {
			$filter_categoryid = $this->request->post['filter_categoryid'];
			$data['filter_categoryid'] = $this->request->post['filter_categoryid'];
			$CategoryId = $this->request->post['filter_menuid'];
			$data['CategoryId'] = $this->request->post['filter_menuid'];
		}else {
			$filter_categoryid = null;
			$data['filter_categoryid'] = null;
			$CategoryId = null;
			$data['CategoryId'] = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'DisplayPosition';
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

		if (isset($this->request->get['filter_categoryid'])) {
			$url .= '&filter_categoryid=' . urlencode(html_entity_decode($this->request->get['filter_categoryid'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/page_flow/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/page_flow/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['page_flow'] = array();

		$filter_data = array(
			'filter_menuid'  => $filter_menuid,
			'filter_categoryid'  => $filter_categoryid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('kiosk/menus');
		$data['menus'] = $this->model_kiosk_menus->getMenus();

		/*if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} elseif (isset($this->request->get['MenuId'])) {
			$data['MenuId'] = $this->request->get['MenuId'];
		} else {
			$data['MenuId'] = '';
		}*/

		$this->load->model('kiosk/category');
		$data['categorys'] = $this->model_kiosk_category->getActiveCategoriesByMenuId($filter_menuid);
	
		/*if (isset($this->request->post['CategoryId'])) {
			$data['CategoryId'] = $this->request->post['CategoryId'];
		} elseif (isset($this->request->get['CategoryId'])) {
			$data['CategoryId'] = $this->request->get['CategoryId'];
		} else {
			$data['CategoryId'] = '';
		}*/

		$page_flow_total = $this->model_kiosk_page_flow->getTotalPageFlow($filter_data);

		$results = $this->model_kiosk_page_flow->getPageFlows($filter_data);
		//$results = $this->model_kiosk_page_flow->getPageFlows();

		foreach ($results as $result) {
			
			$page_names = $this->model_kiosk_page_flow->getPagesNameByMenuDetailId($result['MenuDetailId']);
			
			$pagenames = array();

			if(isset($page_names))
			{
				foreach($page_names as $pa) {
					$pagenames[] = array(
						'PageFlowHeaderId' => $pa['PageFlowHeaderId'],
						'InternalTitle' => $pa['InternalTitle'],
						'Action' => substr($pa['Action'],0,1),
						'FreeTopingsCt' => $pa['FreeTopingsCt'],
						'PageId' => $pa['PageId'],
						'url' => $this->url->link('kiosk/pages/info', 'token=' . $this->session->data['token'] . '&PageId=' . $pa['PageId']),
						);
				}
			}

			if($result['itemimage']=='')
			{
				$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
				$image = file_get_contents(DIR_IMAGE.'no_image.png');
			}else{
				$image = $result['itemimage'];
			}

			$data['page_flow'][] = array(
				'image'      => base64_encode($image),
				'iitemid'  => $result['iitemid'],
				'Price'  => $result['Price'],
				'MenuDetailId'  => $result['MenuDetailId'],
				'vitemname'  => $result['vitemname'],
				'pagenames'  => $pagenames,
				'edit'   => $this->url->link('kiosk/page_flow/edit', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $result['MenuDetailId'] . $url, true),
			);
		}

		if($filter_menuid=='' || count($results)==0){ 
			$data['page_flow'] =array();			
			$page_flow_total = 0;
			//$data['category_row'] =1;	
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_pageid'] = $this->language->get('column_pageid');
		$data['column_pageaction'] = $this->language->get('column_pageaction');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

/*Add New Page Flow Model Info*/

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

		$this->load->language('kiosk/menu_item');
		
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
		
		//if (!isset($this->request->get['MenuDetailId'])) {
			$data['action_model'] = $this->url->link('kiosk/page_flow/add', 'token=' . $this->session->data['token'] . $url, true);
		//} else {
			//$data['action'] = $this->url->link('kiosk/page_flow/edit', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $this->request->get['MenuDetailId'] . $url, true);
		//}
		
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
		//print_r($this->request->get);
		$this->load->model('kiosk/items');		
		$data['items'] = $this->model_kiosk_items->getItems();		
	
		if (isset($this->request->post['iitemid'])) {
			$data['iitemid'] = $this->request->post['iitemid'];  
		}else if (isset($this->request->get['iitemid'])) {
			$data['iitemid'] = $this->request->get['iitemid'];
		}elseif (!empty($menu_item_info)) {
			$data['iitemid'] = $menu_item_info['iitemid'];
		} else {
			$data['iitemid'] = '';
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

		$this->load->model('kiosk/pages');
		$data['pages'] = $this->model_kiosk_pages->getPages();
		
/* Model Info End*/

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

		if (isset($this->request->get['filter_categoryid'])) {
			$url .= '&filter_categoryid=' . urlencode(html_entity_decode($this->request->get['filter_categoryid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $page_flow_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($page_flow_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($page_flow_total - $this->config->get('config_limit_admin'))) ? $page_flow_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $page_flow_total, ceil($page_flow_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/page_flow_list', $data));
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

		$data['entry_page'] = $this->language->get('entry_page');
		$data['entry_receiptprintseq'] = $this->language->get('entry_receiptprintseq');
		$data['entry_menu'] = $this->language->get('entry_menu');
		$data['entry_prevpage'] = $this->language->get('entry_prevpage');
		$data['entry_action'] = $this->language->get('entry_action');
		$data['entry_nextpage'] = $this->language->get('entry_nextpage');
		$data['entry_freetopings'] = $this->language->get('entry_freetopings');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_pageflowlast'])) {
			$data['error_pageflowlast'] = $this->error['error_pageflowlast'];
		} else {
			$data['error_pageflowlast'] = '';
		}

		if (isset($this->error['menu'])) {
			$data['error_menu'] = $this->error['menu'];
		} else {
			$data['error_menu'] = '';
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
			'href' => $this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['MenuDetailId'])) {
			$data['action'] = $this->url->link('kiosk/page_flow/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/page_flow/edit', 'token=' . $this->session->data['token'] . '&MenuDetailId=' . $this->request->get['MenuDetailId'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['MenuDetailId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$page_flow_info = $this->model_kiosk_page_flow->getPageFlow($this->request->get['MenuDetailId']);
			//$page_flow_info_by_menuid = $this->model_kiosk_page_flow->getPageFlowsByMenuDatailId($this->request->get['MenuDetailId']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['PageFlowHeaderId'])) {
			$data['PageFlowHeaderId'] = $this->request->post['PageFlowHeaderId'];
		} elseif (!empty($page_flow_info)) {
			$data['PageFlowHeaderId'] = $page_flow_info['PageFlowHeaderId'];
		} else {
			$data['PageFlowHeaderId'] = '';
		}

		if (isset($this->request->post['PageId'])) {
			$data['PageId'] = $this->request->post['PageId'];
		} elseif (!empty($page_flow_info)) {
			$data['PageId'] = $page_flow_info['PageId'];
		} else {
			$data['PageId'] = '';
		}

		if (isset($this->request->post['ReceiptPrintSeq'])) {
			$data['ReceiptPrintSeq'] = $this->request->post['ReceiptPrintSeq'];
		} elseif (!empty($page_flow_info)) {
			$data['ReceiptPrintSeq'] = $page_flow_info['ReceiptPrintSeq'];
		} else {
			$data['ReceiptPrintSeq'] = '';
		}
		
		if (!empty($page_flow_info)) {
			$data['menu_items'] = $this->model_kiosk_page_flow->getMenuItemsEdit();
		}
		else{
			$data['menu_items'] = $this->model_kiosk_page_flow->getMenuItems();
		}		

		if (isset($this->request->post['MenuDetailId'])) {
			$data['MenuDetailId'] = $this->request->post['MenuDetailId'];
		} elseif (!empty($page_flow_info)) {
			$data['MenuDetailId'] = $page_flow_info['MenuDetailId'];
		} else {
			$data['MenuDetailId'] = '';
		}

		if (isset($this->request->post['PrevPage'])) {
			$data['PrevPage'] = $this->request->post['PrevPage'];
		} elseif (!empty($page_flow_info)) {
			$data['PrevPage'] = $page_flow_info['PrevPage'];
		} else {
			$data['PrevPage'] = 0;
		}

		if (isset($this->request->post['Action'])) {
			$data['Action'] = $this->request->post['Action'];
		} elseif (!empty($page_flow_info)) {
			$data['Action'] = $page_flow_info['Action'];
		} else {
			$data['Action'] = 0;
		}

		if (isset($this->request->post['NextPage'])) {
			$data['NextPage'] = $this->request->post['NextPage'];
		} elseif (!empty($page_flow_info)) {
			$data['NextPage'] = $page_flow_info['NextPage'];
		} else {
			$data['NextPage'] = 0;
		}

		if (isset($this->request->post['FreeTopingsCt'])) {
			$data['FreeTopingsCt'] = $this->request->post['FreeTopingsCt'];
		} elseif (!empty($page_flow_info)) {
			$data['FreeTopingsCt'] = $page_flow_info['FreeTopingsCt'];
		} else {
			$data['FreeTopingsCt'] = '';
		}

		$this->load->model('kiosk/pages');
		$data['pages'] = $this->model_kiosk_pages->getPages();

		if (isset($this->request->post['pages'])) {
			$pages = $this->request->post['pages'];
		} elseif (isset($this->request->get['PageId'])) {
			$pages = $this->model_kiosk_page_flow->getPageFlowDetail($this->request->get['PageId']);
		} else {
			$pages = array();
		}
		
		if (isset($this->request->post['pageflow'])) {
			$pageflows = $this->request->post['pageflow'];
		} elseif (isset($this->request->get['MenuDetailId'])) {
			$pageflows = $this->model_kiosk_page_flow->getPageFlowsByMenuDatailId($this->request->get['MenuDetailId']);
		} else {
			$pageflows = array();
		}

		$data['pageflows'] = array();

		if(isset($pageflows) && count($pageflows) > 0)
		{
			foreach ($pageflows as $pageflow) {
				//print_r($pageflow);
				$data['pageflows'][] = array(
					'PageId' => $pageflow['PageId'],
					'ReceiptPrintSeq' => $pageflow['ReceiptPrintSeq'],
					'Action' => $pageflow['Action'],
					'FreeTopingsCt' => $pageflow['FreeTopingsCt'],
				);
			}
		}
		else
		{
			for($i=1;$i<=20;$i++)
			{
				$data['pageflows'][] = array(
					'PageId' => '',
					'ReceiptPrintSeq' => '',
					'Action' => '',
					'FreeTopingsCt' => '',
				);
			}	
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/page_flow_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/page_flow')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		/*if (($this->request->post['MenuDetailId'] == '')) {
			$this->error['menu']= 'Please Select Menu';
		}

		$err_flg='';
		$last_pg=0;
		
		foreach($this->request->post['pageflow'] as $pageflow)
		{
			if($pageflow['PageId'] != '')
			{
				$last_pg=$pageflow['PageId'];				
			}
		}
		
		if($last_pg!=5)
		{
			$this->error['error_pageflowlast']= $this->language->get('error_pageflowlast');
		}*/

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'kiosk/page_flow')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function getCategory(){
		
		$this->load->model('kiosk/category');
		
		$categorys = $this->model_kiosk_category->getActiveCategoriesByMenuId($this->request->get['menuid']);
		
		$html='';
		if($this->request->get['model']=="Yes"){
			$html .='<select name="CategoryId" id="CategoryId" class="form-control" onchange="loadleftitems()">';
		}else{
			$html .='<select name="filter_categoryid" id="CategoryId" class="form-control" onchange="filterpage()">';
		}
		$html .=' <option value="">-- Select Category --</option>';
		foreach($categorys as $category)
		{
			$html .='<option value="'.$category['CategoryId'].'">'.$category['Category'].'</option>';
		}		
		$html .='</select>';
		
		echo $html;	
	}
	
	public function getLeftItems() {
		$json = array();
		
		if (isset($this->request->post['selecteditems']) && $this->request->post['selecteditems']!='') {
			$selecteditems1 = " AND iitemid NOT IN(".$this->request->post['selecteditems'].")";
		}else {
			$selecteditems1 = '';
		}

		$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' $selecteditems1 ORDER BY vitemname ";
		//echo $sql;
		$query = $this->db2->query($sql);
		$items_result = $query->rows;
		
		$html = "";
		$left ='';
		foreach ($items_result as $result) {
			//$json[] = array(
			//'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftitemsselected[]" value="'.$result['iitemid'].'" /></td><td><input type="hidden" name="items['.$result['iitemid'].']" />'.$result['vitemname'].'['.$result['iitemid'].']</td></tr>'
				$left.='<tr><td style="width: 1px;"><input type="checkbox" name="leftitemsselected[]" value="'.$result['iitemid'].'" /></td><td><input type="hidden" name="items['.$result['iitemid'].']" />'.$result['vitemname'].$result['iitemid'].'</td></tr>'.",";
			//);			
		}

		$this->load->model('kiosk/page_flow');
		
		$filter_data = array(
			'filter_menuid'  => $this->request->post['MenuId'],
			'filter_categoryid'  => $this->request->post['CategoryId'],
		);
		
		$right='';
		$right_itemsid='';
			
		if( $this->request->post['MenuId'] !='' && $this->request->post['CategoryId'] !="")
		{
			$results = $this->model_kiosk_page_flow->getPageFlows($filter_data);
			$i=1;
			
			if(count($results) > 0)
			{
				foreach ($results as $result) {
					$right .= '<tr><td style="width: 1px;"><input type="checkbox" name="rightitemsselected[]" value="'.$result['iitemid'].'" /></td><td>'.$result['vitemname'].$result['iitemid'].'</td><td><input type="text" name="price['.$i.']" size="3" value="'.$result['Price'].'"/></td></tr>'.",";
					/*$json[] = array(
					'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightitemsselected[]" value="'.$result['iitemid'].'" /></td><td>'.$result['vitemname'].'['.$result['iitemid'].']</td><td><input type="text" name="price['.$i.']" size="3" value="0.00"/></td></tr>',
					'right_itemsid' => 	$result['iitemid']		
					);*/
					
					$right_itemsid.=$result['iitemid'].",";
					$i++;
				}
			}else{
				$right .= '';
				$right_itemsid.="";
			}
		}else{
			$right .= '';
			$right_itemsid.="";
		}
		//$right_itemsid=rtrim($right_itemsid,",");
		//$json[] = array('right_itemsid' => $right_itemsid);
		
		$json = array(
			'left' => rtrim($left,","),
			'right' => rtrim($right,","),
			'right_itemsid' => rtrim($right_itemsid,","),
		);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function getLeftRightItems() {
		$json = array();
		$left ='';
		$right ='';
		$right_itemsid = '';
		
		if (isset($this->request->post['right_itemsadded']) && $this->request->post['right_itemsadded']!='') {
			$selecteditems1 = " AND iitemid NOT IN(".$this->request->post['right_itemsadded'].")";
		}else {
			$selecteditems1 = "";
		}
		
		$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' $selecteditems1 ORDER BY vitemname";
		$query = $this->db2->query($sql);
		$items_result = $query->rows;
		if(count($items_result) > 0){
			foreach ($items_result as $result) {
				/*$json[] = array(
				'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftitemsselected[]" value="'.$result['iitemid'].'" /></td><td>'.$result['vitemname'].'['.$result['iitemid'].']</td></tr>'
				);*/	
				
				$left .= '<tr><td style="width: 1px;"><input type="checkbox" name="leftitemsselected[]" value="'.$result['iitemid'].'" /></td><td>'.$result['vitemname'].'</td></tr>';		
			}
		}else{
			$left .= '0';
		}

		if (isset($this->request->post['right_itemsadded']) && $this->request->post['right_itemsadded']!='') {
			$items=explode(",",$this->request->post['right_itemsadded']);
			//$selecteditems2 = " AND iitemid IN(".$this->request->post['right_itemsadded'].")";
			$limit="";
		}else {
			$selecteditems2 = "";
			$items=array();
			$limit ="0";
		}
		
		if(count($items) > 0)
		{	
			$i=1;
			foreach($items as $item)
			{
				//$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' AND iitemid=".$item." $limit";
				$sql="SELECT c.MenuDetailId,d.vitemname,d.itemimage,c.iitemid,c.Price FROM mst_item d LEFT JOIN kiosk_menu_item c ON (c.iitemid = d.iitemid) WHERE  c.MenuId = '" . $this->db->escape($this->request->post['MenuId']) . "' AND c.CategoryId = '" . $this->db->escape($this->request->post['CategoryId']) . "' AND d.vitemtype='Kiosk' AND d.estatus='Active' AND d.iitemid=".$item." ORDER BY c.DisplayPosition $limit";
				
				$query = $this->db2->query($sql);
				$items_result = $query->row;
			
				if(count($items_result) > 0){	
					 $right .='<tr><td style="width: 1px;"><input type="checkbox" name="rightitemsselected[]" value="'.$items_result['iitemid'].'" /></td><td>'.$items_result['vitemname'].'</td><td><input type="text" name="price['.$i.']" size="3" value="'.$items_result['Price'].'"/></td></tr>';
					 $right_itemsid.=$items_result['iitemid'].",";
				}else{	
					$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' AND iitemid=".$item." $limit";
					$query = $this->db2->query($sql);
					$itemsresult = $query->row;
						
						$right .='<tr><td style="width: 1px;"><input type="checkbox" name="rightitemsselected[]" value="'.$itemsresult['iitemid'].'" /></td><td>'.$itemsresult['vitemname'].'</td><td><input type="text" name="price['.$i.']" size="3" value="0.00"/></td></tr>';
						$right_itemsid.=$itemsresult['iitemid'].",";
				}
				$i++;
			}
		}
		else{
			$right .= '0';
			$right_itemsid .= '0';						
		}

		$json = array(				
			'left' => $left,
			'right' => $right,
			'right_itemsid' =>  $right_itemsid
		);	
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/*public function getrighttoleft() {
		$json = array();
		
		if (isset($this->request->post['right_itemsadded']) && $this->request->post['right_itemsadded']!='') {
			$selecteditems1 = " AND iitemid NOT IN(".$this->request->post['right_itemsadded'].")";
		}else {
			$selecteditems1 = '';
		}

		$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' $selecteditems1 ORDER BY vitemname";
		//echo $sql;
		$query = $this->db2->query($sql);
		$items_result = $query->rows;
		
		if(count($items_result) > 0)
		{
			foreach ($items_result as $result) {
				$json[] = array(
				'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftitemsselected[]" value="'.$result['iitemid'].'" /></td><td><input type="hidden" name="items['.$result['iitemid'].']" />'.$result['vitemname'].'['.$result['iitemid'].']</td></tr>'
				);			
			}
		}else{
			$json[] = array('left' => '0');
		}
		
		if (isset($this->request->post['right_itemsadded']) && $this->request->post['right_itemsadded']!='') {
			
			$selecteditems2 = " AND iitemid IN(".$this->request->post['right_itemsadded'].")";
		}else {
			$selecteditems2 = '';
		}
		
		$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active' $selecteditems2 ORDER BY vitemname";
		//echo $sql;
		$query = $this->db2->query($sql);
		$items_result = $query->rows;
		
		if(count($items_result) > 0 )
		{			
			foreach ($items_result as $result) {
				$json[] = array(
				 'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightitemsselected[]" value="'.$result['iitemid'].'" /></td><td><input type="hidden" name="items['.$result['iitemid'].']" />'.$result['vitemname'].'['.$result['iitemid'].']</td></tr>'
				 );			
			}
		}else{
			$json[] = array('right' => '0');	
		}
		
		//if($selecteditems2==""){$json[] = array('right' => '');}
		
		//print_r($json);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}*/
	
	public function getLeftRightPages() {
		$json = array();
		$pagesright = '';
		$left='';
		$right='';
		
		if (isset($this->request->post['MenuDetailId'])) {
			$data['MenuDetailId'] = $this->request->post['MenuDetailId'];
		} elseif ($this->request->get['MenuDetailId']) {
			$data['MenuDetailId'] = $this->request->get['MenuDetailId'];
		} else {
			$data['MenuDetailId'] = '';
		}
		
		if (isset($this->request->post['MenuId'])) {
			$data['MenuId'] = $this->request->post['MenuId'];
		} elseif ($this->request->get['MenuId']) {
			$data['MenuId'] = $this->request->get['MenuId'];
		} else {
			$data['MenuId'] = '';
		}

		if (isset($this->request->post['iitemid'])) {
			$data['iitemid'] = $this->request->post['iitemid'];
		} elseif ($this->request->get['iitemid']) {
			$data['iitemid'] = $this->request->get['iitemid'];
		} else {
			//$data['iitemid'] = '';
		}
		
		$sql="SELECT a.*,b.InternalTitle,b.DisplayTitle FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON a.PageId=b.PageId WHERE a.MenuDetailId = '" . (int)$this->request->post['MenuDetailId'] . "' AND a.PageId > 5  ORDER BY  a.ReceiptPrintSeq";
			$query = $this->db2->query($sql);
			$rightpageflows = $query->rows;
			
			$i=0;			
			if(count($rightpageflows) > 0)
			{
				foreach($rightpageflows as $row)
				{
					$sin = ($row['Action']=="Single")?"selected":"";
					$mul = ($row['Action']=="Multi")?"selected":"";				

					$right .= '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" '.$sin.'>Single</option><option value="Multi" '.$mul.'>Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="'.$row['FreeTopingsCt'].'" placeholder="FreeTopingsCt" size="3"/></td></tr>'.",";
					$pagesright .= $row['PageId'].",";
				
				$i++;
				}
			}else{
				$right .= '';$pagesright .= '';
			}
			
			$pagesright = rtrim($pagesright,",");
			
			if($pagesright != "")
			{
				$sql = "SELECT a.PageId,a.InternalTitle,a.DisplayTitle FROM kiosk_page_master a WHERE  a.PageId > 5  AND a.PageId NOT IN (".$pagesright.")";
			}else{
				$sql = "SELECT a.PageId,a.InternalTitle,a.DisplayTitle FROM kiosk_page_master a WHERE  a.PageId > 5";
			}
			$query = $this->db2->query($sql);
			$leftpageflows = $query->rows;
			
			if(count($leftpageflows) > 0)
			{
				foreach ($leftpageflows as $result) {
					
					$left .='<tr><td style="width: 1px;"><input type="checkbox" name="leftpagesselected[]" value="'.$result['PageId'].'" /></td><td>'.$result['InternalTitle'].'</td></tr>'.",";							
				}
			}else
			{
				$left .= '';
			}
			
		
		$json = array(
			'left' => rtrim($left,","),
			'right' => rtrim($right,","),
			'right_pagesadded' => rtrim($pagesright,","),
		);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function AddLeftToRightPages() {
		$json = array();
		$pagesright = '';
		
		if (isset($this->request->post['right_pagesadded']) && $this->request->post['right_pagesadded']!='') {
			
			$pages=explode(",",$this->request->post['right_pagesadded']);
			$i=0;
			foreach($pages as $page)
			{
				$sql="SELECT a.*,b.InternalTitle,b.DisplayTitle FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON a.PageId=b.PageId WHERE a.PageId !=5 AND  a.MenuDetailId = '" . (int)$this->request->post['MenuDetailId'] . "' AND a.PageId IN (".$page.") ORDER BY a.ReceiptPrintSeq";
				$query = $this->db2->query($sql);
				$row = $query->row;
			
				if(count($row) > 0)
				{
					$sin = ($row['Action']=="Single")?"selected":"";
					$mul = ($row['Action']=="Multi")?"selected":"";

					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" '.$sin.'>Single</option><option value="Multi" '.$mul.'>Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="'.$row['FreeTopingsCt'].'" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
				
					$pagesright .= $row['PageId'].",";
				}
				else
				{
					$sql="SELECT b.* FROM kiosk_page_master b WHERE b.PageId > 5 AND b.PageId IN (".$page.")";
					$query = $this->db2->query($sql);
					$row = $query->row;
				
					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" selected >Single</option><option value="Multi">Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="0" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
					$pagesright .= $row['PageId'].",";
				}
				
				$i++;
			}
			
			$pagesright = rtrim($pagesright,",");
			
			$sql = "SELECT a.PageId,a.InternalTitle,a.DisplayTitle FROM kiosk_page_master a WHERE  a.PageId > 5  AND a.PageId NOT IN (".$this->request->post['right_pagesadded'].")";		
			$query = $this->db2->query($sql);
			$leftpageflows = $query->rows;
			
			foreach ($leftpageflows as $result) {
				$json[] = array(
				'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftpagesselected[]" value="'.$result['PageId'].'" /></td><td>'.$result['InternalTitle'].'</td></tr>',
				'right_pagesadded' => '0',
				);			
			}
		}else {
			
			$pages=explode(",",$this->request->post['right_pagesadded']);
			$i=0;
			foreach($pages as $page)
			{
				$sql="SELECT a.*,b.InternalTitle,b.DisplayTitle FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON a.PageId=b.PageId WHERE a.PageId > 5 AND  a.MenuDetailId = '" . (int)$this->request->post['MenuDetailId'] . "' AND a.PageId IN (".$page.") ORDER BY a.ReceiptPrintSeq";
				$query = $this->db2->query($sql);
				$row = $query->row;
			
				if(count($row) > 0)
				{
					$sin = ($row['Action']=="Single")?"selected":"";
					$mul = ($row['Action']=="Multi")?"selected":"";

					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" '.$sin.'>Single</option><option value="Multi" '.$mul.'>Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="'.$row['FreeTopingsCt'].'" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
				
					$pagesright .= $row['PageId'].",";
				}
				else
				{
					$sql="SELECT b.* FROM kiosk_page_master b WHERE b.PageId > 5 AND b.PageId IN (".$page.")";
					$query = $this->db2->query($sql);
					$row = $query->row;
				
					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" selected >Single</option><option value="Multi">Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="0" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
					$pagesright .= $row['PageId'].",";
				}
				
				$i++;
			}
			$json[] = array(
				'left' => '',
				'right_pagesadded' => '0',
			);			
		}
		//print_r($json);		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function AddRightToLeftPages() {
		$json = array();
		$pagesright = '';
		
		if (isset($this->request->post['right_pagesadded']) && $this->request->post['right_pagesadded']!='') {
			$pages=explode(",",$this->request->post['right_pagesadded']);
			$i=0;
			foreach($pages as $page)
			{
				$sql="SELECT a.*,b.InternalTitle,b.DisplayTitle FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON a.PageId=b.PageId WHERE a.PageId > 5 AND  a.MenuDetailId = '" . (int)$this->request->post['MenuDetailId'] . "' AND a.PageId = ".$page." ORDER BY a.ReceiptPrintSeq";
				$query = $this->db2->query($sql);
				$row = $query->row;	
				
				if(count($row) > 0)
				{
					$sin = ($row['Action']=="Single")?"selected":"";
					$mul = ($row['Action']=="Multi")?"selected":"";
	
					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" '.$sin.'>Single</option><option value="Multi" '.$mul.'>Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="'.$row['FreeTopingsCt'].'" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
				
					$pagesright .= $row['PageId'].",";
				}
				else
				{
					$sql="SELECT b.* FROM kiosk_page_master b WHERE b.PageId > 5 AND b.PageId =".$page."";
					$query = $this->db2->query($sql);
					$row = $query->row;	
					
					$json[] = array(
						'right' => '<tr><td style="width: 1px;"><input type="checkbox" name="rightpagesselected[]" value="'.$row['PageId'].'" /></td><td style="width: 150px;"><input type="hidden" name="pageflow['.$i.'][PageId]" value="'.$row['PageId'].'" />'.$row['InternalTitle'].'</td><td style="width: 100px;"><select name="pageflow['.$i.'][Action]" ><option value="">-- Select Action --</option><option value="Single" selected >Single</option><option value="Multi">Multi</option></select></td><td style="width: 100px;"><input type="text" name="pageflow['.$i.'][FreeTopingsCt]" value="0" placeholder="FreeTopingsCt" size="3"/></td></tr>',
					'right_pagesadded' => $row['PageId'],
					);
				
					$pagesright .= $row['PageId'].",";
				}
			
			$i++;
			}
			
			$pagesright = rtrim($pagesright,",");
			
			$sql = "SELECT a.PageId,a.InternalTitle,a.DisplayTitle FROM kiosk_page_master a WHERE  a.PageId > 5  AND a.PageId NOT IN (".$pagesright.")";		
			$query = $this->db2->query($sql);
			$leftpageflows = $query->rows;
			
			foreach ($leftpageflows as $result) {
				$json[] = array(
				'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftpagesselected[]" value="'.$result['PageId'].'" /></td><td>'.$result['InternalTitle'].'</td></tr>',
				'right_pagesadded' => '0',
				);			
			}
		}else {
			$json[] = array(
				'right' => '',
				'right_pagesadded' =>'0',
			);
			
			$sql = "SELECT a.PageId,a.InternalTitle,a.DisplayTitle FROM kiosk_page_master a WHERE a.PageId > 5 ";
			$query = $this->db2->query($sql);
			$leftpageflows = $query->rows;
			
			foreach ($leftpageflows as $result) {
				$json[] = array(
				'left' => '<tr><td style="width: 1px;"><input type="checkbox" name="leftpagesselected[]" value="'.$result['PageId'].'" /></td><td>'.$result['InternalTitle'].'</td></tr>',
				'right_pagesadded' => '0',
				);			
			}	
		}
		//print_r($json);		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function getEditModelitemid(){
		$json =array();
		$iitemid = $this->request->get['iitemid'];
		
		$this->load->model('kiosk/items');		
		$items = $this->model_kiosk_items->getItems();		
		
		$html ='';
		$html .='<select name="iitemid" id="iitemid" class="form-control">';
		$html .='<option value="">-- Select Item --</option>';		
		foreach($items as $item)
		{
			if ($item['iitemid'] == $iitemid) {				
				$html.='<option value="'.$item['iitemid'].'" selected="selected">'.$item['vitemname'].'</option>';
			}
			else
			{
				$html.='<option value="'.$item['iitemid'].'">'.$item['vitemname'].'</option>';
			}
		}		
		$html.='</select>';
		
		$this->load->model('kiosk/menu_item');		
		$row = $this->model_kiosk_menu_item->getMenuItem($this->request->get['MenuDetailId']);	
		
		$json[] = array(
			'item' =>  $html,
			'price' => $row['Price'],
		);
		
		//print_r($json);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function CopyToAllPages(){
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $MenuDetailId) {
				$this->model_kiosk_page_flow->CopyPageFlowToOtherAllPages($MenuDetailId,$this->request->post);				
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['filter_categoryid'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();	
	}
	
	public function updaetPageflowposition(){
		
		$str='';
		$PrevPage=0;
		$NextPage=0;

		if($this->request->get['pageid_seq']!="")
		{
			$page_seq = explode(",",$this->request->get['pageid_seq']);
		}
		
		$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$this->request->get['MenuDetailId']." AND PageId > 5 ORDER BY PageFlowHeaderId";		
		$query = $this->db2->query($sql);
		$rows = $query->rows;
		$row_count = count($rows);
		
		$j=1;
		for($i=0;$i < count($page_seq);$i++)
		{	
			if($page_seq[$i]!='')
			{				
				if($i!=count($page_seq) && isset($page_seq[$i+1])!=""){			
					$NextPage = $page_seq[$i+1];
				}
				else{
					$NextPage='5';	
				}
					$sql ="UPDATE kiosk_page_flow_header SET  PageId = '" . (int)$page_seq[$i] . "',`ReceiptPrintSeq` = '" . $j. "', MenuDetailId = '" . (int)$this->request->get['MenuDetailId'] . "',PrevPage = '" . (int)$PrevPage . "',Action = '" . $rows[$i]["Action"] . "',NextPage = '" . (int)$NextPage . "',FreeTopingsCt = '" . $this->db->escape($rows[$i]["FreeTopingsCt"]) . "',SID = '" . (int)($this->session->data['SID'])."' WHERE PageFlowHeaderId=".$rows[$i]['PageFlowHeaderId'];					
					$this->db2->query($sql);
					
//				$str.=' '.$rows[$i]['PageFlowHeaderId'].",";
//				$str.=' '.$page_seq[$i].",";
//				$str.=' '.$j.",";
//				$str.=' '.$this->request->get['MenuDetailId'].",";
//				$str.=' '.$PrevPage.",";
//				$str.=' '.$rows[$i]["Action"].",";
//				$str.=' '.$NextPage.",";
//				$str.=' '.$rows[$i]["FreeTopingsCt"]."<br>";			
//				$str.="<br>";
			}			
			$PrevPage=$page_seq[$i];
			
			$j++;
		}		
		
		if($NextPage == 5)
		{
			$PrevPage=$page_seq[$i-1];
	
//			$str.=' '.($rows[$i-1]['PageFlowHeaderId']+1).",";
//			$str.=' 5,';
//			$str.=' '.($j).",";
//			$str.=' '.$this->request->get['MenuDetailId'].",";
//			$str.=' '.$PrevPage.",";
//			$str.='Single,';
//			$str.='0,';
//			$str.=' 0'."<br>";			
//			$str.="<br>";
			
			$sql ="UPDATE kiosk_page_flow_header SET  PageId = '5',`ReceiptPrintSeq` = '" . (int)($j). "', MenuDetailId = '" . (int)$this->request->get['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = 'Single',NextPage = '0',FreeTopingsCt = '0',SID = '" . (int)($this->session->data['SID'])."' WHERE PageFlowHeaderId=".($rows[$i-1]['PageFlowHeaderId']+1);
			$this->db2->query($sql);
		}
		//echo $str;
		//exit;
	}
	
	public function getPageFlowPagesEdit() {
		$json =array();		
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		$PageFlowHeaderId= $this->request->get['PageFlowHeaderId'];
		
		$sql="SELECT a.*,b.InternalTitle FROM kiosk_page_flow_header a,kiosk_page_master b WHERE  a.PageId > 5 AND a.PageId=b.PageId AND PageFlowHeaderId = '" . (int)$PageFlowHeaderId . "'";
		$query = $this->db2->query($sql);
		$row=$query->row;

		//$this->getList();
		$json = array(
			'PageFlowHeaderId' => $row['PageFlowHeaderId'],
			'InternalTitle' => $row['InternalTitle'],
			'Action' => $row['Action'],
			'FreeTopingsCt' => $row['FreeTopingsCt'],
		);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function savePageFlow(){
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$this->model_kiosk_page_flow->savePageFlow($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['filter_categoryid'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	public function updaetItemPrice(){
		
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$this->model_kiosk_page_flow->updaetItemPrice($this->request->get);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['filter_categoryid'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}
	
	public function position()
	{
		$this->load->language('kiosk/page_flow');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/page_flow');

		if (isset($this->request->post) && $this->request->post['filter_menuid']!='' && $this->request->post['filter_categoryid']!='') {
			
			$this->model_kiosk_page_flow->UpdatePageFlowSequence($this->request->post);
						
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->post['filter_menuid'])) {
				$url .= '&filter_menuid=' . $this->request->post['filter_menuid'];
			}

			if (isset($this->request->post['filter_categoryid'])) {
				$url .= '&filter_categoryid=' . $this->request->post['filter_categoryid'];
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

			$this->response->redirect($this->url->link('kiosk/page_flow', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	
	}
}
