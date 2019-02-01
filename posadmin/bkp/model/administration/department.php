<?php
class ModelAdministrationDepartment extends Model {

	public function editDepartmentList($data) {
		
		if(isset($data['department']))
		{
			foreach($data['department'] as $key=>$value){
				
				$que= $this->db2->query("SELECT count(*) as total FROM mst_department WHERE idepartmentid = '" . $this->db->escape($value['idepartmentid']) . "'");
				if($que->row['total'] > 0){
					$this->db2->query("UPDATE mst_department SET vdepartmentname = '" . $this->db->escape($value['vdepartmentname']) . "',`vdescription` = '" . $this->db->escape($value['vdescription']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "' WHERE idepartmentid = '" . (int)$value['idepartmentid'] . "'");
				}else{
					$this->db2->query("INSERT INTO mst_department SET vdepartmentname = '" . $this->db->escape($value['vdepartmentname']) . "',`vdescription` = '" . $this->db->escape($value['vdescription']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['SID'])."'");

					$last_id = $this->db2->getLastId();
					$this->db2->query("UPDATE mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
				}
				
			}

		}
		
	  }

	public function getDepartments($data = array()) {
		$sql = "SELECT * FROM mst_department ORDER BY idepartmentid DESC";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalDepartments($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}

}
