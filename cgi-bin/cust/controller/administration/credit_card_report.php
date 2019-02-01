<?php
class ControllerAdministrationCreditCardReport extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('administration/credit_card_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/credit_card_report');

		$this->getList();
	}

  public function csv_export() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

      $data['reports'] = $this->session->data['reports'];
      
      $data_row = '';

      if(count($data['reports']) > 0){
          $data_row .= 'Supplier,Department,Item,QOH,Cost,Price,Shelf,Shelving,Aisle'.PHP_EOL;

          $tot_cost = 0;
          $tot_price = 0;
          $tot_qoh = 0;

          foreach ($data['reports'] as $key => $value) {
              $data_row .= str_replace(',',' ',$value['suppliername']).','.str_replace(',',' ',$value['vname']).','.str_replace(',',' ',$value['itemname']).','.$value['iqtyonhand'].','.number_format((float)$value['cost'], 2, '.', '').','.number_format((float)$value['price'], 2, '.', '').','.$value['shelf'].','.$value['shelving'].','.$value['aisle'].PHP_EOL;

              $tot_cost = $tot_cost + $value['cost'];
              $tot_price = $tot_price + $value['price'];
              $tot_qoh = $tot_qoh + $value['iqtyonhand'];
          }

          $data_row .= ',,Total,'.$tot_qoh.',$'.number_format((float)$tot_cost, 2, '.', '').',$'.number_format((float)$tot_price, 2, '.', '').',,,'.PHP_EOL;

      }else{
          $data_row = 'Sorry no data found!';
      }

      $file_name_csv = 'zero-movement-report.csv';

      $file_path = DIR_TEMPLATE."/administration/zero-movement-report.csv";

      $myfile = fopen( DIR_TEMPLATE."/administration/zero-movement-report.csv", "w");

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

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Zero Movement Report';

    $this->response->setOutput($this->load->view('administration/print_zero_movement_report_page', $data));
  }

  public function print_receipt() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $this->load->model('api/credit_card_report');
    $this->load->model('api/store');

    $id = 0;
    $by = 'mpstender';

    if(!empty($this->request->get['id'])){
      $id = $this->request->get['id'];
    }

    if(!empty($this->request->get['by'])){
      $by = $this->request->get['by'];
    }

    $data['receipt'] = $this->model_api_credit_card_report->getReceiptData($id,$by);

    $salesid = $data['receipt']['isalesid'];

    $store_info= $this->model_api_store->getStore();
    $sales_header= $this->model_api_credit_card_report->getSalesById($salesid);

    if($sales_header){
      $trn_date = DateTime::createFromFormat('m-d-Y h:i A', $sales_header['trandate']);
      $trn_date = $trn_date->format('m-d-Y');
    }else{
      $trn_date = '';
    }
    
    $sales_detail= $this->model_api_credit_card_report->getSalesPerview($salesid);

    $sales_tender= $this->model_api_credit_card_report->getSalesByTender($salesid);

    $sales_customer= $this->model_api_credit_card_report->getSalesByCustomer($sales_header['icustomerid']);

    $data['store_info'] = $store_info;
    $data['sales_header'] = $sales_header;
    $data['trn_date'] = $trn_date;
    $data['sales_detail'] = $sales_detail;
    $data['sales_tender'] = $sales_tender;
    $data['sales_customer'] = $sales_customer;

    $this->response->setOutput($this->load->view('administration/print_credit_card_report_reciept', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Zero Movement Report';

    $html = $this->load->view('administration/print_zero_movement_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Zero-Movement-Report.pdf');
  }
	  
	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      $data['reports'] = $this->model_api_credit_card_report->getCreditCardReport($this->request->post);

      $data['p_start_date'] = $this->request->post['start_date'];
      $data['p_end_date'] = $this->request->post['end_date'];
      $data['credit_card_number'] = $this->request->post['credit_card_number'];
      $data['credit_card_amount'] = $this->request->post['credit_card_amount'];

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['p_start_date'] = $data['p_start_date'];
      $this->session->data['p_end_date'] = $data['p_end_date'];
      
    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/credit_card_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['report_ajax_data'] = $this->url->link('administration/credit_card_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/credit_card_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/credit_card_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/credit_card_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/credit_card_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);

    $data['print_receipt'] = $this->url->link('administration/credit_card_report/print_receipt', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$this->response->setOutput($this->load->view('administration/credit_card_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/credit_card_report')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }

  public function report_ajax_data() {

    $json =array();
    $this->load->model('api/credit_card_report');
    
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      $temp_arr = json_decode(file_get_contents('php://input'), true);

      if(!empty($temp_arr['report_pull_by'])){
        $data = $this->model_api_credit_card_report->ajaxDataCreditCardReport($temp_arr);
      }else{
        $data = array();
      }

      $this->response->addHeader('Content-Type: application/json');
      echo json_encode($data);
      exit;

    }
  }
	
}
