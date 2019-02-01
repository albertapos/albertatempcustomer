<?php
class ControllerApiHoldOrder extends Controller {
	private $error = array();

	public function index() {
		$data = array();
		$this->load->model('api/hold_order');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !$this->user->verifyTokenExpired($this->request->get['token']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);
			$sid = $this->request->get['sid'];

			$order_data = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_hold_order->getPageFlowHeaders($order_data,$db2,$sid);

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
