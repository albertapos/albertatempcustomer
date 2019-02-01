<?php
class ControllerKioskItems extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('kiosk/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/items');

		$this->getList();
	}

	public function add() {
		$this->load->language('kiosk/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_kiosk_items->addItems($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() { 
		$this->load->language('kiosk/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 
			$this->model_kiosk_items->editItems($this->request->get['iitemid'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('kiosk/items');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/items');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $iitemid) {
				$this->model_kiosk_items->deleteItems($iitemid);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'iitemid';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
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
			'href' => $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/items/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('kiosk/items/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['items'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$category_total = $this->model_kiosk_items->getTotalItems();

		$results = $this->model_kiosk_items->getWebItems($filter_data);

		foreach ($results as $result) {
			
			if($result['itemimage']=='')
			{
				$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
				$image = file_get_contents(DIR_IMAGE.'no_image.png');
			}
			else
			{
				$image = $result['itemimage'];
			}
			
			$data['items'][] = array(
				'image'      => base64_encode($image),				
				'iitemid' => $result['iitemid'],
				'vitemname' => $result['vitemname'],
				'vitemtype'        => $result['vitemtype'],
				'vdepcode'  => $result['vdepcode'],
				'vbarcode'  => $result['vbarcode'],
				'dunitprice'  => $result['dunitprice'],
				'vcategorycode'  => $result['vcategorycode'],
				'SID'  => $result['SID'],
				'iqtyonhand'  => $result['iqtyonhand'],
				'edit'        => $this->url->link('kiosk/items/edit', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true),
				'delete'      => $this->url->link('kiosk/items/delete', 'token=' . $this->session->data['token'] . '&iitemid=' . $result['iitemid'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_image'] = $this->language->get('column_image');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['column_itemid'] = $this->language->get('column_itemid');
		$data['column_itemname'] = $this->language->get('column_itemname');
		$data['column_itemtype'] = $this->language->get('column_itemtype');
		$data['column_deptcode'] = $this->language->get('column_deptcode');
		$data['column_sku'] = $this->language->get('column_sku');
		$data['column_categorycode'] = $this->language->get('column_categorycode');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_qtyonhand'] = $this->language->get('column_qtyonhand');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_itemname'] = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . '&sort=itemname' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/items_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['iitemid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');

		$data['entry_itemtype'] = $this->language->get('entry_itemtype');
		$data['entry_itemname'] = $this->language->get('entry_itemname');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_unit'] = $this->language->get('entry_unit');
		$data['entry_deartment'] = $this->language->get('entry_deartment');
		$data['entry_size'] = $this->language->get('entry_size');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_supplier'] = $this->language->get('entry_supplier');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_groupname'] = $this->language->get('entry_groupname');
		$data['entry_seq'] = $this->language->get('entry_seq');
		$data['entry_itemcolor'] = $this->language->get('entry_itemcolor');
		$data['entry_salesitem'] = $this->language->get('entry_salesitem');
		$data['entry_unitpercase'] = $this->language->get('entry_unitpercase');
		$data['entry_casecost'] = $this->language->get('entry_casecost');
		$data['entry_unitcost'] = $this->language->get('entry_unitcost');
		$data['entry_sellingunit'] = $this->language->get('entry_sellingunit');
		$data['entry_sellingprice'] = $this->language->get('entry_sellingprice');
		$data['entry_qtyonhand'] = $this->language->get('entry_qtyonhand');
		$data['entry_reorderpoint'] = $this->language->get('entry_reorderpoint');
		$data['entry_orderqtyupto'] = $this->language->get('entry_orderqtyupto');
		$data['entry_lavel2price'] = $this->language->get('entry_lavel2price');
		$data['entry_lavel3price'] = $this->language->get('entry_lavel3price');
		$data['entry_lavel4price'] = $this->language->get('entry_lavel4price');
		$data['entry_inventoryitem'] = $this->language->get('entry_inventoryitem');
		$data['entry_fooditem'] = $this->language->get('entry_fooditem');
		$data['entry_ageverification'] = $this->language->get('entry_ageverification');
		$data['entry_taxable'] = $this->language->get('entry_taxable');
		$data['entry_bottledeposit'] = $this->language->get('entry_bottledeposit');
		$data['entry_barcodetype'] = $this->language->get('entry_barcodetype');
		$data['entry_discount'] = $this->language->get('entry_discount');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['itemname'])) {
			$data['error_itemname'] = $this->error['itemname'];
		} else {
			$data['error_itemname'] = '';
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
			'href' => $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['iitemid'])) {
			$data['action'] = $this->url->link('kiosk/items/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('kiosk/items/edit', 'token=' . $this->session->data['token'] . '&iitemid=' . $this->request->get['iitemid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['iitemid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$items_info = $this->model_kiosk_items->getwebItem($this->request->get['iitemid']);
		}//print_r($items_info);

		$data['token'] = $this->session->data['token'];

		$this->load->model('kiosk/menus');
		
		$data['menus'] = $this->model_kiosk_menus->getMenus();		
		
				
		$fp = fopen(DIR_IMAGE.'no_image.png', 'rb');
		$no_image = file_get_contents(DIR_IMAGE.'no_image.png');				
		
		if (isset($this->request->post['itemimage'])) {				
			$data['itemimage'] = $this->request->post['itemimage'];
		} elseif (!empty($items_info)) {			
			$image = ($items_info['itemimage']=='')?$no_image:$items_info['itemimage'];			
			$data['itemimage'] = base64_encode($image);
		} else {
			$data['itemimage'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image'])) {
			$data['thumb'] = $this->request->post['image'];
		} elseif (!empty($items_info)) {			
			$image = ($items_info['itemimage']=='')?$no_image:$items_info['itemimage'];			
			$data['thumb'] = base64_encode($image);
		} else {
			$data['thumb'] = base64_encode($no_image);
		}
		
		$data['placeholder'] = base64_encode($no_image);

		if (isset($this->request->post['vitemtype'])) {
			$data['vitemtype'] = $this->request->post['vitemtype'];
		} elseif (!empty($items_info)) {
			$data['vitemtype'] = $items_info['vitemtype'];
		} else {
			$data['vitemtype'] = '';
		}

		if (isset($this->request->post['vitemname'])) {
			$data['vitemname'] = $this->request->post['vitemname'];
		} elseif (!empty($items_info)) {
			$data['vitemname'] = $items_info['vitemname'];
		} else {
			$data['vitemname'] = '';
		}

		$data['units'] = $this->model_kiosk_items->getUnit();	
		$data['departments'] = $this->model_kiosk_items->getDepartment();
		$data['sizes'] = $this->model_kiosk_items->getSize();
		$data['suppliers'] = $this->model_kiosk_items->getSupplier();
		$data['cateorys'] = $this->model_kiosk_items->getCategorys();
		$data['itemgroups'] = $this->model_kiosk_items->getItemgroup();
		$data['ages'] = $this->model_kiosk_items->getAgeverification();
		$data['colors'] = $this->model_kiosk_items->getColor();
		
		if (isset($this->request->post['vunitcode'])) {
			$data['vunitcode'] = $this->request->post['vunitcode'];
		} elseif (!empty($items_info)) {
			$data['vunitcode'] = $items_info['vunitcode'];
		} else {
			$data['vunitcode'] = '';
		}

		if (isset($this->request->post['vdepcode'])) {
			$data['vdepcode'] = $this->request->post['vdepcode'];
		} elseif (!empty($items_info)) {
			$data['vdepcode'] = $items_info['vdepcode'];
		} else {
			$data['vdepcode'] = '';
		}

		if (isset($this->request->post['vsize'])) {
			$data['vsize'] = $this->request->post['vsize'];
		} elseif (!empty($items_info)) {
			$data['vsize'] = $items_info['vsize'];
		} else {
			$data['vsize'] = '';
		}

		if (isset($this->request->post['dcostprice'])) {
			$data['dcostprice'] = $this->request->post['dcostprice'];
		} elseif (!empty($items_info)) {
			$data['dcostprice'] = $items_info['dcostprice'];
		} else {
			$data['dcostprice'] = '';
		}
		if (isset($this->request->post['nunitcost'])) {
			$data['nunitcost'] = $this->request->post['nunitcost'];
		} elseif (!empty($items_info)) {
			$data['nunitcost'] = $items_info['nunitcost'];
		} else {
			$data['nunitcost'] = '';
		}

		if (isset($this->request->post['nlastcost'])) {
			$data['nlastcost'] = $this->request->post['nlastcost'];
		} elseif (!empty($items_info)) {
			$data['nlastcost'] = $items_info['nunitcost'];
		} else {
			$data['nlastcost'] = '0.00';
		}
		if (isset($this->request->post['vbarcode'])) {
			$data['vbarcode'] = $this->request->post['vbarcode'];
		} elseif (!empty($items_info)) {
			$data['vbarcode'] = $items_info['vbarcode'];
		} else {
			$data['vbarcode'] = '';
		}

		if (isset($this->request->post['vsuppliercode'])) {
			$data['vsuppliercode'] = $this->request->post['vsuppliercode'];
		} elseif (!empty($items_info)) {
			$data['vsuppliercode'] = $items_info['vsuppliercode'];
		} else {
			$data['vsuppliercode'] = '';
		}

		if (isset($this->request->post['vcategorycode'])) {
			$data['vcategorycode'] = $this->request->post['vcategorycode'];
		} elseif (!empty($items_info)) {
			$data['vcategorycode'] = $items_info['vcategorycode'];
		} else {
			$data['vcategorycode'] = '';
		}
		
		if (isset($this->request->post['iitemgroupid'])) {
			$data['iitemgroupid'] = $this->request->post['iitemgroupid'];
		} elseif (!empty($items_info)) {
			//$data['iitemgroupid'] = $items_info['iitemgroupid'];
			$data['iitemgroupid'] = '';
		} else {
			$data['iitemgroupid'] = '';
		}

		if (isset($this->request->post['nsellunit'])) {
			$data['nsellunit'] = $this->request->post['nsellunit'];
		} elseif (!empty($items_info)) {
			$data['nsellunit'] = $items_info['nsellunit'];
		} else {
			$data['nsellunit'] = '';
		}

		if (isset($this->request->post['dunitprice'])) {
			$data['dunitprice'] = $this->request->post['dunitprice'];
		} elseif (!empty($items_info)) {
			$data['dunitprice'] = $items_info['dunitprice'];
		} else {
			$data['dunitprice'] = '';
		}

		if (isset($this->request->post['iqtyonhand'])) {
			$data['iqtyonhand'] = $this->request->post['iqtyonhand'];
		} elseif (!empty($items_info)) {
			$data['iqtyonhand'] = $items_info['iqtyonhand'];
		} else {
			$data['iqtyonhand'] = '';
		}

		if (isset($this->request->post['visinventory'])) {
			$data['visinventory'] = $this->request->post['visinventory'];
		} elseif (!empty($items_info)) {
			$data['visinventory'] = $items_info['visinventory'];
		} else {
			$data['visinventory'] = '';
		}

		if (isset($this->request->post['vageverify'])) {
			$data['vageverify'] = $this->request->post['vageverify'];
		} elseif (!empty($items_info)) {
			$data['vageverify'] = $items_info['vageverify'];
		} else {
			$data['vageverify'] = '';
		}

		if (isset($this->request->post['ebottledeposit'])) {
			$data['ebottledeposit'] = $this->request->post['ebottledeposit'];
		} elseif (!empty($items_info)) {
			$data['ebottledeposit'] = $items_info['ebottledeposit'];
		} else {
			$data['ebottledeposit'] = '';
		}

		

		if (isset($this->request->post['ireorderpoint'])) {
			$data['ireorderpoint'] = $this->request->post['ireorderpoint'];
		} elseif (!empty($items_info)) {
			$data['ireorderpoint'] = $items_info['ireorderpoint'];
		} else {
			$data['ireorderpoint'] = '';
		}

		

		if (isset($this->request->post['vtax1'])) {
			$data['vtax1'] = $this->request->post['vtax1'];
		} elseif (!empty($items_info)) {
			$data['vtax1'] = $items_info['vtax1'];
		} else {
			$data['vtax1'] = 'Y';
		}
		if (isset($this->request->post['vtax2'])) {
			$data['vtax2'] = $this->request->post['vtax2'];
		} elseif (!empty($items_info)) {
			$data['vtax2'] = $items_info['vtax2'];
		} else {
			$data['vtax2'] = 'N';
		}

		if (isset($this->request->post['vbarcodetype'])) {
			$data['vbarcodetype'] = $this->request->post['vbarcodetype'];
		} elseif (!empty($items_info)) {
			$data['vbarcodetype'] = $items_info['vbarcodetype'];
		} else {
			$data['vbarcodetype'] = '';
		}

		if (isset($this->request->post['vdiscount'])) {
			$data['vdiscount'] = $this->request->post['vdiscount'];
		} elseif (!empty($items_info)) {
			$data['vdiscount'] = $items_info['vdiscount'];
		} else {
			$data['vdiscount'] = '';
		}

		if (isset($this->request->post['norderqtyupto'])) {
			$data['norderqtyupto'] = $this->request->post['norderqtyupto'];
		} elseif (!empty($items_info)) {
			$data['norderqtyupto'] = $items_info['norderqtyupto'];
		} else {
			$data['norderqtyupto'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('kiosk/items_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'kiosk/items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['vitemname']) < 2) || (utf8_strlen($this->request->post['vitemname']) > 32)) {
			$this->error['itemname']= $this->language->get('error_itemname');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'kiosk/items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function validateSKU(){

		$json = array ();
		
		$this->load->model('kiosk/items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$sql="SELECT count(*) as tot FROM mst_item WHERE vbarcode LIKE '%".$this->request->get['vbarcode']."%'";
			$query = $this->db2->query($sql);
			$row = $query->row;
			$msg='';
			if($row['tot'] == 1)
			{
				$msg="Please Enter Another SKU.";
			}
			else
			{
				$msg='';
			}
			$json = array('msg'=>$msg);
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));			
		}
	}
}
