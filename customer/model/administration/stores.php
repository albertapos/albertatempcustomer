<?php
class ModelAdministrationStores extends Model {
	/*public function addMenus($data) {
		$this->db2->query("INSERT INTO " . DB_PREFIX2 . "menu_header SET `Title` = '" . $this->db->escape($data['Title']) . "', StartTime = '" . (int)$data['StartTime'] . "',ImageLoc = '" . $this->db->escape($data['ImageLoc']) . "', Status = '" . $this->db->escape($data['status']) . "',`SID` = '" . $this->db->escape($data['SID']) . "',`EndTime` = '" . $this->db->escape($data['EndTime']) . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "', LastUpdate = NOW()");

		$MenuId = $this->db->getLastId();

		$this->cache->delete('menu');

		return $MenuId;
	}

	public function editMenus($MenuId, $data) {
		$this->db2->query("UPDATE " . DB_PREFIX2 . "menu_header SET `Title` = '" . $this->db->escape($data['Title']) . "', StartTime = '" . (int)$data['StartTime'] . "',ImageLoc = '" . $this->db->escape($data['ImageLoc']) . "', Status = '" . $this->db->escape($data['status']) . "',`SID` = '" . $this->db->escape($data['SID']) . "',`EndTime` = '" . $this->db->escape($data['EndTime']) . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "', LastUpdate = NOW() WHERE MenuId = '" . (int)$MenuId . "'");

		$this->cache->delete('menu');
	}

	public function deleteMenus($MenuId) {

		$this->db2->query("DELETE FROM " . DB_PREFIX2 . "menu_header WHERE MenuId = '" . (int)$MenuId . "'");

		$this->cache->delete('menu');
	}*/

	public function getStore($id) {
		$query = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id=".$id);

		return $query->row;
	}

	public function getStores($data = array()) {
		//$sql = "SELECT * FROM stores";
		$sql = "SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores";

		$sort_data = array(
			'name',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	/*public function getTotalMenus() {
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX2 . "menu_header");

		return $query->row['total'];
	}*/
}
