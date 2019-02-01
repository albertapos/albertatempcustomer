<?php
class ModelCommonDashboard extends Model {

	public function getSales($date = null) {

		if(empty($date)){
			$date = date('Y-m-d');
		}
		$store_id = $this->session->data['sid'];
		$fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));

		$return = array();

		$query1 = $this->db2->query("SELECT sum(nnettotal) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59') AND vtrntype='Transaction' AND SID='".(int)$store_id."'")->row;

		if($query1['total'] > 0){
			$return['today'] = $query1['total'];
		}else{
			$return['today'] = 0;
		}

		$query2 = $this->db2->query("SELECT sum(nnettotal) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$tdate." 00:00:00' AND '".$tdate." 23:59:59') AND vtrntype='Transaction' AND SID='".(int)$store_id."'")->row;

		if($query2['total'] > 0){
			$return['yesterday'] = $query2['total'];
		}else{
			$return['yesterday'] = 0;
		}

		$fdate1 = $fdate.' 00:00:00';
		$date1 = $date.' 23:59:59';

		$query3 = $this->db2->query("SELECT sum(nnettotal) AS total FROM trn_sales WHERE date_format(dtrandate,'%Y-%m-%d %H:%i:%s') >= '".$fdate1."' and date_format(dtrandate,'%Y-%m-%d %H:%i:%s') <= '".$date1."' AND vtrntype='Transaction' AND SID='".(int)$store_id."'")->row;

		if($query3['total'] > 0){
			$return['week'] = $query3['total'];
		}else{
			$return['week'] = 0;
		}
		return $return;
	}

	public function getCustomers($date = null) {

		if(empty($date)){
			$date = date('Y-m-d');
		}
		$store_id = $this->session->data['sid'];
		$fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));

		$return = array();

		$query1 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59') AND SID='".(int)$store_id."'")->row;

		if(count($query1) > 0){
			$return['today'] = $query1['total'];
		}else{
			$return['today'] = 0;
		}

		$query2 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$tdate." 00:00:00' AND '".$tdate." 23:59:59') AND SID='".(int)$store_id."'")->row;

		if(count($query2) > 0){
			$return['yesterday'] = $query2['total'];
		}else{
			$return['yesterday'] = 0;
		}

		$fdate1 = $fdate.' 00:00:00';
		$date1 = $date.' 23:59:59';

		$query3 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE date_format(dtrandate,'%Y-%m-%d %H:%i:%s') >= '".$fdate1."' and date_format(dtrandate,'%Y-%m-%d %H:%i:%s') <= '".$date1."' AND SID='".(int)$store_id."'")->row;

		if(count($query3) > 0){
			$return['week'] = $query3['total'];
		}else{
			$return['week'] = 0;
		}

		return $return;
	}

	public function getVoid($date = null) {

		if(empty($date)){
			$date = date('Y-m-d');
		}
		$store_id = $this->session->data['sid'];
		$fdate = date("Y-m-d", (strtotime($date)) - (7*24*60*60));
        $tdate = date("Y-m-d", (strtotime($date)) - (24*60*60));

		$return = array();

		$query1 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59') AND vtrntype='Void' AND SID='".(int)$store_id."'")->row;

		if(count($query1) > 0){
			$return['today'] = $query1['total'];
		}else{
			$return['today'] = 0;
		}

		$query2 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE (date_format(dtrandate,'%Y-%m-%d %H:%i:%s') BETWEEN '".$tdate." 00:00:00' AND '".$tdate." 23:59:59') AND vtrntype='Void' AND SID='".(int)$store_id."'")->row;

		if(count($query2) > 0){
			$return['yesterday'] = $query2['total'];
		}else{
			$return['yesterday'] = 0;
		}

		$fdate1 = $fdate.' 00:00:00';
		$date1 = $date.' 23:59:59';

		$query3 = $this->db2->query("SELECT count(isalesid) AS total FROM trn_sales WHERE date_format(dtrandate,'%Y-%m-%d %H:%i:%s') >= '".$fdate1."' and date_format(dtrandate,'%Y-%m-%d %H:%i:%s') <= '".$date1."' AND vtrntype='Void' AND SID='".(int)$store_id."'")->row;

		if(count($query3) > 0){
			$return['week'] = $query3['total'];
		}else{
			$return['week'] = 0;
		}
		return $return;
	}

	public function getchartsValues($url) {
		$return_data = array();
		if(!empty($url)){
			$curl = curl_init();
	        curl_setopt_array($curl, array(
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_URL => $url
	        ));
	        $data = curl_exec($curl);
	        $info = curl_getinfo($curl);
	        curl_close($curl);

	        $return_data = json_decode($data);

	        if(count($return_data) > 0){
	        	foreach ($return_data as $key => $value) {
		        	if($key == 'data'){
		        		$return_data = $value;
		        	}
		        }
	        }
		}
		return $return_data;
	}

}
