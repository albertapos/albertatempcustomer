<?php
class ControllerAdministrationCashSalesSummary extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/cash_sales_summary');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/cash_sales_summary');

		$this->getList();
	}

  public function print_page() {
    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];
    $data['desc_title'] = $this->session->data['desc_title'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Cash & Sales Summary';

    $this->response->setOutput($this->load->view('administration/print_page_list', $data));
  }
	  
	protected function getList() {

		$url = '';

    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      if($this->request->post['report_by'] == 1){
        $data['reports'] = $this->model_administration_cash_sales_summary->getCategoriesReport($this->request->post);
      }elseif($this->request->post['report_by'] == 2){
        $data['reports'] = $this->model_administration_cash_sales_summary->getDepartmentsReport($this->request->post);
      }else{
         $data['reports'] = $this->model_administration_cash_sales_summary->getGroupsReport($this->request->post);
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
			'href' => $this->url->link('administration/cash_sales_summary', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('administration/cash_sales_summary/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/cash_sales_summary/print_page', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$this->response->setOutput($this->load->view('administration/cash_sales_summary_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/plcb_reports')) {
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
	
}
