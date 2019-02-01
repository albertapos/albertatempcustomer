<?php
class ControllerApiStoreSetting extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/store_setting');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_store_setting->getStoreSettings();

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

	public function edit_list() {

		$data = array();
		$this->load->model('api/store_setting');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr = array(
			// 					'RequiredPassword' => 'No',
			// 					'SameProduct' => 'Yes',
			// 					'Geographical Information' => 'None',
			// 					'Allowdiscountlessthencostprice' => 'Yes',
			// 					'AllowUpdateQoh' => 'No',
			// 					'StoreTime' => '09:00,10',
			// 					'Defaultageverificationdate' => '02-23-2017',
			// 					'Tax1seletedfornewItem' => 'No',
			// 					'ShowlowlevelInventory' => 'No',
			// 					'AskBeginningbalanceindollar' => 'Yes',
			// 					'AskReasonforvoidtransaction' => 'No',
			// 					'Updateallregisterquickitemonce' => 'No',
			// 					'AskItemPriceConfirmation' => '0',
			// 					'Showquotation' => 'No',
			// 					'QutaInventory' => 'No',
			// 					'QutaTax' => 'Yes',
			// 					'Dobackupwhenlogin' => 'No',
			// 					'AlertEmail' => '',
			// 					'ZeroItemPriceUpdate' => 'No',
			// 					'ShowChangeDuewnd' => 'No',
			// 					'EnableQuickItemScreen' => 'No',
			// 					'ZreportEmail' => 'test@test.com'
			// 				);

			$data = $this->model_api_store_setting->editlistStoreSettings($temp_arr);

			if(array_key_exists("success",$data)){
				http_response_code(200);
			}else{
				http_response_code(500);
			}

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
