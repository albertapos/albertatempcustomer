<?php
class ControllerApiCustomer extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/customer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_customer->getCustomers();

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
		$this->load->model('api/customer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr[0] = array(
			// 					'vcustomername' => 'test 1',
			// 					'vaccountnumber' => '12345678',
			// 					'vfname' => 'fname 1',
			// 					'vlname' => 'vlname 1',
			// 					'vaddress1' => 'Testing Address 1',
			// 					'vcity' => 'Testing vcity 1',
			// 					'vstate' => 'Testing vstate 1',
			// 					'vphone' => '123467890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test1@test1.com',
			// 					'pricelevel' => '2',
			// 					'vtaxable' => 'Yes',
			// 					'estatus' => 'Close'
			// 				);
			// $temp_arr[1] = array(
			// 					'vcustomername' => 'test 2',
			// 					'vaccountnumber' => '12345678',
			// 					'vfname' => 'fname 2',
			// 					'vlname' => 'vlname 2',
			// 					'vaddress1' => 'Testing Address 2',
			// 					'vcity' => 'Testing vcity 2',
			// 					'vstate' => 'Testing vstate 2',
			// 					'vphone' => '123467890',
			// 					'vzip' => '12345',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test2@test2.com',
			// 					'pricelevel' => '3',
			// 					'vtaxable' => 'Yes',
			// 					'estatus' => 'open'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vcustomername'] == ''){
					$data['validation_error'][] = 'Customer Name Required';
				}

				if($value['vaccountnumber'] == ''){
					$data['validation_error'][] = 'Account Number Required';
				}

				if($value['vcustomername'] == '' || $value['vaccountnumber'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_customer->addCustomer($temp_arr);

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
		$this->load->model('api/customer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr[0] = array(
			// 					'icustomerid' => '100',
			// 					'vcustomername' => 'test 11',
			// 					'vaccountnumber' => '12345678',
			// 					'vfname' => 'fname 1',
			// 					'vlname' => 'vlname 1',
			// 					'vaddress1' => 'Testing Address 1',
			// 					'vcity' => 'Testing vcity 1',
			// 					'vstate' => 'Testing vstate 1',
			// 					'vphone' => '123467890',
			// 					'vzip' => '33020',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test1@test1.com',
			// 					'pricelevel' => '2',
			// 					'vtaxable' => 'Yes',
			// 					'estatus' => 'Close'
			// 				);
			// $temp_arr[1] = array(
			// 					'icustomerid' => '101',
			// 					'vcustomername' => 'test 22',
			// 					'vaccountnumber' => '12345678',
			// 					'vfname' => 'fname 2',
			// 					'vlname' => 'vlname 2',
			// 					'vaddress1' => 'Testing Address 2',
			// 					'vcity' => 'Testing vcity 2',
			// 					'vstate' => 'Testing vstate 2',
			// 					'vphone' => '123467890',
			// 					'vzip' => '12345',
			// 					'vcountry' => 'USA',
			// 					'vemail' => 'test2@test2.com',
			// 					'pricelevel' => '2',
			// 					'vtaxable' => 'Yes',
			// 					'estatus' => 'open'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['icustomerid'] == ''){
					$data['validation_error'][] = 'Customer ID Required';
				}

				if($value['vcustomername'] == ''){
					$data['validation_error'][] = 'Customer Name Required';
				}

				if($value['vaccountnumber'] == ''){
					$data['validation_error'][] = 'Account Number Required';
				}

				if($value['vcustomername'] == '' || $value['vaccountnumber'] == ''){
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_customer->editlistCustomer($temp_arr);

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
		$this->load->model('api/customer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_customer->getCustomersSearch($search);

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
		$this->load->model('api/customer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['icustomerid']))) {

			$data = $this->model_api_customer->getCustomer($this->request->get['icustomerid']);

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
