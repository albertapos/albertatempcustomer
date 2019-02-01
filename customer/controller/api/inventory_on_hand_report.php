<?php
class ControllerApiInventoryOnHandReport extends Controller {
	private $error = array();

	public function index() {

		$this->load->model('api/inventory_on_hand_report');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

        $temp_arr = json_decode(file_get_contents('php://input'), true);
                
        if($temp_arr['report_by'] == 1){
          $data = $this->model_api_inventory_on_hand_report->getCategoriesReport($temp_arr);
        }elseif($temp_arr['report_by'] == 2){
          $data = $this->model_api_inventory_on_hand_report->getDepartmentsReport($temp_arr);
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
	
}
