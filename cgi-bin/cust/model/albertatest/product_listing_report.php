<?php
class ModelApiProductListingReport extends Model {

	public function getProductListingReport() {
		$query = $this->db2->query("SELECT mi.iitemid, mi.vitemtype, mi.vbarcode, mi.vitemname, mi.dunitprice, mi.npack, mi.vsize, mi.iqtyonhand as qoh, mi.vcategorycode, mi.vdepcode, mc.vcategoryname, md.vdepartmentname, CASE WHEN mi.NPACK = 1 or (mi.npack is null)   then IQTYONHAND else (Concat(cast(((IQTYONHAND div mi.NPACK )) as signed), '  (', Mod(IQTYONHAND,mi.NPACK) ,')') ) end as IQTYONHAND  FROM mst_item as mi LEFT JOIN mst_category mc ON(mc.vcategorycode=mi.vcategorycode) LEFT JOIN mst_department md ON(md.vdepcode=mi.vdepcode)");

		return $query->rows;
	}
}
