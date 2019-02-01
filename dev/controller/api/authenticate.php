<?php
class ControllerApiAuthenticate extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/authenticate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$credentials = json_decode(file_get_contents('php://input'), true);
			
			$username = $credentials['username'];
			$password = $credentials['password'];
			//$sid = $this->request->post['sid'];

			if(!empty($username) && !empty($password)){
				$data = $this->model_api_authenticate->authenticateUser($username,$password);
			}else{
				$data['error'] = 'Please Enter Valid Credentials';
			}

			if(array_key_exists("error",$data)){
				$error_code = 401;
			}else{
				$error_code = 200;
			}

			http_response_code($error_code);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong';
			http_response_code(500);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function change_store() {

		$data = array();
		$this->load->model('api/authenticate');

		if (($this->session->data['token'] == $this->request->get['token']) && (!empty($this->request->get['store_id']))) {

			$store_id = $this->request->get['store_id'];
			
			if(!empty($store_id)){
				$data = $this->model_api_authenticate->changeStore($store_id);
			}else{
				$data['error'] = 'Store Id Missing';
			}

			if(array_key_exists("error",$data)){
				$error_code = 401;
			}else{
				$error_code = 200;
			}

			http_response_code($error_code);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong';
			http_response_code(500);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
	
}
