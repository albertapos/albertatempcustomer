<?php
class ModelAdministrationGroupSlabPricing extends Model {

	public function getRightItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice FROM mst_item WHERE iitemid IN($item_ids)");
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

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice FROM mst_item WHERE iitemid NOT IN($item_ids)");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice FROM mst_item");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditLeftItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice FROM mst_item WHERE iitemid NOT IN($item_ids)");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,nsaleprice FROM mst_item");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditRightItems($data = array(),$iitemgroupid,$vtype) {

		$return = array();
		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.nsaleprice,mid.isequence FROM mst_item as mi,itemgroupdetail as mid WHERE mi.vbarcode=mid.vsku AND mid.vtype='" . $vtype."' AND mid.iitemgroupid='" . (int)$iitemgroupid."' AND mi.iitemid IN($item_ids)");
			$return = $query->rows;
		}
		return $return;
	}

	public function getPrevRightItemIds($datas = array()) {

		$return = array();

		if(count($datas) > 0){
			foreach($datas as $data){
			$return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE vbarcode='" . $this->db->escape($data['vsku']) . "'")->row;
			}
		}
		$item_arr = array();
		foreach ($return as  $v) {
			$item_arr[] = $v['iitemid'];
		}
		
		return $item_arr;
	}

	public function addGroup($datas = array()) {

			if(isset($datas) && count($datas) > 0){
				$this->db2->query("INSERT INTO itemgroup SET  vitemgroupname = '" . $this->db->escape($datas['vitemgroupname']) . "',SID = '" . (int)($this->session->data['sid'])."'");

				$iitemgroupid = $this->db2->getLastId();

				if(isset($datas['items']) && count($datas['items']) > 0){

					foreach ($datas['items'] as $key => $data) {
						$this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$iitemgroupid . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($datas['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
					}

				}
			}
	}

	public function editlistGroup($datas = array()) {

			if(isset($datas) && count($datas) > 0){
				$this->db2->query("UPDATE itemgroup SET  vitemgroupname = '" . $this->db->escape($datas['vitemgroupname']) . "' WHERE iitemgroupid = '" . (int)$this->db->escape($datas['iitemgroupid'])."'");

				if(isset($datas['items']) && count($datas['items']) > 0){
					$this->db2->query("DELETE FROM itemgroupdetail WHERE iitemgroupid='" . (int)$this->db->escape($datas['iitemgroupid']) . "' AND vtype='" . $this->db->escape($datas['vtype']) . "' ");

					foreach ($datas['items'] as $key => $data) {
						$this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($datas['iitemgroupid']) . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($datas['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
					}

				}
			}
	}

}
