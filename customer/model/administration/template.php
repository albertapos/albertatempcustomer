<?php
class ModelAdministrationTemplate extends Model {

	public function getRightItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vitemcode,vitemname FROM mst_item WHERE iitemid IN($item_ids) AND estatus='Active'");
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

			$query = $this->db2->query("SELECT iitemid,vitemcode,vitemname FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vitemcode,vitemname FROM mst_item WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditLeftItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vitemcode,vitemname FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vitemcode,vitemname FROM mst_item WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditRightItems($data = array(),$itemplateid) {

		$return = array();
		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mtd.isequence FROM mst_item as mi,mst_templatedetail as mtd WHERE mi.estatus='Active' AND mi.vitemcode=mtd.vitemcode AND mtd.itemplateid='" . (int)$itemplateid."' AND mi.iitemid IN($item_ids) ORDER BY mtd.isequence ASC");
			$return = $query->rows;
		}
		return $return;
	}

	public function getPrevRightItemIds($datas = array()) {

		$return = array();

		if(count($datas) > 0){
			foreach($datas as $data){
			$return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE estatus='Active' AND vitemcode='" . $this->db->escape($data['vitemcode']) . "'")->row;
			}
		}
		$item_arr = array();
		foreach ($return as  $v) {
			$item_arr[] = $v['iitemid'];
		}
		
		return $item_arr;
	}

}
