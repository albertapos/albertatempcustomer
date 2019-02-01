<?php
class ModelAdministrationCustomer extends Model {

	public function addCustomer($data) {
		
		$this->db2->query("INSERT INTO mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', pricelevel = '" . (int)$this->db->escape($data['pricelevel']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', debitlimit = '" . $this->db->escape($data['debitlimit']) . "', creditday = '" . $this->db->escape($data['creditday']) . "',SID = '" . (int)($this->session->data['SID'])."'");

		$this->cache->delete('customer');

	}

	public function editCustomer($icustomerid, $data) {

		$this->db2->query("UPDATE mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', pricelevel = '" . (int)$this->db->escape($data['pricelevel']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', debitlimit = '" . $this->db->escape($data['debitlimit']) . "', creditday = '" . $this->db->escape($data['creditday']) . "' WHERE icustomerid = '" . (int)$icustomerid . "'");

		$this->cache->delete('customer');
	}

	public function getCustomer($icustomerid) {
		$query = $this->db2->query("SELECT * FROM mst_customer c WHERE c.icustomerid = '" . (int)$icustomerid . "'");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		$sql = "SELECT * FROM mst_customer";

		if (!empty($data['filter_search'])) {
			$sql .= " WHERE (vfname LIKE '" . $this->db->escape($data['filter_search']) . "%' OR vlname LIKE '" . $this->db->escape($data['filter_search']) . "%' OR vaccountnumber LIKE '" . $this->db->escape($data['filter_search']) . "%')";
		}

		$sort_data = array(
			'vfname',
			'vlname',
			'vaccountnumber',
			'vcustomername',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vcustomername";
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

	public function getTotalCustomers($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_customer";

		if (!empty($data['filter_search'])) {
			$sql .= " where (vfname LIKE '" . $this->db->escape($data['filter_search']) . "%' OR vlname LIKE '" . $this->db->escape($data['filter_search']) . "%' OR vaccountnumber LIKE '" . $this->db->escape($data['filter_search']) . "%')";
		}
				
		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getAcNumber($acnumber) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_customer WHERE vaccountnumber = '".$this->db->escape($acnumber)."'";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getCustomerPay($icustomerid) {
		$query = $this->db2->query("SELECT *,DATE_FORMAT(dtrandate,'%m-%d-%Y') as dtrandate FROM trn_customerpay  WHERE icustomerid = '" . (int)$icustomerid . "' order by DATE_FORMAT(dtrandate,'%m-%d-%Y')");

		return $query->rows;
	}
}
