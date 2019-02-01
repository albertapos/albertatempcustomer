<?php
class ControllerApiProfitLoss extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->model('api/profit_loss');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

        $temp_arr = json_decode(file_get_contents('php://input'), true);
                
        if($temp_arr['report_by'] == 1){
          $data = $this->model_api_profit_loss->getCategoriesReport($temp_arr);
        }elseif($temp_arr['report_by'] == 2){
          $data = $this->model_api_profit_loss->getDepartmentsReport($temp_arr);
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
