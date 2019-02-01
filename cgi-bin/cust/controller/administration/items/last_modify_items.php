<?php
class ControllerAdministrationItemsLastModifyItems extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/items/last_modify_items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function edit_list() {

		$this->load->language('administration/items/edit_items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/edit_items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$post_data = $this->request->post;

			$items_id_array = rawurldecode($this->request->post['items_id_array']);
			$items_id_array = unserialize($items_id_array);

			$post_data['item_ids'] = $items_id_array;
			
			$this->model_api_items_edit_items->editlistItems($post_data);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('administration/items/last_modify_items', 'token=' . $this->session->data['token'] . $url, true));
		}
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'iitemid';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->post['search_radio'])) {
			$search_radio =  $this->request->post['search_radio'];
			$page = 1;
		}else if(isset($this->request->get['search_radio'])){
			$search_radio =  $this->request->get['search_radio'];
		}else{
			$search_radio = '';
		}

		if (isset($this->request->post['seach_start_date']) && isset($this->request->post['seach_end_date']) && isset($this->request->post['search_radio'])  && $this->request->post['search_radio'] == 'by_dates') {
			$search_find_dates['seach_start_date'] =  $this->request->post['seach_start_date'];
			$search_find_dates['seach_end_date'] =  $this->request->post['seach_end_date'];
			$search_find = '';
			$page = 1;
		}else if (isset($this->request->post['search_item']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'search'){
			$search_find =  $this->request->post['search_item'];
			$search_find_dates = array();
			$page = 1;
		}else if(isset($this->request->get['search_find'])){
			$search_find =  $this->request->get['search_find'];
		}else if(isset($this->request->get['seach_start_date']) && isset($this->request->get['seach_end_date'])){
			$search_find_dates['seach_start_date'] =  $this->request->get['seach_start_date'];
			$search_find_dates['seach_end_date'] =  $this->request->get['seach_end_date'];
			$search_find = '';
		}else{
			$search_find = '';
			$search_find_dates = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Items',
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items/last_modify_items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/items/last_modify_items/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/items/last_modify_items/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/items/last_modify_items/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/items/last_modify_items/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['searchitem'] = $this->url->link('administration/items/last_modify_items/search', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/items/last_modify_items', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['items'] = array();

		$filter_data = array(
			'search_radio'  => $search_radio,
			'search_find_dates' => $search_find_dates,
			'search_find'  => $search_find,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		if(!empty($search_radio)){
			$data['search_radio'] = $search_radio;
		}else{
			$data['search_radio'] = 'by_dates';
		}
		$data['search_find'] = $search_find;
		$data['search_find_dates'] = $search_find_dates;

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/items/last_modify_items');

		$item_data_total = $this->model_api_items_last_modify_items->getTotalItems($filter_data);
		$item_total = $item_data_total['total'];
		$data['items_id_array'] = $item_data_total['iitemid'];
		
		$item_data = $this->model_api_items_last_modify_items->getItems($filter_data);

		$results = $item_data;

		foreach ($results as $result) {
			
			$data['items'][] = array(
				'iitemid'     	=> $result['iitemid'],
				'vitemtype'   	=> $result['vitemtype'],
				'vitemname'     => $result['vitemname'],
				'VITEMNAME'     => $result['VITEMNAME'],
				'vbarcode' 	   	=> $result['vbarcode'],
				'vcategorycode' => $result['vcategorycode'],
				'vcategoryname' => $result['vcategoryname'],
				'vdepcode'  	=> $result['vdepcode'],
				'vdepartmentname'  	=> $result['vdepartmentname'],
				'vsuppliercode' => $result['vsuppliercode'],
				'vcompanyname' => $result['vcompanyname'],
				'iqtyonhand'  	=> $result['iqtyonhand'],
				'vtax1'  	    => $result['vtax1'],
				'vtax2'  	    => $result['vtax2'],
				'QOH'  	        => $result['IQTYONHAND'],
				'dcostprice'  	=> $result['dcostprice'],
				'dunitprice'  	=> $result['dunitprice'],
				'visinventory'  => $result['visinventory'],
				'isparentchild' => $result['isparentchild'],
				'LastUpdate' => $result['LastUpdate'],
			);
		}
		
		if(count($item_data)==0){ 
			$data['items'] =array();
			$item_total = 0;
			$data['item_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_itemname'] = $this->language->get('column_itemname');
		$data['column_itemtype'] = $this->language->get('column_itemtype');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_deptcode'] = $this->language->get('column_deptcode');
		$data['column_sku'] = $this->language->get('column_sku');
		$data['column_categorycode'] = $this->language->get('column_categorycode');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_qtyonhand'] = $this->language->get('column_qtyonhand');
		
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

		$this->load->model('administration/items');

		$data['array_yes_no']['Y'] = 'Yes'; 
		$data['array_yes_no']['N'] = 'No'; 

		if(!empty($search_radio)){
			$url .= '&search_radio='.$search_radio;
		}

		if(count($search_find_dates) > 0){
			$url .= '&seach_start_date='.$search_find_dates['seach_start_date'].'&seach_end_date='.$search_find_dates['seach_end_date'];
		}

		$pagination = new Pagination();
		$pagination->total = $item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/items/last_modify_items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($item_total - $this->config->get('config_limit_admin'))) ? $item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $item_total, ceil($item_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/items/last_modify__item_list', $data));
	}
	
}
