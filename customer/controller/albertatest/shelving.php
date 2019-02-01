<?php
class ControllerAdministrationShelving extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/shelving');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/shelving');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/shelving');
    
		$this->load->model('api/shelving');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$this->model_api_shelving->editlistShelving($this->request->post['shelving']);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/shelving', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	  }
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id';
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
			'href' => $this->url->link('administration/shelving', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/shelving/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/shelving/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/shelving/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/shelving/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/shelving', 'token=' . $this->session->data['token'], true);
		$data['searchshelving'] = $this->url->link('administration/shelving/search', 'token=' . $this->session->data['token'], true);
		
		$data['shelvings'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');
		
		$this->load->model('tool/image');
		
		$shelving_total = $this->model_api_shelving->getTotalShelvings($filter_data);

		$results = $this->model_api_shelving->getShelvings($filter_data);

		foreach ($results as $result) {
			
			$data['shelvings'][] = array(
				'id'     	 => $result['id'],
				'shelvingname'  => $result['shelvingname'],
				'view'   	 => $this->url->link('administration/shelving/info', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, true),
				'edit'   => $this->url->link('administration/shelving/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, true),
				'delete' => $this->url->link('administration/shelving/delete', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, true)
			);
		}
		
		if(count($results)==0){ 
			$data['shelvings'] =array();
			$shelving_total = 0;
			$data['shelving_row'] =1;
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_value'] = $this->language->get('column_value');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_value'] = $this->language->get('entry_value');

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
		$data['sid'] = $this->session->data['sid'];

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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $shelving_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/shelving', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($shelving_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($shelving_total - $this->config->get('config_limit_admin'))) ? $shelving_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $shelving_total, ceil($shelving_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/shelving_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/shelving')) {
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
		$this->load->model('api/shelving');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_shelving->getShelvingSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['id'] = $value['id'];
				$temp['shelvingname'] = $value['shelvingname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
