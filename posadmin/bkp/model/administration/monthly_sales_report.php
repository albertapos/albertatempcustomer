<?php
class ModelAdministrationMonthlySalesReport extends Model {

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

		$sql = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(a.NNETTOTAL),0) as nettotal, ifnull(SUM(a.nsubtotal),0) as nsubtotal, ifnull(SUM(a.NTAXABLETOTAL),0) as ntaxable, ifnull(SUM(a.NNONTAXABLETOTAL),0) as nnontaxabletotal, ifnull(SUM(a.NDISCOUNTAMT),0) as ndiscountamt, ifnull(SUM(a.NTAXTOTAL),0) as ntaxtotal, ifnull(SUM(a.NSALETOTALAMT),0) as ntotalsalediscount, ifnull(SUM(a.NTAXABLETOTAL + a.NNONTAXABLETOTAL),0) as ntotalsaleswithout, ifnull(SUM(b.namount),0) as totalcreditamt FROM trn_sales as a, trn_salestender b,mst_tentertype c WHERE iOnAccount != 1 and a.isalesid = b.isalesid and b.itenerid != 121 and b.itenerid = c.itenderid  and vtrntype='Transaction' and a.dtrandate >= '".$data['start_date']."' and a.dtrandate <= '".$data['end_date']."' and c.vtendertag in ('Credit','Debit','Gift') GROUP BY date_format(a.dtrandate,'%m-%d-%Y')";

        $query1 = $this->db2->query($sql);

        $query_transactions = $query1->rows;

        $sql_add_cash = "SELECT date_format(a.dtrandate,'%m-%d-%Y') as date_sale, ifnull(SUM(a.NNETTOTAL),0) as nettotalcashadded FROM trn_sales as a WHERE iOnAccount != 1 and a.vtrntype='Add Cash' and a.dtrandate >= '".$data['start_date']."' and a.dtrandate <= '".$data['end_date']."' GROUP BY date_format(a.dtrandate,'%m-%d-%Y')";

        $query2 = $this->db2->query($sql_add_cash);

        $query_add_cashs = $query2->rows;

        $main_data = array();

        if(count($query_transactions) > 0){
        	foreach ($query_transactions as $key => $query_transaction) {
        		
	        	$flag = false;
	        	if(count($query_add_cashs) > 0){
	        		foreach ($query_add_cashs as $k => $query_add_cash) {
	        			if($query_add_cash['date_sale'] == $query_transaction['date_sale']){
	        				$main_data[$key]['date_sale'] = $query_transaction['date_sale'];
	        				$main_data[$key]['nettotal'] = $query_transaction['nettotal'];
	        				$main_data[$key]['nettotalcashadded'] = $query_add_cash['nettotalcashadded'];
	        				$main_data[$key]['nsubtotal'] = $query_transaction['nsubtotal'];
	        				$main_data[$key]['ntaxable'] = $query_transaction['ntaxable'];
	        				$main_data[$key]['nnontaxabletotal'] = $query_transaction['nnontaxabletotal'];
	        				$main_data[$key]['ndiscountamt'] = $query_transaction['ndiscountamt'];
	        				$main_data[$key]['ntaxtotal'] = $query_transaction['ntaxtotal'];
	        				$main_data[$key]['ntotalsalediscount'] = $query_transaction['ntotalsalediscount'];
	        				$main_data[$key]['ntotalsaleswithout'] = $query_transaction['ntotalsaleswithout'];
	        				$main_data[$key]['totalcreditamt'] = $query_transaction['totalcreditamt'];
	        				$flag = true;
	        			}
	        		}
        		}

        		if($flag == false){
        			$main_data[]['date_sale'] = $query_transaction['date_sale'];
        				$main_data[$key]['nettotal'] = $query_transaction['nettotal'];
        				$main_data[$key]['nettotalcashadded'] = 0;
        				$main_data[$key]['nsubtotal'] = $query_transaction['nsubtotal'];
        				$main_data[$key]['ntaxable'] = $query_transaction['ntaxable'];
        				$main_data[$key]['nnontaxabletotal'] = $query_transaction['nnontaxabletotal'];
        				$main_data[$key]['ndiscountamt'] = $query_transaction['ndiscountamt'];
        				$main_data[$key]['ntaxtotal'] = $query_transaction['ntaxtotal'];
        				$main_data[$key]['ntotalsalediscount'] = $query_transaction['ntotalsalediscount'];
        				$main_data[$key]['ntotalsaleswithout'] = $query_transaction['ntotalsaleswithout'];
        				$main_data[$key]['totalcreditamt'] = $query_transaction['totalcreditamt'];
        		}
	        }
        }

		return $main_data;
	}

}
