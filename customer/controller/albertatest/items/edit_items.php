<?php
class ControllerAlbertatestItemsEditItems extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('albertatest/items/edit_items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function edit_list() {

		$this->load->language('albertatest/items/edit_items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('albertatest/items/edit_items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$post_data = $this->request->post;

			if(isset($post_data['options_checkbox']) && $post_data['options_checkbox'] != ''){
				$post_data['options_data']['unit_id'] = $this->request->post['update_unit_id'];
				$post_data['options_data']['unit_value'] = $this->request->post['update_unit_value'];
				$post_data['options_data']['bucket_id'] = $this->request->post['update_bucket_id'];
				if(isset($this->request->post['update_malt']) && $this->request->post['update_malt'] == 1){
					$post_data['options_data']['malt'] = $this->request->post['update_malt'];
				}else{
					$post_data['options_data']['malt'] = 0;
				}

			}else{
				$post_data['options_data'] = array();
			}

			// $decodedText = html_entity_decode($this->request->post['items_id_array']);
			// $items_id_array = json_decode($decodedText, true);

			$post_data['item_ids'] = $this->session->data['items_total_ids'];
			
			$this->model_albertatest_items_edit_items->editlistItems($post_data);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '&search_radio='.$this->request->post['search_radio_btn'].'&search_find='.$this->request->post['search_find_btn'];

			$this->response->redirect($this->url->link('albertatest/items/edit_items', 'token=' . $this->session->data['token'] . $url, true));
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
			$search_radio = 'category';
		}

		$this->load->model('administration/items');

		$categories = $this->model_administration_items->getCategories();
		$default_cat_id = $categories[0]['icategoryid'];
		
		if (isset($this->request->post['search_vcategorycode']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'category') {
			$search_find =  $this->request->post['search_vcategorycode'];
			$page = 1;
		}else if (isset($this->request->post['search_vdepcode']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'department'){
			$search_find =  $this->request->post['search_vdepcode'];
			$page = 1;
		}else if (isset($this->request->post['search_vsuppliercode']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'supplier'){
			$search_find =  $this->request->post['search_vsuppliercode'];
			$page = 1;
		}else if (isset($this->request->post['search_vitem_group_id']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'item_group'){
			$search_find =  $this->request->post['search_vitem_group_id'];
			$page = 1;
		}else if (isset($this->request->post['search_vfood_stamp']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'food_stamp'){
			$search_find =  $this->request->post['search_vfood_stamp'];
			$page = 1;
		}else if (isset($this->request->post['search_item']) && isset($this->request->post['search_radio']) && $this->request->post['search_radio'] == 'search'){
			$search_find =  $this->request->post['search_item'];
			$page = 1;
		}else if(isset($this->request->get['search_find'])){
			$search_find =  $this->request->get['search_find'];
		}else{
			$search_find = $default_cat_id;
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Items',
			'href' => $this->url->link('albertatest/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('albertatest/items/edit_items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('albertatest/items/edit_items/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('albertatest/items/edit_items/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('albertatest/items/edit_items/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('albertatest/items/edit_items/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['searchitem'] = $this->url->link('albertatest/items/edit_items/search', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('albertatest/items/edit_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_remove_ids_url'] = $this->url->link('albertatest/items/edit_items/add_remove_ids', 'token=' . $this->session->data['token'] . $url, true);
		$data['unset_session_value'] = $this->url->link('albertatest/items/edit_items/unset_session_value', 'token=' . $this->session->data['token'] . $url, true);
		$data['get_session_value'] = $this->url->link('albertatest/items/edit_items/get_session_value', 'token=' . $this->session->data['token'] . $url, true);
		$data['set_unset_session_value'] = $this->url->link('albertatest/items/edit_items/set_unset_session_value', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['items'] = array();

		$filter_data = array(
			'search_radio'  => $search_radio,
			'search_find'  => $search_find,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$data['search_radio'] = $search_radio;
		$data['search_find'] = $search_find;

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('albertatest/items/edit_items');

		$item_data_total = $this->model_albertatest_items_edit_items->getTotalItems($filter_data);
		$item_total = $item_data_total['total'];
		$data['items_id_array'] = $item_data_total['iitemid'];
		
		$item_data = $this->model_albertatest_items_edit_items->getItems($filter_data);
		
		$results = $item_data['items'];

		$items_total_ids = array();

		if(count($item_data['items_total_ids']) > 0){
			foreach ($item_data['items_total_ids'] as $key => $v) {
				$items_total_ids[] = $v['iitemid'];
			}
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			unset($this->session->data['items_total_ids']);
			unset($this->session->data['session_items_total_ids']);
		}

		if(!isset($this->session->data['items_total_ids'])){
			$this->session->data['items_total_ids'] = $items_total_ids;
			$this->session->data['session_items_total_ids'] = $items_total_ids;
			$data['items_total_ids'] = $items_total_ids;
		}else{
			$data['items_total_ids'] = $this->session->data['items_total_ids'];
		}

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

		$departments = $this->model_administration_items->getDepartments();
		
		$data['departments'] = $departments;
		
		$data['categories'] = $categories;

		$suppliers = $this->model_administration_items->getSuppliers();
		
		$data['suppliers'] = $suppliers;

		$itemGroups = $this->model_administration_items->getItemGroups();

		$ageVerifications = $this->model_administration_items->getAgeVerifications();
		
		$data['ageVerifications'] = $ageVerifications;
		
		$data['itemGroups'] = $itemGroups;

		$itemsUnits = $this->model_albertatest_items_edit_items->getItemsUnits();

		$data['itemsUnits'] = $itemsUnits;

		$buckets = $this->model_albertatest_items_edit_items->getBuckets();

		$data['buckets'] = $buckets;

		$data['array_yes_no']['Y'] = 'Yes'; 
		$data['array_yes_no']['N'] = 'No';

		$data['arr_y_n'][] = 'No';
		$data['arr_y_n'][] = 'Yes';  

		$data['array_updates']['No'] = '-- No Update --'; 
		$data['array_updates']['Yes'] = 'Update';

		$data['array_status']['no-update'] = '-- No Update --'; 
		$data['array_status']['Active'] = 'Active'; 
		$data['array_status']['Inactive'] = 'Inactive'; 

		$data['item_types'][] = 'Standard';
		$data['item_types'][] = 'Kiosk';
		$data['item_types'][] = 'Lot Matrix';
		$data['item_types'][] = 'Gasoline';
		$data['item_types'][] = 'Lottery';

		$data['barcode_types'][] = 'Code 128';
		$data['barcode_types'][] = 'Code 39';
		$data['barcode_types'][] = 'Code 93';
		$data['barcode_types'][] = 'UPC E';
		$data['barcode_types'][] = 'EAN 8';
		$data['barcode_types'][] = 'EAN 13';
		$data['barcode_types'][] = 'UPC A'; 

		if(!empty($search_radio) && !empty($search_find)){
			$url .= '&search_radio='.$search_radio.'&search_find='.$search_find;
		}

		$pagination = new Pagination();
		$pagination->total = $item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('albertatest/items/edit_items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($item_total - $this->config->get('config_limit_admin'))) ? $item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $item_total, ceil($item_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('albertatest/items/edit_item_list', $data));
	}

	public function add_remove_ids() {

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $posted_arr = json_decode(file_get_contents('php://input'), true);
            
            if(isset($this->session->data['items_total_ids'])){
                $session_data = $this->session->data['items_total_ids'];
    
                if(isset($posted_arr['add']) && count($posted_arr['add']) > 0){
                    foreach ($posted_arr['add'] as $key => $value) {
                        if(!in_array($value, $session_data)){
                            $session_data[] = $value;
                        }
                    }
                }

                if(isset($posted_arr['remove']) && count($posted_arr['remove']) > 0){
                    foreach ($posted_arr['remove'] as $key => $value) {
                        if (($key = array_search($value, $session_data)) !== false) {
                            unset($session_data[$key]);
                        }
                    }
                }

                $this->session->data['items_total_ids'] = $session_data;
            }
        }
    }

    public function unset_session_value() {
    	unset($this->session->data['items_total_ids']);
    	unset($this->session->data['session_items_total_ids']);
    }

    public function get_session_value() {
    	$json['total_items'] = count($this->session->data['items_total_ids']);
    	$this->response->addHeader('Content-Type: application/json');
		echo json_encode($json);
		exit;
    }

    public function set_unset_session_value() {
    	if(isset($this->request->get['checkbox_value']) && !empty($this->request->get['checkbox_value'])){

    		if($this->request->get['checkbox_value'] == 'unset'){
    			$this->session->data['items_total_ids'] = array();
    		}else{
    			$this->session->data['items_total_ids'] = $this->session->data['session_items_total_ids'];
    		}

    	}
    }


	
}
