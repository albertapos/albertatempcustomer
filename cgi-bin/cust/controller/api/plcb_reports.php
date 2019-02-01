<?php
class ControllerApiPlcbReports extends Controller {
	private $error = array();

	public function index() {

		$this->load->model('api/plcb_reports');

		if (($this->session->data['token'] == $this->request->get['token']) && ($this->session->data['sid'] == $this->request->get['sid'])) {

        $buckets = $this->model_api_plcb_reports->getBuckets();

        $mst_plcb_items = $this->model_api_plcb_reports->getMstPlcbItems();

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

        $mst_plcb_item_details = $this->model_api_plcb_reports->getMstPlcbItemDetails();

        $newarr = array();
        foreach ($mst_plcb_item_details as $mst_plcb_item_detail) {
           $newtemp = array();
           $newtemp['id'] = $mst_plcb_item_detail['id'];
           $newtemp['item_id'] = $mst_plcb_item_detail['plcb_item_id'];
           $newtemp['bucket_id'] = $mst_plcb_item_detail['bucket_id'];
           $newtemp['bucket_name'] = $mst_plcb_item_detail['bucket_name'];
           $newtemp['supplier_id'] = $mst_plcb_item_detail['supplier_id'];
           $newtemp['supplier_name'] = $mst_plcb_item_detail['vcompanyname'];
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

        $data['main_bucket_arr'] = $main_bucket_arr;
        $data['main_supplier_arr'] = $main_supplier_arr;
        $data['buckets'] = $buckets;
        // $data['schedule_a'] = array();
        $data['schedules'] = $schedules;
        $data['main_bucket_arr_end'] = $main_bucket_arr_end;
        $data['main_bucket_arr_malt'] = $main_bucket_arr_malt;
        
        http_response_code(200);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));

    }else{
        $data['error'] = 'Something went wrong missing token or sid';
        http_response_code(401);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
    }
	}
	
}
