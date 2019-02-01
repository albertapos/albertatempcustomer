<?php
class ControllerAdministrationProductListingReport extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('administration/product_listing_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/product_listing_report');

		$this->getList();
	}
	  
	protected function getList() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      $reports = $this->model_api_product_listing_report->getProductListingReport();

      $data_row = '';
      
      $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
      $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
      $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;
      $data_row .= PHP_EOL;

      if(isset($reports) && count($reports) > 0){
        $data_row .= 'Item Type,SKU,Item Name,QOH,Selling Price,Unit Per Case,Department,Category,Size'.PHP_EOL;

        foreach ($reports as $key => $value) {
          $data_row .= $value['vitemtype'].','.$value['vbarcode'].','.str_replace(',',' ',$value['vitemname']).','.$value['qoh'].','.$value['dunitprice'].','.$value['npack'].','.$value['vdepartmentname'].','.$value['vcategoryname'].','.$value['vsize'].PHP_EOL;
        }

      }else{
        $data_row = 'Sorry no data found!';
      }

      $file_name_csv = $this->session->data['storename'] . '-product-list.csv';

      $file_path = DIR_TEMPLATE."/administration/product-list.csv";

      $myfile = fopen( DIR_TEMPLATE."/administration/product-list.csv", "w");

      fwrite($myfile,$data_row);
      fclose($myfile);

      $content = file_get_contents ($file_path);
      header ('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='.basename($file_name_csv));
      echo $content;
      exit;
      
    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/product_listing_report', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['current_url'] = $this->url->link('administration/product_listing_report', 'token=' . $this->session->data['token'] , true);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');
		
		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
  
        $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/product_listing', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/product_listing_report')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }
	
}
