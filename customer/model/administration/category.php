<?php
class ModelAdministrationCategory extends Model {

	public function editCategoryList($data) {
		
		if(isset($data['category']))
		{
			foreach($data['category'] as $key=>$value){
				
				$que= $this->db2->query("SELECT count(*) as total FROM mst_category WHERE icategoryid = '" . $this->db->escape($value['icategoryid']) . "'");
				if($que->row['total'] > 0){
					$this->db2->query("UPDATE mst_category SET vcategoryname = '" . html_entity_decode($value['vcategoryname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "', vcategorttype = '" . $this->db->escape($value['vcategorttype']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "' WHERE icategoryid = '" . (int)$value['icategoryid'] . "'");
				}else{
					$this->db2->query("INSERT INTO mst_category SET vcategoryname = '" . html_entity_decode($value['vcategoryname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "', vcategorttype = '" . $this->db->escape($value['vcategorttype']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['SID'])."'");

					$last_id = $this->db2->getLastId();
					$this->db2->query("UPDATE mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'");
				}
				
			}

		}
		
	  }

	public function getCategory($icategoryid) {
		$query = $this->db2->query("SELECT * FROM mst_category c WHERE c.icategoryid = '" . (int)$icategoryid . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		
		$sql = "SELECT * FROM mst_category";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE icategoryid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY vcategoryname";

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

	public function getTotalCategories($data) {
		
		$sql = "SELECT * FROM mst_category";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE icategoryid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY icategoryid DESC";
    
		$query = $this->db2->query($sql);

		return count($query->rows);
	}
	
}
