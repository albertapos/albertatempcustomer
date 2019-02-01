<?php
class ModelApiRipReport extends Model {

	public function getRip($id) {
		$query = $this->db2->query("SELECT * FROM trn_rip_header a WHERE a.id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getRips($data = array()) {
		$sql = "SELECT a.*,b.vcompanyname FROM `trn_rip_header` a,`mst_supplier` b WHERE a.vendorid=b.isupplierid";

		if (!empty($data['vendorid'])) {
			$sql .= " AND vendorid = '" . $this->db->escape($data['vendorid']) . "'";
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

			//$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
//echo $sql;		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalRips($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM trn_rip_header";
				
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

		return 'Rip Added Successfully!!!';	
	}
}
