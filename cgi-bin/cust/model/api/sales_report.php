<?php
class ModelApiSalesReport extends Model {

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

	public function getSalesReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $data['start_date'] = $start_date->format('Y-m-d');

        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
        $data['end_date'] = $end_date->format('Y-m-d');


		$sql = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as dtrandate,vterminalid,concat('TRN',isalesid) as  trnsalesid,isalesid,nnettotal,nchange,ntaxtotal,vtendertype,vtrntype FROM trn_sales a WHERE date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND a.vtrntype='Transaction' ";

		$sort_data = array(
			'dtrandate',
			'vtendertype',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dtrandate";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getSalesReportTotal($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $data['start_date'] = $start_date->format('Y-m-d');

        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
        $data['end_date'] = $end_date->format('Y-m-d');

		$sql = "SELECT count(*) as total FROM trn_sales a WHERE date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' ";

        $query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getSalesPerview($isalesid){
		
		$query=$this->db2->query("select * from trn_salesdetail a  where a.isalesid=".$isalesid);	
		
		return $query->rows;	
	}
	
	public function getSalesById($salesid) {
		$sql = "SELECT *,date_format(dtrandate,'%m-%d-%Y %h:%i %p') as trandate FROM trn_sales WHERE isalesid = ". $salesid;

		$query = $this->db2->query($sql);

		return $query->row;
	}
	
	public function getSalesByTender($salesid) {
		$sql = "SELECT * FROM trn_salestender WHERE isalesid = ". $salesid;

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getSalesByCustomer($icustomerid) {
        $query = $this->db2->query("SELECT * FROM mst_customer WHERE icustomerid='" .(int)$icustomerid. "'");

        return $query->row;
    }
}
