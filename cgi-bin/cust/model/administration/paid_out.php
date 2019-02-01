<?php
class ModelAdministrationPaidOut extends Model {

	public function editCategoryList($data) {
		
		if(isset($data['paidout']))
		{
			foreach($data['paidout'] as $key=>$value){
				
				$que= $this->db2->query("SELECT count(*) as total FROM mst_paidout WHERE ipaidoutid = '" . $this->db->escape($value['ipaidoutid']) . "'");

				if($que->row['total'] > 0){
					$this->db2->query("UPDATE mst_paidout SET vpaidoutname = '" . $this->db->escape($value['vpaidoutname']) . "',`estatus` = '" . $this->db->escape($value['estatus']) . "' WHERE ipaidoutid = '" . (int)$value['ipaidoutid'] . "'");
				}else{
					$this->db2->query("INSERT INTO mst_paidout SET vpaidoutname = '" . $this->db->escape($value['vpaidoutname']) . "',`estatus` = '" . $this->db->escape($value['estatus']) . "',SID = '" . (int)($this->session->data['SID'])."'");
				}
				
			}

		}
		
	  }

	public function getPaidOuts($data = array()) {
		
		$sql = "SELECT * FROM mst_paidout";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ipaidoutid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ipaidoutid DESC";

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

	public function getTotalPaidOuts($data = array()) {
		
		$sql = "SELECT * FROM mst_paidout";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ipaidoutid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ipaidoutid DESC";

        $query = $this->db2->query($sql);

		return count($query->rows);
	}
	
}
