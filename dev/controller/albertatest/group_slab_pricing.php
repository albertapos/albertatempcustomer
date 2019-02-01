<?php
class ControllerAdministrationGroupSlabPricing extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/group_slab_pricing');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/group_slab_pricing');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group_slab_pricing');
		$this->load->model('administration/group_slab_pricing');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$datas = array();
			$datas[0]['iitemgroupid'] = $this->request->post['iitemgroupid'];
			$datas[0]['slicetype'] = $this->request->post['slicetype'];
			$datas[0]['iqty'] = $this->request->post['iqty'];
			$datas[0]['nprice'] = $this->request->post['nprice'];
			$datas[0]['percentage'] = $this->request->post['percentage'];
			$datas[0]['nunitprice'] = $this->request->post['nunitprice'];
			$datas[0]['status'] = $this->request->post['status'];

			if(isset($this->request->post['start_date']) && $this->request->post['start_date'] != ''){
				$datas[0]['startdate'] = $this->request->post['start_date'].' '.$this->request->post['start_time'].':00:00';
			}else{
				$datas[0]['startdate'] = '00-00-0000 00:00:00';
			}

			if(isset($this->request->post['end_date']) && $this->request->post['end_date'] != ''){
				$datas[0]['enddate'] = $this->request->post['end_date'].' '.$this->request->post['end_time'].':00:00';
			}else{
				$datas[0]['enddate'] = '00-00-0000 00:00:00';
			}

			$this->model_api_group_slab_pricing->addGroupSlabPricing($datas);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
				$iitemgroupid = $this->request->get['iitemgroupid'];
			}else{
				$iitemgroupid = '';
			}

			$this->response->redirect($this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/group_slab_pricing');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group_slab_pricing');
		$this->load->model('administration/group_slab_pricing');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$new_arr = array();

			foreach ($this->request->post['group_slab_pricing'] as $k => $v) {
				$temp = array();
				$temp['igroupslabid'] = $v['igroupslabid'];
				$temp['iitemgroupid'] = $v['iitemgroupid'];
				$temp['iqty'] = $v['iqty'];
				$temp['nprice'] = $v['nprice'];
				$temp['nunitprice'] = $v['nunitprice'];
				$temp['percentage'] = $v['percentage'];
				$temp['slicetype'] = $v['slicetype'];
				$temp['status'] = $v['status'];
				
				if(isset($v['startdate']) && $v['startdate'] != ''){
					$temp['startdate'] = $v['startdate'].' '.$v['start_time'].':00:00';
				}else{
					$temp['startdate'] = '00-00-0000 00:00:00';
				}

				if(isset($v['enddate']) && $v['enddate'] != ''){
					$temp['enddate'] = $v['enddate'].' '.$v['end_time'].':00:00';
				}else{
					$temp['enddate'] = '00-00-0000 00:00:00';
				}
				$new_arr[] = $temp;
			}

			$this->model_api_group_slab_pricing->editlistGroupSlabPricing($new_arr);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$url = '';

			if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
				$iitemgroupid = $this->request->get['iitemgroupid'];
			}else{
				$iitemgroupid = '';
			}

			$this->response->redirect($this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true));
		}

		$this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'igroupslabid';
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
			'href' => $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true)
		);

		if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
			$iitemgroupid = $this->request->get['iitemgroupid'];
		}else{
			$iitemgroupid = '';
		}

		$data['add'] = $this->url->link('administration/group_slab_pricing/add', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
		$data['edit'] = $this->url->link('administration/group_slab_pricing/edit', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
		$data['delete'] = $this->url->link('administration/group_slab_pricing/delete', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
		$data['edit_list'] = $this->url->link('administration/group_slab_pricing/edit_list', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
		$data['delete_slab_pricing_item'] = $this->url->link('administration/group_slab_pricing/delete_slab_pricing_item', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);

		if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
			$data['group'] = $this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$this->request->get['iitemgroupid'], true);
		}else{
			$data['group'] = '';
		}
		
		
		$data['group_slab_pricings'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/group');

		$data['groups'] =array();

		$group_data = $this->model_api_group->getGroups();

		$results = $group_data;

		foreach ($results as $result) {
			
			$data['groups'][] = array(
				'iitemgroupid'     => $result['iitemgroupid'],
				'vitemgroupname'   => $result['vitemgroupname'],
				// 'slicetype'   => $result['slicetype'],
				'etransferstatus'  => $result['etransferstatus'],
				
			);
		}

		$this->load->model('api/group_slab_pricing');

		$data['group_slab_pricings'] =array();

		if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
			$iitemgroupid = $this->request->get['iitemgroupid'];
		}else{
			$iitemgroupid = null;
		}

		$group_slab_pricing_data = $this->model_api_group_slab_pricing->getGroupSlabPricings($iitemgroupid);

		foreach ($group_slab_pricing_data as $r) {
			
			$data['group_slab_pricings'][] = array(
				'igroupslabid'  => $r['igroupslabid'],
				'iitemgroupid'  => $r['iitemgroupid'],
				'iqty'        	=> $r['iqty'],
				'nunitprice'    => $r['nunitprice'],
				'nprice'        => $r['nprice'],
				'status'        => $r['status'],
				'percentage'    => $r['percentage'],
				'startdate'     => $r['startdate'],
				'enddate'       => $r['enddate'],
				'edit'         	=> $this->url->link('administration/group_slab_pricing/edit', 'token=' . $this->session->data['token'] . '&igroupslabid=' . $r['igroupslabid'] . $url, true)
			);
		}
		
		$group_slab_pricing_total = count($group_slab_pricing_data);

		if(count($group_data)==0){ 
			$data['group_slab_pricings'] =array();
			$group_slab_pricing_total = 0;
			$data['group_slab_pricing_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_group_name'] = $this->language->get('text_group_name');
		$data['text_slice_type'] = $this->language->get('text_slice_type');
		$data['text_by_price'] = $this->language->get('text_by_price');
		$data['text_by_percentage'] = $this->language->get('text_by_percentage');
		$data['text_qty'] = $this->language->get('text_qty');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_percentage'] = $this->language->get('text_percentage');
		$data['text_unit_price'] = $this->language->get('text_unit_price');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_time'] = $this->language->get('text_time');
		$data['text_status'] = $this->language->get('text_status');

		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['column_group_name'] = $this->language->get('column_group_name');
		$data['column_qty'] = $this->language->get('column_qty');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_unit_price'] = $this->language->get('column_unit_price');
		$data['column_percentage'] = $this->language->get('column_percentage');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_start_date'] = $this->language->get('column_start_date');
		$data['column_end_date'] = $this->language->get('column_end_date');

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
		$pagination->total = $group_slab_pricing_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($group_slab_pricing_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($group_slab_pricing_total - $this->config->get('config_limit_admin'))) ? $group_slab_pricing_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $group_slab_pricing_total, ceil($group_slab_pricing_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/group_slab_pricing_list', $data));
	}


	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['igroupslabid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_group_name'] = $this->language->get('text_group_name');
		$data['text_slice_type'] = $this->language->get('text_slice_type');
		$data['text_by_price'] = $this->language->get('text_by_price');
		$data['text_by_percentage'] = $this->language->get('text_by_percentage');
		$data['text_qty'] = $this->language->get('text_qty');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_percentage'] = $this->language->get('text_percentage');
		$data['text_unit_price'] = $this->language->get('text_unit_price');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_time'] = $this->language->get('text_time');
		$data['text_status'] = $this->language->get('text_status');

		$data['Active'] = $this->language->get('Active');
		$data['Inactive'] = $this->language->get('Inactive');

		$data['item_types'][] = $this->language->get('Product');

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
			'href' => $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['cancel'] = $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('administration/group_slab_pricing/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/group_slab_pricing/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		if(isset($this->request->get['iitemgroupid']) && !empty($this->request->get['iitemgroupid'])){
			$iitemgroupid = $this->request->get['iitemgroupid'];

			$data['group'] = $this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
			$data['group_slab_pricing'] = $this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);

			if (!isset($this->request->get['igroupslabid'])) {
				$data['action'] = $this->url->link('administration/group_slab_pricing/add', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true);
			} else {
				$data['action'] = $this->url->link('administration/group_slab_pricing/edit', 'token=' . $this->session->data['token'] . '&igroupslabid=' . $this->request->get['igroupslabid'] . $url.'&iitemgroupid='.$iitemgroupid, true);
			}
		
		}else{
			$data['group'] = '';
			$data['group_slab_pricing'] = '';

			if (!isset($this->request->get['igroupslabid'])) {
				$data['action'] = $this->url->link('administration/group_slab_pricing/add', 'token=' . $this->session->data['token'] . $url, true);
			} else {
				$data['action'] = $this->url->link('administration/group_slab_pricing/edit', 'token=' . $this->session->data['token'] . '&igroupslabid=' . $this->request->get['igroupslabid'] . $url, true);
			}
		}

		if (isset($this->request->get['igroupslabid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$group_info = $this->model_api_group_slab_pricing->getGroupSlabPricing($this->request->get['igroupslabid']);
			$data['igroupslabid'] = $this->request->get['igroupslabid'];
		}

		$this->load->model('api/group');

		$data['groups'] =array();

		$group_data = $this->model_api_group->getGroups();
		if(count($group_data) > 0){
			$data['groups'] = $group_data;
		}

		$data['token'] = $this->session->data['token'];	

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/group_slab_pricing_form', $data));
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

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/group');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_administration_group->getRightItems($this->request->post['checkbox_itemsort2']);

			$left_items_arr = $this->model_administration_group->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/group');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		$left_items_arr = $this->model_administration_group->getLeftItems($data);
		
		$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	
	public function delete_slab_pricing_item() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group_slab_pricing');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$temp_arr = json_decode(file_get_contents('php://input'), true);
			$data = $this->model_api_group_slab_pricing->deleteGroupSlabPricingItem($temp_arr);
			
			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
	
}
