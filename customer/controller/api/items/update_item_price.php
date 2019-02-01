<?php
class ControllerApiItemsUpdateItemPrice extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/items/update_item_price');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_items_update_item_price->getItems();

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
		$this->load->model('api/items/update_item_price');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			foreach ($temp_arr as $key => $value) {

				if($value['iitemid'] == ''){
					$data['validation_error'][] = 'Item Id Required';
				}

				if($value['dcostprice'] == ''){
					$data['validation_error'][] = 'Item Cost price Required';
				}

				if($value['dunitprice'] == ''){
					$data['validation_error'][] = 'Item Unit Price Required';
				}

				if($value['vtax1'] == ''){
					$data['validation_error'][] = 'Item Tax 1 Required';
				}

				if($value['vtax2'] == ''){
					$data['validation_error'][] = 'Item Tax 2 Required';
				}

				if($value['iitemid'] == '' || $value['dcostprice'] == '' || $value['dunitprice'] == '' || $value['vtax1'] == '' || $value['vtax2'] == ''){
					break;
				}
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items_update_item_price->editlistItems($temp_arr);

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
		$this->load->model('api/items/update_item_price');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_items_update_item_price->getItems($temp_arr);

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
