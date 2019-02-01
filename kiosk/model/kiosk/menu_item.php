<?php
class ModelKioskMenuItem extends Model {
	public function addMenuItem($data) {
		$this->db2->query("INSERT INTO kiosk_menu_item SET `MenuId` = '" . (int)($data['MenuId']) . "', CategoryId = '" . (int)$data['CategoryId'] . "',iitemid = '" . (int)($data['iitemid']) . "', DisplayPosition = '" . (int)($data['DisplayPosition']) . "',`Price` = '" . $this->db->escape($data['Price']) . "',SID = '" . (int)($this->session->data['SID'])."'");

		$MenuDetailId = $this->db->getLastId();

		$this->cache->delete('menuitem');

		return $MenuDetailId;
	}

	public function editMenuItem($MenuDetailId, $data) {
		$this->db2->query("UPDATE kiosk_menu_item SET `MenuId` = '" . (int)($data['MenuId']) . "', CategoryId = '" . (int)$data['CategoryId'] . "',iitemid = '" . (int)($data['iitemid']) . "', DisplayPosition = '" . (int)($data['DisplayPosition']) . "',`Price` = '" . $this->db->escape($data['Price']) . "',SID = '" . (int)($this->session->data['SID'])."' WHERE MenuDetailId = '" . (int)$MenuDetailId . "'");

		$this->cache->delete('menuitem');
	}

	public function deleteMenuItem($MenuDetailId) {

		$this->db2->query("DELETE FROM kiosk_menu_item WHERE MenuDetailId = '" . (int)$MenuDetailId . "'");

		$this->cache->delete('menuitem');
	}

	public function getMenuItem($MenuDetailId) {
		$query = $this->db2->query("SELECT * FROM kiosk_menu_item  WHERE MenuDetailId = '" . (int)$MenuDetailId . "'");

		return $query->row;
	}

	public function getMenuItems($data = array()) {
		
		 //$sql = "SELECT a.DisplayPosition,a.Price,a.SID,a.LastUpdate,b.Title as MenuId,c.Category,d.vitemname FROM kiosk_menu_item a,kiosk_menu_header b,kiosk_Category c,mst_item d WHERE a.MenuId=b.MenuId AND a.CategoryId=c.CategoryId AND a.iitemid=d.iitemid";
		 
		 $sql = "SELECT a.MenuDetailId as MenuDetailId,a.iitemid as iitemid,a.CategoryId as CategoryId,a.DisplayPosition,a.Price,a.SID,a.LastUpdate,b.Title,c.Category,d.vitemname FROM kiosk_menu_item a LEFT JOIN kiosk_menu_header b ON a.MenuId=b.MenuId LEFT JOIN kiosk_category c ON a.CategoryId=c.CategoryId LEFT JOIN mst_item d ON a.iitemid=d.iitemid ";

		/*if (!empty($data['filter_menu'])) {
			$sql .= " AND MenuId LIKE '" . $this->db->escape($data['filter_menu']) . "%'";
		}*/

		//$sql .= " GROUP BY MenuDetailId";

		/**/$sort_data = array(
			'a.MenuDetailId',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY MenuDetailId DESC,b.Title,c.Category,d.vitemname";
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

	public function getTotalMenuItem() {
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM kiosk_menu_item");

		return $query->row['total'];
	}
	
	public function ValidateDisplayPosition($MenuId,$CategoryId,$DisplayPosition) {
		
		$sql="SELECT COUNT(*) as total  FROM kiosk_menu_item WHERE DisplayPosition=". $DisplayPosition." AND MenuId=".$MenuId." AND CategoryId=".$CategoryId;
		
		$query = $this->db2->query($sql);
		
		return $query->row['total'];
	}
}
