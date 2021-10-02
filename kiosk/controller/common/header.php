<?php
class ControllerCommonHeader extends Controller {
	
	public function index() {
		$data['title'] = $this->document->getTitle();
		$data['stores'] = isset($this->session->data['user_stores']) ? $this->session->data['user_stores'] : array();
		$data['SID'] = isset($this->session->data['SID']) ? $this->session->data['SID'] : '';

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		if(isset($this->session->data['db_database2']))
		{		
			$this->config->set('db_database2',$this->session->data['db_database2']);
			$data['storename'] = $this->session->data['storename'];
		}
		
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->load->language('common/header');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
		$data['text_logout'] = $this->language->get('text_logout');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', true);
		} else {
			$data['logged'] = true;
			
			$data['home'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
			$data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], true);
			
			$data['token'] = $this->session->data['token'];
			$this->load->model('kiosk/stores');
// 			$data['stores'] = array();
			//$data['stores'] = $this->model_kiosk_stores->getStores();
		}

		return $this->load->view('common/header', $data);
	}
	
	public function changestore($id=''){
		
		if(isset($this->request->get['id'])){
			$this->load->model('kiosk/stores');		
			$store=$this->model_kiosk_stores->getStore($this->request->get['id']);
			//print_r($store);
			
			unset($this->session->data['db2']);
			unset($this->session->data['db_hostname2']);
			unset($this->session->data['db_username2']);
			unset($this->session->data['db_password2']);
			unset($this->session->data['db_database2']);
						
			$this->session->data['db_hostname2'] = $store['db_hostname'];
			$this->session->data['db_username2'] = $store['db_username'];
			$this->session->data['db_password2'] = $store['db_password'];
			$this->session->data['db_database2'] = $store['db_name'];
			$this->session->data['db_port2'] = '3306';
			
			$this->config->set('db_database2',$store['db_name']);
			
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		 }
		 else
		 {
			// $this->registry->set('db2', new DB(DB_DRIVER2, DB_HOSTNAME2, DB_USERNAME2, DB_PASSWORD2, DB_DATABASE2, DB_PORT2));
			 //$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true));
		}
	}
}
