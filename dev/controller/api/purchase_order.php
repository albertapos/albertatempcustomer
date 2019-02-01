<?php
class ControllerApiPurchaseOrder extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			$data = $this->model_api_purchase_order->getPurchaseOrders();

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
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr = Array
			// 			(
			// 			    "vinvoiceno" => "test 111",
			// 			    "dcreatedate" => "05-29-2017",
			// 			    "vponumber" => "000000108",
			// 			    "dreceiveddate" => "05-29-2017",
			// 			    "vordertitle" => "Test Title",
			// 			    "estatus" => "Close",
			// 			    "vorderby" => "Test Order By",
			// 			    "vconfirmby" => "Test Confirm By",
			// 			    "vnotes" => "Test Notes",
			// 			    "vshipvia" => "Test Ship Via",
			// 			    "vvendorid" => "101",
			// 			    "vvendorname" => "General Vendor",
			// 			    "vvendoraddress1" => "--",
			// 			    "vvendoraddress2" => "",
			// 			    "vvendorstate" => "--",
			// 			    "vvendorzip" => "--",
			// 			    "vvendorphone" => "",
			// 			    "vshpid" => "101",
			// 			    "vshpname" => "STEVENS DELI & LIQUOR",
			// 			    "vshpaddress1" => "250 NORTH STEVENS AVENUE",
			// 			    "vshpaddress2" => "",
			// 			    "vshpstate" => "FL",
			// 			    "vshpzip" => "08879",
			// 			    "vshpphone" => "732-721-0982",
			// 			    "nsubtotal" => "0.00",
			// 			    "ntaxtotal" => "0.00",
			// 			    "nfreightcharge" => "0.00",
			// 			    "ndeposittotal" => "0.00",
			// 			    "nreturntotal" => "0.00",
			// 			    "ndiscountamt" => "0.00",
			// 			    "nripsamt" => "0.00",
			// 			    "nnettotal" => "0.00",
			// 			    "items" => Array
			// 			        (
			// 			            '0' => Array
			// 			                (
			// 			                    "vitemid" => "2781",
			// 			                    "nordunitprice" => "94.50",
			// 			                    "vunitcode" => "UNT001",
			// 			                    "vunitname" => "Each2",
			// 			                    "ipodetid" => "0",
			// 			                    "vbarcode" => "2pk",
			// 			                    "vitemname" => "2pk",
			// 			                    "vvendoritemcode" => "1234567",
			// 			                    "vsize" => "",
			// 			                    "nordqty" => "0",
			// 			                    "npackqty" => "20",
			// 			                    "itotalunit" => "0",
			// 			                    "nordextprice" => "0.0000",
			// 			                    "nunitcost" => "0.0000"
			// 			                )

			// 			        )

			// 			);


			if($temp_arr['vinvoiceno'] == ''){
				$data['validation_error'][] = 'Invoice Required';
			}

			if($temp_arr['vponumber'] == ''){
				$data['validation_error'][] = 'Number Required';
			}

			$check = $this->model_api_purchase_order->checkExistInvoice($temp_arr['vinvoiceno']);

			if(isset($check['error'])){
				$data['validation_error'][] = $check['error'];
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_purchase_order->addPurchaseOrder($temp_arr);

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
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr = Array
			// 			(
			// 			    "ipoid" => "107",
			// 			    "vinvoiceno" => "Test 11",
			// 			    "dcreatedate" => "05-25-2017",
			// 			    "vponumber" => "000000016",
			// 			    "dreceiveddate" => "05-27-2017",
			// 			    "vordertitle" => "Testing 1",
			// 			    "estatus" => "Close",
			// 			    "vorderby" => "Test Order By",
			// 			    "vconfirmby" => "Test Confirm By",
			// 			    "vnotes" => "Test Notes",
			// 			    "vshipvia" => "Test Ship Via",
			// 			    "vvendorid" => "101",
			// 			    "vvendorname" => "General Vendor",
			// 			    "vvendoraddress1" => "--",
			// 			    "vvendoraddress2" => "",
			// 			    "vvendorstate" => "--",
			// 			    "vvendorzip" => "--",
			// 			    "vvendorphone" => "",
			// 			    "vshpid" => "101",
			// 			    "vshpname"=> "STEVENS DELI & LIQUOR",
			// 			    "vshpaddress1" => "250 NORTH STEVENS AVENUE",
			// 			    "vshpaddress2" => "",
			// 			    "vshpstate" => "FL",
			// 			    "vshpzip" => "08879",
			// 			    "vshpphone" => "732-721-0982",
			// 			    "nsubtotal" => "2400.00",
			// 			    "ntaxtotal" => "0.00",
			// 			    "nfreightcharge" => "0.00",
			// 			    "ndeposittotal" => "0.00",
			// 			    "nreturntotal"=> "0.00",
			// 			    "ndiscountamt" => "0.00",
			// 			    "nripsamt" => "20.00",
			// 			    "nnettotal" => "2380.00",

			// 			    "items" => Array
			// 			        (
			// 			            '0' => Array
			// 			                (
			// 			                    "vitemid" => "1969",
			// 			                    "nordunitprice" => "10.99",
			// 			                    "vunitcode" => "UNT001",
			// 			                    "vunitname" => "Each2",
			// 			                    "ipodetid" => "2633",
			// 			                    "vbarcode" => "01820000964",
			// 			                    "vitemname" => "NATURAL ICE 12PK CN",
			// 			                    "vvendoritemcode" => "12611",
			// 			                    "vsize" => "12 OZ ",
			// 			                    "nordqty" => "10.00",
			// 			                    "npackqty" => "2",
			// 			                    "itotalunit" => "20",
			// 			                    "nordextprice" => "400.0000",
			// 			                    "nunitcost" => "20.0000"
			// 			                ),

			// 			            '1' => Array
			// 			                (
			// 			                    "vitemid" => "2781",
			// 			                    "nordunitprice" => "94.50",
			// 			                    "vunitcode" => "UNT001",
			// 			                    "vunitname" => "Each2",
			// 			                    "ipodetid" => "2631",
			// 			                    "vbarcode" => "2pk",
			// 			                    "vitemname" => "2pk",
			// 			                    "vvendoritemcode" => "123",
			// 			                    "vsize" => "",
			// 			                    "nordqty" => "20.00",
			// 			                    "npackqty" => "10",
			// 			                    "itotalunit" => "200",
			// 			                    "nordextprice" => "2000.0000",
			// 			                    "nunitcost" => "10.0000"
			// 			                )

			// 			        )

			// 			);

			if($temp_arr['ipoid'] == ''){
				$data['validation_error'][] = 'Purchase Order Id Required';
			}

			if($temp_arr['vinvoiceno'] == ''){
				$data['validation_error'][] = 'Invoice Required';
			}

			if($temp_arr['vponumber'] == ''){
				$data['validation_error'][] = 'Number Required';
			}

			if(isset($temp_arr['items']) && count($temp_arr['items']) > 0){
				foreach ($temp_arr['items'] as $key => $value) {
					if($value['ipodetid'] == ''){
						$data['validation_error'][] = 'Purchase Order Item Id Required';
						break;
					}
				}
			}

			
			if(!array_key_exists("validation_error",$data)){

				$purchase_info = $this->model_api_purchase_order->getPurchaseOrder($temp_arr['ipoid']);
				if($purchase_info['vinvoiceno'] != $temp_arr['vinvoiceno']){
					$check = $this->model_api_purchase_order->checkExistInvoice($temp_arr['vinvoiceno']);

					if(isset($check['error'])){
						$data['error'] = $check['error'];
					}
				}else{
					$data['success'] = "success";
				}

				if(array_key_exists("success",$data)){

					$data = $this->model_api_purchase_order->editPurchaseOrder($temp_arr);
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

	public function edit() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['ipoid']))) {

			$data = $this->model_api_purchase_order->getPurchaseOrder($this->request->get['ipoid']);

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

	public function check_invoice() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST') ) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if($temp_arr['invoice'] == ''){
				$data['validation_error'] = 'Invoice Required';
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_purchase_order->checkExistInvoice($temp_arr['invoice']);

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
			$data['error'] = 'Something went wrong missing token or sid or search field';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}

	public function delete_purchase_order_item() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
		
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_purchase_order->deleteItemPurchase($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(401);
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

	public function import_invoice() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

            foreach ($temp_arr as $key => $value) {
				if($value['vinvoiceno'] == ''){
					$data['validation_error'][] = 'Invoice Number Required';
					break;
				}

				if($value['vvendorid'] == ''){
					$data['validation_error'][] = 'Missing Vendor Id';
					break;
				}

				$dtCh = $this->model_api_purchase_order->GetPurchaseOrderByInvoice($value['vinvoiceno']);

				if(count($dtCh) > 0){
					$data['validation_error'][] = 'Invoice Number '.$value['vinvoiceno'].' already Exist';
					break;
            	}
			}
		
			if(!array_key_exists("validation_error",$data)){

				$vcategory = $this->model_api_purchase_order->getCategories();
	            if(count($vcategory) > 0){
	            	$vcatcode = $vcategory[0]['vcategorycode'];
	            }else{
	            	$vcatcode = '1';
	            }

	            $vdepartment = $this->model_api_purchase_order->getDepartments();
	            if(count($vdepartment) > 0){
	            	$vdepcode = $vdepartment[0]['vdepcode'];
	            }else{
	            	$vdepcode = '1';
	            }

	            $dtVend = $this->model_api_purchase_order->getTax1();
	            if(count($dtVend) > 0){
	            	$vtax1 = "Y";
	            }else{
	            	$vtax1 = "N";
	            }

				foreach ($temp_arr as $key => $value) {
					$invoicenumber = $value['vinvoiceno'];

					$DTVENDOR = $this->model_api_purchase_order->getVendor($value['vvendorid']);

					$trnPurchaseorderdto = array();

                    $trnPurchaseorderdto['vvendorname'] = $DTVENDOR['vcompanyname'];
                    $trnPurchaseorderdto['nripsamt'] = 0;
                    $trnPurchaseorderdto['dduedatetime'] = $value['dduedatetime'];
                    $trnPurchaseorderdto['nsubtotal'] = 0;
                    $trnPurchaseorderdto['nreturntotal'] = 0;
                    $trnPurchaseorderdto['nrectotal'] = 0;
                    $trnPurchaseorderdto['ndeposittotal'] = 0;
                    $trnPurchaseorderdto['ndiscountamt'] = 0;
                    $trnPurchaseorderdto['vinvoiceno'] = $invoicenumber;
                    $trnPurchaseorderdto['vponumber'] = $invoicenumber;
                    $trnPurchaseorderdto['vrefnumber'] = $invoicenumber;
                    $trnPurchaseorderdto['nnettotal'] = $value['nnettotal'];
                    $trnPurchaseorderdto['ntaxtotal'] = 0;
                    $trnPurchaseorderdto['dcreatedate'] = $value['dcreatedate'];
                    $trnPurchaseorderdto['estatus'] = "Open";
                    $trnPurchaseorderdto['nfreightcharge'] = 0;
                    $trnPurchaseorderdto['vvendoraddress1'] = $DTVENDOR['vaddress1'];
                    $trnPurchaseorderdto['vvendoraddress2'] = '';
                    $trnPurchaseorderdto['vvendorid'] = $DTVENDOR['isupplierid'];
                    $trnPurchaseorderdto['vvendorstate'] = $DTVENDOR['vstate'];
                    $trnPurchaseorderdto['vvendorzip'] = $DTVENDOR['vzip'];
                    $trnPurchaseorderdto['vvendorphone'] = $DTVENDOR['vphone'];
                    $trnPurchaseorderdto['vordertitle'] = '';
                    $trnPurchaseorderdto['vordertype'] = "";
                    $trnPurchaseorderdto['vconfirmby'] = "";
                    $trnPurchaseorderdto['vorderby'] = "";
                    $trnPurchaseorderdto['vshpid'] = "0";
                    $trnPurchaseorderdto['vshpname'] = "";
                    $trnPurchaseorderdto['vshpaddress1'] = "";
                    $trnPurchaseorderdto['vshpaddress2'] = "";
                    $trnPurchaseorderdto['vshpzip'] = "";
                    $trnPurchaseorderdto['vshpstate'] ="";
                    $trnPurchaseorderdto['vshpphone'] = "";
                    $trnPurchaseorderdto['vshipvia'] = "";
                    $trnPurchaseorderdto['vnotes'] = "";

                    $poid = $this->model_api_purchase_order->insertPurchaseOrder($trnPurchaseorderdto);

                    if(isset($value['items']) && count($value['items']) > 0){
                    	foreach ($value['items'] as $k => $v) {
                    		$dtC = $this->model_api_purchase_order->getItemByBarCode($v['vCode']);

                    		if(count($dtC) > 0){
                            	$iitemid = $dtC["iitemid"];
                            	$dtI = $this->model_api_purchase_order->getItemVendorByVendorItemCode($v['vvendoritemcode']);
                            	if(count($dtI) == 0){
                            		$mstItemVendorDto = array();
                            		$mstItemVendorDto['iitemid'] = $iitemid;
                            		$mstItemVendorDto['ivendorid'] = $value['vvendorid'];
                            		$mstItemVendorDto['vvendoritemcode'] = $v['vvendoritemcode'];

                            		$this->model_api_purchase_order->insertItemVendor($mstItemVendorDto);
                            	}

                            	$trnPurchaseOrderDetaildto = array();
                            	$trnPurchaseOrderDetaildto['npackqty'] = (int)$v['npack'];
                                $trnPurchaseOrderDetaildto['vbarcode'] = $v['vCode'];

                                $trnPurchaseOrderDetaildto['ipoid'] = (int)$poid;
                                $trnPurchaseOrderDetaildto['vitemid'] = (string)$iitemid;
                                $trnPurchaseOrderDetaildto['vitemname'] = $v['vname'];
                                $trnPurchaseOrderDetaildto['vunitname'] = "Each";
                                $trnPurchaseOrderDetaildto['nordqty'] = $v['qtyor'];
                                $trnPurchaseOrderDetaildto['nordunitprice'] = $v['nCost'];
                                $trnPurchaseOrderDetaildto['nordextprice'] = $v['totAmt'];
                                $trnPurchaseOrderDetaildto['nordtax'] = 0;
                                $trnPurchaseOrderDetaildto['nordtextprice'] = 0;
                                $trnPurchaseOrderDetaildto['vvendoritemcode'] = (string)$v['vvendoritemcode'];
                                $trnPurchaseOrderDetaildto['nunitcost'] = $v['unitcost'];

                                $trnPurchaseOrderDetaildto['itotalunit'] = (int)$v['itotalunit'];
                                $trnPurchaseOrderDetaildto['vsize'] = "";

                                $this->model_api_purchase_order->InsertPurchaseDetail($trnPurchaseOrderDetaildto);

                            }else{

                            	$mst_missingitemDTO = array();
                            	$mst_missingitemDTO['norderqty'] = (int)$v['qtyor'];
                                $mst_missingitemDTO['vvendoritemcode'] = $v['vvendoritemcode'];
                                $mst_missingitemDTO['iinvoiceid'] = $poid;
                                $mst_missingitemDTO['vbarcode'] = $v['vCode'];
                                $mst_missingitemDTO['vitemname'] = $v['vname'];
                                $mst_missingitemDTO['nsellunit'] = 1;
                                $mst_missingitemDTO['dcostprice'] = $v['nCost'];
                                $mst_missingitemDTO['dunitprice'] = $v['rPrice'];

                                $mst_missingitemDTO['vcatcode'] = $vcatcode;
                                $mst_missingitemDTO['vdepcode'] = $vdepcode;
                                $mst_missingitemDTO['vsuppcode'] = $value['vvendorid'];
                                $mst_missingitemDTO['vtax1'] = $vtax1;
                                $mst_missingitemDTO['vitemtype'] = "Standard";
                                $mst_missingitemDTO['npack'] = (int)$v['npack'];
                                $mst_missingitemDTO['vitemcode'] = $v['vCode'];
                                $mst_missingitemDTO['vunitcode'] = "UNT001";
                                $mst_missingitemDTO['nunitcost'] = $v['unitcost'];

                                $this->model_api_purchase_order->createMissingitem($mst_missingitemDTO);
                            	
                            }
                    	}
                    }

                    $this->model_api_purchase_order->updatePurchaseOrderReturnTotal($value['nReturnTotal'],$poid);

				}
				$data['success'] = 'Successfully Imported Invoice!';

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(401);
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

	public function import_missing_items() {

		$data = array();
		$this->load->model('api/purchase_order');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if(count($temp_arr) <= 0){
				$data['validation_error'] = 'Missing id of missing items';
			}
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_purchase_order->importMissingItems($temp_arr);

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}else{
					http_response_code(401);
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
