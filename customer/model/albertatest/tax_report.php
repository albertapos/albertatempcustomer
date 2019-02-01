<?php
class ModelAlbertatestTaxReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTaxReport($data) {

		ini_set('max_execution_time', 0);
    	ini_set("memory_limit", "2G");

		$return = array();

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

    	$sql = "SELECT ifnull(SUM(trn_s.nnontaxabletotal),0) as nnontaxabletotal, ifnull(SUM(trn_s.ntaxabletotal),0) as ntaxabletotal FROM trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

    	$query = $this->db2->query($sql)->row;

    	$return['nnontaxabletotal'] = $query['nnontaxabletotal'];
    	$return['ntaxabletotal'] = $query['ntaxabletotal'];

    	$sql_tax1_sales = "SELECT ifnull(SUM(trn_sd.nextunitprice),0) as nextunitprice FROM trn_salesdetail trn_sd, trn_sales trn_s WHERE trn_sd.isalesid=trn_s.isalesid AND trn_sd.vtax='Y' AND trn_sd.itemtaxrateone > 0 AND trn_s.vtrntype='Transaction' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

    	$query_tax1_sales = $this->db2->query($sql_tax1_sales)->row;

    	$return['tax1_sales'] = $query_tax1_sales['nextunitprice'];

    	$sql_tax2_sales = "SELECT ifnull(SUM(trn_sd.nextunitprice),0) as nextunitprice FROM trn_salesdetail trn_sd, trn_sales trn_s WHERE trn_sd.isalesid=trn_s.isalesid AND trn_sd.vtax='Y' AND trn_sd.itemtaxratetwo > 0 AND trn_s.vtrntype='Transaction' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

    	$query_tax2_sales = $this->db2->query($sql_tax2_sales)->row;

    	$return['tax2_sales'] = $query_tax2_sales['nextunitprice'];

    	$return['net_sales'] = ($query_tax1_sales['nextunitprice'] + $query_tax2_sales['nextunitprice']);

    	$sql_tax1 = "SELECT * FROM trn_salesdetail trn_sd, trn_sales trn_s WHERE trn_sd.isalesid=trn_s.isalesid AND trn_sd.vtax='Y' AND trn_sd.itemtaxrateone > 0 AND trn_s.vtrntype='Transaction' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

    	$query_tax1 = $this->db2->query($sql_tax1)->rows;

    	$sql_tax2 = "SELECT * FROM trn_salesdetail trn_sd, trn_sales trn_s WHERE trn_sd.isalesid=trn_s.isalesid AND trn_sd.vtax='Y' AND trn_sd.itemtaxratetwo > 0 AND trn_s.vtrntype='Transaction' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

    	$query_tax2 = $this->db2->query($sql_tax2)->rows;

    	$tax1_total = 0;
    	$tax2_total = 0;

    	if(count($query_tax1) > 0 ){
    		foreach($query_tax1 as $k => $v){
    			$tax1 = ($v['nextunitprice'] * $v['itemtaxrateone']) / 100;
    			$tax1_total = $tax1_total + $tax1;
    		}
    	}

    	if(count($query_tax2) > 0 ){
    		foreach($query_tax2 as $k => $v){
    			$tax2 = ($v['nextunitprice'] * $v['itemtaxratetwo']) / 100;
    			$tax2_total = $tax2_total + $tax2;
    		}
    	}

    	$return['tax1'] = $tax1_total;
    	$return['tax2'] = $tax2_total;

		return $return;
	}
}
