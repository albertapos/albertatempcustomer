<?php
class ControllerAdministrationStore extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/store');

		$this->document->setTitle($this->language->get('heading_title'));

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function edit_list() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/store');
    
		$this->load->model('api/store');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {


			$this->model_api_store->editlistStore($this->request->post);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/store', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	 }
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'istoreid';
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/store', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/store/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/store/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/store/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/store/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['text_vcompanycode'] = $this->language->get('text_vcompanycode');
		$data['text_vstorename'] = $this->language->get('text_vstorename');
		$data['text_vstoreabbr'] = $this->language->get('text_vstoreabbr');
		$data['text_vaddress1'] = $this->language->get('text_vaddress1');
		$data['text_vstoredesc'] = $this->language->get('text_vstoredesc');
		$data['text_vcity'] = $this->language->get('text_vcity');
		$data['text_vstate'] = $this->language->get('text_vstate');
		$data['text_vzip'] = $this->language->get('text_vzip');
		$data['text_vcountry'] = $this->language->get('text_vcountry');
		$data['text_vphone1'] = $this->language->get('text_vphone1');
		$data['text_vphone2'] = $this->language->get('text_vphone2');
		$data['text_vfax1'] = $this->language->get('text_vfax1');
		$data['text_vemail'] = $this->language->get('text_vemail');
		$data['text_vwebsite'] = $this->language->get('text_vwebsite');
		$data['text_vcontactperson'] = $this->language->get('text_vcontactperson');
		$data['text_isequence'] = $this->language->get('text_isequence');
		$data['text_vmessage1'] = $this->language->get('text_vmessage1');
		$data['text_vmessage2'] = $this->language->get('text_vmessage2');

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

		if (isset($this->error['vcompanycode'])) {
			$data['error_vcompanycode'] = $this->error['vcompanycode'];
		} else {
			$data['error_vcompanycode'] = '';
		}

		if (isset($this->error['vstorename'])) {
			$data['error_vstorename'] = $this->error['vstorename'];
		} else {
			$data['error_vstorename'] = '';
		}

		if (isset($this->error['vstoreabbr'])) {
			$data['error_vstoreabbr'] = $this->error['vstoreabbr'];
		} else {
			$data['error_vstoreabbr'] = '';
		}

		if (isset($this->error['vaddress1'])) {
			$data['error_vaddress1'] = $this->error['vaddress1'];
		} else {
			$data['error_vaddress1'] = '';
		}

		if (isset($this->error['vstoredesc'])) {
			$data['error_vstoredesc'] = $this->error['vstoredesc'];
		} else {
			$data['error_vstoredesc'] = '';
		}

		if (isset($this->error['vcity'])) {
			$data['error_vcity'] = $this->error['vcity'];
		} else {
			$data['error_vcity'] = '';
		}

		if (isset($this->error['vstate'])) {
			$data['error_vstate'] = $this->error['vstate'];
		} else {
			$data['error_vstate'] = '';
		}

		if (isset($this->error['vzip'])) {
			$data['error_vzip'] = $this->error['vzip'];
		} else {
			$data['error_vzip'] = '';
		}

		if (isset($this->error['vphone1'])) {
			$data['error_vphone1'] = $this->error['vphone1'];
		} else {
			$data['error_vphone1'] = '';
		}

		if (isset($this->error['vemail'])) {
			$data['error_vemail'] = $this->error['vemail'];
		} else {
			$data['error_vemail'] = '';
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

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/store_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/store')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (($this->request->post['vcompanycode'] == '')) {
			$this->error['vcompanycode']= 'SID Required';
		}

		if (($this->request->post['vstorename'] == '')) {
			$this->error['vstorename']= 'Store Name Required';
		}

		if (($this->request->post['vstoreabbr'] == '')) {
			$this->error['vstoreabbr']= 'Store Abbr Required';
		}

		if (($this->request->post['vaddress1'] == '')) {
			$this->error['vaddress1']= 'Address Required';
		}

		if (($this->request->post['vstoredesc'] == '')) {
			$this->error['vstoredesc']= 'Description Required';
		}

		if (($this->request->post['vcity'] == '')) {
			$this->error['vcity']= 'City Required';
		}

		if (($this->request->post['vstate'] == '')) {
			$this->error['vstate']= 'State Required';
		}

		if (($this->request->post['vzip'] == '')) {
			$this->error['vzip']= 'Zip Required';
		}

		if (($this->request->post['vphone1'] == '')) {
			$this->error['vphone1']= 'Phone 1 Required';
		}

		if (($this->request->post['vemail'] != '')) {
			if (!filter_var($this->request->post['vemail'], FILTER_VALIDATE_EMAIL)) {
			  $this->error['vemail']= 'Please Enter Valid Email Address';
			}
		}

		return !$this->error;
  	}
	
}
