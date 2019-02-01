<?php
class ControllerAdministrationPlcbProducts extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/plcb_products');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}
	  
	protected function getList() {

		$url = '';

		ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

		$this->load->model('api/plcb_products');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/plcb_products', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['plcb_product_update'] = $this->url->link('administration/plcb_products/plcb_product_update', 'token=' . $this->session->data['token'], true);
		$data['searchitem'] = $this->url->link('administration/plcb_products/searchitem', 'token=' . $this->session->data['token'], true);
		$data['current_url'] = $this->url->link('administration/plcb_products', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = "";
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = "";
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->post['searchbox'])) {
			$searchbox =  $this->request->post['searchbox'];
		}else{
			$searchbox = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filter_data = array(
			'sort'  => $sort,
			'order'  => $order,
			'searchbox'  => $searchbox,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$plcb_products_total = $this->model_api_plcb_products->getPlcbProductsTotal($filter_data);

		$plcb_products = $this->model_api_plcb_products->getPlcbProducts($filter_data);


		$data['plcb_products'] = $plcb_products;

		if(count($plcb_products)==0){ 
			$data['plcb_products'] =array();
			$plcb_products_total = 0;
		}

		$data['units'] = $this->model_api_plcb_products->getPlcbunits();
		$data['buckets'] = $this->model_api_plcb_products->getPlcbBuckets();

		$url = '';
		$data['sort'] = $sort;
		$data['order'] = $order;

		if($sort!=''){
			$url .= "&sort=".$sort;
		}

		if($order!=''){
			$url .= "&order=".$order;
		}

		$pagination = new Pagination();
		$pagination->total = $plcb_products_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/plcb_products', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($plcb_products_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($plcb_products_total - $this->config->get('config_limit_admin'))) ? $plcb_products_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $plcb_products_total, ceil($plcb_products_total / $this->config->get('config_limit_admin')));

		$data['heading_title'] = "PLCB Products";

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/plcb_products_list', $data));
	}

	public function plcb_product_update() {

		$this->load->model('api/plcb_products');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$posted_arr = json_decode(file_get_contents('php://input'), true);

			if($posted_arr['iitemid'] != ''){

				$mst_item_size = $this->model_api_plcb_products->getMstItemSize($posted_arr['iitemid']);

				if(count($mst_item_size) > 0){
	                $this->model_api_plcb_products->updateMstItemSize($posted_arr);
	            }else{
	                $this->model_api_plcb_products->insertMstItemSize($posted_arr);
	            }

	            $mst_plcb_item = $this->model_api_plcb_products->getMstPlcbItem($posted_arr['iitemid']);

				if(count($mst_plcb_item) > 0){
	                
	                if($posted_arr['prev_mo_end_qty'] != ''){
	                    $posted_arr['prev_mo_end_qty'] = (int)$posted_arr['prev_mo_end_qty'];
	                }
	                $posted_arr['malt'] = ($posted_arr['malt']) ? (int)$posted_arr['malt'] : 0;
	                
	                $this->model_api_plcb_products->updateMstPlcbItem($posted_arr);
	            }else{
	                if($posted_arr['prev_mo_end_qty'] != ''){
	                    $posted_arr['prev_mo_end_qty'] = (int)$posted_arr['prev_mo_end_qty'];
	                }
	                $posted_arr['malt'] = ($posted_arr['malt']) ? (int)$posted_arr['malt'] : 0;
	                
	                $this->model_api_plcb_products->insertMstPlcbItem($posted_arr);
	            }

	            $json['code'] = 1;
				
			}else{
				$json['code'] = 0;
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function searchitem() {
		$return = array();
		$this->load->model('api/plcb_products');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_plcb_products->getItemsSearchResult($this->request->get['term']);

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
	
}
