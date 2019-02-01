<?php
class ControllerApiMenuHeader extends Controller {
	private $error = array();

	public function index() {
		$data = array();
		$this->load->model('api/menu_header');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !$this->user->verifyTokenExpired($this->request->get['token'])) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);

			$data = $this->model_api_menu_header->getMenuHeaders($db2);

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
