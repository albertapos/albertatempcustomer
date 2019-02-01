<?php
class ControllerApiCategory extends Controller {
	private $error = array();

	public function index() {
		$data = array();
		$this->load->model('api/category');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_category->getCategories();

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

	public function category_by_menu() {
		$data = array();
		$this->load->model('api/category');

		if (($this->user->verifyUserToken($this->request->get['token']) == $this->request->get['token']) && ($this->user->verifyUserSID($this->request->get['token']) == $this->request->get['sid']) && !empty($this->request->get['MenuId']) && !$this->user->verifyTokenExpired($this->request->get['token'])) {

			$db2 = $this->user->storeDatabase($this->request->get['token']);

			$data = $this->model_api_category->getCategoriesByMenu($this->request->get['MenuId'],$db2);

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
