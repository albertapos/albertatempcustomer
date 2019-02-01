<?php
class ControllerAlbertatestEndOfDayReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('albertatest/end_of_day_report');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('administration/end_of_day_report');
		$this->load->model('albertatest/end_of_day_report');

		$this->getList();
	}

    public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        $report_hourly_sales = $this->session->data['report_hourly_sales'];
        $report_categories = $this->session->data['report_categories'];
        $report_departments = $this->session->data['report_departments'];
        $report_shifts = $this->session->data['report_shifts'];
        $report_tenders = $this->session->data['report_tenders'];

        $data_row = '';

        if(isset($report_shifts[0]['NOPENINGBALANCE'])){
            $data_row .= 'Opening Balance,'. $report_shifts[0]['NOPENINGBALANCE'] .PHP_EOL;
        }else{
            $data_row .= 'Opening Balance,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['CASHONDRAWER'])){
            $data_row .= 'Cash on Drawer,'. $report_shifts[0]['CASHONDRAWER'] .PHP_EOL;
        }else{
            $data_row .= 'Cash on Drawer,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['userclosingbalance'])){
            $data_row .= 'User Closing Balance,'.$report_shifts[0]['userclosingbalance'] .PHP_EOL;
        }else{
            $data_row .= 'User Closing Balance,0'.PHP_EOL;
        }
        
        if(isset($report_shifts[0]['CashShort'])){
            $data_row .= 'Cash Short/Over,'. $report_shifts[0]['CashShort'] .PHP_EOL;
        }else{
            $data_row .= 'Cash Short/Over,0'.PHP_EOL;
        }
        
        if(isset($report_shifts[0]['Nebtsales'])){
            $data_row .= 'Sales,'. $report_shifts[0]['Nebtsales'] .PHP_EOL;
        }else{
            $data_row .= 'Sales,0' .PHP_EOL;
        }

        if(isset($report_shifts[0]['naddcash'])){
            $data_row .= 'Cash Added,'. $report_shifts[0]['naddcash'] .PHP_EOL;
        }else{
            $data_row .= 'Cash Added,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NSUBTOTAL'])){
            $data_row .= 'SubTotal,'. $report_shifts[0]['NSUBTOTAL'] .PHP_EOL;
        }else{
            $data_row .= 'SubTotal,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NCLOSINGBALANCE'])){
            $data_row .= 'Closing Balance,'. $report_shifts[0]['NCLOSINGBALANCE'] .PHP_EOL;
        }else{
            $data_row .= 'Closing Balance,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['NTAXTOTAL'])){
            $data_row .= 'Total Tax,'. $report_shifts[0]['NTAXTOTAL'] .PHP_EOL;
        }else{
            $data_row .= 'Total Tax,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntaxable'])){
            $data_row .= 'Taxable Sales,'. $report_shifts[0]['ntaxable'] .PHP_EOL;
        }else{
            $data_row .= 'Taxable Sales,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['nnontaxabletotal'])){
            $data_row .= 'Nontaxable Sales,'. $report_shifts[0]['nnontaxabletotal'] .PHP_EOL;
        }else{
            $data_row .= 'Nontaxable Sales,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ndiscountamt'])){
            $data_row .= 'Discount,'. $report_shifts[0]['ndiscountamt'] .PHP_EOL;
        }else{
            $data_row .= 'Discount,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntotalsalediscount'])){
            $data_row .= 'Sale Discount,'. $report_shifts[0]['ntotalsalediscount'] .PHP_EOL;
        }else{
            $data_row .= 'Sale Discount,0'.PHP_EOL;
        }

        if(isset($report_shifts[0]['ntotalsaleswtax'])){
            $data_row .= 'Total Sales (Without Tax),'. $report_shifts[0]['ntotalsaleswtax'] .PHP_EOL;
        }else{
            $data_row .= 'Total Sales (Without Tax),0'.PHP_EOL;   
        }
        
        if(isset($report_shifts[0]['noncredittotal'])){
            $data_row .= 'Total Credit Amt,'. $report_shifts[0]['noncredittotal'] .PHP_EOL;
        }else{
            $data_row .= 'Total Credit Amt,0'.PHP_EOL;
        }

        $data_row .= 'Sales by Category'.PHP_EOL;

        if(isset($report_categories) && count($report_categories) > 0){
            foreach($report_categories as $report_category){
                $data_row .= str_replace(',',' ',$report_category['vcategoryame']).','.$report_category['namount'].''.PHP_EOL;
            }
        }else{
            $data_row .= 'Sorry no data found!'.PHP_EOL;
        }

        $data_row .= 'Sales by Department'.PHP_EOL;

        if(isset($report_departments) && count($report_departments) > 0){
            foreach($report_departments as $report_department){
                $data_row .= str_replace(',',' ',$report_department['vdepatname']).','.$report_department['namount'].''.PHP_EOL;
            }
        }else{
            $data_row .= 'Sorry no data found!'.PHP_EOL;
        }

        $file_name_csv = 'end-of-day-report.csv';

        $file_path = DIR_TEMPLATE."/albertatest/end-of-day-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/albertatest/end-of-day-report.csv", "w");

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

    $data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];
    
    $data['storename'] = $this->session->data['storename'];

    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }

    $data['heading_title'] = 'End of Day Report';

    $this->response->setOutput($this->load->view('albertatest/print_end_of_day_report_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];
    
    $data['storename'] = $this->session->data['storename'];

    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }

    $data['heading_title'] = 'End of Day Report';


    $html = $this->load->view('albertatest/print_end_of_day_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('End-of-Day-Report.pdf');
  }
	  
	protected function getList() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

		$url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $data['report_hourly_sales'] = $this->model_albertatest_end_of_day_report->getHourlySalesReport($this->request->post);

            $data['report_categories'] = $this->model_albertatest_end_of_day_report->getCategoriesReport($this->request->post);

            $data['report_departments'] = $this->model_albertatest_end_of_day_report->getDepartmentsReport($this->request->post);

            $data['report_shifts'] = $this->model_albertatest_end_of_day_report->getShiftsReport($this->request->post);

            $data['report_tenders'] = $this->model_albertatest_end_of_day_report->getTenderReport($this->request->post);

            $data['p_start_date'] = $this->request->post['start_date'];
            $this->session->data['p_start_date'] = $data['p_start_date'];

        }else{

            $data['report_hourly_sales'] = $this->model_albertatest_end_of_day_report->getHourlySalesReport();

            $data['report_categories'] = $this->model_albertatest_end_of_day_report->getCategoriesReport();

            $data['report_departments'] = $this->model_albertatest_end_of_day_report->getDepartmentsReport();

            $data['report_shifts'] = $this->model_albertatest_end_of_day_report->getShiftsReport();

            // $data['report_paidouts'] = $this->model_api_end_of_day_report->getPaidoutsReport();

            // $data['report_picups'] = $this->model_api_end_of_day_report->getPicupsReport();

            $data['report_tenders'] = $this->model_albertatest_end_of_day_report->getTenderReport();

        }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('albertatest/end_of_day_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('albertatest/end_of_day_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('albertatest/end_of_day_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('albertatest/end_of_day_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('albertatest/end_of_day_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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

    $this->session->data['report_hourly_sales'] = $data['report_hourly_sales'];
    $this->session->data['report_categories']   = $data['report_categories'];
    $this->session->data['report_departments']  = $data['report_departments'];
    $this->session->data['report_shifts']       = $data['report_shifts'];
    $this->session->data['report_tenders']      = $data['report_tenders'];
  
    $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('albertatest/end_of_day_report_list', $data));
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
