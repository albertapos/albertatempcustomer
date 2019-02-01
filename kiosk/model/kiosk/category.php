<?php
class ModelKioskCategory extends Model {
	public function addCategory($data,$files='') {

		/*if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($value['image']);
		}*/
		
		if(isset($files['image']['tmp_name']))
		{
			if(is_file($files['image']['tmp_name']) && $files['image']['tmp_name']!='')
			{
				$fp = fopen($files['image']['tmp_name'], 'rb');
				$image = file_get_contents($files['image']['tmp_name']);
			}else{
				$image = base64_decode($files['image']['tmp_name']);
			}
		}
		else
		{
			$image ='NULL';			
		}
		
		$this->db2->query("INSERT INTO kiosk_category SET  MenuId = '" . $this->db->escape($data['MenuId']) . "',`Category` = '" . $this->db->escape($data['category']) . "', Sequence = '" . (int)$data['sequence'] . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($data['ColumnSize']) . "', Status = '" . $this->db->escape($data['status']) . "', StartEndTime = NOW(),SID = '" . (int)($this->session->data['SID'])."',ImageLoc = '" . $this->db->escape($image) . "'");
		$CategoryId = $this->db->getLastId();

		$this->cache->delete('category');

		return $CategoryId;
	}

	public function editCategoryList($MenuId,$data,$files='') {
		
		if(isset($data['category']))
		{
			$i=1;
			$catid='';
			foreach($data['category'] as $key=>$value)
			{
				if(isset($value['CategoryId']) && $value['CategoryId']!="")
				{
					$catid=	$value['CategoryId'];
				}
				else
				{
					$catid=	'';
				}
					/*if(is_file(DIR_IMAGE.$this->db->escape($value['image'])))
					{
						$fp = fopen(DIR_IMAGE.$this->db->escape($value['image']), 'rb');
						$image = file_get_contents(DIR_IMAGE.$this->db->escape($value['image']));
					}else{
						$image = base64_decode($value['image']);
					}*/
					
					$file= $files['category']['tmp_name'][$key]['image'];
				
					if(isset($file) && $file!='')
					{
						if(is_file($file) && $file!='')
						{
							$fp = fopen($file, 'rb');
							$image = file_get_contents($file);
						}else{
							$image = base64_decode($file);
						}
						//echo 'new';
					}
					else
					{
						//echo 'old';
						$image = base64_decode($value['imagehidden']);			
					}
					
					
					$que= $this->db2->query("SELECT count(*) as total FROM kiosk_category WHERE CategoryId = '" . $this->db->escape($catid) . "'");
					
					if($que->row['total'] > 0)
					{
						$this->db2->query("UPDATE kiosk_category SET MenuId = '" . $this->db->escape($MenuId) . "',`Category` = '" . $this->db->escape($value['Category']) . "', Sequence = '" . (int)$i . "',`RowSize` = '" . $this->db->escape($value['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($value['ColumnSize']) . "', Status = '" . $this->db->escape($value['Status']) . "', StartEndTime = NOW(),SID = '" . (int)($this->session->data['SID'])."',ImageLoc = '" . $this->db->escape($image) . "' WHERE CategoryId = '" . (int)$value['CategoryId'] . "'");
					}else{
						$this->db2->query("INSERT INTO kiosk_category SET MenuId = '" . $this->db->escape($MenuId) . "',`Category` = '" . $this->db->escape($value['Category']) . "', Sequence = '" . (int)$i . "',`RowSize` = '" . $this->db->escape($value['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($value['ColumnSize']) . "', Status = '" . $this->db->escape($value['Status']) . "', StartEndTime = NOW(),SID = '" . (int)($this->session->data['SID'])."',ImageLoc = '" . $this->db->escape($image) . "'");
					}	
				$i++;	
			}			
		}
		//exit;
	  }
	  
	public function editCategory($CategoryId, $data,$files='') {//print_r($data);exit;

		/*if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($value['image']);
		}*/

		if(isset($files['image']['tmp_name']))
		{
			if(is_file($files['image']['tmp_name']) && $files['image']['tmp_name']!='')
			{
				$fp = fopen($files['image']['tmp_name'], 'rb');
				$image = file_get_contents($files['image']['tmp_name']);
			}else{
				$image = base64_decode($files['image']['tmp_name']);
			}
		}
		else
		{
			$image ='NULL';			
		}

		$this->db2->query("UPDATE kiosk_category SET MenuId = '" . $this->db->escape($data['MenuId']) . "',`Category` = '" . $this->db->escape($data['category']) . "', Sequence = '" . (int)$data['sequence'] . "',`RowSize` = '" . $this->db->escape($data['RowSize']) . "',`ColumnSize` = '" . $this->db->escape($data['ColumnSize']) . "', Status = '" . $this->db->escape($data['status']) . "', StartEndTime = NOW(),SID = '" . (int)($this->session->data['SID'])."',ImageLoc = '" . $this->db->escape($image) . "' WHERE CategoryId = '" . (int)$CategoryId . "'");

		$this->cache->delete('category');
	}

	public function deleteCategory($CategoryId) {

		$this->db2->query("INSERT INTO mst_delete_table SET TableName='kiosk_category',TableId='".$CategoryId."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'");			
		$this->db2->query("DELETE FROM kiosk_category WHERE CategoryId = '" . (int)$CategoryId . "'");

		$this->cache->delete('category');
	}

	public function getCategory($CategoryId) {
		$query = $this->db2->query("SELECT * FROM kiosk_category c WHERE c.CategoryId = '" . (int)$CategoryId . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT a.*,b.Title FROM kiosk_category a ,kiosk_menu_header b WHERE a.MenuId=b.MenuId";

		$implode = array();

		if (!empty($data['filter_menuid'])) {
			$implode[] = "a.MenuId = '" . $this->db->escape($data['filter_menuid']) . "' ";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}		

		$sort_data = array(
			'Category',
			'Sequence'
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

	public function getActiveCategories($data = array()) {
		$sql = "SELECT a.*,b.Title FROM kiosk_category a ,kiosk_menu_header b WHERE a.MenuId=b.MenuId AND a.Status='Active'";

		$sort_data = array(
			'Category',
			'Sequence'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY Category";
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
	
	public function getActiveCategoriesByMenuId($MenuId = '') {
		$sql = "SELECT a.* FROM kiosk_category a  WHERE a.MenuId='" .$MenuId. "' AND a.Status='Active'";
		
		$sql .= " ORDER BY Category";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getCategoryStores($CategoryId) {
		$category_store_data = array();

		$query = $this->db2->query("SELECT * FROM kiosk_category_to_store WHERE CategoryId = '" . (int)$CategoryId . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getTotalCategories($data) {
		
		//$query = $this->db2->query("SELECT COUNT(*) AS total FROM kiosk_category");
		
		$sql = "SELECT COUNT(*) AS total FROM kiosk_category";

		$implode = array();

		if (!empty($data['filter_menuid'])) {
			$implode[] = "MenuId = '" . $this->db->escape($data['filter_menuid']) . "' ";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getCategoryDetailView($CategoryId) {
		
		//echo "select a.CategoryId,a.DisplayPosition,a.Price,b.Category,b.RowSize,b.ColumnSize,c.vitemname,c.itemimage from kiosk_menu_item a,kiosk_category b,mst_item c WHERE a.CategoryId = b.CategoryId AND a.iitemid = c.iitemid AND a.CategoryId=".$CategoryId." ORDER BY b.Sequence,c.vitemname";
		//$sql = "SELECT a.*,b.Title FROM kiosk_category a ,kiosk_menu_header b WHERE a.MenuId=b.MenuId AND CategoryId = '" . (int)$CategoryId . "' ORDER BY CategoryId";
		
		$sql="select a.CategoryId,a.DisplayPosition,a.Price,b.Category,b.RowSize,b.ColumnSize,c.vitemname,c.itemimage from kiosk_menu_item a,kiosk_category b,mst_item c WHERE a.CategoryId = b.CategoryId AND a.iitemid = c.iitemid AND a.CategoryId=".$CategoryId." ORDER BY a.DisplayPosition";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
	public function ValidateCategorySequenceByCategory($MenuId,$category,$Sequence) {
		
		$sql="SELECT COUNT(*) as total  FROM kiosk_category WHERE MenuId='".$MenuId."' AND Sequence='".$Sequence."' AND category !='".$category."'";
		
		$query = $this->db2->query($sql);
		
		return $query->row['total'];
	}
	
	public function ValidateRowColumnSizeByMenu($MenuId) {
		
		//$sql="SELECT COUNT(*) as total  FROM kiosk_menu_header WHERE MenuId='".$MenuId."' AND RowSize='". $RowSize."'";
		$sql="SELECT RowSize,ColumnSize  FROM kiosk_menu_header WHERE MenuId='".$MenuId."'";
		
		$query = $this->db2->query($sql);
		
		return $query->row['RowSize'].",".$query->row['ColumnSize'];
	}
	
	public function validatedeletecategory($id) {
		$query = $this->db2->query("SELECT count(*) as total FROM kiosk_menu_item WHERE CategoryId IN (".$this->db->escape($id).")");
		
		return ($query->row['total']);	
	}
}
