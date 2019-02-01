<?php
class ControllerAdministrationSettings extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/settings');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/settings');

		$this->getList();
	}

	public function edit() {

   		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/settings');
    
		$this->load->model('administration/settings');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditList()) {

			if(count($this->request->post['itemListings']) > 0 ){
				$this->model_administration_settings->editlistSettings($this->request->post['itemListings']);
			}
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/settings', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
  	  }
	  
	protected function getList() {

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/settings', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/settings/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/settings/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/settings/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/settings/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['settings'] = array();
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_value'] = $this->language->get('column_value');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_value'] = $this->language->get('entry_value');

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
		$data['sid'] = $this->session->data['sid'];

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

		$data['defualt_items_listings'] = array();
		$data['pre_items_listings'] = array();
		$not_displays = array('iitemid', 'vitemname', 'vitemtype', 'vbarcode', 'itemimage', 'LastUpdate', 'SID');

		$defualt_items_listings = $this->model_administration_settings->defaultListings();
		$pre_items_listings = $this->model_administration_settings->getItemListings();

		if(count($pre_items_listings) > 0){
			$pre_items_listings = json_decode($pre_items_listings['variablevalue']);
			$data['pre_items_listings'] = $pre_items_listings;

			foreach ($pre_items_listings as $keys => $pre_items_listing) {
				array_push($not_displays, $keys);
			}
		}

		if(count($defualt_items_listings) > 0){
			foreach ($defualt_items_listings as $defualt_items_listing) {
				if(!in_array($defualt_items_listing['Field'], $not_displays)){
					$data['defualt_items_listings'][] = $defualt_items_listing['Field'];
				}
			}
		}

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
							'isparentchild' => 'Is Parent Child',
							'parentid' => 'Parent Id',
							'parentmasterid' => 'Parent Master Id',
							'wicitem' => 'WIC Item'
							);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/settings_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/settings')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}
	
}
