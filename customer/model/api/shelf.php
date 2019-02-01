<?php
class ModelApiShelf extends Model {
    public function getTotalShelfs($data = array()) {
        $sql = "SELECT * FROM mst_shelf";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE Id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY Id DESC";

        $query = $this->db2->query($sql);


        return count($query->rows);
    }

    public function getShelfs($data = array()) {
        
        $sql = "SELECT * FROM mst_shelf";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE Id= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY Id DESC";

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

    public function getShelf($aisle_id) {
        $query = $this->db2->query("SELECT * FROM mst_shelf WHERE Id='" .(int)$aisle_id. "'");

        return $query->row;
    }

    public function getShelfSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_shelf WHERE shelfname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addShelf($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {
               try {
                    $this->db2->query("INSERT INTO mst_shelf SET shelfname = '" . $this->db->escape($value['shelfname']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Shelf';
        return $success;
    }

    public function editlistShelf($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {

               try {
                    $exists = $this->db2->query("SELECT * FROM mst_shelf WHERE Id = '" . (int)$value['Id'] . "'")->rows;

                    if(count($exists) > 0){
                        $this->db2->query("UPDATE mst_shelf SET shelfname = '" . $this->db->escape($value['shelfname']) . "' WHERE Id = '" . (int)$value['Id'] . "'");
                    }else{
                        $this->db2->query("INSERT INTO mst_shelf SET shelfname = '" . $this->db->escape($value['shelfname']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Updated Shelf';
        return $success;
    }

}
?>