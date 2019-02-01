<?php
class ModelApiTax extends Model {
    public function getTax() {
        $query = $this->db2->query("SELECT * FROM mst_tax ORDER BY Id ASC");

        return $query->rows;
    }

    public function getTaxById($Id) {
        $query = $this->db2->query("SELECT * FROM mst_tax WHERE Id='" .(int)$Id. "'");

        return $query->row;
    }

    public function gettaxSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_tax WHERE vtaxcode LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function editlistTax($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_tax SET vtaxtype = '" . $this->db->escape($data['vtaxtype']) . "',`ntaxrate` = '" . $this->db->escape($data['ntaxrate']) . "' WHERE Id = '" . (int)$data['Id'] . "' ");
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

        $success['success'] = 'Successfully Updated Tax';
        return $success;
    }

}
?>