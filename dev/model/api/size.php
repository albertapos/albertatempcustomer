<?php
class ModelApiSize extends Model {
    public function getTotalSizes($data = array()) {
        $sql = "SELECT * FROM mst_size";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE isizeid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY isizeid DESC";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

    public function getSizes($data = array()) {
        
        $sql = "SELECT * FROM mst_size";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE isizeid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY isizeid DESC";

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

    public function getSize($isizeid) {
        $query = $this->db2->query("SELECT * FROM mst_size WHERE isizeid='" .(int)$isizeid. "'");

        return $query->row;
    }

    public function getSizeByName($size) {
        $query = $this->db2->query("SELECT * FROM mst_size WHERE vsize='" .$size. "'");

        return $query->row;
    }

    public function getSizeSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_size WHERE vsize LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addSize($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {
               try {
                    $this->db2->query("INSERT INTO mst_size SET vsize = '" . $this->db->escape($value['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Size';
        return $success;
    }

    public function addSizeByName($size) {

        $success =array();
        $error =array();

        try {
            $this->db2->query("INSERT INTO mst_size SET vsize = '" . $this->db->escape($size) . "',SID = '" . (int)($this->session->data['sid'])."'");

            $last_id = $this->db2->getLastId();

            $query = $this->db2->query("SELECT * FROM mst_size WHERE isizeid='" .(int)$last_id. "'")->row;

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

        return $query['vsize'];
    }

    public function editlistSize($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {

               try {
                    $exists = $this->db2->query("SELECT * FROM mst_size WHERE isizeid = '" . (int)$value['isizeid'] . "'")->rows;

                    if(count($exists) > 0){
                        $this->db2->query("UPDATE mst_size SET vsize = '" . $this->db->escape($value['vsize']) . "' WHERE isizeid = '" . (int)$value['isizeid'] . "'");
                    }else{
                        $this->db2->query("INSERT INTO mst_size SET vsize = '" . $this->db->escape($value['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Updated Size';
        return $success;
    }

}
?>