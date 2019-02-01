<?php
class ModelAdministrationStoreSetting extends Model {

	public function editStoreSettingList($data) {
		
		if(isset($data['store_setting']))
		{
			$store_time = $data['store_setting']['StoreTime_s']. ',' .$data['store_setting']['StoreTime_e'];

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['RequiredPassword']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['RequiredPassword_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['SameProduct']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['SameProduct_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Geographical_Information']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Geographical_Information_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Allowdiscountlessthencostprice']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Allowdiscountlessthencostprice_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['AllowUpdateQoh']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['AllowUpdateQoh_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $store_time . "' WHERE Id = '" . $this->db->escape($data['store_setting']['StoreTime_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Defaultageverificationdate']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Defaultageverificationdate_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Tax1seletedfornewItem']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Tax1seletedfornewItem_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['ShowlowlevelInventory']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['ShowlowlevelInventory_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['AskBeginningbalanceindollar']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['AskBeginningbalanceindollar_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['AskReasonforvoidtransaction']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['AskReasonforvoidtransaction_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Updateallregisterquickitemonce']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Updateallregisterquickitemonce_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['AskItemPriceConfirmation']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['AskItemPriceConfirmation_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Showquotation']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Showquotation_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['QutaInventory']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['QutaInventory_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['QutaTax']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['QutaTax_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['Dobackupwhenlogin']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['Dobackupwhenlogin_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['AlertEmail']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['AlertEmail_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['ZeroItemPriceUpdate']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['ZeroItemPriceUpdate_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['ShowChangeDuewnd']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['ShowChangeDuewnd_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['EnableQuickItemScreen']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['EnableQuickItemScreen_id']) . "'");

			$this->db2->query("UPDATE mst_storesetting SET 	vsettingvalue = '" . $this->db->escape($data['store_setting']['ZreportEmail']) . "' WHERE Id = '" . $this->db->escape($data['store_setting']['ZreportEmail_id']) . "'");

		}
		
	  }

	public function getStoreSettings($data = array()) {
		$sql = "SELECT * FROM mst_storesetting WHERE Id  BETWEEN 347 AND 369";

		$query = $this->db2->query($sql);

		return $query->rows;
	}
	
}
