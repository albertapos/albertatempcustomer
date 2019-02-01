<?php
class ModelApiDepartment extends Model {
    public function getDepartments() {
        $query = $this->db2->query("SELECT * FROM mst_department ORDER BY idepartmentid DESC");

        return $query->rows;
    }

    public function getDepartment($idepartmentid) {
        $query = $this->db2->query("SELECT * FROM mst_department WHERE idepartmentid='" .(int)$idepartmentid. "'");

        return $query->row;
    }

    public function getDepartmentByName($depname) {
        $query = $this->db2->query("SELECT * FROM mst_department WHERE vdepartmentname='" .$depname. "'");

        return $query->row;
    }

    public function getDepartmentSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_department WHERE vdepartmentname LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addDepartment($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $value) {

               try {
                    $sql = "INSERT INTO mst_department SET vdepartmentname = '" . html_entity_decode($value['vdepartmentname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "',";

                    if(!empty($value['starttime'])){
                        $sql .= " starttime = '" .$value['starttime']. "',";
                    }else{
                        $sql .= " starttime = NULL,";
                    }

                    if(!empty($value['endtime'])){
                        $sql .= " endtime = '" .$value['endtime']. "',";
                    }else{
                        $sql .= " endtime = NULL,";
                    }

                    $sql .= "isequence = '" . (int)$this->db->escape($value['isequence']) . "',estatus = 'Active',SID = '" . (int)($this->session->data['sid'])."'";

                    $this->db2->query($sql);

                    $last_id = $this->db2->getLastId();
                    $this->db2->query("UPDATE mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
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

        $success['success'] = 'Successfully Added Department';
        return $success;
    }

    public function addDepartmentByName($depname) {

        $success =array();
        $error =array();

        try {
            $sql = "INSERT INTO mst_department SET vdepartmentname = '" . html_entity_decode($depname) . "',isequence =0 ,estatus = 'Active',SID = '" . (int)($this->session->data['sid'])."'";

            $this->db2->query($sql);

            $last_id = $this->db2->getLastId();
            $this->db2->query("UPDATE mst_department SET vdepcode = '" . (int)$last_id . "' WHERE idepartmentid = '" . (int)$last_id . "'");
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

    public function editlistDepartment($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $value) {

              try {

                    $sql = "UPDATE mst_department SET vdepartmentname = '" . html_entity_decode($value['vdepartmentname']) . "',`vdescription` = '" . html_entity_decode($value['vdescription']) . "',";

                    if(!empty($starttime)){
                        $sql .= " starttime = '" .$starttime. "',";
                    }else{
                        $sql .= " starttime = NULL,";
                    }

                    if(!empty($endtime)){
                        $sql .= " endtime = '" .$endtime. "',";
                    }else{
                        $sql .= " endtime = NULL,";
                    }

                    $sql .= "isequence = '" . (int)$this->db->escape($value['isequence']) . "' WHERE idepartmentid = '" . (int)$value['idepartmentid'] . "'";

                    $this->db2->query($sql);

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

        $success['success'] = 'Successfully Updated Department';
        return $success;
    }

    public function deleteDepartment($data) {

        $exist_departments = array();
        
        if(isset($data) && count($data) > 0){

            foreach ($data as $key => $value) {
                $mst_department = $this->db2->query("SELECT * FROM mst_department WHERE vdepcode = '" . $this->db->escape($value) . "'")->row;

                $mst_item = $this->db2->query("SELECT * FROM mst_item WHERE vdepcode = '" . $this->db->escape($value) . "'")->rows;

                if(count($mst_item) > 0){
                    $exist_departments[] = $mst_department['vdepartmentname'];
                }else{
                  $trn_salesdetail = $this->db2->query("SELECT * FROM trn_salesdetail WHERE vdepcode = '" . $this->db->escape($value) . "'")->rows;  

                  if(count($trn_salesdetail) > 0){
                    $exist_departments[] = $mst_department['vdepartmentname'];
                  }
                }
            }

            if(count($exist_departments) > 0){
                $exit_dep = implode(",",$exist_departments);
                $return['error'] = $exit_dep.' Department already assigned to item in system please unselect it!';
            }else{
                foreach ($data as $key => $value) {
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_department',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $this->db2->query("DELETE FROM mst_department WHERE idepartmentid='" . (int)$value . "'");
                }

                $return['success'] = 'Department deleted Successfully';
            }
            
        }

        return $return;

    }

}
?>