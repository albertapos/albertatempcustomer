<?php
class ControllerApiPoHistoryReport extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->model('api/po_history_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $temp_arr = json_decode(file_get_contents('php://input'), true);
            
            if(in_array('ALL', $temp_arr['report_by'])){
                $data = $this->model_api_po_history_report->getPoHistoryReportAll($temp_arr);
            }else{
                $data = $this->model_api_po_history_report->getPoHistoryReport($temp_arr);
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

    public function view_item() {
        $this->load->model('api/po_history_report');

        if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && !empty($this->request->get['vendor_id']) && !empty($this->request->get['vendor_date'])) {

            $data = $this->model_api_po_history_report->getViewItems($this->request->get['vendor_id'],$this->request->get['vendor_date']);

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
