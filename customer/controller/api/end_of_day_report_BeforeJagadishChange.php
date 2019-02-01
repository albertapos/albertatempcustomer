<?php
class ControllerApiEndOfDayReport extends Controller {
	private $error = array();

	public function index() {

		$this->load->model('api/end_of_day_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $temp_arr = json_decode(file_get_contents('php://input'), true);
            
            $data['report_hourly_sales'] = $this->model_api_end_of_day_report->getHourlySalesReport($temp_arr);

            $data['report_categories'] = $this->model_api_end_of_day_report->getCategoriesReport($temp_arr);

            $data['report_departments'] = $this->model_api_end_of_day_report->getDepartmentsReport($temp_arr);

            $data['report_shifts'] = $this->model_api_end_of_day_report->getShiftsReport($temp_arr);

            $data['report_tenders'] = $this->model_api_end_of_day_report->getTenderReport($temp_arr);

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
