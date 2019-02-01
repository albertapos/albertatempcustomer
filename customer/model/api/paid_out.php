<?php
class ModelApiPaidOut extends Model {
    public function getPaidOuts() {
        $query = $this->db2->query("SELECT * FROM mst_paidout ORDER BY ipaidoutid DESC");

        return $query->rows;
    }

    public function getPaidOut($ipaidoutid) {
        $query = $this->db2->query("SELECT * FROM mst_paidout WHERE ipaidoutid='" .(int)$ipaidoutid. "'");

        return $query->row;
    }

    public function getPaidOutSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_paidout WHERE vpaidoutname LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addPaidOut($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $value) {

               try {
                    $this->db2->query("INSERT INTO mst_paidout SET vpaidoutname = '" . $this->db->escape($value['vpaidoutname']) . "',`estatus` = '" . $this->db->escape($value['estatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Paid Out';
        return $success;
    }

    public function editlistPaidOut($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $value) {

              try {
                    $this->db2->query("UPDATE mst_paidout SET vpaidoutname = '" . $this->db->escape($value['vpaidoutname']) . "',`estatus` = '" . $this->db->escape($value['estatus']) . "' WHERE ipaidoutid = '" . (int)$value['ipaidoutid'] . "'");
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

        $success['success'] = 'Successfully Updated Paid Out';
        return $success;
    }

}
?>