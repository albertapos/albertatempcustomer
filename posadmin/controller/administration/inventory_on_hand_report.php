<?php
class ControllerAdministrationInventoryOnHandReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/inventory_on_hand_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/inventory_on_hand_report');

		$this->getList();
	}

  public function print_page() {
    $data['reports'] = $this->session->data['reports'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Inventory On Hand Report';

    $data['selected_report'] = $this->session->data['selected_report'];

    $this->response->setOutput($this->load->view('administration/print_inventory_on_hand_report_page', $data));
  }

  public function pdf_save_page() {
    $data['reports'] = $this->session->data['reports'];

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
	  
	protected function getList() {

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

      if($this->request->post['report_by'] == 1){
        $reportsdata = $this->model_administration_inventory_on_hand_report->getCategoriesReport($this->request->post);
        $data['selected_report'] = 1;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getCategories();
      }elseif($this->request->post['report_by'] == 2){
        $reportsdata = $this->model_administration_inventory_on_hand_report->getDepartmentsReport($this->request->post);
        $data['selected_report'] = 2;
        $data['drop_down_datas'] = $this->model_administration_inventory_on_hand_report->getDepartments();
      }

      $data['selected_report_data'] = $this->request->post['report_data'];

      $data['reports'] = $reportsdata;

      $this->session->data['reports'] = $data['reports'];
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
