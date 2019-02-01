<?php
class ModelApiItemsQuickItem extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT * FROM mst_itemgroup";
        
        $query = $this->db2->query($sql);
        
        $return_arr = array();

        $return_arr['total'] = count($query->rows);
        
        return $return_arr;
    }

    public function getItems($itemdata = array()) {
        
        $sql="SELECT * FROM mst_itemgroup";
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getQuickItemSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_itemgroup WHERE vitemgroupname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function editlistItems($datas = array()) {

        $success =array();
        $error =array();
       
        if(isset($datas) && count($datas) > 0){

              try {
                    foreach ($datas as $key => $value) {
                        $this->db2->query("UPDATE mst_itemgroup SET vitemgroupname = '" . $this->db->escape($value['vitemgroupname']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "' WHERE iitemgroupid = '" . (int)$value['iitemgroupid'] . "'");
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

        $success['success'] = 'Successfully Updated Quick Item';
        return $success;
    }
}
?>