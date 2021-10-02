<?php
class ControllerAdministrationBelowCostReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/below_cost_report');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('administration/below_cost_report');
		$this->load->model('api/below_cost_report');

		$this->getList();
	}

    public function csv_export() {
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");
        $data['reports'] = $this->session->data['reports'];
        
        $data_row = '';
        
        $data_row .= "Store Name:".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address:".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone:".$this->session->data['storephone'].PHP_EOL;

        if(count($data['reports']) > 0){
            $data_row .= 'Supplier,Item,Department,Cost,Price'.PHP_EOL;

            foreach ($data['reports'] as $key => $value) {
                $data_row .= str_replace(',',' ',$value['suppliername']).','.str_replace(',',' ',$value['itemname']).','.str_replace(',',' ',$value['vname']).','.number_format((float)$value['cost'], 2, '.', '').','.number_format((float)$value['price'], 2, '.', '').PHP_EOL;
            }

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'below-cost-report.csv';

        $file_path = DIR_TEMPLATE."/administration/below-cost-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/below-cost-report.csv", "w");

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
    
    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Below Cost Report';

    $this->response->setOutput($this->load->view('administration/print_below_cost_report_page', $data));
  }

  public function pdf_save_page() {
    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");
    $data['reports'] = $this->session->data['reports'];
    
    $data['storename'] = $this->session->data['storename'];
    
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];

    $data['heading_title'] = 'Below Cost Report';

    $html = $this->load->view('administration/print_below_cost_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Below-Cost-Report.pdf');

  }
	  
	protected function getList() {
    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
        $reportsdata = $this->model_api_below_cost_report->getBelowCostReport($this->request->post);

      $data['reports'] = $reportsdata;

      $data['selected_byreports'] = $this->request->post['report_by'];

      $this->session->data['reports'] = $data['reports'];

    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/below_cost_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('administration/below_cost_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/below_cost_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/below_cost_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/below_cost_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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

    $data['byreports'] = $this->model_administration_below_cost_report->getDepartments();
  
    $data['store_name'] = $this->session->data['storename'];
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];
    

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/below_cost_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/profit_loss')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }

  public function reportdata(){
    $return = array();

    $this->load->model('administration/cash_sales_summary');

    if(!empty($this->request->get['report_by'])){
      if($this->request->get['report_by'] == 1){
        $datas = $this->model_administration_cash_sales_summary->getCategories();
      }elseif($this->request->get['report_by'] == 2){
        $datas = $this->model_administration_cash_sales_summary->getDepartments();
      }

      $return['code'] = 1;
      $return['data'] = $datas;
    }else{
      $return['code'] = 0;
    }
    echo json_encode($return);
    exit;  
  }
	
}