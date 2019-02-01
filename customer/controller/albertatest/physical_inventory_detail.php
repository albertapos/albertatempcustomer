<?php
class ControllerAlbertatestPhysicalInventoryDetail extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('albertatest/physical_inventory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$items = array();
			$ndebitextprice = 0;
			if(isset($this->request->post['items']) && count($this->request->post['items']) > 0){
				foreach ($this->request->post['items'] as $k => $item) {
					$items[$k] = array(
									'vitemid' => $item['vitemid'],
									'vitemname' => $item['vitemname'],
									'vunitcode' => '',
									'vunitname' => '',
									'ndebitqty' => $item['ndebitqty'],
									'ncreditqty' => '0.00',
									'ndebitunitprice' => '0.00',
									'ncrediteunitprice' => '0.00',
									'nordtax' => '0.00',
									'ndebitextprice' => $item['ndebitextprice'],
									'ncrditextprice' => '0.00',
									'ndebittextprice' => '0.00',
									'ncredittextprice' => '0.00',
									'vbarcode' => $item['vbarcode'],
									'vreasoncode' => '',
									'ndiffqty' => '0.00',
									'vvendoritemcode' => '',
									'npackqty' => $item['npackqty'],
									'nunitcost' => $item['nunitcost'],
									'itotalunit' => $item['itotalunit']
								);
					$ndebitextprice = $ndebitextprice + $item['ndebitextprice'];
				}
			}

			$temp_arr[0] = array(
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $ndebitextprice,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => '',
								'vtype' => 'Physical',
								'ilocid' => $this->request->post['ilocid'],
								'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
								'dclosedate' => '',
								'items' => $items,
								'detail_name' => 'physical'
									
							);

			$this->model_albertatest_physical_inventory->addPhysicalInventory($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('albertatest/physical_inventory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$items = array();
			$ndebitextprice = 0;
			if(isset($this->request->post['items']) && count($this->request->post['items']) > 0){
				foreach ($this->request->post['items'] as $k => $item) {

					$items[$k] = array(
									'vitemid' => $item['vitemid'],
									'vitemname' => $item['vitemname'],
									'vunitcode' => '',
									'vunitname' => '',
									'ndebitqty' => $item['ndebitqty'],
									'ncreditqty' => '0.00',
									'ndebitunitprice' => '0.00',
									'ncrediteunitprice' => '0.00',
									'nordtax' => '0.00',
									'ndebitextprice' => $item['ndebitextprice'],
									'ncrditextprice' => '0.00',
									'ndebittextprice' => '0.00',
									'ncredittextprice' => '0.00',
									'vbarcode' => $item['vbarcode'],
									'vreasoncode' => '',
									'ndiffqty' => '0.00',
									'vvendoritemcode' => '',
									'npackqty' => $item['npackqty'],
									'nunitcost' => $item['nunitcost'],
									'itotalunit' => $item['itotalunit']
								);
					$ndebitextprice = $ndebitextprice + $item['ndebitextprice'];
				}
			}

			$temp_arr[0] = array(
								'ipiid' => $this->request->post['ipiid'],
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $ndebitextprice,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => '',
								'vtype' => 'Physical',
								'ilocid' => $this->request->post['ilocid'],
								'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
								'dclosedate' => '',
								'items' => $items,
								'detail_name' => 'physical'
							);
			
			$this->model_albertatest_physical_inventory->editlistPhsicalInventory($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ipiid';
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

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('albertatest/physical_inventory_detail/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('albertatest/physical_inventory_detail/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('albertatest/physical_inventory_detail/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('albertatest/physical_inventory_detail/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'], true);
		$data['searchphysical'] = $this->url->link('albertatest/physical_inventory_detail/search', 'token=' . $this->session->data['token'], true);
		
		$data['physical_inventory_details'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('albertatest/physical_inventory');
		$this->load->model('administration/physical_inventory_detail');

		$physical_inventory_detail_data = $this->model_albertatest_physical_inventory->getPhysicalInventoriesByType('Physical',$filter_data);
		
		$physical_inventory_detail_total = $this->model_albertatest_physical_inventory->getPhysicalInventoriesByTypeTotal('Physical');

		$results = $physical_inventory_detail_data;

		foreach ($results as $result) {
			
			$data['physical_inventory_details'][] = array(
				'ipiid'     => $result['ipiid'],
				'vpinvtnumber'   => $result['vpinvtnumber'],
				'vrefnumber'   => $result['vrefnumber'],
				'nnettotal'  => $result['nnettotal'],
				'ntaxtotal'        => $result['ntaxtotal'],
				'dcreatedate'  	  => $result['dcreatedate'],
				'estatus'  	      => $result['estatus'],
				'vordertitle'  	      => $result['vordertitle'],
				'vnotes'  	      => $result['vnotes'],
				'vtype'  	      => $result['vtype'],
				'ilocid'  	      => $result['ilocid'],
				'dcalculatedate'  => $result['dcalculatedate'],
				'dclosedate'  	  => $result['dclosedate'],
				'edit'            => $this->url->link('albertatest/physical_inventory_detail/edit', 'token=' . $this->session->data['token'] . '&ipiid=' . $result['ipiid'] . $url, true)
				
			);
		}
		
		if(count($physical_inventory_detail_data)==0){ 
			$data['physical_inventory_details'] =array();
			$physical_inventory_detail_total = 0;
			$data['physical_inventory_detail_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_number'] = $this->language->get('text_number');
		$data['text_location'] = $this->language->get('text_location');
		$data['text_created'] = $this->language->get('text_created');
		$data['text_calculated'] = $this->language->get('text_calculated');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_status'] = $this->language->get('text_status');
		$data['text_notes'] = $this->language->get('text_notes');

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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		$data['locations'] = $this->model_administration_physical_inventory_detail->getLocations();

		$pagination = new Pagination();
		$pagination->total = $physical_inventory_detail_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($physical_inventory_detail_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($physical_inventory_detail_total - $this->config->get('config_limit_admin'))) ? $physical_inventory_detail_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $physical_inventory_detail_total, ceil($physical_inventory_detail_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('albertatest/physical_inventory_detail_list', $data));
	}


	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ipiid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_number'] = $this->language->get('text_number');
		$data['text_created'] = $this->language->get('text_created');
		$data['text_calculated'] = $this->language->get('text_calculated');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_status'] = $this->language->get('text_status');
		$data['text_notes'] = $this->language->get('text_notes');

		$data['column_sku'] = $this->language->get('column_sku');
		$data['column_item_name'] = $this->language->get('column_item_name');
		$data['column_unit_cost'] = $this->language->get('column_unit_cost');
		$data['column_pack_qty'] = $this->language->get('column_pack_qty');
		$data['column_invt_count'] = $this->language->get('column_invt_count');
		$data['column_total_unit'] = $this->language->get('column_total_unit');
		$data['column_total_amt'] = $this->language->get('column_total_amt');

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

		if (isset($this->error['vrefnumber'])) {
			$data['error_vrefnumber'] = $this->error['vrefnumber'];
		} else {
			$data['error_vrefnumber'] = '';
		}

		if (isset($this->error['vordertitle'])) {
			$data['error_vordertitle'] = $this->error['vordertitle'];
		} else {
			$data['error_vordertitle'] = '';
		}

		if (isset($this->error['dcreatedate'])) {
			$data['error_dcreatedate'] = $this->error['dcreatedate'];
		} else {
			$data['error_dcreatedate'] = '';
		}

		if (isset($this->error['dcalculatedate'])) {
			$data['error_dcalculatedate'] = $this->error['dcalculatedate'];
		} else {
			$data['error_dcalculatedate'] = '';
		}

		if (isset($this->error['ilocid'])) {
			$data['error_ilocid'] = $this->error['ilocid'];
		} else {
			$data['error_ilocid'] = '';
		}

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['ipiid'])) {
			$data['action'] = $this->url->link('albertatest/physical_inventory_detail/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('albertatest/physical_inventory_detail/edit', 'token=' . $this->session->data['token'] . '&ipiid=' . $this->request->get['ipiid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('albertatest/physical_inventory_detail/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('albertatest/physical_inventory_detail/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		$data['display_items'] = $this->url->link('albertatest/physical_inventory_detail/display_items', 'token=' . $this->session->data['token'], true);
		$data['display_items_search'] = $this->url->link('albertatest/physical_inventory_detail/display_items_search', 'token=' . $this->session->data['token'], true);
		$data['calculate_post'] = $this->url->link('albertatest/physical_inventory_detail/calculate_post', 'token=' . $this->session->data['token'], true);
		$data['physical_inventory_list'] = $this->url->link('albertatest/physical_inventory_detail', 'token=' . $this->session->data['token'], true);

		$data['import_physical_inventory'] = $this->url->link('albertatest/physical_inventory_detail/import_physical_inventory', 'token=' . $this->session->data['token'], true);
		$data['calculate_post_check_data'] = $this->url->link('albertatest/physical_inventory_detail/calculate_post_check_data', 'token=' . $this->session->data['token'], true);

		$data['add_new_import_physical_inventory'] = $this->url->link('albertatest/physical_inventory_detail/add_new_import_physical_inventory', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['ipiid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$physical_inventory_detail_info = $this->model_albertatest_physical_inventory->getPhysicalInventory($this->request->get['ipiid']);
			$data['ipiid'] = $this->request->get['ipiid'];
		}

		$data['token'] = $this->session->data['token'];	

		if (isset($this->request->post['vrefnumber'])) {
			$data['vrefnumber'] = $this->request->post['vrefnumber'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['vrefnumber'] = $physical_inventory_detail_info['vrefnumber'];
		} else {
			$temp_vrefnumber = $this->model_albertatest_physical_inventory->getLastInsertedID();

			if(isset($temp_vrefnumber['ipiid'])){
				$data['vrefnumber'] = str_pad($temp_vrefnumber['ipiid']+1,9,"0",STR_PAD_LEFT);
			}else{
				$data['vrefnumber'] = str_pad(1,9,"0",STR_PAD_LEFT);
			}
		}

		if (isset($this->request->post['vordertitle'])) {
			$data['vordertitle'] = $this->request->post['vordertitle'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['vordertitle'] = $physical_inventory_detail_info['vordertitle'];
		} else {
			$data['vordertitle'] = '';
		}

		if (isset($this->request->post['dcreatedate'])) {
			$data['dcreatedate'] = $this->request->post['dcreatedate'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['dcreatedate'] = $physical_inventory_detail_info['dcreatedate'];
		} else {
			$data['dcreatedate'] = '';
		}

		if (isset($this->request->post['dcalculatedate'])) {
			$data['dcalculatedate'] = $this->request->post['dcalculatedate'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['dcalculatedate'] = $physical_inventory_detail_info['dcalculatedate'];
		} else {
			$data['dcalculatedate'] = '';
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['estatus'] = $physical_inventory_detail_info['estatus'];
		}

		if (isset($this->request->post['vnotes'])) {
			$data['vnotes'] = $this->request->post['vnotes'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['vnotes'] = $physical_inventory_detail_info['vnotes'];
		} else {
			$data['vnotes'] = '';
		}

		if (isset($this->request->post['ilocid'])) {
			$data['ilocid'] = $this->request->post['ilocid'];
		} elseif (!empty($physical_inventory_detail_info)) {
			$data['ilocid'] = $physical_inventory_detail_info['ilocid'];
		} else {
			$data['ilocid'] = '';
		}

		$this->load->model('administration/physical_inventory_detail');

		$data['locations'] = $this->model_administration_physical_inventory_detail->getLocations();

		$data['reasons'] = $this->model_administration_physical_inventory_detail->getReasons();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('albertatest/physical_inventory_detail_form', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/physical_inventory')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	public function add_items() {

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/physical_inventory_detail');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_administration_physical_inventory_detail->getRightItems($this->request->post['checkbox_itemsort2']);

			//$left_items_arr = $this->model_administration_physical_inventory_detail->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			//$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/physical_inventory_detail');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		//$left_items_arr = $this->model_administration_physical_inventory_detail->getLeftItems($data);
		
		//$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function display_items() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/physical_inventory_detail');
		$this->load->model('api/items');
		$this->load->model('albertatest/physical_inventory');

		$json = array();

		if (isset($this->request->get['ipiid'])) {
			$physical_inventory_detail_info = $this->model_albertatest_physical_inventory->getPhysicalInventory($this->request->get['ipiid']);
			if(isset($physical_inventory_detail_info)){
			
				$itms = array();

				if(isset($physical_inventory_detail_info['items']) && count($physical_inventory_detail_info['items']) > 0){

					$itms = $this->model_administration_physical_inventory_detail->getPrevRightItemIds($physical_inventory_detail_info['items']);
				}
				
				//$edit_left_items = $this->model_administration_physical_inventory_detail->getEditLeftItems($itms);

				$edit_right_items =array();
				if(count($itms) > 0){
					$edit_right_items = $this->model_administration_physical_inventory_detail->getEditRightItems($itms,$this->request->get['ipiid']);
				}

				//$json['items'] = $edit_left_items;
				$json['edit_right_items'] = $edit_right_items;
				$json['previous_items'] = $itms;

			}else{
				//$json['items'] = $this->model_administration_physical_inventory_detail->getlistItems();
			}
			
		}else{
			//$json['items'] = $this->model_administration_physical_inventory_detail->getlistItems();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function calculate_post() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->model('albertatest/physical_inventory');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$items = array();
			$ndebitextprice = 0;
			if(isset($this->request->post['items']) && count($this->request->post['items']) > 0){
			    foreach ($this->request->post['items'] as $k => $item) {

			    	$query_item_qoh = $this->db2->query("SELECT iqtyonhand,isparentchild,parentid,parentmasterid FROM mst_item WHERE iitemid='". (int)$item['vitemid'] ."'")->row;

			    	if($query_item_qoh['isparentchild'] == 1){
			    		$query_item_qoh = $this->db2->query("SELECT iqtyonhand,isparentchild,parentid,parentmasterid FROM mst_item WHERE iitemid='". (int)$query_item_qoh['parentmasterid'] ."'")->row;
			    	}


			        $items[$k] = array(
			                        'vitemid' => $item['vitemid'],
			                        'vitemname' => $item['vitemname'],
			                        'vunitcode' => '',
			                        'vunitname' => '',
			                        'ndebitqty' => $item['ndebitqty'],
			                        'ncreditqty' => '0.00',
			                        'ndebitunitprice' => '0.00',
			                        'ncrediteunitprice' => '0.00',
			                        'nordtax' => '0.00',
			                        'ndebitextprice' => $item['ndebitextprice'],
			                        'ncrditextprice' => '0.00',
			                        'ndebittextprice' => '0.00',
			                        'ncredittextprice' => '0.00',
			                        'vbarcode' => $item['vbarcode'],
			                        'vreasoncode' => '',
			                        'ndiffqty' => $query_item_qoh['iqtyonhand'] - $item['itotalunit'],
			                        'vvendoritemcode' => '',
			                        'npackqty' => $item['npackqty'],
			                        'nunitcost' => $item['nunitcost'],
			                        'itotalunit' => $item['itotalunit']
			                    );
			        $ndebitextprice = $ndebitextprice + $item['ndebitextprice'];
			    }
			}

			if(isset($this->request->post['ipiid'])){
				$temp_arr[0] = array(
			                'ipiid' => $this->request->post['ipiid'],
			                'vpinvtnumber' => '',
			                'vrefnumber' => $this->request->post['vrefnumber'],
			                'nnettotal' => $ndebitextprice,
			                'ntaxtotal' => '0.00',
			                'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
			                'estatus' => "Close",
			                'vordertitle' => $this->request->post['vordertitle'],
			                'vnotes' => $this->request->post['vnotes'],
			                'dlastupdate' => date('Y-m-d H:i:s'),
			                'vtype' => 'Physical',
			                'ilocid' => $this->request->post['ilocid'],
			                'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
			                'dclosedate' => date('Y-m-d H:i:s'),
			                'items' => $items,
			                'detail_name' => 'physical'
			            );
			}else{
				$temp_arr[0] = array(
			                'vpinvtnumber' => '',
			                'vrefnumber' => $this->request->post['vrefnumber'],
			                'nnettotal' => $ndebitextprice,
			                'ntaxtotal' => '0.00',
			                'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
			                'estatus' => "Close",
			                'vordertitle' => $this->request->post['vordertitle'],
			                'vnotes' => $this->request->post['vnotes'],
			                'dlastupdate' => date('Y-m-d H:i:s'),
			                'vtype' => 'Physical',
			                'ilocid' => $this->request->post['ilocid'],
			                'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
			                'dclosedate' => date('Y-m-d H:i:s'),
			                'items' => $items,
			                'detail_name' => 'physical'
			             );
			}
			
			$item_response = $this->model_albertatest_physical_inventory->calclulatePost($temp_arr);
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

	public function search(){
		$return = array();
		$this->load->model('albertatest/physical_inventory');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_albertatest_physical_inventory->getPhysicalInventorySearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['ipiid'] = $value['ipiid'];
				$temp['vordertitle'] = $value['vordertitle'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}

	
	public function import_physical_inventory() {
		$this->load->model('albertatest/physical_inventory');

		$data = array();
		$json_return = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if(isset($this->request->files['import_physical_inventory_file']) && $this->request->files['import_physical_inventory_file']['name'] != ''){
				$import_physical_inventory_file = $this->request->files['import_physical_inventory_file']['tmp_name'];
				$ipiid = $this->request->post['ipiid'];

					$handle = fopen($import_physical_inventory_file, "r");
					$line_row_index=1;
					$item_exist_flag=false;

					if ($handle) {
						$item_total_ndebitextprice = '0.00';
						while (($strline = fgets($handle)) !== false) {
						$arr = explode(',', $strline);
							if($line_row_index != 1){
								if(count($arr) != 2){
									$return['code'] = 0;
									$return['error'] = "Your csv file is not valid";
									$this->response->addHeader('Content-Type: application/json');
								    echo json_encode($return);
									exit;
								}else{
									$item_vbarcode = str_replace('"', '', $arr[0]);
									
									$item_arr = $this->model_albertatest_physical_inventory->getItemBySKU($item_vbarcode);

									if(count($item_arr) > 0){
										$ipiid_arr = $this->model_albertatest_physical_inventory->getItemBySKUipiid($ipiid,$item_arr['iitemid']);
										if(count($ipiid_arr) == 0){
											
											$item_ndebitqty = $arr[1];
											$item_npackqty = 1;
											$item_itotalunit = $item_ndebitqty * $item_npackqty;
											$item_ndebitextprice = $item_itotalunit * $item_arr['nunitcost'];

											$items = array(
													'vitemid' => $item_arr['iitemid'],
													'vitemname' => $item_arr['vitemname'],
													'vunitcode' => $item_arr['vunitcode'],
													'vunitname' => '',
													'ndebitqty' => $item_ndebitqty,
													'ncreditqty' => '0.00',
													'ndebitunitprice' => '0.00',
													'ncrediteunitprice' => '0.00',
													'nordtax' => '0.00',
													'ndebitextprice' => $item_ndebitextprice,
													'ncrditextprice' => '0.00',
													'ndebittextprice' => '0.00',
													'ncredittextprice' => '0.00',
													'vbarcode' => $item_arr['vbarcode'],
													'vreasoncode' => '',
													'ndiffqty' => '0.00',
													'vvendoritemcode' => '',
													'npackqty' => $item_npackqty,
													'nunitcost' => $item_arr['nunitcost'],
													'itotalunit' => $item_itotalunit
												);

											$item_total_ndebitextprice = $item_total_ndebitextprice + $item_ndebitextprice;

											$this->model_albertatest_physical_inventory->insertInventory($ipiid,$items);

										}
									}else{
										$item_exist_flag=true;
									}
								}
							}
						$line_row_index++;
						}
						$this->model_albertatest_physical_inventory->updatennettotal($ipiid,$item_total_ndebitextprice);

						$json_return['code'] = 1;
						if($item_exist_flag == true){
							$json_return['success'] = 'Physical Inventory Imported Successfully and Some Items not Exists in System!';
						}else{
							$json_return['success'] = 'Physical Inventory Imported Successfully';
						}
						
						echo json_encode($json_return);
						exit;
					}else{
						$json_return['code'] = 0;
						$json_return['error'] = 'Something went wrong';
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
			$json_return['error'] = 'Something went wrong';
			echo json_encode($json_return);
			exit;
		}

	}

	public function add_new_import_physical_inventory() {
		$this->load->model('albertatest/physical_inventory');

		$data = array();
		$json_return = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if(isset($this->request->files['add_import_physical_inventory_file']) && $this->request->files['add_import_physical_inventory_file']['name'] != ''){
				$add_import_physical_inventory_file = $this->request->files['add_import_physical_inventory_file']['tmp_name'];
				
				$line_row_index=1;
				$item_exist_flag=false;
				$items = array();

					$handle = fopen($add_import_physical_inventory_file, "r");
					if ($handle) {
						
						while (($strline = fgets($handle)) !== false) {
						$arr = explode(',', $strline);
							if($line_row_index != 1){
								if(count($arr) != 2){
									$return['code'] = 0;
									$return['error'] = "Your csv file is not valid";
									$this->response->addHeader('Content-Type: application/json');
								    echo json_encode($return);
									exit;
								}else{
									$item_vbarcode = str_replace('"', '', $arr[0]);
									
									$item_arr = $this->model_albertatest_physical_inventory->getItemBySKU($item_vbarcode);

									if(count($item_arr) > 0){
										$item_ndebitqty = $arr[1];
										$item_npackqty = 1;
										$item_itotalunit = $item_ndebitqty * $item_npackqty;
										$item_ndebitextprice = $item_itotalunit * $item_arr['nunitcost'];

										$items[] = array(
												'vitemid' => $item_arr['iitemid'],
												'vitemname' => $item_arr['vitemname'],
												'vunitcode' => $item_arr['vunitcode'],
												'vunitname' => '',
												'ndebitqty' => $item_ndebitqty,
												'ncreditqty' => '0.00',
												'ndebitunitprice' => '0.00',
												'ncrediteunitprice' => '0.00',
												'nordtax' => '0.00',
												'ndebitextprice' => $item_ndebitextprice,
												'ncrditextprice' => '0.00',
												'ndebittextprice' => '0.00',
												'ncredittextprice' => '0.00',
												'vbarcode' => $item_arr['vbarcode'],
												'vreasoncode' => '',
												'ndiffqty' => '0.00',
												'vvendoritemcode' => '',
												'npackqty' => $item_npackqty,
												'nunitcost' => $item_arr['nunitcost'],
												'itotalunit' => $item_itotalunit
											);
									}else{
										$item_exist_flag=true;
									}
								}
							}
							$line_row_index++;
						}

						$json_return['code'] = 1;
						if($item_exist_flag){
							$json_return['success'] = 'Physical Inventory Imported Successfully and Some Items not Exists in System!';
						}else{
							$json_return['success'] = 'Physical Inventory Imported Successfully';
						}
						
						$json_return['items'] = $items;
						echo json_encode($json_return);
						exit;
					}else{
						$json_return['code'] = 0;
						$json_return['error'] = 'Something went wrong';
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
			$json_return['error'] = 'Something went wrong';
			echo json_encode($json_return);
			exit;
		}

	}

	public function calculate_post_check_data() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->model('albertatest/physical_inventory');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$items = array();
			$ndebitextprice = 0;
			if(isset($this->request->post['items']) && count($this->request->post['items']) > 0){
			    foreach ($this->request->post['items'] as $k => $item) {

			        $items[$k] = array(
			                        'vitemid' => $item['vitemid'],
			                        'vitemname' => $item['vitemname'],
			                        'vunitcode' => '',
			                        'vunitname' => '',
			                        'ndebitqty' => $item['ndebitqty'],
			                        'ncreditqty' => '0.00',
			                        'ndebitunitprice' => '0.00',
			                        'ncrediteunitprice' => '0.00',
			                        'nordtax' => '0.00',
			                        'ndebitextprice' => $item['ndebitextprice'],
			                        'ncrditextprice' => '0.00',
			                        'ndebittextprice' => '0.00',
			                        'ncredittextprice' => '0.00',
			                        'vbarcode' => $item['vbarcode'],
			                        'vreasoncode' => '',
			                        'ndiffqty' => '0.00',
			                        'vvendoritemcode' => '',
			                        'npackqty' => $item['npackqty'],
			                        'nunitcost' => $item['nunitcost'],
			                        'itotalunit' => $item['itotalunit']
			                    );
			        $ndebitextprice = $ndebitextprice + $item['ndebitextprice'];
			    }
			}

			if(isset($this->request->post['ipiid'])){
				$temp_arr[0] = array(
			                'ipiid' => $this->request->post['ipiid'],
			                'vpinvtnumber' => '',
			                'vrefnumber' => $this->request->post['vrefnumber'],
			                'nnettotal' => $ndebitextprice,
			                'ntaxtotal' => '0.00',
			                'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
			                'estatus' => "Close",
			                'vordertitle' => $this->request->post['vordertitle'],
			                'vnotes' => $this->request->post['vnotes'],
			                'dlastupdate' => date('Y-m-d H:i:s'),
			                'vtype' => 'Physical',
			                'ilocid' => $this->request->post['ilocid'],
			                'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
			                'dclosedate' => date('Y-m-d H:i:s'),
			                'items' => $items,
			                'detail_name' => 'physical'
			            );
			}else{
				$temp_arr[0] = array(
			                'vpinvtnumber' => '',
			                'vrefnumber' => $this->request->post['vrefnumber'],
			                'nnettotal' => $ndebitextprice,
			                'ntaxtotal' => '0.00',
			                'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
			                'estatus' => "Close",
			                'vordertitle' => $this->request->post['vordertitle'],
			                'vnotes' => $this->request->post['vnotes'],
			                'dlastupdate' => date('Y-m-d H:i:s'),
			                'vtype' => 'Physical',
			                'ilocid' => $this->request->post['ilocid'],
			                'dcalculatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcalculatedate'])->format('Y-m-d').' 00:00:00',
			                'dclosedate' => date('Y-m-d H:i:s'),
			                'items' => $items,
			                'detail_name' => 'physical'
			             );
			}

			$item_response = $this->model_albertatest_physical_inventory->calclulatePostCheckData($temp_arr);
			$json = $item_response;
		}

		$this->response->addHeader('Content-Type: application/json');
		echo json_encode($json);
		exit;
	}

	public function display_items_search() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->language('albertatest/physical_inventory_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/physical_inventory_detail');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$post_arr = json_decode(file_get_contents('php://input'), true);

			if(isset($post_arr['search_val']) && isset($post_arr['search_by']) && isset($post_arr['right_items'])){
				
					$json['items'] = $this->model_administration_physical_inventory_detail->getSearchItems($post_arr);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
