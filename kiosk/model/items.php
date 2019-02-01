<?php
class ModelKioskItems extends Model {
	public function addItems($data) {

		if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($data['image']);
		}
		
		$sql="INSERT INTO web_mst_item  SET  vitemtype='" .$this->db->escape($data['vitemtype']) . "',vitemcode='" . $this->db->escape($data['vbarcode']) . "',vitemname='" . $this->db->escape($data['vitemname']). "',vunitcode='" . $this->db->escape($data['vunitcode']) . "',vbarcode='" . $this->db->escape($data['vbarcode']) . "',vcategorycode='" . $this->db->escape($data['vcategorycode']) ."',vdepcode='" . $this->db->escape($data['vdepcode']). "',vsuppliercode='" . $this->db->escape($data['vsuppliercode']) . "',iqtyonhand='" . $this->db->escape($data['iqtyonhand']) . "',ireorderpoint='" . $this->db->escape($data['ireorderpoint']) . "',dcostprice='" . $this->db->escape($data['dcostprice']) . "',dunitprice='" . $this->db->escape($data['dunitprice']) . "',nlevel2='0.00',nlevel3='0.00',nlevel4='0.00',ndiscountper='0.00',vtax1='" . $this->db->escape($data['vtax1']) . "',vtax2='" . $this->db->escape($data['vtax2']) . "',vfooditem='Y',vdescription='NULL',visinventory='" . $this->db->escape($data['visinventory']) . "',vageverify='" .$this->db->escape($data['vageverify']). "',ebottledeposit='" . $this->db->escape($data['ebottledeposit']) . "',vbarcodetype='" .$this->db->escape($data['vbarcodetype']) . "',nlastcost='" . $this->db->escape($data['nlastcost']) ."',vsize='" . $this->db->escape($data['vsize']) . "',npack='1',nunitcost='" . $this->db->escape($data['nunitcost']) . "',nsellunit='" . $this->db->escape($data['nsellunit']) . "',vsequence='0',vcolorcode='None',vdiscount='" .$this->db->escape($data['vdiscount']). "',norderqtyupto='" .$this->db->escape($data['norderqtyupto']). "',dlastupdated=NOW(),SID = '" . (int)($this->session->data['SID'])."',itemimage = '" . $this->db->escape($image) . "',updatetype='Open',mstid=0,estatus =  'Active',stationid='" . (int)($data['stationid'])."'";
      		
		$this->db2->query($sql);
		
		$iitemid = $this->db2->getLastId();
		
		//$this->db2->query("UPDATE web_mst_item SET vitemcode='" . (int)$iitemid . "',vbarcode='" . (int)$iitemid . "' WHERE iitemid=".$iitemid);

		$this->cache->delete('items');

		return $iitemid;
	}
	
	public function editItems($iitemid, $data) {

		if(is_file(DIR_IMAGE.$this->db->escape($data['image'])))
		{
			$fp = fopen(DIR_IMAGE.$this->db->escape($data['image']), 'rb');
			$image = file_get_contents(DIR_IMAGE.$this->db->escape($data['image']));
		}else{
			$image = base64_decode($data['image']);
		}		
		
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM web_mst_item WHERE vitemtype='Kiosk' AND mstid=".$iitemid);
		
		if($query->row['total']==0)
		{
			$sql="INSERT INTO web_mst_item  SET  vitemtype='" .$this->db->escape($data['vitemtype']) . "',vitemcode='" . $this->db->escape($data['vbarcode']) . "',vitemname='" . $this->db->escape($data['vitemname']). "',vunitcode='" . $this->db->escape($data['vunitcode']) . "',vbarcode='" . $this->db->escape($data['vbarcode']) . "',vcategorycode='" . $this->db->escape($data['vcategorycode']) ."',vdepcode='" . $this->db->escape($data['vdepcode']). "',vsuppliercode='" . $this->db->escape($data['vsuppliercode']) . "',iqtyonhand='" . $this->db->escape($data['iqtyonhand']) . "',ireorderpoint='" . $this->db->escape($data['ireorderpoint']) . "',dcostprice='" . $this->db->escape($data['dcostprice']) . "',dunitprice='" . $this->db->escape($data['dunitprice']) . "',nlevel2='0.00',nlevel3='0.00',nlevel4='0.00',ndiscountper='0.00',vtax1='" . $this->db->escape($data['vtax1']) . "',vtax2='" . $this->db->escape($data['vtax2']) . "',vfooditem='Y',vdescription='NULL',visinventory='" . $this->db->escape($data['visinventory']) . "',vageverify='" .$this->db->escape($data['vageverify']). "',ebottledeposit='" . $this->db->escape($data['ebottledeposit']) . "',vbarcodetype='" .$this->db->escape($data['vbarcodetype']) . "',nlastcost='" . $this->db->escape($data['nlastcost']) ."',vsize='" . $this->db->escape($data['vsize']) . "',npack='1',nunitcost='" . $this->db->escape($data['nunitcost']) . "',nsellunit='" . $this->db->escape($data['nsellunit']) . "',vsequence='0',vcolorcode='None',vdiscount='" .$this->db->escape($data['vdiscount']). "',norderqtyupto='" .$this->db->escape($data['norderqtyupto']). "',dlastupdated=NOW(),SID = '" . (int)($this->session->data['SID'])."',itemimage = '" . $this->db->escape($image) . "',estatus =  'Active',updatetype='Open',stationid='" . (int)($data['stationid'])."',mstid=".(int)$iitemid ;
		}
		else
		{
			$sql="UPDATE web_mst_item  SET  vitemtype='" .$this->db->escape($data['vitemtype']) . "',vitemcode='" . $this->db->escape($data['vbarcode']) . "',vitemname='" . $this->db->escape($data['vitemname']). "',vunitcode='" . $this->db->escape($data['vunitcode']) . "',vbarcode='" . $this->db->escape($data['vbarcode']) . "',vcategorycode='" . $this->db->escape($data['vcategorycode']) ."',vdepcode='" . $this->db->escape($data['vdepcode']). "',vsuppliercode='" . $this->db->escape($data['vsuppliercode']) . "',iqtyonhand='" . $this->db->escape($data['iqtyonhand']) . "',ireorderpoint='" . $this->db->escape($data['ireorderpoint']) . "',dcostprice='" . $this->db->escape($data['dcostprice']) . "',dunitprice='" . $this->db->escape($data['dunitprice']) . "',nlevel2='0.00',nlevel3='0.00',nlevel4='0.00',ndiscountper='0.00',vtax1='" . $this->db->escape($data['vtax1']) . "',vtax2='" . $this->db->escape($data['vtax2']) . "',vfooditem='Y',vdescription='NULL',visinventory='" . $this->db->escape($data['visinventory']) . "',vageverify='" .$this->db->escape($data['vageverify']). "',ebottledeposit='" . $this->db->escape($data['ebottledeposit']) . "',vbarcodetype='" .$this->db->escape($data['vbarcodetype']) . "',nlastcost='" . $this->db->escape($data['nlastcost']) ."',vsize='" . $this->db->escape($data['vsize']) . "',npack='1',nunitcost='" . $this->db->escape($data['nunitcost']) . "',nsellunit='" . $this->db->escape($data['nsellunit']) . "',vsequence='0',vcolorcode='None',vdiscount='" .$this->db->escape($data['vdiscount']). "',norderqtyupto='" .$this->db->escape($data['norderqtyupto']). "',dlastupdated=NOW(),SID = '" . (int)($this->session->data['SID'])."',itemimage = '" . $this->db->escape($image) . "',estatus =  'Active',updatetype='Open',stationid='" . (int)($data['stationid'])."' WHERE mstid='" . (int)$iitemid . "'";
		}
		
		$this->db2->query($sql);
		
		$iitemid = $this->db2->getLastId();
		$this->cache->delete('items');
	}
	
	public function deleteItems($iitemid) {

		$this->db2->query("DELETE FROM web_mst_item WHERE iitemid = '" . (int)$iitemid . "'");

		$this->cache->delete('category');
	}

	public function getwebItem($iitemid) {
		//$query = $this->db2->query("SELECT a.*,b.iitemgroupid FROM mst_item a,itemgroupdetail b WHERE a.iitemid = '" . (int)$iitemid . "' AND a.vbarcode=b.vsku");
		//$query = $this->db2->query("SELECT a.*,b.iitemgroupid FROM mst_item a LEFT JOIN itemgroupdetail b ON a.vbarcode=b.vsku WHERE a.iitemid = '" . (int)$iitemid . "'");
		$query = $this->db2->query("SELECT a.* FROM mst_item a  WHERE a.iitemid = '" . (int)$iitemid . "' AND  vitemtype='Kiosk'");
		
		return $query->row;
	}
	
	public function getTotalItems($data = array()) {
		$sql="SELECT COUNT(*) AS total FROM mst_item WHERE vitemtype='Kiosk'";
		
		$implode = array();

		if (!empty($data['searchbox'])) {
			$implode[] = " vitemname LIKE '%" . $this->db->escape($data['searchbox']) . "%' ";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$query = $this->db2->query($sql);

		return $query->row['total'];
	}
	
	public function getWebItems($data = array()) {
		$sql = "SELECT * FROM  mst_item WHERE vitemtype='Kiosk'";

		$implode = array();

		if (!empty($data['searchbox'])) {
			$implode[] = " vitemname LIKE '%" . $this->db->escape($data['searchbox']) . "%' ";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'iitemid',
			'vitemname'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY iitemid";
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
	
	public function getItems($data = array()) {
		$sql = "SELECT iitemid,vitemtype,vitemcode,vitemname FROM mst_item WHERE vitemtype='Kiosk' AND estatus='Active'";

		if (!empty($data['auto_item_search'])) {
			$sql .= " AND vitemname LIKE '%" . $this->db->escape($data['auto_item_search']) . "%'";
		}

		$sort_data = array(
			'vitemname',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY vitemname";
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
	
	public function getUnit() {
		$query = $this->db2->query("SELECT * FROM mst_unit WHERE estatus = 'Active'");

		return $query->rows;
	}
	
	public function getDepartment() {
		$query = $this->db2->query("SELECT * FROM mst_department WHERE estatus = 'Active'");

		return $query->rows;
	}
	
	public function getSize() {
		$query = $this->db2->query("SELECT * FROM mst_size");

		return $query->rows;
	}
	
	public function getSupplier() {
		$query = $this->db2->query("SELECT * FROM mst_supplier WHERE estatus = 'Active'");

		return $query->rows;
	}
	
	public function getCategorys() {
		$query = $this->db2->query("SELECT * FROM mst_category WHERE estatus = 'Active'");

		return $query->rows;
	}
	
	public function getAgeverification() {
		$query = $this->db2->query("SELECT * FROM mst_ageverification");

		return $query->rows;
	}
	
	public function getItemgroup() {
		$query = $this->db2->query("SELECT * FROM itemgroup");

		return $query->rows;
	}
	
	public function getColor() {
		//$query = $this->db2->query("SELECT * FROM mst_ageverification");

		//return $query->rows;
	}
	
	public function getStations() {
		$query = $this->db2->query("SELECT * FROM mst_station");

		return $query->rows;
	}
	
}
