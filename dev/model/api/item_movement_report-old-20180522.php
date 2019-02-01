<?php
class ModelApiItemMovementReport extends Model {

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

	public function getItemMovementReport($data) {

		$start_date = date("Y",strtotime("-1 year"));
		$end_date = date('Y');

		$query_item = $this->db2->query("SELECT a.iitemid, a.vbarcode, a.vitemname, CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND FROM mst_item as a WHERE a.vbarcode='". $this->db->escape($data['search_vbarcode']) ."'")->row;

		$sql = "SELECT ifnull(SUM(trn_sd.ndebitqty),0) as items_sold, date_format(trn_s.dtrandate,'%m-%Y') as dtrandate FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode='". $this->db->escape($data['search_vbarcode']) ."' AND (date_format(trn_s.dtrandate,'%Y') BETWEEN '".$start_date."' AND '".$end_date."') GROUP BY date_format(trn_s.dtrandate,'%m-%Y')";

		$query_data = $this->db2->query($sql)->rows;


		$sql1 = "SELECT ifnull(SUM(tpd.itotalunit),0) as items_receive, DATE_FORMAT(tp.dcreatedate,'%m-%Y') as dcreatedate FROM trn_purchaseorderdetail tpd LEFT JOIN trn_purchaseorder tp ON (tpd.ipoid = tp.ipoid) WHERE tpd.vitemid='". $this->db->escape($data['search_iitemid']) ."' AND (date_format(tp.dcreatedate,'%Y') BETWEEN '".$start_date."' AND '".$end_date."') GROUP BY date_format(tp.dcreatedate,'%m-%Y')";

		$query_data1 = $this->db2->query($sql1)->rows;

		$year_arr_sold = array();
		$month_year_arr_sold = array();

		$year_arr_receive = array();
		$month_year_arr_receive = array();

		if(count($query_data) > 0){
			foreach ($query_data as $key => $value) {
				$t = explode('-', $value['dtrandate']);

				if(array_key_exists($t[1], $year_arr_sold)){
					$year_arr_sold[$t[1]]['total_sold'] = $year_arr_sold[$t[1]]['total_sold'] + $value['items_sold'];
				}else{
					$year_arr_sold[$t[1]]['total_sold'] = $value['items_sold'];
				}

				if(array_key_exists($t[1], $month_year_arr_sold)){
					if(array_key_exists($t[0], $month_year_arr_sold[$t[1]])){
						$month_year_arr_sold[$t[1]][$t[0]]['total_sold'] = $month_year_arr_sold[$t[1]][$t[0]]['total_sold'] + $value['items_sold'];
					}else{
						$month_year_arr_sold[$t[1]][$t[0]]['total_sold'] = $value['items_sold'];
					}

				}else{
					$month_year_arr_sold[$t[1]][$t[0]]['total_sold'] = $value['items_sold'];
				}
			}

		}

		if(count($query_data1) > 0){
			foreach ($query_data1 as $key => $value) {
				$t = explode('-', $value['dcreatedate']);

				if(array_key_exists($t[1], $year_arr_receive)){
					$year_arr_receive[$t[1]]['total_receive'] = $year_arr_receive[$t[1]]['total_receive'] + $value['items_receive'];
				}else{
					$year_arr_receive[$t[1]]['total_receive'] = $value['items_receive'];
				}

				if(array_key_exists($t[1], $month_year_arr_receive)){
					if(array_key_exists($t[0], $month_year_arr_receive[$t[1]])){
						$month_year_arr_receive[$t[1]][$t[0]]['total_receive'] = $month_year_arr_receive[$t[1]][$t[0]]['total_receive'] + $value['items_receive'];
					}else{
						$month_year_arr_receive[$t[1]][$t[0]]['total_receive'] = $value['items_receive'];
					}

				}else{
					$month_year_arr_receive[$t[1]][$t[0]]['total_receive'] = $value['items_receive'];
				}
			}

		}

		$return = array();
		
		$return['item_data'] = $query_item;
		$return['year_arr_sold'] = $year_arr_sold;
		$return['year_arr_receive'] = $year_arr_receive;
		$return['month_year_arr_sold'] = $month_year_arr_sold;
		$return['month_year_arr_receive'] = $month_year_arr_receive;

		return $return;
	}

	public function getItemsSearchResult($search) {

        $datas = array();

        $query = $this->db2->query("SELECT DISTINCT(mi.iitemid),mi.vbarcode,mi.vitemname FROM mst_item as mi WHERE mi.estatus='Active' AND (mi.vitemname LIKE  '%" .$this->db->escape($search). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search). "%')");

        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {

                $temp = array();
                $temp['iitemid'] = $value['iitemid'];
                $temp['vitemname'] = $value['vitemname'];
                $temp['vbarcode'] = $value['vbarcode'];
                
                $datas[] = $temp;
            }
        }

        return $datas;
    }

    public function getItemMovementData($vbarcode,$start_date,$end_date,$data_by) {

        $start_date = DateTime::createFromFormat('m-d-Y', $start_date);
        $start_date = $start_date->format('Y-m-d');

        $end_date = DateTime::createFromFormat('m-d-Y', $end_date);
        $end_date = $end_date->format('Y-m-d');

        if(!empty($data_by) && $data_by == 'sold'){

        	$sql = "SELECT trn_sd.idettrnid as idettrnid,trn_sd.isalesid as isalesid,trn_sd.ndebitqty as items_count, date_format(trn_s.dtrandate,'%m-%d-%Y %h:%i %p') as ddate, trn_sd.npack as npack, trn_sd.vsize as size, trn_sd.nunitprice as dunitprice, trn_sd.ndebitqty as total_qoh, trn_sd.nextunitprice as total_price  FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode='". $this->db->escape($vbarcode) ."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$start_date."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$end_date."'";

            $query_data = $this->db2->query($sql)->rows;


        }else if(!empty($data_by) && $data_by == 'receive'){

        	$sql1 = "SELECT tpd.itotalunit as items_count, tpd.npackqty as npack, tpd.vsize as size, tpd.nordunitprice as dunitprice,tpd.itotalunit as total_qoh , (tpd.nordunitprice * tpd.itotalunit) as total_price, DATE_FORMAT(tp.dcreatedate,'%m-%d-%Y %h:%i %p') as ddate FROM trn_purchaseorderdetail tpd LEFT JOIN trn_purchaseorder tp ON (tpd.ipoid = tp.ipoid) WHERE tpd.vbarcode='". $this->db->escape($vbarcode) ."' AND date_format(tp.dcreatedate,'%Y-%m-%d') >= '".$start_date."' AND date_format(tp.dcreatedate,'%Y-%m-%d') <= '".$end_date."'";

			$query_data = $this->db2->query($sql1)->rows;
        }

        return $query_data;
    }

    public function getSalesById($salesid) {
        $sql = "SELECT *,date_format(dtrandate,'%m-%d-%Y %h:%i %p') as trandate FROM trn_sales WHERE isalesid = ". $salesid;

        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function getSalesPerview($idettrnid){
        
        $query=$this->db2->query("select * from trn_salesdetail a  where a.idettrnid=".$idettrnid);   
        
        return $query->row;    
    }

    public function getSalesByTender($salesid) {
        $sql = "SELECT * FROM trn_salestender WHERE isalesid = ". $salesid;

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getSalesByCustomer($icustomerid) {
        $query = $this->db2->query("SELECT * FROM mst_customer WHERE icustomerid='" .(int)$icustomerid. "'");

        return $query->row;
    }
}
