<?php
class ControllerApiGroupSlabPricing extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/group_slab_pricing');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_group_slab_pricing->getGroupSlabPricings();

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
		$this->load->model('api/group_slab_pricing');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'iitemgroupid' => '1',
			// 					'slicetype' => 'nprice',
			// 					'iqty' => '5',
			// 					'nunitprice' => '0.99',
			// 					'nprice' => '1.10',
			// 					'percentage' => '',
			// 					'startdate' => '04-05-2017 10:00:00',
			// 					'enddate' => '04-07-2017 10:00:00',
			// 					'status' => '1'
			// 				);
			// $temp_arr[1] = array(
			// 					'iitemgroupid' => '1',
			// 					'slicetype' => 'percentage',
			// 					'iqty' => '5',
			// 					'nunitprice' => '1.99',
			// 					'nprice' => '',
			// 					'percentage' => '1.15',
			// 					'startdate' => '03-05-2017 10:00:00',
			// 					'enddate' => '04-08-2017 10:00:00',
			// 					'status' => '1'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Group ID Required';
					break;
				}

				if($value['slicetype'] == ''){
					$data['validation_error'][] = 'Slice Type Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_group_slab_pricing->addGroupSlabPricing($temp_arr);

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
		$this->load->model('api/group_slab_pricing');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr[0] = array(
			// 					'igroupslabid' => '106',
			// 					'iitemgroupid' => '1',
			// 					'slicetype' => 'nprice',
			// 					'iqty' => '5',
			// 					'nunitprice' => '0.99',
			// 					'nprice' => '1.10',
			// 					'percentage' => '',
			// 					'startdate' => '04-05-2017 10:00:00',
			// 					'enddate' => '04-07-2017 10:00:00',
			// 					'status' => '1'
			// 				);
			// $temp_arr[1] = array(
			// 					'igroupslabid' => '107',
			// 					'iitemgroupid' => '1',
			// 					'slicetype' => 'percentage',
			// 					'iqty' => '5',
			// 					'nunitprice' => '1.99',
			// 					'nprice' => '',
			// 					'percentage' => '1.15',
			// 					'startdate' => '03-05-2017 10:00:00',
			// 					'enddate' => '04-08-2017 10:00:00',
			// 					'status' => '1'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['igroupslabid'] == ''){
					$data['validation_error'][] = 'Group Slab Pricing ID Required';
					break;
				}

				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Group ID Required';
					break;
				}

				if($value['slicetype'] == ''){
					$data['validation_error'][] = 'Slice Type Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_group_slab_pricing->editlistGroupSlabPricing($temp_arr);

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

	public function edit() {

		$data = array();
		$this->load->model('api/group_slab_pricing');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['igroupslabid']))) {

			$data = $this->model_api_group_slab_pricing->getGroupSlabPricing($this->request->get['igroupslabid']);

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
