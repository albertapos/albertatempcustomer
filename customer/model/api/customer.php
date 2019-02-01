<?php
class ModelApiCustomer extends Model {
    public function getCustomers() {
        $query = $this->db2->query("SELECT * FROM mst_customer ORDER BY icustomerid DESC");

        return $query->rows;
    }

    public function getCustomer($icustomerid) {
        $query = $this->db2->query("SELECT * FROM mst_customer WHERE icustomerid='" .(int)$icustomerid. "'");

        return $query->row;
    }

    public function getCustomersSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_customer WHERE vfname LIKE  '%" .$this->db->escape($search). "%' OR vlname LIKE  '%" .$this->db->escape($search). "%' OR vcustomername LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addCustomer($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', pricelevel = '" . (int)$this->db->escape($data['pricelevel']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', debitlimit = '" . $this->db->escape($data['debitlimit']) . "', creditday = '" . $this->db->escape($data['creditday']) . "', note = '" . $this->db->escape($data['note']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Customer';
        return $success;
    }

    public function editlistCustomer($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_customer SET  vcustomername = '" . $this->db->escape($data['vcustomername']) . "',`vaccountnumber` = '" . $this->db->escape($data['vaccountnumber']) . "', vfname = '" . $this->db->escape($data['vfname']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', pricelevel = '" . (int)$this->db->escape($data['pricelevel']) . "', vtaxable = '" . $this->db->escape($data['vtaxable']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', debitlimit = '" . $this->db->escape($data['debitlimit']) . "', creditday = '" . $this->db->escape($data['creditday']) . "', note = '" . $this->db->escape($data['note']) . "' WHERE icustomerid = '" . (int)$this->db->escape($data['icustomerid']) . "'");
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

        $success['success'] = 'Successfully Updated Customer';
        return $success;
    }

}
?>