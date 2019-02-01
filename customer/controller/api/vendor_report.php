<?php
class ControllerApiVendorReport extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/vendor_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_vendor_report->getVendorReport($temp_arr);

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
