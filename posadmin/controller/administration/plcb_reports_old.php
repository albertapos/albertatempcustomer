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
    $data['schedule_a'] = $this->session->data['schedule_a'];
    $data['main_bucket_arr_end'] = $this->session->data['main_bucket_arr_end'];
    $data['main_bucket_arr_malt'] = $this->session->data['main_bucket_arr_malt'];

    $data['store_name'] = $this->session->data['storename'];

    $data['heading_title'] = 'PLCB Report';
    $this->response->setOutput($this->load->view('administration/plcb_print_page_list', $data));
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
           $newtemp['unit_id'] = $mst_plcb_item_detail['unit_id'];
           $newtemp['unit_value'] = (int)$mst_plcb_item_detail['unit_value'];
           $newtemp['tot_qty'] = $mst_plcb_item_detail['prev_mo_purchase'] * (int)$mst_plcb_item_detail['unit_value'];
           $newarr[] = $newtemp;
        }

        $newsupp_arr = array();
        foreach ($newarr as $key => $value) {
            if(array_key_exists($value['supplier_id'], $newsupp_arr)){
                $newtemparr = $newsupp_arr[$value['supplier_id']];
                if(array_key_exists($value['bucket_id'], $newtemparr)){
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] = $newsupp_arr[$value['supplier_id']][$value['bucket_id']]['tot_qty'] + $value['tot_qty'];
                }else{
                    $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
                }
            }else{
                $newsupp_arr[$value['supplier_id']][$value['bucket_id']] = array(
                                                        'supplier_id' => $value['supplier_id'],
                                                        'supplier_name' => $value['supplier_name'],
                                                        'bucket_id' => $value['bucket_id'],
                                                        'bucket_name' => $value['bucket_name'],
                                                        'tot_qty' => $value['tot_qty']
                                                        );
            }
        }

        $main_supplier_arr = array();
        foreach ($newsupp_arr as $value) {
            $temp_arr = array();
            foreach ($value as  $v) {
                $temp_arr[] = $v;
            }
           $main_supplier_arr[] =  $temp_arr;
        }

        foreach($buckets as $bucket){
          ${'bucket_id_total'.$bucket['id']} = 0 ;
        }

        if(count($main_supplier_arr) > 0){
            foreach($main_supplier_arr as $k => $main_supplier_array){
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

        $schedule_a = array();
        foreach($buckets as $bucket){
            $schedule_a[$bucket['id']] = ${'bucket_id_total'.$bucket['id']};
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

        $data['main_bucket_arr'] = $main_bucket_arr;
        $data['main_supplier_arr'] = $main_supplier_arr;
        $data['buckets'] = $buckets;
        $data['schedule_a'] = $schedule_a;
        $data['main_bucket_arr_end'] = $main_bucket_arr_end;
        $data['main_bucket_arr_malt'] = $main_bucket_arr_malt;

        $this->session->data['main_bucket_arr'] = $data['main_bucket_arr'];
        $this->session->data['main_supplier_arr'] = $data['main_supplier_arr'];
        $this->session->data['buckets'] = $data['buckets'];
        $this->session->data['schedule_a'] = $data['schedule_a'];
        $this->session->data['main_bucket_arr_end'] = $data['main_bucket_arr_end'];
        $this->session->data['main_bucket_arr_malt'] = $data['main_bucket_arr_malt'];

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
