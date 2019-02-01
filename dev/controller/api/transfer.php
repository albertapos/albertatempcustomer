<?php
class ControllerApiTransfer extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/transfer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['vtransfertype'])) && (!empty($this->request->get['vvendorid']))) {

			if(in_array($this->request->get['vtransfertype'], array('WarehouseToStore','StoretoWarehouse','Storetostore'))){
				$data = $this->model_api_transfer->getTransfers($this->request->get['vtransfertype'],$this->request->get['vvendorid']);
				http_response_code(200);
			}else{
				$data['error'] = 'Transfer type not matched or missing vendor id';
				http_response_code(401);
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

	public function add() {

		$data = array();
		$this->load->model('api/transfer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vwhcode' => 'testing 1',
			// 					'vvendorid' => '104',
			// 					'dreceivedate' => '2017-04-05',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'WarehouseToStore',
			// 					'vinvnum' => '132564654',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '1230',
			// 								'vitemname' => 'test 1 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '1231',
			// 								'vitemname' => 'test 2 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'vwhcode' => 'testing 2',
			// 					'vvendorid' => '105',
			// 					'dreceivedate' => '2017-04-04',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'StoretoWarehouse',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '3214',
			// 								'vitemname' => 'test 3 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '2351',
			// 								'vitemname' => 'test 4 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);
			// $temp_arr[2] = array(
			// 					'vwhcode' => 'testing 3',
			// 					'vvendorid' => '106',
			// 					'dreceivedate' => '2017-04-03',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'Storetostore',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '5621',
			// 								'vitemname' => 'test 5 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '6548',
			// 								'vitemname' => 'test 6 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vtransfertype'] == ''){
					$data['validation_error'][] = 'Transfer Type Required';
					break;
				}

				if($value['vvendorid'] == ''){
					$data['validation_error'][] = 'Vendor ID Required';
					break;
				}

				if($value['dreceivedate'] == ''){
					$data['validation_error'][] = 'Transfer Date Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_transfer->addTransfer($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(500);
				}

			}else{
				http_response_code(401);
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

	public function edit_list() {

		$data = array();
		$this->load->model('api/transfer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vwhcode' => 'testing 1',
			// 					'vvendorid' => '104',
			// 					'dreceivedate' => '2017-04-10',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'WarehouseToStore',
			// 					'vinvnum' => '132564654',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '1230',
			// 								'vitemname' => 'test 1 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '25',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '1231',
			// 								'vitemname' => 'test 2 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '25',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'vwhcode' => 'testing 2',
			// 					'vvendorid' => '105',
			// 					'dreceivedate' => '2017-04-10',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'StoretoWarehouse',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '3214',
			// 								'vitemname' => 'test 3 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '25',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '2351',
			// 								'vitemname' => 'test 4 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '25',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);
			// $temp_arr[2] = array(
			// 					'vwhcode' => 'testing 3',
			// 					'vvendorid' => '106',
			// 					'dreceivedate' => '2017-04-10',
			// 					'estatus' => 'Open',
			// 					'vvendortype' => 'Vendor',
			// 					'vtransfertype' => 'Storetostore',
			// 					'items' => array(
			// 							array(
			// 								'vbarcode' => '5621',
			// 								'vitemname' => 'test 5 item',
			// 								'nitemqoh' => '5',
			// 								'npackqty' => '2',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								),
			// 							array(
			// 								'vbarcode' => '6548',
			// 								'vitemname' => 'test 6 item',
			// 								'nitemqoh' => '4',
			// 								'npackqty' => '1',
			// 								'vsize' => '23',
			// 								'ntransferqty' => '10'
			// 								)
			// 						)
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['vtransfertype'] == ''){
					$data['validation_error'][] = 'Transfer Type Required';
					break;
				}

				if($value['vvendorid'] == ''){
					$data['validation_error'][] = 'Vendor ID Required';
					break;
				}

				if($value['dreceivedate'] == ''){
					$data['validation_error'][] = 'Transfer Date Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_transfer->editlistTransfer($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(500);
				}

			}else{
				http_response_code(401);
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

	public function delete_transfer_item() {

		$data = array();
		$this->load->model('api/transfer');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			// $temp_arr[0] = array(
			// 					'vtransfertype' => 'WarehouseToStore',
			// 					'vvendorid' => '104',
			// 					'vbarcode' => '1230',
			// 					'dreceivedate' => '04-05-2017'
			// 				);
			// $temp_arr[1] = array(
			// 					'vtransfertype' => 'Storetostore',
			// 					'vvendorid' => '106',
			// 					'vbarcode' => '5621',
			// 					'dreceivedate' => '04-03-2017'
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				if($value['vtransfertype'] == ''){
					$data['validation_error'][] = 'Transfer Type Required';
					break;
				}

				if($value['vvendorid'] == ''){
					$data['validation_error'][] = 'Vendor ID Required';
					break;
				}

				if($value['vbarcode'] == ''){
					$data['validation_error'][] = 'SKU Required';
					break;
				}

				if($value['dreceivedate'] == ''){
					$data['validation_error'][] = 'Transfer Date Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {
					
				$data = $this->model_api_transfer->deleteTransferProduct($v['vtransfertype'],$v['vvendorid'],$v['vbarcode'],$v['dreceivedate']);

				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(500);
				}

			}else{
				http_response_code(401);
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
