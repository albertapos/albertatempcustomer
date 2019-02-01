<?php
class ControllerAdministrationPurchaseOrder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/purchase_order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/purchase_order');

		$this->getList();
	}

	public function add() {
		$this->load->language('administration/purchase_order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/purchase_order');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_administration_purchase_order->addPurchaseOrder($this->request->post);

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

			$this->response->redirect($this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true));
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
		
		if (isset($this->request->get['searchbox'])) {
			$searchbox = $this->request->get['searchbox'];
			$data['searchbox'] = $this->request->get['searchbox'];
		}else if (isset($this->request->post['searchbox'])) {
			$searchbox = $this->request->post['searchbox'];
			$data['searchbox'] = $this->request->post['searchbox'];
		} else {
			$searchbox = '';
			$data['searchbox'] = '';
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ipoid';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['searchbox'])) {
			$url .= '&searchbox=' . $this->request->get['searchbox'];
		}else if (isset($this->request->post['searchbox'])) {
			$url .= '&searchbox=' . $this->request->post['searchbox'];
		}

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
			'href' => $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/purchase_order/add', 'token=' . $this->session->data['token'] . $url, true);

		$data['pos'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$purchase_order_total = $this->model_administration_purchase_order->getTotalPurchaseOrders($filter_data);

		$results = $this->model_administration_purchase_order->getPurchaseOrders($filter_data);

		foreach ($results as $result) {
			
			$data['pos'][] = array(
				'ipoid' => $result['ipoid'],
				'estatus' => $result['estatus'],
				'vponumber' => $result['vponumber'],
				'vinvoiceno' => $result['vinvoiceno'],
				'nnettotal'        => $result['nnettotal'],
				'vvendorname'  => $result['vvendorname'],
				'vordertype'  => $result['vordertype'],
				'dcreatedate'  => $result['dcreatedate'],
				'dreceiveddate'  => $result['dreceiveddate'],
				'LastUpdate'  => $result['LastUpdate'],
				'edit' => $this->url->link('administration/purchase_order/edit', 'token=' . $this->session->data['token'] . '&ipoid=' . $result['ipoid'] . $url, true),
				'delete'=> $this->url->link('administration/purchase_order/delete', 'token=' . $this->session->data['token'] . '&ipoid=' . $result['ipoid'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['column_po'] = $this->language->get('column_po');
		$data['column_invoice'] = $this->language->get('column_invoice');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_vendorname'] = $this->language->get('column_vendorname');
		$data['column_order_type'] = $this->language->get('column_order_type');
		$data['column_cdate'] = $this->language->get('column_cdate');
		$data['column_rdate'] = $this->language->get('column_rdate');
		$data['column_udate'] = $this->language->get('column_udate');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $purchase_order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($purchase_order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($purchase_order_total - $this->config->get('config_limit_admin'))) ? $purchase_order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $purchase_order_total, ceil($purchase_order_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/purchase_order_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ipoid']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

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

		if (isset($this->request->post['venselected'])) {
			$data['venselected'] = (array)$this->request->post['venselected'];
		} else {
			$data['venselected'] = array();
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
			'href' => $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['iitemid'])) {
			$data['action'] = $this->url->link('administration/purchase_order/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('administration/purchase_order/edit', 'token=' . $this->session->data['token'].'&iitemid=' . $this->request->get['iitemid'] . $url, true);
		}

		$data['cancel'] = $this->url->link('administration/purchase_order', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['ipoid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$po_info = $this->model_kiosk_items->getwebItem($this->request->get['ipoid']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('kiosk/menus');
				
		if (isset($this->request->post['vinvoiceno'])) {
			$data['vinvoiceno'] = $this->request->post['vinvoiceno'];
		} elseif (!empty($po_info)) {
			$data['vinvoiceno'] = $po_info['vinvoiceno'];
		} else {
			$data['vinvoiceno'] = '';
		}

		if (isset($this->request->post['vponumber'])) {
			$data['vponumber'] = $this->request->post['vponumber'];
		} elseif (!empty($po_info)) {
			$data['vponumber'] = $po_info['vponumber'];
		} else {
			$data['vponumber'] = '';
		}
		
		if (isset($this->request->post['vordertitle'])) {
			$data['vordertitle'] = $this->request->post['vordertitle'];
		} elseif (!empty($po_info)) {
			$data['vordertitle'] = $po_info['vordertitle'];
		} else {
			$data['vordertitle'] = '';
		}

		if (isset($this->request->post['vorderby'])) {
			$data['vorderby'] = $this->request->post['vorderby'];
		} elseif (!empty($po_info)) {
			$data['vorderby'] = $po_info['vorderby'];
		} else {
			$data['vorderby'] = '';
		}

		if (isset($this->request->post['vnotes'])) {
			$data['vnotes'] = $this->request->post['vnotes'];
		} elseif (!empty($po_info)) {
			$data['vnotes'] = $po_info['vnotes'];
		} else {
			$data['vnotes'] = '';
		}

		if (isset($this->request->post['dcreatedate'])) {
			$data['dcreatedate'] = $this->request->post['dcreatedate'];
		} elseif (!empty($po_info)) {
			$data['dcreatedate'] = $po_info['dcreatedate'];
		} else {
			$data['dcreatedate'] = '';
		}
		if (isset($this->request->post['dreceiveddate'])) {
			$data['dreceiveddate'] = $this->request->post['dreceiveddate'];
		} elseif (!empty($po_info)) {
			$data['dreceiveddate'] = $po_info['dreceiveddate'];
		} else {
			$data['dreceiveddate'] = '';
		}

		if (isset($this->request->post['vconfirmby'])) {
			$data['vconfirmby'] = $this->request->post['vconfirmby'];
		} elseif (!empty($po_info)) {
			$data['vconfirmby'] = $po_info['vconfirmby'];
		} else {
			$data['vconfirmby'] = '';
		}
		if (isset($this->request->post['vshipvia'])) {
			$data['vshipvia'] = $this->request->post['vshipvia'];
		} elseif (!empty($po_info)) {
			$data['vshipvia'] = $po_info['vshipvia'];
		} else {
			$data['vshipvia'] = '';
		}

		if (isset($this->request->post['vvendorname'])) {
			$data['vvendorname'] = $this->request->post['vvendorname'];
		} elseif (!empty($po_info)) {
			$data['vvendorname'] = $po_info['vvendorname'];
		} else {
			$data['vvendorname'] = '';
		}
		
		if (isset($this->request->post['vvendoraddress1'])) {
			$data['vvendoraddress1'] = $this->request->post['vvendoraddress1'];
		} elseif (!empty($po_info)) {
			$data['vvendoraddress1'] = $po_info['vvendoraddress1'];
		} else {
			$data['vvendoraddress1'] = '';
		}

		if (isset($this->request->post['vvendoraddress2'])) {
			$data['vvendoraddress2'] = $this->request->post['vvendoraddress2'];
		} elseif (!empty($po_info)) {
			$data['vvendoraddress2'] = $po_info['vvendoraddress2'];
		} else {
			$data['vvendoraddress2'] = '';
		}
		
		if (isset($this->request->post['vvendorstate'])) {
			$data['vvendorstate'] = $this->request->post['vvendorstate'];
		} elseif (!empty($po_info)) {
			$data['vvendorstate'] = $po_info['vvendorstate'];
		} else {
			$data['vvendorstate'] = '';
		}

		if (isset($this->request->post['vvendorzip'])) {
			$data['vvendorzip'] = $this->request->post['vvendorzip'];
		} elseif (!empty($po_info)) {
			$data['vvendorzip'] = $po_info['vvendorzip'];
		} else {
			$data['vvendorzip'] = '';
		}
		
		if (isset($this->request->post['vvendorphone'])) {
			$data['vvendorphone'] = $this->request->post['vvendorphone'];
		} elseif (!empty($po_info)) {
			$data['vvendorphone'] = $po_info['vvendorphone'];
		} else {
			$data['vvendorphone'] = '';
		}
		
		if (isset($this->request->post['vshpname'])) {
			$data['vshpname'] = $this->request->post['vshpname'];
		} elseif (!empty($po_info)) {
			$data['vshpname'] = $po_info['vshpname'];
		} else {
			$data['vshpname'] = '';
		}
		
		if (isset($this->request->post['vshpaddress1'])) {
			$data['vshpaddress1'] = $this->request->post['vshpaddress1'];
		} elseif (!empty($po_info)) {
			$data['vshpaddress1'] = $po_info['vshpaddress1'];
		} else {
			$data['vshpaddress1'] = '';
		}

		if (isset($this->request->post['vshpaddress2'])) {
			$data['vshpaddress2'] = $this->request->post['vshpaddress2'];
		} elseif (!empty($po_info)) {
			$data['vshpaddress2'] = $po_info['vshpaddress2'];
		} else {
			$data['vshpaddress2'] = '';
		}
		
		if (isset($this->request->post['vshpstate'])) {
			$data['vshpstate'] = $this->request->post['vshpstate'];
		} elseif (!empty($po_info)) {
			$data['vshpstate'] = $po_info['vshpstate'];
		} else {
			$data['vshpstate'] = '';
		}

		if (isset($this->request->post['vshpzip'])) {
			$data['vshpzip'] = $this->request->post['vshpzip'];
		} elseif (!empty($po_info)) {
			$data['vshpzip'] = $po_info['vshpzip'];
		} else {
			$data['vshpzip'] = '';
		}
		
		if (isset($this->request->post['vshpphone'])) {
			$data['vshpphone'] = $this->request->post['vshpphone'];
		} elseif (!empty($po_info)) {
			$data['vshpphone'] = $po_info['vshpphone'];
		} else {
			$data['vshpphone'] = '';
		}

		if (isset($this->request->post['nsubtotal'])) {
			$data['nsubtotal'] = $this->request->post['nsubtotal'];
		} elseif (!empty($po_info)) {
			$data['nsubtotal'] = $po_info['nsubtotal'];
		} else {
			$data['nsubtotal'] = '';
		}
		
		if (isset($this->session->data['selected_vendor'])) {
			$data['selected_vendor'] = $this->session->data['selected_vendor'];
		} else {
			$data['selected_vendor'] = '';
		}

		$vendors = $this->model_administration_purchase_order->getVendors();		
		
		$vandors_total =  count($vendors);
		$data['vendors'] = $vendors;
		
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $vandors_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('kiosk/items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vandors_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($vandors_total - $this->config->get('config_limit_admin'))) ? $vandors_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $vandors_total, ceil($vandors_total / $this->config->get('config_limit_admin')));
		
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/purchase_order_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'administration/purchase_order')) {
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
		if (!$this->user->hasPermission('modify', 'administration/purchase_order')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['searchbox'])) {

			$this->load->model('kiosk/items');

			if (isset($this->request->get['searchbox'])) {
				$searchbox = $this->request->get['searchbox'];
			} else {
				$searchbox = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'searchbox'  => $searchbox,
			);

			$results = $this->model_kiosk_items->getWebItems($filter_data);
	
			foreach ($results as $result) {
				
				$json[] = array(
					'iitemid' => $result['iitemid'],
					'vitemname' => $result['vitemname'],
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function getVendorInfo(){
		
		$json = array();
		
		$this->load->model('administration/purchase_order');	
		
		if (isset($this->request->post['vendorcode'])) {
			$this->session->data['selected_vendor'] = $this->request->post['vendorcode'];
		} else {
			$this->session->data['selected_vendor'] = '';
		}


		$result=$this->model_administration_purchase_order->getVendorsByCode($this->request->post['vendorcode']);
		
		$result2=$this->model_administration_purchase_order->getStoreById();
		
		$json = array(
			'vvendorname' => $result['vcompanyname'],
			'vvendoraddress1' => $result['vaddress1'],
			'vvendoraddress2' => '',
			'vvendorzip' => $result['vzip'],
			'vvendorstate' => $result['vstate'],
			'vvendorphone' => $result['vphone'],						
			'vshpname' => $result2['vstorename'],
			'vshpaddress1' => $result2['vaddress1'],
			'vshpaddress2' => '',
			'vshpstate' => $result2['vstate'],
			'vshpzip' => $result2['vzip'],
			'vshpphone' => $result2['vphone1'],
		);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
