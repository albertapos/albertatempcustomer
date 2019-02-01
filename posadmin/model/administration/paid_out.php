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

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalPaidOuts($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_paidout";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
}
