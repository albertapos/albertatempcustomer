<?php
class ModelAdministrationUsers extends Model {

	public function addUser($data = array()) {

		$this->db2->query("INSERT INTO mst_user SET vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vaddress2 = '" . $this->db->escape($data['vaddress2']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vuserid = '" . $this->db->escape($data['vuserid']) . "', vpassword = '" . $this->db->escape($data['vpassword']) . "', vusertype = '" . $this->db->escape($data['vusertype']) . "', vpasswordchange = '" . $this->db->escape($data['vpasswordchange']) . "', vuserbarcode = '" . $this->db->escape($data['vuserbarcode']) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['SID'])."'");

		$iuserid = $this->db2->getLastId();

		if(!empty($this->db->escape($data['vusertype']))){
			$query = $this->db2->query("SELECT * FROM mst_permissiongroup  WHERE vgroupname = '" . $this->db->escape($data['vusertype']) . "'");
			if(count($query->rows) > 0){
				$ipermissiongroupid = $query->row['ipermissiongroupid'];
			
				$que = $this->db2->query("SELECT * FROM mst_userpermissiongroup  WHERE iuserid = '" . (int)$iuserid . "'");

				if(count($que->rows) > 0){
					$this->db2->query("UPDATE mst_userpermissiongroup SET  ipermissiongroupid = '" . (int)$ipermissiongroupid . "' WHERE iuserid = '" . (int)$iuserid . "'");
				}else{
					$this->db2->query("INSERT INTO mst_userpermissiongroup SET iuserid = '" . (int)$iuserid . "',`ipermissiongroupid` = '" . (int)$ipermissiongroupid . "',SID = '" . (int)($this->session->data['SID'])."'");
				}
			}
		}

	}

	public function editUser($iuserid, $data) {
		
		if(!empty($this->db->escape($data['vusertype']))){
			$query = $this->db2->query("SELECT * FROM mst_permissiongroup  WHERE vgroupname = '" . $this->db->escape($data['vusertype']) . "'");
			if(count($query->rows) > 0){
				$ipermissiongroupid = $query->row['ipermissiongroupid'];
			
				$que = $this->db2->query("SELECT * FROM mst_userpermissiongroup  WHERE iuserid = '" . (int)$iuserid . "'");

				if(count($que->rows) > 0){
					$this->db2->query("UPDATE mst_userpermissiongroup SET  ipermissiongroupid = '" . (int)$ipermissiongroupid . "' WHERE iuserid = '" . (int)$iuserid . "'");
				}else{
					$this->db2->query("INSERT INTO mst_userpermissiongroup SET iuserid = '" . (int)$iuserid . "',`ipermissiongroupid` = '" . (int)$ipermissiongroupid . "',SID = '" . (int)($this->session->data['SID'])."'");
				}
			}
		}

		$this->db2->query("UPDATE mst_user SET  vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "',`vaddress2` = '" . $this->db->escape($data['vaddress2']) . "',`vcity` = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vuserid = '" . $this->db->escape($data['vuserid']) . "', vpassword = '" . $this->db->escape($data['vpassword']) . "', vusertype = '" . $this->db->escape($data['vusertype']) . "', vpasswordchange = '" . $this->db->escape($data['vpasswordchange']) . "', vuserbarcode = '" . $this->db->escape($data['vuserbarcode']) . "', estatus = '" . $this->db->escape($data['estatus']) . "' WHERE iuserid = '" . (int)$iuserid . "'");
	}

	public function getUser($iuserid) {


		$query = $this->db2->query("SELECT * FROM mst_user u WHERE u.iuserid = '" . (int)$iuserid . "'");

		return $query->row;
	}

	public function getUsers($data = array()) {
		$sql = "SELECT * FROM mst_user";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalUsers() {
		
		$sql = "SELECT COUNT(*) AS total FROM mst_user";

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}

	public function getUserTypes() {
		$sql = "SELECT * FROM mst_permissiongroup";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getUserID($vuserid) {


		$query = $this->db2->query("SELECT * FROM mst_user u WHERE u.vuserid = '" . (int)$vuserid . "'");

		return $query->rows;
	}
	
}
