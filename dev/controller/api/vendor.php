<?php
class ControllerApiVendor extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/vendor');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_vendor->getVendors();

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
		$this->load->model('api/vendor');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vcompanyname' => 'testing 1',
			// 					'vvendortype' => 'Vendor',
			// 					'vfnmae' => 'test 1',
			// 					'vlname' => 'test 1',
			// 					'vcode' => '123456',
			// 					'vaddress1' => 'testing address 1',
			// 					'vcity' => 'testing city 1',
			// 					'vstate' => 'FL',
			// 					'vphone' => '1234567890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test1@test1.com',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'vcompanyname' => 'testing 2',
			// 					'vvendortype' => 'Vendor',
			// 					'vfnmae' => 'test 2',
			// 					'vlname' => 'test 2',
			// 					'vcode' => '123456',
			// 					'vaddress1' => 'testing address 2',
			// 					'vcity' => 'testing city 2',
			// 					'vstate' => 'FL',
			// 					'vphone' => '1234567890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test2@test2.com',
			// 					'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vcompanyname'] == ''){
					$data['validation_error'][] = 'Vendor Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_vendor->addVendor($temp_arr);

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
		$this->load->model('api/vendor');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'isupplierid' => '235',
			// 					'vcompanyname' => 'testing 11',
			// 					'vvendortype' => 'Vendor',
			// 					'vfnmae' => 'test 11',
			// 					'vlname' => 'test 11',
			// 					'vcode' => '123456',
			// 					'vaddress1' => 'testing address 11',
			// 					'vcity' => 'testing city 11',
			// 					'vstate' => 'FL',
			// 					'vphone' => '1234567890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test1@test1.com',
			// 					'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'isupplierid' => '236',
			// 					'vcompanyname' => 'testing 22',
			// 					'vvendortype' => 'Vendor',
			// 					'vfnmae' => 'test 22',
			// 					'vlname' => 'test 22',
			// 					'vcode' => '123456',
			// 					'vaddress1' => 'testing address 22',
			// 					'vcity' => 'testing city 22',
			// 					'vstate' => 'FL',
			// 					'vphone' => '1234567890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test2@test2.com',
			// 					'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['isupplierid'] == ''){
					$data['validation_error'][] = 'Vendor ID Required';
				}

				if($value['vcompanyname'] == ''){
					$data['validation_error'][] = 'Vendor Name Required';
				}

				if($value['isupplierid'] == '' || $value['vcompanyname'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_vendor->editlistVendor($temp_arr);

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
		$this->load->model('api/vendor');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_vendor->getVendorSearch($search);

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
		$this->load->model('api/vendor');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['isupplierid']))) {

			$data = $this->model_api_vendor->getVendor($this->request->get['isupplierid']);

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
