<?php
class ControllerApiInventoryDashboard extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/inventory_dashboard');

		if ($this->session->data['token'] == $this->request->get['token']) {

			$data = $this->model_api_inventory_dashboard->last10PhysicalInventories();
			
			if(count($data) > 0)
			{
				http_response_code(200);
			}else{
				$data['error'] = 'Not Found';
				http_response_code(404);
			}
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Unauthorized';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
}
