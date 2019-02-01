<?php
class ModelAdministrationTransfer extends Model {

	public function getRightItems($data = array()) {

		$return = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,iqtyonhand,npack FROM mst_item WHERE iitemid IN($item_ids) AND estatus='Active'");
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

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,iqtyonhand,npack FROM mst_item WHERE iitemid NOT IN($item_ids) AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,iqtyonhand,npack FROM mst_item WHERE estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditLeftItems($data = array(), $vendor_id) {

		$return = array();
		$data = array();

		if(count($data) > 0){

			$item_ids = implode(',', $data);

			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,iqtyonhand FROM mst_item WHERE iitemid NOT IN($item_ids) AND vsuppliercode='". $vendor_id ."' AND estatus='Active'");
			$return = $query->rows;
		}else{
			$query = $this->db2->query("SELECT iitemid,vbarcode,vitemname,iqtyonhand FROM mst_item WHERE vsuppliercode='". $vendor_id ."' AND estatus='Active'");
			$return = $query->rows;
		}
		return $return;
	}

	public function getEditRightItems($data = array(),$vtransfertype,$vendor_id) {

		$return = array();
		if(count($data) > 0){

			$item_ids = implode(',', $data);

			if($vtransfertype == 'WarehouseToStore'){
				// $query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.iqtyonhand,twhi.vwhcode,twhi.vvendorid,twhi.dreceivedate,twhi.nitemqoh,twhi.npackqty,twhi.estatus,twhi.estatus,twhi.vvendortype,twhi.vtransfertype,twhi.vsize,twhi.ntransferqty,twhin.vinvnum,twqoh.onhandcaseqty as onhandcaseqty FROM mst_item as mi,trn_warehouseinvoice as twhin, trn_warehouseitems as twhi LEFT JOIN trn_warehouseqoh as twqoh ON(twhi.vvendorid=twqoh.ivendorid AND twhi.vbarcode=twqoh.vbarcode)  WHERE mi.vbarcode=twhi.vbarcode AND twhi.invoiceid=twhin.vinvnum AND twhi.vtransfertype='" . $vtransfertype . "' AND twhi.vvendorid='" . (int)$vendor_id . "'");
				$query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.iqtyonhand,mi.npack as npackqty, mi.vsize as vsize ,mi.vsuppliercode,twqoh.onhandcaseqty as onhandcaseqty FROM mst_item as mi ,trn_warehouseqoh as twqoh WHERE mi.vbarcode=twqoh.vbarcode AND mi.estatus='Active' AND twqoh.ivendorid='" . (int)$vendor_id . "' AND twqoh.onhandcaseqty > 0");

			}else{
				$query = $this->db2->query("SELECT mi.iitemid,mi.vbarcode,mi.vitemname,mi.iqtyonhand,twhi.vwhcode,twhi.vvendorid,twhi.dreceivedate,twhi.nitemqoh,twhi.npackqty,twhi.estatus,twhi.estatus,twhi.vvendortype,twhi.vtransfertype,twhi.vsize,twhi.ntransferqty FROM mst_item as mi,trn_warehouseitems as twhi WHERE mi.vbarcode=twhi.vbarcode AND mi.estatus='Active' AND mi.iitemid IN($item_ids) AND twhi.vtransfertype='" . $vtransfertype . "' AND twhi.vvendorid='" . (int)$vendor_id . "'");
			}

			$return = $query->rows;
		}
		return $return;
	}

	public function getPrevRightItemIds($datas = array()) {

		$return = array();

		if(count($datas) > 0){
			foreach($datas as $data){
			$return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE vbarcode='" . $this->db->escape($data['vbarcode']) . "' AND vitemname='" . $this->db->escape($data['vitemname']) . "' AND estatus='Active'")->row;
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

	public function getVendors() {

		$query = $this->db2->query("SELECT * FROM mst_supplier ");
			
		return $query->rows;
	}

}
