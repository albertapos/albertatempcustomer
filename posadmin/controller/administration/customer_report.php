<?php
class ControllerAdministrationCustomerReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/customer_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('administration/customer');

		$this->getList();
	}
	
  public function customer_view($id=0) {
	
	$this->load->language('administration/customer_report');
	
	$this->document->setTitle($this->language->get('heading_title'));
	
	$data['heading_title'] = $this->language->get('heading_title');
		
    $icustomerid = ($this->request->get['icustomerid'])?$this->request->get['icustomerid']:$id;
	
	$print_page = $this->url->link('administration/customer_report/print_page', 'token=' . $this->session->data['token'] .'&icustomerid='.$icustomerid, true);
	
	$this->load->model('administration/customer');
	$this->load->model('api/store');

	$store_info= $this->model_api_store->getStore();
	
	$sales_tender= $this->model_administration_customer->getCustomerPay($icustomerid);
	
	$html='';
	
	$html.='<table class="table table-bordered table-striped table-hover" style="border:none;">';
	$html.='<thead><tr>';	  
	$html.='<th>Tran. Date</th>';
	//$html.='<th>Check Number</th>';
	//$html.='<th>Bank Name</th>';
	$html.='<th>Tran. Type</th>';
	$html.='<th>Credit Amt.</th>';
	$html.='<th>Debit Amt.</th>';
	$html.='<th>Balance Amt.</th>';
	$html.='</tr></thead>';
	$html.='<tbody>';	
	foreach($sales_tender as $value){
		$html.='<tr>';
		$html.='<td>'.$value['dtrandate'].'</td>';
		//$html.='<td>'.$value['vchecknumber'].'</td>';
		//$html.='<td>'.$value['vbankname'].'</td>';
		$html.='<td>'.$value['vtrantype'].'</td>';
		$html.='<td>'.$value['ncreditamt'].'</td>';
		$html.='<td>'.$value['ndebitamt'].'</td>';
		$html.='<td>'.$value['nbalamt'].'</td>';
		$html.='</tr>';	
	}
	
	$html.='</tr></tbody>';	
		 
	$html.='</table>';
	$store='';
	$store.='<table width="100%" border="0" cellspacing="5" cellpadding="0">
		  <tr>
			<td align="center"><strong>'.$store_info['vstorename'].'</strong></td>
		  </tr>
		  <tr>
			<td align="center"><strong>'.$store_info['vaddress1'].'</strong></td>
		  </tr>
		  <tr>
			<td align="center"><strong>'.$store_info['vcity']." ".$store_info['vstate']." ".$store_info['vzip'].'</strong></td>
		  </tr>
		  <tr>
			<td align="center"><strong>'.$store_info['vphone1'].'</strong></td>
		  </tr>
		</table><hr>';
	
	$file='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><div id="content">
  <div class="container-fluid">
    <div class="" style="margin-top:0%;">
      <div class="panel-body"> 
        <div class="row">
          <div class="col-md-12" id="printappend">'.$store.$html.'          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';

	$myfile = fopen( DIR_TEMPLATE."/administration/print_customer_report.tpl", "w");
	fwrite($myfile,$file);
	fclose($myfile);

	$return['code'] = 1;
    $return['data'] = $html;
   
    echo json_encode($return);
    exit;
  }

  public function pdf_save_page() {
    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Sales Report';

    $html = $this->load->view('administration/print_customer_report', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Sales-Report.pdf');
  }
	  
	protected function getList() {

		if (isset($this->request->post['start_date'])) {
			$data['start_date'] = $this->request->post['start_date'];
		} elseif (isset($this->request->get['start_date'])) {
			$data['start_date'] = $this->request->get['start_date'];
		} else {
			$data['start_date'] = date('m-d-Y',strtotime('-1 day'));
		}

		if (isset($this->request->post['end_date'])) {
			$data['end_date'] = $this->request->post['end_date'];
		} elseif (isset($this->request->get['end_date'])) {
			$data['end_date'] = $this->request->get['end_date'];
		} else {
			$data['end_date'] = date('m-d-Y');
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'vcustomername';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($data['start_date'])) {
			$url .= '&start_date=' . urlencode(html_entity_decode($data['start_date'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($data['end_date'])) {
			$url .= '&end_date=' . urlencode(html_entity_decode($data['end_date'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filter_data = array(
			'start_date'  => $data['start_date'],
			'end_date'  => $data['end_date'],
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$customers_total = $this->model_administration_customer->getTotalCustomers($filter_data);
		
		$customer_datas = $this->model_administration_customer->getCustomers($filter_data);
		
		$data['customers'] = $customer_datas;	
		
		$this->session->data['reports'] = $data['customers'];
		$this->session->data['p_start_date'] = $data['start_date'];
		$this->session->data['p_end_date'] = $data['end_date'];
		
		$pagination = new Pagination();
		$pagination->total = $customers_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/customer_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($customers_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($customers_total - $this->config->get('config_limit_admin'))) ? $customers_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $customers_total, ceil($customers_total / $this->config->get('config_limit_admin')));
			
		$data['sort'] = $sort;
		$data['order'] = $order;		
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/customer_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['reportdata'] = $this->url->link('administration/customer_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
		$data['print_page'] = $this->url->link('administration/customer_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['pdf_save_page'] = $this->url->link('administration/customer_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		
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

		$this->response->setOutput($this->load->view('administration/customer_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/customer_report')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }	
	public function printpage(){
		$this->response->setOutput($this->load->view('administration/print_customer_report'));	
	}
}
