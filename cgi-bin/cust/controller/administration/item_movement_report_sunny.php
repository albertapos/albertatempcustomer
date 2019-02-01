<?php
class ControllerAdministrationItemMovementReport extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('administration/item_movement_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('api/item_movement_report');

		$this->getList();
	}

  public function print_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'] ;
    //$data['p_start_date'] = $this->session->data['p_start_date'];
    //$data['p_end_date'] = $this->session->data['p_end_date'];
    $data['search_iitemid'] = $this->session->data['search_iitemid'] ;
    $data['search_vbarcode'] = $this->session->data['search_vbarcode'] ;
    $data['report_by'] = $this->session->data['report_by'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Item Movement Report';

    $this->response->setOutput($this->load->view('administration/print_item_movement_report_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'] ;
    //$data['p_start_date'] = $this->session->data['p_start_date'];
    //$data['p_end_date'] = $this->session->data['p_end_date'];
    $data['search_iitemid'] = $this->session->data['search_iitemid'] ;
    $data['search_vbarcode'] = $this->session->data['search_vbarcode'] ;
    $data['report_by'] = $this->session->data['report_by'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Item Movement Report';

    $html = $this->load->view('administration/print_item_movement_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Item-Movement-Report.pdf');
  }

	protected function getList() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      
      $data['reports'] = $this->model_api_item_movement_report->getItemMovementReport($this->request->post);

      $data['report_by'] = $this->request->post['report_by'];
      $data['search_iitemid'] = $this->request->post['search_iitemid'];
      $data['search_vbarcode'] = $this->request->post['search_vbarcode'];

      //$data['p_start_date'] = $this->request->post['start_date'];
      //$data['p_end_date'] = $this->request->post['end_date'];

      $this->session->data['reports'] = $data['reports'];
      //$this->session->data['p_start_date'] = $data['p_start_date'];
      //$this->session->data['p_end_date'] = $data['p_end_date'];
      $this->session->data['search_iitemid'] = $data['search_iitemid'];
      $this->session->data['search_vbarcode'] = $data['search_vbarcode'];
      $this->session->data['report_by'] = $data['report_by'];
      
    }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/item_movement_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('administration/item_movement_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['item_movement_data'] = $this->url->link('administration/item_movement_report/item_movement_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/item_movement_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/item_movement_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('administration/item_movement_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
    $data['searchitem'] = $this->url->link('administration/item_movement_report/searchitem', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$this->response->setOutput($this->load->view('administration/item_movement_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/item_movement_report')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }

  public function searchitem() {
    $return = array();
    $this->load->model('api/item_movement_report');
    if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

      $datas = $this->model_api_item_movement_report->getItemsSearchResult($this->request->get['term']);

      foreach ($datas as $key => $value) {
        $temp = array();
        $temp['iitemid'] = $value['iitemid'];
        $temp['vbarcode'] = $value['vbarcode'];
        $temp['vitemname'] = $value['vitemname'];
        $return[] = $temp;
      }
    }
    $this->response->addHeader('Content-Type: application/json');
      $this->response->setOutput(json_encode($return));
    
  }

  public function item_movement_data() {
    $return = array();
    $this->load->model('api/item_movement_report');
    if((isset($this->request->get['vbarcode']) && !empty($this->request->get['vbarcode'])) && (isset($this->request->get['start_date']) && !empty($this->request->get['start_date'])) && (isset($this->request->get['end_date']) && !empty($this->request->get['end_date'])) && (isset($this->request->get['data_by']) && !empty($this->request->get['data_by']))){

      $return = $this->model_api_item_movement_report->getItemMovementData($this->request->get['vbarcode'],$this->request->get['start_date'],$this->request->get['end_date'],$this->request->get['data_by']);
      
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($return));
    
  }
	
}
