<?php
class ModelApiGroup extends Model {
    public function getGroups($datas = array()) {
        $data = array();

        $sql = "SELECT * FROM itemgroup";
            
        if(isset($datas['searchbox']) && !empty($datas['searchbox'])){
            $sql .= " WHERE iitemgroupid= ". $this->db->escape($datas['searchbox']);
        }

        $sql .= " ORDER BY iitemgroupid DESC";

        if (isset($datas['start']) || isset($datas['limit'])) {
            if ($datas['start'] < 0) {
                $datas['start'] = 0;
            }

            if ($datas['limit'] < 1) {
                $datas['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$datas['start'] . "," . (int)$datas['limit'];
        }

        $query = $this->db2->query($sql);

        $itemgroups = $query->rows;

        if(count($itemgroups) > 0){
            foreach ($itemgroups as $key => $itemgroup) {
                $itemgroupdetails = $this->db2->query("SELECT * FROM itemgroupdetail WHERE iitemgroupid='" . (int)$this->db->escape($itemgroup['iitemgroupid']) . "'")->rows;

                $itemgroupslabprice = $this->db2->query("SELECT * FROM mst_groupslabprice WHERE iitemgroupid='" . (int)$this->db->escape($itemgroup['iitemgroupid']) . "'")->rows;
                $data[$key] = $itemgroup;
                $data[$key]['items'] = $itemgroupdetails;
                $data[$key]['group_slab_pricings'] = $itemgroupslabprice;
            }
        }

        return $data;
    }

    public function getGroupsTotal($data = array()) {
        
        $sql = "SELECT * FROM itemgroup";
            
        if(isset($data['searchbox']) && !empty($data['searchbox'])){
            $sql .= " WHERE iitemgroupid= ". $this->db->escape($data['searchbox']);
        }

        $sql .= " ORDER BY iitemgroupid DESC";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

    public function getGroupSearch($search) {
        $query = $this->db2->query("SELECT * FROM itemgroup WHERE vitemgroupname LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function getGroup($iitemgroupid) {
        $data = array();

        $itemgroup = $this->db2->query("SELECT * FROM itemgroup WHERE iitemgroupid='" . (int)$iitemgroupid . "'")->row;

        $itemgroupdetails = $this->db2->query("SELECT * FROM itemgroupdetail WHERE iitemgroupid='" . (int)$iitemgroupid . "'")->rows;

        $data = $itemgroup;
        $data['items'] = $itemgroupdetails;


        return $data;
    }

    public function deleteGroupProduct($iitemgroupid, $Id) {
        $success = array();

        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$Id . "',SID = '" . (int)($this->session->data['sid'])."'");

        $itemgroup = $this->db2->query("DELETE FROM itemgroupdetail WHERE iitemgroupid='" . (int)$iitemgroupid . "' AND Id='" . (int)$Id . "'");

        $success['success'] = 'Successfully Deleted Group Product';
        return $success;
    
    }

    public function addGroup($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO itemgroup SET  vitemgroupname = '" . $this->db->escape($data['vitemgroupname']) . "',`etransferstatus` = '" . $this->db->escape($data['etransferstatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Group';
        return $success;
    }

    public function addGroupGeneral($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'")->row;

                    if(count($delete_ids) > 0){
                        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                    }

                    $this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'");

                    $this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($data['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Group General Details';
        return $success;
    }

    public function editlistGroupGeneral($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {

                    $delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'")->row;

                    if(count($delete_ids) > 0){
                        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                    }

                    $this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vsku']) . "'");

                    $this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$iitemgroupid . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`vtype` = '" . $this->db->escape($datas['vtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                    
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

        $success['success'] = 'Successfully Updated Group General Details';
        return $success;
    }

}
?>