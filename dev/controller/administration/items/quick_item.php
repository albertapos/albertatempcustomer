<?php
class ControllerAdministrationItemsQuickItem extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/items/quick_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function edit_list() {

		$this->load->language('administration/items/quick_item');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/items/quick_item');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$this->model_api_items_quick_item->editlistItems($this->request->post['quick_item']);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('administration/items/quick_item', 'token=' . $this->session->data['token'] . $url, true));
		}
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Items',
			'href' => $this->url->link('administration/items', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/items/quick_item', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('administration/items/quick_item/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit'] = $this->url->link('administration/items/quick_item/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('administration/items/quick_item/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['edit_list'] = $this->url->link('administration/items/quick_item/edit_list', 'token=' . $this->session->data['token'] . $url, true);
		$data['searchitem'] = $this->url->link('administration/items/quick_item/search', 'token=' . $this->session->data['token'] . $url, true);
		$data['current_url'] = $this->url->link('administration/items/quick_item', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['items'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('administration/menus');

		$this->load->model('tool/image');

		$this->load->model('api/items/quick_item');

		$item_data_total = $this->model_api_items_quick_item->getTotalItems($filter_data);
		$item_total = $item_data_total['total'];
		
		$item_data = $this->model_api_items_quick_item->getItems($filter_data);

		$results = $item_data;

		foreach ($results as $result) {
			
			$data['items'][] = array(
				'iitemgroupid'     	=> $result['iitemgroupid'],
				'vgroupcode'   	=> $result['vgroupcode'],
				'vitemgroupname'     => $result['vitemgroupname'],
				'vterminalid' 	   	=> $result['vterminalid'],
				'estatus' => $result['estatus'],
				'isequence'  	=> $result['isequence']
			);
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

		$pagination = new Pagination();
		$pagination->total = $item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/items/edit_items', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($item_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($item_total - $this->config->get('config_limit_admin'))) ? $item_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $item_total, ceil($item_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/items/quick_item_list', $data));
	}
	
}
