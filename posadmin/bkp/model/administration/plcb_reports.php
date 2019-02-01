<?php
class ModelAdministrationPlcbReports extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getBuckets() {
		$sql = "SELECT * FROM mst_item_bucket";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMstPlcbItems() {
		$sql = "SELECT * FROM mst_plcb_item mpi LEFT JOIN mst_item_size mis ON mpi.item_id=mis.item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getMstPlcbItemDetails() {
		$sql = "SELECT * FROM mst_plcb_item_detail mpid LEFT JOIN mst_plcb_item mpi ON mpi.item_id=mpid.plcb_item_id LEFT JOIN mst_item_size mis ON mis.item_id=mpid.plcb_item_id LEFT JOIN mst_item_bucket mib ON mib.id=mpi.bucket_id LEFT JOIN mst_supplier ms ON ms.isupplierid=mpid.supplier_id";

		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
}
