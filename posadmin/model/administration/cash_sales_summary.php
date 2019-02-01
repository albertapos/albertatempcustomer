<?php
class ModelAdministrationCashSalesSummary extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCategories() {
		$sql = "SELECT vcategorycode as id, vcategoryname as name FROM mst_category";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getGroups() {
		$sql = "SELECT iitemgroupid as id, vitemgroupname as name FROM itemgroup";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getCategoriesReport($data) {
		$vcatcodes = implode(',', $data['report_data']);

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		if(in_array('ALL', $data['report_data'])){
			$sql = "SELECT trn_sd.vcatname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_s.isalesid=trn_sd.isalesid GROUP BY trn_sd.vcatname";
		}else{
			$sql = "SELECT trn_sd.vcatname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_sd.vcatcode in($vcatcodes) AND trn_s.isalesid=trn_sd.isalesid GROUP BY trn_sd.vcatname";
		}
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartmentsReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$vdepcodes = implode(',', $data['report_data']);

		if(in_array('ALL', $data['report_data'])){
			$sql = "SELECT trn_sd.vdepname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction'  AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_s.isalesid=trn_sd.isalesid GROUP BY trn_sd.vdepname";
		}else{
			$sql = "SELECT trn_sd.vdepname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction'  AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_sd.vdepcode in($vdepcodes) AND trn_s.isalesid=trn_sd.isalesid GROUP BY trn_sd.vdepname";
		}
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getGroupsReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$vgroups = implode(',', $data['report_data']);

		if(in_array('ALL', $data['report_data'])){
			$sql = "SELECT itmg.vitemgroupname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";
		}else{
			$sql = "SELECT itmg.vitemgroupname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND itmg.iitemgroupid in($vgroups) AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";
		}
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

}
