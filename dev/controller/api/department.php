<?php
class ControllerApiDepartment extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/department');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_department->getDepartments();

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
		$this->load->model('api/department');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vdepartmentname' => 'test 1',
			// 					'vdescription' => 'Testing 1',
			// 					'isequence' => '11'
			// 				);
			// $temp_arr[1] = array(
			// 					'vdepartmentname' => 'test 2',
			// 					'vdescription' => 'Testing 2',
			// 					'isequence' => '22'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vdepartmentname'] == ''){
					$data['validation_error'][] = 'Department Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_department->addDepartment($temp_arr);

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
		$this->load->model('api/department');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'idepartmentid' => '145',
			// 					'vdepartmentname' => 'test 11',
			// 					'vdescription' => 'Testing 11',
			// 					'isequence' => '11'
			// 				);
			// $temp_arr[1] = array(
			// 					'idepartmentid' => '146',
			// 					'vdepartmentname' => 'test2 2',
			// 					'vdescription' => 'Testing 22',
			// 					'isequence' => '22'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['idepartmentid'] == ''){
					$data['validation_error'][] = 'Department ID Required';
				}

				if($value['vdepartmentname'] == ''){
					$data['validation_error'][] = 'Department Name Required';
				}

				if($value['idepartmentid'] == '' || $value['vdepartmentname'] == ''){
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_department->editlistDepartment($temp_arr);

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
		$this->load->model('api/department');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_department->getDepartmentSearch($search);

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
		$this->load->model('api/department');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['idepartmentid']))) {

			$data = $this->model_api_department->getDepartment($this->request->get['idepartmentid']);

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
