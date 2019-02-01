<?php
class ControllerAdministrationItemsSale extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/sale');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_api_items_sale->addSaleItems($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/sale');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_api_items_sale->editlistSaleItems($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$url = '';

			$this->response->redirect($this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'isalepriceid';
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
			'text' => 'Items',
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/items/sale/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/items/sale/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/items/sale/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/items/sale/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['import_sale'] = $this->url->link('administration/items/sale/import_sale', 'token=' . $this->session->data['token'].'&sid='.$this->session->data['sid'], true);
		
		$data['sales'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/items/sale');

		$sale_data = $this->model_api_items_sale->getSales();

		$sale_total = count($sale_data);

		$results = $sale_data;

		foreach ($results as $result) {
			
			$data['sales'][] = array(
				'isalepriceid'    => $result['isalepriceid'],
				'vsalename'       => $result['vsalename'],
				'vsaletype'       => $result['vsaletype'],
				'dstartdatetime'  => $result['dstartdatetime'],
				'denddatetime'    => $result['denddatetime'],
				'estatus'  	      => $result['estatus'],
				'nbuyqty'  	      => $result['nbuyqty'],
				'edit'            => $this->url->link('administration/items/sale/edit', 'token=' . $this->session->data['token'] . '&isalepriceid=' . $result['isalepriceid'] . $url, true)
				
			);
		}
		
		if(count($sale_data)==0){ 
			$data['sales'] =array();
			$sale_total = 0;
			$data['sale_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_sale_name'] = $this->language->get('column_sale_name');
		$data['column_sale_type'] = $this->language->get('column_sale_type');
		$data['column_buy_qty'] = $this->language->get('column_buy_qty');
		$data['column_start_date'] = $this->language->get('column_start_date');
		$data['column_end_date'] = $this->language->get('column_end_date');
		$data['column_status'] = $this->language->get('column_status');

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
		$pagination->total = $sale_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sale_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sale_total - $this->config->get('config_limit_admin'))) ? $sale_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sale_total, ceil($sale_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/items/sale_list', $data));
	}


	protected function getForm() {
	    $query = "\r\n"."214: GET FORM.";
	    
	    $file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");
        
        
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['isalepriceid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_sale_name'] = $this->language->get('text_sale_name');
		$data['text_sale_type'] = $this->language->get('text_sale_type');
		$data['text_buy_qty'] = $this->language->get('text_buy_qty');
		$data['text_start_date'] = $this->language->get('text_start_date');
		$data['text_end_date'] = $this->language->get('text_end_date');
		$data['text_status'] = $this->language->get('text_status');

		$data['status_array'][] = $this->language->get('Active');
		$data['status_array'][] = $this->language->get('Inactive');

		$data['sale_types'] = array('On Going', 'Time Duration', 'Buy Get Free');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['vsalename'])) {
			$data['error_vsalename'] = $this->error['vsalename'];
		} else {
			$data['error_vsalename'] = '';
		}

		if (isset($this->error['vsaletype'])) {
			$data['error_vsaletype'] = $this->error['vsaletype'];
		} else {
			$data['error_vsaletype'] = '';
		}

		$url = '';

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
			'href' => $this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['isalepriceid'])) {
			$data['action'] = $this->url->link('administration/items/sale/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/items/sale/edit', 'token=' . $this->session->data['token'] . '&isalepriceid=' . $this->request->get['isalepriceid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/items/sale', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('administration/items/sale/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/items/sale/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		$data['display_items'] = $this->url->link('administration/items/sale/display_items', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['isalepriceid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$sale_info = $this->model_api_items_sale->getSale($this->request->get['isalepriceid']);
			$data['isalepriceid'] = $this->request->get['isalepriceid'];
		}

		$data['token'] = $this->session->data['token'];	

		if (isset($this->request->post['vsalename'])) {
			$data['vsalename'] = $this->request->post['vsalename'];
		} elseif (!empty($sale_info)) {
			$data['vsalename'] = $sale_info['vsalename'];
		} else {
			$data['vsalename'] = '';
		}

		if (isset($this->request->post['vsaletype'])) {
			$data['vsaletype'] = $this->request->post['vsaletype'];
		} elseif (!empty($sale_info)) {
			$data['vsaletype'] = $sale_info['vsaletype'];
		} else {
			$data['vsaletype'] = '';
		}

		if (isset($this->request->post['vsaleby'])) {
			$data['vsaleby'] = $this->request->post['vsaleby'];
		} elseif (!empty($sale_info)) {
			$data['vsaleby'] = $sale_info['vsaleby'];
		} else {
			$data['vsaleby'] = '';
		}

		if (isset($this->request->post['ndiscountper'])) {
			$data['ndiscountper'] = $this->request->post['ndiscountper'];
		} elseif (!empty($sale_info)) {
			$data['ndiscountper'] = $sale_info['ndiscountper'];
		}

		if (isset($this->request->post['dstartdatetime'])) {
			$data['dstartdatetime'] = $this->request->post['dstartdatetime'];
		} elseif (!empty($sale_info)) {
			$data['dstartdatetime'] = $sale_info['dstartdatetime'];
		} else {
			$data['dstartdatetime'] = '';
		}

		if (isset($this->request->post['denddatetime'])) {
			$data['denddatetime'] = $this->request->post['denddatetime'];
		} elseif (!empty($sale_info)) {
			$data['denddatetime'] = $sale_info['denddatetime'];
		} else {
			$data['denddatetime'] = '';
		}

		if (isset($this->request->post['nbuyqty'])) {
			$data['nbuyqty'] = $this->request->post['nbuyqty'];
		} elseif (!empty($sale_info)) {
			$data['nbuyqty'] = $sale_info['nbuyqty'];
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($sale_info)) {
			$data['estatus'] = $sale_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		$data['hours'] = array(
							'00' => '00 am',
							'01' => '01 am',
							'02' => '02 am',
							'03' => '03 am',
							'04' => '04 am',
							'05' => '05 am',
							'06' => '06 am',
							'07' => '07 am',
							'08' => '08 am',
							'09' => '09 am',
							'10' => '10 am',
							'11' => '11 am',
							'12' => '12 pm',
							'13' => '01 pm',
							'14' => '02 pm',
							'15' => '03 pm',
							'16' => '04 pm',
							'17' => '05 pm',
							'18' => '06 pm',
							'19' => '07 pm',
							'20' => '08 pm',
							'21' => '09 pm',
							'22' => '10 pm',
							'23' => '11 pm'
						);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$query .= "\r\n".json_encode($data['dstartdatetime']);
		
		$data_row = PHP_EOL.json_encode($query);
        
        //fwrite($myfile,$data_row);
        fclose($myfile);
		
		

		$this->response->setOutput($this->load->view('administration/items/sale_form', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/items/sale')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	public function add_items() {

		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/sale');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_api_items_sale->getRightItems($this->request->post['checkbox_itemsort2']);

			$left_items_arr = $this->model_api_items_sale->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/sale');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		$left_items_arr = $this->model_api_items_sale->getLeftItems($data);
		
		$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function display_items() {

		ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 300);

		$this->load->language('administration/items/sale');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items');
		$this->load->model('api/items/sale');

		$json = array();

		if (isset($this->request->get['isalepriceid'])) {
			$sale_info = $this->model_api_items_sale->getSale($this->request->get['isalepriceid']);
			if(isset($sale_info)){
			
				$itms = array();

				if(isset($sale_info['items']) && count($sale_info['items']) > 0){

					$itms = $this->model_api_items_sale->getPrevRightItemIds($sale_info['items']);
				}
				
				$edit_left_items = $this->model_api_items_sale->getEditLeftItems($itms);

				$edit_right_items =array();
				if(count($itms) > 0){
					$edit_right_items = $this->model_api_items_sale->getEditRightItems($itms,$this->request->get['isalepriceid']);
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

	public function import_sale() {
		$this->load->model('api/items/sale');

		$data = array();
		$data_pitem = array();
		$json_return = array();
		$missing_items = array();
		$missing_pitem_items = array();
		$missing_pitem_items = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if(isset($this->request->files['import_sale_file']) && $this->request->files['import_sale_file']['name'] != ''){

				$import_sale_file = $this->request->files['import_sale_file']['tmp_name'];

				$get_xml = file_get_contents($import_sale_file);
				$arr_xml = simplexml_load_string($get_xml);

				$json_xml = json_encode($arr_xml);
				$array_xml = json_decode($json_xml, true);

				//SItems
				if(isset($array_xml['Sales']['@attributes'])){
					$data[0]['vsalename'] = $array_xml['Sales']['@attributes']['PromoName'];
					$data[0]['dstartdatetime'] = DateTime::createFromFormat('Y-m-d', $array_xml['Sales']['@attributes']['StartDate'])->format('m-d-Y'). ' 00:00:00';
					// $data[0]['dstartdatetime'] = $array_xml['Sales']['@attributes']['StartDate']. ' 00:00:00';
					$data[0]['denddatetime'] = DateTime::createFromFormat('Y-m-d', $array_xml['Sales']['@attributes']['EndDate'])->format('m-d-Y'). ' 00:00:00';
					// $data[0]['denddatetime'] = $array_xml['Sales']['@attributes']['EndDate']. ' 00:00:00';
					$data[0]['vsaletype'] = 'Time Duration';
					$data[0]['vsaleby'] = 'Price';
					$data[0]['estatus'] = 'Active';

					if(isset($array_xml['Sales']['SItem']) && count($array_xml['Sales']['SItem']) > 0){
						foreach ($array_xml['Sales']['SItem'] as $key => $value) {
							$value = $value['@attributes'];

							if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
								$value['NEW_UPC'] = $this->generate_upc_checkdigit($value['UPC']);
							}else{
								$value['NEW_UPC'] = $value['UPC'];
							}
							
							$current_item = $this->model_api_items_sale->getItem($value['NEW_UPC']);
							
							if(count($current_item) > 0){
								$data[0]['items'][$key]['vitemcode'] = $current_item['vitemcode'];
								$data[0]['items'][$key]['vitemname'] = $current_item['vitemname'];
								$data[0]['items'][$key]['vbarcode'] = $current_item['vbarcode'];
								$data[0]['items'][$key]['vunitcode'] = $current_item['vunitcode'];
								$data[0]['items'][$key]['vitemtype'] = $current_item['vitemtype'];
								$data[0]['items'][$key]['dunitprice'] = $current_item['dunitprice'];

								if(isset($value['WHCode'])){
									$data[0]['items'][$key]['WHCode'] = $value['WHCode'];
								}else{
									$data[0]['items'][$key]['WHCode'] = '000000';
								}

								if(isset($value['Dept'])){
									$data[0]['items'][$key]['Dept'] = $value['Dept'];
								}else{
									$data[0]['items'][$key]['Dept'] = '';
								}

								if(isset($value['Description'])){
									$data[0]['items'][$key]['Description'] = $value['Description'];
								}else{
									$data[0]['items'][$key]['Description'] = '';
								}
								
								if(isset($value['Size'])){
									$data[0]['items'][$key]['Size'] = $value['Size'];
								}else{
									$data[0]['items'][$key]['Size'] = '';
								}

								if(isset($value['RegQTY'])){
									$data[0]['items'][$key]['RegQTY'] = $value['RegQTY'];
								}else{
									$data[0]['items'][$key]['RegQTY'] = '0';
								}

								if(isset($value['RegPrice'])){
									$data[0]['items'][$key]['RegPrice'] = $value['RegPrice'];
								}else{
									$data[0]['items'][$key]['RegPrice'] = '0.00';
								}

								if(isset($value['SaleQTY'])){
									$data[0]['items'][$key]['SaleQTY'] = $value['SaleQTY'];
								}else{
									$data[0]['items'][$key]['SaleQTY'] = '0';
								}

								if(isset($value['SalePrice'])){
									$data[0]['items'][$key]['SalePrice'] = $value['SalePrice'];
								}else{
									$data[0]['items'][$key]['SalePrice'] = '0.00';
								}

								if(isset($value['Discount'])){
									$data[0]['items'][$key]['Discount'] = $value['Discount'];
								}else{
									$data[0]['items'][$key]['Discount'] = '0.00';
								}

								if(isset($value['PromoID'])){
									$data[0]['items'][$key]['PromoID'] = $value['PromoID'];
								}else{
									$data[0]['items'][$key]['PromoID'] = '';
								}

								if(isset($value['PriceMethod'])){
									$data[0]['items'][$key]['PriceMethod'] = $value['PriceMethod'];
								}else{
									$data[0]['items'][$key]['PriceMethod'] = '';
								}
								
							}else{
								$missing_items[] = $value['UPC'];
							}
						}
					}

				}else{
					if(isset($array_xml['Sales']) && count($array_xml['Sales']) > 0){
						foreach ($array_xml['Sales'] as $k => $v) {
							$data[$k]['vsalename'] = $v['@attributes']['PromoName'];
							$data[0]['dstartdatetime'] = DateTime::createFromFormat('Y-m-d', $v['@attributes']['StartDate'])->format('m-d-Y'). ' 00:00:00';
							// $data[$k]['dstartdatetime'] = $v['@attributes']['StartDate']. ' 00:00:00';
							$data[$k]['denddatetime'] = DateTime::createFromFormat('Y-m-d', $v['@attributes']['EndDate'])->format('m-d-Y'). ' 00:00:00';
							// $data[$k]['denddatetime'] = $v['@attributes']['EndDate']. ' 00:00:00';
							$data[$k]['vsaletype'] = 'Time Duration';
							$data[$k]['vsaleby'] = 'Price';
							$data[$k]['estatus'] = 'Active';

							if(isset($v['SItem']) && count($v['SItem']) > 0){
								foreach ($v['SItem'] as $key => $value) {
									$value = $value['@attributes'];
									if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
										$value['NEW_UPC'] = $this->generate_upc_checkdigit($value['UPC']);
									}else{
										$value['NEW_UPC'] = $value['UPC'];
									}
									
									$current_item = $this->model_api_items_sale->getItem($value['NEW_UPC']);
									
									if(count($current_item) > 0){
								
										$data[$k]['items'][$key]['vitemcode'] = $current_item['vitemcode'];
										$data[$k]['items'][$key]['vitemname'] = $current_item['vitemname'];
										$data[$k]['items'][$key]['vbarcode'] = $current_item['vbarcode'];
										$data[$k]['items'][$key]['vunitcode'] = $current_item['vunitcode'];
										$data[$k]['items'][$key]['vitemtype'] = $current_item['vitemtype'];
										$data[$k]['items'][$key]['dunitprice'] = $current_item['dunitprice'];

										if(isset($value['WHCode'])){
											$data[$k]['items'][$key]['WHCode'] = $value['WHCode'];
										}else{
											$data[$k]['items'][$key]['WHCode'] = '000000';
										}

										if(isset($value['Dept'])){
											$data[$k]['items'][$key]['Dept'] = $value['Dept'];
										}else{
											$data[$k]['items'][$key]['Dept'] = '';
										}

										if(isset($value['Description'])){
											$data[$k]['items'][$key]['Description'] = $value['Description'];
										}else{
											$data[$k]['items'][$key]['Description'] = '';
										}

										if(isset($value['Size'])){
											$data[$k]['items'][$key]['Size'] = $value['Size'];
										}else{
											$data[$k]['items'][$key]['Size'] = '';
										}

										if(isset($value['RegQTY'])){
											$data[$k]['items'][$key]['RegQTY'] = $value['RegQTY'];
										}else{
											$data[$k]['items'][$key]['RegQTY'] = '0';
										}

										if(isset($value['RegPrice'])){
											$data[$k]['items'][$key]['RegPrice'] = $value['RegPrice'];
										}else{
											$data[$k]['items'][$key]['RegPrice'] = '0.00';
										}

										if(isset($value['SaleQTY'])){
											$data[$k]['items'][$key]['SaleQTY'] = $value['SaleQTY'];
										}else{
											$data[$k]['items'][$key]['SaleQTY'] = '0';
										}

										if(isset($value['SalePrice'])){
											$data[$k]['items'][$key]['SalePrice'] = $value['SalePrice'];
										}else{
											$data[$k]['items'][$key]['SalePrice'] = '0.00';
										}

										if(isset($value['Discount'])){
											$data[$k]['items'][$key]['Discount'] = $value['Discount'];
										}else{
											$data[$k]['items'][$key]['Discount'] = '0.00';
										}

										if(isset($value['PromoID'])){
											$data[$k]['items'][$key]['PromoID'] = $value['PromoID'];
										}else{
											$data[$k]['items'][$key]['PromoID'] = '';
										}

										if(isset($value['PriceMethod'])){
											$data[$k]['items'][$key]['PriceMethod'] = $value['PriceMethod'];
										}else{
											$data[$k]['items'][$key]['PriceMethod'] = '';
										}
										
									}else{
										$missing_items[] = $value['UPC'];
									}
								}
							}
						}
					}
				}
				//SItems

				//PItems
				if(isset($array_xml['SRP']['@attributes'])){
					$data_pitem[0]['StartDate'] = DateTime::createFromFormat('Y-m-d', $array_xml['Sales']['@attributes']['StartDate'])->format('m-d-Y'). ' 00:00:00';
					$data_pitem[0]['vsaletype'] = 'Time Duration';
					$data_pitem[0]['vsaleby'] = 'Price';
					$data_pitem[0]['estatus'] = 'Active';

					if(isset($array_xml['SRP']['PItem']) && count($array_xml['SRP']['PItem']) > 0){
						foreach ($array_xml['SRP']['PItem'] as $key => $value) {
							$value = $value['@attributes'];

							if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
								$value['NEW_UPC'] = $this->generate_upc_checkdigit($value['UPC']);
							}else{
								$value['NEW_UPC'] = $value['UPC'];
							}

							if(isset($value['WHCode'])){
								$data_pitem[0]['items'][$key]['WHCode'] = $value['WHCode'];
							}else{
								$data_pitem[0]['items'][$key]['WHCode'] = '000000';
							}

							if(isset($value['Dept'])){
								$data_pitem[0]['items'][$key]['Dept'] = $value['Dept'];
							}else{
								$data_pitem[0]['items'][$key]['Dept'] = '';
							}

							if(isset($value['Description'])){
								$data_pitem[0]['items'][$key]['Description'] = $value['Description'];
							}else{
								$data_pitem[0]['items'][$key]['Description'] = '';
							}
							
							if(isset($value['Size'])){
								$data_pitem[0]['items'][$key]['Size'] = $value['Size'];
							}else{
								$data_pitem[0]['items'][$key]['Size'] = '';
							}

							if(isset($value['RegQTY'])){
								$data_pitem[0]['items'][$key]['RegQTY'] = $value['RegQTY'];
							}else{
								$data_pitem[0]['items'][$key]['RegQTY'] = '0';
							}

							if(isset($value['RegPrice'])){
								$data_pitem[0]['items'][$key]['RegPrice'] = $value['RegPrice'];
							}else{
								$data_pitem[0]['items'][$key]['RegPrice'] = '0.00';
							}
						}
					}

				}else{
					if(isset($array_xml['SRP']) && count($array_xml['SRP']) > 0){
						foreach ($array_xml['SRP'] as $k => $v) {
							$data_pitem[0]['StartDate'] = DateTime::createFromFormat('Y-m-d', $v['@attributes']['StartDate'])->format('m-d-Y'). ' 00:00:00';
							$data_pitem[$k]['vsaletype'] = 'Time Duration';
							$data_pitem[$k]['vsaleby'] = 'Price';
							$data_pitem[$k]['estatus'] = 'Active';

							if(isset($v['PItem']) && count($v['PItem']) > 0){
								foreach ($v['PItem'] as $key => $value) {
									$value = $value['@attributes'];
									if(isset($this->request->post['check_digit']) && $this->request->post['check_digit'] == 'Y'){
										$value['NEW_UPC'] = $this->generate_upc_checkdigit($value['UPC']);
									}else{
										$value['NEW_UPC'] = $value['UPC'];
									}

									if(isset($value['WHCode'])){
										$data_pitem[$k]['items'][$key]['WHCode'] = $value['WHCode'];
									}else{
										$data_pitem[$k]['items'][$key]['WHCode'] = '000000';
									}

									if(isset($value['Dept'])){
										$data_pitem[$k]['items'][$key]['Dept'] = $value['Dept'];
									}else{
										$data_pitem[$k]['items'][$key]['Dept'] = '';
									}

									if(isset($value['Description'])){
										$data_pitem[$k]['items'][$key]['Description'] = $value['Description'];
									}else{
										$data_pitem[$k]['items'][$key]['Description'] = '';
									}

									if(isset($value['Size'])){
										$data_pitem[$k]['items'][$key]['Size'] = $value['Size'];
									}else{
										$data_pitem[$k]['items'][$key]['Size'] = '';
									}

									if(isset($value['RegQTY'])){
										$data_pitem[$k]['items'][$key]['RegQTY'] = $value['RegQTY'];
									}else{
										$data_pitem[$k]['items'][$key]['RegQTY'] = '0';
									}

									if(isset($value['RegPrice'])){
										$data_pitem[$k]['items'][$key]['RegPrice'] = $value['RegPrice'];
									}else{
										$data_pitem[$k]['items'][$key]['RegPrice'] = '0.00';
									}
								}
							}
						}
					}
				}
				//PItems
				echo "<pre>";
				print_r($data_pitem);
				exit;
	
			}else{
				$json_return['code'] = 0;
				$json_return['error'] = 'Please select File';
				echo json_encode($json_return);
				exit;
				}
		}else{
			$json_return['code'] = 0;
			$json_return['error'] = 'Something went wrong!';
			echo json_encode($json_return);
			exit;
		}
	}

	public function generate_upc_checkdigit($upc_code){
	    $odd_total  = 0;
	    $even_total = 0;
	 
	    for($i=0; $i<11; $i++)
	    {
	        if((($i+1)%2) == 0) {
	            /* Sum even digits */
	            $even_total += $upc_code[$i];
	        } else {
	            /* Sum odd digits */
	            $odd_total += $upc_code[$i];
	        }
	    }
	 
	    $sum = (3 * $odd_total) + $even_total;
	 
	    /* Get the remainder MOD 10*/
	    $check_digit = $sum % 10;
	 
	    /* If the result is not zero, subtract the result from ten. */
	    return ($check_digit > 0) ? 10 - $check_digit : $check_digit;
	}
	
}
