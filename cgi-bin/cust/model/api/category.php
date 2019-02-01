<?php
class ModelApiCategory extends Model {
    public function getCategories() {
        $query = $this->db2->query("SELECT * FROM mst_category ORDER BY icategoryid DESC");

        return $query->rows;
    }

    public function getCategory($icategoryid) {
        $query = $this->db2->query("SELECT * FROM mst_category WHERE icategoryid='" .(int)$icategoryid. "'");

        return $query->row;
    }

    public function getCategoryByName($catname) {
        $query = $this->db2->query("SELECT * FROM mst_category WHERE vcategoryname='" .$catname. "'");

        return $query->row;
    }

    public function getCategoriesSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_category WHERE vcategoryname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function addCategory($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {

                try {
                    $this->db2->query("INSERT INTO mst_category SET vcategoryname = '" . html_entity_decode($value['vcategoryname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "', vcategorttype = '" . $this->db->escape($value['vcategorttype']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['sid'])."'");

                    $last_id = $this->db2->getLastId();
                    $this->db2->query("UPDATE mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'");
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

        $success['success'] = 'Successfully Added Category';
        return $success;
    }

    public function addCategoryByName($catname) {

        $success =array();
        $error =array();

        try {
            $this->db2->query("INSERT INTO mst_category SET vcategoryname = '" . html_entity_decode($catname) . "',isequence =0,estatus = 'Active',SID = '" . (int)($this->session->data['sid'])."'");

            $last_id = $this->db2->getLastId();
            $this->db2->query("UPDATE mst_category SET vcategorycode = '" . (int)$last_id . "' WHERE icategoryid = '" . (int)$last_id . "'");
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

        return $last_id;
    }

    public function editlistCategory($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            foreach ($data as $key => $value) {
               
               try {
                    $this->db2->query("UPDATE mst_category SET vcategoryname = '" . html_entity_decode($value['vcategoryname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "', vcategorttype = '" . $this->db->escape($value['vcategorttype']) . "',`isequence` = '" . (int)$this->db->escape($value['isequence']) . "' WHERE icategoryid = '" . (int)$value['icategoryid'] . "'");
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

        $success['success'] = 'Successfully Updated Category';
        return $success;
    }

    public function deleteCatgory($data) {

        $exist_categories = array();
        
        if(isset($data) && count($data) > 0){

            foreach ($data as $key => $value) {
                $mst_category = $this->db2->query("SELECT * FROM mst_category WHERE vcategorycode = '" . $this->db->escape($value) . "'")->row;

                $mst_item = $this->db2->query("SELECT * FROM mst_item WHERE vcategorycode = '" . $this->db->escape($value) . "'")->rows;

                if(count($mst_item) > 0){
                    $exist_categories[] = $mst_category['vcategoryname'];
                }else{
                  $trn_salesdetail = $this->db2->query("SELECT * FROM trn_salesdetail WHERE vcatcode = '" . $this->db->escape($value) . "'")->rows;  

                  if(count($trn_salesdetail) > 0){
                    $exist_categories[] = $mst_category['vcategoryname'];
                  }
                }
            }

            if(count($exist_categories) > 0){
                $exit_cat = implode(",",$exist_categories);
                $return['error'] = $exit_cat.' Category already assigned to item in system please unselect it!';
            }else{
                foreach ($data as $key => $value) {
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_category',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $this->db2->query("DELETE FROM mst_category WHERE icategoryid='" . (int)$value . "'");
                }

                $return['success'] = 'Category deleted Successfully';
            }
            
        }

        return $return;

    }

}
?>