<?php
class ModelApiHourlySalesReport extends Model {

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

	public function getHourlySalesReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}

		$query = $this->db2->query("CALL rp_eofhourlysales('".$date."')");

		return $query->rows;
	}

	public function getCategoriesReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}

		$query = $this->db2->query("CALL rp_eofcategory('".$date."')");

		return $query->rows;
	}

	public function getDepartmentsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofdepartment('".$date."')");

		return $query->rows;
	}

	public function getShiftsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_endofshift('".$date."')");

		return $query->rows;
	}

	public function getPaidoutsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofpaidout('".$date."')");

		return $query->rows;
	}

	public function getPicupsReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eofpickup('".$date."')");

		return $query->rows;
	}

	public function getTenderReport($data = null) {

		if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}
		
		$query = $this->db2->query("CALL rp_eoftender('".$date."')");

		return $query->rows;
	}
	
	
	public function getSumTotal($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
	    /*if(isset($data)){
			$date = $data['start_date'];
		}else{
			$date = date("m-d-Y");
		}*/
		
// 		$query = "select sum(ntotalsales)+sum(ntotaltax) totalsales_withtax, sum(nnetsales)-(sum(ntotalsales)+sum(ntotaltax)) liability_sales, sum(nnetsales) Totalsales, sum(ntotaltaxable) taxable_sales, sum(ntotalnontaxable) nontaxable_sales, sum(ntotaltax) total_tax, sum(nnetpaidout) netpaidout, sum(nnetaddcash) netaddcash, sum(nnetcashpickup) netcashpickup, sum(ntotalcreditsales) totalcreditsales, sum(ntotalcashsales) totalcashsales, sum(ntotalchecksales) totalchecksales, sum(ntotaldebitsales) totaldebitsales,  sum(ntotaldiscount) totaldiscount from trn_batch where date_format(dbatchstarttime,'%m-%d-%Y') = '". $date ."'";

        $query = "SELECT sum(nnettotal) Sales_With_Tax, sum(nnontaxabletotal) Non_Taxable_Sales, sum(ntaxabletotal) Taxable_Total, sum(case when vtendertype='On Account' then nnettotal else 0 end) House_Charged, sum(ntaxtotal) Total_Tax, sum(case when vtendertype='EBT' then nnettotal else 0 end) EBT_Cash_Payments, sum(case when vtendertype='Check' then nnettotal else 0 end) Check_Payments, sum(case when vtendertype='Credit Card' then nnettotal else 0 end) Credit_Card_Payments, sum(case when vtendertype='Debit Card' then nnettotal else 0 end) Debit_Card_Payments, sum(ndiscountamt) Discount_Amount FROM trn_sales where date_format(dtrandate,'%m-%d-%Y') = '". $date ."' and vtrntype='Transaction'";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($query);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}
	public function getCreditCardReport($data,$type) {

		
		
		$sql = "SELECT count(trn_mps.nauthamount) as transaction_number,ifnull(SUM(trn_mps.nauthamount),0) as nauthamount, trn_mps.vcardtype as vcardtype FROM trn_mpstender trn_mps WHERE trn_mps.vcardtype ='amex' AND trn_mps.nauthamount !=0 AND date_format(trn_mps.dtrandate,'%m-%d-%Y') >= '".$data['start_date']."' AND date_format(trn_mps.dtrandate,'%m-%d-%Y') <= '".$data['end_date']."' GROUP BY trn_mps.vcardtype ";

    	$query = $this->db2->query($sql);
		

		return $query->rows;
	}
	
	public function liabilitySales($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "select sum(liabilityamount) Liability_Amount, sum(itemtaxrateone*ncostprice/100) Tax1_Total, sum(itemtaxratetwo*ncostprice/100) Tax2_Total, sum(case when vitemcode = 20 then nextunitprice else 0 end) Lot_Sales, sum(case when vitemcode in (6, 22) then nextunitprice else 0 end) Lot_Redeem, sum(case when vitemcode = 21 then nextunitprice else 0 end) Inst_Sales, sum(case when vitemcode = 23 then nextunitprice else 0 end) Inst_Redeem, sum(case when vitemcode = 1 and ndebitqty>0 then nextunitprice else 0 end) Bottle_Deposit, sum(case when vitemcode = 1 and ndebitqty<0 then nextunitprice else 0 end) Bottle_Deposit_Redeem, sum(case when vitemcode = 18 then nextunitprice else 0 end) Coupon_Redeem, sum(nextunitprice) Gross_Sales, sum(nextcostprice) Gross_Cost from trn_sales s join trn_salesdetail d on s.isalesid=d.isalesid where date_format(dtrandate,'%m-%d-%Y') = '". $date ."' and vtrntype='Transaction'";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($query);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}


	public function houseCharge($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "SELECT sum(ndebitamt) housecharge_payments from trn_customerpay where vtrantype='Payment' and date_format(dtrandate,'%m-%d-%Y') = '". $date ."'";

        $run_query = $this->db2->query($query);
        
        return $run_query->rows;
	}	
	
	public function deletedSales($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "SELECT sum(extprice) Deleted_Items_Amount, count(extprice) No_of_Trn_Items_Deleted FROM mst_deleteditem d join trn_batch b on d.batchid=b.ibatchid where date_format(dbatchstarttime,'%m-%d-%Y') = '". $date ."'";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($query);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}
	
	
	public function voidSaleAmount($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;

        $query = "SELECT sum(nnettotal) Void_Amount FROM trn_sales where date_format(dtrandate,'%m-%d-%Y') = '". $date ."' and vtrntype='Void'";

        $run_query = $this->db2->query($query);
        
        return $run_query->rows;
	}
	
	
	public function deptSummary($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "select vdepname Dept, sum(ndebitqty) Qty, sum(ndebitamt) Amount from trn_sales s join trn_salesdetail d on s.isalesid=d.isalesid where date_format(dtrandate,'%m-%d-%Y') = '". $date ."' and vtrntype='Transaction' group by vdepname;";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($run_query->rows);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}
	
	
	

	public function salesTotal($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "select sum(case when vtrntype='Transaction' then 1 else 0 end) No_of_Sales, sum(case when vtrntype='Transaction' then nnettotal else 0 end) Sales_amount, sum(case when vtrntype='Void' then 1 else 0 end) No_of_Void, sum(case when vtrntype='Void' then nnettotal else 0 end) Void_Amount, sum(case when vtrntype='No Sale' then 1 else 0 end) No_Sales from trn_sales where date_format(dtrandate,'%m-%d-%Y') = '". $date ."'";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($run_query->rows);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}


	public function hourlyReport($start_date = null,$end_date = null) {
	    
	    $start_date = (!isset($start_date) || $start_date == null) ? date("m-d-Y"):$start_date;
	    $end_date = (!isset($end_date) || $end_date == null) ? date("m-d-Y"):$end_date;
		
        $query = "SELECT CONCAT(date_format(dtrandate,'%h:00 %p to '), date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p')) Hours, sum(nnettotal) Amount FROM trn_sales where date_format(dtrandate,'%m-%d-%Y')>='". $start_date ."' AND date_format(dtrandate,'%m-%d-%Y')<='". $end_date ."' group by CONCAT(date_format(dtrandate,'%h:00 %p to ') , date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p')),date_format(dtrandate,'%H') order by date_format(dtrandate,'%H')";

        $run_query = $this->db2->query($query);
        // echo "<pre>";print_r($run_query->rows);exit;
        return $run_query->rows;
	}
	
	
    public function paidOut($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "SELECT vpaidoutname, namount Amount FROM trn_paidoutdetail tpd join trn_paidout tp on tpd.ipaidouttrnid=tp.ipaidouttrnid where date_format(ddate,'%m-%d-%Y') = '". $date ."' ";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($run_query->rows);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}
	
	
	public function totalShiftCash($date = null) {
	    
	    $date = (!isset($date) || $date == null) ? date("m-d-Y"):$date;
		
        $query = "Select SUM(Amount) as TotalAmount from ( SELECT CONCAT(date_format(dtrandate,'%h:00 %p to '), date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p')) Hours, sum(nnettotal) Amount FROM trn_sales where date_format(dtrandate,'%m-%d-%Y')='". $date ."' group by CONCAT(date_format(dtrandate,'%h:00 %p to ') , date_format(date_add(dtrandate, interval 1 hour),'%h:00 %p')),date_format(dtrandate,'%H') ) t1";

        $run_query = $this->db2->query($query);
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");

        $data_row = PHP_EOL.json_encode($run_query->rows);

        fwrite($myfile,$data_row);
        fclose($myfile);*/
        
        return $run_query->rows;
	}

}
