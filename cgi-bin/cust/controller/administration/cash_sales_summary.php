<?php
class ControllerAdministrationCashSalesSummary extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/cash_sales_summary');

		$this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/cash_sales_summary');
		$this->load->model('api/cash_sales_summary');

		$this->getList();
	}

  public function csv_export() {

      ini_set('max_execution_time', 0);
      ini_set("memory_limit", "2G");

      $data['reports'] = $this->session->data['reports'];
      
      $data_row = '';
      $total_hit = 0;
      $total_Net_Amount = 0;
      $total_Cost_Amount = 0;
      $total_Profit_Amount = 0;
      $total_gross_profit = 0;

      if(count($data['reports']) > 0){
          $data_row .= 'Category,Item Sold,Net Amt,Cost Amt,Profit Amt,Gross Profit (%)'.PHP_EOL;

          foreach ($data['reports'] as $key => $value) {

              $pr_amt = (number_format((float)$value['Net_Amount'] - $value['Cost_Amount'], 2, '.', '')) / number_format((float)$value['Net_Amount'], 2, '.', '');

              $data_row .= str_replace(',',' ',$value['name']).','.$value['hit'].','.number_format((float)$value['Net_Amount'], 2, '.', '').','.number_format((float)$value['Cost_Amount'], 2, '.', '').','.number_format((float)$value['Net_Amount'] - $value['Cost_Amount'], 2, '.', '').','.number_format((float)$pr_amt * 100, 2, '.', '').'%'.PHP_EOL;

              $tot_pro = $value['Net_Amount'] - $value['Cost_Amount'];
              $total_hit = $total_hit + $value['hit'];
              $total_Net_Amount = $total_Net_Amount + $value['Net_Amount'] ;
              $total_Cost_Amount = $total_Cost_Amount + $value['Cost_Amount'];
              $total_Profit_Amount = $total_Profit_Amount + $tot_pro;
              $total_gross_profit = $total_gross_profit + $pr_amt;
          }

          $data_row .= 'Total,'. $total_hit .','. number_format((float)$total_Net_Amount, 2, '.', '') .','. number_format((float)$total_Cost_Amount, 2, '.', '') .','. number_format((float)$total_Profit_Amount, 2, '.', '') .','.number_format((float)($total_Profit_Amount / $total_Net_Amount) * 100, 2, '.', '').'%' .PHP_EOL;

      }else{
          $data_row = 'Sorry no data found!';
      }

      $file_name_csv = 'cash-and-sales-summary-report.csv';

      $file_path = DIR_TEMPLATE."/administration/cash-and-sales-summary-report.csv";

      $myfile = fopen( DIR_TEMPLATE."/administration/cash-and-sales-summary-report.csv", "w");

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
    $data['desc_title'] = $this->session->data['desc_title'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Cash & Sales Summary';

    $this->response->setOutput($this->load->view('administration/print_page_list', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];
    $data['desc_title'] = $this->session->data['desc_title'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Cash & Sales Summary';

    $html = $this->load->view('administration/print_page_list', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Cast-and-Sales-Summary.pdf');
  }
	  
	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      if($this->request->post['report_by'] == 1){
        $data['reports'] = $this->model_api_cash_sales_summary->getCategoriesReport($this->request->post);
      }elseif($this->request->post['report_by'] == 2){
        $data['reports'] = $this->model_api_cash_sales_summary->getDepartmentsReport($this->request->post);
      }else{
         $data['reports'] = $this->model_api_cash_sales_summary->getGroupsReport($this->request->post);
      }

      $data['p_start_date'] = $this->request->post['start_date'];
      $data['p_end_date'] = $this->request->post['end_date'];

      if($this->request->post['report_by'] == 1){
        $data['desc_title'] = 'Category';
        $data['drop_down_datas'] = $this->model_administration_cash_sales_summary->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $data['desc_title'] = 'Department';
        $data['drop_down_datas'] = $this->model_administration_cash_sales_summary->getDepartments();
      }else{
        $data['desc_title'] = 'Item Group';
        $data['drop_down_datas'] = $this->model_administration_cash_sales_summary->getGroups();
      }

      $data['selected_report_by'] = $this->request->post['report_by'];
      $data['selected_report_data'] = $this->request->post['report_data'];

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['p_start_date'] = $data['p_start_date'];
      $this->session->data['p_end_date'] = $data['p_end_date'];
      $this->session->data['desc_title'] = $data['desc_title'];

    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/cash_sales_summary', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('administration/cash_sales_summary/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/cash_sales_summary/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/cash_sales_summary/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/cash_sales_summary/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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

    $data['byreports'] = array(
                    1 => 'Category',
                    2 => 'Department',
                    3 => 'Item Group'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/cash_sales_summary_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/plcb_reports')) {
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
      }else{
        $datas = $this->model_administration_cash_sales_summary->getGroups();
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
