<?php
class ModelApiInventoryOnHandReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCategories() {
		$sql = "SELECT vcategorycode as id, vcategoryname as name FROM mst_category";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getItemGroupsReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$iitemgroupids = 'ALL';

			$sql = "SELECT a.nsellunit,d.vitemgroupname as search_name, d.iitemgroupid as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname, CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price, d.vitemgroupname as vname FROM itemgroupdetail e, mst_item a, mst_supplier c, itemgroup d WHERE e.vsku=a.vbarcode AND a.vsuppliercode =c.vsuppliercode and d.iitemgroupid=e.iitemgroupid and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY d.vitemgroupname ASC";
		}else{
			$iitemgroupids = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,d.vitemgroupname as search_name , d.iitemgroupid as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname, CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price, d.vitemgroupname as vname FROM itemgroupdetail e, mst_item a, mst_supplier c, itemgroup d WHERE e.vsku=a.vbarcode AND a.vsuppliercode =c.vsuppliercode and d.iitemgroupid=e.iitemgroupid and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND e.iitemgroupid IN($iitemgroupids) ORDER BY d.vitemgroupname ASC";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getItemGroupsReportAlberta($data) {

		if(in_array('ALL', $data['report_data'])){
			$iitemgroupids = 'ALL';

			$sql = "SELECT a.nsellunit,d.vitemgroupname as search_name, d.iitemgroupid as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname, CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price, d.vitemgroupname as vname FROM itemgroupdetail e, mst_item a, mst_supplier c, itemgroup d WHERE e.vsku=a.vbarcode AND a.vsuppliercode =c.vsuppliercode and d.iitemgroupid=e.iitemgroupid and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY d.vitemgroupname ASC";
		}else{
			$iitemgroupids = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,d.vitemgroupname as search_name , d.iitemgroupid as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname, CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price, d.vitemgroupname as vname FROM itemgroupdetail e, mst_item a, mst_supplier c, itemgroup d WHERE e.vsku=a.vbarcode AND a.vsuppliercode =c.vsuppliercode and d.iitemgroupid=e.iitemgroupid and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND e.iitemgroupid IN($iitemgroupids) ORDER BY d.vitemgroupname ASC";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function ajaxDataReportItemGroup($data) {

		$sql = "SELECT a.nsellunit,d.vitemgroupname as search_name , d.iitemgroupid as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname, CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price, d.vitemgroupname as vname FROM itemgroupdetail e, mst_item a, mst_supplier c, itemgroup d WHERE e.vsku=a.vbarcode AND a.vsuppliercode =c.vsuppliercode and d.iitemgroupid=e.iitemgroupid and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND e.iitemgroupid='". $this->db->escape($data['report_pull_id']) ."'";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getItemsReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$iitemids = 'ALL';

			$sql = "SELECT a.nsellunit,c.vcompanyname as suppliername, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes'";
		}else{
			$iitemids = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,c.vcompanyname as suppliername, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.iitemid in($iitemids)";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getItemsReportAlberta($data) {

		if(in_array('ALL', $data['report_data'])){
			$iitemids = 'ALL';

			$sql = "SELECT a.nsellunit,c.vcompanyname as suppliername, c.vsuppliercode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes'";
		}else{
			$iitemids = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,c.vcompanyname as suppliername, c.vsuppliercode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.iitemid in($iitemids)";
		}

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getCategoriesReport($data) {

		if(in_array('ALL', $data['report_data'])){
			$vcatcodes = 'ALL';

			$sql = "SELECT a.nsellunit,b.vcategoryname as search_name, a.vcategorycode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY b.vcategoryname ASC";
		}else{
			$vcatcodes = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,b.vcategoryname as search_name, a.vcategorycode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vcategorycode in($vcatcodes) ORDER BY b.vcategoryname ASC";
		}

		$query = $this->db2->query($sql);
		
		// $query = $this->db2->query("CALL rp_webqoh('Category','".$vcatcodes."')");

		return $query->rows;
	}

	public function getCategoriesReportAlberta($data) {

		if(in_array('ALL', $data['report_data'])){
			$vcatcodes = 'ALL';

			$sql = "SELECT a.nsellunit,b.vcategoryname as search_name, a.vcategorycode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY b.vcategoryname ASC";
		}else{
			$vcatcodes = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,b.vcategoryname as search_name, a.vcategorycode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vcategorycode in($vcatcodes) ORDER BY b.vcategoryname ASC";
		}

		$query = $this->db2->query($sql);
		
		// $query = $this->db2->query("CALL rp_webqoh('Category','".$vcatcodes."')");

		return $query->rows;
	}

	public function ajaxDataReportCategory($data) {

		$sql = "SELECT a.nsellunit,b.vcategoryname as search_name, a.vcategorycode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null) then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vcategoryname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_category b,mst_supplier c  where a.vcategorycode=b.vcategorycode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vcategorycode='". $this->db->escape($data['report_pull_id']) ."'";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartmentsReport($data) {
		
		if(in_array('ALL', $data['report_data'])){
			$vdepcodes = 'ALL';

			$sql = "SELECT a.nsellunit,b.vdepartmentname as search_name,a.vdepcode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY b.vdepartmentname ASC";
		}else{
			$vdepcodes = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,b.vdepartmentname as search_name,a.vdepcode as search_id, c.vsuppliercode as vsuppliercode ,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vdepcode in($vdepcodes) ORDER BY b.vdepartmentname ASC";
		}

		// $query = $this->db2->query("CALL rp_webqoh('Department','".$vdepcodes."')");

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartmentsReportAlberta($data) {
		
		if(in_array('ALL', $data['report_data'])){
			$vdepcodes = 'ALL';

			$sql = "SELECT a.nsellunit,b.vdepartmentname as search_name,a.vdepcode as search_id, c.vsuppliercode as vsuppliercode,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' ORDER BY b.vdepartmentname ASC";
		}else{
			$vdepcodes = implode(',', $data['report_data']);

			$sql = "SELECT a.nsellunit,b.vdepartmentname as search_name,a.vdepcode as search_id, c.vsuppliercode as vsuppliercode ,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vdepcode in($vdepcodes) ORDER BY b.vdepartmentname ASC";
		}

		// $query = $this->db2->query("CALL rp_webqoh('Department','".$vdepcodes."')");

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function ajaxDataReportDepartment($data) {
		
		$sql = "SELECT a.nsellunit,b.vdepartmentname as search_name,a.vdepcode as search_id, c.vsuppliercode as vsuppliercode ,a.vitemname as itemname,CASE WHEN NPACK = 1 or (npack is null)   then IQTYONHAND else (Concat(cast((a.IQTYONHAND/a.NPACK ) as signed), '  (' , Mod(a.IQTYONHAND,a.NPACK) , ')') )  end as vqty,iqtyonhand,b.vdepartmentname as vname,Case When (nUnitCost) is null then 0 else  nUnitCost end as cost ,a.dUnitPrice as price FROM mst_item a,mst_department b,mst_supplier c  where a.vdepcode=b.vdepcode  and a.vsuppliercode =c.vsuppliercode and a.vitemtype != 'Kiosk' and IQTYONHAND !=0 and IQTYONHAND > 0  and vitemname is not null AND a.visinventory='Yes' AND a.vdepcode='". $this->db->escape($data['report_pull_id']) ."'";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

}
