<?php
class ModelApiInventoryDashboard extends Model {

	public function last10PhysicalInventories(){
		
		$sql="select ipiid,SID,vrefnumber as Tranid,date_format(dclosedate,'%m-%d-%Y') as dclosedate,nnettotal FROM trn_physicalinventory where vtype='Physical' and estatus='Close' order by date_format(dclosedate,'%m-%d-%Y') desc limit 10";	
		
		$query = $this->db2->query($sql);
		
		return $query->rows;
	}
	
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

	public function getCategoriesReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$vcatcodes = 'ALL';
		}else{
			$vcatcodes = implode(',', $data['report_data']);
		}

		$query = $this->db2->query("CALL rp_webqoh('Category','".$vcatcodes."')");

		return $query->rows;
	}

	public function getDepartmentsReport($data) {
		
		if(in_array('ALL', $data['report_data'])){
			$vdepcodes = 'ALL';
		}else{
			$vdepcodes = implode(',', $data['report_data']);
		}

		$query = $this->db2->query("CALL rp_webqoh('Department','".$vdepcodes."')");

		return $query->rows;
	}

	
}
