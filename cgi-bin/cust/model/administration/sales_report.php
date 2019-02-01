<?php
class ModelAdministrationSalesReport extends Model {

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

	public function getGroups() {
		$sql = "SELECT iitemgroupid as id, vitemgroupname as name FROM itemgroup";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMonthlyReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $data['start_date'] = $start_date->format('Y-m-d');

        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
        $data['end_date'] = $end_date->format('Y-m-d');

		$sql = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as dtrandate,vterminalid,concat('TRN',isalesid) as  trnsalesid,isalesid,nnettotal,nchange,ntaxtotal,vtendertype,vtrntype FROM trn_sales a WHERE date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

        $query = $this->db2->query($sql);

		return $query->rows;
	}

}
