<?php
class ModelApiTransfer extends Model {
    public function getTransfers($vtransfertype,$vvendorid) {
        if($vtransfertype == 'WarehouseToStore'){
            $query = $this->db2->query("SELECT * FROM trn_warehouseitems item LEFT JOIN trn_warehouseinvoice invoice ON(item.invoiceid=invoice.vinvnum) WHERE  item.vtransfertype!='StoretoWarehouse' AND item.vvendorid='" .$vvendorid. "'");

            return $query->rows;
        }else{
            $query = $this->db2->query("SELECT * FROM trn_warehouseitems item WHERE item.vtransfertype='" .$vtransfertype. "' AND item.vvendorid='" .$vvendorid. "'");

            return $query->rows;
        }
        
    }

    public function deleteTransferProduct($vtransfertype, $vvendorid, $vbarcode, $dreceivedate) {
        $success = array();

        $dreceivedate = DateTime::createFromFormat('m-d-Y', $dreceivedate);
        $dreceivedate = $dreceivedate->format('Y-m-d');

        $itemgroup = $this->db2->query("DELETE FROM trn_warehouseitems WHERE vtransfertype='" . $this->db->escape($vtransfertype) . "' AND vvendorid='" . (int)$this->db->escape($vvendorid) . "' AND vbarcode='" . $this->db->escape($vbarcode) . "' AND dreceivedate='" . $this->db->escape($dreceivedate) . "' ");

        $success['success'] = 'Successfully Deleted Transfer Product';
        return $success;
    
    }

    public function addTransfer($datas = array()) {
        
        $success =array();
        $error =array();

        $istoreid = $this->db2->query("SELECT * FROM mst_store")->row;

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

                if(isset($data['items']) && count($data['items']) > 0){

                    if($data['vtransfertype'] == 'WarehouseToStore'){

                        $this->db2->query("INSERT INTO trn_warehouseinvoice SET  istoreid = '" . (int)$istoreid['istoreid'] . "',`vstorecode` = '" . $istoreid['vcompanycode'] . "', dinvoicedate = '" . $this->db->escape($data['dreceivedate']) . "',`vinvnum` = '" . $this->db->escape($data['vinvnum']) . "',`vvendorid` = '" . $this->db->escape($data['vvendorid']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                        $invoiceid = $this->db2->getLastId();

                    }

                    foreach ($data['items'] as $k => $item) {
                       try {
                            if($data['vtransfertype'] == 'WarehouseToStore'){
                                $this->db2->query("INSERT INTO trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "',`invoiceid` = '" . $invoiceid . "', vvendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`dreceivedate` = '" . $this->db->escape($data['dreceivedate']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', vtransfertype = '" . $this->db->escape($data['vtransfertype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) . "', vsize = '" . $this->db->escape($item['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }else{
                                $this->db2->query("INSERT INTO trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "', vvendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`dreceivedate` = '" . $this->db->escape($data['dreceivedate']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', vtransfertype = '" . $this->db->escape($data['vtransfertype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) . "', vsize = '" . $this->db->escape($item['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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
            }
        }

        $success['success'] = 'Successfully Added Transfer';
        return $success;
    }

    public function editlistTransfer($datas = array()) {

        $istoreid = $this->db2->query("SELECT * FROM mst_store")->row;
       
        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

                if(isset($data['items']) && count($data['items']) > 0){

                    if($data['vtransfertype'] == 'WarehouseToStore'){

                        $trn_inv = $this->db2->query("SELECT * FROM trn_warehouseinvoice WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vinvnum='" .$this->db->escape($data['vinvnum']). "'")->row;

                        if(count($trn_inv) > 0){
                            $this->db2->query("UPDATE trn_warehouseinvoice SET  istoreid = '" . (int)$istoreid['istoreid'] . "',`vstorecode` = '" . $istoreid['vcompanycode'] . "',`vinvnum` = '" . $this->db->escape($data['vinvnum']) . "',`dinvoicedate` = '" . $this->db->escape($data['dreceivedate']) . "' WHERE vvendorid='" . $this->db->escape($data['vvendorid']) . "' ");

                            // $invoiceid = $trn_inv['iid'];
                            $invoiceid = $data['vinvnum'];

                        }else{
                            $this->db2->query("INSERT INTO trn_warehouseinvoice SET  istoreid = '" . (int)$istoreid['istoreid'] . "',`vstorecode` = '" . $istoreid['vcompanycode'] . "', dinvoicedate = '" . $this->db->escape($data['dreceivedate']) . "',`vinvnum` = '" . $this->db->escape($data['vinvnum']) . "',`vvendorid` = '" . $this->db->escape($data['vvendorid']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                            // $invoiceid = $this->db2->getLastId();
                            $invoiceid = $data['vinvnum'];
                        }

                    }else{
                        $invoiceid = null;
                    }

                    // $delete_items = $this->db2->query("SELECT `iwtrnid` FROM trn_warehouseitems WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "'")->rows;

                    // if(count($delete_items) > 0){
                    //     foreach ($delete_items as $delete_item) {
                    //        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_warehouseitems',`Action` = 'delete',`TableId` = '" . (int)$delete_item['iwtrnid'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                    //     }
                    // }

                    // $this->db2->query("DELETE FROM trn_warehouseitems WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "'");

                    foreach ($data['items'] as $k => $item) {
                        if($item['ntransferqty'] != ''){

                            $trn_data = $this->db2->query("SELECT * FROM trn_warehouseitems WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "' AND invoiceid='" .$this->db->escape($invoiceid). "'")->row;

                            if(count($trn_data) > 0){
                                $trn_warehouseitems_id =$trn_data['iwtrnid']; 
                                if($data['vtransfertype'] == 'WarehouseToStore'){
                                    $this->db2->query("UPDATE trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "',`invoiceid` = '" . $invoiceid . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', dreceivedate = '" . $this->db->escape($data['dreceivedate']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) * $item['npackqty'] . "', vsize = '" . $this->db->escape($item['vsize']) . "' WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "' ");
                                }else{
                                    $this->db2->query("UPDATE trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', dreceivedate = '" . $this->db->escape($data['dreceivedate']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', vtransfertype = '" . $this->db->escape($data['vtransfertype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) * $item['npackqty'] . "', vsize = '" . $this->db->escape($item['vsize']) . "' WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "' ");
                                }
                            }else{
                                if($data['vtransfertype'] == 'WarehouseToStore'){
                                    $this->db2->query("INSERT INTO trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "',`invoiceid` = '" . $invoiceid . "', vvendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`dreceivedate` = '" . $this->db->escape($data['dreceivedate']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', vtransfertype = '" . $this->db->escape($data['vtransfertype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) * $item['npackqty'] . "', vsize = '" . $this->db->escape($item['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                                    $trn_warehouseitems_id =$this->db2->getLastId(); 
                                }else{
                                    $this->db2->query("INSERT INTO trn_warehouseitems SET  vwhcode = '" . $this->db->escape($data['vwhcode']) . "', vvendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`dreceivedate` = '" . $this->db->escape($data['dreceivedate']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', vvendortype = '" . $this->db->escape($data['vvendortype']) . "', vtransfertype = '" . $this->db->escape($data['vtransfertype']) . "', ntransferqty = '" . $this->db->escape($item['ntransferqty']) * $item['npackqty'] . "', vsize = '" . $this->db->escape($item['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                                    $trn_warehouseitems_id =$this->db2->getLastId(); 
                                }
                            }

                            if($data['vtransfertype'] == 'WarehouseToStore'){
                                $trn_qoh_data = $this->db2->query("SELECT * FROM trn_warehouseqoh WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'")->row;

                                if(count($trn_qoh_data) > 0){
                                    $this->db2->query("UPDATE trn_warehouseqoh SET  npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty =onhandcaseqty - '" . $this->db->escape($item['ntransferqty']) . "' WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'");
                                }else{
                                    $this->db2->query("INSERT INTO trn_warehouseqoh SET  ivendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty = '" . $this->db->escape($item['ntransferqty']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                $mst_item_data = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode='" .$this->db->escape($item['vbarcode']). "'")->row;
                                if(count($mst_item_data) > 0){

                                    if($mst_item_data['isparentchild'] == 1){
                                        $this->db2->query("UPDATE mst_item SET iqtyonhand = '0' WHERE vbarcode='" . $this->db->escape($item['vbarcode']) . "' ");

                                        //trn_itempricecosthistory

                                            $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $mst_item_data['iitemid'] . "',vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vtype = 'TrnfQOH', noldamt = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                                        //trn_itempricecosthistory

                                        //trn_webadmin_history
                                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                            $old_item_values = $mst_item_data;
                                            unset($old_item_values['itemimage']);

                                            $x_general_child = new stdClass();
                                            $x_general_child->trn_warehouseitems_id = $trn_warehouseitems_id;
                                            $x_general_child->is_child = 'Yes';
                                            $x_general_child->parentmasterid = $old_item_values['parentmasterid'];
                                            $x_general_child->current_transfer_item_values = $item;
                                            $x_general_child->old_item_values = $old_item_values;

                                            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$mst_item_data['iitemid'] ."' ")->row;
                                            unset($new_item_values['itemimage']);

                                            $x_general_child->new_item_values = $new_item_values;

                                            $x_general_child = addslashes(json_encode($x_general_child));
                                            try{

                                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $mst_item_data['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', newamount = '0', general = '" . $x_general_child . "', source = 'Transfer', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                            }
                                            //trn_webadmin_history

                                        //trn_itempricecosthistory

                                            $parent_item = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($mst_item_data['parentmasterid']) . "'")->row;
                                           
                                            $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'TrnfQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '". ($this->db->escape($parent_item['iqtyonhand']) + ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                            
                                        //trn_itempricecosthistory

                                        //trn_webadmin_history
                                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                            $old_item_values = $mst_item_data;
                                            unset($old_item_values['itemimage']);

                                            $x_general_parent = new stdClass();
                                            $x_general_parent->trn_warehouseitems_id = $trn_warehouseitems_id;
                                            $x_general_parent->is_parent = 'Yes';
                                            $x_general_parent->current_transfer_item_values = $item;
                                            $x_general_parent->old_item_values = $old_item_values;
                                            try{

                                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_item['iqtyonhand']) + ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', source = 'Transfer', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                            $trn_webadmin_history_last_id_parent = $this->db2->getLastId();
                                            }
                                        //trn_webadmin_history

                                        $this->db2->query("UPDATE mst_item SET  iqtyonhand =iqtyonhand + ('" . $this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']) . "') WHERE iitemid='" .$this->db->escape($mst_item_data['parentmasterid']). "'");

                                        //trn_webadmin_history
                                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                        $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$mst_item_data['parentmasterid'] ."' ")->row;
                                        unset($new_item_values['itemimage']);
                                        $x_general_parent->new_item_values = $new_item_values;

                                        $x_general_parent = addslashes(json_encode($x_general_parent));
                                        try{

                                        $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general_parent . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_parent . "'");
                                        }
                                        catch (Exception $e) {
                                            $this->log->write($e);
                                        }
                                        }
                                        //trn_webadmin_history


                                    }else{
                                        $this->db2->query("UPDATE mst_item SET  iqtyonhand =iqtyonhand + ('" . $this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']) . "') WHERE vbarcode='" .$this->db->escape($item['vbarcode']). "'");
                                        //trn_itempricecosthistory
                                        
                                        $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $mst_item_data['iitemid'] . "',vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vtype = 'TrnfQOH', noldamt = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', nnewamt = '". ($this->db->escape($mst_item_data['iqtyonhand']) + ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                        
                                        //trn_itempricecosthistory

                                        //trn_webadmin_history
                                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                            $old_item_values = $mst_item_data;
                                            unset($old_item_values['itemimage']);

                                            $x_general = new stdClass();
                                            $x_general->trn_warehouseitems_id = $trn_warehouseitems_id;
                                            $x_general->current_transfer_item_values = $item;
                                            $x_general->old_item_values = $old_item_values;
                                            
                                            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$mst_item_data['iitemid'] ."' ")->row;
                                            unset($new_item_values['itemimage']);

                                            $x_general->new_item_values = $new_item_values;

                                            $x_general = addslashes(json_encode($x_general));
                                            try{

                                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $mst_item_data['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', newamount = '". ($this->db->escape($mst_item_data['iqtyonhand']) + ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', general = '" . $x_general . "', source = 'Transfer', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                        }
                                        //trn_webadmin_history
                                    }
                                }

                            }else{
                                $trn_qoh_data = $this->db2->query("SELECT * FROM trn_warehouseqoh WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'")->row;

                                if(count($trn_qoh_data) > 0){
                                    $this->db2->query("UPDATE trn_warehouseqoh SET  npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty =onhandcaseqty + '" . $this->db->escape($item['ntransferqty']) . "' WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'");
                                }else{
                                    $this->db2->query("INSERT INTO trn_warehouseqoh SET  ivendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty = '" . $this->db->escape($item['ntransferqty']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                $mst_item_data = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode='" .$this->db->escape($item['vbarcode']). "'")->row;
                                if(count($mst_item_data) > 0){
                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand =iqtyonhand - ('" . $this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']) . "') WHERE vbarcode='" .$this->db->escape($item['vbarcode']). "'");

                                    //trn_itempricecosthistory
                                        
                                        $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $mst_item_data['iitemid'] . "',vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vtype = 'TrnfQOH', noldamt = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', nnewamt = '". ($this->db->escape($mst_item_data['iqtyonhand']) - ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                        
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                        $old_item_values = $mst_item_data;
                                        unset($old_item_values['itemimage']);

                                        $x_general = new stdClass();
                                        $x_general->trn_warehouseitems_id = $trn_warehouseitems_id;
                                        $x_general->current_transfer_item_values = $item;
                                        $x_general->old_item_values = $old_item_values;

                                        $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($mst_item_data['iitemid']) ."' ")->row;
                                        unset($new_item_values['itemimage']);
                                        $x_general->new_item_values = $new_item_values;

                                        $x_general = addslashes(json_encode($x_general));
                                        try{

                                        $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $mst_item_data['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($mst_item_data['iqtyonhand']) . "', newamount = '". ($this->db->escape($mst_item_data['iqtyonhand']) - ($this->db->escape($item['ntransferqty']) * $this->db->escape($item['npackqty']))) ."', general = '" . $x_general . "', source = 'Transfer', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                        }
                                        catch (Exception $e) {
                                            $this->log->write($e);
                                        }
                                    }
                                    //trn_webadmin_history
                                }
                            }
                        }
                    }
                }else{
                    $delete_items = $this->db2->query("SELECT `iwtrnid` FROM trn_warehouseitems WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "'")->rows;

                    if(count($delete_items) > 0){
                        foreach ($delete_items as $delete_item) {
                           $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_warehouseitems',`Action` = 'delete',`TableId` = '" . (int)$delete_item['iwtrnid'] . "'SID = '" . (int)($this->session->data['sid'])."'");
                        }
                    }

                    $this->db2->query("DELETE FROM trn_warehouseitems WHERE vvendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['vtransfertype']). "'");
                }
            }

        }

        $success['success'] = 'Successfully Updated Transfer';
        return $success;
    }

    public function getCheckInvoice($invoice) {
        $invoices = $this->db2->query("SELECT * FROM trn_warehouseitems WHERE invoiceid='" .$this->db->escape($invoice). "'")->row;
        $return = array();
        if(count($invoices) > 0){
            $return['error'] = 'Invoice Already Exist!';
        }else{
            $return['success'] = 'Not Exist!';
        }

        return $return;

    }

    public function getTransfersData($data = array()) {

        $sql = "SELECT tw.*, ms.vstorename,msupp.vcompanyname FROM trn_warehouseinvoice as tw LEFT JOIN mst_store as ms ON (tw.istoreid=ms.istoreid) LEFT JOIN mst_supplier as msupp ON (msupp.isupplierid=tw.vvendorid)";

        $sql .= ' ORDER BY tw.LastUpdate DESC';

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

    public function getTransfersTotal($data = array()) {

        $sql = "SELECT * FROM trn_warehouseinvoice";

        $query = $this->db2->query($sql);

        return count($query->rows);
    }

}
?>