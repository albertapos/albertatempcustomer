<?php
class ModelApiGroupSlabPricing extends Model {
    public function getGroupSlabPricings($iitemgroupid = null) {
        $query = $this->db2->query("SELECT * FROM mst_groupslabprice WHERE iitemgroupid='". $iitemgroupid ."'");

        return $query->rows;
    }

    public function getGroupSlabPricing($igroupslabid) {
        $query = $this->db2->query("SELECT * FROM mst_groupslabprice WHERE igroupslabid='" .(int)$igroupslabid. "'");

        return $query->row;
    }

    public function getVendorSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE vcompanyname LIKE  '%" .$this->db->escape($search). "%' OR vfnmae LIKE  '%" .$this->db->escape($search). "%' OR vlname LIKE  '%" .$this->db->escape($search). "%' OR vcity LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addGroupSlabPricing($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $start_date = DateTime::createFromFormat('m-d-Y H:i:s', $data['startdate']);
                    $data['startdate'] = $start_date->format('Y-m-d H:i:s');

                    $end_date = DateTime::createFromFormat('m-d-Y H:i:s', $data['enddate']);
                    $data['enddate'] = $end_date->format('Y-m-d H:i:s');

                    if($data['slicetype'] == 'percentage'){
                        $this->db2->query("INSERT INTO mst_groupslabprice SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`iqty` = '" . (int)$this->db->escape($data['iqty']) . "', nunitprice = '" . $this->db->escape($data['nunitprice']) . "',`percentage` = '" . $this->db->escape($data['percentage']) . "',`startdate` = '" . $this->db->escape($data['startdate']) . "', enddate = '" . $this->db->escape($data['enddate']) . "', status = '" . (int)$this->db->escape($data['status']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                    }else{
                        $this->db2->query("INSERT INTO mst_groupslabprice SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`iqty` = '" . (int)$this->db->escape($data['iqty']) . "', nunitprice = '" . $this->db->escape($data['nunitprice']) . "',`nprice` = '" . $this->db->escape($data['nprice']) . "',`startdate` = '" . $this->db->escape($data['startdate']) . "', enddate = '" . $this->db->escape($data['enddate']) . "', status = '" . (int)$this->db->escape($data['status']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                    }

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
            }
        }

        $success['success'] = 'Successfully Added Group Slab Pricing';
        return $success;
    }

    public function editlistGroupSlabPricing($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

                $start_date = DateTime::createFromFormat('m-d-Y H:i:s', $data['startdate']);
                $data['startdate'] = $start_date->format('Y-m-d H:i:s');

                $end_date = DateTime::createFromFormat('m-d-Y H:i:s', $data['enddate']);
                $data['enddate'] = $end_date->format('Y-m-d H:i:s');

              try {

                    if($data['slicetype'] == 'percentage'){
                        $this->db2->query("UPDATE mst_groupslabprice SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`iqty` = '" . (int)$this->db->escape($data['iqty']) . "', nunitprice = '" . $this->db->escape($data['nunitprice']) . "',`percentage` = '" . $this->db->escape($data['percentage']) . "',`startdate` = '" . $this->db->escape($data['startdate']) . "', enddate = '" . $this->db->escape($data['enddate']) . "', status = '" . (int)$this->db->escape($data['status']) . "' WHERE igroupslabid = '" . (int)$this->db->escape($data['igroupslabid']) . "'");
                    }else{

                        $this->db2->query("UPDATE mst_groupslabprice SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`iqty` = '" . (int)$this->db->escape($data['iqty']) . "', nunitprice = '" . $this->db->escape($data['nunitprice']) . "',`nprice` = '" . $this->db->escape($data['nprice']) . "',`startdate` = '" . $this->db->escape($data['startdate']) . "', enddate = '" . $this->db->escape($data['enddate']) . "', status = '" . (int)$this->db->escape($data['status']) . "' WHERE igroupslabid = '" . (int)$this->db->escape($data['igroupslabid']) . "'");
                    }

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }

            }

        }

        $success['success'] = 'Successfully Updated Group Slab Pricing';
        return $success;
    }

    public function deleteGroupSlabPricingItem($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach($datas as $value){
                try {
                    
                    $exist_igroupslabid = $this->db2->query("SELECT `igroupslabid` FROM mst_groupslabprice WHERE igroupslabid='" . (int)$value . "' ")->row;

                    if(count($exist_igroupslabid) > 0){
                        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_groupslabprice',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");
                        $this->db2->query("DELETE FROM mst_groupslabprice WHERE igroupslabid='" . (int)$value . "'");
                    }

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage(); 
                    return $error; 
                }
            }
        }

        $success['success'] = 'Successfully Deleted Group Slab Pricing';
        return $success;
    }

}
?>