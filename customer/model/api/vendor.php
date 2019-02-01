<?php
class ModelApiVendor extends Model {
    public function getVendors() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY isupplierid DESC");

        return $query->rows;
    }

    public function getVendor($isupplierid) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE isupplierid='" .(int)$isupplierid. "'");

        return $query->row;
    }

    public function getVendorSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE vcompanyname LIKE  '%" .$this->db->escape($search). "%' OR vfnmae LIKE  '%" .$this->db->escape($search). "%' OR vlname LIKE  '%" .$this->db->escape($search). "%' OR vcity LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }
    
    public function getVendorByName($vendorname) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE vcompanyname =  '" .$this->db->escape($vendorname)."'");

        return $query->row;
    }
    
    public function addVendorByName($vendorname) {
        
        $success =array();
        $error =array();

        try {
        
            $lastId = $this->db2->getLastId();
            
            //$suppliercode = $lastId+1;
            
            $this->db2->query("INSERT INTO mst_supplier SET  vcompanyname = '" . $this->db->escape($vendorname) . "',`vvendortype` = 'Vendor', vfnmae = '',`vlname` = '',`vcode` = '', vaddress1 = '', vcity = '', vstate = '', vphone = '', vzip = '', vcountry = '', vemail = '', plcbtype = '', estatus = 'Active',SID = '" . (int)($this->session->data['sid'])."'");
    
            $isupplierid = $this->db2->getLastId();
    
            $this->db2->query("UPDATE mst_supplier SET vsuppliercode = '" . (int)$isupplierid . "' WHERE isupplierid = '" . (int)$isupplierid . "'");
            
            $query = $this->db2->query("SELECT * FROM mst_supplier WHERE isupplierid='" . (int)$isupplierid . "'")->row;
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

        return $isupplierid;
    }

    public function addVendor($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

               try {
                    $this->db2->query("INSERT INTO mst_supplier SET  vcompanyname = '" . $this->db->escape($data['vcompanyname']) . "',`vvendortype` = '" . $this->db->escape($data['vvendortype']) . "', vfnmae = '" . $this->db->escape($data['vfnmae']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "',`vcode` = '" . $this->db->escape($data['vcode']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', plcbtype = '" . $this->db->escape($data['plcbtype']) . "', estatus = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $isupplierid = $this->db2->getLastId();

                    $this->db2->query("UPDATE mst_supplier SET vsuppliercode = '" . (int)$isupplierid . "' WHERE isupplierid = '" . (int)$isupplierid . "'");
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

        $success['success'] = 'Successfully Added Vendor';
        return $success;
    }

    public function editlistVendor($datas = array()) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

              try {
                    $this->db2->query("UPDATE mst_supplier SET  vcompanyname = '" . $this->db->escape($data['vcompanyname']) . "',`vvendortype` = '" . $this->db->escape($data['vvendortype']) . "', vfnmae = '" . $this->db->escape($data['vfnmae']) . "',`vlname` = '" . $this->db->escape($data['vlname']) . "',`vcode` = '" . $this->db->escape($data['vcode']) . "', vaddress1 = '" . $this->db->escape($data['vaddress1']) . "', vcity = '" . $this->db->escape($data['vcity']) . "', vstate = '" . $this->db->escape($data['vstate']) . "', vphone = '" . $this->db->escape($data['vphone']) . "', vzip = '" . $this->db->escape($data['vzip']) . "', vcountry = '" . $this->db->escape($data['vcountry']) . "', vemail = '" . $this->db->escape($data['vemail']) . "', plcbtype = '" . $this->db->escape($data['plcbtype']) . "', estatus = '" . $this->db->escape($data['estatus']) . "' WHERE isupplierid = '" . (int)$this->db->escape($data['isupplierid']) . "'");
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

        $success['success'] = 'Successfully Updated Vendor';
        return $success;
    }

}
?>