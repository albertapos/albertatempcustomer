<?php
class ControllerApiItemsSale extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/items/sale');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_items_sale->getSales();

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
		$this->load->model('api/items/sale');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if($temp_arr['vsalename'] == ''){
				$data['validation_error'][] = 'Sale Name Required';
			}

			if($temp_arr['vsaletype'] == ''){
				$data['validation_error'][] = 'Sale type Required';
			}

			if($temp_arr['vsaleby'] == ''){
				$data['validation_error'][] = 'Sale By Required';
			}

			if(count($temp_arr['items']) > 0){
				foreach ($temp_arr['items'] as $key => $value) {
					if($value['vitemcode'] == ''){
						$data['validation_error'][] = 'Item Code Required';
					}

					if($value['vunitcode'] == ''){
						$data['validation_error'][] = 'Unit Code Required';
					}

					if($value['vitemtype'] == ''){
						$data['validation_error'][] = 'Item Type Required';
					}

					if($value['iitemid'] == ''){
						$data['validation_error'][] = 'Item Id Required';
					}

					if($value['Id'] == ''){
						$data['validation_error'][] = 'Id Required';
					}

					if($value['vitemname'] == ''){
						$data['validation_error'][] = 'Item Name Required';
					}

					if($value['dunitprice'] == ''){
						$data['validation_error'][] = 'Unit Price Required';
					}

					if($value['nsaleprice'] == ''){
						$data['validation_error'][] = 'Sale Price Required';
					}

					if($value['vitemcode'] == '' || $value['vunitcode'] == '' || $value['vitemtype'] == '' || $value['iitemid'] == '' || $value['Id'] == '' || $value['vitemname'] == '' || $value['dunitprice'] == '' || $value['nsaleprice'] == ''){
						break;
					}
				}
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items_sale->addSaleItems($temp_arr);

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

	public function edit() {

		$data = array();
		$this->load->model('api/items/sale');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if($temp_arr['isalepriceid'] == ''){
				$data['validation_error'][] = 'Sale Id Required';
			}

			if($temp_arr['vsalename'] == ''){
				$data['validation_error'][] = 'Sale Name Required';
			}

			if($temp_arr['vsaletype'] == ''){
				$data['validation_error'][] = 'Sale type Required';
			}

			if($temp_arr['vsaleby'] == ''){
				$data['validation_error'][] = 'Sale By Required';
			}

			if(count($temp_arr['items']) > 0){
				foreach ($temp_arr['items'] as $key => $value) {
					if($value['vitemcode'] == ''){
						$data['validation_error'][] = 'Item Code Required';
					}

					if($value['vunitcode'] == ''){
						$data['validation_error'][] = 'Unit Code Required';
					}

					if($value['vitemtype'] == ''){
						$data['validation_error'][] = 'Item Type Required';
					}

					if($value['iitemid'] == ''){
						$data['validation_error'][] = 'Item Id Required';
					}

					if($value['Id'] == ''){
						$data['validation_error'][] = 'Id Required';
					}

					if($value['vitemname'] == ''){
						$data['validation_error'][] = 'Item Name Required';
					}

					if($value['dunitprice'] == ''){
						$data['validation_error'][] = 'Unit Price Required';
					}

					if($value['nsaleprice'] == ''){
						$data['validation_error'][] = 'Sale Price Required';
					}

					if($value['vitemcode'] == '' || $value['vunitcode'] == '' || $value['vitemtype'] == '' || $value['iitemid'] == '' || $value['Id'] == '' || $value['vitemname'] == '' || $value['dunitprice'] == '' || $value['nsaleprice'] == ''){
						break;
					}
				}
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items_sale->editlistSaleItems($temp_arr);

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
		$this->load->model('api/items/sale');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_items_sale->getSaleSearch($search);

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
