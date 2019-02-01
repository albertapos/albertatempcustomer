<?php
class ControllerKioskPages extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/pages');
//print_r($this->user->hasPermission('modify', 'kiosk/pages'));
		$this->getList();
	}
	
	public function addboxes() {
		$this->load->language('kiosk/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/pages');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if (strpos($this->request->server['QUERY_STRING'],'edit') == false){		   
				$PageId=$this->model_kiosk_pages->addPage($this->request->post);
			}else{
				$this->model_kiosk_pages->editPage($this->request->get['PageId'], $this->request->post);
			}
			
			$json=array(			
				'Rows'=>($this->request->post['RowSize']*$this->request->post['ColumnSize']),
				'Columns'=>$this->request->post['ColumnSize'],
				'warning'=>'',
			);
			
			$this->response->setOutput(json_encode($json));	
		}
		else
		{
			$err='';
			if (isset($this->error['warning'])) {
				$err.=$this->error['warning']."\n";
			} 
	
			if (isset($this->error['InternalTitle'])) {
				$err.=$this->error['InternalTitle']."\n";
			} 
	
			if (isset($this->error['DisplayTitle'])) {
				$err.=$this->error['DisplayTitle']."\n";
			} 
			
			$json=array(			
				'warning'=>($this->error['warning'])?$err:'',
				//'InternalTitle'=>($this->error['InternalTitle'])?$this->error['InternalTitle']:'',
				//'DisplayTitle'=>($this->error['DisplayTitle'])?$this->error['DisplayTitle']:'',
				'Rows'=>'',
				'Columns'=>'',				
			);
			
			$this->response->setOutput(json_encode($json));	
		}
	}
	
	public function add() {
		$this->load->language('kiosk/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/pages');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_pages->addPage($this->request->post);

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

			$this->response->redirect($this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/pages');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_pages->editPage($this->request->get['PageId'], $this->request->post);

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

			$this->response->redirect($this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('kiosk/pages');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/pages');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $PageId) {
				$this->model_kiosk_pages->deletePage($PageId);
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

			$this->response->redirect($this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'PageId';
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
			'href' => $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/pages/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/pages/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['pages'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$page_total = $this->model_kiosk_pages->getTotalPage();

		$results = $this->model_kiosk_pages->getPages($filter_data);

		foreach ($results as $result) {
			
			$data['pages'][] = array(
				'PageId' => $result['PageId'],
				'InternalTitle'        => $result['InternalTitle'],
				'DisplayTitle'  => $result['DisplayTitle'],
				'RowSize'  => $result['RowSize'],
				'ColumnSize'  => $result['ColumnSize'],
				//'LastUpdate'  => $result['LastUpdate'],
				//'SID'  => $result['SID'],
				'view'        => $this->url->link('kiosk/pages/info', 'token=' . $this->session->data['token'] . '&PageId=' . $result['PageId'] . $url, true),
				'edit'        => $this->url->link('kiosk/pages/edit', 'token=' . $this->session->data['token'] . '&PageId=' . $result['PageId'] . $url, true),
				'delete'      => $this->url->link('kiosk/pages/delete', 'token=' . $this->session->data['token'] . '&PageId=' . $result['PageId'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_pageid'] = $this->language->get('column_pageid');
		$data['column_internaltitle'] = $this->language->get('column_internaltitle');
		$data['column_displaytitle'] = $this->language->get('column_displaytitle');
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

		$data['sort_InternalTitle'] = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . '&sort=InternalTitle' . $url, true);
		$data['sort_DisplayTitle'] = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . '&sort=DisplayTitle' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $page_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($page_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($page_total - $this->config->get('config_limit_admin'))) ? $page_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $page_total, ceil($page_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/pages_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['PageId']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');

		$data['entry_internalid'] = $this->language->get('entry_internalid');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_displaytitle'] = $this->language->get('entry_displaytitle');
		$data['entry_rowsize'] = $this->language->get('entry_rowsize');
		$data['entry_columnsize'] = $this->language->get('entry_columnsize');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['InternalTitle'])) {
			$data['error_internal_title'] = $this->error['InternalTitle'];
		} else {
			$data['error_internal_title'] = '';
		}

		if (isset($this->error['DisplayTitle'])) {
			$data['error_display_title'] = $this->error['DisplayTitle'];
		} else {
			$data['error_display_title'] = '';
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
			'href' => $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['PageId'])) {
			$data['action'] = $this->url->link('kiosk/pages/add', 'token=' . $this->session->data['token'] . $url, true);
			//$data['action'] = 'index.php?route=kiosk/pages/addboxes&add&token=' . $this->session->data['token'] . $url;
		} else {
			$data['action'] = $this->url->link('kiosk/pages/edit', 'token=' . $this->session->data['token'] . '&PageId=' . $this->request->get['PageId'] . $url, true);
			//$data['action'] = 'index.php?route=kiosk/pages/addboxes&edit&token=' . $this->session->data['token'] . '&PageId=' . $this->request->get['PageId'] . $url;
		}

		$data['cancel'] = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['PageId']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$page_info = $this->model_kiosk_pages->getPage($this->request->get['PageId']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['PageId'])) {
			$data['PageId'] = $this->request->post['PageId'];
		} elseif (!empty($page_info)) {
			$data['PageId'] = $page_info['PageId'];
		} else {
			$data['PageId'] = '';
		}

		if (isset($this->request->post['InternalTitle'])) {
			$data['InternalTitle'] = $this->request->post['InternalTitle'];
		} elseif (!empty($page_info)) {
			$data['InternalTitle'] = $page_info['InternalTitle'];
		} else {
			$data['InternalTitle'] = '';
		}

		if (isset($this->request->post['DisplayTitle'])) {
			$data['DisplayTitle'] = $this->request->post['DisplayTitle'];
		} elseif (!empty($page_info)) {
			$data['DisplayTitle'] = $page_info['DisplayTitle'];
		} else {
			$data['DisplayTitle'] = '';
		}

		if (isset($this->request->post['RowSize'])) {
			$data['RowSize'] = $this->request->post['RowSize'];
		} elseif (!empty($page_info)) {
			$data['RowSize'] = $page_info['RowSize'];
		} else {
			$data['RowSize'] = 4;
		}

		if (isset($this->request->post['ColumnSize'])) {
			$data['ColumnSize'] = $this->request->post['ColumnSize'];
		} elseif (!empty($page_info)) {
			$data['ColumnSize'] = $page_info['ColumnSize'];
		} else {
			$data['ColumnSize'] = 4;
		}

		if (isset($this->request->post['image'])) {				
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = base64_encode($page_info['image']);
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			//$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			$data['thumb'] = base64_encode(file_get_contents(DIR_IMAGE.'no_image.png'));
		}
		
		$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
		$no_image = file_get_contents(DIR_IMAGE.'no_image.png');
				
		$data['placeholder'] = base64_encode($no_image);//$this->model_tool_image->resize('no_image.png', 100, 100);

		$this->load->model('kiosk/items');
		
		$data['items'] = $this->model_kiosk_items->getItems();		
		
		if (isset($this->request->post['iitemid'])) {
			$data['iitemid'] = $this->request->post['iitemid'];
		} elseif (!empty($page_info)) {
			//$data['iitemid'] = $page_info['iitemid'];
		} else {
			$data['iitemid'] = '';
		}

		$data['pages'] = array();
		
		if (isset($this->request->post['pages'])) {
			$pages = $this->request->post['pages'];
		} elseif (isset($this->request->get['PageId'])) {
			$pages = $this->model_kiosk_pages->getPageFlowDetail($this->request->get['PageId']);

			$data['pages'] = array();
	
			foreach ($pages as $page) {
				
				if($page['itemimage']=='')
				{
					$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
					$image = file_get_contents(DIR_IMAGE.'no_image.png');
				}
				else
				{
					$image = $page['itemimage'];
				}
					
				$data['pages'][] = array(
					'PageDetailId'    => $page['PageDetailId'],
					'iitemid'         => $page['iitemid'],
					'itemimage'       => base64_encode($image),
					'vitemname'       => $page['vitemname'],
					'DisplaySeq'      => $page['DisplaySeq'],
					'MoreLessAction'  => $page['MoreLessAction'],
					'RealItem'        => $page['RealItem'],
					'Price'           => $page['Price'],
				);
			}
	
		} else {
			$data['pages'] = array();
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/pages_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/pages')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['InternalTitle']) < 2) || (utf8_strlen($this->request->post['InternalTitle']) > 32)) {
			$this->error['InternalTitle']= $this->language->get('error_internal_title');
		}
		
		if ((utf8_strlen($this->request->post['DisplayTitle']) < 2) || (utf8_strlen($this->request->post['DisplayTitle']) > 32)) {
			$this->error['DisplayTitle']= $this->language->get('error_display_title');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'kiosk/pages')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function info() {
		$this->load->model('kiosk/pages');

		if (isset($this->request->get['PageId'])) {
			$PageId = $this->request->get['PageId'];
		} else {
			$PageId = 0;
		}

		$page_info = $this->model_kiosk_pages->getPage($PageId);

		if ($page_info) {
			
			$this->load->language('kiosk/pages');

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
				'href' => $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true)
			);
			
			$data['button_edit'] = $this->language->get('button_edit');
			
			$data['edit'] = $this->url->link('kiosk/pages/edit', 'token=' . $this->session->data['token'] . '&PageId=' . $this->request->get['PageId'] . $url, true);
			$data['cancel'] = $this->url->link('kiosk/pages', 'token=' . $this->session->data['token'] . $url, true);

			$data['PageId'] = $this->request->get['PageId'];
	
			$data['InternalTitle'] = $page_info['InternalTitle'];
			$data['DisplayTitle'] = $page_info['DisplayTitle'];
			$data['RowSize'] = $page_info['RowSize'];
			$data['ColumnSize'] = $page_info['ColumnSize'];
			
			//print_r($page_info);
			
			$pages = $this->model_kiosk_pages->getPageFlowDetailView($PageId);			
	
			$data['pages'] = array();
	
			foreach ($pages as $page) {
				
				if($page['itemimage']=='')
				{
					$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
					$image = file_get_contents(DIR_IMAGE.'no_image.png');
				}
				else
				{
					$image = $page['itemimage'];
				}
								
				$data['pages'][] = array(
					'PageDetailId' => $page['PageDetailId'],
					'iitemid' => $page['iitemid'],
					//'itemimage' => base64_encode(stream_get_contents($page['itemimage'])),
					'itemimage' => base64_encode($image),
					'vitemname' => $page['vitemname'],
					'DisplaySeq'          => $page['DisplaySeq'],
					'MoreLessAction'          => $page['MoreLessAction'],
					'RealItem'             => $page['RealItem'],					
					'Price'        => $page['Price'],
					'RowSize'        => $page['RowSize'],
					'ColumnSize'        => $page['ColumnSize'],					
				);
			}

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('kiosk/pages_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}
	
	public function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1])); 
    fclose($ifp); 

    return $output_file; 
}
}
