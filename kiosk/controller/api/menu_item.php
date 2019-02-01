<?php
class ControllerApiMenuItem extends Controller {
	private $error = array();

	public function index() {
		$data = array();
		$this->load->model('api/menu_item');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !empty($this->request->get['CategoryId']) && !empty($this->request->get['MenuId']) && !$this->user->verifyTokenExpired($this->request->get['token'])) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);

			$data = $this->model_api_menu_item->getMenuItems($this->request->get['CategoryId'],$this->request->get['MenuId'],$db2);

			http_response_code(200);
			$this->response->addHeader('Access-Control-Allow-Origin: *');
  			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
  			$this->response->addHeader('Access-Control-Max-Age: 1000');
  			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function item_show() {
		$data = array();
		$this->load->model('api/menu_item');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !$this->user->verifyTokenExpired($this->request->get['token'])) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);


			$data = $this->model_api_menu_item->getMenuItemImage($this->request->get['iitemid'],$db2);
			$imgstr = $data['image_string'];

			echo "<img src='data:image/jpg;base64,".$imgstr."' />";
			exit;

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
