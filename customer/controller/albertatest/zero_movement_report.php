<?php
class ControllerAlbertatestZeroMovementReport extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('albertatest/zero_movement_report');

		$this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('administration/zero_movement_report');
		$this->load->model('albertatest/zero_movement_report');

		$this->getList();
	}

  public function csv_export() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

      $data['reports'] = $this->session->data['reports'];
      $data['desc_title'] = $this->session->data['desc_title'];
      
      $data_row = '';

      if(count($data['reports']) > 0){
          $data_row .= $data['desc_title'].',Supplier,Item,QOH,Cost,Price,Shelf,Shelving,Aisle'.PHP_EOL;

          $tot_cost = 0;
          $tot_price = 0;
          $tot_qoh = 0;

          foreach ($data['reports'] as $k => $v) {

            $data_row .= str_replace(',',' ',$v['name']).',,,,,'.PHP_EOL;

          foreach ($v['items'] as $key => $value) {
              $data_row .= str_replace(',',' ',$value['vname']).','.str_replace(',',' ',$value['suppliername']).','.str_replace(',',' ',$value['itemname']).','.$value['iqtyonhand'].','.number_format((float)$value['cost'], 2, '.', '').','.number_format((float)$value['price'], 2, '.', '').','.$value['shelf'].','.$value['shelving'].','.$value['aisle'].PHP_EOL;

              $tot_cost = $tot_cost + $value['cost'];
              $tot_price = $tot_price + $value['price'];
              $tot_qoh = $tot_qoh + $value['iqtyonhand'];
          }
          }

          //$data_row .= ',,Total,'.$tot_qoh.',$'.number_format((float)$tot_cost, 2, '.', '').',$'.number_format((float)$tot_price, 2, '.', '').',,,'.PHP_EOL;

      }else{
          $data_row = 'Sorry no data found!';
      }

      $file_name_csv = 'zero-movement-report.csv';

      $file_path = DIR_TEMPLATE."/albertatest/zero-movement-report.csv";

      $myfile = fopen( DIR_TEMPLATE."/albertatest/zero-movement-report.csv", "w");

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

    $data['heading_title'] = 'Zero Movement Report';

    $this->response->setOutput($this->load->view('albertatest/print_zero_movement_report_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];
    $data['desc_title'] = $this->session->data['desc_title'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Zero Movement Report';

    $html = $this->load->view('albertatest/print_zero_movement_report_page', $data);
    
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
    $this->load->model('administration/cash_sales_summary');

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      if($this->request->post['report_by'] == 1){
        $data['reports'] = $this->model_albertatest_zero_movement_report->getCategoriesReport($this->request->post);
      }elseif($this->request->post['report_by'] == 2){
        $data['reports'] = $this->model_albertatest_zero_movement_report->getZeroMovementReport($this->request->post);
      }else{
         $data['reports'] = $this->model_albertatest_zero_movement_report->getGroupsReport($this->request->post);
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

      $report_datas =array();

      if(count($data['reports']) > 0){

        foreach ($data['reports'] as $k => $v) {
          if(array_key_exists($v['vname'],$report_datas)){

            $report_datas[$v['vname']]['name'] = $v['vname'];
            $report_datas[$v['vname']]['total_cost'] = $report_datas[$v['vname']]['total_cost'] + $v['cost'];
            $report_datas[$v['vname']]['total_price'] = $report_datas[$v['vname']]['total_price'] + $v['price'];
            $report_datas[$v['vname']]['total_iqtyonhand'] = $report_datas[$v['vname']]['total_iqtyonhand'] + $v['iqtyonhand'];
            $report_datas[$v['vname']]['items'][] = $v;

          }else{
            $report_datas[$v['vname']]['name'] = $v['vname'];
            $report_datas[$v['vname']]['total_cost'] = $v['cost'];
            $report_datas[$v['vname']]['total_price'] = $v['price'];
            $report_datas[$v['vname']]['total_iqtyonhand'] = $v['iqtyonhand'];
            $report_datas[$v['vname']]['items'][] = $v;
          }
        }
      }

      $data['reports'] = $report_datas;

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
			'href' => $this->url->link('albertatest/zero_movement_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['report_ajax_data'] = $this->url->link('albertatest/zero_movement_report/report_ajax_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['reportdata'] = $this->url->link('albertatest/zero_movement_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('albertatest/zero_movement_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('albertatest/zero_movement_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('albertatest/zero_movement_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$this->response->setOutput($this->load->view('albertatest/zero_movement_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/zero_movement_report')) {
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

  public function report_ajax_data() {

    $json =array();
    $this->load->model('albertatest/zero_movement_report');
    
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      $temp_arr = json_decode(file_get_contents('php://input'), true);

      if(!empty($temp_arr['start_date']) && !empty($temp_arr['end_date']) && !empty($temp_arr['report_pull_by'])){

        if($temp_arr['report_by'] == 1){
          $data = $this->model_albertatest_zero_movement_report->ajaxDataCategoryZeroMovementReport($temp_arr);
        }else if($temp_arr['report_by'] == 2){
          $data = $this->model_albertatest_zero_movement_report->ajaxDataZeroMovementReport($temp_arr);
        }else{
          $data = $this->model_albertatest_zero_movement_report->ajaxDataItemGroupZeroMovementReport($temp_arr);
        }
        
      }else{
        $data = array();
      }

      $this->response->addHeader('Content-Type: application/json');
      echo json_encode($data);
      exit;

    }
  }
	
}
