<?php
class ControllerAdministrationItemDeleteVoidReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/item_delete_void_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('api/item_delete_void_report');
		
		$this->getList();
	}

	public function csv_export() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

        $data['reports'] = $this->session->data['item_delete_void_reports'];
        
        $data_row = '';
        
        $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;
        $data_row .= PHP_EOL;

        if(count($data['reports']) > 0){
            $data_row .= 'User,Item Barcode,Item Name,Qty,Price,Total Price,Date Time,Action'.PHP_EOL;
            if(isset($data['reports']['voids']) && count($data['reports']['voids']) > 0){
            	foreach ($data['reports']['voids'] as $key => $report) {
	                $data_row .= str_replace(',',' ',$report['vusername']).','.str_replace(',',' ',$report['vitemcode']).','.str_replace(',',' ',$report['vitemname']).','.(int)$report['ndebitqty'].','.$report['nunitprice'].','.$report['nextunitprice'].','.$report['trn_date_time'].','.$report['vtrntype'].PHP_EOL;
	            }
            }

            if(isset($data['reports']['deletes']) && count($data['reports']['deletes']) > 0){
            	foreach ($data['reports']['deletes'] as $key => $report) {
	                $data_row .= str_replace(',',' ',$report['vusername']).','.str_replace(',',' ',$report['vitemcode']).','.str_replace(',',' ',$report['vitemname']).','.(int)$report['ndebitqty'].','.$report['nunitprice'].','.$report['nextunitprice'].','.$report['trn_date_time'].','.$report['vtrntype'].PHP_EOL;
	            }
            }
            

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'item-delete-void-report.csv';

        $file_path = DIR_TEMPLATE."/administration/item-delete-void-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/item-delete-void-report.csv", "w");

        fwrite($myfile,$data_row);
        fclose($myfile);

        $content = file_get_contents ($file_path);
        header ('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_name_csv));
        echo $content;
        exit;
    }

	public function print_page() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

	    $data['reports'] = $this->session->data['item_delete_void_reports'];
	    $data['p_start_date'] = $this->session->data['item_delete_void_p_start_date'];
	    $data['p_end_date'] = $this->session->data['item_delete_void_p_end_date'];
	    
	    $data['storename'] = $this->session->data['storename'];
	    $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

	    $data['heading_title'] = 'Item Delete/Void Report';

	    $this->response->setOutput($this->load->view('administration/print_page_item_delete_void_report_list', $data));
	}

	public function pdf_save_page() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

	    $data['reports'] = $this->session->data['item_delete_void_reports'];
	    $data['p_start_date'] = $this->session->data['item_delete_void_p_start_date'];
	    $data['p_end_date'] = $this->session->data['item_delete_void_p_end_date'];
	    
	    $data['storename'] = $this->session->data['storename'];
	    $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

	    $data['heading_title'] = 'Item Delete/Void Report';

	    $html = $this->load->view('administration/print_page_item_delete_void_report_list', $data);
	    
	    $this->dompdf->loadHtml($html);

	    //(Optional) Setup the paper size and orientation
	    // $this->dompdf->setPaper('A4', 'landscape');

	    // Render the HTML as PDF
	    $this->dompdf->render();

	    // Output the generated PDF to Browser
	    $this->dompdf->stream('item-delete-void-report.pdf');
	 }
	  
	protected function getList() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

		if (isset($this->request->post['start_date'])) {
			$data['start_date'] = $this->request->post['start_date'];
		} elseif (isset($this->request->get['start_date'])) {
			$data['start_date'] = $this->request->get['start_date'];
		} else {
			$data['start_date'] = date('m-d-Y',strtotime('-1 day'));
		}

		if (isset($this->request->post['end_date'])) {
			$data['end_date'] = $this->request->post['end_date'];
		} elseif (isset($this->request->get['end_date'])) {
			$data['end_date'] = $this->request->get['end_date'];
		} else {
			$data['end_date'] = date('m-d-Y');
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($data['start_date'])) {
			$url .= '&start_date=' . urlencode(html_entity_decode($data['start_date'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($data['end_date'])) {
			$url .= '&end_date=' . urlencode(html_entity_decode($data['end_date'], ENT_QUOTES, 'UTF-8'));
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

		$filter_data = array(
			'start_date'  => $data['start_date'],
			'end_date'  => $data['end_date'],
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
	
		$report_datas = $this->model_api_item_delete_void_report->getItemReport($filter_data);
		
		$data['reports'] = $report_datas;	
		
		$this->session->data['item_delete_void_reports'] = $data['reports'];
		$this->session->data['item_delete_void_p_start_date'] = $data['start_date'];
		$this->session->data['item_delete_void_p_end_date'] = $data['end_date'];
			
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/item_delete_void_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['print_page'] = $this->url->link('administration/item_delete_void_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['pdf_save_page'] = $this->url->link('administration/item_delete_void_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['csv_export'] = $this->url->link('administration/item_delete_void_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$data['storename'] = $this->session->data['storename'];
	    $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/item_delete_void_report_list', $data));
	}

}
