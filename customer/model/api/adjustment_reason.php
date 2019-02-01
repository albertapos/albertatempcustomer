<?php
class ModelApiAdjustmentReason extends Model {
    public function getAdjustmentReasons($data = array()) {

        $sql = "SELECT * FROM mst_adjustmentreason";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ireasonid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ireasonid DESC";

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

    public function getAdjustmentReasonsTotal($data = array()) {

        $sql = "SELECT * FROM mst_adjustmentreason";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE ireasonid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY ireasonid DESC";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

    public function getAdjustmentReason($ireasonid) {
        $query = $this->db2->query("SELECT * FROM mst_adjustmentreason WHERE ireasonid='" .(int)$ireasonid. "'");

        return $query->row;
    }

    public function getAdjustmentReasonSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_adjustmentreason WHERE vreasoncode LIKE  '%" .$this->db->escape($search). "%' OR vreasonename LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addAdjustmentReason($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO mst_adjustmentreason SET  vreasoncode = '" . $this->db->escape($data['vreasoncode']) . "',`vreasonename` = '" . $this->db->escape($data['vreasonename']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");

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

        $success['success'] = 'Successfully Added Adjustment Reason';
        return $success;
    }

    public function editlistAdjustmentReason($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_adjustmentreason SET  vreasoncode = '" . $this->db->escape($data['vreasoncode']) . "',`vreasonename` = '" . $this->db->escape($data['vreasonename']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "' WHERE ireasonid = '" . (int)$this->db->escape($data['ireasonid']) . "'");
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

        $success['success'] = 'Successfully Updated Adjustment Reason';
        return $success;
    }

}
?>