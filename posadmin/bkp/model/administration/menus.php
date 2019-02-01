<?php
class ModelAdministrationMenus extends Model {
	
	public function addMenus($data) {
		
		if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($data['image']);
		}
		
		$query=$this->db2->query("SELECT (max(Sequence)+1) as Sequence FROM kiosk_menu_header");
		
		$this->db2->query("INSERT INTO kiosk_menu_header SET `Title` = '" . $this->db->escape($data['Title']) . "', StartTime = '" . (int)$data['StartTime'] . "',ImageLoc = '" . $this->db->escape($image) . "',Status = '" . $this->db->escape($data['status']) . "',`EndTime` = '" . $this->db->escape($data['EndTime']) . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($data['ColumnSize']) . "',SID = '" . (int)($this->session->data['SID'])."',`Sequence` ='".$query->row['Sequence']."'");

		$MenuId = $this->db2->getLastId();

		$this->cache->delete('menu');

		return $MenuId;
	}

	public function editMenus($MenuId, $data) {
		
		if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($value['image']);
		}
		
		$this->db2->query("UPDATE kiosk_menu_header SET `Title` = '" . $this->db->escape($data['Title']) . "', StartTime = '" . (int)$data['StartTime'] . "',ImageLoc = '" . $this->db->escape($image) . "', Status = '" . $this->db->escape($data['status']) . "',`EndTime` = '" . $this->db->escape($data['EndTime']) . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($data['ColumnSize']) . "',SID = '" . (int)($this->session->data['SID'])."' WHERE MenuId = '" . (int)$MenuId . "'");

		$this->cache->delete('menu');
	}
	
	public function editMenusList($data) {
		
		//print_r($data);
		//exit;
		
		if(count($data['menu']) > 0)
		{
			$image='';
			$i=1;
			foreach($data['menu'] as $data)
			{
				if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
				{
					$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
					$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
				}else{
					$image = base64_decode($data['image']);
				}
				$this->db2->query("UPDATE kiosk_menu_header SET `Title` = '" . $this->db->escape($data['Title']) . "', StartTime = '" . (int)$data['StartTime'] . "',ImageLoc = '" . $this->db->escape($image) . "', Status = '" . $this->db->escape($data['Status']) . "',`EndTime` = '" . $this->db->escape($data['EndTime']) . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($data['ColumnSize']) . "',SID = '" . (int)($this->session->data['SID'])."',`Sequence`='".$i."' WHERE MenuId = '" . (int)$data['MenuId'] . "'");
				
			$i++;}
		}
		
		$this->cache->delete('menu');
	}

	public function deleteMenus($MenuId) {

		$this->db2->query("DELETE FROM kiosk_menu_header WHERE MenuId = '" . (int)$MenuId . "'");

		$this->cache->delete('menu');
	}

	public function getMenu($MenuId) {
		$query = $this->db2->query("SELECT * FROM kiosk_menu_header  WHERE MenuId = '" . (int)$MenuId . "'");

		return $query->row;
	}

	public function getMenus($data = array()) {
		
		$sql = "SELECT *,DATE_FORMAT(LastUpdate,'%m-%d-%Y %H:%i:%s') as LastUpdate FROM kiosk_menu_header ";

		if (!empty($data['filter_menu'])) {
			$sql .= " AND Title LIKE '" . $this->db->escape($data['filter_menu']) . "%'";
		}

		$sql .= " GROUP BY MenuId";

		$sort_data = array(
			'Title',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY Sequence";
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

	public function getActiveMenus($data = array()) {
		$sql = "SELECT * FROM kiosk_menu_header WHERE Status='Active'";

		//$sql .= " GROUP BY MenuId";

		$sql .= " ORDER BY MenuId";

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
	
	public function getTotalMenus() {
		
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM kiosk_menu_header");

		return $query->row['total'];
	}
	
	public function getMenuFlowDetailView($MenuId) {
		
		$sql="SELECT b.Title,a.* FROM kiosk_category a,kiosk_menu_header b WHERE a.MenuId=b.MenuId AND b.MenuId=".$MenuId." ORDER BY a.Sequence";
	
		$query = $this->db2->query($sql);

		return $query->rows;
	}
}
