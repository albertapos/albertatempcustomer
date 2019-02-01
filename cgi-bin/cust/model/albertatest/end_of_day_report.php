<?php
class ModelAlbertatestEndOfDayReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCategories() {
		$sql = "SELECT vcategorycode as id, vcategoryname as name FROM mst_category";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getHourlySalesReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}

		$query = $this->db2->query("CALL rp_eofhourlysales('".$date."')");

		return $query->rows;
	}

	public function getCategoriesReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}

		$query = $this->db2->query("CALL rp_eofcategory('".$date."')");

		return $query->rows;
	}

	public function getDepartmentsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofdepartment('".$date."')");

		return $query->rows;
	}

	public function getShiftsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_endofshift('".$date."')");

		return $query->rows;
	}

	public function getPaidoutsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofpaidout('".$date."')");

		return $query->rows;
	}

	public function getPicupsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofpickup('".$date."')");

		return $query->rows;
	}

	public function getTenderReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eoftender('".$date."')");

		return $query->rows;
	}

}
