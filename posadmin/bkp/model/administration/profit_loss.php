<?php
class ModelAdministrationProfitLoss extends Model {

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

		if(in_array('ALL', $data['report_data'])){
			$vcatcodes = 'ALL';
		}else{
			$vcatcodes = implode(',', $data['report_data']);
		}

		$query = $this->db2->query("CALL rp_profitloss('" . $data['start_date'] . "','".$data['end_date']."','Category','".$vcatcodes."')");

		return $query->rows;
	}

	public function getDepartmentsReport($data) {
		
		if(in_array('ALL', $data['report_data'])){
			$vdepcodes = 'ALL';
		}else{
			$vdepcodes = implode(',', $data['report_data']);
		}

		$query = $this->db2->query("CALL rp_profitloss('" . $data['start_date'] . "','".$data['end_date']."','Department','".$vdepcodes."')");

		return $query->rows;
	}

	public function getGroupsReport($data) {

		$vgroups = implode(',', $data['report_data']);
		
		$sql = "SELECT itmg.vitemgroupname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND trn_s.dtrandate >= '".$data['start_date']."' AND trn_s.dtrandate <= '".$data['end_date']."' AND itmg.iitemgroupid in($vgroups) AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

}
