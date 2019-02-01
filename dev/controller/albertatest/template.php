<?php
class ControllerAdministrationTemplate extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/template');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$datas[] = $this->request->post;

			$this->model_api_template->addTemplate($datas);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/template');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$datas[] = $this->request->post;

			$this->model_api_template->editlistTemplate($datas);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			$this->response->redirect($this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'itemplateid';
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
			'href' => $this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/template/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/template/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/template/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/template/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/template', 'token=' . $this->session->data['token'], true);
		$data['searchtemplate'] = $this->url->link('administration/template/search', 'token=' . $this->session->data['token'], true);
		
		$data['templates'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/template');

		$template_data = $this->model_api_template->getTemplates($filter_data);
		$template_total = $this->model_api_template->getTemplatesTotal($filter_data);

		$results = $template_data;

		foreach ($results as $result) {
			
			$data['templates'][] = array(
				'itemplateid'     => $result['itemplateid'],
				'vtemplatename'   => $result['vtemplatename'],
				'vtemplatetype'   => $result['vtemplatetype'],
				'vinventorytype'  => $result['vinventorytype'],
				'istoreid'        => $result['istoreid'],
				'isequence'  	  => $result['isequence'],
				'estatus'  	      => $result['estatus'],
				'edit'            => $this->url->link('administration/template/edit', 'token=' . $this->session->data['token'] . '&itemplateid=' . $result['itemplateid'] . $url, true)
				
			);
		}
		
		if(count($template_data)==0){ 
			$data['templates'] =array();
			$template_total = 0;
			$data['template_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['text_template_type'] = $this->language->get('text_template_type');
		$data['text_inventory_type'] = $this->language->get('text_inventory_type');
		$data['text_template_name'] = $this->language->get('text_template_name');
		$data['text_template_sequence'] = $this->language->get('text_template_sequence');
		$data['text_template_status'] = $this->language->get('text_template_status');

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
		$pagination->total = $template_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/template', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($template_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($template_total - $this->config->get('config_limit_admin'))) ? $template_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $template_total, ceil($template_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/template_list', $data));
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

		$data['display_items'] = $this->url->link('administration/template/display_items', 'token=' . $this->session->data['token'], true);

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

		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/template');

		$json = array();

		if(count($this->request->post['checkbox_itemsort1']) > 0){
			$right_items_arr = $this->model_administration_template->getRightItems($this->request->post['checkbox_itemsort2']);

			$left_items_arr = $this->model_administration_template->getLeftItems($this->request->post['checkbox_itemsort1']);

			$json['right_items_arr'] = $right_items_arr;
			$json['left_items_arr'] = $left_items_arr;
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_items() {

		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/template');

		$json = array();

		if(isset($this->request->post['checkbox_itemsort1'])){
			$data = $this->request->post['checkbox_itemsort1'];
		}else{
			$data = array();
		}

		$left_items_arr = $this->model_administration_template->getLeftItems($data);
		
		$json['left_items_arr'] = $left_items_arr;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function display_items() {

		ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 0);

		$this->load->language('administration/template');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/template');
		$this->load->model('api/items');
		$this->load->model('api/template');

		$json = array();

		if (isset($this->request->get['itemplateid'])) {
			$template_info = $this->model_api_template->getTemplate($this->request->get['itemplateid']);
			if(isset($template_info)){
			
				$itms = array();

				if(isset($template_info['items']) && count($template_info['items']) > 0){

					$itms = $this->model_administration_template->getPrevRightItemIds($template_info['items']);
				}
				
				$edit_left_items = $this->model_administration_template->getEditLeftItems($itms);

				$edit_right_items =array();
				if(count($itms) > 0){
					$edit_right_items = $this->model_administration_template->getEditRightItems($itms,$this->request->get['itemplateid']);
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

	public function search(){
		$return = array();
		$this->load->model('api/template');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_template->getTemplateSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['itemplateid'] = $value['itemplateid'];
				$temp['vtemplatename'] = $value['vtemplatename'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
