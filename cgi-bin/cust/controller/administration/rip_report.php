<?php
class ControllerAdministrationRipReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/rip_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('administration/rip_report');

		$this->getList();
	}
	
	public function rip_add(){
		
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->language('administration/rip_report');
    
		$this->load->model('administration/rip_report');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$this->model_administration_rip_report->AddRipDetail($this->request->post);
			
			$url = '';

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('administration/rip_report', 'token=' . $this->session->data['token'] . $url, true));
		  }

    	$this->getList();
	}
	
	public function rip_view($id=0) {
	
	$this->load->language('administration/rip_report');
	
	$this->document->setTitle($this->language->get('heading_title'));
	
	$data['heading_title'] = $this->language->get('heading_title');
		
    $ripheaderid = ($this->request->get['ripheaderid'])?$this->request->get['ripheaderid']:$id;
	
	$print_page = $this->url->link('administration/rip_report/print_page', 'token=' . $this->session->data['token'] .'&ripheaderid='.$ripheaderid, true);
	
	$this->load->model('administration/rip_report');
	//$this->load->model('api/store');

	//$store_info= $this->model_api_store->getStore();
	
	$sales_tender= $this->model_administration_rip_report->getRipDetail($ripheaderid);
	
	$html='';
	
	$html.='<table class="table table-bordered table-striped table-hover" style="border:none;">';
	$html.='<thead><tr>';	  
	$html.='<th>Check No.</th>';
	$html.='<th class="text-right">Amount</th>';
	$html.='<th>Desc#</th>';
	$html.='</tr></thead>';
	$html.='<tbody>';	
	foreach($sales_tender as $value){
		$html.='<tr>';
		$html.='<td>'.$value['checknumber'].'</td>';
		$html.='<td class="text-right">'.$value['checkamt'].'</td>';
		$html.='<td>'.$value['checkdesc'].'</td>';
		$html.='</tr>';	
	}
	
	$html.='</tr></tbody>';	
		 
	$html.='</table>';
	/*$store='';
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

	$myfile = fopen( DIR_TEMPLATE."/administration/print_rip_report.tpl", "w");
	fwrite($myfile,$file);
	fclose($myfile);*/

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

    $html = $this->load->view('administration/print_rip_report', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Sales-Report.pdf');
  }
	  
	protected function getList() {

		if (isset($this->request->post['vendorid'])) {
			$data['vendorid'] = $this->request->post['vendorid'];
		} elseif (isset($this->request->get['vendorid'])) {
			$data['vendorid'] = $this->request->get['vendorid'];
		} else {
			$data['vendorid'] = '';
		}
		
		if (isset($this->request->post['start_date'])) {
			$data['start_date'] = $this->request->post['start_date'];
		} elseif (isset($this->request->get['start_date'])) {
			$data['start_date'] = $this->request->get['start_date'];
		} else {
			$data['start_date'] = '';
		}

		if (isset($this->request->post['end_date'])) {
			$data['end_date'] = $this->request->post['end_date'];
		} elseif (isset($this->request->get['end_date'])) {
			$data['end_date'] = $this->request->get['end_date'];
		} else {
			$data['end_date'] = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'vcompanyname';
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
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$filter_data = array(
			'vendorid'  => $data['vendorid'],
			'start_date'  => $data['start_date'],
			'end_date'  => $data['end_date'],
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$rip_total = $this->model_administration_rip_report->getTotalRips($filter_data);
		
		$data['rips'] = $this->model_administration_rip_report->getRips($filter_data);

		if ($data['start_date'] != '' && $data['end_date'] != '') {
			$url .= '&start_date=' .$data['start_date'].'&end_date='.$data['end_date'] ;
		}
		
		$pagination = new Pagination();
		$pagination->total = $rip_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('administration/rip_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
		
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($rip_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($rip_total - $this->config->get('config_limit_admin'))) ? $rip_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $rip_total, ceil($rip_total / $this->config->get('config_limit_admin')));
			
		$data['sort'] = $sort;
		$data['order'] = $order;		
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/rip_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['print_page'] = $this->url->link('administration/rip_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['pdf_save_page'] = $this->url->link('administration/rip_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);

		$data['current_url'] = $this->url->link('administration/rip_report', 'token=' . $this->session->data['token'], true);
		$data['searchvendor'] = $this->url->link('administration/rip_report/search', 'token=' . $this->session->data['token'], true);
		
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

		$this->load->model('administration/items');
		$suppliers = $this->model_administration_items->getSuppliers();		
		$data['suppliers'] = $suppliers;		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('administration/rip_report_list', $data));
	}
	
	protected function validateEditList() {
    	if(!$this->user->hasPermission('modify', 'administration/rip_report')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  }	
  
	public function printpage(){
		$this->response->setOutput($this->load->view('administration/print_rip_report'));	
	}

	public function search(){
		$return = array();
		$this->load->model('api/vendor');
		if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

			$datas = $this->model_api_vendor->getVendorSearch($this->request->get['term']);

			foreach ($datas as $key => $value) {
				$temp = array();
				$temp['isupplierid'] = $value['isupplierid'];
				$temp['vcompanyname'] = $value['vcompanyname'];
				$return[] = $temp;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($return));
	}
}
