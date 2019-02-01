<?php
class ControllerAdministrationAdjustmentReason extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/adjustment_reason');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/adjustment_reason');
    
		$this->load->model('api/adjustment_reason');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			$arr_with_ireasonid = array();
			$arr_without_ireasonid = array();

			foreach ($this->request->post['adjustment_reason'] as $key => $value) {
				if(isset($value['ireasonid']) && $value['ireasonid'] == 0){
					$temp = array();
					$temp['vreasonename'] = $value['vreasonename'];
					$temp['vreasoncode'] = $value['vreasonename'];
					$temp['estatus'] = 'Active';
					$arr_without_ireasonid[] = $temp;
				}else{
					$temp = array();
					$temp['vreasonename'] = $value['vreasonename'];
					$temp['vreasoncode'] = $value['vreasonename'];
					$temp['estatus'] = 'Active';
					$temp['ireasonid'] = $value['ireasonid'];
					
					$arr_with_ireasonid[] = $temp;
				}
			}
			
			$this->model_api_adjustment_reason->addAdjustmentReason($arr_without_ireasonid);
			$this->model_api_adjustment_reason->editlistAdjustmentReason($arr_with_ireasonid);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/adjustment_reason', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	 }
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ireasonid';
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
			'href' => $this->url->link('administration/adjustment_reason', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/adjustment_reason/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/adjustment_reason/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/adjustment_reason/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/adjustment_reason/edit_list', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/adjustment_reason', 'token=' . $this->session->data['token'], true);
		$data['searchreason'] = $this->url->link('administration/adjustment_reason/search', 'token=' . $this->session->data['token'], true);
		
		$data['adjustment_reasons'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/adjustment_reason');

		$adjustment_reason_data = $this->model_api_adjustment_reason->getAdjustmentReasons($filter_data);
		$adjustment_reason_total = $this->model_api_adjustment_reason->getAdjustmentReasonsTotal($filter_data);

		$data['adjustment_reasons'] = $adjustment_reason_data;
		
		if(count($adjustment_reason_data)==0){ 
			$data['adjustment_reasons'] =array();
			$adjustment_reason_total = 0;
			$data['adjustment_reason_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_reason_name'] = $this->language->get('column_reason_name');
		$data['column_reason_status'] = $this->language->get('column_reason_status');

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
		$pagination->total = $adjustment_reason_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/adjustment_reason', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($adjustment_reason_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($adjustment_reason_total - $this->config->get('config_limit_admin'))) ? $adjustment_reason_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $adjustment_reason_total, ceil($adjustment_reason_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/adjustment_reason_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/adjustment_reason')) {
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
		$this->load->model('api/adjustment_reason');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_adjustment_reason->getAdjustmentReasonSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['ireasonid'] = $value['ireasonid'];
				$temp['vreasonename'] = $value['vreasonename'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
	
}
