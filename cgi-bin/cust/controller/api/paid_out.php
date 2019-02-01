<?php
class ControllerApiPaidOut extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/paid_out');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_paid_out->getPaidOuts();

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
		$this->load->model('api/paid_out');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vpaidoutname' => 'test 1',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'vpaidoutname' => 'test 2',
			// 					'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vpaidoutname'] == ''){
					$data['validation_error'][] = 'Paid Out Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_paid_out->addPaidOut($temp_arr);

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
		$this->load->model('api/paid_out');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'ipaidoutid' => '103',
			// 					'vpaidoutname' => 'test 11',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'ipaidoutid' => '104',
			// 					'vpaidoutname' => 'test 22',
			// 					'estatus' => 'Active'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['ipaidoutid'] == ''){
					$data['validation_error'][] = 'Paid Out ID Required';
				}

				if($value['vpaidoutname'] == ''){
					$data['validation_error'][] = 'Paid Out Name Required';
				}

				if($value['ipaidoutid'] == '' || $value['vpaidoutname'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_paid_out->editlistPaidOut($temp_arr);

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
		$this->load->model('api/paid_out');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_paid_out->getPaidOutSearch($search);

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
		$this->load->model('api/paid_out');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ipaidoutid']))) {

			$data = $this->model_api_paid_out->getPaidOut($this->request->get['ipaidoutid']);

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
