<?php
class ModelApiScanDataReport extends Model {

	public function getScanDadtaReport($data = array()){
       
		$week_ending_date = DateTime::createFromFormat('m-d-Y', $data['week_ending_date']);
		$week_ending_date = $week_ending_date->format('Y-m-d');

        $week_starting_date = date('Y-m-d', strtotime('-1 week', strtotime($week_ending_date)));

        $department_id = implode(',', $data['department_id']);
        
        $category_id = implode(',', $data['category_id']);
        
        // $query = "SELECT tsd.*, ts.*,ms.*,mi.iitemid,mi.vsuppliercode,msupplier.vcompanyname, u.*  FROM trn_salesdetail as tsd, trn_sales as ts, mst_store as ms, mst_item as mi, mst_supplier as msupplier, mst_unit as u  WHERE u.vunitcode = mi.vunitcode AND tsd.isalesid=ts.isalesid AND ms.istoreid=ts.istoreid AND mi.vbarcode=tsd.vitemcode AND msupplier.vsuppliercode=mi.vsuppliercode AND date_format(ts.dtrandate,'%Y-%m-%d') > '".$week_starting_date."' AND date_format(ts.dtrandate,'%Y-%m-%d') <= '".$week_ending_date."' AND mi.vdepcode in($department_id) AND mi.vcategorycode in($category_id)";
        
        //New query for Multi pack indicator
        
        $query = "SELECT tsd.vitemcode as upc_code, tsd.*, ts.*,ms.*,mi.iitemid,mi.vsuppliercode,mi.nunitcost,msupplier.vcompanyname, u.*, prom.*  FROM trn_salesdetail as tsd, trn_sales as ts, mst_store as ms, mst_item as mi left join   
        (select vitemcode, 'Y' as 'is_multiple', 
        nbuyqty,ndiscountper, vsaleby 
        from trn_saleprice sp join trn_salepricedetail spd 
        on sp.isalepriceid=spd.isalepriceid
		where estatus='Active' and 
		(dstartdatetime < current_date() or dstartdatetime='0000-00-00 00:00:00' or dstartdatetime is null)
		and
		(denddatetime > current_date() or denddatetime='0000-00-00 00:00:00' or denddatetime is null))  as prom
		on mi.vbarcode	= prom.vitemcode, mst_supplier as msupplier, mst_unit as u  WHERE u.vunitcode = mi.vunitcode AND tsd.isalesid=ts.isalesid AND ms.istoreid=ts.istoreid AND mi.vbarcode=tsd.vitemcode AND msupplier.vsuppliercode=mi.vsuppliercode AND date_format(ts.dtrandate,'%Y-%m-%d') > '".$week_starting_date."' AND date_format(ts.dtrandate,'%Y-%m-%d') <= '".$week_ending_date."' AND mi.vdepcode in($department_id) AND mi.vcategorycode in($category_id)";
        
        
        

        $run_query = $this->db2->query($query);

        // $query = $this->db2->query("SELECT s.vcity vcity, s.vstate vstate, s.vzip vzip, t.dtrandate dtrandate, d.idettrnid idettrnid, t.vterminalid, d.ndebitqty, d.nunitprice, d.vitemcode, d.vitemname item_name, d.vsize, m.ndiscountper from trn_sales t join mst_store s on t.istoreid=s.istoreid join trn_salesdetail d on d.isalesid=t.isalesid join mst_item m on d.vitemcode=m.vitemcode where date_format(t.dtrandate,'%Y-%m-%d') > '".$week_starting_date."' AND date_format(t.dtrandate,'%Y-%m-%d') <= '".$week_ending_date."' AND m.vdepcode in($department_id) AND m.vcategorycode in($category_id)");

            /*$file_path1 = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

			$myfile1 = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");
$data_row = json_encode($run_query);
			fwrite($myfile1,$data_row);
			fclose($myfile1);*/

		return $run_query->rows;
	}

    public function getVendors() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY isupplierid DESC");

        return $query->rows;
    }

    public function getDepartments() {
        $query = $this->db2->query("SELECT * FROM mst_department ORDER BY vdepartmentname ASC");

        return $query->rows;
    }
    
    public function getCategories() {
        $query = $this->db2->query("SELECT * FROM mst_category ORDER BY vcategoryname ASC");

        return $query->rows;
    }

    public function getStore() {
        $sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

        $query = $this->db->query($sql);

        return $query->row;
    }
}
