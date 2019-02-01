<?php
class ModelAdministrationAgeVerification extends Model {

	public function editAgeVerificationList($data) {
		
		if(isset($data['age_verification']))
		{

			foreach($data['age_verification'] as $key=>$value){
				
				$que= $this->db2->query("SELECT count(*) as total FROM mst_ageverification WHERE Id = '" . $this->db->escape($value['Id']) . "'");
				if($que->row['total'] > 0){
					$this->db2->query("UPDATE mst_ageverification SET vname = '" . $this->db->escape($value['vname']) . "',`vvalue` = '" . $this->db->escape($value['vvalue']) . "' WHERE Id = '" . (int)$value['Id'] . "'");
				}else{
					$this->db2->query("INSERT INTO mst_ageverification SET vname = '" . $this->db->escape($value['vname']) . "',`vvalue` = '" . $this->db->escape($value['vvalue']) . "',SID = '" . (int)($this->session->data['SID'])."'");
				}
				
			}

		}
		
	  }

	public function getAgeVerifications($data = array()) {
		
		$sql = "SELECT * FROM mst_ageverification";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE Id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY Id ASC";

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

	public function getTotalAgeVerifications($data = array()) {
		
		$sql = "SELECT * FROM mst_ageverification";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE Id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY Id ASC";

		$query = $this->db2->query($sql);

		return count($query->rows);
	}
	
}
