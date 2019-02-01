<?php
class ControllerApiPhysicalInventory extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_physical_inventory->getPhysicalInventories();

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

	public function add() {

		$data = array();
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr[0] = array(
			// 					'vpinvtnumber' => '000000002',
			// 					'vrefnumber' => '000000002',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Close',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Physical',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '620',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '621',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'vpinvtnumber' => '000000003',
			// 					'vrefnumber' => '000000003',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Close',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Adjustment',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '622',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 2',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '623',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 3',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);

			// $temp_arr[2] = array(
			// 					'vpinvtnumber' => '000000004',
			// 					'vrefnumber' => '000000004',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Close',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Waste',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '624',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 4',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '625',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 5',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);

	
			foreach ($temp_arr as $key => $value) {
				if($value['vpinvtnumber'] == ''){
					$data['validation_error'][] = 'Number Required';
					break;
				}

				if($value['dcreatedate'] == ''){
					$data['validation_error'][] = 'Created Date Required';
					break;
				}

				if($value['vtype'] == ''){
					$data['validation_error'][] = 'Type Required';
					break;
				}

				if($value['estatus'] == ''){
					$data['validation_error'][] = 'Status Required';
					break;
				}
				
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_physical_inventory->addPhysicalInventory($temp_arr);

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
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr[0] = array(
			// 					'ipiid' => '107',
			// 					'vpinvtnumber' => '000000002',
			// 					'vrefnumber' => '000000002',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Physical',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '620',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '621',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'ipiid' => '108',
			// 					'vpinvtnumber' => '000000003',
			// 					'vrefnumber' => '000000003',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Adjustment',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '622',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 2',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '623',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 3',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);

			// $temp_arr[2] = array(
			// 					'ipiid' => '109',
			// 					'vpinvtnumber' => '000000004',
			// 					'vrefnumber' => '000000004',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Waste',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '624',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 4',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '625',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 5',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);


			foreach ($temp_arr as $key => $value) {
				if($value['ipiid'] == ''){
					$data['validation_error'][] = 'Physical Inventory ID Required';
					break;
				}

				if($value['vpinvtnumber'] == ''){
					$data['validation_error'][] = 'Number Required';
					break;
				}

				if($value['dcreatedate'] == ''){
					$data['validation_error'][] = 'Created Date Required';
					break;
				}

				if($value['vtype'] == ''){
					$data['validation_error'][] = 'Type Required';
					break;
				}

				if($value['estatus'] == ''){
					$data['validation_error'][] = 'Status Required';
					break;
				}
				
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_physical_inventory->editlistPhsicalInventory($temp_arr);

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

	public function calculate_post() {

		$data = array();
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr[0] = array(
			// 					'ipiid' => '107',
			// 					'vpinvtnumber' => '000000002',
			// 					'vrefnumber' => '000000002',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Physical',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '620',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '621',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);
			// $temp_arr[1] = array(
			// 					'ipiid' => '108',
			// 					'vpinvtnumber' => '000000003',
			// 					'vrefnumber' => '000000003',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Adjustment',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '622',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 2',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '623',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 3',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);

			// $temp_arr[2] = array(
			// 					'ipiid' => '109',
			// 					'vpinvtnumber' => '000000004',
			// 					'vrefnumber' => '000000004',
			// 					'nnettotal' => '0.00',
			// 					'ntaxtotal' => '0.00',
			// 					'dcreatedate' => '2017-02-28 00:01:05',
			// 					'estatus' => 'Open',
			// 					'vordertitle' => '',
			// 					'vnotes' => '',
			// 					'dlastupdate' => '',
			// 					'vtype' => 'Waste',
			// 					'ilocid' => '-1',
			// 					'dcalculatedate' => '',
			// 					'dclosedate' => '',
			// 					'items' =>array(
			// 								array(
			// 									'vitemid' => '624',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 4',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								),
			// 								array(
			// 									'vitemid' => '625',
			// 									'vitemname' => 'WRIG ORBIT WHITE PEPPERMI 5',
			// 									'vunitcode' => '',
			// 									'vunitname' => 'Each',
			// 									'ndebitqty' => '0.00',
			// 									'ncreditqty' => '0.00',
			// 									'ndebitunitprice' => '6.33',
			// 									'ncrediteunitprice' => '0.00',
			// 									'nordtax' => '0.00',
			// 									'ndebitextprice' => '0.00',
			// 									'ncrditextprice' => '0.00',
			// 									'ndebittextprice' => '0.00',
			// 									'ncredittextprice' => '0.00',
			// 									'vbarcode' => '02200001344',
			// 									'vreasoncode' => '',
			// 									'ndiffqty' => '0.00',
			// 									'vvendoritemcode' => '',
			// 									'npackqty' => '8',
			// 									'nunitcost' => '0.7900',
			// 									'itotalunit' => '0'
			// 								)
			// 						)
			// 				);

			foreach ($temp_arr as $key => $value) {
				if($value['ipiid'] == ''){
					$data['validation_error'][] = 'Physical Inventory ID Required';
					break;
				}

				if($value['vpinvtnumber'] == ''){
					$data['validation_error'][] = 'Number Required';
					break;
				}

				if($value['dcreatedate'] == ''){
					$data['validation_error'][] = 'Created Date Required';
					break;
				}

				if($value['vtype'] == ''){
					$data['validation_error'][] = 'Type Required';
					break;
				}

				if($value['estatus'] == ''){
					$data['validation_error'][] = 'Status Required';
					break;
				}
				
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_physical_inventory->calclulatePost($temp_arr);

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

	public function search() {

		$data = array();
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_physical_inventory->getPhysicalInventorySearch($search);

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

	public function edit() {

		$data = array();
		$this->load->model('api/physical_inventory');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ipiid']))) {

			$data = $this->model_api_physical_inventory->getPhysicalInventory($this->request->get['ipiid']);

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
