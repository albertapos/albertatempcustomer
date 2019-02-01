<?php
class ControllerAdministrationProfitLoss extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/profit_loss');

		$this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/profit_loss');
		$this->load->model('api/profit_loss');

		$this->getList();
	}

  public function csv_export() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

        $data['reports'] = $this->session->data['reports'];
        $data_grand_total_qty_sold = $this->session->data['data_grand_total_qty_sold'];
        $data_grand_total_total_cost = $this->session->data['data_grand_total_total_cost'];
        $data_grand_total_total_price = $this->session->data['data_grand_total_total_price'];
        $data_grand_total_total_amount = $this->session->data['data_grand_total_total_amount'];
        $data_grand_total_net_amt = $this->session->data['data_grand_total_net_amt'];
        
        $data_row = '';
        $grand_total_qty_sold = 0;
        $grand_total_total_cost = 0;
        $grand_total_total_price = 0;
        $grand_total_mark_up = 0;
        $grand_total_gross_profit = 0;
        $grand_total_number_of_rows = 0;
        $grand_g_p_percent = 0;
        
        $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;
        $data_row .= PHP_EOL;

        if(count($data['reports']) > 0){
            $data_row .= 'Name,Item Sold,% of Items,Net Amt,% of Sales,Cost Amt,Profit Amt,Mark Up(%),Gross Profit (%)'.PHP_EOL;

            foreach ($data['reports'] as $key => $value) {

              $total_qty_sold = 0;
              $total_total_cost = 0;
              $total_total_price = 0;
              $total_mark_up = 0;
              $total_gross_profit = 0;
              $total_gross_profit_percent = 0;
              $sub_total_number_of_rows = 0;
              $sub_total_percent_item = 0;
              $data_row .= $key.',,,,,,,'.PHP_EOL;
              foreach ($value['items'] as $k => $v){
                $grand_total_number_of_rows++ ;
                $sub_total_number_of_rows++ ;

                if($v['TOTUNITPRICE'] != 0.00){
                  $p_profit = $v['Amount'] / $v['TOTUNITPRICE'];
                }else{
                  $p_profit = $v['Amount'];
                }

                $data_row .= str_replace(',',' ',$v['vITemName']).','.$v['TotalQty'].','.number_format((float)($v['TotalQty']/$value['TotalQty'])*100, 2, '.', '').'%,'.number_format((float)$v['NetAmt'], 2, '.', '').','.number_format((float)($v['NetAmt']/$value['NetAmt'])*100, 2, '.', '').'%,'.number_format((float)$v['TotCostPrice'], 2, '.', '').','.number_format((float)$v['Amount'], 2, '.', '').','.number_format((float)$v['AmountPer'], 2, '.', '') .'%'.','.number_format((float)$p_profit * 100, 2, '.', '') .'%'.PHP_EOL;

                $total_qty_sold = $total_qty_sold + $v['TotalQty'];
                $total_total_cost = $total_total_cost + number_format((float)$v['TotCostPrice'], 2, '.', '') ;
                $total_total_price = $total_total_price + number_format((float)$v['TOTUNITPRICE'], 2, '.', '') ;
                $total_mark_up = $total_mark_up + number_format((float)$v['AmountPer'], 2, '.', '') ;
                $total_gross_profit = $total_gross_profit + number_format((float)$v['Amount'], 2, '.', '') ;
                $total_gross_profit_percent = $total_gross_profit_percent + number_format((float)$p_profit, 2, '.', '') ;
                $sub_total_percent_item = $sub_total_percent_item + number_format((float)($v['TotalQty']/$value['TotalQty'])*100, 2, '.', '');

              }

              if($total_total_cost != '0.00'){
                $sub_tot_mark_up = ($total_gross_profit / $total_total_cost) * 100;
              }else{
                $sub_tot_mark_up = 100;
              }

              $data_row .= 'Sub Total,'.$total_qty_sold.','.number_format((float)$sub_total_percent_item, 2, '.', '').'%,'.number_format((float)$value['NetAmt'], 2, '.', '').','.number_format((float)($value['NetAmt']/$data_grand_total_net_amt)*100, 2, '.', '').'%,'.number_format((float)$total_total_cost, 2, '.', '').','.number_format((float)$total_gross_profit, 2, '.', '').','.number_format((float)$sub_tot_mark_up, 2, '.', '') .'%'.','.number_format((float)($total_gross_profit / $total_total_price) * 100, 2, '.', '') .'%'.PHP_EOL;

              $grand_total_qty_sold = $grand_total_qty_sold + $total_qty_sold;
              $grand_total_total_cost = $grand_total_total_cost + $total_total_cost;
              $grand_total_total_price = $grand_total_total_price + $total_total_price;
              $grand_total_mark_up = $grand_total_mark_up + $total_mark_up;
              $grand_total_gross_profit = $grand_total_gross_profit + $total_gross_profit;
              $grand_g_p_percent = $grand_g_p_percent + $total_gross_profit_percent;
            }

            if($grand_total_total_cost != '0.00'){
              $tot_mark_up = ($data_grand_total_total_amount / $grand_total_total_cost) * 100;
            }else{
              $tot_mark_up = 100;
            }
            
            $data_row .= 'Grand Total,'.$grand_total_qty_sold.',100.00%,$'.number_format((float)$data_grand_total_net_amt, 2, '.', '').',100.00%,$'.number_format((float)$grand_total_total_cost, 2, '.', '').',$'.number_format((float)$data_grand_total_total_amount, 2, '.', '').','.number_format((float)$tot_mark_up, 2, '.', '') .'%'.','.number_format((float)($grand_total_gross_profit / $grand_total_total_price) * 100, 2, '.', '') .'%'.PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'profit-loss-report.csv';

        $file_path = DIR_TEMPLATE."/administration/profit-loss-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/profit-loss-report.csv", "w");

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

    ini_set('max_execution_time', 0);
    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['data_grand_total_qty_sold'] = $this->session->data['data_grand_total_qty_sold'];
    $data['data_grand_total_total_cost'] = $this->session->data['data_grand_total_total_cost'];
    $data['data_grand_total_total_price'] = $this->session->data['data_grand_total_total_price'];
    $data['data_grand_total_total_amount'] = $this->session->data['data_grand_total_total_amount'];
    $data['data_grand_total_net_amt'] = $this->session->data['data_grand_total_net_amt'];

    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];

    $data['heading_title'] = 'Profit & Loss Report';

    $this->response->setOutput($this->load->view('administration/print_profit_loss_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    ini_set('max_execution_time', 0);
    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];
    $data['data_grand_total_qty_sold'] = $this->session->data['data_grand_total_qty_sold'];
    $data['data_grand_total_total_cost'] = $this->session->data['data_grand_total_total_cost'];
    $data['data_grand_total_total_price'] = $this->session->data['data_grand_total_total_price'];
    $data['data_grand_total_net_amt'] = $this->session->data['data_grand_total_net_amt'];

    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];

    $data['heading_title'] = 'Profit & Loss Report';

    $html = $this->load->view('administration/print_profit_loss_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Profit-and-loss-Report.pdf');
  }
	  
	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_api_profit_loss->getCategoriesReport($this->request->post);
        $data['drop_down_datas'] = $this->model_administration_profit_loss->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_api_profit_loss->getDepartmentsReport($this->request->post);
        $data['drop_down_datas'] = $this->model_administration_profit_loss->getDepartments();
      }else if($this->request->post['report_by'] == 3){
        $reportsdata = $this->model_api_profit_loss->getItemGroupsReport($this->request->post);
        $data['drop_down_datas'] = $this->model_administration_profit_loss->getGroups();
      }

      $report_datas = array();

      $grand_total_qty_sold = 0;
      $grand_total_total_cost = 0;
      $grand_total_total_price = 0;
      $grand_total_total_amount = 0;
      $grand_total_net_amt = 0;

      foreach ($reportsdata as $k => $v) {
        if(array_key_exists($v['vname'],$report_datas)){
            $v['NetAmt'] = $v['TOTUNITPRICE'];
            $report_datas[$v['vname']]['items'][] = $v;
            $report_datas[$v['vname']]['TotalQty'] = $report_datas[$v['vname']]['TotalQty'] + $v['TotalQty'];
            $report_datas[$v['vname']]['TOTUNITPRICE'] = $report_datas[$v['vname']]['TOTUNITPRICE'] + $v['TOTUNITPRICE'];
            $report_datas[$v['vname']]['TotCostPrice'] = $report_datas[$v['vname']]['TotCostPrice'] + $v['TotCostPrice'];
            $report_datas[$v['vname']]['Amount'] = $report_datas[$v['vname']]['Amount'] + $v['Amount'];
            $report_datas[$v['vname']]['AmountPer'] = $report_datas[$v['vname']]['AmountPer'] + $v['AmountPer'];
            //$report_datas[$v['vname']]['NetAmt'] = $report_datas[$v['vname']]['NetAmt'] + ($v['TotCostPrice']+$v['TOTUNITPRICE']);
			$report_datas[$v['vname']]['NetAmt'] = $report_datas[$v['vname']]['NetAmt'] + ($v['TOTUNITPRICE']);

        }else{
            $v['NetAmt'] = $v['TOTUNITPRICE'];
            $report_datas[$v['vname']]['items'][] = $v;
            $report_datas[$v['vname']]['TotalQty'] = $v['TotalQty'];
            $report_datas[$v['vname']]['TOTUNITPRICE'] = $v['TOTUNITPRICE'];
            $report_datas[$v['vname']]['TotCostPrice'] = $v['TotCostPrice'];
            $report_datas[$v['vname']]['Amount'] = $v['Amount'];
            $report_datas[$v['vname']]['AmountPer'] = $v['AmountPer'];
            //$report_datas[$v['vname']]['NetAmt'] = ($v['TotCostPrice']+$v['TOTUNITPRICE']);
			$report_datas[$v['vname']]['NetAmt'] = ($v['TOTUNITPRICE']);
        }

        $grand_total_qty_sold = $grand_total_qty_sold + $v['TotalQty'];
        $grand_total_total_cost = $grand_total_total_cost + $v['TotCostPrice'];
        $grand_total_total_price = $grand_total_total_price + $v['TOTUNITPRICE'];
        $grand_total_total_amount = $grand_total_total_amount + $v['Amount'];
        //$grand_total_net_amt = $grand_total_net_amt + ($v['TotCostPrice']+$v['TOTUNITPRICE']);
		$grand_total_net_amt = $grand_total_net_amt + ($v['TOTUNITPRICE']);
      }

      $data['reports'] = $report_datas;
      $data['data_grand_total_qty_sold'] = $grand_total_qty_sold;
      $data['data_grand_total_total_cost'] = $grand_total_total_cost;
      $data['data_grand_total_total_price'] = $grand_total_total_price;
      $data['data_grand_total_total_amount'] = $grand_total_total_amount;
      $data['data_grand_total_net_amt'] = $grand_total_net_amt;

      $data['selected_report_by'] = $this->request->post['report_by'];
      $data['selected_report_data'] = $this->request->post['report_data'];

      $data['p_start_date'] = $this->request->post['start_date'];
      $data['p_end_date'] = $this->request->post['end_date'];

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['p_start_date'] = $data['p_start_date'];
      $this->session->data['p_end_date'] = $data['p_end_date'];
      $this->session->data['data_grand_total_qty_sold'] = $data['data_grand_total_qty_sold'];
      $this->session->data['data_grand_total_total_cost'] = $data['data_grand_total_total_cost'];
      $this->session->data['data_grand_total_total_price'] = $data['data_grand_total_total_price'];
      $this->session->data['data_grand_total_total_amount'] = $data['data_grand_total_total_amount'];
      $this->session->data['data_grand_total_net_amt'] = $data['data_grand_total_net_amt'];

    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/profit_loss', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['report_ajax_data'] = $this->url->link('administration/profit_loss/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/profit_loss/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/profit_loss/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/profit_loss/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/profit_loss/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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
        
        $data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];
        

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/profit_loss_list', $data));
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
      }elseif($this->request->get['report_by'] == 3){
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

  public function report_ajax_data() {

    $json =array();
    $this->load->model('api/profit_loss');
    
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      $temp_arr = json_decode(file_get_contents('php://input'), true);

      if($temp_arr['report_by'] == 1){
        $data = $this->model_api_profit_loss->ajaxDataReportCategory($temp_arr);
      }else if($temp_arr['report_by'] == 2){
        $data = $this->model_api_profit_loss->ajaxDataReportDepartment($temp_arr);
      }else if($temp_arr['report_by'] == 3){
        $data = $this->model_api_profit_loss->ajaxDataReportItemGroup($temp_arr);
      }else{
        $data = $this->model_api_profit_loss->ajaxDataReportDepartment($temp_arr);
      }

      $this->response->addHeader('Content-Type: application/json');
      echo json_encode($data);
      exit;

    }
  }
	
}
