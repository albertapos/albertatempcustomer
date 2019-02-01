<?php
class ControllerApiUserGroups extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/user_groups');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_user_groups->getUserGroups();

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

	public function all_permissions() {

		$data = array();
		$this->load->model('api/user_groups');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_user_groups->getAllPermissions();

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
		$this->load->model('api/user_groups');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'ipermissiongroupid' => '3',
			// 				    'vgroupname' => 'Cashier',
			// 				    'vpermissioncode' => Array
			// 				        (
			// 				            '0' => 'PER001',
			// 				            '1' => 'PER002',
			// 				            '2' => 'PER003',
			// 				            '3' => 'PER004',
			// 				            '4' => 'PER005',
			// 				            '5' => 'PER006',
			// 				            '6' => 'PER007',
			// 				            '7' => 'PER008',
			// 				            '8' => 'PER009',
			// 				            '9' => 'PER010',
			// 				            '10' => 'PER011',
			// 				            '11' => 'PER012',
			// 				            '12' => 'PER013',
			// 				            '13' => 'PER014',
			// 				            '14' => 'PER015',
			// 				            '15' => 'PER044',
			// 				            '16' => 'PER045',
			// 				            '17' => 'PER016',
			// 				            '18' => 'PER017',
			// 				            '19' => 'PER018',
			// 				            '20' => 'PER019',
			// 				            '21' => 'PER020',
			// 				            '22' => 'PER021',
			// 				            '23' => 'PER022',
			// 				            '24' => 'PER023',
			// 				            '25' => 'PER024',
			// 				            '26' => 'PER025',
			// 				            '27' => 'PER026',
			// 				            '28' => 'PER027',
			// 				            '29' => 'PER029',
			// 				            '30' => 'PER030',
			// 				            '31' => 'PER031',
			// 				            '32' => 'PER032',
			// 				            '33' => 'PER033',
			// 				            '34' => 'PER034',
			// 				            '35' => 'PER035',
			// 				            '36' => 'PER036',
			// 				            '37' => 'PER037',
			// 				            '38' => 'PER038',
			// 				            '39' => 'PER039',
			// 				            '40' => 'PER040',
			// 				            '41' => 'PER041',
			// 				            '42' => 'PER042',
			// 				            '43' => 'PER043',
			// 				            '44' => 'PER046',
			// 				            '45' => 'PER047',
			// 				            '46' => 'PER048',
			// 				            '47' => 'PER049',
			// 				            '48' => 'PER052',
			// 				            '49' => 'PER053',
			// 				            '50' => 'PER054',
			// 				            '51' => 'PER055',
			// 				            '52' => 'PER056',
			// 				            '53' => 'PER057',
			// 				            '54' => 'PER058',
			// 				            '55' => 'PER059',
			// 				            '56' => 'PER060',
			// 				            '57' => 'PER061',
			// 				            '58' => 'PER050',
			// 				            '59' => 'PER062',
			// 				            '60' => 'PER00074',
			// 				            '61' => 'PER00076',
			// 				            '62' => 'PER00080'
			// 				        ),

			// 				    'estatus' => 'Active'
			// 				);
			// $temp_arr[1] = array(
			// 					'ipermissiongroupid' => '1',
			// 				    'vgroupname' => 'Admin',
			// 				    'vpermissioncode' => Array
			// 				        (
			// 				            '0' => 'PER001',
			// 				            '1' => 'PER002',
			// 				            '2' => 'PER003',
			// 				            '3' => 'PER004',
			// 				            '4' => 'PER005',
			// 				            '5' => 'PER006',
			// 				            '6' => 'PER007',
			// 				            '7' => 'PER008',
			// 				            '8' => 'PER009',
			// 				            '9' => 'PER010',
			// 				            '10' => 'PER011',
			// 				            '11' => 'PER012',
			// 				            '12' => 'PER013',
			// 				            '13' => 'PER014',
			// 				            '14' => 'PER015',
			// 				            '15' => 'PER044',
			// 				            '16' => 'PER045',
			// 				            '17' => 'PER016',
			// 				            '18' => 'PER017',
			// 				            '19' => 'PER018',
			// 				            '20' => 'PER019',
			// 				            '21' => 'PER020',
			// 				            '22' => 'PER021',
			// 				            '23' => 'PER022',
			// 				            '24' => 'PER023',
			// 				            '25' => 'PER024',
			// 				            '26' => 'PER025',
			// 				            '27' => 'PER026',
			// 				            '28' => 'PER027',
			// 				            '29' => 'PER028',
			// 				            '30' => 'PER029',
			// 				            '31' => 'PER030',
			// 				            '32' => 'PER031',
			// 				            '33' => 'PER032',
			// 				            '34' => 'PER033',
			// 				            '35' => 'PER034',
			// 				            '36' => 'PER035',
			// 				            '37' => 'PER036',
			// 				            '38' => 'PER037',
			// 				            '39' => 'PER038',
			// 				            '40' => 'PER039',
			// 				            '41' => 'PER040',
			// 				            '42' => 'PER041',
			// 				            '43' => 'PER042',
			// 				            '44' => 'PER043',
			// 				            '45' => 'PER046',
			// 				            '46' => 'PER047',
			// 				            '47' => 'PER048',
			// 				            '48' => 'PER049',
			// 				            '49' => 'PER052',
			// 				            '50' => 'PER053',
			// 				            '51' => 'PER054',
			// 				            '52' => 'PER055',
			// 				            '53' => 'PER056',
			// 				            '54' => 'PER057',
			// 				            '55' => 'PER058',
			// 				            '56' => 'PER059',
			// 				            '57' => 'PER060',
			// 				            '58' => 'PER061',
			// 				            '59' => 'PER050',
			// 				            '60' => 'PER051',
			// 				            '61' => 'PER062',
			// 				            '62' => 'PER00085',
			// 				            '63' => 'PER00086',
			// 				            '64' => 'PER00087',
			// 				        ),

			// 				    'estatus' => 'Active'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['ipermissiongroupid'] == ''){
					$data['validation_error'][] = 'User Group ID Required';
					break;
				}

				if($value['vgroupname'] == ''){
					$data['validation_error'][] = 'User Group Name Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_user_groups->editlistUserGroups($temp_arr);

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
		$this->load->model('api/user_groups');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_user_groups->getUserGroupsSearch($search);

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
		$this->load->model('api/user_groups');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ipermissiongroupid']))) {

			$data = $this->model_api_user_groups->getUserGroup($this->request->get['ipermissiongroupid']);

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
