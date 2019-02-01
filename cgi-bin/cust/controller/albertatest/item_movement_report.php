<?php
class ControllerAlbertatestItemMovementReport extends Controller {
	private $error = array();

	public function index() {
    $this->load->language('albertatest/item_movement_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('albertatest/item_movement_report');

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

    $this->response->setOutput($this->load->view('albertatest/print_item_movement_report_page', $data));
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

    $html = $this->load->view('albertatest/print_item_movement_report_page', $data);
    
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
      
      $data['reports'] = $this->model_albertatest_item_movement_report->getItemMovementReport($this->request->post);

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
			'href' => $this->url->link('albertatest/item_movement_report', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['reportdata'] = $this->url->link('albertatest/item_movement_report/reportdata', 'token=' . $this->session->data['token'] . $url, true);
    $data['item_movement_data'] = $this->url->link('albertatest/item_movement_report/item_movement_data', 'token=' . $this->session->data['token'] . $url, true);
    $data['print_page'] = $this->url->link('albertatest/item_movement_report/print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('albertatest/item_movement_report/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['csv_export'] = $this->url->link('albertatest/item_movement_report/csv_export', 'token=' . $this->session->data['token'] . $url, true);
    $data['searchitem'] = $this->url->link('albertatest/item_movement_report/searchitem', 'token=' . $this->session->data['token'] . $url, true);
    $data['item_movement_print_data'] = $this->url->link('albertatest/item_movement_report/item_movement_print_data', 'token=' . $this->session->data['token'], true);
    $data['printpage'] = $this->url->link('albertatest/item_movement_report/printpage', 'token=' . $this->session->data['token'], true);
		
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
		
		$this->response->setOutput($this->load->view('albertatest/item_movement_report_list', $data));
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
    $this->load->model('albertatest/item_movement_report');
    if(isset($this->request->get['term']) && !empty($this->request->get['term'])){

      $datas = $this->model_albertatest_item_movement_report->getItemsSearchResult($this->request->get['term']);

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
    $this->load->model('albertatest/item_movement_report');
    if((isset($this->request->get['vbarcode']) && !empty($this->request->get['vbarcode'])) && (isset($this->request->get['start_date']) && !empty($this->request->get['start_date'])) && (isset($this->request->get['end_date']) && !empty($this->request->get['end_date'])) && (isset($this->request->get['data_by']) && !empty($this->request->get['data_by']))){

      $return = $this->model_albertatest_item_movement_report->getItemMovementData($this->request->get['vbarcode'],$this->request->get['start_date'],$this->request->get['end_date'],$this->request->get['data_by']);
      
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($return));
    
  }

  public function item_movement_print_data() {
  
  $data['heading_title'] = 'Item Movement';
    
    $isalesid = ($this->request->get['isalesid'])?$this->request->get['isalesid']:'0';
    $idettrnid = ($this->request->get['idettrnid'])?$this->request->get['idettrnid']:'0';
  
  $this->load->language('albertatest/item_movement_report');
  
  $this->document->setTitle($this->language->get('heading_title'));
  
  $this->load->model('albertatest/item_movement_report');
  $this->load->model('api/store');

  $store_info= $this->model_api_store->getStore();

  $sales_header= $this->model_albertatest_item_movement_report->getSalesById($isalesid);
  
  $trn_date = DateTime::createFromFormat('m-d-Y h:i A', $sales_header['trandate']);
  $trn_date = $trn_date->format('m-d-Y');

  $sales_detail= $this->model_albertatest_item_movement_report->getSalesPerview($idettrnid);

  $sales_customer= $this->model_albertatest_item_movement_report->getSalesByCustomer($sales_header['icustomerid']);

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
              <h3>Sales Transaction Receipt</h3>
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
          <td width="50%" align="left"><strong>'.$store_info['vstorename'].'</strong></td>
          <td width="25%" align="right"><strong>Status</strong></td>
          <td>&nbsp;&nbsp;'.$sales_header['estatus'].'</td>
          </tr>
          <tr style="line-height:25px;">
          <td width="50%" align="left"><strong>'.$store_info['vaddress1'].'</strong></td>
          <td width="25%" align="right"><strong>Ordered</strong></td>
          <td>&nbsp;&nbsp;'.$trn_date.'</td>
          </tr>
          <tr style="line-height:25px;">
          <td width="50%" align="left"><strong>'.$store_info['vcity']." ".$store_info['vstate']." ".$store_info['vzip'].'</strong></td>
          <td width="25%" align="right"><strong>Invoiced</strong></td>
          <td>&nbsp;&nbsp;'.$trn_date.'</td>
          </tr>
          <tr style="line-height:25px;">
          <td width="50%" align="left"><strong>'.$store_info['vphone1'].'</strong></td>
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

      $sub_total = $sales_detail['nextunitprice'];
      $noofitems = $sales_detail['ndebitqty'];
      $html.='
        
        <tr>
          <td>'.$sales_detail['ndebitqty'].'</td>
          <td>'.$sales_detail['npack'].'</td>
          <td>'.$sales_detail['vitemcode'].'</td>
          <td>'.$sales_detail['vitemname'].'</td>
          <td>'.$sales_detail['vsize'].'</td>
          <td>'.$sales_detail['nunitprice'].'</td>
          <td>'.$sales_detail['nextunitprice'].'</td>
        </tr>';
      
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
        <td width="70%" align="right" style="padding-bottom:5px;"><strong>Total</strong></td>
        <td width="10%" style="padding-bottom:5px;">&nbsp;</td>
        <td width="20%" align="right" style="padding-top:5px;padding-bottom:5px;">';
        $total=$sub_total;       
        $html.=$total.'</td>
        </tr>
      </table></td>
      </tr>
      
      
      </table></td>
      </tr>';
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

  $myfile = fopen( DIR_TEMPLATE."/albertatest/print_item_movement_report.tpl", "w");
  fwrite($myfile,$file);
  fclose($myfile);

  $return['code'] = 1;
    $return['data'] = $html;
   
    echo json_encode($return);
    exit;
  }

  public function printpage(){
    $this->response->setOutput($this->load->view('albertatest/print_item_movement_report')); 
  }
	
}
