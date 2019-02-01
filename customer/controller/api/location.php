<?php
class ControllerApiLocation extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/location');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_location->getLocations();

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
		$this->load->model('api/location');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vlocname' => 'testing 1',
			// 					'vlocdesc' => 'Test 1 Desc'
			// 				);
			// $temp_arr[1] = array(
			// 					'vlocname' => 'testing 2',
			// 					'vlocdesc' => 'Test 2 Desc'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vlocname'] == ''){
					$data['validation_error'][] = 'Location Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_location->addLocation($temp_arr);

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
		$this->load->model('api/location');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'ilocid' => '100',
			// 					'vlocname' => 'testing 1',
			// 					'vlocdesc' => 'Test 1 Desc'
			// 				);
			// $temp_arr[1] = array(
			// 					'ilocid' => '101',
			// 					'vlocname' => 'testing 2',
			// 					'vlocdesc' => 'Test 2 Desc'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['ilocid'] == ''){
					$data['validation_error'][] = 'Location ID Required';
					break;
				}

				if($value['vlocname'] == ''){
					$data['validation_error'][] = 'Location Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_location->editlistLocation($temp_arr);

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

	public function search() {

		$data = array();
		$this->load->model('api/location');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_location->getLocationSearch($search);

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

	public function edit() {

		$data = array();
		$this->load->model('api/location');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ilocid']))) {

			$data = $this->model_api_location->getLocation($this->request->get['ilocid']);

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
