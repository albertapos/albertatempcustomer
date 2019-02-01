<?php
class ControllerApiPageFlowDetail extends Controller {
	private $error = array();

	public function index() {
		$data = array();
		$this->load->model('api/page_flow_detail');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !empty($this->request->get['MenuDetailId']) && !empty($this->request->get['PageId']) && !$this->user->verifyTokenExpired($this->request->get['token'])) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);

			$data = $this->model_api_page_flow_detail->getPageFlowDetail($this->request->get['MenuDetailId'],$this->request->get['PageId'],$db2);

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
