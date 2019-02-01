<?php
class ControllerAdministrationEmployeeReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/employee_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	//$this->load->model('administration/sales_item_report');
		$this->load->model('api/employee_report');

		$this->getList();
	}

    public function csv_export() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");
        
        $data['reports'] = $this->session->data['reports'];
        
        $data_row = '';
        
        $data_row .= "Store Name: ".$this->session->data['storename'].PHP_EOL;
        $data_row .= "Store Address: ".$this->session->data['storeaddress'].PHP_EOL;
        $data_row .= "Store Phone: ".$this->session->data['storephone'].PHP_EOL;

        if(count($data['reports']) > 0){
   
            $data_row .= 'Username,Transaction Type,Transaction Id,Transaction Time,Product Name,Amount'.PHP_EOL;
            $total = 0;

            foreach ($data['reports'] as $key => $value) {
                $data_row .= str_replace(',',' ',$value['vusername']).','.str_replace(',',' ',$value['TrnType']).','.$value['isalesid'].','.str_replace(',',' ',$value['trn_date_time']).','.str_replace(',',' ',$value['vitemname']).','.number_format((float)$value['nextunitprice'], 2, '.', '').PHP_EOL;
                //$total = $total+$value['amount'];
            }
            
            //foreach ($data['reports']['deletes'] as $key => $value) {
                //$data_row .= str_replace(',',' ',$value['vusername']).','.str_replace(',',' ',$value['vtrntype']).','.$value['vitemname'].','.number_format((float)$value['nextunitprice'], 2, '.', '').','.str_replace(',',' ',$value['trn_date_time']).PHP_EOL;
                //$total = $total+$value['amount'];
            //}
            //$data_row .= 'Total,,,'.$total.PHP_EOL;

        }else{
            $data_row = 'Sorry no data found!';
        }

        $file_name_csv = 'Employee-Loss-Prevention-Report.csv';

        $file_path = DIR_TEMPLATE."/administration/Employee-Loss-Prevention-Report.csv";

        $myfile = fopen( DIR_TEMPLATE."/administration/Employee-Loss-Prevention-Report.csv", "w");

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
	
	$data['storename'] = $this->session->data['storename'];
	
	$data['storeaddress'] = $this->session->data['storeaddress'];
	
	$data['storephone'] = $this->session->data['storephone'];
	
	$data['heading_title'] = 'Employee Loss Prevention Report';
	
	// $data['selected_report'] = $this->session->data['selected_report'];
	
	$this->response->setOutput($this->load->view('administration/print_employee_report_page', $data));
  }

  public function pdf_save_page() {

    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");
   
	$data['reports'] = $this->session->data['reports'];

    $data['storename'] = $this->session->data['storename'];

    $data['storeaddress'] = $this->session->data['storeaddress'];

    $data['storephone'] = $this->session->data['storephone'];


    $data['heading_title'] = 'Employee Loss Prevention Report';

    // $data['selected_report'] = $this->session->data['selected_report'];

    $html = $this->load->view('administration/print_employee_report_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Employee-Report.pdf');
  }
	
  public function send_mail($email_to='adarsh.s.chacko@gmail.com'){
        
        //print_r($this->session->data['reports']);
        
        $email_to = $this->session->data['logged_email'];
        
        $mail = new Mail();
        
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');            
        $mail->setTo($email_to);
        $mail->setReplyTo($email_to);
        $mail->setFrom("webadmin@albertapayments.com");
        $mail->setSender("Notification");
        $mail->setSubject("Employee Loss Prevention Report For the Period From ".$this->session->data['p_start_date']." To ".$this->session->data['p_end_date']);
        
        if(count($this->session->data['reports']) > 0){
            
            $message = "<p><b>Store Name: </b> ".$this->session->data['storename']." </p>";
            $message .= "<p><b>Store Address: </b>".$this->session->data['storeaddress']."</p>";
            $message .= "<p><b>Store Phone: </b>".$this->session->data['storephone']." </p><br/>";
            
            $message .= "<p>Employee Loss Prevention Report For the Period From ".$this->session->data['p_start_date']." To ".$this->session->data['p_end_date']." is as follows</p><br/>";
            
            $message .= '<table class="table table-bordered table-striped table-hover" style="border:none;width:80%;">
                          <thead>
                            <tr style="border-top: 1px solid #ddd;">
                              <th style="text-align: center; vertical-align: middle;">Username</th>
                              <th style="text-align: center; vertical-align: middle;">Transaction Type</th>
                              <th style="text-align: center; vertical-align: middle;">Transaction Id</th>
                              <th style="text-align: center; vertical-align: middle;">Transaction Time</th>
                              <th style="text-align: center; vertical-align: middle;">Product Name</th>
                              <th style="text-align: center; vertical-align: middle;">Total Amount</th>
                            </tr>
                          </thead>
                          <tbody>';
                          
            foreach($this->session->data['reports'] as $report){
                
                $message .= '<tr>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vusername'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['TrnType'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['isalesid'].'</td>
                        <td  style="text-align: center; vertical-align: middle;">'. $report['trn_date_time'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vitemname'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['nextunitprice'].'</td>                        
                      </tr>';
            }
            
            /*foreach($this->session->data['reports']['voids'] as $report){
                
                $message .= '<tr>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vusername'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vtrntype'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vitemname'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['nextunitprice'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['trn_date_time'].'</td>
                      </tr>';
                      
                
            }
            
            foreach($this->session->data['reports']['deletes'] as $report){
                
                $message .= '<tr>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vusername'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vtrntype'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['vitemname'].'</td>
                        <td  style="text-align: center; vertical-align: middle;">'. $report['nextunitprice'].'</td>
                        <td style="text-align: center; vertical-align: middle;">'. $report['trn_date_time'].'</td>
                      </tr>';
            }*/
            
            $message .= '</tbody>              
                        </table>';
        } else {
            
            $message = '<div class="row">
                          <div class="col-md-12"><br><br>
                            <div class="alert alert-info text-center">
                              <strong>Sorry no data found!</strong>
                            </div>
                          </div>
                        </div>';
        }
        
                  
        //$message .='';
        
        $mail->setHtml($message);
        //$mail->isHTML();
        
        //$mail->setText();
        
        $send = $mail->send();
        
        echo $email_to;
      
  }
	  
    protected function getList() {

        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "2G");
        
		$url = '';
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
	
			$data['p_start_date'] = $this->request->post['start_date'];
			$data['p_end_date'] = $this->request->post['end_date'];
			

			$reportsdata = $this->model_api_employee_report->getCategoriesReport($data['p_start_date'],$data['p_end_date']);
			
			$data['reports'] = $reportsdata;
			$this->session->data['p_start_date'] = $data['p_start_date'];
			$this->session->data['p_end_date'] = $data['p_end_date'];
			
			$this->session->data['reports'] = $data['reports'];
			//$this->session->data['selected_report'] = $data['selected_report'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/sales_item_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['reportdata'] = $this->url->link('administration/employee_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
		$data['print_page'] = $this->url->link('administration/employee_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
        $data['pdf_save_page'] = $this->url->link('administration/employee_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['csv_export'] = $this->url->link('administration/employee_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
		$data['send_mail'] = $this->url->link('administration/employee_report/send_mail', 'token=' . $this->session->data['token'] . $url, true);
		
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

		$data['byreports'] = array(1 => 'Category',2 => 'Department');
  
		$data['storename'] = $this->session->data['storename'];
		$data['storeaddress'] = $this->session->data['storeaddress'];
		$data['storephone'] = $this->session->data['storephone'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/employee_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/sales_item_report')) {
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

    $this->load->model('api/sales_item_report');

    if(!empty($this->request->get['report_by'])){
      if($this->request->get['report_by'] == 1){
        $datas = $this->model_api_sales_item_report->getCategories();
      }elseif($this->request->get['report_by'] == 2){
        $datas = $this->model_api_sales_item_report->getDepartments();
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
