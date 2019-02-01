<?php
class ControllerApiLogin extends Controller {
	private $error = array();

	public function index() {
		$return = array();
		if(!empty($this->request->get['username']) && !empty($this->request->get['password']) && !empty($this->request->get['SID'])){

			$this->load->language('common/login');

			$this->document->setTitle($this->language->get('heading_title'));
			
			if ($this->validate()) {
				$this->session->data['token'] = token(32);
				$token = $this->session->data['token'];
				
				$return['token'] = $token;
			}else{
				$return['error'] = "Login Fail";
			}

		}else{
			$return['error'] = 'Something Went Wrong!!! <br> PLease Enter Correct Login Credentials!!!';
		}
		echo json_encode($return);
		exit;
	}

	public function getProductDetails(){
		$return = array();

		$this->load->model('api/store');

		if(isset($this->request->get['token']) && isset($this->session->data['token']) && ($this->request->get['token'] == $this->session->data['token'])){
			$data = $this->model_api_store->getData();
			
			echo json_encode($data);
		}else{
			$return['error'] = 'Something Went Wrong!!!';
			echo json_encode($return);
		}
		
	}

	protected function validate() {
		
		$this->load->model('api/store');

		if (!isset($this->request->get['username']) || !isset($this->request->get['password']) || !$this->model_api_store->login($this->request->get['username'], html_entity_decode($this->request->get['password'], ENT_QUOTES, 'UTF-8'),$this->request->get['SID'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		return !$this->error;
	}
}
