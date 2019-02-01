<?php
class ModelAdministrationTax extends Model {

	public function editTaxList($data) {
		
		if(isset($data)){
			$this->db2->query("UPDATE mst_tax SET vtaxtype = '" . $this->db->escape($data['vtaxtype1']) . "',`ntaxrate` = '" . $this->db->escape($data['ntaxrate1']) . "' WHERE Id = '1'");
			$this->db2->query("UPDATE mst_tax SET vtaxtype = '" . $this->db->escape($data['vtaxtype2']) . "',`ntaxrate` = '" . $this->db->escape($data['ntaxrate2']) . "' WHERE Id = '2'");
		}
		
	  }

	public function getTaxes($data = array()) {
		$sql = "SELECT * FROM mst_tax";

		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
}
