<?php
class ModelApiSalesItemReport extends Model {

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

	public function getCategoriesReport($sdate,$edate) {

		//$query = $this->db2->query("CALL rp_dailysalesitem('".$sdate."','".$edate."','Category')");
		$query = $this->db2->query("select vitemcode,vitemname as itemname,vcatname as vname,sum(iunitqty) as qtysold,sum(nextunitprice) as amount from trn_salesdetail a,trn_sales b where a.isalesid = b.isalesid and date_format(dtrandate,'%m-%d-%Y') between '".$sdate."' and '".$edate."' and b.vtrntype='Transaction' and a.vitemtype='Kiosk'  and (a.vcatname <> '' or a.vcatname is not null) group by  vitemcode,vitemname,vcatname order by qtysold desc,vitemname");

		return $query->rows;
	}

	public function getDepartmentsReport($sdate,$edate) {	
		

		$query = $this->db2->query("CALL rp_dailysalesitem('".$sdate."','".$edate."','Department')");

		return $query->rows;
	}
}