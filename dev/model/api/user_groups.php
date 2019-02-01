<?php
class ModelApiUserGroups extends Model {
    public function getUserGroups($data = array()) {
        $sql = "SELECT * FROM mst_permissiongroup";

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getUserGroup($ipermissiongroupid) {
        $query = $this->db2->query("SELECT * FROM mst_permissiongroup WHERE ipermissiongroupid='" .(int)$ipermissiongroupid. "'");
        $data = array();
        $data = $query->row;

        $q = $this->db2->query("SELECT * FROM mst_permissiongroupdetail WHERE ipermissiongroupid='" .(int)$ipermissiongroupid. "'");

        $dt = $q->rows;
        $data['permissions'] = $dt;
        
        return $data;
    }

    public function getUserGroupsSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_permissiongroup WHERE vgroupname LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function getAllPermissions() {
        $sql = "SELECT * FROM mst_permission";

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function editlistUserGroups($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    foreach ($data['vpermissioncode'] as $key => $value) {

                        $sql = "SELECT *  FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$data['ipermissiongroupid'] . "' AND vpermissioncode='".$this->db->escape($value)."'  group by vpermissioncode ";

                        $query = $this->db2->query($sql);

                        //Insert in to mst_delete_table and delete record from mst_permissiongroupdetail

                        //$p_details_id = $query->row['Id'];

                        // $this->db2->query("INSERT INTO mst_delete_table SET TableName = 'mst_permissiongroupdetail',`TableId` = '" . (int)$p_details_id . "', Action = 'Delete',SID = '" . (int)($this->session->data['SID'])."'");

                        // $this->db2->query("DELETE  FROM mst_permissiongroupdetail WHERE ipermissiongroupid = '" . (int)$ipermissiongroupid . "' AND vpermissioncode='".$this->db->escape($value)."' AND Id = '" . (int)$p_details_id . "'");

                        $details = $query->rows;

                        if(count($details) > 0){
                            $this->db2->query("UPDATE mst_permissiongroupdetail SET  ipermissiongroupid = '" . (int)$data['ipermissiongroupid'] . "',`vpermissioncode` = '" . $this->db->escape($value) . "' WHERE Id = '" . (int)$details[0]['Id'] . "'");
                        }else{
                            $this->db2->query("INSERT INTO mst_permissiongroupdetail SET ipermissiongroupid = '" . (int)$data['ipermissiongroupid'] . "',`vpermissioncode` = '" . $this->db->escape($value) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }

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

        $success['success'] = 'Successfully Updated User Group';
        return $success;
    }

}
?>