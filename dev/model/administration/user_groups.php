<?php
class ModelAdministrationUserGroups extends Model {

	public function editUserGroup($ipermissiongroupid, $data) {

		if(isset($data) && isset($data['vpermissioncode'])){
			foreach ($data['vpermissioncode'] as $key => $value) {

				$sql = "SELECT *  FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$ipermissiongroupid . "' AND vpermissioncode='".$this->db->escape($value)."'  group by vpermissioncode ";

				$query = $this->db2->query($sql);

				//Insert in to mst_delete_table and delete record from mst_permissiongroupdetail

				//$p_details_id = $query->row['Id'];

				// $this->db2->query("INSERT INTO mst_delete_table SET TableName = 'mst_permissiongroupdetail',`TableId` = '" . (int)$p_details_id . "', Action = 'Delete',SID = '" . (int)($this->session->data['SID'])."'");

				// $this->db2->query("DELETE  FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$ipermissiongroupid . "' AND vpermissioncode='".$this->db->escape($value)."' AND Id = '" . (int)$p_details_id . "'");

				$details = $query->rows;

				if(count($details) > 0){
					$this->db2->query("UPDATE mst_permissiongroupdetail SET  ipermissiongroupid = '" . (int)$ipermissiongroupid . "',`vpermissioncode` = '" . $this->db->escape($value) . "' WHERE Id = '" . (int)$details[0]['Id'] . "'");
				}else{
					$this->db2->query("INSERT INTO mst_permissiongroupdetail SET ipermissiongroupid = '" . (int)$ipermissiongroupid . "',`vpermissioncode` = '" . $this->db->escape($value) . "',SID = '" . (int)($this->session->data['SID'])."'");
				}

			}

		}

	}

	public function getUserGroup($ipermissiongroupid) {
		$query = $this->db2->query("SELECT * FROM mst_permissiongroup p WHERE p.ipermissiongroupid = '" . (int)$ipermissiongroupid . "'");

		return $query->row;
	}

	public function getUserGroups($data = array()) {
		$sql = "SELECT * FROM mst_permissiongroup";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ipermissiongroupid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ipermissiongroupid DESC";

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

	public function getTotalUserGroups($data = array()) {
		
		$sql = "SELECT * FROM mst_permissiongroup";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ipermissiongroupid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ipermissiongroupid DESC";

		$query = $this->db2->query($sql);

		return count($query->rows);
	}

	public function getUserPermissions() {
		$sql = "SELECT * FROM mst_permission";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getUserBeforePermissions($ipermissiongroupid) {
		//$sql = "SELECT DISTINCT ipermissiongroupid, vpermissioncode   FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$ipermissiongroupid . "' ";
		$sql = "SELECT *  FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$ipermissiongroupid . "' group by vpermissioncode ";

		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
}
