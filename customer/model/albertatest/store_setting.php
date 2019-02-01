<?php
class ModelApiStoreSetting extends Model {
    public function getStoreSettings() {
        $query = $this->db2->query("SELECT `vsettingname`, `vsettingvalue` FROM mst_storesetting GROUP BY  `vsettingname` ");

        return $query->rows;
    }

    public function editlistStoreSettings($data = array()) {

        $success =array();
        $error =array();
        $storeid = $this->db2->query("SELECT * FROM mst_store")->row;
        
        if(isset($data) && count($data) > 0){
            
            try {
                foreach ($data as $key => $value) {
                
                $exists = $this->db2->query("SELECT * FROM mst_storesetting WHERE vsettingname = '" . $this->db->escape($key) . "'")->rows;
                if(count($exists) > 0){
                    $this->db2->query("UPDATE mst_storesetting SET  vsettingvalue = '" . $this->db->escape($value) . "' WHERE vsettingname = '" . $this->db->escape($key) . "' ");
                }else{
                    $this->db2->query("INSERT INTO mst_storesetting SET  vsettingvalue = '" . $this->db->escape($value) . "', vsettingname = '" . $this->db->escape($key) . "', istoreid = '" . $storeid['istoreid'] . "',estatus = 'Active',SID = '" . (int)($this->session->data['sid'])."'");
                }

                

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

        $success['success'] = 'Successfully Updated Store Setting';
        return $success;
    }

}
?>