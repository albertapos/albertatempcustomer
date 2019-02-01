<?php
class ControllerApiCustomerReport extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/customer_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_customer_report->getCustomers();

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
		$this->load->model('api/customer_report');
		$this->load->model('api/store');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$icustomerid = $temp_arr['icustomerid'];

			$data['store_info'] = $this->model_api_store->getStore();
	
			$data['sales_tender'] = $this->model_api_customer_report->getCustomerPay($icustomerid);

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
