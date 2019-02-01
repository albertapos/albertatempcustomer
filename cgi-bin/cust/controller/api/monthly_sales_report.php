<?php
class ControllerApiMonthlySalesReport extends Controller {
	private $error = array();

	public function index() {

		$this->load->model('api/monthly_sales_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

        $temp_arr = json_decode(file_get_contents('php://input'), true);

        $data = $this->model_api_monthly_sales_report->getMonthlyReport($temp_arr);

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
