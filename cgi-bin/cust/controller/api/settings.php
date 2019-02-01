<?php
class ControllerApiSettings extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/settings');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_settings->getSettings();

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function add() {

		$data = array();
		$this->load->model('api/settings');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr = array(
			// 				'variablename' => 'ItemListing',
			// 				'variablevalue' => array(
			// 						'vcategorycode' => 'Category',
			// 						'vdepcode' => 'Dept',
			// 						'vunitcode' => 'Unit',
			// 						'vsuppliercode' => 'Supplier'
			// 					)
			// 			);

			if($temp_arr['variablename'] == ''){
				$data['validation_error'][] = 'Variable Name Required';
			}

			if(count($temp_arr['variablevalue']) == 0){
				$data['validation_error'][] = 'Variable value Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_settings->addSettings($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(500);
				}

			}else{
				http_response_code(401);
			}

			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function edit_list() {

		$data = array();
		$this->load->model('api/settings');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr = array(
			// 				'variablename' => 'ItemListing',
			// 				'variablevalue' => array(
			// 						'vcategorycode' => 'Category',
			// 						'vdepcode' => 'Dept',
			// 						'vunitcode' => 'Unit',
			// 						'vsuppliercode' => 'Supplier'
			// 					)
			// 			);

			if($temp_arr['variablename'] == ''){
				$data['validation_error'][] = 'Variable Name Required';
			}

			if(count($temp_arr['variablevalue']) == 0){
				$data['validation_error'][] = 'Variable value Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_settings->editlistSettings($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(500);
				}

			}else{
				http_response_code(401);
			}

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function search() {

		$data = array();
		$this->load->model('api/settings');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_settings->getSettingsSearch($search);

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid or search field';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function edit() {

		$data = array();
		$this->load->model('api/settings');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['variablename']))) {

			$data = $this->model_api_settings->getSetting($this->request->get['variablename']);

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	
}
