<?php
class ControllerAdministrationHourlySalesReport extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('administration/hourly_sales_report');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('administration/hourly_sales_report');
        $this->load->model('api/hourly_sales_report');

        $this->getList();
    }

    public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        $report_hourly_sales = $this->session->data['report_hourly'];
        $report_categories = $this->session->data['report_categories'];
        $report_departments = $this->session->data['report_departments'];
        $report_shifts = $this->session->data['report_shifts'];
        $report_tenders = $this->session->data['report_tenders'];
        
       

        $data_row = '';
        
        $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;

        

        $data_row .= 'Sales by Hours'.PHP_EOL;

        if(isset($report_hourly_sales) && count($report_hourly_sales) > 0){
            foreach($report_hourly_sales as $report_hourly_sale){
                $data_row .= str_replace(',',' ',$report_hourly_sale['Hours']).','.$report_hourly_sale['Amount'].''.PHP_EOL;
            }
        }else{
            $data_row .= 'Sorry no data found!'.PHP_EOL;
        }

        $file_name_csv = 'hourly-report.csv';

        $file_path = DIR_TEMPLATE."/administration/hourly-report-report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/hourly-report-report.csv", "w");

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

    /*$data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];*/
    
    $data['report_sub_totals']    = $this->session->data['report_sub_totals'];
            
    $data['report_liability_sales'] = $this->session->data['report_liability_sales'];
        
    $data['report_deleted_sales'] = $this->session->data['report_deleted_sales'];

    $data['report_void_sale_amount'] = $this->session->data['report_void_sale_amount'];
        
    $data['report_house_charge'] = $this->session->data['report_house_charge'];
        
    $data['report_department_summary'] = $this->session->data['report_department_summary'];
        
    $data['report_sales_total'] = $this->session->data['report_sales_total'];
        
    $data['report_hourly'] = $this->session->data['report_hourly'];
        
    $data['report_paid_out'] = $this->session->data['report_paid_out'];
        
    $data['report_total_shift_cash'] = $this->session->data['report_total_shift_cash'];
    
    
    
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];
    
    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }

    $data['heading_title'] = 'Hourly Sales Report';

    $this->response->setOutput($this->load->view('administration/print_hourly_sales_report_page', $data));
  }

  public function pdf_save_page() {
error_reporting(E_ALL);
ini_set("display_errors", 1);
    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");
    $this->load->model('api/hourly_sales_report');
    /*$data['report_hourly_sales'] = $this->session->data['report_hourly_sales'];
    $data['report_categories'] = $this->session->data['report_categories'];
    $data['report_departments'] = $this->session->data['report_departments'];
    $data['report_shifts'] = $this->session->data['report_shifts'];
    $data['report_tenders'] = $this->session->data['report_tenders'];*/
    
    
    $data['report_sub_totals']    = $this->session->data['report_sub_totals'];
            
    $data['report_liability_sales'] = $this->session->data['report_liability_sales'];
        
    $data['report_deleted_sales'] = $this->session->data['report_deleted_sales'];

    $data['report_void_sale_amount'] = $this->session->data['report_void_sale_amount'];
        
    $data['report_house_charge'] = $this->session->data['report_house_charge'];
        
    $data['report_department_summary'] = $this->session->data['report_department_summary'];
        
    $data['report_sales_total'] = $this->session->data['report_sales_total'];
        
    $data['report_hourly'] = $this->session->data['report_hourly'];
        
    $data['report_paid_out'] = $this->session->data['report_paid_out'];
        
    $data['report_total_shift_cash'] = $this->session->data['report_total_shift_cash'];
    
    $data['storename'] = $this->session->data['storename'];
    $data['storeaddress'] = $this->session->data['storeaddress'];
    $data['storephone'] = $this->session->data['storephone'];

    if(!empty($this->session->data['p_start_date'])){
        $data['p_start_date'] = $this->session->data['p_start_date'];
    }else{
        $data['p_start_date'] = date("m-d-Y");
    }
    $data['report_card_amex'] = $this->model_api_hourly_sales_report->getCreditCardReport($data['p_start_date'],"amex");
            $data['report_card_master'] = $this->model_api_hourly_sales_report->getCreditCardReport($data['p_start_date'],"mastercard");
            $data['report_card_visa'] = $this->model_api_hourly_sales_report->getCreditCardReport($data['p_start_date'],"visa");
            $data['report_card_discover'] = $this->model_api_hourly_sales_report->getCreditCardReport($data['p_start_date'],"discover");
            $data['report_card_ebt'] = $this->model_api_hourly_sales_report->getCreditCardReport($data['p_start_date'],"EBT");
            
    $data['heading_title'] = 'Hourly Sales Report';
//$this->load->view('administration/print_hourly_sales_report_page', $data);die();

    $html = $this->load->view('administration/print_hourly_sales_report_page', $data);
    
    $this->dompdf->loadHtml($html);

$paper_orientation = 'landscape';
$customPaper = array(0,0,950,950);
$this->dompdf->setPaper($customPaper,$paper_orientation);


    //(Optional) Setup the paper size and orientation
    //$this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Hourly-sales-Report.pdf');
  }
      
    protected function getList() {
 error_reporting(E_ALL); ini_set('display_errors', 1); 
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");

        $url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            
            $data['report_sub_totals'] = $this->model_api_hourly_sales_report->getSumTotal($this->request->post['start_date']);
            $data['report_card_amex'] = $this->model_api_hourly_sales_report->getCreditCardReport($this->request->post['start_date'],"amex");
            $data['report_card_master'] = $this->model_api_hourly_sales_report->getCreditCardReport($this->request->post['start_date'],"mastercard");
            $data['report_card_visa'] = $this->model_api_hourly_sales_report->getCreditCardReport($this->request->post['start_date'],"visa");
            $data['report_card_discover'] = $this->model_api_hourly_sales_report->getCreditCardReport($this->request->post['start_date'],"discover");
            $data['report_card_ebt'] = $this->model_api_hourly_sales_report->getCreditCardReport($this->request->post['start_date'],"EBT");
            
            $data['report_liability_sales'] = $this->model_api_hourly_sales_report->liabilitySales($this->request->post['start_date']);
            
            $data['report_deleted_sales'] = $this->model_api_hourly_sales_report->deletedSales($this->request->post['start_date']);

            $data['report_void_sale_amount'] = $this->model_api_hourly_sales_report->voidSaleAmount($this->request->post['start_date']);
            
            $data['report_house_charge'] = $this->model_api_hourly_sales_report->houseCharge($this->request->post['start_date']);
            
            $data['report_department_summary'] = $this->model_api_hourly_sales_report->deptSummary($this->request->post['start_date']);
            
            $data['report_sales_total'] = $this->model_api_hourly_sales_report->salesTotal($this->request->post['start_date']);
            
            $data['report_hourly'] = $this->model_api_hourly_sales_report->hourlyReport($this->request->post['start_date'],$this->request->post['end_date']);
            
            $data['report_paid_out'] = $this->model_api_hourly_sales_report->paidOut($this->request->post['start_date']);
            
            $data['report_total_shift_cash'] = $this->model_api_hourly_sales_report->totalShiftCash($this->request->post['start_date']);

            
            /*$data['report_hourly_sales'] = $this->model_api_hourly_sales_report->getHourlySalesReport($this->request->post);

            $data['report_categories'] = $this->model_api_hourly_sales_report->getCategoriesReport($this->request->post);

            $data['report_departments'] = $this->model_api_hourly_sales_report->getDepartmentsReport($this->request->post);

            $data['report_shifts'] = $this->model_api_hourly_sales_report->getShiftsReport($this->request->post);

            $data['report_tenders'] = $this->model_api_hourly_sales_report->getTenderReport($this->request->post);*/

            $data['p_start_date'] = $this->request->post['start_date'];
            $this->session->data['p_start_date'] = $data['p_start_date'];
            
            $data['p_end_date'] = $this->request->post['end_date'];
            $this->session->data['p_end_date'] = $data['p_end_date'];
            
        }else{
            
            $data['report_sub_totals'] = $this->model_api_hourly_sales_report->getSumTotal();
            
            $data['report_liability_sales'] = $this->model_api_hourly_sales_report->liabilitySales();
            
            $data['report_deleted_sales'] = $this->model_api_hourly_sales_report->deletedSales();

            $data['report_void_sale_amount'] = $this->model_api_hourly_sales_report->voidSaleAmount();
            
            $data['report_house_charge'] = $this->model_api_hourly_sales_report->houseCharge();
            
            $data['report_department_summary'] = $this->model_api_hourly_sales_report->deptSummary();
            
            $data['report_sales_total'] = $this->model_api_hourly_sales_report->salesTotal();
            
            $data['report_hourly'] = $this->model_api_hourly_sales_report->hourlyReport();
            
            $data['report_paid_out'] = $this->model_api_hourly_sales_report->paidOut();
            
            $data['report_total_shift_cash'] = $this->model_api_hourly_sales_report->totalShiftCash();
            $data['report_card_amex'] = $this->model_api_hourly_sales_report->getCreditCardReport("","amex");
            $data['report_card_master'] = $this->model_api_hourly_sales_report->getCreditCardReport("","mastercard");
            $data['report_card_visa'] = $this->model_api_hourly_sales_report->getCreditCardReport("","visa");
            $data['report_card_discover'] = $this->model_api_hourly_sales_report->getCreditCardReport("","discover");
            $data['report_card_ebt'] = $this->model_api_hourly_sales_report->getCreditCardReport("","EBT");
            
            
            /*$data['report_hourly_sales'] = $this->model_api_hourly_sales_report->getHourlySalesReport();

            $data['report_categories'] = $this->model_api_hourly_sales_report->getCategoriesReport();

            $data['report_departments'] = $this->model_api_hourly_sales_report->getDepartmentsReport();

            $data['report_shifts'] = $this->model_api_hourly_sales_report->getShiftsReport();*/

            // $data['report_paidouts'] = $this->model_api_hourly_sales_report->getPaidoutsReport();

            // $data['report_picups'] = $this->model_api_hourly_sales_report->getPicupsReport();

            /*$data['report_tenders'] = $this->model_api_hourly_sales_report->getTenderReport();*/

        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('administration/hourly_sales_report', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['reportdata'] = $this->url->link('administration/hourly_sales_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
        $data['print_page'] = $this->url->link('administration/hourly_sales_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['pdf_save_page'] = $this->url->link('administration/hourly_sales_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['csv_export'] = $this->url->link('administration/hourly_sales_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
        
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


        $this->session->data['report_sub_totals'] = $data['report_sub_totals'];
            
        $this->session->data['report_liability_sales'] = $data['report_liability_sales'];
        
        $this->session->data['report_deleted_sales'] = $data['report_deleted_sales'];

        $this->session->data['report_void_sale_amount'] = $data['report_void_sale_amount'];
        
        $this->session->data['report_house_charge'] = $data['report_house_charge'];
        
        $this->session->data['report_department_summary'] = $data['report_department_summary'];
        
        $this->session->data['report_sales_total'] = $data['report_sales_total'];
        
        $this->session->data['report_hourly'] = $data['report_hourly'];
        
        $this->session->data['report_paid_out'] = $data['report_paid_out'];
        
        $this->session->data['report_total_shift_cash'] = $data['report_total_shift_cash'];



        /*$this->session->data['report_hourly_sales'] = $data['report_hourly_sales'];
        $this->session->data['report_categories']   = $data['report_categories'];
        $this->session->data['report_departments']  = $data['report_departments'];
        $this->session->data['report_shifts']       = $data['report_shifts'];
        $this->session->data['report_tenders']      = $data['report_tenders'];*/
      
        $data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];
        
        //print_r($data); exit;
    
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('administration/hourly_sales_report_list', $data));
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
  public function get_pdf_day(){echo 1;die();


      
  }
  
  
    
}
