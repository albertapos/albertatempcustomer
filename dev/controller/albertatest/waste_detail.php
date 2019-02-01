<?php
class ControllerAdministrationWasteDetail extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/physical_inventory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$items = array();
			$nnettotal = 0;
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
									'ndebitextprice' => '0.00',
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
					$nnettotal = $nnettotal + $item['nnettotal'];
				}
			}

			$temp_arr[0] = array(
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $nnettotal,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => '',
								'vtype' => 'Waste',
								'ilocid' => '',
								'dcalculatedate' => '',
								'dclosedate' => '',
								'items' => $items,
								'detail_name' => 'waste'
									
							);

			$this->model_api_physical_inventory->addPhysicalInventory($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/physical_inventory');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$items = array();
			$nnettotal = 0;
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
									'ndebitextprice' => '0.00',
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
					$nnettotal = $nnettotal + $item['nnettotal'];
				}
			}

			$temp_arr[0] = array(
								'ipiid' => $this->request->post['ipiid'],
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $nnettotal,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => '',
								'vtype' => 'Waste',
								'ilocid' => '',
								'dcalculatedate' => '',
								'dclosedate' => '',
								'items' => $items,
								'checked_items' => '',
								'detail_name' => 'waste'
							);
			

			$this->model_api_physical_inventory->editlistPhsicalInventory($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url, true));
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

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
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
			'href' => $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/waste_detail/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/waste_detail/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/waste_detail/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/waste_detail/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'], true);
		$data['searchwaste'] = $this->url->link('administration/waste_detail/search', 'token=' . $this->session->data['token'], true);
		
		$data['waste_details'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/physical_inventory');

		$waste_detail_data = $this->model_api_physical_inventory->getPhysicalInventoriesByType('Waste',$filter_data);
		
		$waste_detail_total = $this->model_api_physical_inventory->getPhysicalInventoriesByTypeTotal('Waste');

		$results = $waste_detail_data;

		foreach ($results as $result) {
			
			$data['waste_details'][] = array(
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
				'dcalculatedate'  	      => $result['dcalculatedate'],
				'dclosedate'  	      => $result['dclosedate'],
				'edit'            => $this->url->link('administration/waste_detail/edit', 'token=' . $this->session->data['token'] . '&ipiid=' . $result['ipiid'] . $url, true)
				
			);
		}
		
		if(count($waste_detail_data)==0){ 
			$data['waste_details'] =array();
			$waste_detail_total = 0;
			$data['waste_detail_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_number'] = $this->language->get('text_number');
		$data['text_created'] = $this->language->get('text_created');
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

		$pagination = new Pagination();
		$pagination->total = $waste_detail_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($waste_detail_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($waste_detail_total - $this->config->get('config_limit_admin'))) ? $waste_detail_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $waste_detail_total, ceil($waste_detail_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/waste_detail_list', $data));
	}


	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ipiid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_number'] = $this->language->get('text_number');
		$data['text_created'] = $this->language->get('text_created');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_status'] = $this->language->get('text_status');
		$data['text_notes'] = $this->language->get('text_notes');

		$data['column_sku'] = $this->language->get('column_sku');
		$data['column_item_name'] = $this->language->get('column_item_name');
		$data['column_unit_cost'] = $this->language->get('column_unit_cost');
		$data['column_pack_qty'] = $this->language->get('column_pack_qty');
		$data['column_waste_qty'] = $this->language->get('column_waste_qty');
		$data['column_reason'] = $this->language->get('column_reason');
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

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['ipiid'])) {
			$data['action'] = $this->url->link('administration/waste_detail/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/waste_detail/edit', 'token=' . $this->session->data['token'] . '&ipiid=' . $this->request->get['ipiid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('administration/waste_detail/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/waste_detail/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		$data['display_items'] = $this->url->link('administration/waste_detail/display_items', 'token=' . $this->session->data['token'], true);
		$data['calculate_post'] = $this->url->link('administration/waste_detail/calculate_post', 'token=' . $this->session->data['token'], true);
		$data['waste_list'] = $this->url->link('administration/waste_detail', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['ipiid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$waste_detail_info = $this->model_api_physical_inventory->getPhysicalInventory($this->request->get['ipiid']);
			$data['ipiid'] = $this->request->get['ipiid'];
		}

		$data['token'] = $this->session->data['token'];	

		if (isset($this->request->post['vrefnumber'])) {
			$data['vrefnumber'] = $this->request->post['vrefnumber'];
		} elseif (!empty($waste_detail_info)) {
			$data['vrefnumber'] = $waste_detail_info['vrefnumber'];
		} else {
			$temp_vrefnumber = $this->model_api_physical_inventory->getLastInsertedID();

			if(isset($temp_vrefnumber['ipiid'])){
				$data['vrefnumber'] = str_pad($temp_vrefnumber['ipiid']+1,9,"0",STR_PAD_LEFT);
			}else{
				$data['vrefnumber'] = str_pad(1,9,"0",STR_PAD_LEFT);
			}
		}

		if (isset($this->request->post['vordertitle'])) {
			$data['vordertitle'] = $this->request->post['vordertitle'];
		} elseif (!empty($waste_detail_info)) {
			$data['vordertitle'] = $waste_detail_info['vordertitle'];
		} else {
			$data['vordertitle'] = '';
		}

		if (isset($this->request->post['dcreatedate'])) {
			$data['dcreatedate'] = $this->request->post['dcreatedate'];
		} elseif (!empty($waste_detail_info)) {
			$data['dcreatedate'] = $waste_detail_info['dcreatedate'];
		} else {
			$data['dcreatedate'] = '';
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($waste_detail_info)) {
			$data['estatus'] = $waste_detail_info['estatus'];
		}

		if (isset($this->request->post['vnotes'])) {
			$data['vnotes'] = $this->request->post['vnotes'];
		} elseif (!empty($waste_detail_info)) {
			$data['vnotes'] = $waste_detail_info['vnotes'];
		} else {
			$data['vnotes'] = '';
		}

		$this->load->model('administration/waste_detail');

		$data['reasons'] = $this->model_administration_waste_detail->getReasons();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/waste_detail_form', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/waste_detail')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	public function add_items() {

		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/waste_detail');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_administration_waste_detail->getRightItems($this->request->post['checkbox_itemsort2']);

			$left_items_arr = $this->model_administration_waste_detail->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/waste_detail');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		$left_items_arr = $this->model_administration_waste_detail->getLeftItems($data);
		
		$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function display_items() {

		$this->load->language('administration/waste_detail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/waste_detail');
		$this->load->model('administration/physical_inventory_detail');
		$this->load->model('api/items');
		$this->load->model('api/physical_inventory');

		$json = array();

		if (isset($this->request->get['ipiid'])) {
			$waste_detail_info = $this->model_api_physical_inventory->getPhysicalInventory($this->request->get['ipiid']);
			if(isset($waste_detail_info)){
			
				$itms = array();

				if(isset($waste_detail_info['items']) && count($waste_detail_info['items']) > 0){

					$itms = $this->model_administration_waste_detail->getPrevRightItemIds($waste_detail_info['items']);
				}
				
				$edit_left_items = $this->model_administration_waste_detail->getEditLeftItems($itms);

				$edit_right_items =array();
				if(count($itms) > 0){
					$edit_right_items = $this->model_administration_waste_detail->getEditRightItems($itms,$this->request->get['ipiid']);
				}

				$json['items'] = $edit_left_items;
				$json['edit_right_items'] = $edit_right_items;
				$json['previous_items'] = $itms;

			}else{
				$json['items'] = $this->model_api_items->getlistItems();
			}
			
		}else{
			$json['items'] = $this->model_api_items->getlistItems();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function calculate_post() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->model('api/physical_inventory');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$items = array();
			$nnettotal = 0;
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
									'ndebitextprice' => '0.00',
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
					$nnettotal = $nnettotal + $item['nnettotal'];
				}
			}

			if(isset($this->request->post['ipiid'])){
				$temp_arr[0] = array(
								'ipiid' => $this->request->post['ipiid'],
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $nnettotal,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => date('Y-m-d H:i:s'),
								'vtype' => 'Waste',
								'ilocid' => '',
								'dcalculatedate' => date('Y-m-d H:i:s'),
								'dclosedate' => date('Y-m-d H:i:s'),
								'items' => $items,
								'detail_name' => 'waste'
							);
			}else{
				$temp_arr[0] = array(
								'vpinvtnumber' => '',
								'vrefnumber' => $this->request->post['vrefnumber'],
								'nnettotal' => $nnettotal,
								'ntaxtotal' => '0.00',
								'dcreatedate' => DateTime::createFromFormat('m-d-Y', $this->request->post['dcreatedate'])->format('Y-m-d').' 00:00:00',
								'estatus' => $this->request->post['estatus'],
								'vordertitle' => $this->request->post['vordertitle'],
								'vnotes' => $this->request->post['vnotes'],
								'dlastupdate' => date('Y-m-d H:i:s'),
								'vtype' => 'Waste',
								'ilocid' => '',
								'dcalculatedate' => date('Y-m-d H:i:s'),
								'dclosedate' => date('Y-m-d H:i:s'),
								'items' => $items,
								'detail_name' => 'waste'
							);
			}

			

			$item_response = $this->model_api_physical_inventory->calclulatePost($temp_arr);
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
		$this->load->model('api/physical_inventory');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_physical_inventory->getPhysicalInventorySearch($this->request->get['term']);

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
	
}
