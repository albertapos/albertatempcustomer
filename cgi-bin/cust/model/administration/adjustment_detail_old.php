<?php
class ModelAdministrationAdjustmentDetail extends Model {

	public function getRightItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,npack,nunitcost FROM mst_item WHERE iitemid IN($item_ids) AND estatus='Active'");
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

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditLeftItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditRightItems($data = array(),$ipiid) {

		$return = array();
		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,tpid.vunitcode,tpid.vunitname,tpid.ndebitqty,tpid.ncreditqty,tpid.ndebitunitprice,tpid.ncrediteunitprice,tpid.nordtax,tpid.ndebitextprice,tpid.ncrditextprice,tpid.ndebittextprice,tpid.ncredittextprice,tpid.ndiffqty,tpid.vreasoncode,tpid.vvendoritemcode,tpid.npackqty,tpid.nunitcost,tpid.itotalunit FROM mst_item as mi,trn_physicalinventorydetail as tpid WHERE mi.estatus='Active' AND mi.iitemid=tpid.vitemid AND tpid.ipiid='" . (int)$ipiid."' AND mi.iitemid IN($item_ids)");
			$return = $query->rows;
		}
		return $return;
	}

	public function getPrevRightItemIds($datas = array()) {

		$return = array();

		if(count($datas) > 0){
			foreach($datas as $data){
			$return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE iitemid='" . $this->db->escape($data['vitemid']) . "' AND estatus='Active'")->row;
			}
		}
		$item_arr = array();
		if(count($return)){
    		foreach ($return as  $v) {
                if(isset($v['iitemid'])){
    			 $item_arr[] = $v['iitemid'];
                }
            }
		}
		
		return $item_arr;
	}

	public function getReasons() {

		$query = $this->db2->query("SELECT * FROM mst_adjustmentreason ");
		
		return $query->rows;
	}

	public function getSearchItems($data = array()) {

    	$item_ids = implode(',', $data['right_items']);

    	if(isset($data['search_by']) && $data['search_by'] == 'vbarcode'){
    		if($item_ids != ''){
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE vbarcode LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active' AND iitemid NOT IN($item_ids)");
    		}else{
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE vbarcode LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active'");
    		}
    		
    	}else{
    		if($item_ids != ''){
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active' AND iitemid NOT IN($item_ids)");
    		}else{
    			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($data['search_val']). "%' AND estatus='Active'");
    		}
    	}

        return $query->rows;
    }

}
