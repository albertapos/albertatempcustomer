<?php
class ControllerApiUnits extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/units');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_units->getUnits();

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
		$this->load->model('api/units');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr = array();
			// $temp_arr[0] = array(
			// 					'vunitcode' => 'UNT003',
			// 				    'vunitname' => 'Each',
			// 				    'vunitdesc' => 'Each',
			// 				    'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'vunitcode' => 'UNT003',
			// 				    'vunitname' => 'Pound',
			// 				    'vunitdesc' => 'Pound',
			// 				    'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				
				if (($value['vunitcode'] == '')) {
					$data['validation_error'][] = 'Unit Code Required';
					break;
				}

				if (($value['vunitname'] == '')) {
					$data['validation_error'][] = 'Unit Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

						$unique_unitcode = $this->model_api_units->getUnitCode($v['vunitcode']);

						if(count($unique_unitcode) > 0){

							$units_info = $this->model_api_units->getUnitAllData($v['vunitcode'],$v['vunitname']);
							
								if(count($units_info) > 0 ){
									$data = $this->model_api_units->editlistUnits($units_info['iunitid'],$v);
								}else{
									$data['validation_error'][] = 'Entered the same Unit Code';
									break;
								}
						}else{
							$data = $this->model_api_units->addUnits($v);
						}
					
				}

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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
		$this->load->model('api/units');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr = array();
			// $temp_arr[0] = array(
			// 					'iunitid' => '100',
			// 					'vunitcode' => 'UNT003',
			// 				    'vunitname' => 'Each',
			// 				    'vunitdesc' => 'Each',
			// 				    'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'iunitid' => '101',
			// 					'vunitcode' => 'UNT003',
			// 				    'vunitname' => 'Pound',
			// 				    'vunitdesc' => 'Pound',
			// 				    'estatus' => 'Active'
			// 				);

			foreach ($temp_arr as $key => $value) {
				
				if (($value['iunitid'] == '')) {
					$data['validation_error'][] = 'Unit ID Required';
					break;
				}

				if (($value['vunitcode'] == '')) {
					$data['validation_error'][] = 'Unit Code Required';
					break;
				}

				if (($value['vunitname'] == '')) {
					$data['validation_error'][] = 'Unit Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

						$unique_unitcode = $this->model_api_units->getUnitCode($v['vunitcode']);

						$units_info = $this->model_api_units->getUnit($v['iunitid']);
						
						if($v['vunitcode'] != $units_info['vunitcode']){
							if(count($unique_unitcode) > 0 ){
								$data['validation_error'][] = 'Entered the same Unit Code';
								break;
							}else{
								$data = $this->model_api_units->editlistUnits($units_info['iunitid'],$v);
							}
							
						}else{
							$data = $this->model_api_units->editlistUnits($v['iunitid'],$v);
						}
					
				}

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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
		$this->load->model('api/units');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_units->getUnitSearch($search);

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
		$this->load->model('api/units');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['iunitid']))) {

			$data = $this->model_api_units->getUnit($this->request->get['iunitid']);

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
