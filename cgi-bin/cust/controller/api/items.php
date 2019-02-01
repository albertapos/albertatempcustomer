<?php
class ControllerApiItems extends Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			ini_set('memory_limit','512M');

			$data = $this->model_api_items->getItems();
			
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

	public function getChildItems() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

			ini_set('memory_limit','512M');

			$data = $this->model_api_items->getChildProductsLoad();
			
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
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr[0] = array(
			// 					"webstore" => "0",
			// 			        "vitemtype" => "Standard",
			// 			        "iitemgroupid" => "1",
			// 			        "vitemcode" => "8",
			// 			        "vitemname" => "Instant Lottery",
			// 			        "vunitcode" => "UNT001",
			// 			        "vbarcode" => "8",
			// 			        "vpricetype" => "",
			// 			        "vcategorycode" => "1",
			// 			        "vdepcode" => "1",
			// 			        "vsuppliercode" => "101",
			// 			        "iqtyonhand" => "0",
			// 			        "ireorderpoint" => "0",
			// 			        "dcostprice" => "0.0000",
			// 			        "dunitprice" => "0.00",
			// 			        "nsaleprice" => "0.0000",
			// 			        "nlevel2" => "0.00",
			// 			        "nlevel3" => "0.00",
			// 			        "nlevel4" => "0.00",
			// 			        "iquantity" => "0",
			// 			        "ndiscountper" => "0.00",
			// 			        "ndiscountamt" => "0.00",
			// 			        "vtax1" => "N",
			// 			        "vtax2" => "N",
			// 			        "vfooditem" => "Y",
			// 			        "vdescription" => "",
			// 			        "dlastsold" => null,
			// 			        "visinventory" => "No",
			// 			        "dpricestartdatetime" => null,
			// 			        "dpriceenddatetime" => null,
			// 			        "estatus" => "Active",
			// 			        "nbuyqty" => "0",
			// 			        "ndiscountqty" => "0",
			// 			        "nsalediscountper" => "0.00",
			// 			        "vshowimage" => "Yes",
			// 			        "itemimage" => "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",
			// 			        "vageverify" => "0",
			// 			        "ebottledeposit" => "No",
			// 			        "nbottledepositamt" => "0.00",
			// 			        "vbarcodetype" => "Code 128",
			// 			        "ntareweight" => "0.00",
			// 			        "ntareweightper" => "0.00",
			// 			        "dcreated" => null,
			// 			        "dlastupdated" => "2017-02-22",
			// 			        "dlastreceived" => null,
			// 			        "dlastordered" => null,
			// 			        "nlastcost" => "0.00",
			// 			        "nonorderqty" => "0",
			// 			        "vparentitem" => "0",
			// 			        "nchildqty" => "0.00",
			// 			        "vsize" => "",
			// 			        "npack" => "1",
			// 			        "nunitcost" => "0.0000",
			// 			        "ionupload" => "0",
			// 			        "nsellunit" => "1",
			// 			        "ilotterystartnum" => "0",
			// 			        "ilotteryendnum" => "0",
			// 			        "etransferstatus" => "2|1|",
			// 			        "vsequence" => "0",
			// 			        "vcolorcode" => "None",
			// 			        "vdiscount" => "Yes",
			// 			        "norderqtyupto" => "0",
			// 			        "vshowsalesinzreport" => "No",
			// 			        "iinvtdefaultunit" => "0",
			// 			        "stationid" => "0",
			// 			        "shelfid" => "0",
			// 			        "aisleid" => "0",
			// 			        "shelvingid" => "0",
			// 			        "rating" => "",
			// 			        "vintage" => "",
			// 			        "PrinterStationId" => "0",
			// 			        "liability" => "",
			// 			        "isparentchild" => "0",
			// 			        "parentid" => "0",
			// 			        "parentmasterid" => "0",
			// 			        "wicitem" => "0"
			// 				);
			// $temp_arr[1] = array(
			// 					"webstore" => "0",
			// 					"iitemgroupid" => "1",
			// 			        "vitemtype" => "Standard",
			// 			        "vitemcode" => "8",
			// 			        "vitemname" => "Instant Lottery",
			// 			        "vunitcode" => "UNT002",
			// 			        "vbarcode" => "12",
			// 			        "vpricetype" => "",
			// 			        "vcategorycode" => "2",
			// 			        "vdepcode" => "1",
			// 			        "vsuppliercode" => "101",
			// 			        "iqtyonhand" => "0",
			// 			        "ireorderpoint" => "0",
			// 			        "dcostprice" => "0.0000",
			// 			        "dunitprice" => "0.00",
			// 			        "nsaleprice" => "0.0000",
			// 			        "nlevel2" => "0.00",
			// 			        "nlevel3" => "0.00",
			// 			        "nlevel4" => "0.00",
			// 			        "iquantity" => "0",
			// 			        "ndiscountper" => "0.00",
			// 			        "ndiscountamt" => "0.00",
			// 			        "vtax1" => "N",
			// 			        "vtax2" => "N",
			// 			        "vfooditem" => "Y",
			// 			        "vdescription" => "",
			// 			        "dlastsold" => null,
			// 			        "visinventory" => "No",
			// 			        "dpricestartdatetime" => null,
			// 			        "dpriceenddatetime" => null,
			// 			        "estatus" => "Active",
			// 			        "nbuyqty" => "0",
			// 			        "ndiscountqty" => "0",
			// 			        "nsalediscountper" => "0.00",
			// 			        "vshowimage" => "Yes",
			// 			        "itemimage" => "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",
			// 			        "vageverify" => "0",
			// 			        "ebottledeposit" => "No",
			// 			        "nbottledepositamt" => "0.00",
			// 			        "vbarcodetype" => "Code 128",
			// 			        "ntareweight" => "0.00",
			// 			        "ntareweightper" => "0.00",
			// 			        "dcreated" => null,
			// 			        "dlastupdated" => "2017-02-22",
			// 			        "dlastreceived" => null,
			// 			        "dlastordered" => null,
			// 			        "nlastcost" => "0.00",
			// 			        "nonorderqty" => "0",
			// 			        "vparentitem" => "0",
			// 			        "nchildqty" => "0.00",
			// 			        "vsize" => "",
			// 			        "npack" => "1",
			// 			        "nunitcost" => "0.0000",
			// 			        "ionupload" => "0",
			// 			        "nsellunit" => "1",
			// 			        "ilotterystartnum" => "0",
			// 			        "ilotteryendnum" => "0",
			// 			        "etransferstatus" => "2|1|",
			// 			        "vsequence" => "0",
			// 			        "vcolorcode" => "None",
			// 			        "vdiscount" => "Yes",
			// 			        "norderqtyupto" => "0",
			// 			        "vshowsalesinzreport" => "No",
			// 			        "iinvtdefaultunit" => "0",
			// 			        "stationid" => "0",
			// 			        "shelfid" => "0",
			// 			        "aisleid" => "0",
			// 			        "shelvingid" => "0",
			// 			        "rating" => "",
			// 			        "vintage" => "",
			// 			        "PrinterStationId" => "0",
			// 			        "liability" => "",
			// 			        "isparentchild" => "0",
			// 			        "parentid" => "0",
			// 			        "parentmasterid" => "0",
			// 			        "wicitem" => "0"
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				
				if (($value['vbarcode'] == '')) {
					$data['validation_error'][] = 'SKU Required';
					break;
				}

				if (($value['vitemname'] == '')) {
					$data['validation_error'][] = 'Item Name Required';
					break;
				}

				if (($value['vunitcode'] == '')) {
					$data['validation_error'][] = 'Unit Required';
					break;
				}

				if (($value['vsuppliercode'] == '')) {
					$data['validation_error'][] = 'Supplier Required';
					break;
				}

				if (($value['vdepcode'] == '')) {
					$data['validation_error'][] = 'Department Required';
					break;
				}

				if (($value['vcategorycode'] == '')) {
					$data['validation_error'][] = 'Category Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

						$unique_sku = $this->model_api_items->getSKU($v['vbarcode']);
						
						if(count($unique_sku) > 0){

							$item_info = $this->model_api_items->getItemAllData($v['vbarcode'],$v['vunitcode'],$v['vsuppliercode'],$v['vdepcode'],$v['vcategorycode']);
							
								if(count($item_info) > 0 ){
									$data = $this->model_api_items->editlistItems($item_info['iitemid'],$v);
								}else{
									$data['validation_error'][] = 'Entered the same SKU';
									break;
								}
						}else{
							$data = $this->model_api_items->addItems($v);
						}
					
				}

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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

	public function add_item_vendor() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			// $temp_arr = array();
			// $temp_arr['iitemid'] = '2079';
			// $temp_arr['ivendorid'] = '200';
			// $temp_arr['vvendoritemcode'] = '13456';
			
			
				
				if (($temp_arr['iitemid'] == '')) {
					$data['validation_error'][] = 'Item Id Required';
				}

				if (($temp_arr['ivendorid'] == '')) {
					$data['validation_error'][] = 'Vendor Id Required';
				}

				if (($temp_arr['vvendoritemcode'] == '')) {
					$data['validation_error'][] = 'Vendor Item Code Required';
				}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->addUpdateItemVendor($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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

	public function add_alias_code() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr = array();
			// $temp_arr['vitemcode'] = 'Mehul';
			// $temp_arr['vsku'] = 'Mehul';
			// $temp_arr['valiassku'] = 'Mehul';
				
			if (($temp_arr['vitemcode'] == '')) {
				$data['validation_error'][] = 'Item Code Required';
			}

			if (($temp_arr['vsku'] == '')) {
				$data['validation_error'][] = 'SKU Required';
			}

			if (($temp_arr['valiassku'] == '')) {
				$data['validation_error'][] = 'Alias Code Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->addItemAliasCode($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

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

	public function delete_alias_code() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
		
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->deleteItemAliasCode($temp_arr);

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

	public function add_lot_matrix() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
				
			if (($temp_arr['iitemid'] == '')) {
				$data['validation_error'][] = 'Item id Required';
			}

			if (($temp_arr['vbarcode'] == '')) {
				$data['validation_error'][] = 'Barcode Required';
			}

			if (($temp_arr['vpackname'] == '')) {
				$data['validation_error'][] = 'Pack Name Required';
			}

			if (($temp_arr['ipack'] == '')) {
				$data['validation_error'][] = 'Pack Qty Required';
			}

			if (($temp_arr['npackcost'] == '')) {
				$data['validation_error'][] = 'Cost Price Required';
			}

			if (($temp_arr['npackprice'] == '')) {
				$data['validation_error'][] = 'Price Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->addItemLotMatrix($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

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

	public function lot_matrix_editlist() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
				
			foreach ($temp_arr as $key => $value) {
				
				if (($value['iitemid'] == '')) {
					$data['validation_error'][] = 'Item Id Required';
					break;
				}

				if (($value['idetid'] == '')) {
					$data['validation_error'][] = 'Pack Id Required';
					break;
				}

				if (($value['npackprice'] == '')) {
					$data['validation_error'][] = 'Pack Price Required';
					break;
				}

				if (($value['npackmargin'] == '')) {
					$data['validation_error'][] = 'Profit Margin Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->editlistLotMatrixItems($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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

	public function delete_lot_matrix() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->deleteItemLotmatrix($temp_arr);

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

	public function add_slab_price() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if (($temp_arr['vsku'] == '')) {
				$data['validation_error'][] = 'Item SKU Required';
			}

			if (($temp_arr['iitemgroupid'] == '')) {
				$data['validation_error'][] = 'Item Group Id Required';
			}

			if (($temp_arr['iqty'] == '')) {
				$data['validation_error'][] = 'Qty Required';
			}

			if (($temp_arr['nprice'] == '')) {
				$data['validation_error'][] = 'Price Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->addItemSlabPrice($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

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

	public function slab_price_editlist() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
				
			foreach ($temp_arr as $key => $value) {
				
				if (($value['islabid'] == '')) {
					$data['validation_error'][] = 'Slab Price Id Required';
					break;
				}

				if (($value['iqty'] == '')) {
					$data['validation_error'][] = 'Qty Required';
					break;
				}

				if (($value['nprice'] == '')) {
					$data['validation_error'][] = 'Price Required';
					break;
				}

				if (($value['nunitprice'] == '')) {
					$data['validation_error'][] = 'Unit Price Required';
					break;
				}
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->editlistSlabPriceItems($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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

	public function slab_price_deletelist() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);
			
			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->deleteSlabPriceItem($temp_arr);

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

	public function add_parent_item() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if (($temp_arr['parent_item_id'] == '')) {
				$data['validation_error'][] = 'Parent Item Id Required';
			}

			if (($temp_arr['child_item_id'] == '')) {
				$data['validation_error'][] = 'Child Item Id Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->addParentItem($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

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

	public function remove_parent_item() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			if (($temp_arr['iitemid'] == '')) {
				$data['validation_error'][] = 'Item Id Required';
			}

			if (($temp_arr['selected_parent_item_id'] == '')) {
				$data['validation_error'][] = 'Parent Item Id Required';
			}

			if(!array_key_exists("validation_error",$data)){

				$data = $this->model_api_items->removeParentItem($temp_arr);

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

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

	public function edit_list() {

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			// $temp_arr[0] = array(
			// 					'iitemid' => '8',
			// 					"iitemgroupid" => "1",
			// 					"webstore" => "0",
			// 			        "vitemtype" => "Standard",
			// 			        "vitemcode" => "8",
			// 			        "vitemname" => "Instant Lottery",
			// 			        "vunitcode" => "UNT001",
			// 			        "vbarcode" => "8",
			// 			        "vpricetype" => "",
			// 			        "vcategorycode" => "1",
			// 			        "vdepcode" => "1",
			// 			        "vsuppliercode" => "101",
			// 			        "iqtyonhand" => "0",
			// 			        "ireorderpoint" => "0",
			// 			        "dcostprice" => "0.0000",
			// 			        "dunitprice" => "0.00",
			// 			        "nsaleprice" => "0.0000",
			// 			        "nlevel2" => "0.00",
			// 			        "nlevel3" => "0.00",
			// 			        "nlevel4" => "0.00",
			// 			        "iquantity" => "0",
			// 			        "ndiscountper" => "0.00",
			// 			        "ndiscountamt" => "0.00",
			// 			        "vtax1" => "N",
			// 			        "vtax2" => "N",
			// 			        "vfooditem" => "Y",
			// 			        "vdescription" => "",
			// 			        "dlastsold" => null,
			// 			        "visinventory" => "No",
			// 			        "dpricestartdatetime" => null,
			// 			        "dpriceenddatetime" => null,
			// 			        "estatus" => "Active",
			// 			        "nbuyqty" => "0",
			// 			        "ndiscountqty" => "0",
			// 			        "nsalediscountper" => "0.00",
			// 			        "vshowimage" => "Yes",
			// 			        "itemimage" => "/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCABQAFsDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD5/pxJz1NNpT1oANx9TRuPqat6Vp0ur6pb2EMkUck77FaVwqg+57VZs9Au7vUZ7VVYx27ETzxxtIkYHf5QeKh1IJ8reu4PRXZl7j6mui1Twu+m+FtN1z7fBKl4WURxsWIIJ74wOBznuDXSa3oHhu0Ntf3Mkpt5VQzvbEHB2Dbheo39cnjg+tUBrvgqICMaJf3CKAAZpj0Gccbsdz+dcsq058sqd7J66b+REaqa+Fs4jcfU1o2Gg61qqb9P0q/u0/vQW7uPzAr274Z/DDStShfxn4jsYLfTnBlstPc/u1jH/LSTPUcZAPB69CBXU3fxWP2wWnhzTIDYwnaJJgVDgf3VXG0fX8q6nNRV5aEzrRppc3U+YLyxvtOm8m+tbi1l/uTxsh/I1W3H1NfXXiXxBp2s6NYRahoEOoWV3GzTxTN80RBwdhx1B78dq+fPiJ4GTwrdW+oaXK9zoWoZNrK4+aNh1if/AGh+v4GlCrCbtFlRnGTsjiD2+lJSnt9KStCwpT1pKntYBc3IRm2Rj5nfH3VHU0N2AvaVp0MkbahqMrwafE2CU+/M3XYnv6noPyB1zq39t6ZcabaLcWmwqLLTrJMpIM/MZW6scc5NYk2rzG8jktwIoYUMUERUMEQgg8Hgk5JJ9TULX8i27W1sTDA33wvDSf7x7/Tp/OsJU3PV/wBf1/ViLO92dV4e0eKfxnp0es6vAk8k8WIoh5+9lYARPtOFzgDuK0PEfhDSoPH+laLpkcptr+YSNOZQyMrOcqm3soBHPOa8/trmazuUuLeRo5kOUdeqn1Fbvgi7a38ZaQ7udkc+QCeASKx+rVPrCq8/upWt0/r1ubKSUOW2vc+n/iLp+pT+AobHRbWWRPNjWWGBcnygDgADqAQtcNovhfUrO2WW9sZLVexuMJk/QnNet3WsfYPCV1qsaCVra2aVUzwxAyPwrx7SfEM+r6it5q07zu7gyYPRc8hR2GKMcv3Z5uIjBVU3uz1DVLe1u/CVo9tFFtiCqHbgp2I/PrXI654Um1X4a+IrWTyJIRF9stCkgYrNGCTjHTIGPxrpvEGt2B0m2tNPdTE6h8AY2qOB+Of5VzOj6oYp9ZXcfsw0ueWYdvlHB/U1yU5f7WuuiWm1zZyiqiPlw9vpSUp6Ckr2DpCpBKUjkQfx4BPsOcfnj8qjpT1oA9x8IeF9G8UfBe10u5WC31e9vZxp1yUAJmQFghbrggMMf1Aqa9+HMWr+GPDMuoxTadbaXpbtqBtbTfcSSmQKqBQMlsg8nOPxrzZvGSRfD7SNCs0uINR0/UmvluVICjg4x3yDivWdI+Kt54zSdE0+8SG10h5NWe1uhBKhQg+bA3r1+U46+3IBzGrfBWCDSIL3S9Ru7g3N3bLCk0HlssMxCgup5DK3Xtiq2tfDO28I3niTUDqNw1rosVrPYyFV/wBIklOAp9gynOO1WdJ+MVjovie9vIIdau9OksBBCuoXf2iUzq25ZDuOFHqAff2rnde+Ix1r4YaT4WaGb7ZbTbrm5YjEqKX2D143Dr6UAe6eBfEtlrOhraTMHtrqEhQT95CMFT7jkH6Vxs3w58TadrrWmnWv2q0dv3N0HATb2LehHcY+ma8g8L+Lrzw3NsUGa0ZtzRbsFW/vIex/Q9+1ewaZ8adJksWt72dzHIhR1dGVsEYI+X+YNTKKkrMwrUI1bX3R1Gm+FTrmi3v9n3i+da3PkRXDg7JyqgSfRdxIBH933rlviA0fw/8AAN3p0t1HPr+u/uW8s8RW4PzYzzg9M9yfam3Xxx0TQ9HSw8O6eziJdsUeCkae5J5PPPv61414o1q48Qay2p3WoSXtxMgLs8XliP8A2FGT8o7VEKMIO6Wo4UYxak9zGPb6UlKe30pK1NgpT1pKU9aAEr2n4ReGNQ0qfxI3iCwudO0650Yo9xOhRdkhXofXbn6d64i+8OadB8JNL8RIkn9o3GpyW0jF/lKBWI49eBXR6TofxM8aeC4Yf7Zxo8p8u1t727EbXW3+FMjLAEdzjj2oA9R1EaLBrVxoN8I/sdpPa/2faw6JIosnDpsJnwVIYkAk8c/Ws+bxXZN4z8SaX/ZsekrYSCC01eDTftKwSyNmQyjBHzlQB04B5rOXwj40uPBnhiK48U3MExulF5bXF8qCNVcbFX5cl1wMgk4IrP1Dwd480Lx1rFx4e8SC3s5iJZ768vVCnOABN8u3eTnHy9KAOsXTR4RsEmuJtOiv77VJBqbWujNdJcDI2wqqcxgoQcHuT75gng0DUtRs/G9laouneGYb23uIZYvLO6NR5SFCAQfnPUZ4FcTpHhf4tWE2rXNrqz2jtdul+8tzkFhGH805BG0qRhhz0Hap7qw1ddC1LwHaWkMOoT2w1bV9Xmv3liuYlw29crkEkgHj+Hv1oA8ZubiS7u5rmYgyzO0jkDGSTk1FRRQAp7fSkpT2+lJQAUp60lKc5oA9Z0SHw34j+EenaDqPiuy0a6ttRluSsyFyQQQOMj1zW3fw+DdVXwwg8eWlv/wi6pFK3lMBcKpV98XP3jjBxnke3PhWD6UYPpQB7l4q8W+G/FehWOsxatBazaZrT3X2CRD500bSrggf7o3Hr3Fb994i8JTT69p0Ov8Ah66k1W7XU4X1G3aW1X5VQxuQRhhtyPrXzdg+lGD6UAe2/EHxzZ6t8ObvS4NcsLq8XVI48WMLwLLbrEOdrEkqH4znB2ip9c1WTT/gba6hf2k9rr19aR6IDMpVnt0YuGAPJBTjPvXheD6Vf1HWtV1dLdNS1G7u1tk2QrPKziNfQZPHQflQBQoowfSjB9KAFPb6UlKe30pKAP/Z",
			// 			        "vageverify" => "0",
			// 			        "ebottledeposit" => "No",
			// 			        "nbottledepositamt" => "0.00",
			// 			        "vbarcodetype" => "Code 128",
			// 			        "ntareweight" => "0.00",
			// 			        "ntareweightper" => "0.00",
			// 			        "dcreated" => null,
			// 			        "dlastupdated" => "2017-02-22",
			// 			        "dlastreceived" => null,
			// 			        "dlastordered" => null,
			// 			        "nlastcost" => "0.00",
			// 			        "nonorderqty" => "0",
			// 			        "vparentitem" => "0",
			// 			        "nchildqty" => "0.00",
			// 			        "vsize" => "",
			// 			        "npack" => "1",
			// 			        "nunitcost" => "0.0000",
			// 			        "ionupload" => "0",
			// 			        "nsellunit" => "1",
			// 			        "ilotterystartnum" => "0",
			// 			        "ilotteryendnum" => "0",
			// 			        "etransferstatus" => "2|1|",
			// 			        "vsequence" => "0",
			// 			        "vcolorcode" => "None",
			// 			        "vdiscount" => "Yes",
			// 			        "norderqtyupto" => "0",
			// 			        "vshowsalesinzreport" => "No",
			// 			        "iinvtdefaultunit" => "0",
			// 			        "stationid" => "0",
			// 			        "shelfid" => "0",
			// 			        "aisleid" => "0",
			// 			        "shelvingid" => "0",
			// 			        "rating" => "",
			// 			        "vintage" => "",
			// 			        "PrinterStationId" => "0",
			// 			        "liability" => "",
			// 			        "isparentchild" => "0",
			// 			        "parentid" => "0",
			// 			        "parentmasterid" => "0",
			// 			        "wicitem" => "0"
			// 				);
			// $temp_arr[1] = array(
			// 					'iitemid' => '2779',
			// 					"iitemgroupid" => "1",
			// 					"webstore" => "0",
			// 			        "vitemtype" => "Standard",
			// 			        "vitemcode" => "8",
			// 			        "vitemname" => "Instant Lottery",
			// 			        "vunitcode" => "UNT002",
			// 			        "vbarcode" => "12",
			// 			        "vpricetype" => "",
			// 			        "vcategorycode" => "2",
			// 			        "vdepcode" => "1",
			// 			        "vsuppliercode" => "101",
			// 			        "iqtyonhand" => "0",
			// 			        "ireorderpoint" => "0",
			// 			        "dcostprice" => "0.0000",
			// 			        "dunitprice" => "0.00",
			// 			        "nsaleprice" => "0.0000",
			// 			        "nlevel2" => "0.00",
			// 			        "nlevel3" => "0.00",
			// 			        "nlevel4" => "0.00",
			// 			        "iquantity" => "0",
			// 			        "ndiscountper" => "0.00",
			// 			        "ndiscountamt" => "0.00",
			// 			        "vtax1" => "N",
			// 			        "vtax2" => "N",
			// 			        "vfooditem" => "Y",
			// 			        "vdescription" => "",
			// 			        "dlastsold" => null,
			// 			        "visinventory" => "No",
			// 			        "dpricestartdatetime" => null,
			// 			        "dpriceenddatetime" => null,
			// 			        "estatus" => "Active",
			// 			        "nbuyqty" => "0",
			// 			        "ndiscountqty" => "0",
			// 			        "nsalediscountper" => "0.00",
			// 			        "vshowimage" => "Yes",
			// 			        "itemimage" => "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",
			// 			        "vageverify" => "0",
			// 			        "ebottledeposit" => "No",
			// 			        "nbottledepositamt" => "0.00",
			// 			        "vbarcodetype" => "Code 128",
			// 			        "ntareweight" => "0.00",
			// 			        "ntareweightper" => "0.00",
			// 			        "dcreated" => null,
			// 			        "dlastupdated" => "2017-02-22",
			// 			        "dlastreceived" => null,
			// 			        "dlastordered" => null,
			// 			        "nlastcost" => "0.00",
			// 			        "nonorderqty" => "0",
			// 			        "vparentitem" => "0",
			// 			        "nchildqty" => "0.00",
			// 			        "vsize" => "",
			// 			        "npack" => "1",
			// 			        "nunitcost" => "0.0000",
			// 			        "ionupload" => "0",
			// 			        "nsellunit" => "1",
			// 			        "ilotterystartnum" => "0",
			// 			        "ilotteryendnum" => "0",
			// 			        "etransferstatus" => "2|1|",
			// 			        "vsequence" => "0",
			// 			        "vcolorcode" => "None",
			// 			        "vdiscount" => "Yes",
			// 			        "norderqtyupto" => "0",
			// 			        "vshowsalesinzreport" => "No",
			// 			        "iinvtdefaultunit" => "0",
			// 			        "stationid" => "0",
			// 			        "shelfid" => "0",
			// 			        "aisleid" => "0",
			// 			        "shelvingid" => "0",
			// 			        "rating" => "",
			// 			        "vintage" => "",
			// 			        "PrinterStationId" => "0",
			// 			        "liability" => "",
			// 			        "isparentchild" => "0",
			// 			        "parentid" => "0",
			// 			        "parentmasterid" => "0",
			// 			        "wicitem" => "0"
			// 				);
			
			foreach ($temp_arr as $key => $value) {
				
				if (($value['iitemid'] == '')) {
					$data['validation_error'][] = 'Item Id Required';
					break;
				}

				if (($value['vbarcode'] == '')) {
					$data['validation_error'][] = 'SKU Required';
					break;
				}

				if (($value['vitemname'] == '')) {
					$data['validation_error'][] = 'Item Name Required';
					break;
				}

				if (($value['vunitcode'] == '')) {
					$data['validation_error'][] = 'Unit Required';
					break;
				}

				if (($value['vsuppliercode'] == '')) {
					$data['validation_error'][] = 'Supplier Required';
					break;
				}

				if (($value['vdepcode'] == '')) {
					$data['validation_error'][] = 'Department Required';
					break;
				}

				if (($value['vcategorycode'] == '')) {
					$data['validation_error'][] = 'Category Required';
					break;
				}

			}

			if(!array_key_exists("validation_error",$data)){

				foreach ($temp_arr as $k => $v) {

						$item_info = $this->model_api_items->getItem($v['iitemid']);

						if($item_info['vbarcode'] != $v['vbarcode']){

							$unique_sku = $this->model_api_items->getSKU($v['vbarcode']);
							
							if(count($unique_sku) > 0 ){
								$data['validation_error'][] = 'Entered the same SKU';
								break;
							}else{
								$data = $this->model_api_items->editlistItems($v['iitemid'],$v);
							}
						}else{
							$data = $this->model_api_items->editlistItems($v['iitemid'],$v);
						}
					
				}

				if(array_key_exists("validation_error",$data)){
					if(isset($data['success'])){
						unset($data['success']);
					}
				}

				if(array_key_exists("success",$data)){
					http_response_code(200);
				}elseif(array_key_exists("validation_error",$data)){
					http_response_code(401);
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
		ini_set('memory_limit','512M');

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && (!empty($this->request->get['iitemid']))) {

			$data = $this->model_api_items->getItem($this->request->get['iitemid']);

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

	public function search() {
		ini_set('memory_limit','512M');

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['search'];

			$data = $this->model_api_items->getItemsSearch($search);

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid or search field';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
	
	public function itemscan() {
		ini_set('memory_limit','512M');

		$data = array();
		$this->load->model('api/items');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$search = $temp_arr['sku'];

			$data = $this->model_api_items->getItemsSearchBySKU($search);

			http_response_code(200);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));

		}else{
			$data['error'] = 'Something went wrong missing token or sid or search field';
			http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($data));
		}
	}
	
}
