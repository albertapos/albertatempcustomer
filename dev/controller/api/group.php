<?php
class ControllerApiGroup extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_group->getGroups();

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
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vitemgroupname' => 'testing 1',
			// 					'etransferstatus' => ''
			// 				);
			// $temp_arr[1] = array(
			// 					'vitemgroupname' => 'testing 2',
			// 					'etransferstatus' => ''
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vitemgroupname'] == ''){
					$data['validation_error'][] = 'Group Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_group->addGroup($temp_arr);

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

	public function add_general() {

		$data = array();
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'iitemgroupid' => '1',
			// 					'vsku' => '123450',
			// 					'isequence' => '1',
			// 					'vtype' => 'Product'
			// 				);
			// $temp_arr[1] = array(
			// 					'iitemgroupid' => '2',
			// 					'vsku' => '123450',
			// 					'isequence' => '1',
			// 					'vtype' => 'Product'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Group ID Required';
					break;
				}

				if($value['vsku'] == ''){
					$data['validation_error'][] = 'Item SKU Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_group->addGroupGeneral($temp_arr);

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

	public function edit_list_general() {

		$data = array();
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'iitemgroupid' => '1',
			// 					'vsku' => '123450',
			// 					'isequence' => '1',
			// 					'vtype' => 'Product'
			// 				);
			// $temp_arr[1] = array(
			// 					'iitemgroupid' => '2',
			// 					'vsku' => '123450',
			// 					'isequence' => '1',
			// 					'vtype' => 'Product'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Group ID Required';
					break;
				}

				if($value['vsku'] == ''){
					$data['validation_error'][] = 'Item SKU Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_group->editlistGroupGeneral($temp_arr);

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

	public function edit_general() {

		$data = array();
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['iitemgroupid']))) {

			$data = $this->model_api_group->getGroup($this->request->get['iitemgroupid']);

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

	public function delete_general() {

		$data = array();
		$this->load->model('api/group');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'iitemgroupid' => '1',
			// 					'Id' => '428'
			// 				);
			// $temp_arr[1] = array(
			// 					'iitemgroupid' => '2',
			// 					'Id' => '429'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Item Group ID Required';
					break;
				}

				if($value['Id'] == ''){
					$data['validation_error'][] = 'Item Group Details Id Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {
					
				$data = $this->model_api_group->deleteGroupProduct($v['iitemgroupid'],$v['Id']);

				}

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
