<?php
class ModelAdministrationPoHistoryReport extends Model {

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

	public function getViewItems($vendor_id,$vendor_date) {
		
		$vendor_date = DateTime::createFromFormat('m-d-Y', $vendor_date);

		$vendor_date = $vendor_date->format('Y-m-d');
		
		// $sql = "SELECT po.vvendorid as vvendorid, po.vvendorname as vvendorname, pod.vitemid as vitemid, pod.vitemname as vitemname, ifnull(SUM(pod.nordextprice),0) as nordextprice FROM trn_purchaseorder as po, trn_purchaseorderdetail as pod WHERE po.estatus='Close' AND po.ipoid=pod.ipoid AND date_format(po.dcreatedate,'%Y-%m-%d %h:%i:%s') >= '".$vendor_date." 00:00:00' AND date_format(po.dcreatedate,'%Y-%m-%d %h:%i:%s') <= '".$vendor_date." 23:59:59' AND po.vvendorid='".$vendor_id."' GROUP BY pod.vitemid ";

		$sql = "SELECT pod.vbarcode,pod.vitemname as vitemname,pod.vsize,ifnull(pod.nordqty,0) as nordqty,ifnull(pod.npackqty,0) as npackqty,ifnull(pod.itotalunit,0) as itotalunit,ifnull(pod.nunitcost,0) as nunitcost,pod.nripamount as nripamount,po.vvendorid as vvendorid, po.vvendorname as vvendorname, pod.vitemid as vitemid, ifnull(SUM(pod.nordextprice),0) as nordextprice FROM trn_purchaseorder as po, trn_purchaseorderdetail as pod WHERE po.estatus='Close' AND po.ipoid=pod.ipoid AND date_format(po.dcreatedate,'%Y-%m-%d %h:%i:%s') >= '".$vendor_date." 00:00:00' AND date_format(po.dcreatedate,'%Y-%m-%d %h:%i:%s') <= '".$vendor_date." 23:59:59' AND po.vvendorid='".$vendor_id."' GROUP BY pod.vitemid ";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getPoHistoryReportAll($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$sql = "SELECT po.vvendorid as vvendorid, date_format(po.dcreatedate,'%m-%d-%Y') as dcreatedate, po.vvendorname as vvendorname, ifnull(SUM(po.nnettotal),0) as nnettotal FROM trn_purchaseorder as po WHERE estatus='Close' AND date_format(po.dcreatedate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(po.dcreatedate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY po.dcreatedate ";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getPoHistoryReport($data) {
		
		$vvendorids = implode(',', $data['report_by']);

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$sql = "SELECT po.vvendorid as vvendorid, date_format(po.dcreatedate,'%m-%d-%Y') as dcreatedate, po.vvendorname as vvendorname, ifnull(SUM(po.nnettotal),0) as nnettotal FROM trn_purchaseorder as po WHERE estatus='Close' AND po.vvendorid in($vvendorids) AND date_format(po.dcreatedate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(po.dcreatedate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY po.dcreatedate ";

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
