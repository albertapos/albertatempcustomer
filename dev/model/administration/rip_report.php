<?php
class ModelAdministrationRipReport extends Model {

	public function getRip($id) {
		$query = $this->db2->query("SELECT * FROM trn_rip_header a WHERE a.id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getRips($data = array()) {

		$sql = "SELECT a.*,b.vcompanyname FROM trn_rip_header a,mst_supplier b, trn_purchaseorder c WHERE a.vendorid=b.isupplierid AND a.ponumber=c.vrefnumber";

		if (!empty($data['vendorid'])) {
			$sql .= " AND vendorid = '" . $this->db->escape($data['vendorid']) . "'";
		}

		if (!empty($data['start_date']) && !empty($data['end_date'])) {

			$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        	$data['start_date'] = $start_date->format('Y-m-d');

	        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
	        $data['end_date'] = $end_date->format('Y-m-d');

			$sql .= " AND date_format(c.dreceiveddate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(c.dreceiveddate,'%Y-%m-%d') <= '".$data['end_date']."'";
		}

		$sort_data = array(
			'vcompanyname',
			'ponumber',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vcompanyname";
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

	public function getTotalRips($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM trn_rip_header a,trn_purchaseorder b WHERE a.ponumber=b.vrefnumber";

		if (!empty($data['start_date']) && !empty($data['end_date'])) {

			$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        	$data['start_date'] = $start_date->format('Y-m-d');

	        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
	        $data['end_date'] = $end_date->format('Y-m-d');

			$sql .= " AND date_format(b.dreceiveddate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(b.dreceiveddate,'%Y-%m-%d') <= '".$data['end_date']."'";
		}
				
		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getRipDetail($ripheaderid=0){
		
		$sql="SELECT * FROM `trn_rip_detail` a WHERE a.ripheaderid=".$ripheaderid;	
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function AddRipDetail($data){
		
		$this->db2->query("UPDATE `trn_rip_header` SET `receivedtotalamt`=receivedtotalamt+'".$data['checkamt']."',`pendingtotalamt`=riptotal-receivedtotalamt WHERE id='".$data['ripheaderid']."'");
		
		$this->db2->query("INSERT INTO `trn_rip_detail` SET `ripheaderid`='".$data['ripheaderid']."',`checknumber`='".$data['checknumber']."',`checkamt`='".$data['checkamt']."',`checkdesc`='".$data['checkdesc']."',SID = '" . (int)($this->session->data['SID'])."'");	
	}
}
