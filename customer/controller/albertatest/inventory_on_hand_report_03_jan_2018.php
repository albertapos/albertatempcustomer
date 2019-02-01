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
      
        $data['reports'] = $this->session->data['reports'];
        $data['total_qoh'] = $this->session->data['total_qoh'];
        $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
        $data['toal_value'] = $this->session->data['toal_value'];
        $data['selected_report'] = $this->session->data['selected_report'];
        
        $data_row = '';
        $tot_qoh = 0;
        $tot_cost = 0;
        $tot_price = 0;

        if(count($data['reports']) > 0){
            if($data['selected_report'] == 1){
              $data_row .= 'Supplier,Category,Item,QOH,Cost Value,Total Value'.PHP_EOL;
            }else{
              $data_row .= 'Supplier,Department,Item,QOH,Cost Value,Total Value'.PHP_EOL;
            }
            

            foreach ($data['reports'] as $key => $value) {
              $data_row .= $key.',,,,,'.PHP_EOL;

              $total_qty = 0;
              $total_total_cost = 0;
              $total_total_value = 0;

              foreach ($value as $k => $v){
                $tot_value = $v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', '');

                $total_qty = $total_qty + $v['iqtyonhand'];
                $total_total_cost = $total_total_cost + number_format((float)$v['cost'], 2, '.', '');
                $total_total_value = $total_total_value + $tot_value;

                $data_row .= str_replace(',',' ',$v['suppliername']).','.str_replace(',',' ',$v['vname']).','.str_replace(',',' ',$v['itemname']).','.$v['iqtyonhand'].','.number_format((float)$v['cost'], 2, '.', '').','. number_format((float)$tot_value, 2, '.', '') .PHP_EOL;
              }

              $data_row .= ',,Total,'. $total_qty .','. $total_total_cost .','.$total_total_value.PHP_EOL;
            }
            

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

        // download cookie
        //$cookie_name = "csv_download";
        //$cookie_value = "Yes";
        //setcookie($cookie_name, $cookie_value);
        exit;
    }

  public function print_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $this->response->setOutput($this->load->view('administration/print_inventory_on_hand_report_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['total_qoh'] = $this->session->data['total_qoh'];
    $data['toal_cost_price'] = $this->session->data['toal_cost_price'];
    $data['toal_value'] = $this->session->data['toal_value'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $html = $this->load->view('administration/print_inventory_on_hand_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // download cookie
    // $cookie_name = "pdf_download";
    // $cookie_value = "Yes";
    // setcookie($cookie_name, $cookie_value);

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
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $report_datas = array();
      $total_qoh = 0;
      $toal_cost_price = 0.00;
      $toal_value = 0.00;
      foreach ($reportsdata as $k => $v) {
        if(array_key_exists($v['suppliername'],$report_datas)){
            $report_datas[$v['suppliername']][] = $v;
        }else{
            $report_datas[$v['suppliername']][] = $v;
        }
        $total_qoh = $total_qoh + $v['iqtyonhand'];
        $toal_cost_price = $toal_cost_price + $v['cost'];
        $toal_value = $toal_value + ($v['iqtyonhand'] * number_format((float)$v['cost'], 2, '.', ''));
      }

      $data['reports'] = $report_datas;
      $data['total_qoh'] = $total_qoh;
      $data['toal_cost_price'] = $toal_cost_price;
      $data['toal_value'] = $toal_value;

      $this->session->data['reports'] = $data['reports'];
      $this->session->data['total_qoh'] = $data['total_qoh'];
      $this->session->data['toal_cost_price'] = $data['toal_cost_price'];
      $this->session->data['toal_value'] = $data['toal_value'];
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
                    2 => 'Department'
                  );
  
    $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/inventory_on_hand_report_list', $data));
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
