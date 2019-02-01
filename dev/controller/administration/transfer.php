<?php
class ControllerAdministrationTransfer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function listing() {
		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getListing();
	}

	public function getListing(){
		$data['breadcrumbs'] = array();

		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/transfer/list', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/transfer', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('api/transfer');

		$transfer_data = $this->model_api_transfer->getTransfersData($filter_data);

		$transfer_total = $this->model_api_transfer->getTransfersTotal($filter_data);

		$data['transfers'] = $transfer_data;
		
		if(count($transfer_data)==0){ 
			$data['transfers'] =array();
			$transfer_total = 0;
			$data['transfer_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');

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

		$pagination = new Pagination();
		$pagination->total = $transfer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/transfer/listing', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transfer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transfer_total - $this->config->get('config_limit_admin'))) ? $transfer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transfer_total, ceil($transfer_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/transfer_listing', $data));


	}

	public function add() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/transfer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			echo "<pre>";
			print_r($this->request->post);
			exit;
			
			$datas[] = $this->request->post;

			$this->model_api_template->addTemplate($datas);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/transfer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$dreceivedate = DateTime::createFromFormat('m-d-Y', $this->request->post['transfer']['dreceivedate'])->format('Y-m-d');

			$datas[0]['vvendortype'] = $this->request->post['transfer']['vvendortype'];
			$datas[0]['estatus'] = $this->request->post['transfer']['estatus'];
			$datas[0]['vwhcode'] = $this->request->post['transfer']['vwhcode'];
			$datas[0]['vtransfertype'] = $this->request->post['transfer']['vtransfertype'];
			$datas[0]['dreceivedate'] = $dreceivedate;
			$datas[0]['vvendorid'] = $this->request->post['transfer']['vvendorid'];
			$datas[0]['vinvnum'] = $this->request->post['transfer']['vinvnum'];
			$datas[0]['items'] = $this->request->post['items'];

			$data = $this->model_api_transfer->editlistTransfer($datas);

			$this->session->data['success'] = $this->language->get('text_success');

			// $url = '&vtransfertype='.$this->request->post['transfer']['vtransfertype'];
			// $url .= '&vvendorid='.$this->request->post['transfer']['vvendorid'];


			// $this->response->redirect($this->url->link('administration/transfer/listing', 'token=' . $this->session->data['token'], true));

			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}

		// $this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'iwtrnid';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
			'href' => $this->url->link('administration/transfer', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/transfer/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/transfer/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/transfer/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/transfer/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['check_invoice'] = $this->url->link('administration/transfer/check_invoice', 'token=' . $this->session->data['token'] . $url, true);

		$data['filter'] = $this->url->link('administration/transfer', 'token=' . $this->session->data['token'] . $url, true);

		$data['action'] = $this->url->link('administration/transfer/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['cancel'] = $this->url->link('administration/transfer/listing', 'token=' . $this->session->data['token'], true);

		$data['add_items'] = $this->url->link('administration/transfer/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/transfer/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		$data['display_items'] = $this->url->link('administration/transfer/display_items', 'token=' . $this->session->data['token'], true);
		
		$data['transfers'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/transfer');
		$this->load->model('administration/transfer');

		$vendors = $this->model_administration_transfer->getVendors();

		$data['vendors'] = $vendors;

		$transfer_data = array();

		if(count($transfer_data)==0){ 
			$data['transfers'] =array();
			$transfer_total = 0;
			$data['transfer_row'] =1;
		}

		$data['heading_title'] = 'Add Transfer';

		$data['text_list'] = 'Add Transfer';
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_transfer_type'] = $this->language->get('text_transfer_type');
		$data['text_transfer_date'] = $this->language->get('text_transfer_date');
		$data['text_vendor'] = $this->language->get('text_vendor');
		$data['text_invoice'] = $this->language->get('text_invoice');

		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');

		$data['transfer_types'][0]['value_transfer'] = $this->language->get('WarehouseToStore');
		$data['transfer_types'][0]['text_transfer'] = $this->language->get('text_WarehouseToStore');
		$data['transfer_types'][1]['value_transfer'] = $this->language->get('StoretoWarehouse');
		$data['transfer_types'][1]['text_transfer'] = $this->language->get('text_StoretoWarehouse');
		// $data['transfer_types'][2]['value_transfer'] = $this->language->get('Storetostore');
		// $data['transfer_types'][2]['text_transfer'] = $this->language->get('text_Storetostore');

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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $transfer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/transfer', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transfer_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transfer_total - $this->config->get('config_limit_admin'))) ? $transfer_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transfer_total, ceil($transfer_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/transfer_list', $data));
	}


	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['itemplateid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_template_type'] = $this->language->get('text_template_type');
		$data['text_inventory_type'] = $this->language->get('text_inventory_type');
		$data['text_template_name'] = $this->language->get('text_template_name');
		$data['text_template_sequence'] = $this->language->get('text_template_sequence');
		$data['text_template_status'] = $this->language->get('text_template_status');

		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['temp_types'][] = $this->language->get('PO');
		$data['temp_types'][] = $this->language->get('PO1');

		$data['temp_invent_types'][] = $this->language->get('Daily');
		$data['temp_invent_types'][] = $this->language->get('Weekly');
		$data['temp_invent_types'][] = $this->language->get('Monthly');

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

		if (isset($this->error['vtemplatename'])) {
			$data['error_vtemplatename'] = $this->error['vtemplatename'];
		} else {
			$data['error_vtemplatename'] = '';
		}

		if (isset($this->error['vtemplatetype'])) {
			$data['error_vtemplatetype'] = $this->error['vtemplatetype'];
		} else {
			$data['error_vtemplatetype'] = '';
		}

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['itemplateid'])) {
			$data['action'] = $this->url->link('administration/template/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/template/edit', 'token=' . $this->session->data['token'] . '&itemplateid=' . $this->request->get['itemplateid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('administration/template/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/template/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['itemplateid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$template_info = $this->model_api_template->getTemplate($this->request->get['itemplateid']);
			$data['itemplateid'] = $this->request->get['itemplateid'];
		}

		$data['token'] = $this->session->data['token'];	

		if (isset($this->request->post['vtemplatename'])) {
			$data['vtemplatename'] = $this->request->post['vtemplatename'];
		} elseif (!empty($template_info)) {
			$data['vtemplatename'] = $template_info['vtemplatename'];
		} else {
			$data['vtemplatename'] = '';
		}

		if (isset($this->request->post['vtemplatetype'])) {
			$data['vtemplatetype'] = $this->request->post['vtemplatetype'];
		} elseif (!empty($template_info)) {
			$data['vtemplatetype'] = $template_info['vtemplatetype'];
		} else {
			$data['vtemplatetype'] = '';
		}

		if (isset($this->request->post['vinventorytype'])) {
			$data['vinventorytype'] = $this->request->post['vinventorytype'];
		} elseif (!empty($template_info)) {
			$data['vinventorytype'] = $template_info['vinventorytype'];
		} else {
			$data['vinventorytype'] = '';
		}

		if (isset($this->request->post['isequence'])) {
			$data['isequence'] = $this->request->post['isequence'];
		} elseif (!empty($template_info)) {
			$data['isequence'] = $template_info['isequence'];
		} else {
			$data['isequence'] = '';
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($template_info)) {
			$data['estatus'] = $template_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		if(isset($template_info)){
			$this->load->model('administration/template');

			$itms = array();

			if(isset($template_info['items']) && count($template_info['items']) > 0){

				$itms = $this->model_administration_template->getPrevRightItemIds($template_info['items']);
			}
			
			$edit_left_items = $this->model_administration_template->getEditLeftItems($itms);

			$edit_right_items =array();
			if(count($itms) > 0){
				$edit_right_items = $this->model_administration_template->getEditRightItems($itms,$this->request->get['itemplateid']);
			}

			$data['items'] = $edit_left_items;
			$data['edit_right_items'] = $edit_right_items;
			$data['previous_items'] = $itms;

		}else{
			
			$this->load->model('api/items');

			$data['items'] = $this->model_api_items->getItems();
		}

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/template_form', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/template')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	public function add_items() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/transfer');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_administration_transfer->getRightItems($this->request->post['checkbox_itemsort2']);

			$left_items_arr = $this->model_administration_transfer->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/transfer');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		$left_items_arr = $this->model_administration_transfer->getLeftItems($data);
		
		$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function display_items() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/transfer');
		$this->load->model('api/items');
		$this->load->model('api/transfer');

		$json = array();

		$vendors = $this->model_administration_transfer->getVendors();

		if((isset($this->request->get['vtransfertype']) && isset($this->request->get['vvendorid'])) && (($this->request->server['REQUEST_METHOD'] != 'POST'))) {
			
			$json['vendor_id'] = $this->request->get['vvendorid'];
			$vendor_id = $this->request->get['vvendorid'];
			$json['vtransfertype'] = $this->request->get['vtransfertype'];
			$vtransfertype = $this->request->get['vtransfertype'];
		}else{
			
			$json['vendor_id'] = $vendors[0]['isupplierid'];
			$vendor_id = $vendors[0]['isupplierid'];
			$json['vtransfertype'] = 'WarehouseToStore';
			$vtransfertype = 'WarehouseToStore';
		}
		
		$transfer_data = $this->model_api_transfer->getTransfers($vtransfertype,$vendor_id);
		
		if(isset($transfer_data)){
			
			$itms = array();

			if(isset($transfer_data) && count($transfer_data) > 0){

				$itms = $this->model_administration_transfer->getPrevRightItemIds($transfer_data);
			}
			
			$edit_left_items = $this->model_administration_transfer->getEditLeftItems($itms,$vendor_id);
			
			$edit_right_items =array();
			if(count($itms) > 0){
				$edit_right_items = $this->model_administration_transfer->getEditRightItems($itms,$vtransfertype,$vendor_id);

				if($vtransfertype == 'WarehouseToStore'){
					$json['vinvnum'] = "";
				}

			}

			$json['items'] = $edit_left_items;
			$json['edit_right_items'] = $edit_right_items;
			$json['previous_items'] = $itms;

		}else{

			$json['items'] = $this->model_api_items->getlistItems();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function check_invoice() {

		$this->load->language('administration/transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/transfer');

		$json = array();

		if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['invoice'] != '') {
			$json = $this->model_api_transfer->getCheckInvoice($this->request->post['invoice']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
