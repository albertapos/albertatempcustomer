<?php
class ControllerAdministrationSalesReport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/sales_report');

		$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('administration/sales_report');
		$this->load->model('api/sales_report');

		$this->getList();
	}
	
  public function sales_view($id=0) {
	
	$data['heading_title'] = 'Sales Report';
		
    $salesid = ($this->request->get['salesid'])?$this->request->get['salesid']:$id;
	
	$print_page = $this->url->link('administration/sales_report/print_page', 'token=' . $this->session->data['token'] .'&salesid='.$salesid, true);
	
	$this->load->language('administration/sales_report');
	
	$this->document->setTitle($this->language->get('heading_title'));
	
	$this->load->model('administration/sales_report');
	$this->load->model('api/sales_report');
	$this->load->model('api/store');

	$store_info= $this->model_api_store->getStore();
	
	$sales_header= $this->model_api_sales_report->getSalesById($salesid);
	
	$trn_date = DateTime::createFromFormat('m-d-Y h:i A', $sales_header['trandate']);
	$trn_date = $trn_date->format('m-d-Y');

	$sales_detail= $this->model_api_sales_report->getSalesPerview($salesid);

	$sales_tender= $this->model_api_sales_report->getSalesByTender($salesid);

	$sales_customer= $this->model_api_sales_report->getSalesByCustomer($sales_header['icustomerid']);

	if(count($sales_customer) > 0){
		$c_name = $sales_customer['vfname'].' '.$sales_customer['vlname'];
		$c_address = $sales_customer['vaddress1'];
		$c_city = $sales_customer['vcity'].',';
		$c_state = $sales_customer['vstate'];
		$c_zip = $sales_customer['vzip'];
		$c_phone = 'Phone: '.$sales_customer['vphone'];
	}else{
		$c_name = '';
		$c_address = '';
		$c_city = '';
		$c_state = '';
		$c_zip = '';
		$c_phone = '';
	}
	
	$html='';
	
	$html='<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<table width="100%" border="0" cellspacing="5" cellpadding="0" style="margin-bottom:15px;">
					<tr>
					  	<td align="center">
							<h3>Sales Transaction</h3>
					  	</td>
				  </tr>
				</table>
			</tr>
		  <tr style="border-bottom:1px solid #999;">
			<td valign="top">
				<table width="100%" border="0" cellspacing="5" cellpadding="0" style="border-bottom:1px solid #999;">
				  <tr style="line-height:25px;">
				  	<td width="50%" align="left">
				  	<strong>Date</strong> '. date('m-d-Y') .'
				  	</td>
				  	<td width="25%" align="right">
				  		<strong>Order Number</strong>
				  	</td>
				  	<td>&nbsp;&nbsp;'.$sales_header['isalesid'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left"><strong>Store Name: </strong>'.$store_info['vstorename'].'</td>
					<td width="25%" align="right"><strong>Status</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['estatus'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left"><strong>Store Address: </strong>'.$store_info['vaddress1'].'</td>
					<td width="25%" align="right"><strong>Ordered</strong></td>
					<td>&nbsp;&nbsp;'.$trn_date.'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left"><strong></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					'.$store_info['vcity']." ".$store_info['vstate']." ".$store_info['vzip'].'
					</td>
					<td width="25%" align="right"><strong>Invoiced</strong></td>
					<td>&nbsp;&nbsp;'.$trn_date.'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left"><strong>Store Phone: </strong>'.$this->session->data['storephone'].'</td>
					<td width="25%" align="right"><strong>Sale Number</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['isalesid'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">&nbsp;</td>
					<td width="25%" align="right"><strong>Sales Person</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['vusername'].' ('.$sales_header['iuserid'].')</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">&nbsp;</td>
					<td width="25%" align="right"><strong>Tender Type</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['vtendertype'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">&nbsp;</td>
					<td width="25%" align="right"><strong>TRN</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['isalesid'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">&nbsp;</td>
					<td width="25%" align="right"><strong>TRN Time</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['trandate'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">&nbsp;</td>
					<td width="25%" align="right"><strong>Register</strong></td>
					<td>&nbsp;&nbsp;'.$sales_header['vterminalid'].'</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left"><strong>Bill</strong>&nbsp;</td>
					<td width="25%" align="right"><strong>Ship To</strong></td>
					<td>&nbsp;&nbsp;</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">'.$c_name.'</td>
					<td width="25%" align="right">&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">'.$c_address.'</td>
					<td width="25%" align="right">&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">'.$c_city.' '.$c_state.' '.$c_zip.'</td>
					<td width="25%" align="right">&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				  </tr>
				  <tr style="line-height:25px;">
					<td width="50%" align="left">'.$c_phone.'</td>
					<td width="25%" align="right">&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				  </tr>
				</table>
			</td>
		  </tr>		 
		  <tr style="border-bottom:1px solid #999;">
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin:15px 0px;">';
		if(count($sales_detail)>0)
		{
			$sub_total=0;
			$tax=0;
			$total=0;
			$noofitems =0;
			$html.='<tr>';
			$html.='<th>Qty</th>';
			$html.='<th>Pack</th>';
			$html.='<th>SKU</th>';
			$html.='<th>Item Name</th>';
			$html.='<th>Size</th>';
			$html.='<th>Unit Price</th>';
			$html.='<th>Total Price</th>';
			$html.='</tr>';
			foreach($sales_detail as $sales)
			{
				$sub_total+=$sales['nextunitprice'];
				$noofitems+=$sales['ndebitqty'];
				$html.='
					
					<tr>
						<td>'.$sales['ndebitqty'].'</td>
						<td>'.$sales['npack'].'</td>
						<td>'.$sales['vitemcode'].'</td>
						<td>'.$sales['vitemname'].'</td>
						<td>'.$sales['vsize'].'</td>
						<td>'.$sales['nunitprice'].'</td>
						<td>'.$sales['nextunitprice'].'</td>
					</tr>';

			  	// 	<tr>
						// <td width="75%" align="left">'.$sales['ndebitqty']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sales['vitemname'].'<br>
						//   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						  
						// 	if($sales['vunitcode']=="UNT002")
						// 	{
						// 		$html.=$sales['ndebitqty'].' lb @ '.$sales['ndebitamt'];
						// 	}
							
						// 	if((strlen($sales['npack']) >0 && $sales['npack']!=1) || $sales['vitemtype']=="Lot Matrix")
						// 	{
						// 		$html.='&nbsp;Pack : ' .$sales['npack'];
						// 	}
							
						// 	if(strlen($sales['vsize']) > 0)
						// 	{
						// 		$html.='&nbsp;&nbsp;&nbsp;Size : '.$sales['vsize'];
						// 	}
						//   $html.='</td>
						// <td width="25%" align="right">'.$sales['nextunitprice'].'</td>
					 //  </tr>';
			}
			/*$html.='<tr>
				<td align="left"><strong>No of Items '.$noofitems.'</strong></td>
				<td align="right">&nbsp;</td>
			  </tr>';*/
		}
	  $html.='</table></td>
		  </tr><hr style="border-top:1px solid #999;">
		  <tr style="border-bottom:1px solid #999;">
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;">
			  <tr>
				<td width="70%" align="right" style="padding-bottom:5px;"><strong>Sub Total</strong></td>
				<td width="10%" style="padding-bottom:5px;">&nbsp;</td>
				<td width="20%" align="right" style="padding-bottom:5px;">'.$sub_total.'</td>
			  </tr>
			  <tr style="border-top:1px solid #999;">
				<td width="70%" align="right" style="padding-top:5px;padding-bottom:5px;"><strong>Tax</strong></td>
				<td width="10%" style="padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td width="20%" align="right" style="padding-top:5px;padding-bottom:5px;">'.$sales_header['ntaxtotal'].'</td>
			  </tr>
			  <tr style="border-top:1px solid #999;border-bottom:1px solid #999;">
				<td width="70%" align="right" style="padding-top:5px;padding-bottom:5px;"><strong>Total</strong></td>
				<td width="10%" style="padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td width="20%" align="right" style="padding-top:5px;padding-bottom:5px;">';
				$total=$sub_total+$sales_header['ntaxtotal'];				
				$html.=$total.'</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr style="border-top:1px solid #999;border-bottom:1px solid #999;">
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;">';
			  
			  foreach($sales_tender as $tender)
			  {
				  if($tender['itenerid']!="121")
				  {
					  $html.='<tr>
						<td width="70%" align="right"><strong>'.$tender['vtendername'].'</strong></td>
						<td width="10%" align="right">&nbsp;</td>
						<td width="20%" align="right">'.$tender['namount'].'</td>
					  </tr>';
				  }
			  } 
			 
			  $html.='</table></td>
		  </tr>
		  <tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr style="border-top:1px solid #999;border-bottom:1px solid #999;">
				<td width="70%" align="right" style="padding-top:5px;padding-bottom:5px;"><strong>Tendered</strong></td>
				<td width="10%" align="right" style="padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td width="20%" align="right" style="padding-top:5px;padding-bottom:5px;">'.$total.'</td>
			  </tr>
			  <tr style="border-bottom:1px solid #999;">
				<td width="70%" align="right" style="padding-top:5px;padding-bottom:5px;"><strong>Your Change</strong></td>
				<td width="10%" align="right" style="padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td width="20%" align="right" style="padding-top:5px;padding-bottom:5px;">'.$sales_header['nchange'].'</td>
			  </tr>
			</table></td>
		  </tr>		  
		  <tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;display:none;">
			  <tr>
				<td width="49%" align="left"><strong>Cashier ID : </strong>'.$sales_header['iuserid'].'</td>
				<td width="8%">&nbsp;</td>
				<td width="43%" align="right"><strong>Register : </strong>'.$sales_header['vterminalid'].'</td>
			  </tr>
			  <tr>
				<td align="left"><strong>Tender Type : </strong>'.$sales_header['vtendertype'].'</td>
				<td>&nbsp;</td>
				<td align="left">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left"><strong>TRN : </strong>'.$sales_header['isalesid'].'</td>
				<td>&nbsp;</td>
				<td align="left">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left"><strong>TRN Time : </strong>'.$sales_header['trandate'].'</td>
				<td>&nbsp;</td>
				<td align="left">&nbsp;</td>
			  </tr>
			</table></td>
		  </tr>
		  ';
		  if(strlen($sales_header['licnumber']) >0)
		  {
			  $html.='
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;">
					  <tr style="border-top:1px solid #999;border-bottom:1px solid #999;line-height:30px;">					  
						<td align="center"><strong>Customer Licence Detail</strong></td>
					  </tr>
					  <tr>
						<td><strong>Name :</strong> '.$sales_header['liccustomername'].'</td>
					  </tr>
					  <tr>
						<td><strong>Birth Date : </strong>'.$sales_header['liccustomerbirthdate'].'</td>
					  </tr>
					  <tr>
						<td><strong>Address : </strong>'.$sales_header['licaddress'].'</td>
					  </tr>
					  <tr>
						<td><strong>Licence # : </strong>'.$sales_header['licnumber'].'</td>
					  </tr>
					  <tr>
						<td><strong>Licence Expiry Date : </strong>'.$sales_header['licexpireddate'].'</td>
					  </tr>
					</table></td>
			  </tr>';
		  }
		  $html.='
		</table>';
		
		$file='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><div id="content">
  <div class="container-fluid">
    <div class="" style="margin-top:0%;">
      <div class="panel-body"> 
        <div class="row">
          <div class="col-md-12" id="printappend">'.$html.'          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';

	$myfile = fopen( DIR_TEMPLATE."/administration/print_sales_report.tpl", "w");
	fwrite($myfile,$file);
	fclose($myfile);

	$return['code'] = 1;
    $return['data'] = $html;
   
    echo json_encode($return);
    exit;
  }

  public function pdf_save_page() {

  	ini_set('max_execution_time', 0);
    ini_set("memory_limit", "2G");

    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Sales Report';

    $html = $this->load->view('administration/print_monthly_sales_page', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    // $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('Sales-Report.pdf');
  }
	  
	protected function getList() {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

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
			$sort = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = '';
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

		if($order == 'ASC'){
			$data['sort_tender'] = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'] . $url . '&order=DESC&sort=vtendertype', true);
		}else if($order == 'DESC'){
			$data['sort_tender'] = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'] . $url . '&order=ASC&sort=vtendertype', true);
		}else{
			$data['sort_tender'] = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'] . $url . '&order=ASC&sort=vtendertype', true);
		}


		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		// if (isset($this->request->get['page'])) {
		// 	$url .= '&page=' . $this->request->get['page'];
		// }

		//if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			$filter_data = array(
				'start_date'  => $data['start_date'],
				'end_date'  => $data['end_date'],
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
			);

			//$report_datas = $this->model_api_sales_report->getSalesReport($this->request->post);
			$sales_total = $this->model_api_sales_report->getSalesReportTotal($filter_data);

			
			$report_datas = $this->model_api_sales_report->getSalesReport($filter_data);
			
			$data['reports'] = $report_datas;	
			
			$this->session->data['reports'] = $data['reports'];
			$this->session->data['p_start_date'] = $data['start_date'];
			$this->session->data['p_end_date'] = $data['end_date'];
			
			$pagination = new Pagination();
			$pagination->total = $sales_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_limit_admin');
			$pagination->url = $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($sales_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sales_total - $this->config->get('config_limit_admin'))) ? $sales_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sales_total, ceil($sales_total / $this->config->get('config_limit_admin')));
			
			$data['sort'] = $sort;
			$data['order'] = $order;
		
		//}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/sales_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['reportdata'] = $this->url->link('administration/sales_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
		$data['print_page'] = $this->url->link('administration/sales_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
		$data['pdf_save_page'] = $this->url->link('administration/sales_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		
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
		
		$data['storename'] = $this->session->data['storename'];
        $data['storeaddress'] = $this->session->data['storeaddress'];
        $data['storephone'] = $this->session->data['storephone'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/sales_report_list', $data));
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
	
	public function printpage(){
		$this->response->setOutput($this->load->view('administration/print_sales_report'));	
	}
}
