<?php
class ControllerApiTax extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/tax');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_tax->getTax();

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

	public function edit_list() {

		$data = array();
		$this->load->model('api/tax');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'Id' => '1',
			// 					'vtaxtype' => 'State',
			// 					'ntaxrate' => '6.8790'
			// 				);
			// $temp_arr[1] = array(
			// 					'Id' => '2',
			// 					'vtaxtype' => 'Sales',
			// 					'ntaxrate' => '1.0000'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['Id'] == ''){
					$data['validation_error'][] = 'Tax ID Required';
				}

				if($value['Id'] != ''){
					if(!in_array((int)$value['Id'], array(1,2))){
						$data['validation_error'][] = 'Tax ID must 1 or 2 Required';
					}
				}

				if($value['vtaxtype'] == ''){
					$data['validation_error'][] = 'Tax Name Required';
				}

				if($value['Id'] == '' || $value['vtaxtype'] == ''){
					break;
				}

				if($value['Id'] != ''){
					if(!in_array((int)$value['Id'], array(1,2))){
						break;
					}
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_tax->editlistTax($temp_arr);

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
		$this->load->model('api/tax');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_tax->gettaxSearch($search);

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
		$this->load->model('api/tax');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['Id']))) {

			$data = $this->model_api_tax->getTaxById($this->request->get['Id']);

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
