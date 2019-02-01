<?php
class ControllerAdministrationScanDataReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/scan_data_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('api/scan_data_report');
		
		$this->getList();
	}

	public function print_page() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

	    $data['reports'] = $this->session->data['vendor_reports'];
	    $data['p_start_date'] = $this->session->data['vendor_p_start_date'];
	    $data['p_end_date'] = $this->session->data['vendor_p_end_date'];
	    
	    $data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

	    $data['heading_title'] = 'Vendor Report';

	    $this->response->setOutput($this->load->view('administration/print_page_vendor_list', $data));
	}

	public function pdf_save_page() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

	    $data['reports'] = $this->session->data['vendor_reports'];
	    $data['p_start_date'] = $this->session->data['vendor_p_start_date'];
	    $data['p_end_date'] = $this->session->data['vendor_p_end_date'];
	    
	    $data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

	    $data['heading_title'] = 'Vendor Report';

	    $html = $this->load->view('administration/print_page_vendor_list', $data);
	    
	    $this->dompdf->loadHtml($html);

	    //(Optional) Setup the paper size and orientation
	    // $this->dompdf->setPaper('A4', 'landscape');

	    // Render the HTML as PDF
	    $this->dompdf->render();

	    // Output the generated PDF to Browser
	    $this->dompdf->stream('vendor-report.pdf');
	 }
	  
	protected function getList() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

		if($this->request->post){
			
			$filter_data = array(
				'week_ending_date' => $this->request->post['week_ending_date'],
				'department_id' => $this->request->post['department_id'],
				'limit' => $this->config->get('config_limit_admin')
			);
		
			$report_datas = $this->model_api_scan_data_report->getScanDadtaReport($filter_data);

			$data_row = '';
			$data_first_row = '';
			if(count($report_datas) > 0){
				
				$data_first_row .= count($report_datas).'|';
				$total_qty_sold = 0;
				$total_sales_price = 0.00;

				foreach($report_datas as $report_data){
					$management_account_number = $this->request->post['management_account_number'];
					$week_ending_date = DateTime::createFromFormat('m-d-Y', $this->request->post['week_ending_date']);
					$week_ending_date = $week_ending_date->format('Ymd');

					$transaction_date = DateTime::createFromFormat('Y-m-d H:i:s', $report_data['dtrandate']);
					$transaction_date = $transaction_date->format('Ymd');

					$transaction_time = DateTime::createFromFormat('Y-m-d H:i:s', $report_data['dtrandate']);
					$transaction_time = $transaction_time->format('H:i:s');

					$transaction_id_code = $report_data['isalesid'];

					$store_number = $report_data['istoreid'];
					$store_name = $report_data['vstorename'];
					$store_address = $report_data['vaddress1'];
					$store_city = $report_data['vcity'];
					$store_state = $report_data['vstate'];
					$store_zip = (int)$report_data['vzip'].'-0000';

					$category = $report_data['vcatname'];
					$manufacturer_name = $report_data['vcompanyname'];
					$SKU_Code = $report_data['vitemcode'];
					$UPC_Code = $report_data['vitemcode'];
					$SKU_Description = $report_data['vitemname'];
					$Unit_of_Measure = $report_data['vunitname'];
					$Quantity_Sold = (int)$report_data['ndebitqty'];
					$Consumer_Units = 1;
					$Multi_Pack_Indicator = 'N';
					$Multi_Pack_Required_Quantity = 0;
					$Multi_Pack_Discount_Amount = '0.00';
					$Retailer_Funded_Discount_Name = '';
					$Retailer_Funded_Discount_Amount = '0.00';
					$MFG_Deal_Name_ONE = '';
					$MFG_Deal_Discount_Amount_ONE = '0.00';
					$MFG_Deal_Name_TWO = '';
					$MFG_Deal_Discount_Amount_TWO = '0.00';
					$MFG_Deal_Name_THREE = '';
					$MFG_Deal_Discount_Amount_THREE = '0.00';
					$Final_Sales_Price = $report_data['nextunitprice'];
					$Store_Telephone = $report_data['vphone1'];
					$Store_Contact_Name = $report_data['vcontactperson'];
					$Store_Contact_Email = $report_data['vemail'];
					$Product_Grouping_Code = '';
					$Product_Grouping_Name = '';
					$Loyalty_ID_Number = '';

					$data_row .= $management_account_number.'|'.$week_ending_date.'|'.$transaction_date.'|'.$transaction_time.'|'.$transaction_id_code.'|'.$store_number.'|'.$store_name.'|'.$store_address.'|'.$store_city.'|'.$store_state.'|'.$store_zip.'|'.$category.'|'.$manufacturer_name.'|'.$SKU_Code.'|'.$UPC_Code.'|'.$SKU_Description.'|'.$Unit_of_Measure.'|'.$Quantity_Sold.'|'.$Consumer_Units.'|'.$Multi_Pack_Indicator.'|'.$Multi_Pack_Required_Quantity.'|'.$Multi_Pack_Discount_Amount.'|'.$Retailer_Funded_Discount_Name.'|'.$Retailer_Funded_Discount_Amount.'|'.$MFG_Deal_Name_ONE.'|'.$MFG_Deal_Discount_Amount_ONE.'|'.$MFG_Deal_Name_TWO.'|'.$MFG_Deal_Discount_Amount_TWO.'|'.$MFG_Deal_Name_THREE.'|'.$MFG_Deal_Discount_Amount_THREE.'|'.$Final_Sales_Price.'|'.$Store_Telephone.'|'.$Store_Contact_Name.'|'.$Store_Contact_Email.'|'.$Product_Grouping_Code.'|'.$Product_Grouping_Name.'|'.$Loyalty_ID_Number.''.PHP_EOL;

					$total_qty_sold += $Quantity_Sold;
					$total_sales_price += $Final_Sales_Price;
				}

				$total_sales_price = number_format((float)$total_sales_price, 2, '.', '');
				$data_first_row .= $total_qty_sold.'|'.$total_sales_price.PHP_EOL;
				
				$data_first_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
				$data_first_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
				$data_first_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;
				
				
				
				$data_row = $data_first_row.''.$data_row;

			}else{
				$data_row = 'Sorry no data found!';
			}
			
			$store = $this->model_api_scan_data_report->getStore();
			$store_name_txt = $store['name'];
			$week_ending_date_txt = DateTime::createFromFormat('m-d-Y', $this->request->post['week_ending_date']);
			$week_ending_date_txt = $week_ending_date_txt->format('Ymd');

			$management_account_number_txt = $this->request->post['management_account_number'];
			$file_name_txt = $store_name_txt.'_'.$management_account_number_txt.'_'.$week_ending_date_txt.'.txt';
			
			$file_path = DIR_TEMPLATE."/administration/scan-data-report.txt";

			$myfile = fopen( DIR_TEMPLATE."/administration/scan-data-report.txt", "w");

			fwrite($myfile,$data_row);
			fclose($myfile);

			$content = file_get_contents ($file_path);
			header ('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file_name_txt));
			echo $content;
			exit;
			
		}

		$url = '';
			
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/scan_data_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['current_url'] = $this->url->link('administration/scan_data_report', 'token=' . $this->session->data['token'] . $url, true);
		$data['print_page'] = $this->url->link('administration/scan_data_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['pdf_save_page'] = $this->url->link('administration/scan_data_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		
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

		$data['success'] = '';

		$data['departments'] = $this->model_api_scan_data_report->getDepartments();
  
		$data['store_name'] = $this->session->data['storename'];
		
		$data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/scan_data_report_list', $data));
	}

}
