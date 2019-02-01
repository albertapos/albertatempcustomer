<?php
class ModelApiCustomerReport extends Model {
    public function getCustomers() {
        $query = $this->db2->query("SELECT * FROM mst_customer ORDER BY icustomerid DESC");

        return $query->rows;
    }

    public function getCustomerPay($icustomerid) {
        $query = $this->db2->query("SELECT *,DATE_FORMAT(dtrandate,'%m-%d-%Y') as dtrandate FROM trn_customerpay  WHERE icustomerid = '" . (int)$icustomerid . "' order by DATE_FORMAT(dtrandate,'%m-%d-%Y')");

        return $query->rows;
    }

}
?>