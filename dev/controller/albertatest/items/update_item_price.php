<?php
class ControllerAdministrationItemsUpdateItemPrice extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/items/update_item_price');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function edit_list() {

		$this->load->language('administration/items/update_item_price');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/update_item_price');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_api_items_update_item_price->editlistItems($this->request->post['items']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '&search_item_type='.$this->request->post['search_item_type'];

			$this->response->redirect($this->url->link('administration/items/update_item_price', 'token=' . $this->session->data['token'] . $url, true));
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

		if (isset($this->request->post['search_item'])){
			$search_find =  $this->request->post['search_item'];
			$page = 1;
		}else{
			$search_find = '';
		}

		if (isset($this->request->get['search_item_type'])){
			$search_item_type = $this->request->get['search_item_type'];
			$data['search_item_type'] = $this->request->get['search_item_type'];
		}else{
			$search_item_type = 'Standard';
			$data['search_item_type'] = 'Standard';
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
			'href' => $this->url->link('administration/items/update_item_price', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/items/update_item_price/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/items/update_item_price/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/items/update_item_price/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/items/update_item_price/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['searchitem'] = $this->url->link('administration/items/update_item_price/search', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/items/update_item_price', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['items'] = array();

		$filter_data = array(
			'search_find'  => $search_find,
			'search_item_type' => $search_item_type,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$data['search_find'] = $search_find;

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/items/update_item_price');

		$item_data_total = $this->model_api_items_update_item_price->getTotalItems($filter_data);
		$item_total = $item_data_total['total'];
		
		$item_data = $this->model_api_items_update_item_price->getItems($filter_data);
		
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
				'vunitcode'     => $result['vunitcode'],
				'vunitname'     => $result['vunitname'],
				'iqtyonhand'  	=> $result['iqtyonhand'],
				'vtax1'  	    => $result['vtax1'],
				'vtax2'  	    => $result['vtax2'],
				'QOH'  	        => $result['IQTYONHAND'],
				'dcostprice'  	=> $result['dcostprice'],
				'dunitprice'  	=> $result['dunitprice']
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

		$data['item_types'][] = 'Standard';
		$data['item_types'][] = 'Kiosk';
		$data['item_types'][] = 'Lot Matrix';
		// $data['item_types'][] = 'Gasoline';
		$data['item_types'][] = 'Lottery';

		if(!empty($search_find)){
			$url .= '&search_find='.$search_find;
		}

		if(!empty($search_item_type)){
			$url .= '&search_item_type='.$search_item_type;
		}

		$pagination = new Pagination();
		$pagination->total = $item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/items/update_item_price', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($item_total - $this->config->get('config_limit_admin'))) ? $item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $item_total, ceil($item_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/items/update_item_price_list', $data));
	}

	public function search(){
		$return = array();
		$this->load->model('api/items');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_items->getItemsSearchResult($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['iitemid'] = $value['iitemid'];
				$temp['vitemname'] = $value['vitemname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
