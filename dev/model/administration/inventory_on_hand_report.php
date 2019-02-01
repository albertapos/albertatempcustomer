<?php
class ModelAdministrationInventoryOnHandReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCategories() {
		$sql = "SELECT vcategorycode as id, vcategoryname as name FROM mst_category ORDER BY vcategoryname ASC";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department ORDER BY vdepartmentname ASC";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getGroups() {
		$sql = "SELECT iitemgroupid as id, vitemgroupname as name FROM itemgroup ORDER BY vitemgroupname ASC";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getItems() {
		$sql = "SELECT iitemid as id, vitemname as name FROM mst_item WHERE vitemtype != 'Kiosk' and iqtyonhand !=0 and iqtyonhand > 0  and vitemname is not null AND visinventory='Yes'";

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
