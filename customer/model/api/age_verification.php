<?php
class ModelApiAgeVerification extends Model {
    public function getAgeVerifications() {
        $query = $this->db2->query("SELECT * FROM mst_ageverification");

        return $query->rows;
    }

    public function getAgeVerification($age_verification_id) {
        $query = $this->db2->query("SELECT * FROM mst_ageverification WHERE Id='" .(int)$age_verification_id. "'");

        return $query->row;
    }
    
    public function getAgeVerificationByValue($value) {
        $query = $this->db2->query("SELECT * FROM mst_ageverification WHERE vvalue='" . $this->db->escape($value) . "'");

        return $query->row;
    }

    public function getAgeVerificationsSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_ageverification WHERE vname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addAgeVerification($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {
               try {
                    $this->db2->query("INSERT INTO mst_ageverification SET vname = '" . $this->db->escape($value['vname']) . "',`vvalue` = '" . $this->db->escape($value['vvalue']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Age Verification';
        return $success;
    }
    
    public function addAgeVerificationByValue($value) {

        $success =array();
        $error =array();

       try {
            $this->db2->query("INSERT INTO mst_ageverification SET vname = '". $this->db->escape($value) ."',`vvalue` = '" . $this->db->escape($value) . "',SID = '" . (int)($this->session->data['sid'])."'");
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


        $success['success'] = 'Successfully Added Age Verification';
        return $success;
    }    
    

    public function editlistAgeVerification($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {

               try {
                    $this->db2->query("UPDATE mst_ageverification SET vname = '" . $this->db->escape($value['vname']) . "',`vvalue` = '" . $this->db->escape($value['vvalue']) . "' WHERE Id = '" . (int)$value['Id'] . "'");
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

        $success['success'] = 'Successfully Updated Age Verification';
        return $success;
    }

}
?>