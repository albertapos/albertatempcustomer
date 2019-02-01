<?php
class ModelAdministrationSettings extends Model {

	public function editlistSettings($data = array()) {

		$settings_exist = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename='ItemListing'")->rows;

		if(count($settings_exist) > 0){
			$this->db2->query("UPDATE web_admin_settings SET  variablevalue = '" . json_encode($data) . "' WHERE variablename = 'ItemListing'");
		}else{
			$this->db2->query("INSERT INTO web_admin_settings SET variablename = 'ItemListing', variablevalue = '" . json_encode($data) . "',SID = '" . (int)($this->session->data['SID'])."'");
		}
	}

	public function defaultListings() {
		$query = $this->db2->query("SHOW COLUMNS FROM mst_item");

		return $query->rows;
	}

	public function getItemListings() {
		$query = $this->db2->query("SELECT variablevalue FROM web_admin_settings WHERE variablename='ItemListing'")->row;

		return $query;
	}
	
}
