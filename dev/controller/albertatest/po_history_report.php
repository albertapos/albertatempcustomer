<?php
class ControllerAdministrationPoHistoryReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/po_history_report');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('administration/po_history_report');
		$this->load->model('api/po_history_report');

		$this->getList();
	}

    public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        $data['reports'] = $this->session->data['reports'];
        $data['net_tot'] = $this->session->data['net_tot'];
        $data['rip_tot'] = $this->session->data['rip_tot'];
        
        $data_row = '';

        if(count($data['reports']) > 0){
            $data_row .= 'Vendor,Date,Net Total,RIP Total Amt'.PHP_EOL;

            foreach ($data['reports'] as $key => $value) {
                $data_row .= str_replace(',',' ',$value['vvendorname']).','.$value['dcreatedate'].','.number_format((float)$value['nnettotal'], 2, '.', '').','.number_format((float)$value['rip_total'], 2, '.', '').PHP_EOL;
            }

            $data_row .= ',Total,$'.$data['net_tot'].',$'.$data['rip_tot'].PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'po-history-report.csv';

        $file_path = DIR_TEMPLATE."/administration/po-history-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/po-history-report.csv", "w");

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

        $data['net_tot'] = $this->session->data['net_tot'];
        $data['rip_tot'] = $this->session->data['rip_tot'];

        $data['storename'] = $this->session->data['storename'];

        $data['heading_title'] = 'PO History Report';

        $this->response->setOutput($this->load->view('administration/print_po_history_report_page', $data));
    }

    public function pdf_save_page() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        $data['reports'] = $this->session->data['reports'];
        $data['p_start_date'] = $this->session->data['p_start_date'];
        $data['p_end_date'] = $this->session->data['p_end_date'];
        $data['net_tot'] = $this->session->data['net_tot'];
        $data['rip_tot'] = $this->session->data['rip_tot'];

        $data['storename'] = $this->session->data['storename'];

        $data['heading_title'] = 'PO History Report';

        $html = $this->load->view('administration/print_po_history_report_page', $data);
    
        $this->dompdf->loadHtml($html);

        //(Optional) Setup the paper size and orientation
        // $this->dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the generated PDF to Browser
        $this->dompdf->stream('PO-History-Report.pdf');
    }

    public function view_item() {
        $return = array();

        $this->load->model('administration/po_history_report');
        $this->load->model('api/po_history_report');

        if(!empty($this->request->get['vendor_id']) && !empty($this->request->get['vendor_date'])){
          
            $datas = $this->model_api_po_history_report->getViewItems($this->request->get['vendor_id'],$this->request->get['vendor_date'], $this->request->get['vendor_ipoid']);

            $return['code'] = 1;
            $return['data'] = $datas;
        }else{
            $return['code'] = 0;
        }
        echo json_encode($return);
        exit;  
    }
	  
	protected function getList() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

		$url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if(in_array('ALL', $this->request->post['report_by'])){
                $reportsdata = $this->model_api_po_history_report->getPoHistoryReportAll($this->request->post);
            }else{
                $reportsdata = $this->model_api_po_history_report->getPoHistoryReport($this->request->post);
            }
          
            $data['reports'] = $reportsdata;

            $net_tot = 0;
            $rip_tot = 0;

            if(count($reportsdata) > 0){
                foreach ($reportsdata as $key => $value) {
                    $net_tot = $net_tot + $value['nnettotal'];
                    $rip_tot = $rip_tot + $value['rip_total'];
                }
            }

            $data['net_tot'] = number_format((float)$net_tot, 2, '.', '');
            $data['rip_tot'] = number_format((float)$rip_tot, 2, '.', '');

            $data['selected_byreports'] = $this->request->post['report_by'];

            $data['p_start_date'] = $this->request->post['start_date'];
            $data['p_end_date'] = $this->request->post['end_date'];

            $this->session->data['reports'] = $data['reports'];
            $this->session->data['p_start_date'] = $data['p_start_date'];
            $this->session->data['p_end_date'] = $data['p_end_date'];
            $this->session->data['net_tot'] = $data['net_tot'];
            $this->session->data['rip_tot'] = $data['rip_tot'];

        }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/po_history_report', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['reportdata'] = $this->url->link('administration/po_history_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
        $data['print_page'] = $this->url->link('administration/po_history_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['pdf_save_page'] = $this->url->link('administration/po_history_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['csv_export'] = $this->url->link('administration/po_history_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
        $data['view_item'] = $this->url->link('administration/po_history_report/view_item', 'token=' . $this->session->data['token'] . $url, true);
		
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

        $data['byreports'] = $this->model_administration_po_history_report->getVendors();
  
        $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/po_history_report_list', $data));
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
