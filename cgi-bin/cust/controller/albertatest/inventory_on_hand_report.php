<?php
class ControllerAdministrationInventoryOnHandReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/inventory_on_hand_report');

		$this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/inventory_on_hand_report');
		$this->load->model('api/inventory_on_hand_report');

		$this->getList();
	}

  public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");
        
        $data['reports'] = $this->session->data['report_datas_print'];
        $data['total_qoh'] = $this->session->data['total_qoh'];
        $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
        $data['toal_value'] = $this->session->data['toal_value'];
        $data['total_retail'] = $this->session->data['total_retail'];
        $data['total_retail_value'] = $this->session->data['total_retail_value'];
        $data['selected_report'] = $this->session->data['selected_report'];
        
        $data_row = '';
        $tot_qoh = 0;
        $tot_cost = 0;
        $tot_price = 0;

        if(count($data['reports']) > 0){
            if($data['selected_report'] == 1){
              $data_row .= 'Category,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else if($data['selected_report'] == 2){
              $data_row .= 'Department,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else if($data['selected_report'] == 3){
              $data_row .= 'Item Group,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else{
              $data_row .= 'category,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }
            

            foreach ($data['reports'] as $key => $value) {
              $data_row .= $key.',,,,'.PHP_EOL;

              $total_qty = 0;
              $total_total_cost = 0;
              $total_total_value = 0;
              $total_total_retail_value = 0;

              foreach ($value as $k => $v){
                $tot_value = $v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', '');
                $tot_ret_value = $v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', '');

                $total_total_retail_value = $total_total_retail_value + $tot_ret_value;

                $total_qty = $total_qty + $v['iqtyonhand'];
                $total_total_cost = $total_total_cost + number_format((float)$v['cost'], 2, '.', '');
                $total_total_value = $total_total_value + $tot_value;

                $data_row .= str_replace(',',' ',$v['vname']).','.str_replace(',',' ',$v['itemname']).','.$v['iqtyonhand'].','.number_format((float)$v['cost'], 2, '.', '').','. number_format((float)$tot_value, 2, '.', '').','.number_format((float)$v['price'], 2, '.', '').','.number_format((float)$tot_ret_value, 2, '.', '') .PHP_EOL;
              }

              $data_row .= ',Total,'. $total_qty .',,$'.$total_total_value.',,$'.$total_total_retail_value.PHP_EOL;
            }
            
            $data_row .= ',Grand Total,'. $data['total_qoh'] .',,$'.number_format((float)$data['toal_value'], 2, '.', '') .',,$'. number_format((float)$data['total_retail_value'], 2, '.', '') .PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'inventory-on-hand-report.csv';

        $file_path = DIR_TEMPLATE."/administration/inventory-on-hand-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/inventory-on-hand-report.csv", "w");

        fwrite($myfile,$data_row);
        fclose($myfile);

        $content = file_get_contents ($file_path);
        header ('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file_name_csv));
        echo $content;
        exit;
    }

    public function csv_export_alberta() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");
        
        $data['reports'] = $this->session->data['report_datas_print'];
        $data['total_qoh'] = $this->session->data['total_qoh'];
        $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
        $data['toal_value'] = $this->session->data['toal_value'];
        $data['total_retail'] = $this->session->data['total_retail'];
        $data['total_retail_value'] = $this->session->data['total_retail_value'];
        $data['selected_report'] = $this->session->data['selected_report'];
        
        $data_row = '';
        $tot_qoh = 0;
        $tot_cost = 0;
        $tot_price = 0;

        if(count($data['reports']) > 0){
            if($data['selected_report'] == 1){
              $data_row .= 'Category,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else if($data['selected_report'] == 2){
              $data_row .= 'Department,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else if($data['selected_report'] == 3){
              $data_row .= 'Item Group,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }else{
              $data_row .= 'category,Item,QOH,Cost Value,Total Cost Value,Retail Value,Total Retail Value'.PHP_EOL;
            }
            

            foreach ($data['reports'] as $key => $value) {
              $data_row .= $key.',,,,'.PHP_EOL;

              $total_qty = 0;
              $total_total_cost = 0;
              $total_total_value = 0;
              $total_total_retail_value = 0;

              foreach ($value as $k => $v){
                $tot_value = $v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', '');
                $tot_ret_value = $v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', '');

                $total_total_retail_value = $total_total_retail_value + $tot_ret_value;

                $total_qty = $total_qty + $v['iqtyonhand'];
                $total_total_cost = $total_total_cost + number_format((float)$v['cost'], 2, '.', '');
                $total_total_value = $total_total_value + $tot_value;

                $data_row .= str_replace(',',' ',$v['vname']).','.str_replace(',',' ',$v['itemname']).','.$v['iqtyonhand'].','.number_format((float)$v['cost'], 2, '.', '').','. number_format((float)$tot_value, 2, '.', '').','.number_format((float)$v['price'], 2, '.', '').','.number_format((float)$tot_ret_value, 2, '.', '') .PHP_EOL;
              }

              $data_row .= ',Total,'. $total_qty .',,$'.$total_total_value.',,$'.$total_total_retail_value.PHP_EOL;
            }
            
            $data_row .= ',Grand Total,'. $data['total_qoh'] .',,$'.$data['toal_value'].',,$'.$data['total_retail_value'].PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'inventory-on-hand-report.csv';

        $file_path = DIR_TEMPLATE."/administration/inventory-on-hand-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/inventory-on-hand-report.csv", "w");

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

    $data['reports'] = $this->session->data['report_datas_print'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];
    $data['total_retail'] = $this->session->data['total_retail'];
    $data['total_retail_value'] = $this->session->data['total_retail_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $this->response->setOutput($this->load->view('administration/print_inventory_on_hand_report_page', $data));
  }

  public function print_page_alberta() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['report_datas_print'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];
    $data['total_retail'] = $this->session->data['total_retail'];
    $data['total_retail_value'] = $this->session->data['total_retail_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $this->response->setOutput($this->load->view('administration/print_inventory_on_hand_report_page_alberta', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['report_datas_print'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];
    $data['total_retail'] = $this->session->data['total_retail'];
    $data['total_retail_value'] = $this->session->data['total_retail_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $html = $this->load->view('administration/print_inventory_on_hand_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Inventory-On-Hand-Report.pdf');
  }

  public function pdf_save_page_alberta() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['report_datas_print'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];
    $data['total_retail'] = $this->session->data['total_retail'];
    $data['total_retail_value'] = $this->session->data['total_retail_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $html = $this->load->view('administration/print_inventory_on_hand_report_page_alberta', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Inventory-On-Hand-Report.pdf');
  }
	  
	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_api_inventory_on_hand_report->getCategoriesReport($this->request->post);
        $data['selected_report'] = 1;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_api_inventory_on_hand_report->getDepartmentsReport($this->request->post);
        $data['selected_report'] = 2;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getDepartments();
      }else if($this->request->post['report_by'] == 3){
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemGroupsReport($this->request->post);
        $data['selected_report'] = 3;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getGroups();
      }else{
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemsReportAlberta($this->request->post);
        $data['selected_report'] = 4;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getItems();
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $report_datas = array();
      $report_datas_print = array();
      $total_qoh = 0;
      $toal_cost_price = 0.00;
      $toal_value = 0.00;
      $total_retail_value = 0.00;
      $total_retail = 0.00;
      
      foreach ($reportsdata as $k => $v) {

        if(array_key_exists($v['search_name'],$report_datas_print)){
          $report_datas_print[$v['search_name']][] = $v;
        }else{
          $report_datas_print[$v['search_name']][] = $v;
        }

        if(array_key_exists($v['search_name'],$report_datas)){
            $report_datas[$v['search_name']]['key_name'] = $v['search_name'];
            $report_datas[$v['search_name']]['key_id'] = $v['search_id'];
            $report_datas[$v['search_name']]['search_total_qoh'] = $report_datas[$v['search_name']]['search_total_qoh'] + $v['iqtyonhand'];

            $report_datas[$v['search_name']]['search_total_cost_price'] = $report_datas[$v['search_name']]['search_total_cost_price'] + $v['cost'];
            $report_datas[$v['search_name']]['search_total_total_cost_price'] = $report_datas[$v['search_name']]['search_total_total_cost_price'] + ($v['iqtyonhand'] * $v['cost']);
            $report_datas[$v['search_name']]['search_total_retail_value'] = $report_datas[$v['search_name']]['search_total_retail_value'] + $v['price'];
            $report_datas[$v['search_name']]['search_total_total_retail_value'] = $report_datas[$v['search_name']]['search_total_total_retail_value'] + ($v['iqtyonhand'] * $v['price']);

        }else{
            $report_datas[$v['search_name']]['key_name'] = $v['search_name'];
            $report_datas[$v['search_name']]['key_id'] = $v['search_id'];
            $report_datas[$v['search_name']]['search_total_qoh'] = $v['iqtyonhand'];

            $report_datas[$v['search_name']]['search_total_cost_price'] = $v['cost'];
            $report_datas[$v['search_name']]['search_total_total_cost_price'] = ($v['iqtyonhand'] * $v['cost']);
            $report_datas[$v['search_name']]['search_total_retail_value'] = $v['price'];
            $report_datas[$v['search_name']]['search_total_total_retail_value'] = ($v['iqtyonhand'] * $v['price']);
        }

        $total_qoh = $total_qoh + $v['iqtyonhand'];
        $toal_cost_price = $toal_cost_price + $v['cost'];
        $toal_value = $toal_value + ($v['iqtyonhand'] * $v['cost']);

        $total_retail = $total_retail + $v['price'];
        $total_retail_value = $total_retail_value + ($v['iqtyonhand'] * $v['price']);
      }

      $data['reports'] = $report_datas;
      $data['report_datas_print'] = $report_datas_print;
      $data['total_qoh'] = $total_qoh;
      $data['toal_cost_price'] = $toal_cost_price;
      $data['toal_value'] = $toal_value;
      $data['total_retail'] = $total_retail;
      $data['total_retail_value'] = $total_retail_value;

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['report_datas_print'] = $data['report_datas_print'];
      $this->session->data['total_qoh'] = $data['total_qoh'];
      $this->session->data['toal_cost_price'] = $data['toal_cost_price'];
      $this->session->data['toal_value'] = $data['toal_value'];
      $this->session->data['total_retail'] = $data['total_retail'];
      $this->session->data['total_retail_value'] = $data['total_retail_value'];
      $this->session->data['selected_report'] = $data['selected_report'];
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('administration/inventory_on_hand_report', 'token=' . $this->session->data['token'] . $url, true)
    );

    $data['report_ajax_data'] = $this->url->link('administration/inventory_on_hand_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/inventory_on_hand_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/inventory_on_hand_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/inventory_on_hand_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/inventory_on_hand_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
    
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
                    3 => 'Item Group',
                    //4 => 'Items'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');
    
    $this->response->setOutput($this->load->view('administration/inventory_on_hand_report_list', $data));
  }

  public function alberta() {
    $this->load->language('administration/inventory_on_hand_report');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/inventory_on_hand_report');
    $this->load->model('api/inventory_on_hand_report');

    $this->getList_alberta();
  }

  protected function getList_alberta() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_api_inventory_on_hand_report->getCategoriesReportAlberta($this->request->post);
        $data['selected_report'] = 1;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_api_inventory_on_hand_report->getDepartmentsReportAlberta($this->request->post);
        $data['selected_report'] = 2;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getDepartments();
      }else if($this->request->post['report_by'] == 3){
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemGroupsReportAlberta($this->request->post);
        $data['selected_report'] = 3;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getGroups();
      }else{
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemsReportAlberta($this->request->post);
        $data['selected_report'] = 4;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getItems();
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $report_datas = array();
      $report_datas_print = array();
      $total_qoh = 0;
      $toal_cost_price = 0.00;
      $toal_value = 0.00;
      $total_retail_value = 0.00;
      $total_retail = 0.00;
      
      foreach ($reportsdata as $k => $v) {

        if(array_key_exists($v['search_name'],$report_datas_print)){
          $report_datas_print[$v['search_name']][] = $v;
        }else{
          $report_datas_print[$v['search_name']][] = $v;
        }

        if(array_key_exists($v['search_name'],$report_datas)){
            $report_datas[$v['search_name']]['key_name'] = $v['search_name'];
            $report_datas[$v['search_name']]['key_id'] = $v['search_id'];
            $report_datas[$v['search_name']]['search_total_qoh'] = $report_datas[$v['search_name']]['search_total_qoh'] + $v['iqtyonhand'];

            $report_datas[$v['search_name']]['search_total_cost_price'] = $report_datas[$v['search_name']]['search_total_cost_price'] + $v['cost'];
            $report_datas[$v['search_name']]['search_total_total_cost_price'] = $report_datas[$v['search_name']]['search_total_total_cost_price'] + ($v['iqtyonhand'] * $v['cost']);
            $report_datas[$v['search_name']]['search_total_retail_value'] = $report_datas[$v['search_name']]['search_total_retail_value'] + $v['price'];
            $report_datas[$v['search_name']]['search_total_total_retail_value'] = $report_datas[$v['search_name']]['search_total_total_retail_value'] + ($v['iqtyonhand'] * $v['price']);

        }else{
            $report_datas[$v['search_name']]['key_name'] = $v['search_name'];
            $report_datas[$v['search_name']]['key_id'] = $v['search_id'];
            $report_datas[$v['search_name']]['search_total_qoh'] = $v['iqtyonhand'];

            $report_datas[$v['search_name']]['search_total_cost_price'] = $v['cost'];
            $report_datas[$v['search_name']]['search_total_total_cost_price'] = ($v['iqtyonhand'] * $v['cost']);
            $report_datas[$v['search_name']]['search_total_retail_value'] = $v['price'];
            $report_datas[$v['search_name']]['search_total_total_retail_value'] = ($v['iqtyonhand'] * $v['price']);
        }

        $total_qoh = $total_qoh + $v['iqtyonhand'];
        $toal_cost_price = $toal_cost_price + $v['cost'];
        $toal_value = $toal_value + ($v['iqtyonhand'] * $v['cost']);

        $total_retail = $total_retail + $v['price'];
        $total_retail_value = $total_retail_value + ($v['iqtyonhand'] * $v['price']);
      }

      $data['reports'] = $report_datas;
      $data['report_datas_print'] = $report_datas_print;
      $data['total_qoh'] = $total_qoh;
      $data['toal_cost_price'] = $toal_cost_price;
      $data['toal_value'] = $toal_value;
      $data['total_retail'] = $total_retail;
      $data['total_retail_value'] = $total_retail_value;

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['report_datas_print'] = $data['report_datas_print'];
      $this->session->data['total_qoh'] = $data['total_qoh'];
      $this->session->data['toal_cost_price'] = $data['toal_cost_price'];
      $this->session->data['toal_value'] = $data['toal_value'];
      $this->session->data['total_retail'] = $data['total_retail'];
      $this->session->data['total_retail_value'] = $data['total_retail_value'];
      $this->session->data['selected_report'] = $data['selected_report'];
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('administration/inventory_on_hand_report', 'token=' . $this->session->data['token'] . $url, true)
    );

    $data['report_ajax_data'] = $this->url->link('administration/inventory_on_hand_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/inventory_on_hand_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/inventory_on_hand_report/print_page_alberta', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/inventory_on_hand_report/pdf_save_page_alberta', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/inventory_on_hand_report/csv_export_alberta', 'token=' . $this->session->data['token'] . $url, true);
    
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
                    3 => 'Item Group',
                    4 => 'Items'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');
    
    $this->response->setOutput($this->load->view('administration/inventory_on_hand_report_list_alberta', $data));
  }

  public function test() {
    $this->load->language('administration/inventory_on_hand_report');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/inventory_on_hand_report');
    $this->load->model('api/inventory_on_hand_report');

    $this->getList_test();
  }

  protected function getList_test() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_api_inventory_on_hand_report->getCategoriesReport($this->request->post);
        $data['selected_report'] = 1;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_api_inventory_on_hand_report->getDepartmentsReport($this->request->post);
        $data['selected_report'] = 2;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getDepartments();
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $report_datas = array();
      $total_qoh = 0;
      $toal_cost_price = 0.00;
      $toal_value = 0.00;
      $total_retail_value = 0.00;
      $total_retail = 0.00;
      foreach ($reportsdata as $k => $v) {
        if(array_key_exists($v['suppliername'],$report_datas)){
            $report_datas[$v['suppliername']][] = $v;
        }else{
            $report_datas[$v['suppliername']][] = $v;
        }
        $total_qoh = $total_qoh + $v['iqtyonhand'];
        $toal_cost_price = $toal_cost_price + $v['cost'];
        $toal_value = $toal_value + ($v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', ''));

        $total_retail = $total_retail + $v['price'];
        $total_retail_value = $total_retail_value + ($v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', ''));
      }

      $data['reports'] = $report_datas;
      $data['total_qoh'] = $total_qoh;
      $data['toal_cost_price'] = $toal_cost_price;
      $data['toal_value'] = $toal_value;
      $data['total_retail'] = $total_retail;
      $data['total_retail_value'] = $total_retail_value;

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['total_qoh'] = $data['total_qoh'];
      $this->session->data['toal_cost_price'] = $data['toal_cost_price'];
      $this->session->data['toal_value'] = $data['toal_value'];
      $this->session->data['total_retail'] = $data['total_retail'];
      $this->session->data['total_retail_value'] = $data['total_retail_value'];
      $this->session->data['selected_report'] = $data['selected_report'];
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('administration/inventory_on_hand_report/test', 'token=' . $this->session->data['token'] . $url, true)
    );

    $data['report_ajax_data'] = $this->url->link('administration/inventory_on_hand_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/inventory_on_hand_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/inventory_on_hand_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/inventory_on_hand_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/inventory_on_hand_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
    
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
                    3 => 'Item Group',
                    4 => 'Items'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');
    
    $this->response->setOutput($this->load->view('administration/inventory_on_hand_report_list_test', $data));
  }

  public function test_pdf() {
    $this->load->language('administration/inventory_on_hand_report');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/inventory_on_hand_report');
    $this->load->model('api/inventory_on_hand_report');

    $this->getList_test_pdf();
  }

  protected function getList_test_pdf() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_api_inventory_on_hand_report->getCategoriesReport($this->request->post);
        $data['selected_report'] = 1;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_api_inventory_on_hand_report->getDepartmentsReport($this->request->post);
        $data['selected_report'] = 2;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getDepartments();
      }else if($this->request->post['report_by'] == 3){
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemGroupsReport($this->request->post);
        $data['selected_report'] = 3;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getGroups();
      }else{
        $reportsdata = $this->model_api_inventory_on_hand_report->getItemsReport($this->request->post);
        $data['selected_report'] = 4;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getItems();
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $report_datas = array();
      $total_qoh = 0;
      $toal_cost_price = 0.00;
      $toal_value = 0.00;
      $total_retail_value = 0.00;
      $total_retail = 0.00;
      foreach ($reportsdata as $k => $v) {
        if(array_key_exists($v['suppliername'],$report_datas)){
            $report_datas[$v['suppliername']][] = $v;
        }else{
            $report_datas[$v['suppliername']][] = $v;
        }
        $total_qoh = $total_qoh + $v['iqtyonhand'];
        $toal_cost_price = $toal_cost_price + $v['cost'];
        $toal_value = $toal_value + ($v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', ''));

        $total_retail = $total_retail + $v['price'];
        $total_retail_value = $total_retail_value + ($v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', ''));
      }

      $data['reports'] = $report_datas;
      $data['total_qoh'] = $total_qoh;
      $data['toal_cost_price'] = $toal_cost_price;
      $data['toal_value'] = $toal_value;
      $data['total_retail'] = $total_retail;
      $data['total_retail_value'] = $total_retail_value;
      $store_name = $this->session->data['storename'];

      $table_header_all = array();
      
      if($data['selected_report'] == 1){
        $table_header_all[] = array('Supplier','Category','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }elseif($data['selected_report'] == 2){
        $table_header_all[] = array('Supplier','Department','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }else if($data['selected_report'] == 3){
        $table_header_all[] = array('Supplier','Item Group','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }else{
        $table_header_all[] = array('Supplier','Category','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }
      
      $this->FPDF->setHeader($table_header_all);

      $pdf = $this->FPDF;
      $lineheight = 5;
      $fontsize = 8;
      $pdf->SetFont('Arial','B',$fontsize);
      $pdf->SetAutoPageBreak(true,10);
      $pdf->SetMargins(5,10,5);
      $pdf->AddPage();
      $pdf->Ln(4);

      $pdf->SetFont('Arial','B',24);
      $pdf->Cell('', '', 'Inventory On Hand Report','','','C');

      $pdf->Ln(10);
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell(10, '', 'Date:','','','L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20, '', date('m-d-Y'),'','','');
      $pdf->SetFont('Arial','B',10);
      $pdf->Cell('', '', 'Store Name:'.$store_name,'','','R');
      $pdf->Ln(8);

      $pdf->Line($pdf->lMargin, 30, 204, 30);  //Set the line

      $pdf->Ln(12);
      $pdf->Cell('', '', 'Total Cost Value- $'.number_format((float)$toal_value, 2),'','');
      $pdf->Ln(8);
      $pdf->Cell('', '', 'Total Retail Value- $'.number_format((float)$total_retail_value, 2),'','');
      $pdf->Ln(8);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell('', '', '*Exclude non inventory items & items with zero or negative qoh','','');
      $pdf->Ln(8);

      $pdf->SetFont('Arial','B',11);
      $widths = array(30,28,55,12,16,20,18,20);
      $table_header = array();
      if($data['selected_report'] == 1){
        $table_header[] = array('Supplier','Category','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }elseif($data['selected_report'] == 2){
        $table_header[] = array('Supplier','Department','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }elseif($data['selected_report'] == 3){
        $table_header[] = array('Supplier','Item Group','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }else{
        $table_header[] = array('Supplier','Category','Item','QOH','Cost Value','Total Cost Value','Retail Value','Total Retail Value');
      }
      
      $pdf->plot_table($widths, $lineheight, $table_header);
      $pdf->Ln(0);

      if(count($report_datas) > 0){
        foreach ($report_datas as $key => $value) {

          //$vendor_header = array();
          //$vendor_header[] = array($key);
          //$widths_header = array(60);
          $pdf->Ln(0.1);
          // $pdf->plot_table($widths_header, $lineheight, $vendor_header,0);
          $pdf->Cell(199, 8, $key,1,'','L');
          $pdf->Ln();

          if(count($value) > 0){

            $total_qty = 0;
            $total_total_cost = 0;
            $total_total_value = 0;
            $total_total_retail_value = 0;

            foreach ($value as $k => $v) {

              $tot_value = $v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', '');
              $tot_ret_value = $v['iqtyonhand'] * number_format((float)$v['price'], 2, '.', '');

              $total_total_retail_value = $total_total_retail_value + $tot_ret_value;

              $total_qty = $total_qty + $v['iqtyonhand'];
              $total_total_cost = $total_total_cost + number_format((float)$v['cost'], 2, '.', '');
              $total_total_value = $total_total_value + $tot_value;

              $temp = array();
              $temp[0]['suppliername'] = $v['suppliername'];
              $temp[0]['vname'] = $v['vname'];
              $temp[0]['itemname'] = $v['itemname'];
              $temp[0]['iqtyonhand'] = $v['iqtyonhand'];
              $temp[0]['cost'] = number_format((float)$v['cost'], 2, '.', '');
              $temp[0]['total_cost'] = $tot_value;
              $temp[0]['price'] = $v['price'];
              $temp[0]['total_price'] = $v['price'] * $v['iqtyonhand'];
              $pdf->SetFont('Arial','',$fontsize);
              $pdf->plot_table($widths, $lineheight, $temp);
            }

            $vendor_grand_total = array();
            $vendor_grand_total[0]['suppliername'] = '-';
            $vendor_grand_total[0]['vname'] = '-';
            $vendor_grand_total[0]['itemname'] = 'Total';
            $vendor_grand_total[0]['iqtyonhand'] = $total_qty;
            $vendor_grand_total[0]['cost'] = '-';
            $vendor_grand_total[0]['total_cost'] = '$'.number_format((float)$total_total_value, 2);
            $vendor_grand_total[0]['price'] = '-';
            $vendor_grand_total[0]['total_price'] = '$'.number_format((float)$total_total_retail_value, 2);
            $pdf->SetFont('Arial','B',$fontsize);
            $pdf->plot_table($widths, $lineheight, $vendor_grand_total);
            
          }
        }
      }

      $pdf->PageNo();

      $grand_total = array();
      $grand_total[0]['suppliername'] = '-';
      $grand_total[0]['vname'] = '-';
      $grand_total[0]['itemname'] = 'Grand Total';
      $grand_total[0]['iqtyonhand'] = $total_qoh;
      $grand_total[0]['cost'] = '-';
      $grand_total[0]['total_cost'] = '$'.number_format((float)$toal_value, 2);
      $grand_total[0]['price'] = '-';
      $grand_total[0]['total_price'] = '$'.number_format((float)$total_retail_value, 2);
      $pdf->SetFont('Arial','B',$fontsize);
      $pdf->plot_table($widths, $lineheight, $grand_total);
      
      $pdf1 = fopen ('inventory_on_hand_report.pdf','w');
      fwrite ($pdf1,$pdf->Output("mypdf.pdf","S"));
     
      fclose ($pdf1);

      $data['pdf_show'] = true;

    }else{
      $data['pdf_show'] = false;
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $this->url->link('administration/inventory_on_hand_report/test', 'token=' . $this->session->data['token'] . $url, true)
    );

    $data['report_ajax_data'] = $this->url->link('administration/inventory_on_hand_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('administration/inventory_on_hand_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/inventory_on_hand_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/inventory_on_hand_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/inventory_on_hand_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
    
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
                    3 => 'Item Group',
                    4 => 'Items'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');
    
    $this->response->setOutput($this->load->view('administration/inventory_on_hand_report_list_test_pdf', $data));
  }
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/inventory_on_hand_report')) {
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

    $this->load->model('administration/inventory_on_hand_report');

    if(!empty($this->request->get['report_by'])){
      if($this->request->get['report_by'] == 1){
        $datas = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->get['report_by'] == 2){
        $datas = $this->model_administration_inventory_on_hand_report->getDepartments();
      }elseif($this->request->get['report_by'] == 3){
        $datas = $this->model_administration_inventory_on_hand_report->getGroups();
      }else{
        $datas = $this->model_administration_inventory_on_hand_report->getItems();
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
    $this->load->model('api/inventory_on_hand_report');
    
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      $temp_arr = json_decode(file_get_contents('php://input'), true);

      if($temp_arr['report_by'] == 1){
        $data = $this->model_api_inventory_on_hand_report->ajaxDataReportCategory($temp_arr);
      }else if($temp_arr['report_by'] == 2){
        $data = $this->model_api_inventory_on_hand_report->ajaxDataReportDepartment($temp_arr);
      }else if($temp_arr['report_by'] == 3){
        $data = $this->model_api_inventory_on_hand_report->ajaxDataReportItemGroup($temp_arr);
      }else{
        $data = $this->model_api_inventory_on_hand_report->ajaxDataReportDepartment($temp_arr);
      }

      $this->response->addHeader('Content-Type: application/json');
      echo json_encode($data);
      exit;

    }
  }
	
}
