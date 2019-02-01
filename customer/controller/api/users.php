<?php
class ControllerApiUsers extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_users->getUsers();

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

	public function user_types() {

		$data = array();
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_users->getUsersType();

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
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'estatus' => 'Active',
			// 				    'vfname' => 'test1',
			// 				    'vlname' => 'test1',
			// 				    'vaddress1' => 'testing address 1',
			// 				    'vaddress2' => '',
			// 				    'vcity' => 'test 1',
			// 				    'vstate' => 'test1',
			// 				    'vzip' => '12345',
			// 				    'vcountry' => 'USA',
			// 				    'vphone' => '1234567890',
			// 				    'vemail' => 'test1@test1.com',
			// 				    'vuserid' => '321',
			// 				    'vpassword' => '1234',
			// 				    'vusertype' => 'Cashier',
			// 				    'vpasswordchange' => 'No',
			// 				    'vuserbarcode' => '1234'
			// 				);
			// $temp_arr[1] = array(
			// 					'estatus' => 'Active',
			// 				    'vfname' => 'test2',
			// 				    'vlname' => 'test2',
			// 				    'vaddress1' => 'test address 2',
			// 				    'vaddress2' => '',
			// 				    'vcity' => 'test2',
			// 				    'vstate' => 'test2',
			// 				    'vzip' => '12345',
			// 				    'vcountry' => 'USA',
			// 				    'vphone' => '1234567890',
			// 				    'vemail' => 'test2@test2.com',
			// 				    'vuserid' => '456',
			// 				    'vpassword' => '1234',
			// 				    'vusertype' => 'Cashier',
			// 				    'vpasswordchange' => 'No',
			// 				    'vuserbarcode' => '1234'
			// 				);

			foreach ($temp_arr as $key => $value) {
				
				if (($value['vfname'] == '')) {
					$data['validation_error'][] = 'First Name Required';
					break;
				}

				if (($value['vlname'] == '')) {
					$data['validation_error'][] = 'Last Name Required';
					break;
				}

				if (($value['vaddress1'] == '')) {
					$data['validation_error'][] = 'Address Required';
					break;
				}

				if (($value['vemail'] == '')) {
					$data['validation_error'][] = 'Email Required';
					break;
				}

				$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9-_\.]+\@([a-zA-Z0-9-_\.]+\.)+[a-zA-Z]+$/";
				if (!preg_match($email_pattern, $value['vemail'])) {
					$data['validation_error'][] = 'Enter Valid Email';
					break;
				}

				if (($value['vuserid'] == '')) {
					$data['validation_error'][] = 'User ID Required';
					break;
				}

				if (!is_numeric($value['vuserid'])) {
					$data['validation_error'][] = 'Enter Numeric User ID';
					break;
				}

				if(strlen($value['vuserid']) < 3){
					$data['validation_error'][] = 'User ID must be three number ';
					break;
				}

				if (($value['vpassword'] == '')) {
					$data['validation_error'][] = 'Please Enter Password';
					break;
				}

				if(strlen($value['vpassword']) < 4){
					$data['validation_error'][] = 'Password must be four characters ';
					break;
				}

				if(strlen($value['vpassword']) > 4){
					$data['validation_error'][] = 'Password must be four characters ';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

					if(strlen($v['vuserid']) == 3){
						$unique_userid = $this->model_api_users->getUserID($v['vuserid']);
						
						if(count($unique_userid) > 0){

							$users_info = $this->model_api_users->getUserAllData($v['vuserid'],$v['vfname'],$v['vlname']);
							
								if(count($users_info) > 0 ){
									$data = $this->model_api_users->editlistUsers($users_info['iuserid'],$v);
								}else{
									$data['validation_error'][] = 'Entered the same user id';
									break;
								}
						}else{
							$data = $this->model_api_users->addUsers($v);
						}
					}else{
						$data['validation_error'][] = 'user id must be three digit';
						break;
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
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'iuserid' => '106',
			// 					'estatus' => 'Active',
			// 				    'vfname' => 'test11',
			// 				    'vlname' => 'test11',
			// 				    'vaddress1' => 'testing address 1',
			// 				    'vaddress2' => '',
			// 				    'vcity' => 'test 11',
			// 				    'vstate' => 'test11',
			// 				    'vzip' => '12345',
			// 				    'vcountry' => 'USA',
			// 				    'vphone' => '1234567890',
			// 				    'vemail' => 'test11@test11.com',
			// 				    'vuserid' => '123',
			// 				    'vpassword' => '1234',
			// 				    'vusertype' => 'Cashier',
			// 				    'vpasswordchange' => 'No',
			// 				    'vuserbarcode' => '1234'
			// 				);
			// $temp_arr[1] = array(
			// 					'iuserid' => '107',
			// 					'estatus' => 'Active',
			// 				    'vfname' => 'test22',
			// 				    'vlname' => 'test22',
			// 				    'vaddress1' => 'test address 2',
			// 				    'vaddress2' => '',
			// 				    'vcity' => 'test22',
			// 				    'vstate' => 'test22',
			// 				    'vzip' => '12345',
			// 				    'vcountry' => 'USA',
			// 				    'vphone' => '1234567890',
			// 				    'vemail' => 'test22@test22.com',
			// 				    'vuserid' => '678',
			// 				    'vpassword' => '1234',
			// 				    'vusertype' => 'Cashier',
			// 				    'vpasswordchange' => 'No',
			// 				    'vuserbarcode' => '1234'
			// 				);

			foreach ($temp_arr as $key => $value) {
				
				if (($value['iuserid'] == '')) {
					$data['validation_error'][] = 'User ID Required';
					break;
				}

				if (($value['vfname'] == '')) {
					$data['validation_error'][] = 'First Name Required';
					break;
				}

				if (($value['vlname'] == '')) {
					$data['validation_error'][] = 'Last Name Required';
					break;
				}

				if (($value['vaddress1'] == '')) {
					$data['validation_error'][] = 'Address Required';
					break;
				}

				if (($value['vemail'] == '')) {
					$data['validation_error'][] = 'Email Required';
					break;
				}

				$email_pattern = "/^[a-zA-Z0-9][a-zA-Z0-9-_\.]+\@([a-zA-Z0-9-_\.]+\.)+[a-zA-Z]+$/";
				if (!preg_match($email_pattern, $value['vemail'])) {
					$data['validation_error'][] = 'Enter Valid Email';
					break;
				}

				if (($value['vuserid'] == '')) {
					$data['validation_error'][] = 'User ID Required';
					break;
				}

				if (!is_numeric($value['vuserid'])) {
					$data['validation_error'][] = 'Enter Numeric User ID';
					break;
				}

				if(strlen($value['vuserid']) < 3){
					$data['validation_error'][] = 'User ID must be three number ';
					break;
				}

				if (($value['vpassword'] == '')) {
					$data['validation_error'][] = 'Please Enter Password';
					break;
				}

				if(strlen($value['vpassword']) < 4){
					$data['validation_error'][] = 'Password must be four characters ';
					break;
				}

				if(strlen($value['vpassword']) > 4){
					$data['validation_error'][] = 'Password must be four characters ';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

					if(strlen($v['vuserid']) == 3){
						$unique_userid = $this->model_api_users->getUserID($v['vuserid']);

						$users_info = $this->model_api_users->getUser($v['iuserid']);
						
						if($v['vuserid'] != $users_info['vuserid']){
							if(count($unique_userid) > 0 ){
								$data['validation_error'][] = 'Entered the same user id';
								break;
							}else{
								$data = $this->model_api_users->editlistUsers($v['iuserid'],$v);
							}
							
						}else{
							$data = $this->model_api_users->editlistUsers($v['iuserid'],$v);
						}
					}else{
						$data['validation_error'][] = 'user id must be three digit';
						break;
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
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_users->getUsersSearch($search);

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
		$this->load->model('api/users');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['iuserid']))) {

			$data = $this->model_api_users->getUser($this->request->get['iuserid']);

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
