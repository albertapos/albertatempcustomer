<?php
class ModelAdministrationPurchaseOrder extends Model {
	
	public function addPurchaseOrder($data) {

		//$sql="INSERT INTO web_mst_item  SET  vitemtype='" .$this->db->escape($data['vitemtype']) . "',vitemcode='" . $this->db->escape($data['vbarcode']) . "',vitemname='" . $this->db->escape($data['vitemname']). "',vunitcode='" . $this->db->escape($data['vunitcode']) . "',vbarcode='" . $this->db->escape($data['vbarcode']) . "',vcategorycode='" . $this->db->escape($data['vcategorycode']) ."',vdepcode='" . $this->db->escape($data['vdepcode']). "',vsuppliercode='" . $this->db->escape($data['vsuppliercode']) . "',iqtyonhand='" . $this->db->escape($data['iqtyonhand']) . "',ireorderpoint='" . $this->db->escape($data['ireorderpoint']) . "',dcostprice='" . $this->db->escape($data['dcostprice']) . "',dunitprice='" . $this->db->escape($data['dunitprice']) . "',nlevel2='0.00',nlevel3='0.00',nlevel4='0.00',ndiscountper='0.00',vtax1='" . $this->db->escape($data['vtax1']) . "',vtax2='" . $this->db->escape($data['vtax2']) . "',vfooditem='Y',vdescription='NULL',visinventory='" . $this->db->escape($data['visinventory']) . "',vageverify='" .$this->db->escape($data['vageverify']). "',ebottledeposit='" . $this->db->escape($data['ebottledeposit']) . "',vbarcodetype='" .$this->db->escape($data['vbarcodetype']) . "',nlastcost='" . $this->db->escape($data['nlastcost']) ."',vsize='" . $this->db->escape($data['vsize']) . "',npack='1',nunitcost='" . $this->db->escape($data['nunitcost']) . "',nsellunit='" . $this->db->escape($data['nsellunit']) . "',vsequence='0',vcolorcode='None',vdiscount='" .$this->db->escape($data['vdiscount']). "',norderqtyupto='" .$this->db->escape($data['norderqtyupto']). "',dlastupdated=NOW(),SID = '" . (int)($this->session->data['SID'])."',itemimage = '" . $this->db->escape($image) . "',updatetype='Open',mstid=0,estatus =  'Active'";
      		
		//$this->db2->query($sql);
		
		//$iitemid = $this->db2->getLastId();
		//return $iitemid;
	}
	
	public function editPurchaseOrder($iitemid, $data) {


//			$sql="UPDATE web_mst_item  SET  vitemtype='" .$this->db->escape($data['vitemtype']) . "',vitemcode='" . $this->db->escape($data['vbarcode']) . "',vitemname='" . $this->db->escape($data['vitemname']). "',vunitcode='" . $this->db->escape($data['vunitcode']) . "',vbarcode='" . $this->db->escape($data['vbarcode']) . "',vcategorycode='" . $this->db->escape($data['vcategorycode']) ."',vdepcode='" . $this->db->escape($data['vdepcode']). "',vsuppliercode='" . $this->db->escape($data['vsuppliercode']) . "',iqtyonhand='" . $this->db->escape($data['iqtyonhand']) . "',ireorderpoint='" . $this->db->escape($data['ireorderpoint']) . "',dcostprice='" . $this->db->escape($data['dcostprice']) . "',dunitprice='" . $this->db->escape($data['dunitprice']) . "',nlevel2='0.00',nlevel3='0.00',nlevel4='0.00',ndiscountper='0.00',vtax1='" . $this->db->escape($data['vtax1']) . "',vtax2='" . $this->db->escape($data['vtax2']) . "',vfooditem='Y',vdescription='NULL',visinventory='" . $this->db->escape($data['visinventory']) . "',vageverify='" .$this->db->escape($data['vageverify']). "',ebottledeposit='" . $this->db->escape($data['ebottledeposit']) . "',vbarcodetype='" .$this->db->escape($data['vbarcodetype']) . "',nlastcost='" . $this->db->escape($data['nlastcost']) ."',vsize='" . $this->db->escape($data['vsize']) . "',npack='1',nunitcost='" . $this->db->escape($data['nunitcost']) . "',nsellunit='" . $this->db->escape($data['nsellunit']) . "',vsequence='0',vcolorcode='None',vdiscount='" .$this->db->escape($data['vdiscount']). "',norderqtyupto='" .$this->db->escape($data['norderqtyupto']). "',dlastupdated=NOW(),SID = '" . (int)($this->session->data['SID'])."',itemimage = '" . $this->db->escape($image) . "',estatus =  'Active',updatetype='Open' WHERE mstid='" . (int)$iitemid . "'";
//		
//		$this->db2->query($sql);
//		
//		$iitemid = $this->db2->getLastId();
//		$this->cache->delete('items');
	}
	
	public function deletePurchaseOrderItems($iitemid) {

//		$this->db2->query("DELETE FROM web_mst_item WHERE iitemid = '" . (int)$iitemid . "'");
//
//		$this->cache->delete('category');
	}
	
	public function getPurchaseOrders($data = array()) {
		$sql = "SELECT a.*,DATE_FORMAT(a.dcreatedate,'%m-%d-%Y %h:%i %p') as dcreatedate,DATE_FORMAT(a.dreceiveddate,'%m-%d-%Y %h:%i %p') as dreceiveddate,DATE_FORMAT(a.LastUpdate,'%m-%d-%Y %h:%i %p') as LastUpdate FROM  trn_purchaseorder a";

		$implode = array();

		if (!empty($data['searchbox'])) {
			$implode[] = " a.ipoid LIKE '%" . $this->db->escape($data['searchbox']) . "%' ";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'ipoid',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY a.ipoid";
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
	
	public function getTotalPurchaseOrders() {
		
		$query = $this->db2->query("SELECT COUNT(*) AS total FROM trn_purchaseorder");

		return $query->row['total'];
	}
	
	public function getVendors() {
		
		$query = $this->db2->query("SELECT * FROM mst_supplier");

		return $query->rows;
	}
	
	public function getVendorsByCode($vsuppliercode) {
		
		$query = $this->db2->query("SELECT * FROM mst_supplier WHERE vsuppliercode=".$vsuppliercode);

		return $query->row;
	}
	
	public function getStoreById() {
		
		$query = $this->db2->query("SELECT * FROM mst_store WHERE SID=".$this->session->data['SID']);
		return $query->row;
	}
}
