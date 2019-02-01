<?php
class ModelApiScanDataReport extends Model {

	public function getScanDadtaReport($data = array()){
       
		$week_ending_date = DateTime::createFromFormat('m-d-Y', $data['week_ending_date']);
		$week_ending_date = $week_ending_date->format('Y-m-d');

        $week_starting_date = date('Y-m-d', strtotime('-1 week', strtotime($week_ending_date)));

        $department_id = implode(',', $data['department_id']);
        
        $query = $this->db2->query("SELECT tsd.*, ts.*,ms.*,mi.iitemid,mi.vsuppliercode,msupplier.vcompanyname  FROM trn_salesdetail as tsd, trn_sales as ts, mst_store as ms, mst_item as mi, mst_supplier as msupplier WHERE tsd.isalesid=ts.isalesid AND ms.istoreid=ts.istoreid AND mi.vbarcode=tsd.vitemcode AND msupplier.vsuppliercode=mi.vsuppliercode AND date_format(ts.dtrandate,'%Y-%m-%d') > '".$week_starting_date."' AND date_format(ts.dtrandate,'%Y-%m-%d') <= '".$week_ending_date."' AND mi.vdepcode in($department_id)");

		return $query->rows;
	}

    public function getVendors() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY isupplierid DESC");

        return $query->rows;
    }

    public function getDepartments() {
        $query = $this->db2->query("SELECT * FROM mst_department ORDER BY idepartmentid ASC");

        return $query->rows;
    }

    public function getStore() {
        $sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

        $query = $this->db->query($sql);

        return $query->row;
    }
}
