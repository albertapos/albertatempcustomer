<?php
class ControllerApiTransactions extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/transactions');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_transactions->getSalesReport($temp_arr);

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

	public function print_data() {

		$data = array();
		$this->load->model('api/transactions');
		$this->load->model('api/store');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$salesid = $temp_arr['salesid'];

			$data['store_info'] = $this->model_api_store->getStore();
	
			$data['sales_header'] = $this->model_api_transactions->getSalesById($salesid);

			$data['sales_detail'] = $this->model_api_transactions->getSalesPerview($salesid);
			
			$data['sales_tender'] = $this->model_api_transactions->getSalesByTender($salesid);

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid or search field';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
}
