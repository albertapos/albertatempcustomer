<?php
class ControllerAdministrationItems extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->session->data['tab_selected'] = 'item_tab';

		// $this->load->model('administration/location');

		$this->getList();
	}

	public function add() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			if(isset($this->request->files['itemimage']) && $this->request->files['itemimage']['name'] != ''){
				$img_string = file_get_contents($this->request->files['itemimage']['tmp_name']);
			}else{
				$img_string = NULL;
			}

			if(isset($this->request->post['vtax1']) && $this->request->post['vtax1'] == 'Y'){
				$vtax1 = 'Y';
			}else{
				$vtax1 = 'N';
			}

			if(isset($this->request->post['vtax2']) && $this->request->post['vtax2'] == 'Y'){
				$vtax2 = 'Y';
			}else{
				$vtax2 = 'N';
			}

			if(isset($this->request->post['npack']) && $this->request->post['npack'] == ''){
				$npack = '1';
			}else{
				$npack = $this->request->post['npack'];
			}

			if(isset($this->request->post['nsellunit']) && $this->request->post['nsellunit'] == ''){
				$nsellunit = '1';
			}else{
				$nsellunit = $this->request->post['nsellunit'];
			}

			if(isset($this->request->post['visinventory']) && $this->request->post['visinventory'] == 'No'){
				$iqtyonhand = '0';
			}else{
				$iqtyonhand = $this->request->post['iqtyonhand'];
			}

			if(isset($this->request->post['nbottledepositamt']) && ($this->request->post['nbottledepositamt'] == '0.00' || $this->request->post['nbottledepositamt'] == '')){
				$nbottledepositamt = '0.00';
				$ebottledeposit = 'No';
			}else{
				$nbottledepositamt = (float)$this->request->post['nbottledepositamt'];
				$ebottledeposit = 'Yes';
			}

			if(isset($this->request->post['options_checkbox']) && $this->request->post['options_checkbox'] == 1){

				$options_data['unit_id'] = $this->request->post['unit_id'];
				$options_data['unit_value'] = $this->request->post['unit_value'];
				$options_data['bucket_id'] = $this->request->post['bucket_id'];
				if(isset($this->request->post['malt']) && $this->request->post['malt'] == 1){
					$options_data['malt'] = $this->request->post['malt'];
				}else{
					$options_data['malt'] = 0;
				}

			}else{
				$options_data = array();
			}

			$temp_arr = array(
								"iitemgroupid" => $this->request->post['iitemgroupid'],
								"webstore" => "0",
						        "vitemtype" => $this->request->post['vitemtype'],
						        "vitemname" => $this->request->post['vitemname'],
						        "vunitcode" => $this->request->post['vunitcode'],
						        "vbarcode" => $this->request->post['vbarcode'],
						        "vpricetype" => "",
						        "vcategorycode" => $this->request->post['vcategorycode'],
						        "vdepcode" => $this->request->post['vdepcode'],
						        "vsuppliercode" => $this->request->post['vsuppliercode'],
						        "iqtyonhand" => $iqtyonhand,
						        "ireorderpoint" => $this->request->post['ireorderpoint'],
						        "dcostprice" => $this->request->post['dcostprice'],
						        "dunitprice" => $this->request->post['dunitprice'],
						        "nsaleprice" => '',
						        "nlevel2" => $this->request->post['nlevel2'],
						        "nlevel3" => $this->request->post['nlevel3'],
						        "nlevel4" => $this->request->post['nlevel4'],
						        "iquantity" => "0",
						        "ndiscountper" => $this->request->post['ndiscountper'],
						        "ndiscountamt" => "0.00",
						        "vtax1" => $vtax1,
						        "vtax2" => $vtax2,
						        "vfooditem" => $this->request->post['vfooditem'],
						        "vdescription" => $this->request->post['vdescription'],
						        "dlastsold" => null,
						        "visinventory" => $this->request->post['visinventory'],
						        "dpricestartdatetime" => null,
						        "dpriceenddatetime" => null,
						        "estatus" => $this->request->post['estatus'],
						        "nbuyqty" => "0",
						        "ndiscountqty" => "0",
						        "nsalediscountper" => "0.00",
						        "vshowimage" => $this->request->post['vshowimage'],
						        "itemimage" => $img_string,
						        "vageverify" => $this->request->post['vageverify'],
						        "ebottledeposit" => $ebottledeposit,
						        "nbottledepositamt" => $nbottledepositamt,
						        "vbarcodetype" => $this->request->post['vbarcodetype'],
						        "ntareweight" => "0.00",
						        "ntareweightper" => "0.00",
						        "dcreated" => date('Y-m-d'),
						        "dlastupdated" => date('Y-m-d'),
						        "dlastreceived" => null,
						        "dlastordered" => null,
						        "nlastcost" => "0.00",
						        "nonorderqty" => "0",
						        "vparentitem" => "0",
						        "nchildqty" => "0.00",
						        "vsize" => $this->request->post['vsize'],
						        "npack" => $npack,
						        "nunitcost" => $this->request->post['nunitcost'],
						        "ionupload" => "0",
						        "nsellunit" => $nsellunit,
						        "ilotterystartnum" => "0",
						        "ilotteryendnum" => "0",
						        "etransferstatus" => "",
						        "vsequence" => $this->request->post['vsequence'],
						        "vcolorcode" => $this->request->post['vcolorcode'],
						        "vdiscount" => $this->request->post['vdiscount'],
						        "norderqtyupto" => $this->request->post['norderqtyupto'],
						        "vshowsalesinzreport" => $this->request->post['vshowsalesinzreport'],
						        "iinvtdefaultunit" => "0",
						        "stationid" => $this->request->post['stationid'],
						        "shelfid" => $this->request->post['shelfid'],
						        "aisleid" => $this->request->post['aisleid'],
						        "shelvingid" => $this->request->post['shelvingid'],
						        "rating" => $this->request->post['rating'],
						        "vintage" => $this->request->post['vintage'],
						        "PrinterStationId" => "0",
						        "liability" => $this->request->post['liability'],
						        "isparentchild" => "0",
						        "parentid" => "0",
						        "parentmasterid" => "0",
						        "wicitem" => $this->request->post['wicitem'],
						        "options_data" => $options_data
							);

			$this->model_api_items->addItems($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function clone_item() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if(isset($this->request->files['itemimage']) && $this->request->files['itemimage']['name'] != ''){
				$img_string = file_get_contents($this->request->files['itemimage']['tmp_name']);
			}else{
				$img_string = NULL;
			}

			if(isset($this->request->post['vtax1']) && $this->request->post['vtax1'] == 'Y'){
				$vtax1 = 'Y';
			}else{
				$vtax1 = 'N';
			}

			if(isset($this->request->post['vtax2']) && $this->request->post['vtax2'] == 'Y'){
				$vtax2 = 'Y';
			}else{
				$vtax2 = 'N';
			}

			if(isset($this->request->post['npack']) && $this->request->post['npack'] == ''){
				$npack = '1';
			}else{
				$npack = $this->request->post['npack'];
			}

			if(isset($this->request->post['nsellunit']) && $this->request->post['nsellunit'] == ''){
				$nsellunit = '1';
			}else{
				$nsellunit = $this->request->post['nsellunit'];
			}

			if(isset($this->request->post['visinventory']) && $this->request->post['visinventory'] == 'No'){
				$iqtyonhand = '0';
			}else{
				$iqtyonhand = $this->request->post['iqtyonhand'];
			}

			if(isset($this->request->post['nbottledepositamt']) && ($this->request->post['nbottledepositamt'] == '0.00' || $this->request->post['nbottledepositamt'] == '')){
				$nbottledepositamt = '0.00';
				$ebottledeposit = 'No';
			}else{
				$nbottledepositamt = $this->request->post['nbottledepositamt'];
				$ebottledeposit = 'Yes';
			}

			if(isset($this->request->post['options_checkbox']) && $this->request->post['options_checkbox'] == 1){

				$options_data['unit_id'] = $this->request->post['unit_id'];
				$options_data['unit_value'] = $this->request->post['unit_value'];
				$options_data['bucket_id'] = $this->request->post['bucket_id'];
				if(isset($this->request->post['malt']) && $this->request->post['malt'] == 1){
					$options_data['malt'] = $this->request->post['malt'];
				}else{
					$options_data['malt'] = 0;
				}

			}else{
				$options_data = array();
			}

			$temp_arr = array(
								"iitemgroupid" => $this->request->post['iitemgroupid'],
								"webstore" => "0",
						        "vitemtype" => $this->request->post['vitemtype'],
						        "vitemname" => $this->request->post['vitemname'],
						        "vunitcode" => $this->request->post['vunitcode'],
						        "vbarcode" => $this->request->post['vbarcode'],
						        "vpricetype" => "",
						        "vcategorycode" => $this->request->post['vcategorycode'],
						        "vdepcode" => $this->request->post['vdepcode'],
						        "vsuppliercode" => $this->request->post['vsuppliercode'],
						        "iqtyonhand" => $iqtyonhand,
						        "ireorderpoint" => $this->request->post['ireorderpoint'],
						        "dcostprice" => $this->request->post['dcostprice'],
						        "dunitprice" => $this->request->post['dunitprice'],
						        "nsaleprice" => '',
						        "nlevel2" => $this->request->post['nlevel2'],
						        "nlevel3" => $this->request->post['nlevel3'],
						        "nlevel4" => $this->request->post['nlevel4'],
						        "iquantity" => "0",
						        "ndiscountper" => $this->request->post['ndiscountper'],
						        "ndiscountamt" => "0.00",
						        "vtax1" => $vtax1,
						        "vtax2" => $vtax2,
						        "vfooditem" => $this->request->post['vfooditem'],
						        "vdescription" => $this->request->post['vdescription'],
						        "dlastsold" => null,
						        "visinventory" => $this->request->post['visinventory'],
						        "dpricestartdatetime" => null,
						        "dpriceenddatetime" => null,
						        "estatus" => $this->request->post['estatus'],
						        "nbuyqty" => "0",
						        "ndiscountqty" => "0",
						        "nsalediscountper" => "0.00",
						        "vshowimage" => $this->request->post['vshowimage'],
						        "itemimage" => $img_string,
						        "vageverify" => $this->request->post['vageverify'],
						        "ebottledeposit" => $ebottledeposit,
						        "nbottledepositamt" => $nbottledepositamt,
						        "vbarcodetype" => $this->request->post['vbarcodetype'],
						        "ntareweight" => "0.00",
						        "ntareweightper" => "0.00",
						        "dcreated" => date('Y-m-d'),
						        "dlastupdated" => date('Y-m-d'),
						        "dlastreceived" => null,
						        "dlastordered" => null,
						        "nlastcost" => "0.00",
						        "nonorderqty" => "0",
						        "vparentitem" => "0",
						        "nchildqty" => "0.00",
						        "vsize" => $this->request->post['vsize'],
						        "npack" => $npack,
						        "nunitcost" => $this->request->post['nunitcost'],
						        "ionupload" => "0",
						        "nsellunit" => $nsellunit,
						        "ilotterystartnum" => "0",
						        "ilotteryendnum" => "0",
						        "etransferstatus" => "",
						        "vsequence" => $this->request->post['vsequence'],
						        "vcolorcode" => $this->request->post['vcolorcode'],
						        "vdiscount" => $this->request->post['vdiscount'],
						        "norderqtyupto" => $this->request->post['norderqtyupto'],
						        "vshowsalesinzreport" => $this->request->post['vshowsalesinzreport'],
						        "iinvtdefaultunit" => "0",
						        "stationid" => $this->request->post['stationid'],
						        "shelfid" => $this->request->post['shelfid'],
						        "aisleid" => $this->request->post['aisleid'],
						        "shelvingid" => $this->request->post['shelvingid'],
						        "rating" => $this->request->post['rating'],
						        "vintage" => $this->request->post['vintage'],
						        "PrinterStationId" => "0",
						        "liability" => $this->request->post['liability'],
						        "isparentchild" => "0",
						        "parentid" => "0",
						        "parentmasterid" => "0",
						        "wicitem" => $this->request->post['wicitem'],
						        "options_data" => $options_data
							);

			$last_iitemid = $this->model_api_items->addItems($temp_arr);

			$old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->request->post['clone_item_id'] . "'")->row;;
            unset($old_item_values['itemimage']);

            $x_general = new stdClass();
            $x_general->old_item_values = $old_item_values;

            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$last_iitemid['iitemid'] . "'")->row;;
            unset($new_item_values['itemimage']);
            $x_general->new_item_values = $new_item_values;

            $x_general = json_encode($x_general);

            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $last_iitemid['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($new_item_values['vbarcode']) . "', type = 'Clone', oldamount = '0', newamount = '0',general = '" . $x_general . "', source = 'CloneItem', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getCloneForm();
	}

	public function action_vendor() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$temp_arr = array();
			$temp_arr['iitemid'] = $this->request->post['iitemid'];
			$temp_arr['ivendorid'] = $this->request->post['ivendorid'];
			$temp_arr['vvendoritemcode'] = $this->request->post['vvendoritemcode'];
			$temp_arr['Id'] = 0;
			
			$this->model_api_items->addUpdateItemVendor($temp_arr);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->session->data['tab_selected'] = 'vendor_tab';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['iitemid'])) {
				$url .= '&iitemid=' . $this->request->post['iitemid'];
			}

			$this->response->redirect($this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function lot_matrix_editlist() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$temp_arr = $this->request->post['itempacks'];

			$iitemid = $this->request->post['itempacks'][0]['iitemid'];
			
			$this->model_api_items->editlistLotMatrixItems($temp_arr);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->session->data['tab_selected'] = 'lot_matrix_tab';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($iitemid)) {
				$url .= '&iitemid=' . $iitemid;
			}

			$this->response->redirect($this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function action_vendor_editlist() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$iitemid = $this->request->post['itemvendors'][0]['iitemid'];

			if(isset($this->request->post['itemvendors']) && count($this->request->post['itemvendors']) > 0){
				foreach ($this->request->post['itemvendors'] as $key => $value) {
					$this->model_api_items->addUpdateItemVendor($value);
				}
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->session->data['tab_selected'] = 'vendor_tab';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($iitemid)) {
				$url .= '&iitemid=' . $iitemid;
			}

			$this->response->redirect($this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function slab_price_editlist() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$iitemid = $this->request->post['iitemid'];

			$this->model_api_items->editlistSlabPriceItems($this->request->post['itemslabprices']);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->session->data['tab_selected'] = 'slab_price_tab';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($iitemid)) {
				$url .= '&iitemid=' . $iitemid;
			}

			$this->response->redirect($this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function edit() {

		$this->load->language('administration/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/items');
		$this->load->model('api/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			if(isset($this->request->files['itemimage']) && $this->request->files['itemimage']['name'] != ''){
				$img_string = file_get_contents($this->request->files['itemimage']['tmp_name']);
			}elseif($this->request->post['pre_itemimage'] != ''){
				$img_string = base64_decode($this->request->post['pre_itemimage']);
			}else{
			  $img_string =NULL;   
			}

			if(isset($this->request->post['vtax1']) && $this->request->post['vtax1'] == 'Y'){
				$vtax1 = 'Y';
			}else{
				$vtax1 = 'N';
			}

			if(isset($this->request->post['vtax2']) && $this->request->post['vtax2'] == 'Y'){
				$vtax2 = 'Y';
			}else{
				$vtax2 = 'N';
			}

			if(isset($this->request->post['npack']) && $this->request->post['npack'] == ''){
				$npack = '1';
			}else{
				$npack = $this->request->post['npack'];
			}

			if(isset($this->request->post['nsellunit']) && $this->request->post['nsellunit'] == ''){
				$nsellunit = '1';
			}else{
				$nsellunit = $this->request->post['nsellunit'];
			}

			if(isset($this->request->post['visinventory']) && $this->request->post['visinventory'] == 'No'){
				$iqtyonhand = '0';
			}else{
				$iqtyonhand = $this->request->post['iqtyonhand'];
			}

			if(isset($this->request->post['nbottledepositamt']) && ($this->request->post['nbottledepositamt'] == '0.00' || $this->request->post['nbottledepositamt'] == '')){
				$nbottledepositamt = '0.00';
				$ebottledeposit = 'No';
			}else{
				$nbottledepositamt = $this->request->post['nbottledepositamt'];
				$ebottledeposit = 'Yes';
			}

			if(isset($this->request->post['options_checkbox']) && $this->request->post['options_checkbox'] == 1){

				$options_data['unit_id'] = $this->request->post['unit_id'];
				$options_data['unit_value'] = $this->request->post['unit_value'];
				$options_data['bucket_id'] = $this->request->post['bucket_id'];
				if(isset($this->request->post['malt']) && $this->request->post['malt'] == 1){
					$options_data['malt'] = $this->request->post['malt'];
				}else{
					$options_data['malt'] = 0;
				}

			}else{
				$options_data = array();
			}

			$temp_arr = array(
								'iitemid' => $this->request->post['iitemid'],
								"iitemgroupid" => $this->request->post['iitemgroupid'],
								"webstore" => "0",
						        "vitemtype" => $this->request->post['vitemtype'],
						        "vitemname" => $this->request->post['vitemname'],
						        "vunitcode" => $this->request->post['vunitcode'],
						        "vbarcode" => $this->request->post['vbarcode'],
						        "vpricetype" => "",
						        "vcategorycode" => $this->request->post['vcategorycode'],
						        "vdepcode" => $this->request->post['vdepcode'],
						        "vsuppliercode" => $this->request->post['vsuppliercode'],
						        "iqtyonhand" => $iqtyonhand,
						        "ireorderpoint" => $this->request->post['ireorderpoint'],
						        "dcostprice" => $this->request->post['dcostprice'],
						        "dunitprice" => $this->request->post['dunitprice'],
						        "nsaleprice" => '',
						        "nlevel2" => $this->request->post['nlevel2'],
						        "nlevel3" => $this->request->post['nlevel3'],
						        "nlevel4" => $this->request->post['nlevel4'],
						        "iquantity" => "0",
						        "ndiscountper" => $this->request->post['ndiscountper'],
						        "ndiscountamt" => "0.00",
						        "vtax1" => $vtax1,
						        "vtax2" => $vtax2,
						        "vfooditem" => $this->request->post['vfooditem'],
						        "vdescription" => $this->request->post['vdescription'],
						        "dlastsold" => null,
						        "visinventory" => $this->request->post['visinventory'],
						        "dpricestartdatetime" => null,
						        "dpriceenddatetime" => null,
						        "estatus" => $this->request->post['estatus'],
						        "nbuyqty" => "0",
						        "ndiscountqty" => "0",
						        "nsalediscountper" => "0.00",
						        "vshowimage" => $this->request->post['vshowimage'],
						        "itemimage" => $img_string,
						        "vageverify" => $this->request->post['vageverify'],
						        "ebottledeposit" => $ebottledeposit,
						        "nbottledepositamt" => $nbottledepositamt,
						        "vbarcodetype" => $this->request->post['vbarcodetype'],
						        "ntareweight" => "0.00",
						        "ntareweightper" => "0.00",
						        "dlastupdated" => date('Y-m-d'),
						        "dlastreceived" => null,
						        "dlastordered" => null,
						        "nlastcost" => "0.00",
						        "nonorderqty" => "0",
						        "vparentitem" => "0",
						        "nchildqty" => "0.00",
						        "vsize" => $this->request->post['vsize'],
						        "npack" => $npack,
						        "nunitcost" => $this->request->post['nunitcost'],
						        "ionupload" => "0",
						        "nsellunit" => $nsellunit,
						        "ilotterystartnum" => "0",
						        "ilotteryendnum" => "0",
						        "etransferstatus" => "",
						        "vsequence" => $this->request->post['vsequence'],
						        "vcolorcode" => $this->request->post['vcolorcode'],
						        "vdiscount" => $this->request->post['vdiscount'],
						        "norderqtyupto" => $this->request->post['norderqtyupto'],
						        "vshowsalesinzreport" => $this->request->post['vshowsalesinzreport'],
						        "iinvtdefaultunit" => "0",
						        "stationid" => $this->request->post['stationid'],
						        "shelfid" => $this->request->post['shelfid'],
						        "aisleid" => $this->request->post['aisleid'],
						        "shelvingid" => $this->request->post['shelvingid'],
						        "rating" => $this->request->post['rating'],
						        "vintage" => $this->request->post['vintage'],
						        "PrinterStationId" => "0",
						        "liability" => $this->request->post['liability'],
						        "isparentchild" => $this->request->post['isparentchild'],
						        "parentid" => $this->request->post['parentid'],
						        "parentmasterid" => $this->request->post['parentmasterid'],
						        "wicitem" => $this->request->post['wicitem'],
						        "options_data" => $options_data
							);

			$this->model_api_items->editlistItems($temp_arr['iitemid'],$temp_arr);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->session->data['tab_selected'] = 'item_tab';

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['iitemid'])) {
				$url .= '&iitemid=' . $this->request->post['iitemid'];
			}

			if(isset($this->session->data['item_page_search'])){
				$this->session->data['item_page_search_id'] = $this->request->post['iitemid'];
				$url = '';
				$this->response->redirect($this->url->link('administration/items', 'token=' . $this->session->data['token'] .$url, true));
				unset($this->session->data['item_page_search']);
			}else{
				$this->response->redirect($this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true));
			}

		}

		$this->getForm();
	}
	  
	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'iitemid';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
			$this->session->data['item_page_search'] = $this->request->post['searchbox'];
		}elseif(isset($this->session->data['item_page_search']) && isset($this->request->get['cancel_btn'])){
			$searchbox =  $this->session->data['item_page_search'];
		}elseif(isset($this->session->data['item_page_search_id'])){
			$searchbox =  $this->session->data['item_page_search_id'];
			unset($this->session->data['item_page_search_id']);
		}else{
			$searchbox = '';
			unset($this->session->data['item_page_search']);
		}

		if(isset($this->request->get['show_items'])){
			$disable_items =  $this->request->get['show_items'];
		}else{
			$disable_items = 'Active';
		}

		if(isset($this->request->get['sort_items'])){
			$sort_items =  $this->request->get['sort_items'];
		}else{
			$sort_items = '';
		}

		$url .= '&show_items=' . $disable_items;
		$data['show_items'] = $disable_items;

		$url .= '&sort_items=' . $sort_items;
		$data['sort_items'] = $sort_items;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/items/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/items/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/items/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['searchitem'] = $this->url->link('administration/items/search', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'], true);
		$data['import_items'] = $this->url->link('administration/items/import_items', 'token=' . $this->session->data['token'] . $url, true);
		$data['get_barcode'] = $this->url->link('administration/items/get_barcode', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['items'] = array();

		$filter_data = array(
			'searchbox'  => $searchbox,
			'sort_items'  => $sort_items,
			'show_items' => $disable_items,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/items');

		$itemListings = $this->model_api_items->getItemListings();

		$data['itemListings'] = array();

		if(!empty($itemListings['variablevalue']) && count(json_decode($itemListings['variablevalue'])) > 0){
			$data['itemListings'] = json_decode($itemListings['variablevalue']);
		}

		$item_data = $this->model_api_items->getItemsResult($filter_data);

		$item_total = $this->model_api_items->getTotalItems($filter_data);

		$results = $item_data;

		if(count($data['itemListings']) > 0){
			foreach ($results as $k => $result) {
				$data['items'][$k]['iitemid'] = $result['iitemid'];
				$data['items'][$k]['vitemtype'] = $result['vitemtype'];
				$data['items'][$k]['VITEMNAME'] = $result['VITEMNAME'];
				$data['items'][$k]['vbarcode'] = $result['vbarcode'];

				foreach($data['itemListings'] as $m => $v){
					if($m == 'vdepcode'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['vdepartmentname'] = $result['vdepartmentname'];
	                }else if($m == 'vcategorycode'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['vcategoryname'] = $result['vcategoryname'];
	                }else if($m == 'vunitcode'){
	                   $data['items'][$k][$m] = $result[$m];
	                   $data['items'][$k]['vunitname'] = $result['vunitname'];
	                }else if($m == 'vsuppliercode'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['vcompanyname'] = $result['vcompanyname'];
	                }else if($m == 'stationid'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['stationname'] = $result['stationname'];
	                }else if($m == 'aisleid'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['aislename'] = $result['aislename'];
	                }else if($m == 'shelfid'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['shelfname'] = $result['shelfname'];
	                }else if($m == 'shelvingid'){
	                    $data['items'][$k][$m] = $result[$m];
	                    $data['items'][$k]['shelvingname'] = $result['shelvingname'];
	                }else{
	                    $data['items'][$k][$m] = $result[$m];
	                }
				}

				$data['items'][$k]['QOH'] = $result['IQTYONHAND'];
				$data['items'][$k]['isparentchild'] = $result['isparentchild'];
				$data['items'][$k]['edit'] = $this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true);
				$data['items'][$k]['clone_item'] = $this->url->link('administration/items/clone_item', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true);
			}
			
		}else{
			foreach ($results as $result) {
			
				$data['items'][] = array(
					'iitemid'     	=> $result['iitemid'],
					'vitemtype'   	=> $result['vitemtype'],
					'vitemname'     => $result['vitemname'],
					'VITEMNAME'     => $result['VITEMNAME'],
					'vbarcode' 	   	=> $result['vbarcode'],
					'vcategorycode' => $result['vcategorycode'],
					'vcategoryname' => $result['vcategoryname'],
					'vdepcode'  	=> $result['vdepcode'],
					'vdepartmentname'  	=> $result['vdepartmentname'],
					'vsuppliercode' => $result['vsuppliercode'],
					'vcompanyname' => $result['vcompanyname'],
					'iqtyonhand'  	=> $result['iqtyonhand'],
					'QOH'  	        => $result['IQTYONHAND'],
					'dunitprice'  	=> $result['dunitprice'],
					'isparentchild' => $result['isparentchild'],
					'edit'          => $this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true),
					'clone_item'          => $this->url->link('administration/items/clone_item', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true)
				);
			}
		}
		
		if(count($item_data)==0){ 
			$data['items'] =array();
			$item_total = 0;
			$data['item_row'] =1;
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_itemname'] = $this->language->get('column_itemname');
		$data['column_itemtype'] = $this->language->get('column_itemtype');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_deptcode'] = $this->language->get('column_deptcode');
		$data['column_sku'] = $this->language->get('column_sku');
		$data['column_categorycode'] = $this->language->get('column_categorycode');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_qtyonhand'] = $this->language->get('column_qtyonhand');
		
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');
		
		$data['button_edit_list'] = 'Update Selected';
		$data['text_special'] = '<strong>Special:</strong>';
		
		$data['token'] = $this->session->data['token'];


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($disable_items)) {
			$url .= '&show_items=' . $disable_items;
		}

		if (isset($sort_items)) {
			$url .= '&sort_items=' . $sort_items;
		}

		if(isset($sort_items) && $sort_items != ''){
			if($sort_items == 'DESC'){
				$url1 = '&show_items=' . $disable_items.'&sort_items=ASC';
			}else{
				$url1 = '&show_items=' . $disable_items.'&sort_items=DESC';
			}
		}else{
			$url1 = '&show_items=' . $disable_items.'&sort_items=ASC';
		}
		$data['item_sorting'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url1, true);

		$data['title_arr'] = array(
							'webstore' => 'Web Store',
							'vitemtype' => 'Item Type',
							'vitemcode' => 'Item Code',
							'vitemname' => 'Item Name',
							'vunitcode' => 'Unit',
							'vbarcode' => 'SKU',
							'vpricetype' => 'Price Type',
							'vcategorycode' => 'Category',
							'vdepcode' => 'Dept.',
							'vsuppliercode' => 'Supplier',
							'iqtyonhand' => 'Qty. on Hand',
							'ireorderpoint' => 'Reorder Point',
							'dcostprice' => 'Avg. Case Cost',
							'dunitprice' => 'Price',
							'nsaleprice' => 'Sale Price',
							'nlevel2' => 'Level 2 Price',
							'nlevel3' => 'Level 3 Price',
							'nlevel4' => 'Level 4 Price',
							'iquantity' => 'Quantity',
							'ndiscountper' => 'Discount(%)',
							'ndiscountamt' => 'Discount Amt',
							'vtax1' => 'Tax 1',
							'vtax2' => 'Tax 2',
							'vfooditem' => 'Food Item',
							'vdescription' => 'Description',
							'dlastsold' => 'Last Old',
							'visinventory' => 'Inventory Item',
							'dpricestartdatetime' => 'Price Start Time',
							'dpriceenddatetime' => 'Price End Time',
							'estatus' => 'Status',
							'nbuyqty' => 'Buy Qty',
							'ndiscountqty' => 'Discount Qty',
							'nsalediscountper' => 'Sales Discount',
							'vshowimage' => 'Show Image',
							'itemimage' => 'Image',
							'vageverify' => 'Age Verification',
							'ebottledeposit' => 'Bottle Deposit',
							'nbottledepositamt' => 'Bottle Deposit Amt',
							'vbarcodetype' => 'Barcode Type',
							'ntareweight' => 'Tare Weight',
							'ntareweightper' => 'Tare Weight Per',
							'dcreated' => 'Created',
							'dlastupdated' => 'Last Updated',
							'dlastreceived' => 'Last Received',
							'dlastordered' => 'Last Ordered',
							'nlastcost' => 'Last Cost',
							'nonorderqty' => 'On Order Qty',
							'vparentitem' => 'Parent Item',
							'nchildqty' => 'Child Qty',
							'vsize' => 'Size',
							'npack' => 'Unit Per Case',
							'nunitcost' => 'Unit Cost',
							'ionupload' => 'On upload',
							'nsellunit' => 'Selling Unit',
							'ilotterystartnum' => 'Lottery Start Num',
							'ilotteryendnum' => 'Lottery End Num',
							'etransferstatus' => 'Transfer status',
							'vsequence' => 'Sequence',
							'vcolorcode' => 'Color Code',
							'vdiscount' => 'Discount',
							'norderqtyupto' => 'Order Qty Upto',
							'vshowsalesinzreport' => 'Sales Item',
							'iinvtdefaultunit' => 'Invt. Default Unit',
							'stationid' => 'Station',
							'shelfid' => 'Shelf',
							'aisleid' => 'Aisle',
							'shelvingid' => 'Shelving',
							'rating' => 'Rating',
							'vintage' => 'Vintage',
							'PrinterStationId' => 'Printer Station Id',
							'liability' => 'Liability',
							'isparentchild' => 'is parent child',
							'parentid' => 'parent id',
							'parentmasterid' => 'parent master id',
							'wicitem' => 'wic item',
							);

		$pagination = new Pagination();
		$pagination->total = $item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($item_total - $this->config->get('config_limit_admin'))) ? $item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $item_total, ceil($item_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/item_list', $data));
	}

	protected function getForm() {

		if(isset($this->session->data['tab_selected'])){
			$data['tab_selected'] = $this->session->data['tab_selected'];
		}else{
			$data['tab_selected'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['iitemid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_itemtype'] = $this->language->get('entry_itemtype');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_itemname'] = $this->language->get('entry_itemname');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_unit'] = $this->language->get('entry_unit');
		$data['entry_supplier'] = $this->language->get('entry_supplier');
		$data['entry_deartment'] = $this->language->get('entry_deartment');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_size'] = $this->language->get('entry_size');
		$data['entry_groupname'] = $this->language->get('entry_groupname');
		$data['entry_wic_item'] = $this->language->get('entry_wic_item');
		$data['entry_seq'] = $this->language->get('entry_seq');
		$data['entry_itemcolor'] = $this->language->get('entry_itemcolor');
		$data['entry_unitpercase'] = $this->language->get('entry_unitpercase');
		$data['entry_avg_case_cost'] = $this->language->get('entry_avg_case_cost');
		$data['entry_unitcost'] = $this->language->get('entry_unitcost');
		
		$data['entry_lastcost'] = $this->language->get('entry_lastcost');
		$data['entry_newcost'] = $this->language->get('entry_newcost');
		
		$data['entry_sellingunit'] = $this->language->get('entry_sellingunit');
		$data['entry_sellingprice'] = $this->language->get('entry_sellingprice');
		$data['entry_liability'] = $this->language->get('entry_liability');
		$data['entry_salesitem'] = $this->language->get('entry_salesitem');
		$data['entry_station'] = $this->language->get('entry_station');
		$data['entry_aisle'] = $this->language->get('entry_aisle');
		$data['entry_shelf'] = $this->language->get('entry_shelf');
		$data['entry_shelving'] = $this->language->get('entry_shelving');
		$data['entry_qtyonhand'] = $this->language->get('entry_qtyonhand');
		$data['entry_reorderpoint'] = $this->language->get('entry_reorderpoint');
		$data['entry_orderqtyupto'] = $this->language->get('entry_orderqtyupto');
		$data['entry_level2price'] = $this->language->get('entry_level2price');
		$data['entry_level3price'] = $this->language->get('entry_level3price');
		$data['entry_level4price'] = $this->language->get('entry_level4price');
		$data['entry_discount'] = $this->language->get('entry_discount');
		$data['entry_inventoryitem'] = $this->language->get('entry_inventoryitem');
		$data['entry_fooditem'] = $this->language->get('entry_fooditem');
		$data['entry_ageverification'] = $this->language->get('entry_ageverification');
		$data['entry_taxable'] = $this->language->get('entry_taxable');
		$data['entry_taxable'] = $this->language->get('entry_taxable');
		$data['entry_show_image'] = $this->language->get('entry_show_image');
		$data['entry_bottledeposit'] = $this->language->get('entry_bottledeposit');
		$data['entry_barcodetype'] = $this->language->get('entry_barcodetype');
		$data['entry_vintage'] = $this->language->get('entry_vintage');
		$data['text_discount'] = $this->language->get('text_discount');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_tax1'] = $this->language->get('entry_tax1');
		$data['entry_tax2'] = $this->language->get('entry_tax2');

		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['arr_y_n'][] = $this->language->get('No');
		$data['arr_y_n'][] = $this->language->get('Yes');

		$data['array_yes_no']['Y'] = 'Yes'; 
		$data['array_yes_no']['N'] = 'No';

		$data['array_status']['Active'] = 'Active'; 
		$data['array_status']['Inactive'] = 'Inactive';  

		$data['item_colors'] = array("None","AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet","Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen");

		$data['item_types'][] = 'Standard';
		$data['item_types'][] = 'Kiosk';
		$data['item_types'][] = 'Lot Matrix';
		// $data['item_types'][] = 'Gasoline';
		$data['item_types'][] = 'Lottery';

		$data['barcode_types'][] = 'Code 128';
		$data['barcode_types'][] = 'Code 39';
		$data['barcode_types'][] = 'Code 93';
		$data['barcode_types'][] = 'UPC E';
		$data['barcode_types'][] = 'EAN 8';
		$data['barcode_types'][] = 'EAN 13';
		$data['barcode_types'][] = 'UPC A';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['vbarcode'])) {
			$data['error_vbarcode'] = $this->error['vbarcode'];
		} else {
			$data['error_vbarcode'] = '';
		}

		if (isset($this->error['vitemname'])) {
			$data['error_vitemname'] = $this->error['vitemname'];
		} else {
			$data['error_vitemname'] = '';
		}

		if (isset($this->error['vdescription'])) {
			$data['error_vdescription'] = $this->error['vdescription'];
		} else {
			$data['error_vdescription'] = '';
		}

		if (isset($this->error['vunitcode'])) {
			$data['error_vunitcode'] = $this->error['vunitcode'];
		} else {
			$data['error_vunitcode'] = '';
		}

		if (isset($this->error['vsuppliercode'])) {
			$data['error_vsuppliercode'] = $this->error['vsuppliercode'];
		} else {
			$data['error_vsuppliercode'] = '';
		}

		if (isset($this->error['vdepcode'])) {
			$data['error_vdepcode'] = $this->error['vdepcode'];
		} else {
			$data['error_vdepcode'] = '';
		}

		if (isset($this->error['vcategorycode'])) {
			$data['error_vcategorycode'] = $this->error['vcategorycode'];
		} else {
			$data['error_vcategorycode'] = '';
		}

		if (isset($this->error['unit_id'])) {
			$data['error_unit_id'] = $this->error['unit_id'];
		} else {
			$data['error_unit_id'] = '';
		}

		if (isset($this->error['unit_value'])) {
			$data['error_unit_value'] = $this->error['unit_value'];
		} else {
			$data['error_unit_value'] = '';
		}

		if (isset($this->error['bucket_id'])) {
			$data['error_bucket_id'] = $this->error['bucket_id'];
		} else {
			$data['error_bucket_id'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['iitemid'])) {
			$data['action'] = $this->url->link('administration/items/add', 'token=' . $this->session->data['token'] . $url, true);

			$data['clone_item'] = '';
		} else {
			$data['action'] = $this->url->link('administration/items/edit', 'token=' . $this->session->data['token'] . '&iitemid=' . $this->request->get['iitemid'] . $url, true);

			$data['clone_item'] = $this->url->link('administration/items/clone_item', 'token=' . $this->session->data['token'] . '&iitemid=' . $this->request->get['iitemid'] . $url, true);
		}

		$data['delete'] = $this->url->link('administration/items/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete_vendor_code'] = $this->url->link('administration/items/delete_vendor_code', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'], true);

		$data['action_vendor'] = $this->url->link('administration/items/action_vendor', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_vendor_editlist'] = $this->url->link('administration/items/action_vendor_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_alias_code'] = $this->url->link('api/items/add_alias_code', 'token=' . $this->session->data['token'] . $url, true);
		$data['alias_code_deletelist'] = $this->url->link('api/items/delete_alias_code', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_lot_matrix'] = $this->url->link('api/items/add_lot_matrix', 'token=' . $this->session->data['token'] . $url, true);
		$data['lot_matrix_editlist'] = $this->url->link('administration/items/lot_matrix_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['lot_matrix_deletelist'] = $this->url->link('api/items/delete_lot_matrix', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_slab_price'] = $this->url->link('api/items/add_slab_price', 'token=' . $this->session->data['token'] . $url, true);
		$data['slab_price_editlist'] = $this->url->link('administration/items/slab_price_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['slab_price_deletelist'] = $this->url->link('api/items/slab_price_deletelist', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_parent_item'] = $this->url->link('api/items/add_parent_item', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_remove_parent_item'] = $this->url->link('api/items/remove_parent_item', 'token=' . $this->session->data['token'] . $url, true);
		$data['check_vendor_item_code'] = $this->url->link('administration/items/check_vendor_item_code', 'token=' . $this->session->data['token'] . $url, true);

		$data['searchitem'] = $this->url->link('administration/items/search', 'token=' . $this->session->data['token'] . $url, true);

		// urls for adding category, dept, etc
		$data['Sales'] = 'Sales';
		$data['MISC'] = 'MISC';
		$data['add_new_category'] = $this->url->link('api/category/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_category'] = $this->url->link('api/category', 'token=' . $this->session->data['token'], true);

		$data['add_new_department'] = $this->url->link('api/department/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_department'] = $this->url->link('api/department', 'token=' . $this->session->data['token'], true);

		$data['add_new_size'] = $this->url->link('api/size/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_size'] = $this->url->link('api/size', 'token=' . $this->session->data['token'], true);

		$data['add_new_group'] = $this->url->link('api/group/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_group'] = $this->url->link('api/group', 'token=' . $this->session->data['token'], true);

		$data['add_new_supplier'] = $this->url->link('api/vendor/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_supplier'] = $this->url->link('api/vendor', 'token=' . $this->session->data['token'], true);

		// urls for adding category, dept, etc

		$data['sid'] = $this->session->data['sid'];

		$data['cancel'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url.'&cancel_btn=yes', true);

		$this->load->model('api/items');

		if (isset($this->request->get['iitemid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$item_info = $this->model_api_items->getItem($this->request->get['iitemid']);
			
			//print_r($item_info);
			
			//exit;
			
			
			$data['iitemid'] = $this->request->get['iitemid'];
			$data['edit_page'] = 'edit_page';
			$data['itemvendors'] = $item_info['itemvendors'];
			$data['itemalias'] = $item_info['itemalias'];
			$data['itempacks'] = $item_info['itempacks'];
			$data['itemslabprices'] = $item_info['itemslabprices'];
			$data['itemchilditems'] = $item_info['itemchilditems'];
			$data['itemparentitems'] = $item_info['itemparentitems'];
			$data['remove_parent_item'] = $item_info['remove_parent_item'];
			
// 			$data['last_avg_cost'] = $item_info['last_dcostprice'];

			$unit_data = $this->model_api_items->getItemUnitData($this->request->get['iitemid']);
			$bucket_data = $this->model_api_items->getItemBucketData($this->request->get['iitemid']);
		}

		if (isset($this->request->get['iitemid']) && ($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$data['edit_page'] = 'edit_page';
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['iitemid'])) {
			$data['iitemid'] = $this->request->post['iitemid'];
		} elseif (!empty($item_info)) {
			$data['iitemid'] = $item_info['iitemid'];
		} else {
			$data['iitemid'] = '';
		}	

		if (isset($this->request->post['vitemtype'])) {
			$data['vitemtype'] = $this->request->post['vitemtype'];
		} elseif (!empty($item_info)) {
			$data['vitemtype'] = $item_info['vitemtype'];
		} else {
			$data['vitemtype'] = '';
		}

		if (isset($this->request->post['vitemcode'])) {
			$data['vitemcode'] = $this->request->post['vitemcode'];
		} elseif (!empty($item_info)) {
			$data['vitemcode'] = $item_info['vitemcode'];
		} else {
			$data['vitemcode'] = '';
		}

		if (isset($this->request->post['vbarcode'])) {
			$data['vbarcode'] = $this->request->post['vbarcode'];
		} elseif (!empty($item_info)) {
			$data['vbarcode'] = $item_info['vbarcode'];
		} else {
			$data['vbarcode'] = '';
		}

		if (isset($this->request->post['vitemname'])) {
			$data['vitemname'] = $this->request->post['vitemname'];
		} elseif (!empty($item_info)) {
			$data['vitemname'] = $item_info['vitemname'];
		} else {
			$data['vitemname'] = '';
		}

		if (isset($this->request->post['vdescription'])) {
			$data['vdescription'] = $this->request->post['vdescription'];
		} elseif (!empty($item_info)) {
			$data['vdescription'] = $item_info['vdescription'];
		} else {
			$data['vdescription'] = '';
		}

		if (isset($this->request->post['vunitcode'])) {
			$data['vunitcode'] = $this->request->post['vunitcode'];
		} elseif (!empty($item_info)) {
			$data['vunitcode'] = $item_info['vunitcode'];
		} else {
			$data['vunitcode'] = '';
		}

		if (isset($this->request->post['vsuppliercode'])) {
			$data['vsuppliercode'] = $this->request->post['vsuppliercode'];
		} elseif (!empty($item_info)) {
			$data['vsuppliercode'] = $item_info['vsuppliercode'];
		} else {
			$data['vsuppliercode'] = '';
		}

		if (isset($this->request->post['vdepcode'])) {
			$data['vdepcode'] = $this->request->post['vdepcode'];
		} elseif (!empty($item_info)) {
			$data['vdepcode'] = $item_info['vdepcode'];
		} else {
			$data['vdepcode'] = '';
		}

		if (isset($this->request->post['vcategorycode'])) {
			$data['vcategorycode'] = $this->request->post['vcategorycode'];
		} elseif (!empty($item_info)) {
			$data['vcategorycode'] = $item_info['vcategorycode'];
		} else {
			$data['vcategorycode'] = '';
		}

		if (isset($this->request->post['vsize'])) {
			$data['vsize'] = $this->request->post['vsize'];
		} elseif (!empty($item_info)) {
			$data['vsize'] = $item_info['vsize'];
		} else {
			$data['vsize'] = '';
		}

		if (isset($this->request->post['iitemgroupid'])) {
			$data['iitemgroupid'] = $this->request->post['iitemgroupid'];
		} elseif (!empty($item_info)) {
			$data['iitemgroupid'] = isset($item_info['iitemgroupid']['iitemgroupid']) ? $item_info['iitemgroupid']['iitemgroupid']: '';
		} else {
			$data['iitemgroupid'] = '';
		}

		if (isset($this->request->post['wicitem'])) {
			$data['wicitem'] = $this->request->post['wicitem'];
		} elseif (!empty($item_info)) {
			$data['wicitem'] = $item_info['wicitem'];
		} else {
			$data['wicitem'] = '';
		}

		if (isset($this->request->post['vsequence'])) {
			$data['vsequence'] = $this->request->post['vsequence'];
		} elseif (!empty($item_info)) {
			$data['vsequence'] = $item_info['vsequence'];
		} else {
			$data['vsequence'] = '';
		}

		if (isset($this->request->post['vcolorcode'])) {
			$data['vcolorcode'] = $this->request->post['vcolorcode'];
		} elseif (!empty($item_info)) {
			$data['vcolorcode'] = $item_info['vcolorcode'];
		} else {
			$data['vcolorcode'] = '';
		}

		if (isset($this->request->post['npack'])) {
			$data['npack'] = $this->request->post['npack'];
		} elseif (!empty($item_info)) {
			$data['npack'] = $item_info['npack'];
		} else {
			$data['npack'] = '';
		}

		if (isset($this->request->post['dcostprice'])) {
			$data['dcostprice'] = $this->request->post['dcostprice'];
		} elseif (!empty($item_info)) {
			$data['dcostprice'] = $item_info['dcostprice'];
		} else {
			$data['dcostprice'] = '';
		}

		if (isset($this->request->post['nunitcost'])) {
			$data['nunitcost'] = $this->request->post['nunitcost'];
		} elseif (!empty($item_info)) {
			$data['nunitcost'] = $item_info['nunitcost'];
		} else {
			$data['nunitcost'] = '';
		}

		if (isset($this->request->post['nsellunit'])) {
			$data['nsellunit'] = $this->request->post['nsellunit'];
		} elseif (!empty($item_info)) {
			$data['nsellunit'] = $item_info['nsellunit'];
		} else {
			$data['nsellunit'] = '';
		}

		if (isset($this->request->post['nsaleprice'])) {
			$data['nsaleprice'] = $this->request->post['nsaleprice'];
		} elseif (!empty($item_info)) {
			$data['nsaleprice'] = $item_info['nsaleprice'];
		} else {
			$data['nsaleprice'] = '';
		}

		if (isset($this->request->post['dunitprice'])) {
			$data['dunitprice'] = $this->request->post['dunitprice'];
		} elseif (!empty($item_info)) {
			$data['dunitprice'] = $item_info['dunitprice'];
		} else {
			$data['dunitprice'] = '';
		}

		if (isset($this->request->post['profit_margin'])) {
			$data['profit_margin'] = $this->request->post['profit_margin'];
		} else {
			$data['profit_margin'] = '';
		}

		if (isset($this->request->post['liability'])) {
			$data['liability'] = $this->request->post['liability'];
		} elseif (!empty($item_info)) {
			$data['liability'] = $item_info['liability'];
		} else {
			$data['liability'] = '';
		}

		if (isset($this->request->post['vshowsalesinzreport'])) {
			$data['vshowsalesinzreport'] = $this->request->post['vshowsalesinzreport'];
		} elseif (!empty($item_info)) {
			$data['vshowsalesinzreport'] = $item_info['vshowsalesinzreport'];
		} else {
			$data['vshowsalesinzreport'] = '';
		}

		if (isset($this->request->post['stationid'])) {
			$data['stationid'] = $this->request->post['stationid'];
		} elseif (!empty($item_info)) {
			$data['stationid'] = $item_info['stationid'];
		} else {
			$data['stationid'] = '';
		}

		if (isset($this->request->post['aisleid'])) {
			$data['aisleid'] = $this->request->post['aisleid'];
		} elseif (!empty($item_info)) {
			$data['aisleid'] = $item_info['aisleid'];
		} else {
			$data['aisleid'] = '';
		}

		if (isset($this->request->post['shelfid'])) {
			$data['shelfid'] = $this->request->post['shelfid'];
		} elseif (!empty($item_info)) {
			$data['shelfid'] = $item_info['shelfid'];
		} else {
			$data['shelfid'] = '';
		}

		if (isset($this->request->post['shelvingid'])) {
			$data['shelvingid'] = $this->request->post['shelvingid'];
		} elseif (!empty($item_info)) {
			$data['shelvingid'] = $item_info['shelvingid'];
		} else {
			$data['shelvingid'] = '';
		}

		if (isset($this->request->post['iqtyonhand'])) {
			$data['iqtyonhand'] = $this->request->post['iqtyonhand'];
		} elseif (!empty($item_info)) {
			$data['iqtyonhand'] = $item_info['iqtyonhand'];
		} else {
			$data['iqtyonhand'] = '';
		}

		if (isset($this->request->post['QOH'])) {
			$data['QOH'] = $this->request->post['QOH'];
		} elseif (!empty($item_info)) {
			$data['QOH'] = $item_info['QOH'];
		} else {
			$data['QOH'] = '';
		}

		if (isset($this->request->post['ireorderpoint'])) {
			$data['ireorderpoint'] = $this->request->post['ireorderpoint'];
		} elseif (!empty($item_info)) {
			$data['ireorderpoint'] = $item_info['ireorderpoint'];
		} else {
			$data['ireorderpoint'] = '';
		}

		if (isset($this->request->post['norderqtyupto'])) {
			$data['norderqtyupto'] = $this->request->post['norderqtyupto'];
		} elseif (!empty($item_info)) {
			$data['norderqtyupto'] = $item_info['norderqtyupto'];
		} else {
			$data['norderqtyupto'] = '';
		}

		if (isset($this->request->post['nlevel2'])) {
			$data['nlevel2'] = $this->request->post['nlevel2'];
		} elseif (!empty($item_info)) {
			$data['nlevel2'] = $item_info['nlevel2'];
		} else {
			$data['nlevel2'] = '';
		}

		if (isset($this->request->post['nlevel4'])) {
			$data['nlevel4'] = $this->request->post['nlevel4'];
		} elseif (!empty($item_info)) {
			$data['nlevel4'] = $item_info['nlevel4'];
		} else {
			$data['nlevel4'] = '';
		}

		if (isset($this->request->post['visinventory'])) {
			$data['visinventory'] = $this->request->post['visinventory'];
		} elseif (!empty($item_info)) {
			$data['visinventory'] = $item_info['visinventory'];
		} else {
			$data['visinventory'] = 'Yes';
		}

		if (isset($this->request->post['vageverify'])) {
			$data['vageverify'] = $this->request->post['vageverify'];
		} elseif (!empty($item_info)) {
			$data['vageverify'] = $item_info['vageverify'];
		} else {
			$data['vageverify'] = '';
		}

		if (isset($this->request->post['nlevel3'])) {
			$data['nlevel3'] = $this->request->post['nlevel3'];
		} elseif (!empty($item_info)) {
			$data['nlevel3'] = $item_info['nlevel3'];
		} else {
			$data['nlevel3'] = '';
		}

		if (isset($this->request->post['ndiscountper'])) {
			$data['ndiscountper'] = $this->request->post['ndiscountper'];
		} elseif (!empty($item_info)) {
			$data['ndiscountper'] = $item_info['ndiscountper'];
		} else {
			$data['ndiscountper'] = '';
		}

		if (isset($this->request->post['vfooditem'])) {
			$data['vfooditem'] = $this->request->post['vfooditem'];
		} elseif (!empty($item_info)) {
			$data['vfooditem'] = $item_info['vfooditem'];
		} else {
			$data['vfooditem'] = 'N';
		}

		if (isset($this->request->post['vtax1'])) {
			$data['vtax1'] = $this->request->post['vtax1'];
		} elseif (!empty($item_info)) {
			$data['vtax1'] = $item_info['vtax1'];
		} else {
			$item_tax1_info = $this->model_api_items->getStoreSettingTax1();
			
			if(isset($item_tax1_info['vsettingvalue']) && $item_tax1_info['vsettingvalue'] == 'Yes'){
				$data['vtax1'] = 'Y';
			}else{
				$data['vtax1'] = '';
			}
		}

		if (isset($this->request->post['vtax2'])) {
			$data['vtax2'] = $this->request->post['vtax2'];
		} elseif (!empty($item_info)) {
			$data['vtax2'] = $item_info['vtax2'];
		} else {
			$data['vtax2'] = '';
		}

		if (isset($this->request->post['itemimage'])) {
			$data['itemimage'] = $this->request->post['itemimage'];
		} elseif (!empty($item_info)) {
			$data['itemimage'] = base64_encode($item_info['itemimage']);
		} else {
			$data['itemimage'] = '';
		}

		if (isset($this->request->post['vshowimage'])) {
			$data['vshowimage'] = $this->request->post['vshowimage'];
		} elseif (!empty($item_info)) {
			$data['vshowimage'] = $item_info['vshowimage'];
		} else {
			$data['vshowimage'] = '';
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($item_info)) {
			$data['estatus'] = $item_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		if (isset($this->request->post['ebottledeposit'])) {
			$data['ebottledeposit'] = $this->request->post['ebottledeposit'];
		} elseif (!empty($item_info)) {
			$data['ebottledeposit'] = $item_info['ebottledeposit'];
		} else {
			$data['ebottledeposit'] = '';
		}

		if (isset($this->request->post['nbottledepositamt'])) {
			$data['nbottledepositamt'] = $this->request->post['nbottledepositamt'];
		} elseif (!empty($item_info)) {
			$data['nbottledepositamt'] = $item_info['nbottledepositamt'];
		} else {
			$data['nbottledepositamt'] = '0.00';
		}

		if (isset($this->request->post['vbarcodetype'])) {
			$data['vbarcodetype'] = $this->request->post['vbarcodetype'];
		} elseif (!empty($item_info)) {
			$data['vbarcodetype'] = $item_info['vbarcodetype'];
		} else {
			$data['vbarcodetype'] = '';
		}

		if (isset($this->request->post['vintage'])) {
			$data['vintage'] = $this->request->post['vintage'];
		} elseif (!empty($item_info)) {
			$data['vintage'] = $item_info['vintage'];
		} else {
			$data['vintage'] = '';
		}

		if (isset($this->request->post['vdiscount'])) {
			$data['vdiscount'] = $this->request->post['vdiscount'];
		} elseif (!empty($item_info)) {
			$data['vdiscount'] = $item_info['vdiscount'];
		} else {
			$data['vdiscount'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($item_info)) {
			$data['rating'] = $item_info['rating'];
		} else {
			$data['rating'] = '';
		}

		if (!empty($item_info)) {
			$data['isparentchild'] = $item_info['isparentchild'];
		} else {
			$data['isparentchild'] = '';
		}

		if (!empty($item_info)) {
			$data['parentid'] = $item_info['parentid'];
		} else {
			$data['parentid'] = '';
		}

		if (!empty($item_info)) {
			$data['parentmasterid'] = $item_info['parentmasterid'];
		} else {
			$data['parentmasterid'] = '';
		}

		if (isset($this->request->post['unit_id']) || isset($this->request->post['unit_id'])) {
			$data['unit_id'] = $this->request->post['unit_id'];
			$data['unit_value'] = $this->request->post['unit_value'];
		}else if (!empty($item_info) && !empty($unit_data)) {
			$data['unit_id'] = $unit_data['unit_id'];
			$data['unit_value'] = $unit_data['unit_value'];
		} else {
			$data['unit_id'] = '';
			$data['unit_value'] = '';
		}

		if (isset($this->request->post['bucket_id']) ) {
			$data['bucket_id'] = $this->request->post['bucket_id'];
		} else if (!empty($item_info) && !empty($bucket_data)) {
			$data['bucket_id'] = $bucket_data['bucket_id'];
		} else {
			$data['bucket_id'] = '';
		}

		if (isset($this->request->post['malt'])) {
			$data['malt'] = $this->request->post['malt'];
		} else if (!empty($item_info) && !empty($bucket_data)) {
			$data['malt'] = $bucket_data['malt'];
		} else {
			$data['malt'] = '';
		}

		if (isset($this->request->post['options_checkbox'])) {
			$data['options_checkbox'] = $this->request->post['options_checkbox'];
		}else if (!empty($item_info) && !empty($bucket_data)) {
			$data['options_checkbox'] = 1;
		}else{
			$data['options_checkbox'] = 0;
		}
		
		//=============== Include new_costprice = New Cost ==============================
		if (isset($this->request->post['new_costprice'])) {
			$data['new_costprice'] = $this->request->post['new_costprice'];
		} elseif (!empty($item_info)) {
			$data['new_costprice'] = $item_info['new_costprice'];
		} else {
			$data['new_costprice'] = '';
		}
		
		//print_r($item_info); exit;
		
		
		//=============== Include lastcost = Last Cost ==============================
		if (isset($this->request->post['last_costprice'])) {
			$data['last_costprice'] = $this->request->post['last_costprice'];
		} elseif (!empty($item_info)) {
			$data['last_costprice'] = $item_info['last_costprice'];
		} else {
			$data['last_costprice'] = '';
		}

		$departments = $this->model_administration_items->getDepartments();
		
		$data['departments'] = $departments;

		$categories = $this->model_administration_items->getCategories();
		
		$data['categories'] = $categories;

		$units = $this->model_administration_items->getUnits();
		
		$data['units'] = $units;

		$suppliers = $this->model_administration_items->getSuppliers();
		
		$data['suppliers'] = $suppliers;

		$sizes = $this->model_administration_items->getSizes();
		
		$data['sizes'] = $sizes;

		$itemGroups = $this->model_administration_items->getItemGroups();
		
		$data['itemGroups'] = $itemGroups;

		$ageVerifications = $this->model_administration_items->getAgeVerifications();
		
		$data['ageVerifications'] = $ageVerifications;

		$stations = $this->model_administration_items->getStations();
		
		$data['stations'] = $stations;

		$aisles = $this->model_administration_items->getAisles();
		
		$data['aisles'] = $aisles;

		$shelfs = $this->model_administration_items->getShelfs();
		
		$data['shelfs'] = $shelfs;

		$shelvings = $this->model_administration_items->getShelvings();
		
		$data['shelvings'] = $shelvings;

		$loadChildProducts = $this->model_api_items->getChildProductsLoad();

		$data['loadChildProducts'] = $loadChildProducts;

		$itemsUnits = $this->model_api_items->getItemsUnits();

		$data['itemsUnits'] = $itemsUnits;

		$buckets = $this->model_api_items->getBuckets();

		$data['buckets'] = $buckets;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/item_form', $data));
	}

	protected function getCloneForm() {

		if(isset($this->session->data['tab_selected'])){
			$data['tab_selected'] = $this->session->data['tab_selected'];
		}else{
			$data['tab_selected'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = 'Clone Item';
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_itemtype'] = $this->language->get('entry_itemtype');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_itemname'] = $this->language->get('entry_itemname');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_unit'] = $this->language->get('entry_unit');
		$data['entry_supplier'] = $this->language->get('entry_supplier');
		$data['entry_deartment'] = $this->language->get('entry_deartment');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_size'] = $this->language->get('entry_size');
		$data['entry_groupname'] = $this->language->get('entry_groupname');
		$data['entry_wic_item'] = $this->language->get('entry_wic_item');
		$data['entry_seq'] = $this->language->get('entry_seq');
		$data['entry_itemcolor'] = $this->language->get('entry_itemcolor');
		$data['entry_unitpercase'] = $this->language->get('entry_unitpercase');
		$data['entry_avg_case_cost'] = $this->language->get('entry_avg_case_cost');
		$data['entry_unitcost'] = $this->language->get('entry_unitcost');
		$data['entry_sellingunit'] = $this->language->get('entry_sellingunit');
		$data['entry_sellingprice'] = $this->language->get('entry_sellingprice');
		$data['entry_liability'] = $this->language->get('entry_liability');
		$data['entry_salesitem'] = $this->language->get('entry_salesitem');
		$data['entry_station'] = $this->language->get('entry_station');
		$data['entry_aisle'] = $this->language->get('entry_aisle');
		$data['entry_shelf'] = $this->language->get('entry_shelf');
		$data['entry_shelving'] = $this->language->get('entry_shelving');
		$data['entry_qtyonhand'] = $this->language->get('entry_qtyonhand');
		$data['entry_reorderpoint'] = $this->language->get('entry_reorderpoint');
		$data['entry_orderqtyupto'] = $this->language->get('entry_orderqtyupto');
		$data['entry_level2price'] = $this->language->get('entry_level2price');
		$data['entry_level3price'] = $this->language->get('entry_level3price');
		$data['entry_level4price'] = $this->language->get('entry_level4price');
		$data['entry_discount'] = $this->language->get('entry_discount');
		$data['entry_inventoryitem'] = $this->language->get('entry_inventoryitem');
		$data['entry_fooditem'] = $this->language->get('entry_fooditem');
		$data['entry_ageverification'] = $this->language->get('entry_ageverification');
		$data['entry_taxable'] = $this->language->get('entry_taxable');
		$data['entry_taxable'] = $this->language->get('entry_taxable');
		$data['entry_show_image'] = $this->language->get('entry_show_image');
		$data['entry_bottledeposit'] = $this->language->get('entry_bottledeposit');
		$data['entry_barcodetype'] = $this->language->get('entry_barcodetype');
		$data['entry_vintage'] = $this->language->get('entry_vintage');
		$data['text_discount'] = $this->language->get('text_discount');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_tax1'] = $this->language->get('entry_tax1');
		$data['entry_tax2'] = $this->language->get('entry_tax2');

		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['arr_y_n'][] = $this->language->get('No');
		$data['arr_y_n'][] = $this->language->get('Yes');

		$data['array_yes_no']['Y'] = 'Yes'; 
		$data['array_yes_no']['N'] = 'No';

		$data['array_status']['Active'] = 'Active'; 
		$data['array_status']['Inactive'] = 'Inactive';  

		$data['item_colors'] = array("None","AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet","Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen");

		$data['item_types'][] = 'Standard';
		$data['item_types'][] = 'Kiosk';
		$data['item_types'][] = 'Lot Matrix';
		// $data['item_types'][] = 'Gasoline';
		$data['item_types'][] = 'Lottery';

		$data['barcode_types'][] = 'Code 128';
		$data['barcode_types'][] = 'Code 39';
		$data['barcode_types'][] = 'Code 93';
		$data['barcode_types'][] = 'UPC E';
		$data['barcode_types'][] = 'EAN 8';
		$data['barcode_types'][] = 'EAN 13';
		$data['barcode_types'][] = 'UPC A';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['vbarcode'])) {
			$data['error_vbarcode'] = $this->error['vbarcode'];
		} else {
			$data['error_vbarcode'] = '';
		}

		if (isset($this->error['vitemname'])) {
			$data['error_vitemname'] = $this->error['vitemname'];
		} else {
			$data['error_vitemname'] = '';
		}

		if (isset($this->error['vdescription'])) {
			$data['error_vdescription'] = $this->error['vdescription'];
		} else {
			$data['error_vdescription'] = '';
		}

		if (isset($this->error['vunitcode'])) {
			$data['error_vunitcode'] = $this->error['vunitcode'];
		} else {
			$data['error_vunitcode'] = '';
		}

		if (isset($this->error['vsuppliercode'])) {
			$data['error_vsuppliercode'] = $this->error['vsuppliercode'];
		} else {
			$data['error_vsuppliercode'] = '';
		}

		if (isset($this->error['vdepcode'])) {
			$data['error_vdepcode'] = $this->error['vdepcode'];
		} else {
			$data['error_vdepcode'] = '';
		}

		if (isset($this->error['vcategorycode'])) {
			$data['error_vcategorycode'] = $this->error['vcategorycode'];
		} else {
			$data['error_vcategorycode'] = '';
		}

		if (isset($this->error['unit_id'])) {
            $data['error_unit_id'] = $this->error['unit_id'];
        } else {
            $data['error_unit_id'] = '';
        }

        if (isset($this->error['unit_value'])) {
            $data['error_unit_value'] = $this->error['unit_value'];
        } else {
            $data['error_unit_value'] = '';
        }

        if (isset($this->error['bucket_id'])) {
            $data['error_bucket_id'] = $this->error['bucket_id'];
        } else {
            $data['error_bucket_id'] = '';
        }

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['action'] = $this->url->link('administration/items/clone_item', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['action_vendor'] = $this->url->link('administration/items/action_vendor', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_vendor_editlist'] = $this->url->link('administration/items/action_vendor_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_alias_code'] = $this->url->link('api/items/add_alias_code', 'token=' . $this->session->data['token'] . $url, true);
		$data['alias_code_deletelist'] = $this->url->link('api/items/delete_alias_code', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_lot_matrix'] = $this->url->link('api/items/add_lot_matrix', 'token=' . $this->session->data['token'] . $url, true);
		$data['lot_matrix_editlist'] = $this->url->link('administration/items/lot_matrix_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['lot_matrix_deletelist'] = $this->url->link('api/items/delete_lot_matrix', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_slab_price'] = $this->url->link('api/items/add_slab_price', 'token=' . $this->session->data['token'] . $url, true);
		$data['slab_price_editlist'] = $this->url->link('administration/items/slab_price_editlist', 'token=' . $this->session->data['token'] . $url, true);
		$data['slab_price_deletelist'] = $this->url->link('api/items/slab_price_deletelist', 'token=' . $this->session->data['token'] . $url, true);
		$data['add_parent_item'] = $this->url->link('api/items/add_parent_item', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_remove_parent_item'] = $this->url->link('api/items/remove_parent_item', 'token=' . $this->session->data['token'] . $url, true);

		// urls for adding category, dept, etc
		$data['Sales'] = 'Sales';
		$data['MISC'] = 'MISC';
		$data['add_new_category'] = $this->url->link('api/category/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_category'] = $this->url->link('api/category', 'token=' . $this->session->data['token'], true);

		$data['add_new_department'] = $this->url->link('api/department/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_department'] = $this->url->link('api/department', 'token=' . $this->session->data['token'], true);

		$data['add_new_size'] = $this->url->link('api/size/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_size'] = $this->url->link('api/size', 'token=' . $this->session->data['token'], true);

		$data['add_new_group'] = $this->url->link('api/group/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_group'] = $this->url->link('api/group', 'token=' . $this->session->data['token'], true);

		$data['add_new_supplier'] = $this->url->link('api/vendor/add', 'token=' . $this->session->data['token'], true);
		$data['get_new_supplier'] = $this->url->link('api/vendor', 'token=' . $this->session->data['token'], true);

		// urls for adding category, dept, etc

		$data['sid'] = $this->session->data['sid'];

		$data['cancel'] = $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url.'&cancel_btn=yes', true);

		$this->load->model('api/items');

		if(isset($this->request->post['clone_item_id'])){
			$clone_item_id = $this->request->post['clone_item_id'];
		}else{
			$clone_item_id = $this->request->get['iitemid'];
		}
		
		$item_info = $this->model_api_items->getItem($clone_item_id);

		$unit_data = $this->model_api_items->getItemUnitData($clone_item_id);
        $bucket_data = $this->model_api_items->getItemBucketData($clone_item_id);

		$data['itemvendors'] = array();
		$data['itemalias'] = array();
		$data['itempacks'] = array();
		$data['itemslabprices'] = array();
		$data['itemchilditems'] = array();
		$data['itemparentitems'] = array();
		$data['remove_parent_item'] = array();
		
		$data['token'] = $this->session->data['token'];

		$data['iitemid'] = '';

		$data['clone_item_id'] = $clone_item_id;
	
		if (isset($this->request->post['vitemtype'])) {
			$data['vitemtype'] = $this->request->post['vitemtype'];
		} elseif (!empty($item_info)) {
			$data['vitemtype'] = $item_info['vitemtype'];
		} else {
			$data['vitemtype'] = '';
		}

		if (isset($this->request->post['vitemcode'])) {
			$data['vitemcode'] = $this->request->post['vitemcode'];
		} else {
			$data['vitemcode'] = '';
		}

		if (isset($this->request->post['vbarcode'])) {
			$data['vbarcode'] = $this->request->post['vbarcode'];
		} else {
			$data['vbarcode'] = '';
		}

		if (isset($this->request->post['vitemname'])) {
			$data['vitemname'] = $this->request->post['vitemname'];
		} elseif (!empty($item_info)) {
			$data['vitemname'] = $item_info['vitemname'];
		} else {
			$data['vitemname'] = '';
		}

		if (isset($this->request->post['vdescription'])) {
			$data['vdescription'] = $this->request->post['vdescription'];
		} else {
			$data['vdescription'] = '';
		}

		if (isset($this->request->post['vunitcode'])) {
			$data['vunitcode'] = $this->request->post['vunitcode'];
		} elseif (!empty($item_info)) {
			$data['vunitcode'] = $item_info['vunitcode'];
		} else {
			$data['vunitcode'] = '';
		}

		if (isset($this->request->post['vsuppliercode'])) {
			$data['vsuppliercode'] = $this->request->post['vsuppliercode'];
		} elseif (!empty($item_info)) {
			$data['vsuppliercode'] = $item_info['vsuppliercode'];
		} else {
			$data['vsuppliercode'] = '';
		}

		if (isset($this->request->post['vdepcode'])) {
			$data['vdepcode'] = $this->request->post['vdepcode'];
		} elseif (!empty($item_info)) {
			$data['vdepcode'] = $item_info['vdepcode'];
		} else {
			$data['vdepcode'] = '';
		}

		if (isset($this->request->post['vcategorycode'])) {
			$data['vcategorycode'] = $this->request->post['vcategorycode'];
		} elseif (!empty($item_info)) {
			$data['vcategorycode'] = $item_info['vcategorycode'];
		} else {
			$data['vcategorycode'] = '';
		}

		if (isset($this->request->post['vsize'])) {
			$data['vsize'] = $this->request->post['vsize'];
		} elseif (!empty($item_info)) {
			$data['vsize'] = $item_info['vsize'];
		} else {
			$data['vsize'] = '';
		}

		if (isset($this->request->post['iitemgroupid'])) {
			$data['iitemgroupid'] = $this->request->post['iitemgroupid'];
		} elseif (!empty($item_info)) {
			$data['iitemgroupid'] = isset($item_info['iitemgroupid']['iitemgroupid']) ? $item_info['iitemgroupid']['iitemgroupid']: '';
		} else {
			$data['iitemgroupid'] = '';
		}

		if (isset($this->request->post['wicitem'])) {
			$data['wicitem'] = $this->request->post['wicitem'];
		} else {
			$data['wicitem'] = '0';
		}

		if (isset($this->request->post['vsequence'])) {
			$data['vsequence'] = $this->request->post['vsequence'];
		} elseif (!empty($item_info)) {
			$data['vsequence'] = $item_info['vsequence'];
		} else {
			$data['vsequence'] = '';
		}

		if (isset($this->request->post['vcolorcode'])) {
			$data['vcolorcode'] = $this->request->post['vcolorcode'];
		} elseif (!empty($item_info)) {
			$data['vcolorcode'] = $item_info['vcolorcode'];
		} else {
			$data['vcolorcode'] = '';
		}

		if (isset($this->request->post['npack'])) {
			$data['npack'] = $this->request->post['npack'];
		} elseif (!empty($item_info)) {
			$data['npack'] = $item_info['npack'];
		} else {
			$data['npack'] = '';
		}

		if (isset($this->request->post['dcostprice'])) {
			$data['dcostprice'] = $this->request->post['dcostprice'];
		} elseif (!empty($item_info)) {
			$data['dcostprice'] = $item_info['dcostprice'];
		} else {
			$data['dcostprice'] = '';
		}

		if (isset($this->request->post['nunitcost'])) {
			$data['nunitcost'] = $this->request->post['nunitcost'];
		} elseif (!empty($item_info)) {
			$data['nunitcost'] = $item_info['nunitcost'];
		} else {
			$data['nunitcost'] = '';
		}

		if (isset($this->request->post['nsellunit'])) {
			$data['nsellunit'] = $this->request->post['nsellunit'];
		} elseif (!empty($item_info)) {
			$data['nsellunit'] = $item_info['nsellunit'];
		} else {
			$data['nsellunit'] = '';
		}

		if (isset($this->request->post['nsaleprice'])) {
			$data['nsaleprice'] = $this->request->post['nsaleprice'];
		} elseif (!empty($item_info)) {
			$data['nsaleprice'] = $item_info['nsaleprice'];
		} else {
			$data['nsaleprice'] = '';
		}

		if (isset($this->request->post['dunitprice'])) {
			$data['dunitprice'] = $this->request->post['dunitprice'];
		} elseif (!empty($item_info)) {
			$data['dunitprice'] = $item_info['dunitprice'];
		} else {
			$data['dunitprice'] = '';
		}

		if (isset($this->request->post['profit_margin'])) {
			$data['profit_margin'] = $this->request->post['profit_margin'];
		} else {
			$data['profit_margin'] = '';
		}

		if (isset($this->request->post['liability'])) {
			$data['liability'] = $this->request->post['liability'];
		} else {
			$data['liability'] = 'N';
		}

		if (isset($this->request->post['vshowsalesinzreport'])) {
			$data['vshowsalesinzreport'] = $this->request->post['vshowsalesinzreport'];
		} else {
			$data['vshowsalesinzreport'] = 'No';
		}

		if (isset($this->request->post['stationid'])) {
			$data['stationid'] = $this->request->post['stationid'];
		} elseif (!empty($item_info)) {
			$data['stationid'] = $item_info['stationid'];
		} else {
			$data['stationid'] = '';
		}

		if (isset($this->request->post['aisleid'])) {
			$data['aisleid'] = $this->request->post['aisleid'];
		} elseif (!empty($item_info)) {
			$data['aisleid'] = $item_info['aisleid'];
		} else {
			$data['aisleid'] = '';
		}

		if (isset($this->request->post['shelfid'])) {
			$data['shelfid'] = $this->request->post['shelfid'];
		} elseif (!empty($item_info)) {
			$data['shelfid'] = $item_info['shelfid'];
		} else {
			$data['shelfid'] = '';
		}

		if (isset($this->request->post['shelvingid'])) {
			$data['shelvingid'] = $this->request->post['shelvingid'];
		} elseif (!empty($item_info)) {
			$data['shelvingid'] = $item_info['shelvingid'];
		} else {
			$data['shelvingid'] = '';
		}

		if (isset($this->request->post['iqtyonhand'])) {
			$data['iqtyonhand'] = $this->request->post['iqtyonhand'];
		} else {
			$data['iqtyonhand'] = '';
		}

		if (isset($this->request->post['QOH'])) {
			$data['QOH'] = $this->request->post['QOH'];
		} else {
			$data['QOH'] = '';
		}

		if (isset($this->request->post['ireorderpoint'])) {
			$data['ireorderpoint'] = $this->request->post['ireorderpoint'];
		} elseif (!empty($item_info)) {
			$data['ireorderpoint'] = $item_info['ireorderpoint'];
		} else {
			$data['ireorderpoint'] = '';
		}

		if (isset($this->request->post['norderqtyupto'])) {
			$data['norderqtyupto'] = $this->request->post['norderqtyupto'];
		} elseif (!empty($item_info)) {
			$data['norderqtyupto'] = $item_info['norderqtyupto'];
		} else {
			$data['norderqtyupto'] = '';
		}

		if (isset($this->request->post['nlevel2'])) {
			$data['nlevel2'] = $this->request->post['nlevel2'];
		} elseif (!empty($item_info)) {
			$data['nlevel2'] = $item_info['nlevel2'];
		} else {
			$data['nlevel2'] = '';
		}

		if (isset($this->request->post['nlevel4'])) {
			$data['nlevel4'] = $this->request->post['nlevel4'];
		} elseif (!empty($item_info)) {
			$data['nlevel4'] = $item_info['nlevel4'];
		} else {
			$data['nlevel4'] = '';
		}

		if (isset($this->request->post['visinventory'])) {
			$data['visinventory'] = $this->request->post['visinventory'];
		} else {
			$data['visinventory'] = 'Yes';
		}

		if (isset($this->request->post['vageverify'])) {
			$data['vageverify'] = $this->request->post['vageverify'];
		} elseif (!empty($item_info)) {
			$data['vageverify'] = $item_info['vageverify'];
		} else {
			$data['vageverify'] = '';
		}

		if (isset($this->request->post['nlevel3'])) {
			$data['nlevel3'] = $this->request->post['nlevel3'];
		} elseif (!empty($item_info)) {
			$data['nlevel3'] = $item_info['nlevel3'];
		} else {
			$data['nlevel3'] = '';
		}

		if (isset($this->request->post['ndiscountper'])) {
			$data['ndiscountper'] = $this->request->post['ndiscountper'];
		} elseif (!empty($item_info)) {
			$data['ndiscountper'] = $item_info['ndiscountper'];
		} else {
			$data['ndiscountper'] = '';
		}

		if (isset($this->request->post['vfooditem'])) {
			$data['vfooditem'] = $this->request->post['vfooditem'];
		} else {
			$data['vfooditem'] = 'N';
		}

		if (isset($this->request->post['vtax1'])) {
			$data['vtax1'] = $this->request->post['vtax1'];
		} else {
			$item_tax1_info = $this->model_api_items->getStoreSettingTax1();
			
			if(isset($item_tax1_info['vsettingvalue']) && $item_tax1_info['vsettingvalue'] == 'Yes'){
				$data['vtax1'] = 'Y';
			}else{
				$data['vtax1'] = '';
			}
		}

		if (isset($this->request->post['vtax2'])) {
			$data['vtax2'] = $this->request->post['vtax2'];
		} else {
			$data['vtax2'] = '';
		}

		if (isset($this->request->post['itemimage'])) {
			$data['itemimage'] = $this->request->post['itemimage'];
		} else {
			$data['itemimage'] = '';
		}

		if (isset($this->request->post['vshowimage'])) {
			$data['vshowimage'] = $this->request->post['vshowimage'];
		} else {
			$data['vshowimage'] = '';
		}

		if (isset($this->request->post['estatus'])) {
			$data['estatus'] = $this->request->post['estatus'];
		} elseif (!empty($item_info)) {
			$data['estatus'] = $item_info['estatus'];
		} else {
			$data['estatus'] = '';
		}

		if (isset($this->request->post['ebottledeposit'])) {
			$data['ebottledeposit'] = $this->request->post['ebottledeposit'];
		} else {
			$data['ebottledeposit'] = 'No';
		}

		if (isset($this->request->post['nbottledepositamt'])) {
			$data['nbottledepositamt'] = $this->request->post['nbottledepositamt'];
		} else {
			$data['nbottledepositamt'] = '0.00';
		}

		if (isset($this->request->post['vbarcodetype'])) {
			$data['vbarcodetype'] = $this->request->post['vbarcodetype'];
		} elseif (!empty($item_info)) {
			$data['vbarcodetype'] = $item_info['vbarcodetype'];
		} else {
			$data['vbarcodetype'] = '';
		}

		if (isset($this->request->post['vintage'])) {
			$data['vintage'] = $this->request->post['vintage'];
		} elseif (!empty($item_info)) {
			$data['vintage'] = $item_info['vintage'];
		} else {
			$data['vintage'] = '';
		}

		if (isset($this->request->post['vdiscount'])) {
			$data['vdiscount'] = $this->request->post['vdiscount'];
		} elseif (!empty($item_info)) {
			$data['vdiscount'] = $item_info['vdiscount'];
		} else {
			$data['vdiscount'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($item_info)) {
			$data['rating'] = $item_info['rating'];
		} else {
			$data['rating'] = '';
		}

		if (isset($this->request->post['unit_id']) || isset($this->request->post['unit_id'])) {
            $data['unit_id'] = $this->request->post['unit_id'];
            $data['unit_value'] = $this->request->post['unit_value'];
        }else if (!empty($item_info) && !empty($unit_data)) {
            $data['unit_id'] = $unit_data['unit_id'];
            $data['unit_value'] = $unit_data['unit_value'];
        } else {
            $data['unit_id'] = '';
            $data['unit_value'] = '';
        }

        if (isset($this->request->post['bucket_id']) ) {
            $data['bucket_id'] = $this->request->post['bucket_id'];
        } else if (!empty($item_info) && !empty($bucket_data)) {
            $data['bucket_id'] = $bucket_data['bucket_id'];
        } else {
            $data['bucket_id'] = '';
        }

        if (isset($this->request->post['malt'])) {
            $data['malt'] = $this->request->post['malt'];
        } else if (!empty($item_info) && !empty($bucket_data)) {
            $data['malt'] = $bucket_data['malt'];
        } else {
            $data['malt'] = '';
        }

        if (isset($this->request->post['options_checkbox'])) {
            $data['options_checkbox'] = $this->request->post['options_checkbox'];
        }else if (!empty($item_info) && !empty($bucket_data)) {
            $data['options_checkbox'] = 1;
        }else{
            $data['options_checkbox'] = 0;
        }

		
		$data['isparentchild'] = '';
	
		$data['parentid'] = '';

		$data['parentmasterid'] = '';

		$departments = $this->model_administration_items->getDepartments();
		
		$data['departments'] = $departments;

		$categories = $this->model_administration_items->getCategories();
		
		$data['categories'] = $categories;

		$units = $this->model_administration_items->getUnits();
		
		$data['units'] = $units;

		$suppliers = $this->model_administration_items->getSuppliers();
		
		$data['suppliers'] = $suppliers;

		$sizes = $this->model_administration_items->getSizes();
		
		$data['sizes'] = $sizes;

		$itemGroups = $this->model_administration_items->getItemGroups();
		
		$data['itemGroups'] = $itemGroups;

		$ageVerifications = $this->model_administration_items->getAgeVerifications();
		
		$data['ageVerifications'] = $ageVerifications;

		$stations = $this->model_administration_items->getStations();
		
		$data['stations'] = $stations;

		$aisles = $this->model_administration_items->getAisles();
		
		$data['aisles'] = $aisles;

		$shelfs = $this->model_administration_items->getShelfs();
		
		$data['shelfs'] = $shelfs;

		$shelvings = $this->model_administration_items->getShelvings();
		
		$data['shelvings'] = $shelvings;

		$loadChildProducts = $this->model_api_items->getChildProductsLoad();

		$data['loadChildProducts'] = $loadChildProducts;

		$itemsUnits = $this->model_api_items->getItemsUnits();

        $data['itemsUnits'] = $itemsUnits;

        $buckets = $this->model_api_items->getBuckets();

        $data['buckets'] = $buckets;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/clone_item_form', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/items')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}

  	protected function validateForm() {
		
		$this->load->model('administration/items');
		$this->load->model('api/items');
		
		if (!$this->user->hasPermission('modify', 'administration/items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (($this->request->post['vbarcode'] == '')) {
			$this->error['vbarcode']= 'Please Enter SKU';
		}

		if (($this->request->post['vitemname'] == '')) {
			$this->error['vitemname']= 'Please Enter Item Name';
		}

	/*	if (($this->request->post['vitemname'] != '')) {
			if (preg_match('/[\'^£$%&*()}{@#~?><>,:;!`"|=_+¬-]/', $this->request->post['vitemname'])){
			    $this->error['vitemname']= 'Special Characters are not Allowed';
			}
		}

		if (($this->request->post['vdescription'] != '')) {
			if (preg_match('/[\'^£$%&*()}{@#~?><>,:;!`"|=_+¬-]/', $this->request->post['vdescription'])){
			    $this->error['vdescription']= 'Special Characters are not Allowed';
			}
		}
    */
		if (($this->request->post['vunitcode'] == '')) {
			$this->error['vunitcode']= 'Please Select Unit';
		}

		if (($this->request->post['vsuppliercode'] == '')) {
			$this->error['vsuppliercode']= 'Please Select Supplier';
		}

		if (($this->request->post['vdepcode'] == '')) {
			$this->error['vdepcode']= 'Please Select Department';
		}

		if (($this->request->post['vcategorycode'] == '')) {
			$this->error['vcategorycode']= 'Please Select Category';
		}

		if(isset($this->request->get['iitemid']) && $this->request->get['iitemid'] != ''){
			$item_info = $this->model_api_items->getItem($this->request->get['iitemid']);
			if($item_info['vbarcode'] != $this->request->post['vbarcode']){
				$unique_sku = $this->model_api_items->getSKU($this->request->post['vbarcode']);
				if(count($unique_sku) > 0){
					$this->error['vbarcode']= 'SKU Already Exist';
				}
			}
		}else{
			$unique_sku = $this->model_api_items->getSKU($this->request->post['vbarcode']);
				if(count($unique_sku) > 0){
					$this->error['vbarcode']= 'SKU Already Exist';
				}
		}

		if (isset($this->request->post['options_checkbox']) && $this->request->post['options_checkbox'] == 1) {
			
			if (($this->request->post['unit_id'] == '')) {
				$this->error['unit_id']= 'Please Select Unit';
			}

			if (($this->request->post['unit_value'] == '')) {
				$this->error['unit_value']= 'Please Enter Unit Value';
			}
			if (($this->request->post['bucket_id'] == '')) {
				$this->error['bucket_id']= 'Please Select Bucket';
			}
		}

		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	public function search() {
		$return = array();
		$this->load->model('api/items');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_items->getItemsSearchResult($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['iitemid'] = $value['iitemid'];
				$temp['vitemname'] = $value['vitemname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
		
	}

	public function import_items(){
		$return = array();
		$this->load->model('api/items');
		$this->load->model('api/category');
		$this->load->model('api/department');
		$this->load->model('api/size');
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->files['import_item_file']) && $this->request->files['import_item_file']['name'] != '') {
			//itemcode|itemname|catname|depname|size|price|tax|npack|costprice|iqoh

			if($this->request->post['separated_by'] == 'pipe'){
				$seperatBy = "|";
			}else{
				$seperatBy = ",";
			}
			
			$import_item_file = $this->request->files['import_item_file']['tmp_name'];
			$handle = fopen($import_item_file, "r");
			$msg_exist = '';
			$line_row_index=1;
			if ($handle) {
				while (($strline = fgets($handle)) !== false) {
					$values = explode($seperatBy,$strline);

					if($line_row_index != 1){
						if(count($values) != 10){
							$return['code'] = 0;
							$return['error'] = "Your csv file is not valid";
							$this->response->addHeader('Content-Type: application/json');
						    echo json_encode($return);
							exit;
						}else{

							$itemcode = str_replace('"', '', $values[0]);
							$itemname = str_replace('"', '', $values[1]);
							$catname = str_replace('"', '', $values[2]);
							$depname = str_replace('"', '', $values[3]);
							$size = $values[4];
							$price = $values[5];
							$tax = $values[6];
							$npack = $values[7];
							$costprice = $values[8];
							$iqoh = $values[9];

							if(strlen($itemcode) > 0 && strlen($itemname)){
								$checkItemCode = $this->model_api_items->getSKU($itemcode);
								
								if(count($checkItemCode) == 0){
									$vcatcode = '';
	                                $vdepcode = '';

	                                $vcatcodecount = $this->model_api_category->getCategoryByName($catname);
	                               
	                                if(count($vcatcodecount) > 0){
	                                	$vcatcode = $vcatcodecount['vcategorycode']; 
	                                }else{
	                                	$vcatcode = $this->model_api_category->addCategoryByName($catname);
	                                }

	                                $vdepcodecount = $this->model_api_department->getDepartmentByName($depname);

	                                if(count($vdepcodecount) > 0){
	                                	$vdepcode = $vdepcodecount['vdepcode'];
	                                }else{
	                                	$vdepcode = $this->model_api_department->addDepartmentByName($depname);
	                                }

	                                $sizecount = $this->model_api_size->getSizeByName($size);

	                                if(count($sizecount) == 0){
	                                	$size = $this->model_api_size->addSizeByName($size);
	                                }

	                                $price = str_replace('$','',$price);

	                                $dunitprice = $price;
	                                if($price == ''){
	                                	$dunitprice = '0.00';
	                                }

	                                $costprice = str_replace('$','',$costprice);

	                                $dcostPrice = $costprice;
	                                if($costprice == ''){
	                                	$dcostPrice = '0.00';
	                                }

	                                $vtax1 = 'N';
	                                if($tax == 'Y'){
	                                	$vtax1 = 'Y';
	                                }

	                                if(strlen($iqoh) == 0){
	                                	$iqoh = "0";
	                                }

	                                if(strlen($npack) == '0' || $npack == '0'){
	                                	$npack = 1;
	                                }else{
	                                	$npack = $npack;
	                                }

	                                if($dcostPrice == '0.00' || $dcostPrice == '0.0000'){
	                                	$nunitcost = sprintf("%.4f", $dcostPrice);
	                                }

	                                if(($dcostPrice != '0.00' || $dcostPrice != '0.0000') && $npack != '0'){
	                                	$nunitcost = $dcostPrice / $npack;
	                                	$nunitcost = sprintf("%.4f", $nunitcost);
	                                }else{
	                                	$nunitcost = '0.0000';
	                                }

	                                $data = array();
	                                $data['dlastupdated'] = date('Y-m-d');
	                                $data['dcreated'] = date('Y-m-d');
	                                $data['vbarcode'] = $itemcode;
	                                $data['vitemcode'] = $itemcode;
	                                $data['vitemname'] = $itemname;
	                                $data['vitemtype'] = 'Standard';
	                                $data['vcategorycode'] = $vcatcode;
	                                $data['vdepcode'] = $vdepcode;
	                                $data['estatus'] = 'Active';
	                                $data['dunitprice'] = $dunitprice;
	                                $data['dcostPrice'] = $dcostPrice;
	                                $data['vunitcode'] = 'UNT001';
	                                $data['vtax1'] = $vtax1;
	                                $data['vtax2'] = 'N';
	                                $data['vfooditem'] = 'N';
	                                $data['vsuppliercode'] = '101';
	                                $data['vdescription'] = $itemname;
	                                $data['vshowimage'] = 'No';
	                                $data['iquantity'] = '0';
	                                $data['ireorderpoint'] = '0';
	                                $data['iqtyonhand'] = $iqoh;
	                                $data['npack'] = $npack;
	                                $data['nunitcost'] = $nunitcost;
	                                $data['vsize'] = $size;
	                                $data['ionupload'] = '0';
	                                $data['vcolorcode'] = '';

	                                $this->model_api_items->addImportItems($data);

	                                $msg_exist .= 'Item: '.$itemcode.' inserted'.PHP_EOL;
								}else{
									$msg_exist .= 'Item: '.$itemcode.' already exist'.PHP_EOL;
								}
							}
						}	
					}
					$line_row_index++;
				}
				
				$file_path = DIR_TEMPLATE."/administration/import-item-status-report.txt";

				$myfile = fopen( DIR_TEMPLATE."/administration/import-item-status-report.txt", "w");

				fwrite($myfile,$msg_exist);
				fclose($myfile);

				$return['code'] = 1;
				$return['success'] = "Imported successfully!";
				$this->response->addHeader('Content-Type: application/json');
	    		echo json_encode($return);
				exit;
				
			}else{
				$return['code'] = 0;
				$return['error'] = "file not found!";
			}
		}else{
			$return['code'] = 0;
			$return['error'] = "Please select file!";
		}
		$this->response->addHeader('Content-Type: application/json');
	    echo json_encode($return);
		exit;
	}

	public function delete() {

		$data = array();
		$this->load->model('api/items');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_items->deleteItems($temp_arr);

	        $this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;

		}else{
			$data['error'] = 'Something went wrong';
			// http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;
		}
	}

	public function get_barcode() {

		$json =array();
		$this->load->model('api/items');
		
		if(!empty($this->request->get['vbarcode'])){
			
			$json = $this->model_api_items->getItemByBarcode($this->request->get['vbarcode']);

		}

	    $this->response->addHeader('Content-Type: application/json');
	    echo json_encode($json);
		exit;
	}

	public function check_vendor_item_code() {

		$json =array();
		$this->load->model('api/items');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_items->checkVendorItemCode($temp_arr);

	        $this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;

		}else{
			$data['error'] = 'Something went wrong';
			// http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;
		}
	}

	public function delete_vendor_code() {

		$json =array();
		$this->load->model('api/items');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			$temp_arr = json_decode(file_get_contents('php://input'), true);

			$data = $this->model_api_items->deleteVendorItemCode($temp_arr);

	        $this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;

		}else{
			$data['error'] = 'Something went wrong';
			// http_response_code(401);
			$this->response->addHeader('Content-Type: application/json');
		    echo json_encode($data);
			exit;
		}
	}
	
}
