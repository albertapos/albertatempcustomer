<?php
class ControllerApiStore extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/store');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_store->getStore();

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
		$this->load->model('api/store');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

				if($temp_arr['istoreid'] == ''){
					$data['validation_error'][] = 'Store ID Required';
				}

				if($temp_arr['vcompanycode'] == ''){
					$data['validation_error'][] = 'Company Code Required';
				}

				if($temp_arr['vstorename'] == ''){
					$data['validation_error'][] = 'Store Name Required';
				}

				if($temp_arr['vstoreabbr'] == ''){
					$data['validation_error'][] = 'Store Abbr Required';
				}

				if($temp_arr['vaddress1'] == ''){
					$data['validation_error'][] = 'Address Required';
				}

				if($temp_arr['vstoredesc'] == ''){
					$data['validation_error'][] = 'Description Required';
				}

				if($temp_arr['vcity'] == ''){
					$data['validation_error'][] = 'City Required';
				}

				if($temp_arr['vstate'] == ''){
					$data['validation_error'][] = 'State Required';
				}

				if($temp_arr['vzip'] == ''){
					$data['validation_error'][] = 'Zip Required';
				}

				if($temp_arr['vphone1'] == ''){
					$data['validation_error'][] = 'Phone 1 Required';
				}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_store->editlistStore($temp_arr);

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
	
}
