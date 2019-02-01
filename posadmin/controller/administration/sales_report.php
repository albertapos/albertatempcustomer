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

    $sales_detail= $this->model_api_sales_report->getSalesPerview($salesid);
    
    $sales_tender= $this->model_api_sales_report->getSalesByTender($salesid);
    
    $html='';
    
    $html='<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="border-bottom:1px solid #999;">
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
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
            </table></td>
          </tr>      
          <tr style="border-bottom:1px solid #999;">
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin:5px 0px;">';
        if(count($sales_detail)>0)
        {
            $sub_total=0;
            $tax=0;
            $total=0;
            $noofitems =0;
            
            foreach($sales_detail as $sales)
            {
                $sub_total+=$sales['nextunitprice'];
                $noofitems+=$sales['ndebitqty'];
                $html.='
                    <tr>
                        <td width="75%" align="left">'.$sales['ndebitqty']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sales['vitemname'].'<br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                          
                            if($sales['vunitcode']=="UNT002")
                            {
                                $html.=$sales['ndebitqty'].' lb @ '.$sales['ndebitamt'];
                            }
                            
                            if((strlen($sales['npack']) >0 && $sales['npack']!=1) || $sales['vitemtype']=="Lot Matrix")
                            {
                                $html.='&nbsp;Pack : ' .$sales['npack'];
                            }
                            
                            if(strlen($sales['vsize']) > 0)
                            {
                                $html.='&nbsp;&nbsp;&nbsp;Size : '.$sales['vsize'];
                            }
                          $html.='</td>
                        <td width="25%" align="right">'.$sales['nextunitprice'].'</td>
                      </tr>';
            }
            /*$html.='<tr>
                <td align="left"><strong>No of Items '.$noofitems.'</strong></td>
                <td align="right">&nbsp;</td>
              </tr>';*/
        }
      $html.='</table></td>
          </tr>
          <tr style="border-bottom:1px solid #999;">
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;">
              <tr>
                <td width="52%" align="right"><strong>Sub Total</strong></td>
                <td width="23%">&nbsp;</td>
                <td width="25%" align="right">'.$sub_total.'</td>
              </tr>
              <tr>
                <td align="right"><strong>Tax</strong></td>
                <td>&nbsp;</td>
                <td align="right">'.$sales_header['ntaxtotal'].'</td>
              </tr>
              <tr>
                <td align="right"><strong>Total</strong></td>
                <td>&nbsp;</td>
                <td align="right">';
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
                        <td width="52%" align="right"><strong>'.$tender['vtendername'].'</strong></td>
                        <td width="23%" align="right">&nbsp;</td>
                        <td width="25%" align="right">'.$tender['namount'].'</td>
                      </tr>';
                  }
              } 
             
              $html.='</table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="52%" align="right"><strong>Tendered</strong></td>
                <td width="23%" align="right">&nbsp;</td>
                <td width="25%" align="right">'.$total.'</td>
              </tr>
              <tr>
                <td width="52%" align="right"><strong>Your Change</strong></td>
                <td width="23%" align="right">&nbsp;</td>
                <td width="25%" align="right">'.$sales_header['nchange'].'</td>
              </tr>
            </table></td>
          </tr>       
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:5px 0px;">
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
    $data['reports'] = $this->session->data['reports'];
    $data['p_start_date'] = $this->session->data['p_start_date'];
    $data['p_end_date'] = $this->session->data['p_end_date'];

    $data['storename'] = $this->session->data['storename'];

    $data['heading_title'] = 'Sales Report';

    $html = $this->load->view('administration/print_sales_report', $data);
    
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
            $sort = 'dtrandate';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
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
