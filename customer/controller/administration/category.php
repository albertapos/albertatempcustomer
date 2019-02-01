<?php
class ControllerAdministrationCategory extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('administration/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/category');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/category');
    
		$this->load->model('administration/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$this->model_administration_category->editCategoryList($this->request->post);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/category', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	 }
	  
	protected function getList() {
		
		if (isset($this->request->get['filter_menuid'])) {
			$filter_menuid = $this->request->get['filter_menuid'];
			$data['filter_menuid'] = $this->request->get['filter_menuid'];
		}else if (isset($this->request->post['filter_menuid'])) {
			$filter_menuid = $this->request->post['filter_menuid'];
			$data['filter_menuid'] = $this->request->post['filter_menuid'];
		}else {
			$filter_menuid = null;
			$data['filter_menuid'] = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'icategoryid';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_menuid'])) {
			$url .= '&filter_menuid=' . urlencode(html_entity_decode($this->request->get['filter_menuid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

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
			'href' => $this->url->link('administration/category', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/category/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/category/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/category/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/category/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/category', 'token=' . $this->session->data['token'], true);
		$data['searchcategory'] = $this->url->link('administration/category/search', 'token=' . $this->session->data['token'], true);
		
		$data['categories'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');
		
		$category_total = $this->model_administration_category->getTotalCategories($filter_data);

		$results = $this->model_administration_category->getCategories($filter_data);

		foreach ($results as $result) {
			
			$data['categories'][] = array(
				'icategoryid'   => $result['icategoryid'],
				'vcategorycode' => $result['vcategorycode'],
				'vcategoryname' => $result['vcategoryname'],
				'vdescription' 	=> $result['vdescription'],
				'vcategorttype' => $result['vcategorttype'],
				'isequence'  	=> $result['isequence'],
				'view'        => $this->url->link('administration/category/info', 'token=' . $this->session->data['token'] . '&icategoryid=' . $result['icategoryid'] . $url, true),
				'edit'        => $this->url->link('administration/category/edit', 'token=' . $this->session->data['token'] . '&icategoryid=' . $result['icategoryid'] . $url, true),
				'delete'      => $this->url->link('administration/category/delete', 'token=' . $this->session->data['token'] . '&icategoryid=' . $result['icategoryid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['categories'] =array();
			$category_total = 0;
			$data['category_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['Sales'] = $this->language->get('Sales');
		$data['MISC'] = $this->language->get('MISC');
		
		$data['column_category_code'] = $this->language->get('column_category_code');
		$data['column_category_name'] = $this->language->get('column_category_name');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_category_type'] = $this->language->get('column_category_type');
		$data['column_sequence'] = $this->language->get('column_sequence');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_category_name'] = $this->language->get('entry_category_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_category_type'] = $this->language->get('entry_category_type');
		$data['entry_sequence'] = $this->language->get('entry_sequence');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// $data['sort_Category'] = $this->url->link('administration/category', 'token=' . $this->session->data['token'] . '&sort=Category' . $url, true);
		// $data['sort_Sequence'] = $this->url->link('administration/category', 'token=' . $this->session->data['token'] . '&sort=Sequence' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_menuid'])) {
			$url .= '&filter_menuid=' . urlencode(html_entity_decode($this->request->get['filter_menuid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/category', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/category_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/category')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	public function search(){
		$return = array();
		$this->load->model('api/category');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_category->getCategoriesSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['icategoryid'] = $value['icategoryid'];
				$temp['vcategoryname'] = $value['vcategoryname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}

	public function delete() {

		$json =array();
		$this->load->model('api/category');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_category->deleteCatgory($temp_arr);

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
