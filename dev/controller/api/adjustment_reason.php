<?php
class ControllerApiAdjustmentReason extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/adjustment_reason');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_adjustment_reason->getAdjustmentReasons();

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
		$this->load->model('api/adjustment_reason');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vreasoncode' => 'testing 1',
			// 					'vreasonename' => 'testing 1',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'vreasoncode' => 'testing 1',
			// 					'vreasonename' => 'testing 2',
			// 					'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vreasoncode'] == ''){
					$data['validation_error'][] = 'Reason Code Required';
					break;
				}

				if($value['vreasonename'] == ''){
					$data['validation_error'][] = 'Reason Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_adjustment_reason->addAdjustmentReason($temp_arr);

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
		$this->load->model('api/adjustment_reason');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'ireasonid' => '100',
			// 					'vreasoncode' => 'testing 1',
			// 					'vreasonename' => 'testing 1',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'ireasonid' => '101',
			// 					'vreasoncode' => 'testing 1',
			// 					'vreasonename' => 'testing 2',
			// 					'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['ireasonid'] == ''){
					$data['validation_error'][] = 'Reason ID Required';
					break;
				}

				if($value['vreasoncode'] == ''){
					$data['validation_error'][] = 'Reason Code Required';
					break;
				}

				if($value['vreasonename'] == ''){
					$data['validation_error'][] = 'Reason Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_adjustment_reason->editlistAdjustmentReason($temp_arr);

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
		$this->load->model('api/adjustment_reason');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_adjustment_reason->getAdjustmentReasonSearch($search);

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
		$this->load->model('api/adjustment_reason');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ireasonid']))) {

			$data = $this->model_api_adjustment_reason->getAdjustmentReason($this->request->get['ireasonid']);

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
