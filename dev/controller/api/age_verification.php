<?php
class ControllerApiAgeVerification extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/age_verification');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_age_verification->getAgeVerifications();

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
		$this->load->model('api/age_verification');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr[0] = array(
			// 					'vname' => 'test',
			// 					'vvalue' => '123'
			// 				);
			// $temp_arr[1] = array(
			// 					'vname' => 'test1',
			// 					'vvalue' => '12'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['vname'] == ''){
					$data['validation_error'][] = 'Description Required';
				}

				if($value['vvalue'] == ''){
					$data['validation_error'][] = 'Value Required';
				}

				if($value['vname'] == '' || $value['vvalue'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_age_verification->addAgeVerification($temp_arr);

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
		$this->load->model('api/age_verification');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vname' => 'test',
			// 					'vvalue' => '123',
			// 					'Id' => '101'
			// 				);
			// $temp_arr[1] = array(
			// 					'vname' => 'test1',
			// 					'vvalue' => '12',
			// 					'Id' => '102'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['Id'] == ''){
					$data['validation_error'][] = 'Id Required';
				}

				if($value['vname'] == ''){
					$data['validation_error'][] = 'Description Required';
				}

				if($value['vvalue'] == ''){
					$data['validation_error'][] = 'Value Required';
				}

				if($value['Id'] == '' || $value['vname'] == '' || $value['vvalue'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_age_verification->editlistAgeVerification($temp_arr);

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
		$this->load->model('api/age_verification');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_age_verification->getAgeVerificationsSearch($search);

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
		$this->load->model('api/age_verification');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['age_verification_id']))) {

			$data = $this->model_api_age_verification->getAgeVerification($this->request->get['age_verification_id']);

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
