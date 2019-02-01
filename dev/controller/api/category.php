<?php
class ControllerApiCategory extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_category->getCategories();

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
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vcategoryname' => 'test',
			// 					'vdescription' => 'testing 1',
			// 					'vcategorttype' => 'Sales',
			// 					'isequence' => '11'
			// 				);
			// $temp_arr[1] = array(
			// 					'vcategoryname' => 'test1',
			// 					'vdescription' => 'testing 2',
			// 					'vcategorttype' => 'MISC',
			// 					'isequence' => '12'
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vcategoryname'] == ''){
					$data['validation_error'][] = 'Category Name Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_category->addCategory($temp_arr);

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
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'icategoryid' => '118',
			// 					'vcategoryname' => 'test',
			// 					'vdescription' => 'testing 11',
			// 					'vcategorttype' => 'Sales',
			// 					'isequence' => '11'
			// 				);
			// $temp_arr[1] = array(
			// 					'icategoryid' => '119',
			// 					'vcategoryname' => 'test1',
			// 					'vdescription' => 'testing 22',
			// 					'vcategorttype' => 'MISC',
			// 					'isequence' => '12'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['vcategoryname'] == ''){
					$data['validation_error'][] = 'Category Name Required';
				}

				if($value['icategoryid'] == ''){
					$data['validation_error'][] = 'Category ID Required';
				}

				if($value['icategoryid'] == '' || $value['vcategoryname'] == ''){
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_category->editlistCategory($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
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
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_category->getCategoriesSearch($search);

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
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['icategoryid']))) {

			$data = $this->model_api_category->getCategory($this->request->get['icategoryid']);

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
