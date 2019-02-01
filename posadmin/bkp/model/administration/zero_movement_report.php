<?php
class ModelAdministrationZeroMovementReport extends Model {

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

	public function getZeroMovementReport($data) {
		if(in_array('ALL', $data['report_by'])){
			$vdepcodes = 'ALL';
		}else{
			$vdepcodes = implode(',', $data['report_by']);
		}

		$query = $this->db2->query("CALL rp_webzeroitemmovement('".$vdepcodes."','" . $data['start_date'] . "','".$data['end_date']."')");

		return $query->rows;
	}
}
