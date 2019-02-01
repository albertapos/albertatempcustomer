<?php
class ModelAdministrationCustomer extends Model {

	public function addCustomer($data) {
		
		$this->db2->query("INSERT INTO mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['SID'])."'");

		$this->cache->delete('customer');

	}

	public function editCustomer($icustomerid, $data) {

		$this->db2->query("UPDATE mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "' WHERE icustomerid = '" . (int)$icustomerid . "'");

		$this->cache->delete('customer');
	}

	public function getCustomer($icustomerid) {
		$query = $this->db2->query("SELECT * FROM mst_customer c WHERE c.icustomerid = '" . (int)$icustomerid . "'");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		$sql = "SELECT * FROM mst_customer";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalCustomers($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_customer";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}

	public function getAcNumber($acnumber) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_customer WHERE vaccountnumber = '".$this->db->escape($acnumber)."'";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
}
