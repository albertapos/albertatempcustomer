<?php
class ModelKioskPages extends Model {
	public function addPage($data) {
		$this->db2->query("INSERT INTO kiosk_page_master SET  InternalTitle = '" . $this->db->escape($data['InternalTitle']) . "',`DisplayTitle` = '" . $this->db->escape($data['DisplayTitle']) . "', RowSize = '" . (int)$data['RowSize'] . "',ColumnSize = '" . $this->db->escape($data['ColumnSize']) . "',SID = '" . (int)($this->session->data['SID'])."'");

		 $PageId = $this->db2->getLastId();

		if (isset($data['pages'])) {
			foreach ($data['pages'] as $page) {
				
				$this->db2->query("INSERT INTO kiosk_page_flow_detail SET PageId = '" . (int)$PageId . "', iitemid = '" . (int)$page['iitemid'] . "', DisplaySeq = '" . (int)$page['DisplaySeq'] . "', MoreLessAction = '" . $this->db->escape($page['MoreLessAction']) . "', RealItem = '" . $this->db->escape($page['RealItem']) . "', Price = '" . (float)$page['Price'] . "', LastUpdate = NOW(),SID = '" . (int)($this->session->data['SID'])."'");
			}
		}
		
		$this->cache->delete('pages');

		return $PageId;
	}

	public function editPage($PageId, $data) {//print_r($data);exit;
		
		$this->db2->query("UPDATE kiosk_page_master SET InternalTitle = '" . $this->db->escape($data['InternalTitle']) . "',`DisplayTitle` = '" . $this->db->escape($data['DisplayTitle']) . "', RowSize = '" . (int)$data['RowSize'] . "',ColumnSize = '" . $this->db->escape($data['ColumnSize']) . "',SID = '" . (int)($this->session->data['SID'])."'  WHERE PageId = '" . (int)$PageId . "'");
		
		$old_page_detail=array();
		$new_page_detail=array();
		
		$que= $this->db2->query("SELECT * FROM kiosk_page_flow_detail WHERE PageId = '" . $PageId . "'");
		$rows = $que->rows;
		
		if(count($rows) > 0)
		{
			foreach($rows as $row)
			{
				$old_page_detail[]=$row['PageDetailId'];		
			}
		}

		if (isset($data['pages'])) {						
		
			foreach ($data['pages'] as $page) {
				
				if(isset($page['PageDetailId']) && $page['PageDetailId'] !="")
				{
					$que= $this->db2->query("SELECT * FROM kiosk_page_flow_detail WHERE PageDetailId = '" . $this->db->escape($page['PageDetailId']) . "'");		
					$rows = $que->row;
					
					$new_page_detail[]=$page['PageDetailId'];
					
					//echo 'up';
					$this->db2->query("UPDATE kiosk_page_flow_detail SET PageId = '" . (int)$PageId . "', iitemid = '" . (int)$page['iitemid'] . "', DisplaySeq = '" . (int)$page['DisplaySeq'] . "', MoreLessAction = '" . $this->db->escape($page['MoreLessAction']) . "', RealItem = '" . $this->db->escape($page['RealItem']) . "', Price = '" . (float)$page['Price'] . "',SID = '" . (int)($this->session->data['SID'])."' WHERE PageDetailId = '" . $this->db->escape($page['PageDetailId']) . "'");
					
				}else{
					//echo 'in';				
					$this->db2->query("INSERT INTO kiosk_page_flow_detail SET PageId = '" . (int)$PageId . "', iitemid = '" . (int)$page['iitemid'] . "', DisplaySeq = '" . (int)$page['DisplaySeq'] . "', MoreLessAction = '" . $this->db->escape($page['MoreLessAction']) . "', RealItem = '" . $this->db->escape($page['RealItem']) . "', Price = '" . (float)$page['Price'] . "',SID = '" . (int)($this->session->data['SID'])."'");
					
					 $PageDetailId = $this->db2->getLastId();
					 
					//$new_page_detail[]=$PageDetailId;	
				}
				
				//$que= $this->db2->query("SELECT * FROM kiosk_page_flow_detail WHERE PageDetailId = '" . $this->db->escape($page['PageDetailId']) . "'");
				//echo ($que->row['total']);
				//$rows = $que->row;
				//print_r($rows);
				//$new_page_detail[]=$page['PageDetailId'];
				
				//print_r($rows['PageDetailId']);		
					
				//echo $rows['PageDetailId'].','.$page['PageDetailId']."<br>";
				//if(count($rows)> 0 )
				//{					
					//echo 'up';
					//$this->db2->query("UPDATE kiosk_page_flow_detail SET PageId = '" . (int)$PageId . "', iitemid = '" . (int)$page['iitemid'] . "', DisplaySeq = '" . (int)$page['DisplaySeq'] . "', MoreLessAction = '" . $this->db->escape($page['MoreLessAction']) . "', RealItem = '" . $this->db->escape($page['RealItem']) . "', Price = '" . (float)$page['Price'] . "',SID = '" . (int)($this->session->data['SID'])."' WHERE PageDetailId = '" . $this->db->escape($page['PageDetailId']) . "'");
				//}else{
					//echo 'in';				
					//$this->db2->query("INSERT INTO kiosk_page_flow_detail SET PageId = '" . (int)$PageId . "', iitemid = '" . (int)$page['iitemid'] . "', DisplaySeq = '" . (int)$page['DisplaySeq'] . "', MoreLessAction = '" . $this->db->escape($page['MoreLessAction']) . "', RealItem = '" . $this->db->escape($page['RealItem']) . "', Price = '" . (float)$page['Price'] . "',SID = '" . (int)($this->session->data['SID'])."'");
				//}
			}
			
			
		}
		//print_r($new_page_detail);
			//print_r($old_page_detail);
			$diff=array_diff($old_page_detail,$new_page_detail);
			
			if(count($diff) > 0)
			{
				foreach($diff as $dif)
				{
					$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_detail',TableId='".$dif."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
					$this->db2->query($sql);
					$this->db2->query("DELETE FROM kiosk_page_flow_detail WHERE PageDetailId = '" . (int)$dif . "'");
				}			
			}			

		$this->cache->delete('pages');
	}

	public function deletePage($PageId) {
	
		$query = $this->db2->query("SELECT PageDetailId FROM kiosk_page_flow_detail WHERE PageId  = '" . (int)$PageId . "' AND PageId > 5 ORDER BY PageId");
		
		foreach($query->rows as $row)
		{
			$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_detail',TableId='".$row['PageDetailId']."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
			$this->db2->query($sql);
		}
		
		$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_master',TableId='".$PageId."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
		$this->db2->query($sql);
	
		if($PageId > 5)
		{
			$this->db2->query("DELETE FROM kiosk_page_flow_detail WHERE PageId = '" . (int)$PageId . "'");
			$this->db2->query("DELETE FROM kiosk_page_master WHERE PageId = '" . (int)$PageId . "'");
		
			$this->cache->delete('pages');
		}
	}

	public function getPage($PageId) {
		
		$query = $this->db2->query("SELECT * FROM kiosk_page_master  WHERE PageId = '" . (int)$PageId . "'");

		return $query->row;
	}

	public function getPages($data = array()) {
		$sql = "SELECT * FROM kiosk_page_master WHERE PageId > 5 ";

		if (!empty($data['filter_page'])) {
			$sql .= " AND InternalTitle LIKE '" . $this->db->escape($data['filter_page']) . "%'";
		}

		$sql .= " GROUP BY PageId";

		$sort_data = array(
			'Page',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY PageId";
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


	public function getTotalPage() {
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM kiosk_page_master");

		return $query->row['total'];
	}
	
	public function getPageFlowDetail($PageId) {
		
		//$query = $this->db2->query("SELECT a.*,b.vitemname,b.itemimage FROM kiosk_page_flow_detail  a,mst_item b WHERE b.vitemtype='Kiosk' AND a.iitemid=b.iitemid AND a.PageId = '" . (int)$PageId . "' ORDER BY a.DisplaySeq ");
		$query = $this->db2->query("SELECT a.*,b.vitemname,b.itemimage FROM kiosk_page_flow_detail  a LEFT JOIN mst_item b ON b.vitemtype='Kiosk' AND a.iitemid=b.iitemid WHERE a.PageId = '" . (int)$PageId . "' ORDER BY a.DisplaySeq ");

		return $query->rows;
	}
	
	public function getPageFlowDetailView($PageId) {
		
		//$query = $this->db2->query("SELECT a.*,b.vitemname,b.itemimage FROM kiosk_page_flow_detail  a,mst_item b WHERE b.vitemtype='Kiosk' AND a.iitemid=b.iitemid AND a.PageId = '" . (int)$PageId . "' ORDER BY a.DisplaySeq ");
		$query = $this->db2->query("SELECT a.*,b.vitemname,b.itemimage,c.RowSize,c.ColumnSize FROM kiosk_page_master  c,kiosk_page_flow_detail  a LEFT JOIN mst_item b ON b.vitemtype='Kiosk' AND a.iitemid=b.iitemid WHERE c.PageId=a.PageId AND a.PageId = '" . (int)$PageId . "' ORDER BY a.DisplaySeq ");

		return $query->rows;
	}
	
	public function validatedeletepages($id) {
		$query = $this->db2->query("SELECT count(*) as total FROM kiosk_page_flow_header WHERE PageId IN (".$this->db->escape($id).")");
		
		return ($query->row['total']);	
	}
}
