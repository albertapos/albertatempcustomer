<?php
class ModelAdministrationDepartment extends Model {

	public function editDepartmentList($data) {
		
		if(isset($data['department']))
		{
			foreach($data['department'] as $key=>$value){
				$starttime = '';
				$endtime = '';
				if($value['start_hour'] != '' && $value['start_minute'] != ''){
					$starttime = $value['start_hour'].':'.$value['start_minute'].':00';
				}else{
					$starttime = NULL;
				}
				
				if($value['end_hour'] != '' && $value['end_minute'] != ''){
					$endtime = $value['end_hour'].':'.$value['end_minute'].':00';
				}else{
					$endtime = NULL;
				}

				$que= $this->db2->query("SELECT count(*) as total FROM mst_department WHERE idepartmentid = '" . $this->db->escape($value['idepartmentid']) . "'");
				if($que->row['total'] > 0){
					$sql = "UPDATE mst_department SET vdepartmentname = '" . html_entity_decode($value['vdepartmentname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "',";

					if(!empty($starttime)){
						$sql .= " starttime = '" .$starttime. "',";
					}else{
						$sql .= " starttime = NULL,";
					}

					if(!empty($endtime)){
						$sql .= " endtime = '" .$endtime. "',";
					}else{
						$sql .= " endtime = NULL,";
					}

					$sql .= "isequence = '" . (int)$this->db->escape($value['isequence']) . "' WHERE idepartmentid = '" . (int)$value['idepartmentid'] . "'";

					$this->db2->query($sql);
				}else{
					$sql = "INSERT INTO mst_department SET vdepartmentname = '" . html_entity_decode($value['vdepartmentname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "',";

					if(!empty($starttime)){
						$sql .= " starttime = '" .$starttime. "',";
					}else{
						$sql .= " starttime = NULL,";
					}

					if(!empty($endtime)){
						$sql .= " endtime = '" .$endtime. "',";
					}else{
						$sql .= " endtime = NULL,";
					}

					$sql .= "isequence = '" . (int)$this->db->escape($value['isequence']) . "',estatus = 'Active',SID = '" . (int)($this->session->data['SID'])."'";

					$this->db2->query($sql);

					$last_id = $this->db2->getLastId();
					$this->db2->query("UPDATE mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
				}
				
			}

		}
		
	  }

	public function getDepartments($data = array()) {
		$sql = "SELECT * FROM mst_department";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE idepartmentid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY idepartmentid DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalDepartments($data) {
		
		$sql = "SELECT * FROM mst_department";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE idepartmentid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY idepartmentid DESC";

		$query = $this->db2->query($sql);

		return count($query->rows);
	}

}
