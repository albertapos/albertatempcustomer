<?php
class ControllerApiTemplate extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_template->getTemplates();

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
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vtemplatename' => 'testing 1',
			// 					'vtemplatetype' => 'PO',
			// 					'vinventorytype' => 'Daily',
			// 					'isequence' => '1',
			// 					'estatus' => 'Active',
			// 					'items' =>array(
			// 							array(
			// 								'vitemcode' => '12',
			// 								'isequence' => '1'
			// 								),
			// 							array(
			// 								'vitemcode' => '21',
			// 								'isequence' => '2'
			// 								),
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'vtemplatename' => 'testing 2',
			// 					'vtemplatetype' => 'PO',
			// 					'vinventorytype' => 'Daily',
			// 					'isequence' => '2',
			// 					'estatus' => 'Active',
			// 					'items' =>array(
			// 							array(
			// 								'vitemcode' => '22',
			// 								'isequence' => '3'
			// 								),
			// 							array(
			// 								'vitemcode' => '23',
			// 								'isequence' => '4'
			// 								),
			// 						)
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vtemplatename'] == ''){
					$data['validation_error'][] = 'Template Name Required';
					break;
				}

				if($value['vtemplatetype'] == ''){
					$data['validation_error'][] = 'Template Type Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_template->addTemplate($temp_arr);

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
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'itemplateid' => '1',
			// 					'vtemplatename' => 'testing 11',
			// 					'vtemplatetype' => 'PO',
			// 					'vinventorytype' => 'Daily',
			// 					'isequence' => '1',
			// 					'estatus' => 'Active',
			// 					'items' =>array(
			// 							array(
			// 								'vitemcode' => '12',
			// 								'isequence' => '1'
			// 								),
			// 							array(
			// 								'vitemcode' => '21',
			// 								'isequence' => '2'
			// 								),
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'itemplateid' => '2',
			// 					'vtemplatename' => 'testing 22',
			// 					'vtemplatetype' => 'PO',
			// 					'vinventorytype' => 'Daily',
			// 					'isequence' => '2',
			// 					'estatus' => 'Active',
			// 					'items' =>array(
			// 							array(
			// 								'vitemcode' => '22',
			// 								'isequence' => '3'
			// 								),
			// 							array(
			// 								'vitemcode' => '23',
			// 								'isequence' => '4'
			// 								),
			// 						)
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['itemplateid'] == ''){
					$data['validation_error'][] = 'Template ID Required';
					break;
				}

				if($value['vtemplatename'] == ''){
					$data['validation_error'][] = 'Template Name Required';
					break;
				}

				if($value['vtemplatetype'] == ''){
					$data['validation_error'][] = 'Template Type Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_template->editlistTemplate($temp_arr);

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
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_template->getTemplateSearch($search);

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
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['itemplateid']))) {

			$data = $this->model_api_template->getTemplate($this->request->get['itemplateid']);

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

	public function delete_template_item() {

		$data = array();
		$this->load->model('api/template');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'itemplateid' => '1',
			// 					'Id' => '1'
			// 				);
			// $temp_arr[1] = array(
			// 					'itemplateid' => '2',
			// 					'Id' => '3'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['itemplateid'] == ''){
					$data['validation_error'][] = 'Template Id Required';
					break;
				}

				if($value['Id'] == ''){
					$data['validation_error'][] = 'Template Details ID Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {
					
				$data = $this->model_api_template->deleteTemplateProduct($v['itemplateid'],$v['Id']);

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
