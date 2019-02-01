<?php
class ControllerAdministrationDepartment extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('administration/department');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/department');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/department');
    
		$this->load->model('administration/department');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$this->model_administration_department->editDepartmentList($this->request->post);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/department', 'token=' . $this->session->data['token'] . $url, true));
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
			$sort = 'idepartmentid';
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

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/department', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/department/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/department/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/department/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/department/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/department', 'token=' . $this->session->data['token'], true);
		$data['searchdepartment'] = $this->url->link('administration/department/search', 'token=' . $this->session->data['token'], true);
		
		$data['departments'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'filter_menuid'  => $filter_menuid,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');
		
		// $data['menus'] = $this->model_administration_menus->getActiveMenus();

		$this->load->model('tool/image');
		
		$department_total = $this->model_administration_department->getTotalDepartments($filter_data);

		$results = $this->model_administration_department->getDepartments($filter_data);

		foreach ($results as $result) {
			
			$data['departments'][] = array(
				'idepartmentid'   => $result['idepartmentid'],
				'vdepcode' 		  => $result['vdepcode'],
				'vdepartmentname' => $result['vdepartmentname'],
				'vdescription' 	  => $result['vdescription'],
				'starttime' 	  => $result['starttime'],
				'endtime' 	      => $result['endtime'],
				'isequence'       => $result['isequence'],
				'view'            => $this->url->link('administration/department/info', 'token=' . $this->session->data['token'] . '&idepartmentid=' . $result['idepartmentid'] . $url, true),
				'edit'            => $this->url->link('administration/department/edit', 'token=' . $this->session->data['token'] . '&idepartmentid=' . $result['idepartmentid'] . $url, true),
				'delete'          => $this->url->link('administration/department/delete', 'token=' . $this->session->data['token'] . '&idepartmentid=' . $result['idepartmentid'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['departments'] =array();
			$department_total = 0;
			$data['department_row'] =1;
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_department_name'] = $this->language->get('column_department_name');
		$data['column_description'] = $this->language->get('column_description');
		$data['column_sequence'] = $this->language->get('column_sequence');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_department_name'] = $this->language->get('entry_department_name');
		$data['entry_description'] = $this->language->get('entry_description');
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
		$pagination->total = $department_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/department', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($department_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($department_total - $this->config->get('config_limit_admin'))) ? $department_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $department_total, ceil($department_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/department_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/department')) {
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
		$this->load->model('api/department');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_department->getDepartmentSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['idepartmentid'] = $value['idepartmentid'];
				$temp['vdepartmentname'] = $value['vdepartmentname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}

	public function delete() {

		$json =array();
		$this->load->model('api/department');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_department->deleteDepartment($temp_arr);

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
