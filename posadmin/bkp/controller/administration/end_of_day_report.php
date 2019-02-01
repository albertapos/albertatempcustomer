<?php
class ControllerAdministrationEndOfDayReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/end_of_day_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/end_of_day_report');

		$this->getList();
	}

  public function print_page() {

    $data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];
    
    $data['storename'] = $this->session->data['storename'];

    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }

    $data['heading_title'] = 'End of Day Report';

    $this->response->setOutput($this->load->view('administration/print_end_of_day_report_page', $data));
  }
	  
	protected function getList() {

		$url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $data['report_hourly_sales'] = $this->model_administration_end_of_day_report->getHourlySalesReport($this->request->post);

            $data['report_categories'] = $this->model_administration_end_of_day_report->getCategoriesReport($this->request->post);

            $data['report_departments'] = $this->model_administration_end_of_day_report->getDepartmentsReport($this->request->post);

            $data['report_shifts'] = $this->model_administration_end_of_day_report->getShiftsReport($this->request->post);

            $data['report_tenders'] = $this->model_administration_end_of_day_report->getTenderReport($this->request->post);

            $data['p_start_date'] = $this->request->post['start_date'];
            $this->session->data['p_start_date'] = $data['p_start_date'];

        }else{

            $data['report_hourly_sales'] = $this->model_administration_end_of_day_report->getHourlySalesReport();

            $data['report_categories'] = $this->model_administration_end_of_day_report->getCategoriesReport();

            $data['report_departments'] = $this->model_administration_end_of_day_report->getDepartmentsReport();

            $data['report_shifts'] = $this->model_administration_end_of_day_report->getShiftsReport();

            // $data['report_paidouts'] = $this->model_administration_end_of_day_report->getPaidoutsReport();

            // $data['report_picups'] = $this->model_administration_end_of_day_report->getPicupsReport();

            $data['report_tenders'] = $this->model_administration_end_of_day_report->getTenderReport();

        }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/end_of_day_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('administration/end_of_day_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('administration/end_of_day_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		
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

    $this->session->data['report_hourly_sales'] = $data['report_hourly_sales'];
    $this->session->data['report_categories']   = $data['report_categories'];
    $this->session->data['report_departments']  = $data['report_departments'];
    $this->session->data['report_shifts']       = $data['report_shifts'];
    $this->session->data['report_tenders']      = $data['report_tenders'];
  
    $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/end_of_day_report_list', $data));
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
