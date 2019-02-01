<?php
class ModelKioskGlobalParam extends Model {
	
	public function addGlobalParams($data) {		
		$this->db2->query("INSERT INTO kiosk_global_param SET  ParameterValue = '" . $this->db->escape($data['ParameterValue']) . "',LastUpdate =NOW(),SID = '" . (int)($this->session->data['SID'])."'");

		$UId = $this->db->getLastId();

		$this->cache->delete('menu');

		return $UId;
	}

	public function editGlobalParams($UId, $data) {
		$this->db2->query("UPDATE kiosk_global_param SET  ParameterValue = '" . $this->db->escape($data['ParameterValue']) . "',LastUpdate =NOW(),SID = '" . (int)($this->session->data['SID'])."'  WHERE UId = '" . (int)$UId . "'");

		$this->cache->delete('menu');
	}

	public function deleteGlobalParams($UId) {

		$this->db2->query("DELETE FROM kiosk_global_param WHERE UId = '" . (int)$UId . "'");

		$this->cache->delete('menu');
	}

	public function getGlobalParam($UId) {
		$query = $this->db2->query("SELECT * FROM kiosk_global_param  WHERE UId = '" . (int)$UId . "'");

		return $query->row;
	}

	public function getGlobalParams($data = array()) {
		$sql = "SELECT * FROM kiosk_global_param ";
		
		$sql .= " ORDER BY UId";

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

	public function getTotalGlobalParams() {
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM kiosk_global_param");

		return $query->row['total'];
	}
}
