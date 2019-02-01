<?php
class ModelKioskPageFlow extends Model {
	public function addPageFlow($data) {
		
		$str='';
		$PrevPage=0;
		$NextPage=0;
		//print_r($data);
		//exit;
		for($i=1;$i<count($data['pageflow']);$i++)
		{
			if($data['pageflow'][$i]['PageId']!='')
			{
				$NextPage=$data['pageflow'][$i+1]["PageId"];
				
				$this->db2->query("INSERT INTO kiosk_page_flow_header SET  PageId = '" . (int)($data['pageflow'][$i]['PageId']) . "',`ReceiptPrintSeq` = '" . (int)($data['pageflow'][$i]['ReceiptPrintSeq']) . "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = '" . $this->db->escape($data['pageflow'][$i]['Action']) . "',NextPage = '" . (int)($NextPage) . "',FreeTopingsCt = '" . $this->db->escape($data['pageflow'][$i]['FreeTopingsCt']) . "',SID = '" . (int)($this->session->data['SID'])."'");
				
//				$str.=' '.$data['pageflow'][$i]["PageId"].",";
//				$str.=' '.$data['pageflow'][$i]["ReceiptPrintSeq"].",";
//				$str.=' '.$data["MenuDetailId"].",";
//				$str.=' '.$PrevPage.",";
//				$str.=' '.$data['pageflow'][$i]["Action"].",";
//				$str.=' '.$NextPage.",";
//				$str.=' '.$data['pageflow'][$i]["FreeTopingsCt"]."<br>";			
//				$str.="<br>";
			}	
				$PrevPage=$data['pageflow'][$i]["PageId"];
			
		}
		
		//echo $str;exit;
		$this->cache->delete('page_flow');

		//return $PageFlowHeaderId;
	}

	public function editPageFlow($MenuDetailId, $data) {//print_r($data);exit;
		
		$this->db2->query("DELETE FROM kiosk_page_flow_header WHERE MenuDetailId = '" . (int)$MenuDetailId. "'");

		$str='';
		$PrevPage=0;
		$NextPage=0;

		for($i=1;$i<=count($data['pageflow']);$i++)
		{
			if($data['pageflow'][$i]['PageId']!='')
			{
				$NextPage=$data['pageflow'][$i+1]["PageId"];
				
				
			
				$this->db2->query("INSERT INTO kiosk_page_flow_header SET  PageId = '" . (int)($data['pageflow'][$i]['PageId']) . "',`ReceiptPrintSeq` = '" . (int)($data['pageflow'][$i]['ReceiptPrintSeq']) . "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = '" . $this->db->escape($data['pageflow'][$i]['Action']) . "',NextPage = '" . (int)($NextPage) . "',FreeTopingsCt = '" . $this->db->escape($data['pageflow'][$i]['FreeTopingsCt']) . "',SID = '" . (int)($this->session->data['SID'])."'");
				
//				$str.=' '.$data['pageflow'][$i]["PageId"].",";
//				$str.=' '.$data['pageflow'][$i]["ReceiptPrintSeq"].",";
//				$str.=' '.$data["MenuDetailId"].",";
//				$str.=' '.$PrevPage.",";
//				$str.=' '.$data['pageflow'][$i]["Action"].",";
//				$str.=' '.$NextPage.",";
//				$str.=' '.$data['pageflow'][$i]["FreeTopingsCt"]."<br>";			
//				$str.="<br>";
			}
				$PrevPage=$data['pageflow'][$i]["PageId"];
			
		}
		//echo $str;exit;
		$this->cache->delete('page_flow');
	}

	public function deletePageFlow($MenuDetailId) {

		$old_query = $this->db2->query("SELECT MenuId,CategoryId FROM kiosk_menu_item WHERE MenuDetailId  = '" . (int)$MenuDetailId . "'");
		$wa = $old_query->row;
	
		$query = $this->db2->query("SELECT PageFlowHeaderId FROM kiosk_page_flow_header WHERE MenuDetailId  = '" . (int)$MenuDetailId . "' ORDER BY PageFlowHeaderId");
		
		foreach($query->rows as $row)
		{
			$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_header',TableId='".$row['PageFlowHeaderId']."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
			$this->db2->query($sql);
		}
		
		$sql="INSERT INTO mst_delete_table SET TableName='kiosk_menu_item',TableId='".$MenuDetailId."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
		$this->db2->query($sql);
			
		$this->db2->query("DELETE FROM kiosk_menu_item WHERE MenuDetailId = '" . (int)$MenuDetailId . "'");
		$this->db2->query("DELETE FROM kiosk_page_flow_header WHERE MenuDetailId = '" . (int)$MenuDetailId . "'");

		if(count($wa) > 0)
		{
			$i=1;
			$old_quer = $this->db2->query("SELECT * FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($wa['MenuId']) . "' AND CategoryId = '" . (int)$wa['CategoryId'] . "'");
			
			foreach($old_quer->rows as $row)
			{
				//echo $i."<br>";
				//echo "UPDATE kiosk_menu_item SET `DisplayPosition` = '" . $i . "' WHERE `MenuDetailId` = '" . (int)($row['MenuDetailId']) . "'";
				$this->db2->query("UPDATE kiosk_menu_item SET `DisplayPosition` = '" . $i . "' WHERE `MenuDetailId` = '" . (int)($row['MenuDetailId']) . "'");	
				$i++;
			}	
		}
		
		//exit;
		$this->cache->delete('page_flow');
	}

	public function getPageFlow($MenuDetailId) {
		
		$sql="SELECT * FROM kiosk_page_flow_header  WHERE MenuDetailId = '" . (int)$MenuDetailId . "'";
		
		$query = $this->db2->query($sql);

		return $query->row;
	}

	public function getPageFlowsByMenuDatailId($MenuDetailId) {
		$sql="SELECT a.*,b.InternalTitle,b.DisplayTitle FROM kiosk_page_flow_header a LEFT JOIN kiosk_page_master b ON a.PageId=b.PageId WHERE a.MenuDetailId = '" . (int)$MenuDetailId . "' AND a.PageId > 5 ORDER BY a.ReceiptPrintSeq";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getPagesNameByMenuDetailId($MenuDetailId){
		$sql="SELECT a.*,b.InternalTitle FROM kiosk_page_flow_header a,kiosk_page_master b WHERE a.PageId!=0 AND a.PageId=b.PageId AND a.MenuDetailId = '" . (int)$MenuDetailId . "' ORDER BY a.ReceiptPrintSeq";
		
		$query = $this->db2->query($sql);
		
		return $query->rows;
	}
	
	public function getPageFlows($data = array()) {

		$sql="SELECT c.MenuDetailId,d.vitemname,d.itemimage,c.iitemid,c.Price FROM kiosk_menu_item c,mst_item d WHERE c.iitemid = d.iitemid  ";
		
		$implode = array();

		if (!empty($data['filter_menuid'])) {
			$implode[] = "c.MenuId = '" . $this->db->escape($data['filter_menuid']) . "' ";
		}

		if (!empty($data['filter_categoryid'])) {
			$implode[] = "c.CategoryId = '" . $this->db->escape($data['filter_categoryid']) . "' ";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}	

		$sort_data = array(
			'vitemname',
			'ReceiptPrintSeq',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY DisplayPosition";
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
//echo $sql;
		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getTotalPageFlow($data = array()) {
		
		//$sql="SELECT  a.MenuDetailId,d.vitemname FROM kiosk_page_flow_header a,kiosk_page_master b,kiosk_menu_item c,mst_item d WHERE a.PageId=b.PageId AND a.MenuDetailId =c.MenuDetailId and c.iitemid = d.iitemid  AND b.PageId > 5";
		$sql="SELECT COUNT(*) AS total FROM kiosk_menu_item c,mst_item d WHERE c.iitemid = d.iitemid  ";
		
		$implode = array();

		if (!empty($data['filter_menuid'])) {
			$implode[] = "c.MenuId = '" . $this->db->escape($data['filter_menuid']) . "' ";
		}

		if (!empty($data['filter_categoryid'])) {
			$implode[] = "c.CategoryId = '" . $this->db->escape($data['filter_categoryid']) . "' ";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}	

		//$sql .= " GROUP BY a.MenuDetailId";

		$query = $this->db2->query($sql);
		
		return $query->row['total'];
	}
	
	public function getMenuItems() {

		$sql="SELECT a.MenuDetailId,b.vitemname FROM kiosk_menu_item	a,mst_item b WHERE a.iitemid=b.iitemid AND a.MenuDetailId NOT IN (SELECT MenuDetailId FROM kiosk_page_flow_header)  ORDER BY b.vitemname ";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
	public function getMenuItemsEdit() {
				
		$sql="SELECT a.MenuDetailId,b.vitemname FROM kiosk_menu_item	a,mst_item b WHERE a.iitemid=b.iitemid ORDER BY b.vitemname";
		
		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
	public function addItems($data) {
		
		$old_items= array();
		$new_items= array();
		$dif_items= array();
		
		if(count($data) > 0)
		{
			$quer=$this->db2->query("SELECT * FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($data['MenuId']) . "'AND  CategoryId = '" . (int)$data['CategoryId'] . "'");
			$rows_old = $quer->rows;
			
			if(count($rows_old) > 0 )
			{
				foreach($rows_old as $ro)
				{
					$old_items[]=$ro['iitemid'];	
				}
			}
				
			$items = explode(",",$data['right_itemsadded']);
			$new_items = $items;
			
			$i=1;
			
			/*$res = $this->db2->query("SELECT max(DisplayPosition) as position FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($data['MenuId']) . "' AND  CategoryId = '" . (int)$data['CategoryId'] . "' AND SID = '" . (int)($this->session->data['SID'])."'");
			
			if(count($res) > 0)
			{
				$position = $res->row['position']+1;	
			}*/
			$position= 1;
			foreach($items as $item)
			{	
				$quer1=$this->db2->query("SELECT * FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($data['MenuId']) . "'AND  CategoryId = '" . (int)$data['CategoryId'] . "' AND iitemid = '" . (int)($item) . "'");
				$rows_qur1 = $quer1->row;

				if(isset($rows_qur1['iitemid']) && $rows_qur1['iitemid']!='' && $rows_qur1['iitemid'] == $item)
				{
					$this->db2->query("UPDATE kiosk_menu_item SET `Price` = '" . $this->db->escape($data['price'][$i]) . "',`DisplayPosition` = '" . (int)($position) . "' WHERE `MenuId` = '" . (int)($data['MenuId']) . "' AND CategoryId = '" . (int)$data['CategoryId'] . "' AND iitemid = '" . (int)($item) . "'");
				}else
				{ 
					$this->db2->query("INSERT INTO kiosk_menu_item SET `MenuId` = '" . (int)($data['MenuId']) . "', CategoryId = '" . (int)$data['CategoryId'] . "',iitemid = '" . (int)($item) . "', DisplayPosition = '" . (int)($position) . "',`Price` = '" . $this->db->escape($data['price'][$i]) . "',SID = '" . (int)($this->session->data['SID'])."'");
				}				
				$i++;
				$position++;
			}
			
			$diff=array_diff($old_items,$new_items);
			
			if(count($diff) > 0)
			{
				foreach($diff as $dif)
				{
					$query = $this->db2->query("SELECT MenuDetailId FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($data['MenuId']) . "' AND CategoryId = '" . (int)$data['CategoryId'] . "' AND iitemid = '" . (int)($dif) . "'");					
					$row1 = $query->row;
					
					if(count($row1) > 0)
					{						
						$query = $this->db2->query("SELECT PageFlowHeaderId from kiosk_page_flow_header where MenuDetailId=".$row1['MenuDetailId']);
						
						foreach($query->rows as $row)
						{
							$this->db2->query("INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_header',TableId='".$row['PageFlowHeaderId']."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'");					
						}
						
						$this->db2->query("DELETE FROM kiosk_page_flow_header WHERE `MenuDetailId` = '" . (int)($row1['MenuDetailId']) . "'");
						
						$this->db2->query("INSERT INTO mst_delete_table SET TableName='kiosk_menu_item',TableId='".$row1['MenuDetailId']."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'");
						
						$this->db2->query("DELETE FROM kiosk_menu_item WHERE `MenuId` = '" . (int)($data['MenuId']) . "' AND CategoryId = '" . (int)$data['CategoryId'] . "' AND iitemid = '" . (int)($dif) . "'");
					}
				}//end for loop
			}//end dif count
		}
		//exit;
		//$this->cache->delete('page_flow');	
		
		//return;	
	}
	
	public function updatePageFlow($MenuDetailId, $data) {//print_r($data);exit;
		
		$this->db2->query("UPDATE kiosk_menu_item SET `MenuId`='".$data['MenuId']."',`CategoryId`='".$data['CategoryId']."',`iitemid`='".$data['iitemid']."' ,`Price` = '" . $this->db->escape($data['Price']) . "' WHERE `MenuDetailId` = '" . (int)($data['MenuDetailId']) . "'");

		$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$MenuDetailId." AND PageId > 5 ORDER BY PageFlowHeaderId";		
		$query = $this->db2->query($sql);
		$rows = $query->rows;

		$str='';
		$PrevPage=0;
		$NextPage=0;
		$flowheader_array_new=array();
		
		$j=1;
		if(isset($data['pageflow']) && $data['pageflow']!='')
		{
			for($i=0;$i < count($data['pageflow']);$i++)
			{
				if($data['pageflow'][$i]['PageId']!='' && isset($data['pageflow'][$i]["PageId"]) && $data['pageflow'][$i]['PageId']!=0)
				//if($data['pageflow'][$i]['PageId']!='' && isset($data['pageflow'][$i]["PageId"]))
				{	
					if($i!=count($data['pageflow']) && isset($data['pageflow'][$i+1]["PageId"]))
					{
						$NextPage = $data['pageflow'][$i+1]["PageId"];	
					}else{
						$NextPage='5';
					}
						
					if(isset($rows[$i]['PageFlowHeaderId']) && $rows[$i]['PageFlowHeaderId']!="")
					{
						$sql ="UPDATE kiosk_page_flow_header SET  PageId = '" . (int)($data['pageflow'][$i]['PageId']) . "',`ReceiptPrintSeq` = '" . (int)($j). "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = '" . $this->db->escape($data['pageflow'][$i]['Action']) . "',NextPage = '" . (int)($NextPage) . "',FreeTopingsCt = '" . $this->db->escape($data['pageflow'][$i]['FreeTopingsCt']) . "',SID = '" . (int)($this->session->data['SID'])."' WHERE  PageFlowHeaderId=".$rows[$i]['PageFlowHeaderId'];
					}
					else
					{
						$sql ="INSERT INTO kiosk_page_flow_header SET  PageId = '" . (int)($data['pageflow'][$i]['PageId']) . "',`ReceiptPrintSeq` = '" . (int)($j). "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = '" . $this->db->escape($data['pageflow'][$i]['Action']) . "',NextPage = '" . (int)($NextPage) . "',FreeTopingsCt = '" . $this->db->escape($data['pageflow'][$i]['FreeTopingsCt']) . "',SID = '" . (int)($this->session->data['SID'])."'";
					}
					//echo $sql."<br>";
					$this->db2->query($sql);
					
	//				$str.=' '.$rows[$i]['PageFlowHeaderId'].",";
	//				$str.=' '.$data['pageflow'][$i]["PageId"].",";
	//				$str.=' '.$j.",";
	//				$str.=' '.$data["MenuDetailId"].",";
	//				$str.=' '.$PrevPage.",";
	//				$str.=' '.$data['pageflow'][$i]["Action"].",";
	//				$str.=' '.$NextPage.",";
	//				$str.=' '.$data['pageflow'][$i]["FreeTopingsCt"]."<br>";			
					//$str.="<br>";
					
				}
				$PrevPage=$data['pageflow'][$i]["PageId"];
				if(isset($rows[$i]['PageFlowHeaderId']) && $rows[$i]['PageFlowHeaderId']!=""){
					$flowheader_array_new[]=$rows[$i]['PageFlowHeaderId'];			
				}else{
					$flowheader_array_new[]='';
				}$j++;
			}
		}
		if($NextPage == 5 && isset($NextPage))
		{
			$PrevPage=$data['pageflow'][$i-1]["PageId"];
			
			//$str.=' '.($rows[$i-1]['PageFlowHeaderId']+1).",";
//			$str.=' 5,';
//			$str.=' '.($j).",";
//			$str.=' '.$data["MenuDetailId"].",";
//			$str.=' '.$PrevPage.",";
//			$str.=' Single,';
//			$str.='0,';
//			$str.=' 0'."<br>";			
//			$str.="<br>";
			//$str.=' '.($rows[$i]['PageFlowHeaderId']+1).",";
			//$a=($rows[$i-1]['PageFlowHeaderId']+1);
			
			$sql="SELECT PageFlowHeaderId FROM kiosk_page_flow_header WHERE MenuDetailId=".$data["MenuDetailId"]." AND PageId = 5";		
			$query = $this->db2->query($sql);
			$row = $query->row;
		
		//echo $row['PageFlowHeaderId'];
			if(count($row) > 0)
			{
				$sql ="UPDATE kiosk_page_flow_header SET  PageId = '5',`ReceiptPrintSeq` = '" . (int)($j). "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = 'Single',NextPage = '0',FreeTopingsCt = '0',SID = '" . (int)($this->session->data['SID'])."' WHERE PageFlowHeaderId=".$row['PageFlowHeaderId'];
			}
			else
			{
				$sql ="INSERT INTO kiosk_page_flow_header SET  PageId = '5',`ReceiptPrintSeq` = '" . (int)($j). "', MenuDetailId = '" . (int)$data['MenuDetailId'] . "',PrevPage = '" . (int)($PrevPage) . "',Action = 'Single',NextPage = '0',FreeTopingsCt = '0',SID = '" . (int)($this->session->data['SID'])."'";
			}
			//echo "<br>".$sql."<br>";
			$this->db2->query($sql);
		}
		
		$flowheader_array_old = array();
		
//		$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$MenuDetailId."  ORDER BY PageFlowHeaderId";		
//		$query = $this->db2->query($sql);
//		$rows = $query->rows;

		foreach($rows as $row)
		{
			$flowheader_array_old[] = $row['PageFlowHeaderId'];	
		}
		//print_r($flowheader_array_old);
		//print_r($flowheader_array_new);
		
		$del_PageFlowHeaderId=array_diff($flowheader_array_old,$flowheader_array_new);
		
		//print_r($del_PageFlowHeaderId);
		if(count($del_PageFlowHeaderId) > 0)
		{
			foreach($del_PageFlowHeaderId as $pgid)
			{
				if($pgid!='' && $pgid!=0){
					
					$query = $this->db2->query("SELECT count(*) as tot FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$this->session->data['db_database2']."') AND (TABLE_NAME = 'mst_delete_table')");
						
					if($query->row['tot']==1)
					{
						$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_header',TableId='".$pgid."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
						$this->db2->query($sql);
					}
					$sql="DELETE FROM kiosk_page_flow_header WHERE PageFlowHeaderId='".$pgid."'";	
					$this->db2->query($sql);
				}
			}
		}
		else
		{
//			$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$MenuDetailId."  ORDER BY PageFlowHeaderId";		
//			$query = $this->db2->query($sql);
//			$rows = $query->rows;
			
			//echo $data['pageflow'][0]['PageId'];
			//print_r($rows);
		}
		//echo $str;
		//exit;
		$this->cache->delete('page_flow');
	}
	
	public function CopyPageFlowToOtherAllPages($MenuDetailId,$data){
		
		$MenuId= $data['filter_menuid'];
		$CategoryId= $data['filter_categoryid'];
		
		$sql="SELECT MenuDetailId FROM kiosk_menu_item WHERE MenuId=".$MenuId." AND CategoryId=".$CategoryId." AND MenuDetailId !=".$MenuDetailId;
		$query1 = $this->db2->query($sql);
		$rows1 = $query1->rows;
		
		if(count($rows1) > 0)
		{
			$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$MenuDetailId;		
			$query2 = $this->db2->query($sql);
			$rows2 = $query2->rows;
			//print_r($rows2);
			//echo "<br>";
			
			$flowheader_array_old=array();
			$flowheader_array_new=array();
			
			foreach($rows1 as $row)
			{
				$sql="SELECT * FROM kiosk_page_flow_header WHERE MenuDetailId=".$row['MenuDetailId'];		
				$query = $this->db2->query($sql);
				$rows = $query->rows;
				
				foreach($rows as $rw)
				{
					$flowheader_array_old[] = $rw['PageFlowHeaderId'];
				}
				//echo "<br>";				
				//print_r($flowheader_array_old);
				//echo "<br><br>";
				$i=0;
				foreach($rows2 as $val2)
				{
					if(isset($rows[$i]['PageFlowHeaderId']))
					{
						$flowheader_array_new[] = $rows[$i]['PageFlowHeaderId'];
						//echo $rows[$i]['PageFlowHeaderId'].",";
						$sql ="UPDATE kiosk_page_flow_header SET  PageId = '" . (int)($val2['PageId']) . "',`ReceiptPrintSeq` = '" . $val2['ReceiptPrintSeq']. "', MenuDetailId = '" . (int)$row['MenuDetailId'] . "',PrevPage = '" . (int)$val2['PrevPage'] . "',Action = '" . $val2['Action'] . "',NextPage = '" . (int)($val2['NextPage']) . "',FreeTopingsCt = '" . $val2['FreeTopingsCt'] . "',SID = '" . (int)($this->session->data['SID'])."' WHERE PageFlowHeaderId=".$rows[$i]['PageFlowHeaderId'];
					}
					else
					{
						$sql ="INSERT INTO kiosk_page_flow_header SET  PageId = '" . (int)($val2['PageId']) . "',`ReceiptPrintSeq` = '" . $val2['ReceiptPrintSeq']. "', MenuDetailId = '" . (int)$row['MenuDetailId'] . "',PrevPage = '" . (int)$val2['PrevPage'] . "',Action = '" . $val2['Action'] . "',NextPage = '" . (int)($val2['NextPage']) . "',FreeTopingsCt = '" . $val2['FreeTopingsCt'] . "',SID = '" . (int)($this->session->data['SID'])."'";
					}
					
					$this->db2->query($sql);					
					//echo "<br>";
					
				$i++;
				}
				//print_r($flowheader_array_new);
				//echo "<br>";
				
				$del_PageFlowHeaderId=array_diff($flowheader_array_old,$flowheader_array_new);
				if(count($del_PageFlowHeaderId) > 0)
				{
					foreach($del_PageFlowHeaderId as $pgid)
					{
						if($pgid!='' && $pgid!=0){	
						
							$query = $this->db2->query("SELECT count(*) as tot FROM information_schema.TABLES WHERE (TABLE_SCHEMA = '".$this->session->data['db_database2']."') AND (TABLE_NAME = 'mst_delete_table')");
								
							if($query->row['tot']==1)
							{
								$query2=$this->db2->query("SELECT count(*) as reccount FROM mst_delete_table WHERE TableName='kiosk_page_flow_header' AND TableId='".$pgid."' AND Action='Delete' AND SID = '" . (int)($this->session->data['SID'])."'");
								
								if($query2->row['reccount']==0)
								{
									$sql="INSERT INTO mst_delete_table SET TableName='kiosk_page_flow_header',TableId='".$pgid."',Action='Delete',SID = '" . (int)($this->session->data['SID'])."'";	
									$this->db2->query($sql);
								}
							}
							$sql="DELETE FROM kiosk_page_flow_header WHERE PageFlowHeaderId='".$pgid."'";	
							$this->db2->query($sql);
						}
					}
				}
			}
		}
	//exit;
		$this->cache->delete('page_flow');
	}
	
	public function savePageFlow($data){
		$sql="UPDATE kiosk_page_flow_header SET Action='".$this->db->escape($data['action'])."',FreeTopingsCt='".$this->db->escape($data['FreeTopingsCt'])."' WHERE PageFlowHeaderId=".(int)$data['PageFlowHeaderId'];	
		$this->db2->query($sql);
	}
	
	public function updaetItemPrice($data){
		$this->db2->query("UPDATE kiosk_menu_item SET `Price` = '" . $this->db->escape($data['Price']) . "' WHERE `MenuDetailId` = '" . (int)($data['MenuDetailId']) . "'");

	}
	
	public function UpdatePageFlowSequence($data){
		$filter_menuid = $data['filter_menuid'];
		$filter_categoryid = $data['filter_categoryid'];
		$itemseq= $data['itemseq'];
		//print_r($data);
		$i=1;
		foreach($itemseq as $seq)
		{
			$this->db2->query("UPDATE kiosk_menu_item SET `DisplayPosition` = '" . $i . "' WHERE `MenuDetailId` = '" . (int)($seq) . "'");			
			$i++;
		}		
	}
	
	public function MovepageFlow($data){
		$this->db2->query("UPDATE kiosk_menu_item SET `MenuId` = '" . (int)($data['MenuId']) . "' ,CategoryId = '" . (int)$data['CategoryId'] . "' WHERE `MenuDetailId` = '" . (int)($data['medetailid']) . "'");		
	}
}
