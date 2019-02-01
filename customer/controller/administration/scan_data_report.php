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
				'category_id' => $this->request->post['category_id'],
				'manufacturer' => $this->request->post['manufacturer'],
				'limit' => $this->config->get('config_limit_admin')
			);
		
			$report_datas = $this->model_api_scan_data_report->getScanDadtaReport($filter_data);
		
			$data_row = '';

// $data_row = [];
			$data_first_row = '';
			
			$total_qty = 0;
			$total_price = 0;
			
			$week_ending_date = DateTime::createFromFormat('m-d-Y', $filter_data['week_ending_date']);
    		$week_ending_date = $week_ending_date->format('Ymd');
    
            $week_starting_date = date('Ymd', strtotime('-1 week', strtotime($week_ending_date)));
			
			if(count($report_datas) > 0){
				
				//$data_first_row .= count($report_datas).'|';
				$total_qty_sold = 0;
				$total_sales_price = 0.00;

                // $data_row .= "Week Starting Date|Week Ending Date|Outlet Name|Outlet Number|Address1|Address2|City|State|Zip|Transaction Date|Market Basket ID|Scan ID|Register ID|Qty|Price|UPC Code|UPC Description|Unit of Measure|Mfg Buydown Desc|Mfg BuyDown Amt"."\r\n";

                if($filter_data['manufacturer'] == 1){
                    
                    $number_of_rows = 0;
                    
                    //For Marlboro
                    foreach($report_datas as $report_data){
                        
                        // ==================== For Marlboro ================================================
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
    					$SKU_Code = $report_data['upc_code'];
    					$UPC_Code = $report_data['upc_code'];
    					$SKU_Description = $report_data['vitemname'];
    					$Unit_of_Measure = $report_data['vunitname'];
    					$Quantity_Sold = $report_data['ndebitqty'] * $report_data['npack'];
    					$Consumer_Units = 1;
    					$Multi_Pack_Required_Quantity = 0;
    					$Multi_Pack_Discount_Amount = '';
    					
    					
    				// 	$Multi_Pack_Indicator = $report_data['is_multiple'];
    				// 	$Multi_Pack_Required_Quantity = $report_data['nbuyqty'];
    				// 	$Multi_Pack_Discount_Amount = $report_data['ndiscountper'];
    					
    					 $Multi_Pack_Indicator = (isset($report_data['is_multiple']) && $report_data['is_multiple'] == "Y") ? $report_data['is_multiple'] : "N";
                        $Multi_Pack_Required_Quantity = (isset($report_data['nbuyqty']) && $report_data['nbuyqty'] != "" && $report_data['nbuyqty'] != 1 && $report_data['nbuyqty'] != -1 && $report_data['nbuyqty'] != 0) ? (int)  $report_data['nbuyqty'] : "";
                        $Multi_Pack_Discount_Amount = "";
                        if(isset($report_data['vsaleby']) && $report_data['vsaleby'] != "" && $Multi_Pack_Indicator != "")
                        {
                            if( strtolower($report_data['vsaleby']) == 'price')
                            {
                                $Multi_Pack_Discount_Amount = (isset($report_data['ndiscountper']) && $report_data['ndiscountper'] != "") ? $report_data['ndiscountper'] : "";
                            }
                            else if(strtolower($report_data['vsaleby']) == 'discount')
                            {
                                $Multi_Pack_Discount_Amount = (isset($report_data['ndiscountper']) && $report_data['ndiscountper'] != "") ? ( $report_data['ndiscountper'] / 100 ) * $report_data['nunitprice'] : "";
                            }
                        }
                        
    					$Retailer_Funded_Discount_Name = '';
    					$Retailer_Funded_Discount_Amount = '0.00';
    					$MFG_Deal_Name_ONE = '';
    					$MFG_Deal_Discount_Amount_ONE = '0.00';
    					$MFG_Deal_Name_TWO = '';
    					$MFG_Deal_Discount_Amount_TWO = '0.00';
    					$MFG_Deal_Name_THREE = '';
    					$MFG_Deal_Discount_Amount_THREE = '0.00';
    					
    					$Final_Sales_Price = $report_data['ndebitamt'] - $Multi_Pack_Discount_Amount;
    					
    					
    					$Final_Sales_Price = sprintf("%0.2f", (float)$Final_Sales_Price  );
    					
    				// 	$Final_Sales_Price = number_format((float)$Final_Sales_Price_1, 2, '.', '');
    				// 	die;
    				// 	number_format($Final_Sales_Price, 2);
    					
    					$Store_Telephone = $report_data['vphone1'];
    					$Store_Contact_Name = $report_data['vcontactperson'];
    					$Store_Contact_Email = $report_data['vemail'];
    					$Product_Grouping_Code = '';
    					$Product_Grouping_Name = '';
    					$Loyalty_ID_Number = $report_data['icustomerid'];
    
                        // $data_row[] = $Final_Sales_Price;
    
    					$data_row .= $management_account_number.'|'.$week_ending_date.'|'.$transaction_date.'|'.$transaction_time.'|'.$transaction_id_code.'|'.$store_number.'|'.$store_name.'|'.$store_address.'|'.$store_city.'|'.$store_state.'|'.$store_zip.'|'.$category.'|'.$manufacturer_name.'|'.$SKU_Code.'|'.$UPC_Code.'|'.$SKU_Description.'|'.$Unit_of_Measure.'|'.$Consumer_Units.'|'.abs($Quantity_Sold).'|'.$Multi_Pack_Indicator.'|'.$Multi_Pack_Required_Quantity.'|'.$Multi_Pack_Discount_Amount.'|'.$Retailer_Funded_Discount_Name.'|'.$Retailer_Funded_Discount_Amount.'|'.$MFG_Deal_Name_ONE.'|'.$MFG_Deal_Discount_Amount_ONE.'|'.$MFG_Deal_Name_TWO.'|'.$MFG_Deal_Discount_Amount_TWO.'|'.$MFG_Deal_Name_THREE.'|'.$MFG_Deal_Discount_Amount_THREE.'|'.$Final_Sales_Price .'|'.$Store_Telephone.'|'.$Store_Contact_Name.'|'.$Store_Contact_Email.'|'.$Product_Grouping_Code.'|'.$Product_Grouping_Name.'|'.$Loyalty_ID_Number.''.PHP_EOL;
    
    					$total_qty_sold += $Quantity_Sold;
    					$total_sales_price += $Final_Sales_Price;
                        $number_of_rows++;
                    
                    }
                    
                    // echo json_encode($data_row); die;
                    
                    // $data_first_row .= $number_of_rows.'|'.$total_qty_sold.'|'.$total_sales_price.PHP_EOL; <= Changed on Vijay's Instructions on 20th Dec 2018
                    $total_sales_price = number_format((float)$total_sales_price, 2, '.', '');
                    
                    $data_first_row .= $number_of_rows.'|'.$number_of_rows.'|'.$total_sales_price.PHP_EOL;
                    
                } else {
                    
                    //================================== For RJR =================================================
                    
                    $data_first_row .= "Outlet Name|Outlet Number|Outlet Address 1|Outlet Address 2|Outlet City|Outlet State|Outlet Zip Code|Transaction Date/Time|Market Basket Transaction ID|Scan Transaction ID|Register ID|Quantity|Price|UPC Code|UPC Description|Unit of Measure|Promotion Flag|Outlet Multi-Pack Flag|Outlet Multi-Pack Quantity|Outlet Multi-Pack Discount Amount|Account Promotion Name|Account Discount Amount|Manufacturer Discount Amount|Coupon PID|Coupon Amount|Manufacturer Multi-pack Flag|Manufacturer Multi-pack Quantity|Manufacturer Multi-pack Discount Amount|Manufacturer Promotion Description|Manufacturer Buy-down Description|Manufacturer Buy-down Amount|Manufacturer Multi-Pack Description|Account Loyalty ID Number|Coupon Description".PHP_EOL;
    				// echo json_encode($report_datas);
    				// die;
    				
    				foreach($report_datas as $report_data){

    					// For RJR
                        $outlet_name = $this->session->data['storename'];
                        $outlet_number = $report_data['istoreid'];
                        $address1 = $this->session->data['storeaddress'];
                        $address2 = " ";
                        $city = $report_data['vcity'];
                        $state = $report_data['vstate'];
                        $zip = $report_data['vzip'];
                        //$transaction_date = DateTime::createFromFormat('Y-m-d H:i:s', $report_data['dtrandate']);
    					//$transaction_date = $transaction_date->format('Y-m-d H:i:s');
    				    //$transaction_date = $report_data['dtrandate'];
    				
    				    $transaction_date = DateTime::createFromFormat('Y-m-d H:i:s', $report_data['dtrandate']);
    					$transaction_date = $transaction_date->format('Y-m-d H:i:s');
    				    
    					$market_basket_id = $this->request->post['management_account_number'];
    					$scan_id = $report_data['isalesid'];
    					
                        // $scan_id = $report_data['idettrnid']; -- Adarsh's code
                        $register_id = $report_data['vterminalid'];
                        $quantity = (int)$report_data['ndebitqty'];
                        $price = $report_data['nunitprice'];
                        $upc_code = $report_data['upc_code'];
                        $upc_description = $report_data['vitemname'];
                        // $unit_of_measure = $report_data['vsize'];
                        $unit_of_measure = $report_data['vunitname'];
                        $promotion_flag = $report_data['nsaleprice']> 0?"Y":"N";
                        
                        $outlet_multipack_flag = "N";
                        $outlet_multipack_qty = "";
                        $outlet_multipack_disc_amt = "";
                        $acct_promo_name = "";
                        $acct_disc_amt = "";
                        $mfg_disc_amt = "";
                        $pid_coupon = "";
                        $pid_coupon_disc = "";
                        
                        $pid_coupon_amt = "";
                        
                        $mfg_multipack_flag = $report_data['nbuyqty'] > 1?"Y":"N";
                        $mfg_multipack_qty = $report_data['nbuyqty'];
                        
                        if($report_data['ndiscountper'] != null && $report_data['nbuyqty'] != null) {
                            $mfg_multipack_disc_amt = (float)$report_data['ndiscountper']/(float)$report_data['nbuyqty'];
                        } else {
                            $mfg_multipack_disc_amt = "";
                        }
                        
                        
                        $mfg_promo_desc = "";
                        $mfg_buydown_desc = "";
                        $mfg_buydown_amt = (($report_data['ndiscountper']*100)/$report_data['nunitcost']) != 0?(($report_data['ndiscountper']*100)/$report_data['nunitcost']):"";
                        $mfg_multipack_desc = $report_data['nbuyqty'] > 1?"RJR MP":"";
                        $acct_loyalty_id = "";
                        $coupon_desc = "";
                        $Loyalty_ID_Number = ($report_data['icustomerid'] == 0)?"":$report_data['icustomerid'];
                        
                        $total_qty = $quantity + $total_qty;
                        $total_price = $price + $total_price;
                        
                        
                        // $data_row .= $report_data['ndiscountper'];
                        
                        $data_row .= $outlet_name.'|'.$outlet_number.'|'.$address1.'|'.$address2.'|'.$city.'|'.$state.'|'.$zip.'|'.$transaction_date.'|'; //8
    					
                        $data_row .= $market_basket_id.'|'.$scan_id.'|'.$register_id.'|'.$quantity.'|'.$price.'|'.$upc_code.'|'.$upc_description.'|'; //15
                        
                        $data_row .= $unit_of_measure.'|'.$promotion_flag.'|'.$outlet_multipack_flag.'|'.$outlet_multipack_qty.'|'.$outlet_multipack_disc_amt.'|'.$acct_promo_name.'|'; //21

                        $data_row .=  $acct_disc_amt.'|'.$mfg_disc_amt.'|'.$pid_coupon.'|'.$pid_coupon_amt.'|'.$mfg_multipack_flag.'|'.$mfg_multipack_qty.'|'; //27
                        
                        $data_row .= $mfg_multipack_disc_amt.'|'.$mfg_promo_desc.'|'.$mfg_buydown_desc.'|'.$mfg_buydown_amt.'|'.$mfg_multipack_desc.'|'.$Loyalty_ID_Number.'|'.$pid_coupon_disc;
                        
                        
                        
                        /*$data_row .= '|'.$scan_id.'|'.$register_id.'|'.$quantity.'|'.$price.'|'.$upc_code.'|'.$upc_description.'|'.$unit_of_measure;
    
                        $data_row .= '|'.$promo_flag.'|'.$outlet_multipack_flag.'|'.$outlet_multipack_qty.'|'.$outlet_multipack_disc_amt.'|'.$acct_promo_name.'|'.$acct_disc_amt.'|'.$mfg_disc_amt.'|'.$pid_coupon.'|'.$pid_coupon_disc;
    
                        $data_row .= '|'.$mfg_multipack_flag.'|'.$mfg_multipack_qty.'|'.$mfg_multipack_disc_amt.'|'.$mfg_promo_desc;
                        
                        $data_row .= 
                        
                        $data_row .= '|'.$mfg_buydown_desc.'|'.$mfg_buydown_amt;
                        
                        $data_row .= '|'.$mfg_multipack_desc.'|'.$acct_loyalty_id.'|'.$coupon_desc;*/
                        
                        $data_row .= PHP_EOL;
                        
    				}                   
                }


				//$total_sales_price = number_format((float)$total_sales_price, 2, '.', '');
				//$data_first_row .= $total_qty_sold.'|'.$total_sales_price.PHP_EOL;
				
				/*$data_first_row .= "Store Name: ".$this->session->data['storename']."\r\n";
				$data_first_row .= "Store Address: ".$this->session->data['storeaddress']."\r\n";
				$data_first_row .= "Store Phone: ".$this->session->data['storephone']."\r\n";
				$data_first_row .= "\r\n";
				$data_first_row .= "Total Records: ".count($report_datas)."\r\n";
				$data_first_row .= "\r\n";*/
				
				//$data_first_row .= count($report_datas)."|".$total_qty."|".$total_price."\r\n"."\r\n";
				
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
		
		$data['categories'] = $this->model_api_scan_data_report->getCategories();
		
		
		$this->response->setOutput($this->load->view('administration/scan_data_report_list', $data));
	}

}
