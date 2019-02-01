<?php
class ModelApiZeroMovementReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getZeroMovementReport($data) {
		if(in_array('ALL', $data['report_data'])){
			$vdepcodes = 'ALL';
		}else{
			$vdepcodes = implode(',', $data['report_data']);
		}

		$query = $this->db2->query("CALL rp_webzeroitemmovement('".$vdepcodes."','" . $data['start_date'] . "','".$data['end_date']."')");

		return $query->rows;
	}

	public function ajaxDataZeroMovementReport($data) {

		$query_dep = $this->db2->query("SELECT vdepcode FROM mst_department WHERE vdepartmentname='". $data['report_pull_by'] ."'")->row;

		$vdepcodes = $query_dep['vdepcode'];

		$query = $this->db2->query("CALL rp_webzeroitemmovement('".$vdepcodes."','" . $data['start_date'] . "','".$data['end_date']."')");

		return $query->rows;
	}

	public function getCategoriesReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$vcategorycodes = 'ALL';

			$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";

		}else{
			$vcategorycodes = implode(',', $data['report_data']);

			$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and a.vcategorycode in ($vcategorycodes) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function ajaxDataCategoryZeroMovementReport($data) {

		$query_cat = $this->db2->query("SELECT vcategorycode FROM mst_category WHERE vcategoryname='". $data['report_pull_by'] ."'")->row;

		$vcategorycodes = $query_cat['vcategorycode'];

		$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and a.vcategorycode in ($vcategorycodes) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getGroupsReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$vgroups = 'ALL';

			$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, n.vitemgroupname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,itemgroupdetail m,itemgroup n,mst_supplier c  where a.vbarcode=m.vsku and m.iitemgroupid=n.iitemgroupid and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";

		}else{
			$vgroups = implode(',', $data['report_data']);

			$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, n.vitemgroupname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,itemgroupdetail m,itemgroup n,mst_supplier c  where a.vbarcode=m.vsku and m.iitemgroupid=n.iitemgroupid and a.vsuppliercode =c.vsuppliercode and m.iitemgroupid in ($vgroups) and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function ajaxDataItemGroupZeroMovementReport($data) {

		$query_group = $this->db2->query("SELECT iitemgroupid FROM itemgroup WHERE vitemgroupname='". $data['report_pull_by'] ."'")->row;

		$vgroups = $query_group['iitemgroupid'];

		$sql = "SELECT c.vcompanyname as suppliername,a.vitemname as itemname, CASE WHEN npack = 1 or (npack is null)   then iqtyonhand else (Concat(cast((a.iqtyonhand/a.npack ) as signed), '  (' , Mod(a.iqtyonhand,a.npack) , ')') )  end as vqty, n.vitemgroupname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost, a.dUnitPrice as price,a.iqtyonhand,(select shelfname from mst_shelf d where a.shelfid=d.Id) as shelf, (select shelvingname from mst_shelving e where a.shelvingid=e.id) as shelving, (select aislename from mst_aisle f where a.aisleid=f.Id) as aisle FROM mst_item a,itemgroupdetail m,itemgroup n,mst_supplier c  where a.vbarcode=m.vsku and m.iitemgroupid=n.iitemgroupid and a.vsuppliercode =c.vsuppliercode and m.iitemgroupid in ($vgroups) and a.vitemtype != 'Kiosk' and ((a.nUnitCost*npack) > a.dUnitPrice or (a.nUnitCost*npack) < a.dUnitPrice) and vitemname is not null and a.vbarcode not in (select a.vitemcode from trn_salesdetail a,trn_sales b where a.isalesid=b.isalesid and vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('". $data['start_date'] ."','%m-%d-%Y') and str_to_date('". $data['end_date'] ."','%m-%d-%Y'))";

		$query = $this->db2->query($sql);

		return $query->rows;
	}
}
