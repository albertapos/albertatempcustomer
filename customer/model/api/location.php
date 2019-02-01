<?php
class ModelApiLocation extends Model {
    public function getLocations($data = array()) {
        
        $sql = "SELECT * FROM mst_location";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE ilocid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ilocid DESC";

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

    public function getLocationsTotal($data = array()) {
        
        $sql = "SELECT * FROM mst_location";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE ilocid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ilocid DESC";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

    public function getLocation($ilocid) {
        $query = $this->db2->query("SELECT * FROM mst_location WHERE ilocid='" .(int)$ilocid. "'");

        return $query->row;
    }

    public function getLocationSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_location WHERE vlocname LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addLocation($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO mst_location SET  vlocname = '" . $this->db->escape($data['vlocname']) . "',`vlocdesc` = '" . $this->db->escape($data['vlocdesc']) . "',SID = '" . (int)($this->session->data['sid'])."'");

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

        $success['success'] = 'Successfully Added Location';
        return $success;
    }

    public function editlistLocation($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_location SET  vlocname = '" . $this->db->escape($data['vlocname']) . "',`vlocdesc` = '" . $this->db->escape($data['vlocdesc']) . "' WHERE ilocid = '" . (int)$this->db->escape($data['ilocid']) . "'");
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

        $success['success'] = 'Successfully Updated Location';
        return $success;
    }

}
?>