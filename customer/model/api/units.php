<?php
class ModelApiUnits extends Model {
    public function getUnits($data = array()) {

        $sql = "SELECT * FROM mst_unit";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE iunitid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY iunitid DESC";

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

    public function getUnitsTotal($data = array()) {

        $sql = "SELECT * FROM mst_unit";
            
        if(!empty($data['searchbox'])){
            $sql .= " WHERE iunitid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY iunitid DESC";

        $query = $this->db2->query($sql);


        return count($query->rows);
    }

    public function getUnit($iunitid) {
        $query = $this->db2->query("SELECT * FROM mst_unit WHERE iunitid='" .(int)$iunitid. "'");

        return $query->row;
    }
    
    public function getUnitByName($unit) {
        $query = $this->db2->query("SELECT * FROM mst_unit WHERE vunitname='" .$unit. "'");

        return $query->row;
    }

    public function getUnitAllData($vunitcode,$vunitname) {
        $query = $this->db2->query("SELECT * FROM mst_unit WHERE vunitcode='" .$this->db->escape($vunitcode). "' AND vunitname='" .$this->db->escape($vunitname). "' ");

        return $query->row;
    }

    public function getUnitCode($vunitcode) {
        $query = $this->db2->query("SELECT * FROM mst_unit WHERE vunitcode = '" . $this->db->escape($vunitcode) . "'");

        return $query->rows;
    }

    public function getUnitSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_unit WHERE iunitid LIKE  '%" .$this->db->escape($search). "%' OR vunitcode LIKE  '%" .$this->db->escape($search). "%' OR vunitname LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addUnits($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

               try {
                    $this->db2->query("INSERT INTO mst_unit SET  vunitcode = '" . $this->db->escape($data['vunitcode']) . "',`vunitname` = '" . $this->db->escape($data['vunitname']) . "', vunitdesc = '" . $this->db->escape($data['vunitdesc']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");

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

        $success['success'] = 'Successfully Added Unit';
        return $success;
    }
    
    public function addUnitByName($unit) {

        $success =array();
        $error =array();

        try {
            $max_id = $this->db2->getLastId();
            
            // $vunitcode = "UNT00".$max_id+1;
            
            $this->db2->query("INSERT INTO mst_unit SET `vunitname` = '" . $this->db->escape($unit) . "', vunitdesc = '" . $this->db->escape($unit) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['sid'])."'");

            $iunitid = $this->db2->getLastId();
            
            $vunitcode = "UNT00".$iunitid;

            $this->db2->query("UPDATE mst_unit SET vunitcode = '" . $vunitcode . "' WHERE iunitid = '" . (int)$iunitid . "'");

            $query = $this->db2->query("SELECT * FROM mst_unit WHERE iunitid='" .(int)$last_id. "'")->row;

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

        return $query['vunitcode'];
    }

    public function editlistUnits($iunitid,$data = array()) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

                try {
                    $this->db2->query("UPDATE mst_unit SET  vunitcode = '" . $this->db->escape($data['vunitcode']) . "',`vunitname` = '" . $this->db->escape($data['vunitname']) . "', vunitdesc = '" . $this->db->escape($data['vunitdesc']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "' WHERE iunitid = '" . (int)$iunitid . "'");
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

        $success['success'] = 'Successfully Updated Unit';
        return $success;
    }

}
?>