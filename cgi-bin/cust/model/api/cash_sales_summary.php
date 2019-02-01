<?php
class ModelApiCashSalesSummary extends Model {

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

	public function getGroups() {
		$sql = "SELECT iitemgroupid as id, vitemgroupname as name FROM itemgroup";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getCategoriesReport($data) {
		$vcatcodes = implode(',', $data['report_data']);

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		if(in_array('ALL', $data['report_data'])){
			//$sql = "SELECT trn_sd.vcatname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s, mst_item ms WHERE trn_s.vtrntype='Transaction' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY trn_sd.vcatname";

			$sql = "Select c.vCATNAME as name,c.TOTUNITPRICE as Net_Amount,c.TotCostPrice as Cost_Amount,c.TotalQty as hit FROM (select a.VITEMCODE,a.vCATNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') group by a.VITEMCODE,a.VCATNAME) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vcatname,d.vITemName";

		}else{
			//$sql = "SELECT trn_sd.vcatname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s, mst_item ms WHERE trn_s.vtrntype='Transaction' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_sd.vcatcode in($vcatcodes) GROUP BY trn_sd.vcatname";


			$sql = "Select c.vCATNAME as name,c.TOTUNITPRICE as Net_Amount,c.TotCostPrice as Cost_Amount,c.TotalQty as hit FROM (select a.VITEMCODE,a.vCATNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') AND find_in_set(a.VCATCODE,$vcatcodes) group by a.VITEMCODE,a.VCATNAME) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vcatname,d.vITemName";

		}

		$return = array();
		$query = $this->db2->query($sql);

		if(count($query->rows) > 0){
			foreach ($query->rows as $key => $value) {
				if(array_key_exists($value['name'], $return)){
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $return[$value['name']]['Net_Amount'] + $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $return[$value['name']]['Cost_Amount'] + $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $return[$value['name']]['hit'] + $value['hit'];
				}else{
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $value['hit'];
				}
			}
		}

		$return_main = array();

		if(count($return) > 0){
			foreach ($return as $key => $value) {
				$return_main[] = $value;
			}
		}

		return $return_main;
	}

	public function getDepartmentsReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$vdepcodes = implode(',', $data['report_data']);

		if(in_array('ALL', $data['report_data'])){
			//$sql = "SELECT trn_sd.vdepname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s, mst_item ms WHERE trn_s.vtrntype='Transaction' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY trn_sd.vdepname";

			$sql = "Select c.vDEPNAME as name,c.TOTUNITPRICE as Net_Amount,c.TotCostPrice as Cost_Amount,c.TotalQty as hit FROM (select a.VITEMCODE,a.VDEPNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') group by a.VITEMCODE,a.VDEPNAME) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vdepname,d.vITemName";
		}else{
			//$sql = "SELECT trn_sd.vdepname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd , trn_sales trn_s, mst_item ms WHERE trn_s.vtrntype='Transaction' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_sd.vdepcode in($vdepcodes) GROUP BY trn_sd.vdepname";

			$sql = "Select c.vDEPNAME as name,c.TOTUNITPRICE as Net_Amount,c.TotCostPrice as Cost_Amount,c.TotalQty as hit FROM (select a.VITEMCODE,a.VDEPNAME, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b where a.ISALESID = b.ISALESID AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d')between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') AND find_in_set(a.vDEPCODE,$vdepcodes) group by a.VITEMCODE,a.VDEPNAME) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vdepname,d.vITemName";
		}
		
		$query = $this->db2->query($sql);

		$return = array();

		if(count($query->rows) > 0){
			foreach ($query->rows as $key => $value) {
				if(array_key_exists($value['name'], $return)){
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $return[$value['name']]['Net_Amount'] + $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $return[$value['name']]['Cost_Amount'] + $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $return[$value['name']]['hit'] + $value['hit'];
				}else{
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $value['hit'];
				}
			}
		}

		$return_main = array();

		if(count($return) > 0){
			foreach ($return as $key => $value) {
				$return_main[] = $value;
			}
		}

		return $return_main;
	}

	public function getGroupsReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		$vgroups = implode(',', $data['report_data']);

		if(in_array('ALL', $data['report_data'])){
			//$sql = "SELECT itmg.vitemgroupname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s, mst_item ms , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";

			$sql = "Select c.vitemgroupname as name,c.TOTUNITPRICE as Net_Amount ,c.TotCostPrice as Cost_Amount, c.TotalQty as hit FROM (select a.VITEMCODE,a.vcatname,m.iitemgroupid,n.vitemgroupname, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b, itemgroupdetail m, itemgroup n where a.ISALESID = b.ISALESID AND a.VITEMCODE=m.vsku AND m.iitemgroupid=n.iitemgroupid AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') group by a.VITEMCODE,m.iitemgroupid) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vitemgroupname,d.vITemName";
		}else{
			//$sql = "SELECT itmg.vitemgroupname as name, ifnull(SUM(trn_sd.iunitqty),0) as hit, ifnull(SUM(trn_sd.nextunitprice),0) as Net_Amount, ifnull(SUM(trn_sd.nextcostprice),0) as Cost_Amount FROM trn_salesdetail trn_sd, trn_sales trn_s, mst_item ms , itemgroupdetail itmgd ,itemgroup itmg WHERE trn_s.vtrntype='Transaction' AND trn_sd.vitemcode=ms.vitemcode AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND itmg.iitemgroupid in($vgroups) AND trn_s.isalesid=trn_sd.isalesid AND  itmgd.vsku=trn_sd.vitemcode AND itmg.iitemgroupid=itmgd.iitemgroupid AND (itmgd.vtype='Product' OR itmgd.vtype=NULL OR itmgd.vtype='') GROUP BY itmg.vitemgroupname";

			$sql = "Select c.vitemgroupname as name,c.TOTUNITPRICE as Net_Amount ,c.TotCostPrice as Cost_Amount, c.TotalQty as hit FROM (select a.VITEMCODE,a.vcatname,m.iitemgroupid,n.vitemgroupname, SUM(NEXTUNITPRICE) as TotUnitPrice,SUM(NEXTCOSTPRICE) as TotCostPrice,CASE  WHEN SUM(iUNITQTY) is  null then 0 ELSE SUM(iUNITQTY) END as TotalQty from trn_salesdetail a,trn_sales b, itemgroupdetail m, itemgroup n where a.ISALESID = b.ISALESID AND a.VITEMCODE=m.vsku AND m.iitemgroupid=n.iitemgroupid AND  b.vtrntype='Transaction' and date_format(b.dtrandate,'%Y-%m-%d') between str_to_date('".$data['start_date']."','%Y-%m-%d') and str_to_date('".$data['end_date']."','%Y-%m-%d') AND find_in_set(m.iitemgroupid,$vgroups) group by a.VITEMCODE,m.iitemgroupid) c,mst_item d WHERE c.vITEMCODE = d.VITEMCODE AND c.TotalQty !=0 order by c.vitemgroupname,d.vITemName";
		}
		
		$query = $this->db2->query($sql);

		$return = array();

		if(count($query->rows) > 0){
			foreach ($query->rows as $key => $value) {
				if(array_key_exists($value['name'], $return)){
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $return[$value['name']]['Net_Amount'] + $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $return[$value['name']]['Cost_Amount'] + $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $return[$value['name']]['hit'] + $value['hit'];
				}else{
					$return[$value['name']]['name'] = $value['name'];
					$return[$value['name']]['Net_Amount'] = $value['Net_Amount'];
					$return[$value['name']]['Cost_Amount'] = $value['Cost_Amount'];
					$return[$value['name']]['hit'] = $value['hit'];
				}
			}
		}

		$return_main = array();

		if(count($return) > 0){
			foreach ($return as $key => $value) {
				$return_main[] = $value;
			}
		}

		return $return_main;
	}

}
