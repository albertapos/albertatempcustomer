<?php
class ModelApiPlcbReports extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getBuckets() {
		$sql = "SELECT * FROM mst_item_bucket WHERE id < 13";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMstPlcbItems() {
		$sql = "SELECT * FROM mst_plcb_item mpi LEFT JOIN mst_item_size mis ON mpi.item_id=mis.item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id WHERE mpi.bucket_id < 13";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMstPlcbItemDetails() {
		$sql = "SELECT * FROM mst_plcb_item_detail mpid LEFT JOIN mst_plcb_item mpi ON mpi.item_id=mpid.plcb_item_id LEFT JOIN mst_item_size mis ON mis.item_id=mpid.plcb_item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id LEFT JOIN mst_supplier ms ON ms.isupplierid=mpid.supplier_id WHERE mpi.bucket_id < 13 AND NOT(ms.plcbtype = 'None' OR ms.plcbtype = '')";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMstPlcbItemDetailsScheduleC($month=0) {

        if($month != 0){
            // $start_date_string = "first day of ". $month ." month";
            // $start_date = date('Y-m-d', strtotime($start_date_string));
            //die($start_date);
            
            // $end_date_string = "last day of ". $month ." month";
            // $end_date = date('Y-m-d', strtotime($end_date_string));
            
            $start_date_string = "first day of ". $data['selected_month'] ." ".date('Y', strtotime('now'));
            $start_date = date('Y-m-d', strtotime($start_date_string));
            
            $end_date_string = "last day of ". $data['selected_month'] ." ".date('Y', strtotime('now'));
            $end_date = date('Y-m-d', strtotime($end_date_string));
            
            
            
            
            
            
            
		  //  $end_date = date('Y-m-d', strtotime('last day of last month'));
        } else {
            $start_date = date('Y-m-d', strtotime('first day of last month'));
		    $end_date = date('Y-m-d', strtotime('last day of last month')); 
        }
		
		
		$data = "Start Date: ".$start_date." End Date: ".$end_date;
            
            $file_path = DIR_TEMPLATE."/administration/error_log_import_item.txt";

            $myfile = fopen( DIR_TEMPLATE."/administration/error_log_import_item.txt", "a");
            
            $content .= json_encode($data)."\r\n";
            
            fwrite($myfile,$content);
            fclose($myfile);
		
		
		
		//$start_date = '2017-04-01';
		//$end_date = '2017-04-30';
		$plcb_items = $this->db2->query("SELECT * FROM mst_plcb_item_detail")->rows;
		
		$main_items = array();
		if(count($plcb_items) > 0){
			foreach ($plcb_items as $key => $plcb_item) {
				$total_plcb_items = $this->db2->query("SELECT mpid.plcb_item_id as plcb_item_id,mpid.supplier_id as supplier_id,mpid.prev_mo_purchase as prev_mo_purchase,mis.unit_id as unit_id,mis.unit_value as unit_value,mib.id as bucket_id,mib.bucket_name as bucket_name,ms.vcompanyname as vcompanyname,ms.vaddress1 as vaddress1,ms.vcity as vcity,ms.vstate as vstate,ms.vzip as vzip,ms.plcbtype as plcbtype ,trp.vinvoiceno as vinvoiceno, date_format(trp.dreceiveddate,'%m/%d/%Y') as dreceiveddate FROM trn_purchaseorderdetail trpd LEFT JOIN trn_purchaseorder trp ON trpd.ipoid=trp.ipoid LEFT JOIN mst_plcb_item_detail mpid ON mpid.plcb_item_id=trpd.vitemid LEFT JOIN mst_plcb_item mpi ON mpi.item_id=mpid.plcb_item_id LEFT JOIN mst_item_size mis ON mis.item_id=mpi.item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id LEFT JOIN mst_supplier ms ON ms.isupplierid=mpid.supplier_id WHERE trpd.vitemid='". (int)$plcb_item['plcb_item_id'] ."' AND trp.vvendorid='". (int)$plcb_item['supplier_id'] ."' AND trp.estatus='Close' AND date_format(trpd.LastUpdate,'%Y-%m-%d') >= '".$start_date."' AND date_format(trpd.LastUpdate,'%Y-%m-%d') <= '".$start_date."' AND mpi.bucket_id < 13")->rows;
				//   $total_plcb_items = $this->db2->query("SELECT mpid.plcb_item_id as plcb_item_id, mpid.supplier_id as supplier_id,mpid.prev_mo_purchase prev_mo_purchase,mis.unit_id as unit_id,mis.unit_value as unit_value, mib.id as bucket_id,mib.bucket_name as bucket_name, ms.vcompanyname as vcompanyname,ms.vaddress1 as vaddress1,ms.vcity as vcity,ms.vstate as vstate,ms.vzip as vzip,ms.plcbtype as plcbtype ,trp.vinvoiceno as vinvoiceno,date_format(trp.dreceiveddate,'%m/%d/%Y')as dreceiveddateFROM trn_purchaseorderdetail trpd LEFT JOIN trn_purchaseorder trp ON trpd.ipoid=trp.ipoid LEFT JOIN mst_plcb_item_detail mpid ON mpid.plcb_item_id=trpd.vitemid LEFT JOIN mst_plcb_item mpi ON mpi.item_id=mpid.plcb_item_id LEFT JOIN mst_item_size mis ON mis.item_id=mpi.item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id LEFT JOIN mst_supplier ms ON ms.isupplierid=mpid.supplier_id WHERE trp.estatus='Close' AND   date_format(trpd.LastUpdate,'%Y-%m-%d') >= '".$start_date."'  AND date_format(trpd.LastUpdate,'%Y-%m-%d') <= '".$start_date."' AND mpi.bucket_id < 13")->rows;
//  --   trpd.vitemid='1'

// --    AND trp.vvendorid='1'

  
				if(count($total_plcb_items) > 0){
					foreach ($total_plcb_items as $value) {
						$main_items[] = $value;
					}
				}	
			}
		}
		return $main_items;
	}
	
}
