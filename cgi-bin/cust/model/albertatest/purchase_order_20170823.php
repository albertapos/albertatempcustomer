<?php
class ModelApiPurchaseOrder extends Model {
    public function getTotalPurchaseOrders($data = array()) {

        $sql = "SELECT COUNT(*) AS total FROM trn_purchaseorder";

        if (!empty($data['searchbox'])) {
            $sql .= " WHERE vponumber LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR  vordertitle LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR vvendorname LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR vinvoiceno LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR estatus LIKE  '%" .$this->db->escape($data['searchbox']). "%' ";
        }

        $sql .= " ORDER BY LastUpdate DESC";

        $query = $this->db2->query($sql);

        return $query->row['total'];
    }

    public function getPurchaseOrders($data = array()) {
        $sql = "SELECT * FROM trn_purchaseorder";

        if (!empty($data['searchbox'])) {
            $sql .= " WHERE vponumber LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR  vordertitle LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR vvendorname LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR vinvoiceno LIKE  '%" .$this->db->escape($data['searchbox']). "%' OR estatus LIKE  '%" .$this->db->escape($data['searchbox']). "%' ";
        }

        $sql .= " ORDER BY LastUpdate DESC";

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getPurchaseOrder($ipoid) {
        $return = array();
        $query = $this->db2->query("SELECT * FROM trn_purchaseorder WHERE ipoid='". (int)$ipoid ."'")->row;

        $return = $query;
        $query1 = $this->db2->query("SELECT * FROM trn_purchaseorderdetail WHERE ipoid='". (int)$ipoid ."'")->rows;
        $return['items'] = $query1;
        return $return;
    }

    public function getVendors() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY isupplierid");

        return $query->rows;
    }

    public function getSearchItems($search) {
        $query = $this->db2->query("SELECT `iitemid`,`vitemcode`,`vitemname` FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($search). "%' OR vbarcode LIKE  '%" .$this->db->escape($search). "%'");

        return $query->rows;
    }

    public function getSearchItem($iitemid,$ivendorid) {

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, miv.ivendorid, miv.vvendoritemcode, mu.vunitname FROM mst_item mi LEFT JOIN mst_itemvendor miv ON (mi.iitemid = miv.iitemid) LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.iitemid='". (int)$iitemid ."' OR (miv.ivendorid='". (int)$ivendorid ."' AND  miv.iitemid='". (int)$iitemid ."' )");

        return $query->row;
    }

    public function getLastInsertedID() {
        $query = $this->db2->query("SELECT ipoid FROM trn_purchaseorder ORDER BY ipoid DESC LIMIT 1");

        return $query->row;
    }

    public function checkExistInvoice($invoice) {
        $return = array();
        $query = $this->db2->query("SELECT vinvoiceno FROM trn_purchaseorder WHERE vinvoiceno='". $invoice ."'")->rows;

        if(count($query) > 0){
            $return['error'] = 'Invoice Already Exist';
        }else{
            $return['success'] = 'Invoice Not Exist';
        }
        return $return;
    }

    public function getStore() {
        $query = $this->db2->query("SELECT * FROM mst_store");

        return $query->row;
    }

    public function getVendor($isupplierid) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE isupplierid='" .(int)$isupplierid. "'");

        return $query->row;
    }

    public function getVendorSearch($search) {
        $query = $this->db2->query("SELECT * FROM mst_supplier WHERE vcompanyname LIKE  '%" .$this->db->escape($search). "%' OR vfnmae LIKE  '%" .$this->db->escape($search). "%' OR vlname LIKE  '%" .$this->db->escape($search). "%' OR vcity LIKE  '%" .$this->db->escape($search). "%' ");

        return $query->rows;
    }

    public function addPurchaseOrder($data = array(), $close = null) {

        $success =array();
        $error =array();

        date_default_timezone_set('US/Eastern');
        
        $currenttime = date('h:i:s');

        if(isset($data) && count($data) > 0){
            if(!empty($close)){
                $close = $close;
            }else{
                $close = $data['estatus'];
            }

            $dcreatedate = DateTime::createFromFormat('m-d-Y', $data['dcreatedate']);
            $dcreatedate = $dcreatedate->format('Y-m-d').' '.$currenttime;

            $dreceiveddate = DateTime::createFromFormat('m-d-Y', $data['dreceiveddate']);
            $dreceiveddate = $dreceiveddate->format('Y-m-d').' '.$currenttime;
            
               try {
                    $this->db2->query("INSERT INTO trn_purchaseorder SET  vinvoiceno = '" . $this->db->escape($data['vinvoiceno']) . "',vrefnumber = '" . $this->db->escape($data['vinvoiceno']) . "',dcreatedate = '" . $dcreatedate . "', vponumber = '" . $this->db->escape($data['vponumber']) . "',`dreceiveddate` = '" . $dreceiveddate . "',`vordertitle` = '" . $this->db->escape($data['vordertitle']) . "', estatus = '" . $close . "', vorderby = '" . $this->db->escape($data['vorderby']) . "', vconfirmby = '" . $this->db->escape($data['vconfirmby']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', vshipvia = '" . $this->db->escape($data['vshipvia']) . "', vvendorid = '" . $this->db->escape($data['vvendorid']) . "', vvendorname = '" . $this->db->escape($data['vvendorname']) . "', vvendoraddress1 = '" . $this->db->escape($data['vvendoraddress1']) . "', vvendoraddress2 = '" . $this->db->escape($data['vvendoraddress2']) . "', vvendorstate = '" . $this->db->escape($data['vvendorstate']) . "', vvendorzip = '" . $this->db->escape($data['vvendorzip']) . "', vvendorphone = '" . $this->db->escape($data['vvendorphone']) . "',vshpid = '" . $this->db->escape($data['vshpid']) . "',vshpname = '" . $this->db->escape($data['vshpname']) . "',vshpaddress1 = '" . $this->db->escape($data['vshpaddress1']) . "',vshpaddress2 = '" . $this->db->escape($data['vshpaddress2']) . "',vshpstate = '" . $this->db->escape($data['vshpstate']) . "',vshpzip = '" . $this->db->escape($data['vshpzip']) . "',vshpphone = '" . $this->db->escape($data['vshpphone']) . "',nsubtotal = '" . $this->db->escape($data['nsubtotal']) . "',ntaxtotal = '" . $this->db->escape($data['ntaxtotal']) . "',nfreightcharge = '" . $this->db->escape($data['nfreightcharge']) . "',ndeposittotal = '" . $this->db->escape($data['ndeposittotal']) . "',nreturntotal = '" . $this->db->escape($data['nreturntotal']) . "',ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "',nripsamt = '" . $this->db->escape($data['nripsamt']) . "',nnettotal = '" . $this->db->escape($data['nnettotal']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $ipoid = $this->db2->getLastId();

                    if(isset($data['items']) && count($data['items']) > 0){
                        foreach ($data['items'] as $key => $item) {

                            $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Purchase Order';
        return $success;
    }

    public function editPurchaseOrder($data = array(), $close = null) {

        $success =array();
        $error =array();

        date_default_timezone_set('US/Eastern');
        
        $currenttime = date('h:i:s');

        if(isset($data) && count($data) > 0){
            if(!empty($close)){
                $close = $close;
            }else{
                $close = $data['estatus'];
            }

            $dcreatedate = DateTime::createFromFormat('m-d-Y', $data['dcreatedate']);
            $dcreatedate = $dcreatedate->format('Y-m-d').' '.$currenttime;

            $dreceiveddate = DateTime::createFromFormat('m-d-Y', $data['dreceiveddate']);
            $dreceiveddate = $dreceiveddate->format('Y-m-d').' '.$currenttime;
            
               try {
                    $this->db2->query("UPDATE trn_purchaseorder SET  vinvoiceno = '" . $this->db->escape($data['vinvoiceno']) . "',vrefnumber = '" . $this->db->escape($data['vinvoiceno']) . "',dcreatedate = '" . $dcreatedate . "', vponumber = '" . $this->db->escape($data['vponumber']) . "',`dreceiveddate` = '" . $dreceiveddate . "',`vordertitle` = '" . $this->db->escape($data['vordertitle']) . "', estatus = '" . $close . "', vorderby = '" . $this->db->escape($data['vorderby']) . "', vconfirmby = '" . $this->db->escape($data['vconfirmby']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', vshipvia = '" . $this->db->escape($data['vshipvia']) . "', vvendorid = '" . $this->db->escape($data['vvendorid']) . "', vvendorname = '" . $this->db->escape($data['vvendorname']) . "', vvendoraddress1 = '" . $this->db->escape($data['vvendoraddress1']) . "', vvendoraddress2 = '" . $this->db->escape($data['vvendoraddress2']) . "', vvendorstate = '" . $this->db->escape($data['vvendorstate']) . "', vvendorzip = '" . $this->db->escape($data['vvendorzip']) . "', vvendorphone = '" . $this->db->escape($data['vvendorphone']) . "',vshpid = '" . $this->db->escape($data['vshpid']) . "',vshpname = '" . $this->db->escape($data['vshpname']) . "',vshpaddress1 = '" . $this->db->escape($data['vshpaddress1']) . "',vshpaddress2 = '" . $this->db->escape($data['vshpaddress2']) . "',vshpstate = '" . $this->db->escape($data['vshpstate']) . "',vshpzip = '" . $this->db->escape($data['vshpzip']) . "',vshpphone = '" . $this->db->escape($data['vshpphone']) . "',nsubtotal = '" . $this->db->escape($data['nsubtotal']) . "',ntaxtotal = '" . $this->db->escape($data['ntaxtotal']) . "',nfreightcharge = '" . $this->db->escape($data['nfreightcharge']) . "',ndeposittotal = '" . $this->db->escape($data['ndeposittotal']) . "',nreturntotal = '" . $this->db->escape($data['nreturntotal']) . "',ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "',nripsamt = '" . $this->db->escape($data['nripsamt']) . "',nnettotal = '" . $this->db->escape($data['nnettotal']) . "' WHERE ipoid='". (int)$this->db->escape($data['ipoid']) ."'");

                    $ipoid = (int)$this->db->escape($data['ipoid']);

                    if(isset($data['items']) && count($data['items']) > 0){

                        foreach ($data['items'] as $key => $item) {

                            $ipodetid_ids = $this->db2->query("SELECT `ipodetid` FROM  trn_purchaseorderdetail WHERE ipodetid='" . (int)$this->db->escape($item['ipodetid']) . "' ")->rows;

                            if(count($ipodetid_ids) > 0){
                                $this->db2->query("UPDATE trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "' WHERE ipodetid='" . (int)$this->db->escape($item['ipodetid']) . "' ");
                            }else{
                                $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Updated Purchase Order';
        return $success;
    }

    public function deleteItemPurchase($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            foreach($data as $value){
                try {

                    $exist_ipodetid = $this->db2->query("SELECT `ipodetid` FROM  trn_purchaseorderdetail WHERE ipodetid='" . (int)$value . "' ")->rows;

                    if(count($exist_ipodetid) > 0){
                        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_purchaseorderdetail',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");
                    $this->db2->query("DELETE FROM trn_purchaseorderdetail WHERE ipodetid='" . (int)$value . "'");
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
        $success['success'] = 'Successfully Deleted Purchase Order Item';
        return $success;
    }

    public function addSaveReceiveItem($data = array()) {

        $success =array();
        $error =array();

        if(isset($data['items']) && count($data['items']) > 0){

            if(isset($data['ipoid'])){
                $purchaseorder_exist = $this->db2->query("SELECT * FROM  trn_purchaseorder WHERE ipoid='" . (int)$this->db->escape($data['ipoid']) . "'")->row;
                if($purchaseorder_exist['vinvoiceno'] != $data['vinvoiceno']){
                    $query_vinvoiceno = $this->db2->query("SELECT vinvoiceno FROM trn_purchaseorder WHERE vinvoiceno='". $data['vinvoiceno'] ."'")->rows;
                    if(count($query_vinvoiceno) > 0){
                        $error['error'] = 'Invoice Already Exist';
                        return $error;
                    }
                }
                $close = 'Close';
                $this->editPurchaseOrder($data,$close);
            }else{
                $query_vinvoiceno = $this->db2->query("SELECT vinvoiceno FROM trn_purchaseorder WHERE vinvoiceno='". $data['vinvoiceno'] ."'")->rows;
                    if(count($query_vinvoiceno) > 0){
                        $error['error'] = 'Invoice Already Exist';
                        return $error;
                    }
                    $close = 'Close';
                    $this->addPurchaseOrder($data,$close);
            }
            
            foreach ($data['items'] as $key => $item) {
                try {
                    // update in mst_itemvendor table
                    $itemvendor_exist = $this->db2->query("SELECT * FROM  mst_itemvendor WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' AND ivendorid='" . (int)$this->db->escape($data['vvendorid']) . "' ")->rows;

                    if(count($itemvendor_exist) > 0){
                        $this->db2->query("UPDATE mst_itemvendor SET vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' AND ivendorid='" . (int)$this->db->escape($data['vvendorid']) . "'");
                    }else{
                        $this->db2->query("INSERT INTO mst_itemvendor SET  iitemid = '" . (int)$this->db->escape($item['vitemid']) . "',ivendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                    }
                    // update in mst_itemvendor table
                    $current_item = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;

                    $total_cost = $item['nordextprice'] + ($current_item['iqtyonhand'] * $current_item['nunitcost']);

                    $total_qty = $current_item['iqtyonhand'] + $item['itotalunit'];

                    $new_nunitcost = $total_cost / $total_qty;

                    if($new_nunitcost < 0){
                        $new_nunitcost = $item['nunitcost'];
                    }

                    $new_nunitcost = number_format((float)$new_nunitcost, 4, '.', '');

                    if(isset($data['update_pack_qty']) && $data['update_pack_qty'] == 'Yes'){
                        $npack = $item['npackqty'];
                    }else{
                        $npack = $current_item['npack'];
                    }

                    $new_dcostprice = $npack * $new_nunitcost;
                    $new_dcostprice = number_format((float)$new_dcostprice, 4, '.', '');

                    if($item['nunitcost'] != $current_item['nunitcost'] && $item['nunitcost'] > 0){
                        $new_nunitcost = $new_nunitcost;
                        $new_dcostprice = $new_dcostprice;
                    }else{
                        $new_nunitcost = $current_item['nunitcost'];
                        $new_dcostprice = $current_item['dcostprice'];
                    }

                    //update dcostprice,npack and nunitcost
                    $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '" . $total_qty . "',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                    //update dcostprice,npack and nunitcost

                    //update child item dcostprice,npack and nunitcost
                    $isParentCheck = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;

                    if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                        $child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$this->db->escape($item['vitemid']) ."' ")->rows;

                        if(count($child_items) > 0){
                            foreach($child_items as $chi_item){
                                $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                    '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");
                            }
                        }
                    }
                    //update child item dcostprice,npack and nunitcost

                    //update into mst_itempackdetail
                    if($isParentCheck['vitemtype'] == 'Lot Matrix'){
                            
                        if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                            $lot_child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$this->db->escape($item['vitemid']) ."' ")->rows;

                            if(count($lot_child_items) > 0){
                                foreach($lot_child_items as $chi){
                                    $pack_lot_child_item = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid= '". (int)$this->db->escape($chi['iitemid']) ."' ")->rows;

                                    if(count($pack_lot_child_item) > 0){
                                        foreach ($pack_lot_child_item as $k => $v) {
                                            $parent_nunitcost = $isParentCheck['nunitcost'];

                                            if($parent_nunitcost == ''){
                                                $parent_nunitcost = 0;
                                            }

                                            $parent_ipack = (int)$v['ipack'];
                                            $parent_npackprice = $v['npackprice'];

                                            $parent_npackcost = (int)$parent_ipack * $parent_nunitcost;
                                            
                                            $parent_npackmargin = $parent_npackprice - $parent_npackcost;

                                            if($parent_npackprice == 0){
                                                $parent_npackprice = 1;
                                            }

                                            if($parent_npackmargin > 0){
                                                $parent_npackmargin = $parent_npackmargin;
                                            }else{
                                                $parent_npackmargin = 0;
                                            }

                                            $parent_npackmargin = (($parent_npackmargin/$parent_npackprice) * 100);
                                            $parent_npackmargin = number_format((float)$parent_npackmargin, 2, '.', '');

                                            $this->db2->query("UPDATE mst_itempackdetail SET  `npackcost` = '" . $parent_npackcost . "',`nunitcost` = '" . $parent_nunitcost . "',`npackmargin` = '" . $parent_npackmargin . "' WHERE idetid='". (int)$this->db->escape($v['idetid']) ."'");
                                        }
                                    }
                                }
                            }
                        }

                        $itempackexists = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE vbarcode='". $this->db->escape($isParentCheck['vbarcode']) ."' AND iitemid='". (int)$isParentCheck['iitemid'] ."'")->rows;

                        if(count($itempackexists) > 0){

                            foreach($itempackexists as $itempackexist){

                                $nunitcost = $isParentCheck['nunitcost'];
                                if($nunitcost == ''){
                                    $nunitcost = 0;
                                }

                                $ipack = $itempackexist['ipack'];
                                if($itempackexist['ipack'] == ''){
                                    $ipack = 0;
                                }

                                $npackprice = $itempackexist['npackprice'];
                                if($itempackexist['npackprice'] == ''){
                                    $npackprice = 0;
                                }

                                $npackcost = (int)$ipack * $nunitcost;
                                $npackmargin = $npackprice - $npackcost;

                                if($npackprice == 0){
                                    $npackprice = 1;
                                }

                                if($npackmargin > 0){
                                    $npackmargin = $npackmargin;
                                }else{
                                    $npackmargin = 0;
                                }

                                $npackmargin = (($npackmargin/$npackprice) * 100);
                                $npackmargin = number_format((float)$npackmargin, 2, '.', '');


                                $this->db2->query("UPDATE mst_itempackdetail SET  `npackcost` = '" . $npackcost . "',`nunitcost` = '" . $nunitcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "' WHERE idetid='". (int)$itempackexist['idetid'] ."'");
                            }
                        }

                    }
                    //update into mst_itempackdetail
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
        $success['success'] = 'Successfully Saved/Received Items';
        return $success;
    }

    public function getCategories() {
        $query = $this->db2->query("SELECT * FROM mst_category");

        return $query->rows;
    }

    public function getDepartments() {
        $query = $this->db2->query("SELECT * FROM mst_department ORDER BY idepartmentid DESC");

        return $query->rows;
    }

    public function getTax1() {
        $query = $this->db2->query("SELECT * FROM mst_storesetting WHERE vsettingname='Tax1seletedfornewItem' AND vsettingvalue='Yes'");

        return $query->rows;
    }

    public function GetPurchaseOrderByInvoice($invoice) {
        $query = $this->db2->query("SELECT vinvoiceno FROM trn_purchaseorder WHERE vinvoiceno='". $invoice ."'")->rows;

        return $query;
    }

    public function insertPurchaseOrder($data = array()) {

        $success =array();
        $error =array();

        date_default_timezone_set('US/Eastern');
        
        if(isset($data) && count($data) > 0){
            
            try {
                $this->db2->query("INSERT INTO trn_purchaseorder SET  vinvoiceno = '" . $this->db->escape($data['vinvoiceno']) . "',vrefnumber = '" . $this->db->escape($data['vrefnumber']) . "',dcreatedate = '" . $this->db->escape($data['dcreatedate']) . "', vponumber = '" . $this->db->escape($data['vponumber']) . "',`vordertitle` = '" . $this->db->escape($data['vordertitle']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vorderby = '" . $this->db->escape($data['vorderby']) . "', vconfirmby = '" . $this->db->escape($data['vconfirmby']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', vshipvia = '" . $this->db->escape($data['vshipvia']) . "', vvendorid = '" . $this->db->escape($data['vvendorid']) . "', vvendorname = '" . $this->db->escape($data['vvendorname']) . "', vvendoraddress1 = '" . $this->db->escape($data['vvendoraddress1']) . "', vvendoraddress2 = '" . $this->db->escape($data['vvendoraddress2']) . "', vvendorstate = '" . $this->db->escape($data['vvendorstate']) . "', vvendorzip = '" . $this->db->escape($data['vvendorzip']) . "', vvendorphone = '" . $this->db->escape($data['vvendorphone']) . "',vshpid = '" . $this->db->escape($data['vshpid']) . "',vshpname = '" . $this->db->escape($data['vshpname']) . "',vshpaddress1 = '" . $this->db->escape($data['vshpaddress1']) . "',vshpaddress2 = '" . $this->db->escape($data['vshpaddress2']) . "',vshpstate = '" . $this->db->escape($data['vshpstate']) . "',vshpzip = '" . $this->db->escape($data['vshpzip']) . "',vshpphone = '" . $this->db->escape($data['vshpphone']) . "',nsubtotal = '" . $this->db->escape($data['nsubtotal']) . "',ntaxtotal = '" . $this->db->escape($data['ntaxtotal']) . "',nfreightcharge = '" . $this->db->escape($data['nfreightcharge']) . "',ndeposittotal = '" . $this->db->escape($data['ndeposittotal']) . "',nreturntotal = '" . $this->db->escape($data['nreturntotal']) . "',ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "',nripsamt = '" . $this->db->escape($data['nripsamt']) . "',nnettotal = '" . $this->db->escape($data['nnettotal']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                $ipoid = $this->db2->getLastId();

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

        return $ipoid;
    }

    public function getItemByBarCode($vCode) {
        $query = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode='". $vCode ."'")->row;

        return $query;
    }

    public function getItemVendorByVendorItemCode($vvendoritemcode) {
        $query = $this->db2->query("SELECT * FROM mst_itemvendor WHERE vvendoritemcode='". $vvendoritemcode ."'")->row;

        return $query;
    }

    public function insertItemVendor($data = array()) {
        $this->db2->query("INSERT INTO mst_itemvendor SET  iitemid = '" . (int)$this->db->escape($data['iitemid']) . "',`ivendorid` = '" . (int)$this->db->escape($data['ivendorid']) . "',`vvendoritemcode` = '" . $this->db->escape($data['vvendoritemcode']) . "', SID = '" . (int)($this->session->data['sid']) . "'");

        return 'Successfully added vendor item code';
    }

    public function InsertPurchaseDetail($data = array()) {
        $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$this->db->escape($data['ipoid']) . "',vitemid = '" . $this->db->escape($data['vitemid']) . "',npackqty = '" . $this->db->escape($data['npackqty']) . "',vbarcode = '" . $this->db->escape($data['vbarcode']) . "',vitemname = '" . $this->db->escape($data['vitemname']) . "',vunitname = '" . $this->db->escape($data['vunitname']) . "',nordqty = '" . $this->db->escape($data['nordqty']) . "',nordunitprice = '" . $this->db->escape($data['nordunitprice']) . "',nordextprice = '" . $this->db->escape($data['nordextprice']) . "',nordtax = '" . $this->db->escape($data['nordtax']) . "',nordtextprice = '" . $this->db->escape($data['nordtextprice']) . "',vvendoritemcode = '" . $this->db->escape($data['vvendoritemcode']) . "',nunitcost = '" . $this->db->escape($data['nunitcost']) . "',itotalunit = '" . $this->db->escape($data['itotalunit']) . "',vsize = '" . $this->db->escape($data['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");

        return 'Successfully added items';
    }

    public function createMissingitem($data = array()) {
        
        $this->db2->query("INSERT INTO mst_missingitem SET  norderqty = '" . $this->db->escape($data['norderqty']) . "',vvendoritemcode = '" . $this->db->escape($data['vvendoritemcode']) . "',iinvoiceid = '" . $this->db->escape($data['iinvoiceid']) . "',vbarcode = '" . $this->db->escape($data['vbarcode']) . "',vitemname = '" . $this->db->escape($data['vitemname']) . "',nsellunit = '" . $this->db->escape($data['nsellunit']) . "',dcostprice = '" . $this->db->escape($data['dcostprice']) . "',dunitprice = '" . $this->db->escape($data['dunitprice']) . "',vcatcode = '" . $this->db->escape($data['vcatcode']) . "',vdepcode = '" . $this->db->escape($data['vdepcode']) . "',vsuppcode = '" . $this->db->escape($data['vsuppcode']) . "',vtax1 = '" . $this->db->escape($data['vtax1']) . "',vitemtype = '" . $this->db->escape($data['vitemtype']) . "',npack = '" . $this->db->escape($data['npack']) . "',vitemcode = '" . $this->db->escape($data['vitemcode']) . "',vunitcode = '" . $this->db->escape($data['vunitcode']) . "',nunitcost = '" . $this->db->escape($data['nunitcost']) . "',SID = '" . (int)($this->session->data['sid'])."'");
            
        return 'Successfully added missing items';
    }

    public function updatePurchaseOrderReturnTotal($nReturnTotal,$poid) {
        
        $this->db2->query("UPDATE trn_purchaseorder SET  nreturntotal = '" . $nReturnTotal . "' WHERE ipoid='". (int)$poid ."'");
            
        return 'Successfully updated return total';
    }


}
?>