<?php
class ModelApiVendorReport extends Model {

	public function getVendorReport($data = array()){
		$start_date = $data['start_date'];

		$end_date = $data['end_date'];
		
		$query = $this->db2->query("CALL rp_vendorsummary('".$data['start_date']."','".$data['end_date']."')");

		return $query->rows;
	}
}
