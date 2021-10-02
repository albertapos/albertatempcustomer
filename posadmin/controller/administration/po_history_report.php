<?php
class ControllerAdministrationPoHistoryReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/po_history_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/po_history_report');

		$this->getList();
	}

    public function print_page() {
        $data['reports'] = $this->session->data['reports'];
        $data['p_start_date'] = $this->session->data['p_start_date'];
        $data['p_end_date'] = $this->session->data['p_end_date'];

        $data['storename'] = $this->session->data['storename'];

        $data['heading_title'] = 'PO History Report';

        $this->response->setOutput($this->load->view('administration/print_po_history_report_page', $data));
    }

    public function pdf_save_page() {
        $data['reports'] = $this->session->data['reports'];
        $data['p_start_date'] = $this->session->data['p_start_date'];
        $data['p_end_date'] = $this->session->data['p_end_date'];

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

        if(!empty($this->request->get['vendor_id']) && !empty($this->request->get['vendor_date'])){
          
            $datas = $this->model_administration_po_history_report->getViewItems($this->request->get['vendor_id'],$this->request->get['vendor_date']);

            $return['code'] = 1;
            $return['data'] = $datas;
        }else{
            $return['code'] = 0;
        }
        echo json_encode($return);
        exit;  
    }
	  
	protected function getList() {
		$url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if(in_array('ALL', $this->request->post['report_by'])){
                $reportsdata = $this->model_administration_po_history_report->getPoHistoryReportAll($this->request->post);
            }else{
                $reportsdata = $this->model_administration_po_history_report->getPoHistoryReport($this->request->post);
            }
          
            $data['reports'] = $reportsdata;

            $data['selected_byreports'] = $this->request->post['report_by'];

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
			'href' => $this->url->link('administration/po_history_report', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['reportdata'] = $this->url->link('administration/po_history_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
        $data['print_page'] = $this->url->link('administration/po_history_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['pdf_save_page'] = $this->url->link('administration/po_history_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
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