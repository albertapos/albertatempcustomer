<?php
class ControllerApiItemsQuickItem extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/items/quick_item');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_items_quick_item->getItems();

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
		$this->load->model('api/items/quick_item');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$temp_name_arr = array();
			$temp_sequence_arr = array();
			
			foreach ($temp_arr as $key => $value) {
				if(in_array($value['vitemgroupname'], $temp_name_arr)){
					$data['validation_error'][] = 'Item group names are same!!!';
					break;
				}else{
					$temp_name_arr[] = $value['vitemgroupname'];
				}

				if(in_array($value['isequence'], $temp_sequence_arr)){
					$data['validation_error'][] = 'Item group sequence are same!!!';
					break;
				}else{
					$temp_sequence_arr[] = $value['isequence'];
				}

				if($value['iitemgroupid'] == ''){
					$data['validation_error'][] = 'Item Group Id Required';
				}

				if($value['vitemgroupname'] == ''){
					$data['validation_error'][] = 'Item Group Name Required';
				}

				if($value['isequence'] == ''){
					$data['validation_error'][] = 'Sequence Required';
				}

				if($value['iitemgroupid'] == '' || $value['vitemgroupname'] == '' || $value['isequence'] == ''){
					break;
				}
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items_quick_item->editlistItems($temp_arr);

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
		$this->load->model('api/items/quick_item');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_items_quick_item->getQuickItemSearch($search);

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
