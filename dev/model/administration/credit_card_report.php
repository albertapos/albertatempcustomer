<?php
class ModelAdministrationCreditCardReport extends Model {

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

	public function getCreditCardReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		
		$sql = "SELECT count(trn_mps.nauthamount) as transaction_number,ifnull(SUM(trn_mps.nauthamount),0) as nauthamount, trn_mps.vcardtype as vcardtype FROM trn_mpstender trn_mps WHERE trn_mps.vcardtype !='' AND trn_mps.nauthamount !=0 AND date_format(trn_mps.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_mps.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' GROUP BY trn_mps.vcardtype ";

    	$query = $this->db2->query($sql);
		

		return $query->rows;
	}

	public function ajaxDataCreditCardReport($data) {

		$start_date = DateTime::createFromFormat('m-d-Y', $data['start_date']);
		$data['start_date'] = $start_date->format('Y-m-d');

		$end_date = DateTime::createFromFormat('m-d-Y', $data['end_date']);
		$data['end_date'] = $end_date->format('Y-m-d');

		
		$sql = "SELECT trn_mps.impstenderid as id, date_format(trn_mps.dtrandate,'%m-%d-%Y') as date, date_format(trn_mps.dtrandate,'%h:%i %p') as time, trn_mps.nauthamount as amount, trn_mps.vauthcode as approvalcode, trn_mps.vcardusage as last_four_of_cc, trn_mps.vcardtype as vcardtype FROM trn_mpstender trn_mps WHERE trn_mps.vcardtype !='' AND trn_mps.nauthamount!=0 AND date_format(trn_mps.dtrandate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(trn_mps.dtrandate,'%Y-%m-%d') <= '".$data['end_date']."' AND trn_mps.vcardtype='". $this->db->escape($data['report_pull_by']) ."' ";

    	$query = $this->db2->query($sql)->rows;

		return $query;
	}

	public function getReceiptData($id,$by) {
		
		$sql = "SELECT trn_mps.impstenderid as id, date_format(trn_mps.dtrandate,'%m-%d-%Y') as date, date_format(trn_mps.dtrandate,'%h:%i %p') as time, trn_mps.nauthamount as amount, trn_mps.vauthcode as approvalcode, trn_mps.vcardusage as last_four_of_cc, trn_mps.vcardtype as vcardtype, trn_mps.itranid as isalesid FROM trn_mpstender trn_mps WHERE trn_mps.impstenderid='". (int)$id ."' ";

    	$query = $this->db2->query($sql)->row;

		return $query;
	}

	public function getSalesById($salesid) {
		$sql = "SELECT *,date_format(dtrandate,'%m-%d-%Y %h:%i %p') as trandate FROM trn_sales WHERE isalesid = ". $salesid;

		$query = $this->db2->query($sql);

		return $query->row;
	}

	public function getSalesPerview($isalesid){
		
		$query=$this->db2->query("select * from trn_salesdetail a  where a.isalesid=".$isalesid);	
		
		return $query->rows;	
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
