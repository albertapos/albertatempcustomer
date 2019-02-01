<?php
class ModelApiUsers extends Model {
    public function getUsers() {
        $query = $this->db2->query("SELECT * FROM mst_user ORDER BY iuserid DESC");

        return $query->rows;
    }

    public function getUsersType() {
        $query = $this->db2->query("SELECT * FROM mst_permissiongroup");

        return $query->rows;
    }

    public function getUser($iuserid) {
        $query = $this->db2->query("SELECT * FROM mst_user WHERE iuserid='" .(int)$iuserid. "'");

        return $query->row;
    }

    public function getUserAllData($vuserid,$vfname,$vlname) {
        $query = $this->db2->query("SELECT * FROM mst_user WHERE vuserid='" .(int)$vuserid. "' AND vfname='" .$this->db->escape($vfname). "' AND vlname='" .$this->db->escape($vlname). "' ");

        return $query->row;
    }

    public function getUsersSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_user WHERE vfname LIKE  '%" .$this->db->escape($search). "%' OR vlname LIKE  '%" .$this->db->escape($search). "%' OR vuserid LIKE  '%" .$this->db->escape($search). "%' OR vusertype LIKE  '%" .$this->db->escape($search). "%' OR vemail LIKE  '%" .$this->db->escape($search). "%' OR iuserid LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addUsers($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

               try {
                    $this->db2->query("INSERT INTO mst_user SET vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vaddress2 = '" . $this->db->escape($data['vaddress2']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vuserid = '" . $this->db->escape($data['vuserid']) . "', vpassword = '" . $this->db->escape($data['vpassword']) . "', vusertype = '" . $this->db->escape($data['vusertype']) . "', vpasswordchange = '" . $this->db->escape($data['vpasswordchange']) . "', vuserbarcode = '" . $this->db->escape($data['vuserbarcode']) . "',`estatus` = 'Active',SID = '" . (int)($this->session->data['sid'])."'");

                    $iuserid = $this->db2->getLastId();

                    if(!empty($this->db->escape($data['vusertype']))){
                        $query = $this->db2->query("SELECT * FROM mst_permissiongroup  WHERE vgroupname = '" . $this->db->escape($data['vusertype']) . "'");
                        if(count($query->rows) > 0){
                            $ipermissiongroupid = $query->row['ipermissiongroupid'];
                        
                            $que = $this->db2->query("SELECT * FROM mst_userpermissiongroup  WHERE iuserid = '" . (int)$iuserid . "'");

                            if(count($que->rows) > 0){
                                $this->db2->query("UPDATE mst_userpermissiongroup SET  ipermissiongroupid = '" . (int)$ipermissiongroupid . "' WHERE iuserid = '" . (int)$iuserid . "'");
                            }else{
                                $this->db2->query("INSERT INTO mst_userpermissiongroup SET iuserid = '" . (int)$iuserid . "',`ipermissiongroupid` = '" . (int)$ipermissiongroupid . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
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

        $success['success'] = 'Successfully Added User';
        return $success;
    }

    public function editlistUsers($iuserid, $data) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

              try {
                    if(!empty($this->db->escape($data['vusertype']))){
                        $query = $this->db2->query("SELECT * FROM mst_permissiongroup  WHERE vgroupname = '" . $this->db->escape($data['vusertype']) . "'");
                        if(count($query->rows) > 0){
                            $ipermissiongroupid = $query->row['ipermissiongroupid'];
                        
                            $que = $this->db2->query("SELECT * FROM mst_userpermissiongroup  WHERE iuserid = '" . (int)$iuserid . "'");

                            if(count($que->rows) > 0){
                                $this->db2->query("UPDATE mst_userpermissiongroup SET  ipermissiongroupid = '" . (int)$ipermissiongroupid . "' WHERE iuserid = '" . (int)$iuserid . "'");
                            }else{
                                $this->db2->query("INSERT INTO mst_userpermissiongroup SET iuserid = '" . (int)$iuserid . "',`ipermissiongroupid` = '" . (int)$ipermissiongroupid . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }
                    }

                    $this->db2->query("UPDATE mst_user SET  vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "',`vaddress2` = '" . $this->db->escape($data['vaddress2']) . "',`vcity` = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', vuserid = '" . $this->db->escape($data['vuserid']) . "', vpassword = '" . $this->db->escape($data['vpassword']) . "', vusertype = '" . $this->db->escape($data['vusertype']) . "', vpasswordchange = '" . $this->db->escape($data['vpasswordchange']) . "', vuserbarcode = '" . $this->db->escape($data['vuserbarcode']) . "', estatus = '" . $this->db->escape($data['estatus']) . "' WHERE iuserid = '" . (int)$iuserid . "'");
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

        $success['success'] = 'Successfully Updated User';
        return $success;
    }

    public function getUserID($vuserid) {
        $query = $this->db2->query("SELECT * FROM mst_user u WHERE u.vuserid = '" . (int)$vuserid . "'");

        return $query->rows;
    }

}
?>