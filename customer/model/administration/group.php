<?php
class ModelAdministrationGroup extends Model {

	public function getRightItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item WHERE iitemid IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$return['error'] = 'data not found';
		}
		return $return;
	}

	public function getLeftItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vbarcode) WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditLeftItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vbarcode) WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditRightItems($data = array(),$iitemgroupid,$vtype) {

		$return = array();
		if(count($data) > 0){

			$item_ids = implode(',', $data);

			// $query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.nsaleprice,mid.isequence FROM mst_item as mi,itemgroupdetail as mid WHERE mi.vbarcode=mid.vsku AND mid.vtype='" . $vtype."' AND mid.iitemgroupid='" . (int)$iitemgroupid."' AND mi.iitemid IN($item_ids)");
			$query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.nsaleprice,mi.dunitprice,mid.isequence FROM mst_item as mi,itemgroupdetail as mid WHERE mi.vbarcode=mid.vsku AND mid.iitemgroupid='" . (int)$iitemgroupid."' AND mi.iitemid IN($item_ids) AND mi.estatus='Active' ORDER BY mid.isequence ASC");
			$return = $query->rows;
		}
		return $return;
	}

	public function getPrevRightItemIds($datas = array()) {

		$return = array();

		if(count($datas) > 0){
			foreach($datas as $data){
			$return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE vbarcode='" . $this->db->escape($data['vsku']) . "' AND estatus='Active'")->row;
			}
		}
		$item_arr = array();
		if(count($return) > 0){
			foreach ($return as  $v) {
				if(isset($v['iitemid'])){
					$item_arr[] = $v['iitemid'];
				}
			}
		}
		
		return $item_arr;
	}

	public function addGroup($datas = array()) {

			if(isset($datas) && count($datas) > 0){
				$this->db2->query("INSERT INTO itemgroup SET  vitemgroupname = '" . $this->db->escape($datas['vitemgroupname']) . "',SID = '" . (int)($this->session->data['sid'])."'");

				$iitemgroupid = $this->db2->getLastId();

				if(isset($datas['items']) && count($datas['items']) > 0){

					foreach ($datas['items'] as $key => $data) {

						$delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'")->row;

						if(count($delete_ids) > 0){
							$this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
						}

						$this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'");

						$this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$iitemgroupid . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($datas['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
					}

				}
				return $iitemgroupid;
			}
	}

	public function editlistGroup($datas = array()) {

			if(isset($datas) && count($datas) > 0){
				$this->db2->query("UPDATE itemgroup SET  vitemgroupname = '" . $this->db->escape($datas['vitemgroupname']) . "' WHERE iitemgroupid = '" . (int)$this->db->escape($datas['iitemgroupid'])."'");

				if(isset($datas['items']) && count($datas['items']) > 0){
					foreach ($datas['items'] as $key => $data) {

						$delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'")->row;

						if(count($delete_ids) > 0){
							$this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
						}

						$this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'");

						$this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($datas['iitemgroupid']) . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($datas['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
					}

				}else{
					$delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE iitemgroupid='" . (int)$this->db->escape($datas['iitemgroupid']) . "'")->rows;

					if(count($delete_ids) > 0){
						foreach ($delete_ids as $k => $delete_id) {
							$this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_id['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

							$this->db2->query("DELETE FROM itemgroupdetail WHERE Id='" . (int)$delete_id['Id'] . "'");
						}

					}
				}
			}
	}

	public function removeItemsRight($datas = array()) {
		
		if(count($datas) > 0){

			foreach ($datas as $key => $data) {
			    
				$delete_vsku = $this->db2->query("SELECT ig.Id FROM mst_item as mi, itemgroupdetail as ig WHERE mi.vbarcode=ig.vsku AND mi.iitemid='" . (int)$this->db->escape($data) . "'")->rows;
				
				if(count($delete_vsku) > 0){
					foreach ($delete_vsku as $k => $v) {
						$this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$v['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
						$this->db2->query("DELETE FROM itemgroupdetail WHERE Id='" . (int)$v['Id'] . "'");
					}

				}
			}

		}

	}	
	
	public function deleteGroups($datas = array()) {
		
		if(count($datas) > 0){

// 			foreach ($datas as $data) {
			   
			  
				$delete_vsku = $this->db2->query("SELECT * FROM itemgroup WHERE iitemgroupid='" . (int)$this->db->escape($datas['iitemgroupid']) . "'")->rows;
				
				
				
				if(count($delete_vsku) > 0){
					foreach ($delete_vsku as $k => $v) {
						$this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroup',`Action` = 'delete',`TableId` = '" . (int)$v['iitemgroupid'] . "',SID = '" . (int)($this->session->data['sid'])."'");
						$this->db2->query("DELETE FROM itemgroup WHERE iitemgroupid='" . (int)$v['iitemgroupid'] . "'");
					}

				}
// 			}

		}

	}

	public function getlistItems() {

        $query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vbarcode) WHERE estatus='Active'");
        
        return $query->rows;
    }

    public function getSearchItems($data = array()) {

    	$item_ids = implode(',', $data['right_items']);

    	if(isset($data['search_by']) && $data['search_by'] == 'vbarcode'){
    		if($item_ids != ''){
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vbarcode) WHERE vbarcode LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active' AND iitemid NOT IN($item_ids)");
    		}else{
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vbarcode) WHERE vbarcode LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active'");
    		}
    		
    	}else{
    		if($item_ids != ''){
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vitemname) WHERE vitemname LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active' AND iitemid NOT IN($item_ids)");
    		}else{
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice,dunitprice FROM mst_item FORCE INDEX (idx_item_vitemname) WHERE vitemname LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active'");
    		}
    	}

        return $query->rows;
    }

}
