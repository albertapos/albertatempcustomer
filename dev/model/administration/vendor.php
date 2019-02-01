<?php
class ModelAdministrationVendor extends Model {

	public function addVendor($data) {
		
		$this->db2->query("INSERT INTO mst_supplier SET  vcompanyname = '" . $this->db->escape($data['vcompanyname']) . "',`vvendortype` = '" . $this->db->escape($data['vvendortype']) . "', vfnmae = '" . $this->db->escape($data['vfnmae']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "',`vcode` = '" . $this->db->escape($data['vcode']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', plcbtype = '" . $this->db->escape($data['plcbtype']) . "', estatus = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['SID'])."'");

		$isupplierid = $this->db2->getLastId();

		$this->db2->query("UPDATE mst_supplier SET vsuppliercode = '" . (int)$isupplierid . "' WHERE isupplierid = '" . (int)$isupplierid . "'");

		$this->cache->delete('vendor');

		return $isupplierid;
	}

	public function editVendor($isupplierid, $data) {

		$this->db2->query("UPDATE mst_supplier SET  vcompanyname = '" . $this->db->escape($data['vcompanyname']) . "',`vvendortype` = '" . $this->db->escape($data['vvendortype']) . "', vfnmae = '" . $this->db->escape($data['vfnmae']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "',`vcode` = '" . $this->db->escape($data['vcode']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', plcbtype = '" . $this->db->escape($data['plcbtype']) . "', estatus = '" . $this->db->escape($data['estatus']) . "' WHERE isupplierid = '" . (int)$isupplierid . "'");

		$this->cache->delete('vendor');
	}


	public function editVendorList($data) {
		
		if(isset($data['vendor']))
		{
			foreach($data['vendor'] as $key=>$value){
				
				$que= $this->db2->query("SELECT count(*) as total FROM mst_supplier WHERE isupplierid = '" . $this->db->escape($value['isupplierid']) . "'");
				if($que->row['total'] > 0){
					$this->db2->query("UPDATE mst_supplier SET vcode = '" . $this->db->escape($value['vcode']) . "',`vcompanyname` = '" . $this->db->escape($value['vcompanyname']) . "', vphone = '" . $this->db->escape($value['vphone']) . "',`vemail` = '" . $this->db->escape($value['vemail']) . "' WHERE isupplierid = '" . (int)$value['isupplierid'] . "'");
				}
				
			}

		}
		
	  }

	public function getVendor($isupplierid) {
		$query = $this->db2->query("SELECT * FROM mst_supplier s WHERE s.isupplierid = '" . (int)$isupplierid . "'");

		return $query->row;
	}

	public function getVendors($data = array()) {
		$sql = "SELECT * FROM mst_supplier";

		if (!empty($data['searchbox'])) {
            $sql .= " WHERE vcompanyname LIKE  '%" .$this->db->escape($data['searchbox']). "%'";
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

	public function getTotalVendors($data) {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_supplier";

		if (!empty($data['searchbox'])) {
            $sql .= " WHERE vcompanyname LIKE  '%" .$this->db->escape($data['searchbox']). "%'";
        }

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
}
