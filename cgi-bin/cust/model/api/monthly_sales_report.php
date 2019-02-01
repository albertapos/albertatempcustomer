<?php
class ModelApiMonthlySalesReport extends Model {

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

	public function getMonthlyReport($data) {

        $start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $data['start_date'] = $start_date->format('Y-m-d');

        $end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
        $data['end_date'] = $end_date->format('Y-m-d');

        $sql = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(a.NNETTOTAL),0) as nettotal, ifnull(SUM(a.nsubtotal),0) as nsubtotal, ifnull(SUM(a.NTAXABLETOTAL),0) as ntaxable, ifnull(SUM(a.NNONTAXABLETOTAL),0) as nnontaxabletotal, ifnull(SUM(a.NDISCOUNTAMT),0) as ndiscountamt, ifnull(SUM(a.NTAXTOTAL),0) as ntaxtotal, ifnull(SUM(a.NSALETOTALAMT),0) as ntotalsalediscount, ifnull(SUM(a.NTAXABLETOTAL + a.NNONTAXABLETOTAL),0) as ntotalsaleswithout FROM trn_sales as a WHERE a.ionaccount!=1 AND a.vtrntype='Transaction' and date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY date_format(a.dtrandate,'%Y-%m-%d')";

        $query1 = $this->db2->query($sql);

        $query_transactions = $query1->rows;

        $sql_credit_amt = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(b.namount),0) as totalcreditamt FROM trn_sales as a, trn_salestender b,mst_tentertype c WHERE a.isalesid = b.isalesid AND b.itenerid = c.itenderid  and a.vtrntype='Transaction' and date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' and c.vtendertag in ('Credit','Debit')  GROUP BY date_format(a.dtrandate,'%Y-%m-%d')";

        $query_credit_amts = $this->db2->query($sql_credit_amt);

        $query_credit_amts = $query_credit_amts->rows;

        $sql_cash_sales = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(b.namount),0) as ntotalcashsales FROM trn_sales as a, trn_salestender b,mst_tentertype c WHERE a.isalesid = b.isalesid AND b.itenerid = c.itenderid  and a.vtrntype='Transaction' and date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' and c.vtendertag in ('Cash','Check') AND c.itenderid NOT in ('120','121') GROUP BY date_format(a.dtrandate,'%Y-%m-%d')";

        $query_cash_sales = $this->db2->query($sql_cash_sales);

        $query_cash_sales = $query_cash_sales->rows;

        $sql_ebt_sales = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(b.namount),0) as ntotalebtsales FROM trn_sales as a, trn_salestender b,mst_tentertype c WHERE a.isalesid = b.isalesid AND b.itenerid = c.itenderid  and a.vtrntype='Transaction' and date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' and c.vtendertag in ('Ebt') GROUP BY date_format(a.dtrandate,'%Y-%m-%d')";

        $query_ebt_sales = $this->db2->query($sql_ebt_sales);

        $query_ebt_sales = $query_ebt_sales->rows;

        $sql_paid_outs = "SELECT date_format(a.ddate,'%m-%d-%Y') as date_sale, ifnull(SUM(a.nnetpaidout),0) as nnetpaidout FROM trn_dailysales as a WHERE a.nnetpaidout!=0 AND date_format(a.ddate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.ddate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY date_format(a.ddate,'%Y-%m-%d')";

        $query_paid_outs = $this->db2->query($sql_paid_outs);

        $query_paid_outs = $query_paid_outs->rows;

        $sql_add_cash = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(a.NNETTOTAL),0) as nettotalcashadded FROM trn_sales as a WHERE a.vtrntype='Add Cash' and date_format(a.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(a.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY date_format(a.dtrandate,'%Y-%m-%d')";

        $query2 = $this->db2->query($sql_add_cash);

        $query_add_cashs = $query2->rows;

        $sql_coupon_data = "SELECT date_format(b.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(abs(a.ndebitamt)),0) as ntotalcouponsales FROM trn_salesdetail as a, trn_sales as b WHERE a.isalesid = b.isalesid and b.vtrntype='Transaction' AND a.ndebitamt!=0 AND a.vitemcode='18' and date_format(b.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' and date_format(b.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY date_format(b.dtrandate,'%Y-%m-%d')";

        $query_coupon_data = $this->db2->query($sql_coupon_data)->rows;

        $new_query_transactions = array();
        $new_query_credit_amts = array();
        $new_query_cash_sales = array();
        $new_query_ebt_sales = array();
        $new_query_paid_outs = array();
        $new_query_add_cashs = array();
        $new_query_coupon_data = array();

        if(count($query_transactions) > 0){
            foreach ($query_transactions as $key => $value) {
                $new_query_transactions[$value['date_sale']] = $value;
            }
        }

        if(count($query_credit_amts) > 0){
            foreach ($query_credit_amts as $key => $value) {
                $new_query_credit_amts[$value['date_sale']] = $value;
            }
        }

        if(count($query_cash_sales) > 0){
            foreach ($query_cash_sales as $key => $value) {
                $new_query_cash_sales[$value['date_sale']] = $value;
            }
        }

        if(count($query_ebt_sales) > 0){
            foreach ($query_ebt_sales as $key => $value) {
                $new_query_ebt_sales[$value['date_sale']] = $value;
            }
        }

        if(count($query_paid_outs) > 0){
            foreach ($query_paid_outs as $key => $value) {
                $new_query_paid_outs[$value['date_sale']] = $value;
            }
        }

        if(count($query_add_cashs) > 0){
            foreach ($query_add_cashs as $key => $value) {
                $new_query_add_cashs[$value['date_sale']] = $value;
            }
        }

        if(count($query_coupon_data) > 0){
            foreach ($query_coupon_data as $key => $value) {
                $new_query_coupon_data[$value['date_sale']] = $value;
            }
        }

        $periods = new DatePeriod(new DateTime($data['start_date']), new DateInterval('P1D'), new DateTime($data['end_date'].' +1 day'));
        foreach ($periods as $date) {
            $dates[] = $date->format("m-d-Y");
        }

        $main_data = array();

        $i= 0;
        if(count($dates) > 0){
            foreach ($dates as $key => $value) {

                if(isset($new_query_transactions[$value]) || isset($new_query_credit_amts[$value]) || isset($new_query_cash_sales[$value]) || isset($new_query_ebt_sales[$value]) || isset($new_query_paid_outs[$value]) || isset($new_query_add_cashs[$value]) || isset($new_query_coupon_data[$value])){

                    $main_data[$i]['date_sale'] = $value;

                    if(isset($new_query_transactions[$value]['nettotal'])){
                        $main_data[$i]['nettotal'] = $new_query_transactions[$value]['nettotal'];
                    }else{
                        $main_data[$i]['nettotal'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['nsubtotal'])){
                        $main_data[$i]['nsubtotal'] = $new_query_transactions[$value]['nsubtotal'];
                    }else{
                        $main_data[$i]['nsubtotal'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['ntaxable'])){
                        $main_data[$i]['ntaxable'] = $new_query_transactions[$value]['ntaxable'];
                    }else{
                        $main_data[$i]['ntaxable'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['nnontaxabletotal'])){
                        $main_data[$i]['nnontaxabletotal'] = $new_query_transactions[$value]['nnontaxabletotal'];
                    }else{
                        $main_data[$i]['nnontaxabletotal'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['ndiscountamt'])){
                        $main_data[$i]['ndiscountamt'] = $new_query_transactions[$value]['ndiscountamt'];
                    }else{
                        $main_data[$i]['ndiscountamt'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['ntaxtotal'])){
                        $main_data[$i]['ntaxtotal'] = $new_query_transactions[$value]['ntaxtotal'];
                    }else{
                        $main_data[$i]['ntaxtotal'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['ntotalsalediscount'])){
                        $main_data[$i]['ntotalsalediscount'] = $new_query_transactions[$value]['ntotalsalediscount'];
                    }else{
                        $main_data[$i]['ntotalsalediscount'] = '0.00';
                    }

                    if(isset($new_query_transactions[$value]['ntotalsaleswithout'])){
                        $main_data[$i]['ntotalsaleswithout'] = $new_query_transactions[$value]['ntotalsaleswithout'];
                    }else{
                        $main_data[$i]['ntotalsaleswithout'] = '0.00';
                    }

                    if(isset($new_query_credit_amts[$value]['totalcreditamt'])){
                        $main_data[$i]['totalcreditamt'] = $new_query_credit_amts[$value]['totalcreditamt'];
                    }else{
                        $main_data[$i]['totalcreditamt'] = '0.00';
                    }

                    if(isset($new_query_cash_sales[$value]['ntotalcashsales'])){
						if(isset($new_query_coupon_data[$value]['ntotalcouponsales']) && $new_query_coupon_data[$value]['ntotalcouponsales'] >0 ){
	                        $main_data[$i]['ntotalcashsales'] = $new_query_cash_sales[$value]['ntotalcashsales']-$new_query_coupon_data[$value]['ntotalcouponsales'];
						}
						else{
							$main_data[$i]['ntotalcashsales'] = $new_query_cash_sales[$value]['ntotalcashsales'];	
						}
                    }else{
                        $main_data[$i]['ntotalcashsales'] = '0.00';
                    }

                    if(isset($new_query_paid_outs[$value]['nnetpaidout'])){
                        $main_data[$i]['nnetpaidout'] = $new_query_paid_outs[$value]['nnetpaidout'];
                    }else{
                        $main_data[$i]['nnetpaidout'] = '0.00';
                    }

                    if(isset($new_query_ebt_sales[$value]['ntotalebtsales'])){
                        $main_data[$i]['ntotalebtsales'] = $new_query_ebt_sales[$value]['ntotalebtsales'];
                    }else{
                        $main_data[$i]['ntotalebtsales'] = '0.00';
                    }

                    if(isset($new_query_add_cashs[$value]['nettotalcashadded'])){
                        $main_data[$i]['nettotalcashadded'] = $new_query_add_cashs[$value]['nettotalcashadded'];
                    }else{
                        $main_data[$i]['nettotalcashadded'] = '0.00';
                    }

                    if(isset($new_query_coupon_data[$value]['ntotalcouponsales'])){
                        $main_data[$i]['ntotalcouponsales'] = $new_query_coupon_data[$value]['ntotalcouponsales'];
                    }else{
                        $main_data[$i]['ntotalcouponsales'] = '0.00';
                    }

                    $i++;
                    
                }
            }
        }

        return $main_data;
    }

}
