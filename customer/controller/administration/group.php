<?php
class ControllerAdministrationGroup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group');
		$this->load->model('administration/group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$iitemgroupid = $this->model_administration_group->addGroup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group');
		$this->load->model('administration/group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_administration_group->editlistGroup($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$url = '';

			$iitemgroupid = $this->request->get['iitemgroupid'];

			$this->response->redirect($this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . $url.'&iitemgroupid='.$iitemgroupid, true));
		}

		$this->getForm();
	}
	
	/*added new functon to delete groups*/
	public function deleteGroup() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/group');
		$this->load->model('administration/group');

		if (($this->request->server['REQUEST_METHOD'] == 'GET')) {

			$this->model_administration_group->deleteGroups($this->request->get);

			

			$url = '';

			$iitemgroupid = $this->request->get['iitemgroupid'];

			
		}
		$this->index();

	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'iitemgroupid';
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
			'text' => 'Items',
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/group/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/group/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/group/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/group', 'token=' . $this->session->data['token'], true);
		$data['searchgroup'] = $this->url->link('administration/group/search', 'token=' . $this->session->data['token'], true);
		
		$data['groups'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/group');

		$group_data = $this->model_api_group->getGroups($filter_data);
		
		$group_total = $this->model_api_group->getGroupsTotal($filter_data);

		$results = $group_data;

		if(count($results) > 0){

			foreach ($results as $result) {

				if(count($result['group_slab_pricings']) > 0){
					$slab_pricing = 'Yes';
				}else{
					$slab_pricing = 'No';
				}
				
				$data['groups'][] = array(
					'iitemgroupid'     => $result['iitemgroupid'],
					'vitemgroupname'   => $result['vitemgroupname'],
					'slab_pricing'     => $slab_pricing,
					'etransferstatus'  => $result['etransferstatus'],
					'edit'            => $this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . '&iitemgroupid=' . $result['iitemgroupid'] . $url, true),
					'delete'            => $this->url->link('administration/group/deleteGroup', 'token=' . $this->session->data['token'] . '&iitemgroupid=' . $result['iitemgroupid'] . $url, true)
					
				);
			}
		}
		
		if(count($group_data)==0){ 
			$data['groups'] =array();
			$group_total = 0;
			$data['group_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_group_name'] = $this->language->get('text_group_name');
		$data['text_item_type'] = $this->language->get('text_item_type');

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
		$pagination->total = $group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($group_total - $this->config->get('config_limit_admin'))) ? $group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $group_total, ceil($group_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/group_list', $data));
	}


	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['iitemgroupid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['text_group_name'] = $this->language->get('text_group_name');
		$data['text_item_type'] = $this->language->get('text_item_type');

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

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['vitemgroupname'])) {
			$data['error_vitemgroupname'] = $this->error['vitemgroupname'];
		} else {
			$data['error_vitemgroupname'] = '';
		}

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Items',
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['iitemgroupid'])) {
			$data['action'] = $this->url->link('administration/group/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/group/edit', 'token=' . $this->session->data['token'] . '&iitemgroupid=' . $this->request->get['iitemgroupid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/group', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_items'] = $this->url->link('administration/group/add_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['remove_items'] = $this->url->link('administration/group/remove_items', 'token=' . $this->session->data['token'] . $url, true);

		$data['display_items'] = $this->url->link('administration/group/display_items', 'token=' . $this->session->data['token'], true);
		$data['display_items_search'] = $this->url->link('administration/group/display_items_search', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['iitemgroupid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$group_info = $this->model_api_group->getGroup($this->request->get['iitemgroupid']);
			$data['iitemgroupid'] = $this->request->get['iitemgroupid'];

			$data['group_slab_pricing'] = $this->url->link('administration/group_slab_pricing', 'token=' . $this->session->data['token'].'&iitemgroupid='.$this->request->get['iitemgroupid'], true);
		}else{
			$data['group_slab_pricing'] = '';
		}

		$data['token'] = $this->session->data['token'];	

		if (isset($this->request->post['vitemgroupname'])) {
			$data['vitemgroupname'] = $this->request->post['vitemgroupname'];
		} elseif (!empty($group_info)) {
			$data['vitemgroupname'] = $group_info['vitemgroupname'];
		} else {
			$data['vitemgroupname'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/group_form', $data));
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
			$right_items_arr = $this->model_administration_group->getRightItems($this->request->post['checkbox_itemsort1']);

			// $left_items_arr = $this->model_administration_group->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			// $json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/group');

		$json = array();
		
		if(isset($this->request->post['remove_items_2'])){
			$data_remove = $this->request->post['remove_items_2'];
		}else{
			$data_remove = array();
		}

		$remove_items_arr = $this->model_administration_group->removeItemsRight($data_remove);

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

	public function display_items() {

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/group');
		$this->load->model('api/items');
		$this->load->model('api/group');

		$json = array();

		if (isset($this->request->get['iitemgroupid'])) {
			$group_info = $this->model_api_group->getGroup($this->request->get['iitemgroupid']);
			if(isset($group_info)){
			
				$itms = array();

				if(isset($group_info['items']) && count($group_info['items']) > 0){

					$itms = $this->model_administration_group->getPrevRightItemIds($group_info['items']);
				}
				
				// $edit_left_items = $this->model_administration_group->getEditLeftItems($itms);
				
				$edit_right_items =array();
				if(count($itms) > 0){
					$edit_right_items = $this->model_administration_group->getEditRightItems($itms,$this->request->get['iitemgroupid'],$group_info['items'][0]['vtype']);
				}

				// $json['items'] = $edit_left_items;
				$json['edit_right_items'] = $edit_right_items;
				$json['previous_items'] = $itms;

			}else{
				// $json['items'] = $this->model_administration_group->getlistItems();
			}
			
		}else{
			// $json['items'] = $this->model_administration_group->getlistItems();
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function search(){
		$return = array();
		$this->load->model('api/group');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_group->getGroupSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['iitemgroupid'] = $value['iitemgroupid'];
				$temp['vitemgroupname'] = $value['vitemgroupname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}

	public function display_items_search() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->language('administration/group');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/group');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$post_arr = json_decode(file_get_contents('php://input'), true);

			if(isset($post_arr['search_val']) && isset($post_arr['search_by']) && isset($post_arr['right_items'])){
				
					$json['items'] = $this->model_administration_group->getSearchItems($post_arr);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
