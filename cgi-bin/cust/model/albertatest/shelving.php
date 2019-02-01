<?php
class ModelApiShelving extends Model {
    public function getTotalShelvings() {
        $sql = "SELECT * FROM mst_shelving";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY id DESC";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

    public function getShelvings($data = array()) {
        
        $sql = "SELECT * FROM mst_shelving";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY id DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getShelving($shelving_id) {
        $query = $this->db2->query("SELECT * FROM mst_shelving WHERE id='" .(int)$shelving_id. "'");

        return $query->row;
    }

    public function getShelvingSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_shelving WHERE shelvingname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addShelving($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {
               try {
                    $this->db2->query("INSERT INTO mst_shelving SET shelvingname = '" . $this->db->escape($value['shelvingname']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Shelving';
        return $success;
    }

    public function editlistShelving($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {

               try {
                    $exists = $this->db2->query("SELECT * FROM mst_shelving WHERE id = '" . (int)$value['id'] . "'")->rows;

                    if(count($exists) > 0){
                        $this->db2->query("UPDATE mst_shelving SET shelvingname = '" . $this->db->escape($value['shelvingname']) . "' WHERE id = '" . (int)$value['id'] . "'");
                    }else{
                        $this->db2->query("INSERT INTO mst_shelving SET shelvingname = '" . $this->db->escape($value['shelvingname']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Updated Shelving';
        return $success;
    }

}
?>