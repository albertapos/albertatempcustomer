<?php
class ModelApiSettings extends Model {
    public function getSettings() {
        $query = $this->db2->query("SELECT * FROM web_admin_settings");

        return $query->rows;
    }

    public function getSetting($variablename) {
        $query = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename='" .$variablename. "'");

        return $query->row;
    }

    public function getSettingsSearch($search) {
        $query = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addSettings($data = array()) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){
           try {
                $settings_exist = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename='". $data['variablename'] ."'")->rows;

                if(count($settings_exist) > 0){
                    $this->db2->query("UPDATE web_admin_settings SET  variablevalue = '" . json_encode($data['variablevalue']) . "' WHERE variablename='". $data['variablename'] ."'");
                }else{
                    $this->db2->query("INSERT INTO web_admin_settings SET variablename = '". $data['variablename'] ."', variablevalue = '" . json_encode($data['variablevalue']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Settings';
        return $success;
    }

    public function editlistSettings($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

           try {
                $settings_exist = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename='". $data['variablename'] ."'")->rows;

                if(count($settings_exist) > 0){
                    $this->db2->query("UPDATE web_admin_settings SET  variablevalue = '" . json_encode($data['variablevalue']) . "' WHERE variablename='". $data['variablename'] ."'");
                }else{
                    $this->db2->query("INSERT INTO web_admin_settings SET variablename = '". $data['variablename'] ."', variablevalue = '" . json_encode($data['variablevalue']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Updated Settings';
        return $success;
    }

}
?>