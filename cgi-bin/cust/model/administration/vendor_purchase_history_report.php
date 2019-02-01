<?php
class ModelAdministrationVendorPurchaseHistoryReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getVendors() {
		$sql = "SELECT isupplierid, vsuppliercode, vcompanyname FROM mst_supplier";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getPoHistoryReportAll($data) {
		$sql = "SELECT po.vvendorid as vvendorid, po.vvendorname as vvendorname, ifnull(SUM(po.nnettotal),0) as nnettotal FROM trn_purchaseorder as po WHERE estatus='Close' AND po.dcreatedate >= '".$data['start_date']."' AND po.dcreatedate <= '".$data['end_date']."' GROUP BY po.vvendorid ";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getPoHistoryReport($data) {
		
		$vvendorids = implode(',', $data['report_by']);

		$sql = "SELECT po.vvendorid as vvendorid, po.vvendorname as vvendorname, ifnull(SUM(po.nnettotal),0) as nnettotal FROM trn_purchaseorder as po WHERE estatus='Close' AND po.vvendorid in($vvendorids) AND po.dcreatedate >= '".$data['start_date']."' AND po.dcreatedate <= '".$data['end_date']."' GROUP BY po.vvendorid ";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getGroupsReport($data) {

		$vgroups = implode(',', $data['report_data']);
		
		$sql = "SELECT itmg.vitemgroupname as name, count(trn_sd.isalesid) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND trn_s.dtrandate >= '".$data['start_date']."' AND trn_s.dtrandate <= '".$data['end_date']."' AND itmg.iitemgroupid in($vgroups) AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

}
