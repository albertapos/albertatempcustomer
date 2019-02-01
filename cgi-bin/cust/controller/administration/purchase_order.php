<?php
class ControllerAdministrationPurchaseOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/purchase_order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/purchase_order');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/purchase_order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/purchase_order');

		$this->getForm();
	}

	public function add_post() {

		$this->load->model('api/purchase_order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$data_response = $this->model_api_purchase_order->addPurchaseOrder($this->request->post,null,'PO');

			if(array_key_exists("success",$data_response)){
				http_response_code(200);
			}else{
				http_response_code(401);
			}

			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data_response));
	        
		}
	}

	public function edit() {

		$this->load->language('administration/purchase_order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/purchase_order');

		$this->getForm();
	}

	public function edit_post() {

		$this->load->model('api/purchase_order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$data_response = $this->model_api_purchase_order->editPurchaseOrder($this->request->post,null,'PO');

			if(array_key_exists("success",$data_response)){
				http_response_code(200);
			}else{
				http_response_code(401);
			}

			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data_response));
			
		}

		
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'LastUpdate';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
			$data['searchbox'] =  $this->request->post['searchbox'];
		}else if(isset($this->request->get['searchbox'])){
			$searchbox =  $this->request->get['searchbox'];
			$data['searchbox'] =  $this->request->get['searchbox'];
		}else{
			$searchbox = '';
			$data['searchbox'] = '';
		}

		if(isset($this->request->get['order']) && $this->request->get['order'] == 'ASC'){
			$data['sort_estatus'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=estatus&order=DESC&searchbox='.$searchbox, true);
			$data['sort_vponumber'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vponumber&order=DESC&searchbox='.$searchbox, true);
			$data['sort_vvendorname'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vvendorname&order=DESC&searchbox='.$searchbox, true);
			$data['sort_vordertype'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vordertype&order=DESC&searchbox='.$searchbox, true);
			$data['sort_dcreatedate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=dcreatedate&order=DESC&searchbox='.$searchbox, true);
			$data['sort_dreceiveddate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=dreceiveddate&order=DESC&searchbox='.$searchbox, true);
			$data['sort_LastUpdate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=LastUpdate&order=DESC&searchbox='.$searchbox, true);
		}else{
			$data['sort_estatus'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=estatus&order=ASC&searchbox='.$searchbox, true);
			$data['sort_vponumber'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vponumber&order=ASC&searchbox='.$searchbox, true);
			$data['sort_vvendorname'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vvendorname&order=ASC&searchbox='.$searchbox, true);
			$data['sort_vordertype'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=vordertype&order=ASC&searchbox='.$searchbox, true);
			$data['sort_dcreatedate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=dcreatedate&order=ASC&searchbox='.$searchbox, true);
			$data['sort_dreceiveddate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=dreceiveddate&order=ASC&searchbox='.$searchbox, true);
			$data['sort_LastUpdate'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] .'&sort=LastUpdate&order=ASC&searchbox='.$searchbox, true);
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
			'href' => $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/purchase_order/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/purchase_order/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/purchase_order/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/purchase_order/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_invoice'] = $this->url->link('administration/purchase_order/import_invoice', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_missing_items'] = $this->url->link('api/purchase_order/import_missing_items', 'token=' . $this->session->data['token'].'&sid='.$this->session->data['sid'] , true);
		
		$data['purchase_orders'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');
		$this->load->model('api/purchase_order');

		$this->load->model('tool/image');
		
		$purchase_order_total = $this->model_api_purchase_order->getTotalPurchaseOrders($filter_data);
		
		$results = $this->model_api_purchase_order->getPurchaseOrders($filter_data);
		
		foreach ($results as $result) {
			
			$data['purchase_orders'][] = array(
				'ipoid'  		=> $result['ipoid'],
				'estatus'     	=> $result['estatus'],
				'vponumber' 	=> $result['vponumber'],
				'nnettotal' 	=> $result['nnettotal'],
				'vinvoiceno' 	=> $result['vinvoiceno'],
				'vvendorname'   => $result['vvendorname'],
				'vordertype'  	=> $result['vordertype'],
				'dcreatedate'  	=> $result['dcreatedate'],
				'dreceiveddate' => $result['dreceiveddate'],
				'dlastupdate'  	=> $result['LastUpdate'],
				'view'          => $this->url->link('administration/purchase_order/info', 'token=' . $this->session->data['token'] . '&ipoid=' . $result['ipoid'] . $url, true),
				'edit'          => $this->url->link('administration/purchase_order/edit', 'token=' . $this->session->data['token'] . '&ipoid=' . $result['ipoid'] . $url, true),
				'delete'        => $this->url->link('administration/purchase_order/delete', 'token=' . $this->session->data['token'] . '&ipoid=' . $result['ipoid'] . $url, true)
			);
		}

		$data['vendors'] = $this->model_api_purchase_order->getVendors();
		
		if(count($results)==0){ 
			$data['purchase_orders'] =array();
			$purchase_order_total = 0;
			$data['purchase_order_row'] =1;
		}

		$missing_item_results = $this->model_api_purchase_order->getMissingItems();

		$data['missing_items'] = array();

		if(count($missing_item_results) > 0){
			foreach ($missing_item_results as $missing_item_result) {
			
				$data['missing_items'][] = array(
					'imitemid'  		=> $missing_item_result['imitemid'],
					'estatus'     	=> $missing_item_result['estatus'],
					'vbarcode' 	=> $missing_item_result['vbarcode'],
					'vitemname' 	=> $missing_item_result['vitemname'],
					'vvendorname' 	=> $missing_item_result['vvendorname'],
					'vponumber'   => $missing_item_result['vponumber']
				);
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_status'] = $this->language->get('column_status');
		$data['column_purchase_ord'] = $this->language->get('column_purchase_ord');
		$data['column_invoice'] = $this->language->get('column_invoice');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_vendor_name'] = $this->language->get('column_vendor_name');
		$data['column_order_type'] = $this->language->get('column_order_type');
		$data['column_date_created'] = $this->language->get('column_date_created');
		$data['column_date_received'] = $this->language->get('column_date_received');
		$data['column_date_lastupdate'] = $this->language->get('column_date_lastupdate');
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

		$pagination = new Pagination();
		$pagination->total = $purchase_order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($purchase_order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($purchase_order_total - $this->config->get('config_limit_admin'))) ? $purchase_order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $purchase_order_total, ceil($purchase_order_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/purchase_order_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/purchase_order')) {
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

		$data['text_form'] = !isset($this->request->get['ipoid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		
		$data['entry_vendor_name'] = $this->language->get('entry_vendor_name');
		$data['entry_address1'] = $this->language->get('entry_address1');
		$data['entry_address2'] = $this->language->get('entry_address2');
		$data['entry_state'] = $this->language->get('entry_state');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_zip'] = $this->language->get('entry_zip');
		$data['entry_invoice'] = $this->language->get('entry_invoice');
		$data['entry_created'] = $this->language->get('entry_created');
		$data['entry_number'] = $this->language->get('entry_number');
		$data['entry_received'] = $this->language->get('entry_received');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_order_by'] = $this->language->get('entry_order_by');
		$data['entry_confirm_by'] = $this->language->get('entry_confirm_by');
		$data['entry_notes'] = $this->language->get('entry_notes');
		$data['entry_ship_to'] = $this->language->get('entry_ship_to');
		$data['entry_ship_vai'] = $this->language->get('entry_ship_vai');
		$data['entry_subtotal'] = $this->language->get('entry_subtotal');
		$data['entry_tax'] = $this->language->get('entry_tax');
		$data['entry_frieght'] = $this->language->get('entry_frieght');
		$data['entry_deposite'] = $this->language->get('entry_deposite');
		$data['entry_return'] = $this->language->get('entry_return');
		$data['entry_discount'] = $this->language->get('entry_discount');
		$data['entry_rips'] = $this->language->get('entry_rips');
		$data['entry_net_total'] = $this->language->get('entry_net_total');

	
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
			'href' => $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['ipoid'])) {
			$data['action'] = $this->url->link('administration/purchase_order/add_post', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/purchase_order/edit_post', 'token=' . $this->session->data['token'] . '&ipoid=' . $this->request->get['ipoid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true);

		$data['get_vendor'] = $this->url->link('administration/purchase_order/get_vendor', 'token=' . $this->session->data['token'], true);
		$data['get_search_items'] = $this->url->link('administration/purchase_order/get_search_items', 'token=' . $this->session->data['token'], true);
		$data['get_search_item'] = $this->url->link('administration/purchase_order/get_search_item', 'token=' . $this->session->data['token'], true);
		$data['check_invoice'] = $this->url->link('api/purchase_order/check_invoice', 'token=' . $this->session->data['token'], true);
		$data['purchase_order_list'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'], true);
		$data['delete_purchase_order_item'] = $this->url->link('api/purchase_order/delete_purchase_order_item', 'token=' . $this->session->data['token'], true);
		$data['save_receive_item'] = $this->url->link('administration/purchase_order/save_receive_item', 'token=' . $this->session->data['token'], true);
		$data['add_purchase_order_item'] = $this->url->link('administration/purchase_order/add_purchase_order_item', 'token=' . $this->session->data['token'], true);

		$data['get_search_item_history'] = $this->url->link('administration/purchase_order/get_search_item_history', 'token=' . $this->session->data['token'], true);
		$data['search_vendor_item_code'] = $this->url->link('administration/purchase_order/search_vendor_item_code', 'token=' . $this->session->data['token'], true);
		$data['get_item_history'] = $this->url->link('administration/purchase_order/get_item_history', 'token=' . $this->session->data['token'], true);
		$data['get_item_history_date'] = $this->url->link('administration/purchase_order/get_item_history_date', 'token=' . $this->session->data['token'], true);
		$data['get_vendor_item'] = $this->url->link('administration/purchase_order/get_vendor_item', 'token=' . $this->session->data['token'], true);
		$data['get_vendor_item_code_data'] = $this->url->link('administration/purchase_order/get_vendor_item_code_data', 'token=' . $this->session->data['token'], true);

		$data['check_warehouse_invoice'] = $this->url->link('administration/transfer/check_invoice', 'token=' . $this->session->data['token'] , true);

		if (isset($this->request->get['ipoid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$purchase_order_info = $this->model_api_purchase_order->getPurchaseOrder($this->request->get['ipoid']);
			$data['ipoid'] = $this->request->get['ipoid'];
		}

		$data['token'] = $this->session->data['token'];
		$data['sid'] = $this->session->data['sid'];

		if (isset($this->request->post['vponumber'])) {
			$data['vponumber'] = $this->request->post['vponumber'];
		} elseif (!empty($purchase_order_info)) {
			$data['vponumber'] = $purchase_order_info['vponumber'];
		} else {
			$temp_vponumber = $this->model_api_purchase_order->getLastInsertedID();
			if(isset($temp_vponumber['ipoid'])){
				$data['vponumber'] = str_pad($temp_vponumber['ipoid']+1,9,"0",STR_PAD_LEFT);
			}else{
				$data['vponumber'] = str_pad(1,9,"0",STR_PAD_LEFT);
			}
			
		}
		
		if (isset($this->request->post['nnettotal'])) {
			$data['nnettotal'] = $this->request->post['nnettotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['nnettotal'] = $purchase_order_info['nnettotal'];
		}

		if (isset($this->request->post['ntaxtotal'])) {
			$data['ntaxtotal'] = $this->request->post['ntaxtotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['ntaxtotal'] = $purchase_order_info['ntaxtotal'];
		}

		if (isset($this->request->post['dcreatedate'])) {
			$data['dcreatedate'] = $this->request->post['dcreatedate'];
		} elseif (!empty($purchase_order_info)) {
			$data['dcreatedate'] = $purchase_order_info['dcreatedate'];
		}

		if (isset($this->request->post['dreceiveddate'])) {
			$data['dreceiveddate'] = $this->request->post['dreceiveddate'];
		} elseif (!empty($purchase_order_info)) {
			$data['dreceiveddate'] = $purchase_order_info['dreceiveddate'];
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($purchase_order_info)) {
			$data['estatus'] = $purchase_order_info['estatus'];
		}

		if (isset($this->request->post['nfreightcharge'])) {
			$data['nfreightcharge'] = $this->request->post['nfreightcharge'];
		} elseif (!empty($purchase_order_info)) {
			$data['nfreightcharge'] = $purchase_order_info['nfreightcharge'];
		}

		if (isset($this->request->post['nfreightcharge'])) {
			$data['nfreightcharge'] = $this->request->post['nfreightcharge'];
		} elseif (!empty($purchase_order_info)) {
			$data['nfreightcharge'] = $purchase_order_info['nfreightcharge'];
		}

		if (isset($this->request->post['vordertitle'])) {
			$data['vordertitle'] = $this->request->post['vordertitle'];
		} elseif (!empty($purchase_order_info)) {
			$data['vordertitle'] = $purchase_order_info['vordertitle'];
		}

		if (isset($this->request->post['vorderby'])) {
			$data['vorderby'] = $this->request->post['vorderby'];
		} elseif (!empty($purchase_order_info)) {
			$data['vorderby'] = $purchase_order_info['vorderby'];
		}

		if (isset($this->request->post['vconfirmby'])) {
			$data['vconfirmby'] = $this->request->post['vconfirmby'];
		} elseif (!empty($purchase_order_info)) {
			$data['vconfirmby'] = $purchase_order_info['vconfirmby'];
		}

		if (isset($this->request->post['vnotes'])) {
			$data['vnotes'] = $this->request->post['vnotes'];
		} elseif (!empty($purchase_order_info)) {
			$data['vnotes'] = $purchase_order_info['vnotes'];
		}

		if (isset($this->request->post['vvendorid'])) {
			$data['vvendorid'] = $this->request->post['vvendorid'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendorid'] = $purchase_order_info['vvendorid'];
		}else{
			$data['vvendorid'] = "";
		}

		if (isset($this->request->post['vvendorname'])) {
			$data['vvendorname'] = $this->request->post['vvendorname'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendorname'] = $purchase_order_info['vvendorname'];
		}

		if (isset($this->request->post['vvendoraddress1'])) {
			$data['vvendoraddress1'] = $this->request->post['vvendoraddress1'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendoraddress1'] = $purchase_order_info['vvendoraddress1'];
		}

		if (isset($this->request->post['vvendoraddress2'])) {
			$data['vvendoraddress2'] = $this->request->post['vvendoraddress2'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendoraddress2'] = $purchase_order_info['vvendoraddress2'];
		}

		if (isset($this->request->post['vvendorstate'])) {
			$data['vvendorstate'] = $this->request->post['vvendorstate'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendorstate'] = $purchase_order_info['vvendorstate'];
		}

		if (isset($this->request->post['vvendorzip'])) {
			$data['vvendorzip'] = $this->request->post['vvendorzip'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendorzip'] = $purchase_order_info['vvendorzip'];
		}

		if (isset($this->request->post['vvendorphone'])) {
			$data['vvendorphone'] = $this->request->post['vvendorphone'];
		} elseif (!empty($purchase_order_info)) {
			$data['vvendorphone'] = $purchase_order_info['vvendorphone'];
		}

		if (isset($this->request->post['vshipvia'])) {
			$data['vshipvia'] = $this->request->post['vshipvia'];
		} elseif (!empty($purchase_order_info)) {
			$data['vshipvia'] = $purchase_order_info['vshipvia'];
		}

		if (isset($this->request->post['nrectotal'])) {
			$data['nrectotal'] = $this->request->post['nrectotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['nrectotal'] = $purchase_order_info['nrectotal'];
		}

		if (isset($this->request->post['nsubtotal'])) {
			$data['nsubtotal'] = $this->request->post['nsubtotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['nsubtotal'] = $purchase_order_info['nsubtotal'];
		}

		if (isset($this->request->post['ndeposittotal'])) {
			$data['ndeposittotal'] = $this->request->post['ndeposittotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['ndeposittotal'] = $purchase_order_info['ndeposittotal'];
		}

		if (isset($this->request->post['nreturntotal'])) {
			$data['nreturntotal'] = $this->request->post['nreturntotal'];
		} elseif (!empty($purchase_order_info)) {
			$data['nreturntotal'] = $purchase_order_info['nreturntotal'];
		}

		if (isset($this->request->post['vinvoiceno'])) {
			$data['vinvoiceno'] = $this->request->post['vinvoiceno'];
		} elseif (!empty($purchase_order_info)) {
			$data['vinvoiceno'] = $purchase_order_info['vinvoiceno'];
		}

		if (isset($this->request->post['ndiscountamt'])) {
			$data['ndiscountamt'] = $this->request->post['ndiscountamt'];
		} elseif (!empty($purchase_order_info)) {
			$data['ndiscountamt'] = $purchase_order_info['ndiscountamt'];
		}

		if (isset($this->request->post['nripsamt'])) {
			$data['nripsamt'] = $this->request->post['nripsamt'];
		} elseif (!empty($purchase_order_info)) {
			$data['nripsamt'] = $purchase_order_info['nripsamt'];
		}

		if (!empty($purchase_order_info)) {
			$data['items'] = $purchase_order_info['items'];
		}else{
			$data['items'] = array();
		}

		$data['items_id'] = array();

		if(count($data['items']) > 0){
			foreach ($data['items'] as $k => $v) {
				array_push($data['items_id'], $v['vitemid']);
			}
		}

		$data['vendors'] = $this->model_api_purchase_order->getVendors();
		$data['store'] = $this->model_api_purchase_order->getStore();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/purchase_order_form', $data));
	}


	protected function validateForm() {
		
		$this->load->model('administration/purchase_order');
		
		if (!$this->user->hasPermission('modify', 'administration/vendor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['vcompanyname'] == '')) {
			$this->error['vcompanyname']= 'Please Enter Vendor Name';
		}

		if (($this->request->post['vemail'] != '')) {
			if (!filter_var($this->request->post['vemail'], FILTER_VALIDATE_EMAIL)) {
			  $this->error['vemail']= 'Please Enter Valid Email Address';
			}
		}

		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	public function get_vendor() {

		ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['isupplierid'])) {
			$supplier = $this->model_api_purchase_order->getVendor($this->request->get['isupplierid']);
			$json['vendor'] = $supplier;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_search_items() {

		ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

		$this->load->model('api/purchase_order');

		$json = array();

		if (!empty($this->request->get['term'])) {
			$items = $this->model_api_purchase_order->getSearchItems($this->request->get['term']);
			
			$json['items'] = $items;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_search_item() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['iitemid']) && isset($this->request->get['ivendorid'])) {
			$item = $this->model_api_purchase_order->getSearchItem($this->request->get['iitemid'],$this->request->get['ivendorid']);
			$json['item'] = $item;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save_receive_item() {

		$this->load->model('api/purchase_order');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if(isset($this->request->post['items']) && count($this->request->post['items']) > 0){

				$item_response = $this->model_api_purchase_order->addSaveReceiveItem($this->request->post);

			}
			$json = $item_response;
		}

		if(array_key_exists("success",$json)){
			http_response_code(200);
		}else{
			http_response_code(401);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function import_invoice() {

		$this->load->model('api/purchase_order');

		$data = array();
		$json_return = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if(isset($this->request->post['vvendorid'])){
				$data['vvendorid'] = $this->request->post['vvendorid'];

				if(isset($this->request->files['import_invoice_file']) && $this->request->files['import_invoice_file']['name'] != ''){

					//variables
					$orderCount = 0;
					$poid = 0;
					$vCompanyName = '';
					$invoicenumber = '';
					$datemonth = '';
					$dateday = '';
					$dateyear = '';
					$totalAmount = '';
					$d = '';
					$vCode = '';
					$vname = '';
					$unitcost = '';
                    $qtyor = '';
                    $rPrice = '';
                    $iitemid = '';
                    $vcatcode = "1";
                    $vdepcode = "1";
                    $vtax1 = "N";
                    $vvendoritemcode = '';
                    $npack = '';
                    $itotalunit = '';
                    $nCost = '';
                    $vSign = '';

                    $vcategory = $this->model_api_purchase_order->getCategories();
                    if(count($vcategory) > 0){
                    	$vcatcode = $vcategory[0]['vcategorycode'];
                    }

                    $vdepartment = $this->model_api_purchase_order->getDepartments();
                    if(count($vdepartment) > 0){
                    	$vdepcode = $vdepartment[0]['vdepcode'];
                    }

                    $dtVend = $this->model_api_purchase_order->getTax1();
                    if(count($dtVend) > 0){
                    	$vtax1 = "Y";
                    }

                    $DTVENDOR = $this->model_api_purchase_order->getVendor($this->request->post['vvendorid']);

					$import_invoice_file = $this->request->files['import_invoice_file']['tmp_name'];

					$handle = fopen($import_invoice_file, "r");

					// check digit 
					// if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
					// 	$msg_check_digit_item = '';
					// 	if ($handle) {
					// 		while (($strline = fgets($handle)) !== false) {
					// 			$FirstChar = substr($strline,0,1);

					// 			if ($FirstChar == "B"){
					// 				$vCode = (substr($strline, 1, 11));
					// 				$vCode = trim($vCode," ");
					// 				$dtC = $this->model_api_purchase_order->getItemByBarCodeCheckDigit($vCode);

					// 				if(count($dtC) > 1){
					// 						$msg_check_digit_item .= 'Item Barcode: '.$vCode.PHP_EOL;
					// 				}
					// 			}

					// 		}

					// 		if($msg_check_digit_item != ''){

					// 			$error_msg_check_digit_item = 'Multiple Barcode Found In File Please Resolve it Manually'.PHP_EOL;
					// 			$error_msg_check_digit_item .= $msg_check_digit_item;

					// 			   $file_path = DIR_TEMPLATE."/administration/import-edi-invoice-multiple-barcode.txt";

					// 				$myfile = fopen( DIR_TEMPLATE."/administration/import-edi-invoice-multiple-barcode.txt", "w");

					// 				fwrite($myfile,$error_msg_check_digit_item);
					// 				fclose($myfile);
					// 				$json_return_arr = array();
					// 				$json_return_arr['code'] = 3;
					// 				$json_return_arr['error'] = 'Multiple Barcode Found In File Please Resolve it Manually';
					// 				echo json_encode($json_return_arr);
					// 				exit;

					// 		}

					// 	}
						
					// }
					// check digit 

					$nReturnTotal = 0;
					$msg_inactive_item = '';

					$import_invoice_file = $this->request->files['import_invoice_file']['tmp_name'];
					$handle1 = fopen($import_invoice_file, "r");
					
					if ($handle1) {

					    while (($strline = fgets($handle1)) !== false) {
					    	$FirstChar = substr($strline,0,1);
					    	
					        if ($FirstChar == "A"){
					        	$orderCount = $orderCount + 1;

					        	$vCompanyName = substr($strline, 1, 6);
                            	$invoicenumber = substr($strline, 7, 10);

                            	$dtCh = $this->model_api_purchase_order->GetPurchaseOrderByInvoice($invoicenumber);
                            	
                            	if(count($dtCh) > 0){
                            		$json_return['code'] = 0;
									$json_return['error'] = 'Invoice Number '.$invoicenumber.'already Exist';
									echo json_encode($json_return);
									exit;
                            	}
                        		$datemonth = substr($strline, 17, 2);
	                            $dateday = substr($strline, 19, 2);
	                            $dateyear = substr($strline, 21, 2);
	                            $totalAmount = substr($strline, 24, 9);

	                            if (strlen($totalAmount) > 0){
	                            	$totalAmount = (sprintf("%.2f", $totalAmount)/100);
	                            }

	                            $dt_year = DateTime::createFromFormat('y', $dateyear);
								$dt_year = $dt_year->format('Y');
	                            
	                            $d = $datemonth .'-'. $dateday .'-'. $dt_year;

	                            $strdue1 = $d.' '.date('H:i:s');

	                            $strdue1 = DateTime::createFromFormat('m-d-Y H:i:s', $strdue1);
								$strdue1 = $strdue1->format('Y-m-d H:i:s');

	                            $nReturnTotal = 0;

	                            $trnPurchaseorderdto = array();

	                            $trnPurchaseorderdto['vvendorname'] = $DTVENDOR['vcompanyname'];
	                            $trnPurchaseorderdto['nripsamt'] = 0;
	                            $trnPurchaseorderdto['dduedatetime'] = $strdue1;
	                            $trnPurchaseorderdto['nsubtotal'] = 0;
	                            $trnPurchaseorderdto['nreturntotal'] = 0;
	                            $trnPurchaseorderdto['nrectotal'] = 0;
	                            $trnPurchaseorderdto['ndeposittotal'] = 0;
	                            $trnPurchaseorderdto['ndiscountamt'] = 0;
	                            $trnPurchaseorderdto['vinvoiceno'] = $invoicenumber;
	                            $trnPurchaseorderdto['vponumber'] = $invoicenumber;
	                            $trnPurchaseorderdto['vrefnumber'] = $invoicenumber;
	                            $trnPurchaseorderdto['nnettotal'] = sprintf("%.2f", $totalAmount);
	                            $trnPurchaseorderdto['ntaxtotal'] = 0;
	                            $trnPurchaseorderdto['dcreatedate'] = $strdue1;
	                            $trnPurchaseorderdto['estatus'] = "Open";
	                            $trnPurchaseorderdto['nfreightcharge'] = 0;
	                            $trnPurchaseorderdto['vvendoraddress1'] = $DTVENDOR['vaddress1'];
	                            $trnPurchaseorderdto['vvendoraddress2'] = '';
	                            $trnPurchaseorderdto['vvendorid'] = $DTVENDOR['isupplierid'];
	                            $trnPurchaseorderdto['vvendorstate'] = $DTVENDOR['vstate'];
	                            $trnPurchaseorderdto['vvendorzip'] = $DTVENDOR['vzip'];
	                            $trnPurchaseorderdto['vvendorphone'] = $DTVENDOR['vphone'];
	                            $trnPurchaseorderdto['vordertitle'] = '';
	                            $trnPurchaseorderdto['vordertype'] = "";
	                            $trnPurchaseorderdto['vconfirmby'] = "";
	                            $trnPurchaseorderdto['vorderby'] = "";
	                            $trnPurchaseorderdto['vshpid'] = "0";
	                            $trnPurchaseorderdto['vshpname'] = "";
	                            $trnPurchaseorderdto['vshpaddress1'] = "";
	                            $trnPurchaseorderdto['vshpaddress2'] = "";
	                            $trnPurchaseorderdto['vshpzip'] = "";
	                            $trnPurchaseorderdto['vshpstate'] ="";
	                            $trnPurchaseorderdto['vshpphone'] = "";
	                            $trnPurchaseorderdto['vshipvia'] = "";
	                            $trnPurchaseorderdto['vnotes'] = "";

	                            $poid = $this->model_api_purchase_order->insertPurchaseOrder($trnPurchaseorderdto);
                            }

                            if ($FirstChar == "B"){
                            	$vCode = (substr($strline, 1, 11));
                            	$vCode = trim($vCode," ");
	                            $vname = substr($strline, 12, 25);
	                            $vname = str_replace("'","",$vname);                           
	                            $unitcost = substr($strline, 43, 6);
	                            $qtyor = substr($strline, 58, 4);
	                            $qtyor = (int)$qtyor;
	                            $rPrice = substr($strline, 62, 5);
	                            $vvendoritemcode = substr($strline, 37, 6);
	                            $npack = substr($strline, 51, 6);
	                            $npack = (int)$npack;
	                            $vSign = substr($strline, 57, 1);
	                            $vvendoritemcode = substr($strline, 37, 6);

	                            if (strlen($unitcost) == 0){
	                            	$unitcost = "0";
	                            }

	                            if (strlen($qtyor) == 0){
	                            	$qtyor = "0";
	                            }

	                            if (strlen($rPrice) == 0){
	                            	$rPrice = "0";
	                            }

	                            if ($unitcost != "0"){
	                            	$unitcost = (sprintf("%.2f", $unitcost)/100);
	                            }

	                            if ($rPrice != "0"){
	                            	$rPrice = (sprintf("%.2f", $rPrice)/100);
	                            }

	                            if (strlen($npack) == 0 || $npack == 0){
	                            	$npack = "1";
	                            }

	                            $nCost = $unitcost;
	                            $unitcost = $unitcost / (int)$npack;
	                            $itotalunit = (int)$qtyor * (int)$npack;
	                            $totAmt = (int)$qtyor * $nCost;

	                            if ($vSign == "-"){
	                                $nReturnTotal += $totAmt;
	                                
	                                $itotalunit = (int)$itotalunit *-1;
	                                
	                                $qtyor = (int)$qtyor*-1;
	                            }

	                            $dtC = $this->model_api_purchase_order->getItemByBarCode($vCode);

	                            if (count($dtC) == 0){
	                                $vCode = substr($strline, 1, 11);
	                                $vCode = trim($vCode," ");
	                                if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
		                                // $old_vCode = substr($vCode, 0, -1);

		                                $check_digit_barcode = $this->model_api_purchase_order->calculate_upc_check_digit($vCode);

		                                if($check_digit_barcode != -1){

		                                	$old_vCode = $vCode.''.$check_digit_barcode;

		                                	$old_vCode = $this->model_api_purchase_order->getItemByBarCode($old_vCode);

			                                if(count($old_vCode) > 0){
			                                	$old_vCode = $old_vCode['vbarcode'];
			                                	$dtC = $this->model_api_purchase_order->getItemByBarCode($old_vCode);
			                                
				                                if(count($dtC) > 0){
				                                	$this->model_api_purchase_order->updateBarcode($vCode,$old_vCode);
				                                }
			                                }else{
			                                	$vCode = $vCode.''.$check_digit_barcode;
			                                }
		                                }
		                                
	                                }                             
	                            }

	                            if(count($dtC) > 0){
	                            	//update item status
	                            	// if($dtC['estatus'] == 'Inactive'){
	                            	// 	$msg_inactive_item .= 'Item Barcode: '.$dtC['vbarcode'].PHP_EOL;
	                            	// }
	                            	$this->model_api_purchase_order->updateItemStatus($dtC["iitemid"]);
	                            	//update item status

	                            	$iitemid = $dtC["iitemid"];
	                            	$dtI = $this->model_api_purchase_order->getItemVendorByVendorItemCode($vvendoritemcode);
	                            	if(count($dtI) == 0){
	                            		$mstItemVendorDto = array();
	                            		$mstItemVendorDto['iitemid'] = $iitemid;
	                            		$mstItemVendorDto['ivendorid'] = $this->request->post['vvendorid'];
	                            		$mstItemVendorDto['vvendoritemcode'] = $vvendoritemcode;

	                            		$this->model_api_purchase_order->insertItemVendor($mstItemVendorDto);
	                            	}

	                            	$trnPurchaseOrderDetaildto = array();
	                            	$trnPurchaseOrderDetaildto['npackqty'] = (int)$npack;
	                                $trnPurchaseOrderDetaildto['vbarcode'] = $vCode;

	                                $trnPurchaseOrderDetaildto['ipoid'] = (int)$poid;
	                                $trnPurchaseOrderDetaildto['vitemid'] = (string)$iitemid;
	                                $trnPurchaseOrderDetaildto['vitemname'] = str_replace("'","",$dtC["vitemname"]);
	                                $trnPurchaseOrderDetaildto['vunitname'] = "Each";
	                                $trnPurchaseOrderDetaildto['nordqty'] = sprintf("%.2f", $qtyor);
	                                $trnPurchaseOrderDetaildto['nordunitprice'] = sprintf("%.2f", $nCost);
	                                $trnPurchaseOrderDetaildto['nordextprice'] = $totAmt;
	                                $trnPurchaseOrderDetaildto['nordtax'] = 0;
	                                $trnPurchaseOrderDetaildto['nordtextprice'] = 0;
	                                $trnPurchaseOrderDetaildto['vvendoritemcode'] = (string)$vvendoritemcode;
	                                $trnPurchaseOrderDetaildto['nunitcost'] = sprintf("%.4f", $unitcost);

	                                $trnPurchaseOrderDetaildto['itotalunit'] = (int)$itotalunit;
	                                $trnPurchaseOrderDetaildto['vsize'] = "";

	                                $this->model_api_purchase_order->InsertPurchaseDetail($trnPurchaseOrderDetaildto);

	                            }else{

	                            	$mst_missingitemDTO = array();
	                            	$mst_missingitemDTO['norderqty'] = (int)$qtyor;
	                                $mst_missingitemDTO['vvendoritemcode'] = $vvendoritemcode;
	                                $mst_missingitemDTO['iinvoiceid'] = $poid;
	                                $mst_missingitemDTO['vbarcode'] = $vCode;
	                                $mst_missingitemDTO['vitemname'] = str_replace("'","",$vname);
	                                $mst_missingitemDTO['nsellunit'] = 1;
	                                $mst_missingitemDTO['dcostprice'] = sprintf("%.2f", $nCost);
	                                $mst_missingitemDTO['dunitprice'] = sprintf("%.2f", $rPrice);

	                                $mst_missingitemDTO['vcatcode'] = $vcatcode;
	                                $mst_missingitemDTO['vdepcode'] = $vdepcode;
	                                $mst_missingitemDTO['vsuppcode'] = $this->request->post['vvendorid'];
	                                $mst_missingitemDTO['vtax1'] = $vtax1;
	                                $mst_missingitemDTO['vitemtype'] = "Standard";
	                                $mst_missingitemDTO['npack'] = (int)$npack;
	                                $mst_missingitemDTO['vitemcode'] = $vCode;
	                                $mst_missingitemDTO['vunitcode'] = "UNT001";
	                                $mst_missingitemDTO['nunitcost'] = sprintf("%.2f", $unitcost);

	                                $this->model_api_purchase_order->createMissingitem($mst_missingitemDTO);
	                            	
	                            }
                            }
					    }

					    $this->model_api_purchase_order->updatePurchaseOrderReturnTotal($nReturnTotal,$poid);

					 //    $file_path = DIR_TEMPLATE."/administration/import-edi-invoice-inactive-items.txt";

					 //    if($msg_inactive_item != ''){
					 //    	$message_inactive = '--List of Inactive Items become Active--'.PHP_EOL;
					 //    	$message_inactive .= $msg_inactive_item;
					 //    }else{
					 //    	$message_inactive = '';
					 //    }

						// $myfile = fopen( DIR_TEMPLATE."/administration/import-edi-invoice-inactive-items.txt", "w");

						// fwrite($myfile,$message_inactive);
						// fclose($myfile);

					 //    if($message_inactive != ''){
					 //    	$json_return['file_download'] = 1;
					 //    }else{
					 //    	$json_return['file_download'] = 0;
					 //    }

					    $json_return['code'] = 1;
						$json_return['success'] = 'Successfully Imported Invoice!';
						echo json_encode($json_return);
						exit;
					}else{
						$json_return['code'] = 0;
						$json_return['error'] = 'file not found';
						echo json_encode($json_return);
						exit;
					}
				}else{
					$json_return['code'] = 0;
					$json_return['error'] = 'Please select file';
					echo json_encode($json_return);
					exit;
				}
			}else{
				$json_return['code'] = 0;
				$json_return['error'] = 'Please select vendor';
				echo json_encode($json_return);
				exit;
			}
		}
	}

	public function get_search_item_history() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['search_item']) && $this->request->get['ivendorid']) {
			$pre_items_id = json_decode(file_get_contents('php://input'), true);
			
			$items = $this->model_api_purchase_order->getSearchItemHistory($this->request->get['search_item'],$this->request->get['ivendorid'],$pre_items_id);
			
			$json['items'] = $items;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function search_vendor_item_code() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['search_item']) && $this->request->get['ivendorid']) {
			$pre_items_id = json_decode(file_get_contents('php://input'), true);
			
			$items = $this->model_api_purchase_order->getSearchVendorItemCode($this->request->get['search_item'],$this->request->get['ivendorid'],$pre_items_id);
			
			$json['items'] = $items;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add_purchase_order_item() {

		$this->load->model('api/purchase_order');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$posted_arr = json_decode(file_get_contents('php://input'), true);
			
			$ivendorid = $posted_arr['ivendorid'];
			$items_id = $posted_arr['items_id'];
			$pre_items_id = $posted_arr['pre_items_id'];

			if(count($items_id) > 0){
				foreach ($items_id as $key => $item_id) {
					if(!in_array($item_id, $pre_items_id)){
						$json['items'][] = $this->model_api_purchase_order->getSearchItem($item_id,$ivendorid);
					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_item_history() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['iitemid']) && isset($this->request->get['radio_search_by']) && isset($this->request->get['vitemcode'])) {
			$json = $this->model_api_purchase_order->getSearchItemData($this->request->get['iitemid'],$this->request->get['radio_search_by'],$this->request->get['vitemcode'],null,null);

		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_item_history_date() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['iitemid']) && isset($this->request->get['start_date']) && isset($this->request->get['end_date']) && isset($this->request->get['vitemcode'])) {
			$json = $this->model_api_purchase_order->getSearchItemData($this->request->get['iitemid'],null,$this->request->get['vitemcode'],$this->request->get['start_date'],$this->request->get['end_date']);

		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_vendor_item() {

		$this->load->model('api/purchase_order');

		$json = array();

		if (isset($this->request->get['isupplierid'])) {
			$json = $this->model_api_purchase_order->getVendorItemData($this->request->get['isupplierid']);
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get_vendor_item_code_data() {

		$this->load->model('api/purchase_order');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$posted_arr = json_decode(file_get_contents('php://input'), true);
			
			$ivendorid = $posted_arr['ivendorid'];
			$items_id = $posted_arr['items_id'];
			$pre_items_id = $posted_arr['pre_items_id'];

			if(count($items_id) > 0){
				foreach ($items_id as $key => $item_id) {
					if(!in_array($item_id, $pre_items_id)){
						$json['items'][] = $this->model_api_purchase_order->getSearchItemVendorData($item_id['id'],$item_id['ivendorid']);
					}
				}
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {

		$json =array();
		$this->load->model('api/purchase_order');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_purchase_order->deletePurchaseOrder($temp_arr);

	        $this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;

		}else{
			$data['error'] = 'Something went wrong';
			// http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;
		}
	}
	
}
