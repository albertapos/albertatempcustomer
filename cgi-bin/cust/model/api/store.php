<?php
class ModelApiStore extends Model {
    public function getStore() {
        $query = $this->db2->query("SELECT * FROM mst_store");

        return $query->row;
    }

    public function editlistStore($data = array()) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

                try {
                    $this->db2->query("UPDATE mst_store SET  vcompanycode = '" . $this->db->escape($data['vcompanycode']) . "',`vstorename` = '" . $this->db->escape($data['vstorename']) . "', vstoredesc = '" . $this->db->escape($data['vstoredesc']) . "',`vstoreabbr` = '" . $this->db->escape($data['vstoreabbr']) . "',`vaddress1` = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vphone1 = '" . $this->db->escape($data['vphone1']) . "', vphone2 = '" . $this->db->escape($data['vphone2']) . "', vfax1 = '" . $this->db->escape($data['vfax1']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vwebsite = '" . $this->db->escape($data['vwebsite']) . "', vcontactperson = '" . $this->db->escape($data['vcontactperson']) . "', isequence = '" . $this->db->escape($data['isequence']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vmessage1 = '" . $this->db->escape($data['vmessage1']) . "', vmessage1 = '" . $this->db->escape($data['vmessage1']) . "' WHERE istoreid = '" . (int)$this->db->escape($data['istoreid']) . "'");
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

        $success['success'] = 'Successfully Updated Store';
        return $success;
    }

}
?>