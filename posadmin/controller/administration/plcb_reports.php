<?php
class ControllerAdministrationPlcbReports extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('administration/plcb_reports');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('administration/plcb_reports');

		$this->getList();
	}

  public function plcb_print_page() {

    $data['main_bucket_arr'] = $this->session->data['main_bucket_arr'];
    $data['main_supplier_arr'] = $this->session->data['main_supplier_arr'];
    $data['buckets'] = $this->session->data['buckets'];
    $data['schedules'] = $this->session->data['schedules'];
    $data['main_bucket_arr_end'] = $this->session->data['main_bucket_arr_end'];
    $data['main_bucket_arr_malt'] = $this->session->data['main_bucket_arr_malt'];
    $data['new_sup_c_invc_arr_main'] = $this->session->data['new_sup_c_invc_arr_main'];

    $data['store_name'] = $this->session->data['storename'];
    $this->load->model('administration/plcb_reports');
    $data['store_data'] = $this->model_administration_plcb_reports->getStoreData();

    $data['heading_title'] = 'PLCB Report';
    $this->response->setOutput($this->load->view('administration/plcb_print_page_list', $data));
  }

  public function pdf_save_page() {

    $data['main_bucket_arr'] = $this->session->data['main_bucket_arr'];
    $data['main_supplier_arr'] = $this->session->data['main_supplier_arr'];
    $data['buckets'] = $this->session->data['buckets'];
    $data['schedules'] = $this->session->data['schedules'];
    $data['main_bucket_arr_end'] = $this->session->data['main_bucket_arr_end'];
    $data['main_bucket_arr_malt'] = $this->session->data['main_bucket_arr_malt'];
    $data['new_sup_c_invc_arr_main'] = $this->session->data['new_sup_c_invc_arr_main'];

    $data['store_name'] = $this->session->data['storename'];
    $this->load->model('administration/plcb_reports');
    $data['store_data'] = $this->model_administration_plcb_reports->getStoreData();

    $data['heading_title'] = 'PLCB Report';

    $html = $this->load->view('administration/plcb_print_page_list', $data);
    
    $this->dompdf->loadHtml($html);

    //(Optional) Setup the paper size and orientation
    $this->dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $this->dompdf->render();

    // Output the generated PDF to Browser
    $this->dompdf->stream('PLCB-Report.pdf');
  }
	  
	protected function getList() {

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('administration/plcb_reports', 'token=' . $this->session->data['token'] . $url, true)
		);

    $data['plcb_print_page'] = $this->url->link('administration/plcb_reports/plcb_print_page', 'token=' . $this->session->data['token'] . $url, true);
    $data['pdf_save_page'] = $this->url->link('administration/plcb_reports/pdf_save_page', 'token=' . $this->session->data['token'] . $url, true);
		
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

		$buckets = $this->model_administration_plcb_reports->getBuckets();

		$mst_plcb_items = $this->model_administration_plcb_reports->getMstPlcbItems();

		$arr = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr[] = $temp;
        }

        $bucket_arr = array();
        foreach ($arr as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr)){
                $bucket_arr[$value['bucket_id']]['tot_qty'] = $bucket_arr[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }

        $main_bucket_arr = array();
        foreach ($bucket_arr as $key => $bucket_array) {
            $main_bucket_arr[] = $bucket_array;
        }

        $mst_plcb_item_details = $this->model_administration_plcb_reports->getMstPlcbItemDetails();

        $newarr = array();
        foreach ($mst_plcb_item_details as $mst_plcb_item_detail) {
           $newtemp = array();
           $newtemp['id'] = $mst_plcb_item_detail['id'];
           $newtemp['item_id'] = $mst_plcb_item_detail['plcb_item_id'];
           $newtemp['bucket_id'] = $mst_plcb_item_detail['bucket_id'];
           $newtemp['bucket_name'] = $mst_plcb_item_detail['bucket_name'];
           $newtemp['supplier_id'] = $mst_plcb_item_detail['supplier_id'];
           $newtemp['supplier_name'] = $mst_plcb_item_detail['vcompanyname'];
           $newtemp['supplier_vaddress1'] = $mst_plcb_item_detail['vaddress1'];
           $newtemp['supplier_vcity'] = $mst_plcb_item_detail['vcity'];
           $newtemp['supplier_vstate'] = $mst_plcb_item_detail['vstate'];
           $newtemp['supplier_vzip'] = $mst_plcb_item_detail['vzip'];
           $newtemp['plcbtype'] = $mst_plcb_item_detail['plcbtype'];
           $newtemp['unit_id'] = $mst_plcb_item_detail['unit_id'];
           $newtemp['unit_value'] = (int)$mst_plcb_item_detail['unit_value'];
           $newtemp['tot_qty'] = $mst_plcb_item_detail['prev_mo_purchase'] * (int)$mst_plcb_item_detail['unit_value'];
           $newarr[] = $newtemp;
        }

        $newsupp_arr = array();
        foreach ($newarr as $key => $value) {
          if(array_key_exists($value['plcbtype'], $newsupp_arr)){
            if(array_key_exists($value['supplier_id'], $newsupp_arr[$value['plcbtype']])){
              if(array_key_exists($value['bucket_id'], $newsupp_arr[$value['plcbtype']][$value['supplier_id']])){
                    $newsupp_arr[$value['plcbtype']][$value['supplier_id']][$value['bucket_id']]['tot_qty'] = $newsupp_arr[$value['plcbtype']][$value['supplier_id']][$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
                }else{
                    $newsupp_arr[$value['plcbtype']][$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'supplier_vaddress1' => $value['supplier_vaddress1'],
                                                        'supplier_vcity' => $value['supplier_vcity'],
                                                        'supplier_vstate' => $value['supplier_vstate'],
                                                        'supplier_vzip' => $value['supplier_vzip'],
                                                        'plcbtype' => $value['plcbtype'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
                }
            }else{
              $newsupp_arr[$value['plcbtype']][$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'supplier_vaddress1' => $value['supplier_vaddress1'],
                                                        'supplier_vcity' => $value['supplier_vcity'],
                                                        'supplier_vstate' => $value['supplier_vstate'],
                                                        'supplier_vzip' => $value['supplier_vzip'],
                                                        'plcbtype' => $value['plcbtype'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
            }
          }else{
            $newsupp_arr[$value['plcbtype']][$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'supplier_vaddress1' => $value['supplier_vaddress1'],
                                                        'supplier_vcity' => $value['supplier_vcity'],
                                                        'supplier_vstate' => $value['supplier_vstate'],
                                                        'supplier_vzip' => $value['supplier_vzip'],
                                                        'plcbtype' => $value['plcbtype'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
          }
        }

        //key sort
        ksort($newsupp_arr);

        $main_supplier_arr = array();
        $main_supplier_arr = $newsupp_arr;

        $schedules =array();
        if(count($main_supplier_arr) > 0){
          foreach($main_supplier_arr as $k => $main_schedule){
            foreach($buckets as $bucket){
              ${'bucket_id_total'.$bucket['id']} = 0 ;
            }
            if(count($main_schedule) > 0){
                foreach($main_schedule as $main_supplier_array){
                    if(count($main_supplier_array) > 0){
                        foreach($buckets as $bucket){
                            foreach($main_supplier_array as $supplier_array){
                                if($bucket['id'] == $supplier_array['bucket_id']){
                                    ${'bucket_id_total'.$bucket['id']} = ${'bucket_id_total'.$bucket['id']} + $supplier_array['tot_qty'];
                                }
                            }
                        }
                    }
                }
            }

            foreach($buckets as $bucket){
                $schedules[$k][$bucket['id']] = ${'bucket_id_total'.$bucket['id']};
            }

          }
        }

        //month end qty
        $arr_end = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
           $temp = array();
           $temp['id'] = $mst_plcb_item['id'];
           $temp['item_id'] = $mst_plcb_item['item_id'];
           $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
           $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
           $temp['unit_id'] = $mst_plcb_item['unit_id'];
           $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
           $temp['tot_qty'] = $mst_plcb_item['prev_mo_end_qty'] * (int)$mst_plcb_item['unit_value'];
           $arr_end[] = $temp;
        }

        $bucket_arr_end = array();
        foreach ($arr_end as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_end)){
                $bucket_arr_end[$value['bucket_id']]['tot_qty'] = $bucket_arr_end[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_end[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }

        $main_bucket_arr_end = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket['id'], $bucket_arr_end)){
                $main_bucket_arr_end[$bucket['id']] = $bucket_arr_end[$bucket['id']]['tot_qty'];
            }else{
                $main_bucket_arr_end[$bucket['id']] = 0; 
            }
        }

        //Sales of Malt Beverage
        $arr_malt = array();
        foreach ($mst_plcb_items as $key => $mst_plcb_item) {
            if($mst_plcb_item['malt'] == 1){
                $temp = array();
                $temp['id'] = $mst_plcb_item['id'];
                $temp['item_id'] = $mst_plcb_item['item_id'];
                $temp['bucket_id'] = $mst_plcb_item['bucket_id'];
                $temp['bucket_name'] = $mst_plcb_item['bucket_name'];
                $temp['unit_id'] = $mst_plcb_item['unit_id'];
                $temp['unit_value'] = (int)$mst_plcb_item['unit_value'];
                $temp['tot_qty'] = $mst_plcb_item['prev_mo_beg_qty'] * (int)$mst_plcb_item['unit_value'];
                $arr_malt[] = $temp;
            }
        }

        $bucket_arr_malt = array();
        foreach ($arr_malt as $key => $value) {
           if(array_key_exists($value['bucket_id'], $bucket_arr_malt)){
                $bucket_arr_malt[$value['bucket_id']]['tot_qty'] = $bucket_arr_malt[$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
           }else{
                $bucket_arr_malt[$value['bucket_id']] = array(
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
           }
        }

        $main_bucket_arr_malt = array();
        foreach($buckets as $bucket){
            if(array_key_exists($bucket['id'], $bucket_arr_malt)){
                $main_bucket_arr_malt[$bucket['id']] = $bucket_arr_malt[$bucket['id']]['tot_qty'];
            }else{
                $main_bucket_arr_malt[$bucket['id']] = 0; 
            }
        }

        //schedule C array
        ini_set('memory_limit', '1G');
        $sch_c_mst_plcb_item_details = $this->model_administration_plcb_reports->getMstPlcbItemDetailsScheduleC();

        $c_temp = array();
        if(count($sch_c_mst_plcb_item_details) > 0){
          foreach ($sch_c_mst_plcb_item_details as $sch_c_mst_plcb_item_detail) {
            if($sch_c_mst_plcb_item_detail['plcbtype'] == 'Schedule C'){

              $temp_c = array();
              $temp_c['item_id'] = $sch_c_mst_plcb_item_detail['plcb_item_id'];
              $temp_c['bucket_id'] = $sch_c_mst_plcb_item_detail['bucket_id'];
              $temp_c['bucket_name'] = $sch_c_mst_plcb_item_detail['bucket_name'];
              $temp_c['supplier_id'] = $sch_c_mst_plcb_item_detail['supplier_id'];
              $temp_c['supplier_name'] = $sch_c_mst_plcb_item_detail['vcompanyname'];
              $temp_c['supplier_vaddress1'] = $sch_c_mst_plcb_item_detail['vaddress1'];
              $temp_c['supplier_vcity'] = $sch_c_mst_plcb_item_detail['vcity'];
              $temp_c['supplier_vstate'] = $sch_c_mst_plcb_item_detail['vstate'];
              $temp_c['supplier_vzip'] = $sch_c_mst_plcb_item_detail['vzip'];
              $temp_c['plcbtype'] = $sch_c_mst_plcb_item_detail['plcbtype'];
              $temp_c['vinvoiceno'] = $sch_c_mst_plcb_item_detail['vinvoiceno'];
              $temp_c['dreceiveddate'] = $sch_c_mst_plcb_item_detail['dreceiveddate'];
              $temp_c['unit_id'] = $sch_c_mst_plcb_item_detail['unit_id'];
              $temp_c['unit_value'] = (int)$sch_c_mst_plcb_item_detail['unit_value'];
              $temp_c['tot_qty'] = (int)$sch_c_mst_plcb_item_detail['unit_value'];
              $c_temp[] = $temp_c;
            }
          }
        }

        $new_supplier_c_arr = array();
        if(count($c_temp) > 0){
          foreach ($c_temp as $k => $c) {
            if(array_key_exists($c['supplier_id'], $new_supplier_c_arr)){
              $new_supplier_c_arr[$c['supplier_id']][] = array(
                                                        'supplier_id' => $c['supplier_id'],
                                                        'bucket_id' => $c['bucket_id'],
                                                        'bucket_name' => $c['bucket_name'],
                                                        'tot_qty' => $c['tot_qty'],
                                                        'vinvoiceno' => $c['vinvoiceno'],
                                                        'dreceiveddate' => $c['dreceiveddate']
                                                        );
            }else{
              $new_supplier_c_arr[$c['supplier_id']][] = array(
                                                        'supplier_id' => $c['supplier_id'],
                                                        'bucket_id' => $c['bucket_id'],
                                                        'bucket_name' => $c['bucket_name'],
                                                        'tot_qty' => $c['tot_qty'],
                                                        'vinvoiceno' => $c['vinvoiceno'],
                                                        'dreceiveddate' => $c['dreceiveddate']
                                                        );
            }
          }
        }

        $new_sup_c_invc_arr = array();
        if(count($new_supplier_c_arr) > 0){
          foreach ($new_supplier_c_arr as $k => $invc) {
            if(count($invc) > 0){
              foreach ($invc as $key => $value) {
                if(array_key_exists($value['vinvoiceno'], $new_supplier_c_arr[$k])){
                  $new_sup_c_invc_arr[$k][$value['vinvoiceno']][] = array(
                                                          'supplier_id' => $value['supplier_id'],
                                                          'bucket_id' => $value['bucket_id'],
                                                          'bucket_name' => $value['bucket_name'],
                                                          'tot_qty' => $value['tot_qty'],
                                                          'vinvoiceno' => $value['vinvoiceno'],
                                                          'dreceiveddate' => $value['dreceiveddate']
                                                          );
                }else{
                  $new_sup_c_invc_arr[$k][$value['vinvoiceno']][] = array(
                                                          'supplier_id' => $value['supplier_id'],
                                                          'bucket_id' => $value['bucket_id'],
                                                          'bucket_name' => $value['bucket_name'],
                                                          'tot_qty' => $value['tot_qty'],
                                                          'vinvoiceno' => $value['vinvoiceno'],
                                                          'dreceiveddate' => $value['dreceiveddate']
                                                          );
                }
              }
            }
          }
        }
        
        $new_sup_c_invc_arr_main =array();
        if(count($new_sup_c_invc_arr) > 0){
          foreach ($new_sup_c_invc_arr as $key => $s) {
            if(count($s) > 0){
              foreach ($s as $k => $invc_num) {

                foreach($buckets as $bucket){
                  ${'bucket_id_total_invc'.$bucket['id']} = 0 ;
                }

                if(count($invc_num) > 0){
                  foreach($buckets as $bucket){
                      foreach($invc_num as $b => $buckets_total){
                          if($bucket['id'] == $buckets_total['bucket_id']){
                              ${'bucket_id_total_invc'.$bucket['id']} = ${'bucket_id_total_invc'.$bucket['id']} + $buckets_total['tot_qty'];
                          }
                      }
                  }
                }

                foreach($buckets as $bucket){
                  $new_sup_c_invc_arr_main[$key][$k]['vinvoiceno'] = $invc_num[0]['vinvoiceno'];
                  $new_sup_c_invc_arr_main[$key][$k]['dreceiveddate'] = $invc_num[0]['dreceiveddate'];
                  $new_sup_c_invc_arr_main[$key][$k][$bucket['id']] = ${'bucket_id_total_invc'.$bucket['id']};
                }
              }
            }
          }
        }
        //schedule C array

        $data['main_bucket_arr'] = $main_bucket_arr;
        $data['main_supplier_arr'] = $main_supplier_arr;
        $data['buckets'] = $buckets;
        // $data['schedule_a'] = array();
        $data['schedules'] = $schedules;
        $data['main_bucket_arr_end'] = $main_bucket_arr_end;
        $data['main_bucket_arr_malt'] = $main_bucket_arr_malt;
        $data['new_sup_c_invc_arr_main'] = $new_sup_c_invc_arr_main;

        $this->session->data['main_bucket_arr'] = $data['main_bucket_arr'];
        $this->session->data['main_supplier_arr'] = $data['main_supplier_arr'];
        $this->session->data['buckets'] = $data['buckets'];
        $this->session->data['schedules'] = $data['schedules'];
        $this->session->data['main_bucket_arr_end'] = $data['main_bucket_arr_end'];
        $this->session->data['main_bucket_arr_malt'] = $data['main_bucket_arr_malt'];
        $this->session->data['new_sup_c_invc_arr_main'] = $data['new_sup_c_invc_arr_main'];

        $data['store_name'] = $this->session->data['storename'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('administration/plcb_reports_list', $data));
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
	
}
