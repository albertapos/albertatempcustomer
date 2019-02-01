<?php
class ControllerAlbertatestMonthlySalesReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('albertatest/monthly_sales_report');

		$this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/monthly_sales_report');
		$this->load->model('albertatest/monthly_sales_report');

		$this->getList();
	}

  public function csv_export() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

        $data['reports'] = $this->session->data['reports'];
        
        $data_row = '';

        if(count($data['reports']) > 0){
            $data_row .= 'Date,Sales,Cash Added,Subtotal,Total Tax,Taxable Sales,Nontaxable Sales,Discount,Sale Discount,Total Sales (Without Tax),Total Credit Amt,Total Cash Sales,Total EBT Sales,Total Coupons Sales,Total Paid out'.PHP_EOL;

            $tot_nettotal = 0;
            $tot_nsubtotal = 0;
            $tot_nettotalcashadded = 0;
            $tot_ntaxtotal = 0;
            $tot_ntaxable = 0;
            $tot_nnontaxabletotal = 0;
            $tot_ndiscountamt = 0;
            $tot_ntotalsalediscount = 0;
            $tot_totalsalewithout = 0;
            $tot_totalcreditamt = 0;
            $tot_ntotalcashsales = 0;
            $tot_nnetpaidout = 0;
            $tot_ntotalebtsales = 0;
            $tot_ntotalcouponsales = 0;

            foreach ($data['reports'] as $key => $value) {

              $tot_nettotal = $tot_nettotal + $value['nettotal'];
              $tot_nsubtotal = $tot_nsubtotal + $value['nsubtotal'];
              $tot_nettotalcashadded = $tot_nettotalcashadded + $value['nettotalcashadded'];
              $tot_ntaxtotal = $tot_ntaxtotal + $value['ntaxtotal'];
              $tot_ntaxable = $tot_ntaxable + $value['ntaxable'];
              $tot_nnontaxabletotal = $tot_nnontaxabletotal + $value['nnontaxabletotal'];
              $tot_ndiscountamt = $tot_ndiscountamt + $value['ndiscountamt'];
              $tot_ntotalsalediscount = $tot_ntotalsalediscount + $value['ntotalsalediscount'];
              $tot_totalsalewithout = $tot_totalsalewithout + $value['ntotalsaleswithout'];
              $tot_totalcreditamt = $tot_totalcreditamt + $value['totalcreditamt'];
              $tot_ntotalcashsales = $tot_ntotalcashsales + $value['ntotalcashsales'];
              $tot_ntotalebtsales = $tot_ntotalebtsales + $value['ntotalebtsales'];
              $tot_ntotalcouponsales = $tot_ntotalcouponsales + $value['ntotalcouponsales'];
              $tot_nnetpaidout = $tot_nnetpaidout + $value['nnetpaidout'];

                $data_row .= $value['date_sale'].','.number_format((float)$value['nettotal'], 2, '.', '').','.number_format((float)$value['nettotalcashadded'], 2, '.', '').','.number_format((float)$value['nsubtotal'], 2, '.', '').','.number_format((float)$value['ntaxtotal'], 2, '.', '').','.number_format((float)$value['ntaxable'], 2, '.', '').','.number_format((float)$value['nnontaxabletotal'], 2, '.', '').','.number_format((float)$value['ndiscountamt'], 2, '.', '').','.number_format((float)$value['ntotalsalediscount'], 2, '.', '').','.number_format((float)$value['ntotalsaleswithout'], 2, '.', '').','.number_format((float)$value['totalcreditamt'], 2, '.','').','.number_format((float)$value['ntotalcashsales'], 2, '.','').','.number_format((float)$value['ntotalebtsales'], 2, '.','').','.number_format((float)$value['ntotalcouponsales'], 2, '.','').','.number_format((float)$value['nnetpaidout'], 2, '.','').PHP_EOL;
            }

            $data_row .= 'Total,'.number_format((float)$tot_nettotal, 2, '.', '').','.number_format((float)$tot_nettotalcashadded, 2, '.', '').','.number_format((float)$tot_nsubtotal, 2, '.', '').','.number_format((float)$tot_ntaxtotal, 2, '.', '').','.number_format((float)$tot_ntaxable, 2, '.', '').','.number_format((float)$tot_nnontaxabletotal, 2, '.', '').','.number_format((float)$tot_ndiscountamt, 2, '.', '').','.number_format((float)$tot_ntotalsalediscount, 2, '.', '').','.number_format((float)$tot_totalsalewithout, 2, '.', '').','.number_format((float)$tot_totalcreditamt, 2, '.', '').','.number_format((float)$tot_ntotalcashsales, 2, '.', '').','.number_format((float)$tot_ntotalebtsales, 2, '.', '').','.number_format((float)$tot_ntotalcouponsales, 2, '.', '').','.number_format((float)$tot_nnetpaidout, 2, '.', '').PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'sales-report.csv';

        $file_path = DIR_TEMPLATE."/albertatest/sales-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/albertatest/sales-report.csv", "w");

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

    $data['heading_title'] = 'Sales Report';

    $this->response->setOutput($this->load->view('albertatest/print_monthly_sales_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Sales Report';

    $html = $this->load->view('albertatest/print_monthly_sales_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Sales-Report.pdf');
  }
	  
	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      $report_datas = $this->model_albertatest_monthly_sales_report->getMonthlyReport($this->request->post);

      $data['reports'] = $report_datas;

      $data['p_start_date'] = $this->request->post['start_date'];
      $data['p_end_date'] = $this->request->post['end_date'];

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
			'href' => $this->url->link('albertatest/monthly_sales_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('albertatest/monthly_sales_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('albertatest/monthly_sales_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('albertatest/monthly_sales_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('albertatest/monthly_sales_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$this->response->setOutput($this->load->view('albertatest/monthly_sales_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'albertatest/profit_loss')) {
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
