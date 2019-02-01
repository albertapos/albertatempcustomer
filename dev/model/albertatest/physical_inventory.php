<?php
class ModelAlbertatestPhysicalInventory extends Model {
    public function getPhysicalInventories() {
        $data = array();

        $inventory_datas = $this->db2->query("SELECT * FROM trn_physicalinventory")->rows;

        foreach ($inventory_datas as $key => $inventory_data) {
            $inventory_detail_datas = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($inventory_data['ipiid']) . "' ")->rows;
            $data[$key] = $inventory_data;
            $data[$key]['items'] = $inventory_detail_datas;
        }

        return $data;
    }

    public function getPhysicalInventory($ipiid) {
        $data = array();
        $query = $this->db2->query("SELECT * FROM trn_physicalinventory WHERE ipiid='" .(int)$ipiid. "'")->row;

        $inventory_detail_datas = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$ipiid . "' ")->rows;
        $data = $query;
        $data['items'] = $inventory_detail_datas;
        return $data;
    }

    public function getPhysicalInventorySearch($search) {
        $inventory_datas = $this->db2->query("SELECT * FROM trn_physicalinventory WHERE vpinvtnumber LIKE  '%" .$this->db->escape($search). "%' OR vrefnumber LIKE  '%" .$this->db->escape($search). "%' OR vtype LIKE  '%" .$this->db->escape($search). "%' OR vordertitle LIKE  '%" .$this->db->escape($search). "%' ")->rows;

        $data = array();

        foreach ($inventory_datas as $key => $inventory_data) {
            $inventory_detail_datas = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($inventory_data['ipiid']) . "' ")->rows;
            $data[$key] = $inventory_data;
            $data[$key]['items'] = $inventory_detail_datas;
        }

        return $data;
    }

    public function getLastInsertedID() {
        $query = $this->db2->query("SELECT ipiid FROM trn_physicalinventory ORDER BY ipiid DESC LIMIT 1");

        return $query->row;
    }

    public function addPhysicalInventory($datas = array(),$status = null) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

                if(!empty($status)){
                    $status = $status;
                }else{
                    $status = $this->db->escape($data['estatus']);
                }

               try {
                    $this->db2->query("INSERT INTO trn_physicalinventory SET  vpinvtnumber = '" . $this->db->escape($data['vpinvtnumber']) . "',`vrefnumber` = '" . $this->db->escape($data['vrefnumber']) . "', nnettotal = '" . $this->db->escape($data['nnettotal']) . "',`ntaxtotal` = '" . $this->db->escape($data['ntaxtotal']) . "',`dcreatedate` = '" . $this->db->escape($data['dcreatedate']) . "', estatus = '" . $status . "', vordertitle = '" . $this->db->escape($data['vordertitle']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', dlastupdate = '" . $this->db->escape($data['dlastupdate']) . "', vtype = '" . $this->db->escape($data['vtype']) . "', ilocid = '" . $this->db->escape($data['ilocid']) . "', dcalculatedate = '" . $this->db->escape($data['dcalculatedate']) . "', dclosedate = '" . $this->db->escape($data['dclosedate']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $ipiid = $this->db2->getLastId();
                    if(count($data['items']) > 0){

                        foreach ($data['items'] as $k => $item) {
                            
                            $this->db2->query("INSERT INTO trn_physicalinventorydetail SET  ipiid = '" . (int)$ipiid . "',`vitemid` = '" . $this->db->escape($item['vitemid']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "',`vunitcode` = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "', ndebitqty = '" . $this->db->escape($item['ndebitqty']) . "', ncreditqty = '" . $this->db->escape($item['ncreditqty']) . "', ndebitunitprice = '" . $this->db->escape($item['ndebitunitprice']) . "', ncrediteunitprice = '" . $this->db->escape($item['ncrediteunitprice']) . "', nordtax = '" . $this->db->escape($item['nordtax']) . "', ndebitextprice = '" . $this->db->escape($item['ndebitextprice']) . "', ncrditextprice = '" . $this->db->escape($item['ncrditextprice']) . "', ndebittextprice = '" . $this->db->escape($item['ndebittextprice']) . "', ncredittextprice = '" . $this->db->escape($item['ncredittextprice']) . "', vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vreasoncode = '" . $this->db->escape($item['vreasoncode']) . "', ndiffqty = '" . $this->db->escape($item['ndiffqty']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "',SID = '" . (int)($this->session->data['sid'])."'");
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

        $success['success'] = 'Successfully Added Physical Inventory';
        $success['ipiid'] = $ipiid;
        return $success;
    }

    public function editlistPhsicalInventory($datas = array(),$status = null) {

        $success =array();
        $error =array();
        
        if(isset($datas) && count($datas) > 0){
            foreach ($datas as $key => $data) {

                if(!empty($status)){
                    $status = $status;
                }else{
                    $status = $this->db->escape($data['estatus']);
                }

                try {

                    $this->db2->query("UPDATE trn_physicalinventory SET  vpinvtnumber = '" . $this->db->escape($data['vpinvtnumber']) . "',`vrefnumber` = '" . $this->db->escape($data['vrefnumber']) . "', nnettotal = '" . $this->db->escape($data['nnettotal']) . "',`ntaxtotal` = '" . $this->db->escape($data['ntaxtotal']) . "',`dcreatedate` = '" . $this->db->escape($data['dcreatedate']) . "', estatus = '" . $status . "', vordertitle = '" . $this->db->escape($data['vordertitle']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', dlastupdate = '" . $this->db->escape($data['dlastupdate']) . "', vtype = '" . $this->db->escape($data['vtype']) . "', ilocid = '" . $this->db->escape($data['ilocid']) . "', dcalculatedate = '" . $this->db->escape($data['dcalculatedate']) . "', dclosedate = '" . $this->db->escape($data['dclosedate']) . "' WHERE ipiid = '" . (int)$this->db->escape($data['ipiid']) . "'");

                    if(count($data['items']) > 0){

                        $physical_ids = $this->db2->query("SELECT `ipidetid` FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' ")->rows;

                        if(count($physical_ids) > 0){
                            foreach ($physical_ids as $k => $physical_id) {
                                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_physicalinventorydetail',`Action` = 'delete',`TableId` = '" . (int)$physical_id['ipidetid'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }

                        $this->db2->query("DELETE FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' ");

                        foreach ($data['items'] as $k => $item) {

                            $inventory_detail_datas = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' AND  vitemid='" . (int)$this->db->escape($item['vitemid']) . "' ")->row;

                            if(count($inventory_detail_datas) > 0){

                                $this->db2->query("UPDATE trn_physicalinventorydetail SET vitemname = '" . $this->db->escape($item['vitemname']) . "',`vunitcode` = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "', ndebitqty = '" . $this->db->escape($item['ndebitqty']) . "', ncreditqty = '" . $this->db->escape($item['ncreditqty']) . "', ndebitunitprice = '" . $this->db->escape($item['ndebitunitprice']) . "', ncrediteunitprice = '" . $this->db->escape($item['ncrediteunitprice']) . "', nordtax = '" . $this->db->escape($item['nordtax']) . "', ndebitextprice = '" . $this->db->escape($item['ndebitextprice']) . "', ncrditextprice = '" . $this->db->escape($item['ncrditextprice']) . "', ndebittextprice = '" . $this->db->escape($item['ndebittextprice']) . "', ncredittextprice = '" . $this->db->escape($item['ncredittextprice']) . "', vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vreasoncode = '" . $this->db->escape($item['vreasoncode']) . "', ndiffqty = '" . $this->db->escape($item['ndiffqty']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "' WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' AND  vitemid='" . (int)$this->db->escape($item['vitemid']) . "'");

                            }else{
                                $this->db2->query("INSERT INTO trn_physicalinventorydetail SET  ipiid = '" . (int)$this->db->escape($data['ipiid']) . "',`vitemid` = '" . $this->db->escape($item['vitemid']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "',`vunitcode` = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "', ndebitqty = '" . $this->db->escape($item['ndebitqty']) . "', ncreditqty = '" . $this->db->escape($item['ncreditqty']) . "', ndebitunitprice = '" . $this->db->escape($item['ndebitunitprice']) . "', ncrediteunitprice = '" . $this->db->escape($item['ncrediteunitprice']) . "', nordtax = '" . $this->db->escape($item['nordtax']) . "', ndebitextprice = '" . $this->db->escape($item['ndebitextprice']) . "', ncrditextprice = '" . $this->db->escape($item['ncrditextprice']) . "', ndebittextprice = '" . $this->db->escape($item['ndebittextprice']) . "', ncredittextprice = '" . $this->db->escape($item['ncredittextprice']) . "', vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vreasoncode = '" . $this->db->escape($item['vreasoncode']) . "', ndiffqty = '" . $this->db->escape($item['ndiffqty']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }

                        }

                    }else{
                        $physical_ids = $this->db2->query("SELECT `ipidetid` FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' ")->rows;

                        if(count($physical_ids) > 0){
                            foreach ($physical_ids as $k => $physical_id) {
                                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_physicalinventorydetail',`Action` = 'delete',`TableId` = '" . (int)$physical_id['ipidetid'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }

                        $this->db2->query("DELETE FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($data['ipiid']) . "' ");
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

        $success['success'] = 'Successfully Updated Physical Inventory';
        return $success;
    }

    public function getPhysicalInventoriesByTypeTotal($vtype) {
        
        $sql = "SELECT * FROM trn_physicalinventory WHERE vtype='" . $vtype . "' ";

        $inventory_datas = $this->db2->query($sql)->rows;

        $data = count($inventory_datas);

        return $data;
    }

    public function getPhysicalInventoriesByType($vtype, $datas = array()) {
        $data = array();

        $sql = "SELECT * FROM trn_physicalinventory WHERE vtype='" . $vtype . "' ";

        if(isset($datas['searchbox']) && !empty($datas['searchbox'])){
            $sql .= " AND ipiid= ". $this->db->escape($datas['searchbox']);
        }

        $sql .= ' ORDER BY LastUpdate DESC';

        if (isset($datas['start']) || isset($datas['limit'])) {
            if ($datas['start'] < 0) {
                $datas['start'] = 0;
            }

            if ($datas['limit'] < 1) {
                $datas['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$datas['start'] . "," . (int)$datas['limit'];
        }

        $inventory_datas = $this->db2->query($sql)->rows;

        foreach ($inventory_datas as $key => $inventory_data) {
            $inventory_detail_datas = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='" . (int)$this->db->escape($inventory_data['ipiid']) . "' ")->rows;
            $data[$key] = $inventory_data;
            $data[$key]['items'] = $inventory_detail_datas;
        }

        return $data;
    }

    public function calclulatePost($datas = array()) {

        $success =array();
        $error =array();

        $data = $datas[0];

        if(isset($datas) && count($datas) > 0){

            if($data['vtype'] == 'Physical'){

                $cal_date = $data['dcalculatedate'];
                $to_date = date('Y-m-d');

                if(count($data['items']) > 0){
                    $temp_items = array();
                    foreach ($data['items'] as $k => $item) {
                       
                        $sql = "SELECT ifnull(SUM(trn_sd.ndebitqty),0) as debitqty FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$cal_date."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$to_date."' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode='". $this->db->escape($item['vbarcode']) ."'";

                        $query_data = $this->db2->query($sql)->row;

                        $item['itotalunit'] = $item['itotalunit'] - $query_data['debitqty'];
                        $item['ndebitqty'] = $item['itotalunit'] / $item['npackqty'];
                        $item['ndebitextprice'] = number_format((float)$item['itotalunit'] * $item['nunitcost'], 2, '.', '');

                        $temp_items[] = $item;
                    }

                    $data['items'] = $temp_items;
                    $datas[0]['items'] = $temp_items;
                }
            }

            $status = 'Close';
            if(isset($data['ipiid'])){
                $this->editlistPhsicalInventory($datas,$status);
                $trn_physicalinventory_id = $data['ipiid'];
            }else{
                $add_physical = $this->addPhysicalInventory($datas,$status);
                $trn_physicalinventory_id = $add_physical['ipiid'];
            }

           try {
                if(count($data['items']) > 0){

                    foreach ($data['items'] as $k => $item) {
                        //update QOH in mst_item table
                        $parent_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ")->row;
                        if($parent_item['visinventory'] == 'Yes'){
                            if($parent_item['isparentchild'] == 1){
                                if($data['vtype'] == 'Waste'){

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'WstQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->is_child = 'Yes';
                                    $x_general->parentmasterid = $old_item_values['parentmasterid'];
                                    $x_general->current_waste_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;

                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['iitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);

                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '0', general = '" . $x_general . "', source = 'Waste', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    }
                                    //trn_webadmin_history


                                    $parent_master_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($parent_item['parentmasterid']) . "' ")->row;
                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_master_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', vtype = 'WstQOH', noldamt = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', nnewamt = '" . ($this->db->escape($parent_master_item['iqtyonhand']) - $this->db->escape($item['itotalunit'])) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_master_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general_parent = new stdClass();
                                    $x_general_parent->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general_parent->is_parent = 'Yes';
                                    $x_general_parent->current_waste_item_values = $item;
                                    $x_general_parent->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_master_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_master_item['iqtyonhand']) - $this->db->escape($item['itotalunit'])) ."', source = 'Waste', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id_parent = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = iqtyonhand-'" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$parent_item['parentmasterid'] . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['parentmasterid']) ."' ")->row;
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
                                }else if($data['vtype'] == 'Physical'){

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'PhyQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->is_child = 'Yes';
                                    $x_general->parentmasterid = $old_item_values['parentmasterid'];
                                    $x_general->current_physical_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['iitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'PhyQOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '0', general = '" . $x_general . "', source = 'Physical', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    }
                                    //trn_webadmin_history


                                    $parent_master_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($parent_item['parentmasterid']) . "' ")->row;

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_master_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', vtype = 'PhyQOH', noldamt = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', nnewamt = '" . $this->db->escape($item['itotalunit']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_master_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general_parent = new stdClass();
                                    $x_general_parent->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general_parent->is_parent = 'Yes';
                                    $x_general_parent->current_physical_item_values = $item;
                                    $x_general_parent->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_master_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', newamount = '". $this->db->escape($item['itotalunit']) ."', source = 'Physical', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id_parent = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = '" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$parent_item['parentmasterid'] . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['parentmasterid']) ."' ")->row;
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

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'AdjQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->is_child = 'Yes';
                                    $x_general->parentmasterid = $old_item_values['parentmasterid'];
                                    $x_general->current_adjustment_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['iitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '0', general = '" . $x_general . "', source = 'Adjustment', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    }
                                    //trn_webadmin_history

                                    $parent_master_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($parent_item['parentmasterid']) . "' ")->row;

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_master_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', vtype = 'AdjQOH', noldamt = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', nnewamt = '" . ($this->db->escape($parent_master_item['iqtyonhand']) + $this->db->escape($item['itotalunit'])) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_master_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general_parent = new stdClass();
                                    $x_general_parent->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general_parent->is_parent = 'Yes';
                                    $x_general_parent->current_adjustment_item_values = $item;
                                    $x_general_parent->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_master_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_master_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_master_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_master_item['iqtyonhand']) + $this->db->escape($item['itotalunit'])) ."', source = 'Adjustment', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id_parent = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = iqtyonhand+'" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$parent_item['parentmasterid'] . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($parent_item['parentmasterid']) ."' ")->row;
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
                                }
                            }else{
                                if($data['vtype'] == 'Waste'){

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'WstQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '" . ($this->db->escape($parent_item['iqtyonhand']) - $this->db->escape($item['itotalunit'])) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->current_waste_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_item['iqtyonhand']) - $this->db->escape($item['itotalunit'])) ."', source = 'Waste', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = iqtyonhand-'" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;
                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id . "'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    //trn_webadmin_history
                                    }
                                }else if($data['vtype'] == 'Physical'){

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'PhyQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '" . $this->db->escape($item['itotalunit']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->current_physical_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". $this->db->escape($item['itotalunit']) ."', source = 'Physical', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = '" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;
                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id . "'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    }
                                    //trn_webadmin_history
                                }else{

                                    //trn_itempricecosthistory
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'AdjQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '" . ($this->db->escape($parent_item['iqtyonhand']) + $this->db->escape($item['itotalunit'])) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                    //trn_itempricecosthistory

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $parent_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->trn_physicalinventory_id = $trn_physicalinventory_id;
                                    $x_general->current_adjustment_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_item['iqtyonhand']) + $this->db->escape($item['itotalunit'])) ."', source = 'Adjustment', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id = $this->db2->getLastId();
                                    }
                                    //trn_webadmin_history

                                    $this->db2->query("UPDATE mst_item SET  iqtyonhand = iqtyonhand+'" . $this->db->escape($item['itotalunit']) . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'");

                                    //trn_webadmin_history
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;
                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id . "'");
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

        $success['success'] = 'Successfully Calculated/Posted';
        return $success;
    }

    public function getItemBySKU($vbarcode){
        $query = $this->db2->query("SELECT a.iitemid,a.vbarcode,a.vitemname,a.npack,a.nunitcost,a.vunitcode FROM mst_item a,mst_unit b WHERE a.vbarcode='". $vbarcode ."'")->row;

        if(count($query) == 0){
            $query1 = $this->db2->query("SELECT vsku FROM mst_itemalias WHERE valiassku='". $vbarcode ."'")->row;

            if(count($query1) > 0){
                $query = $this->db2->query("SELECT a.iitemid,a.vbarcode,a.vitemname,a.npack,a.nunitcost,a.vunitcode FROM mst_item a,mst_unit b WHERE a.vbarcode='". $query1['vsku'] ."'")->row;
            }

        }
        return $query;
    }

    public function getItemBySKUipiid($ipiid,$vitemid){
        $query = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE ipiid='". $ipiid ."' AND vitemid='". $vitemid ."'")->rows;
        return $query;
    }

    public function insertInventory($ipiid,$item){

        $this->db2->query("INSERT INTO trn_physicalinventorydetail SET  ipiid = '" . (int)$ipiid . "',`vitemid` = '" . $this->db->escape($item['vitemid']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "',`vunitcode` = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "', ndebitqty = '" . $this->db->escape($item['ndebitqty']) . "', ncreditqty = '" . $this->db->escape($item['ncreditqty']) . "', ndebitunitprice = '" . $this->db->escape($item['ndebitunitprice']) . "', ncrediteunitprice = '" . $this->db->escape($item['ncrediteunitprice']) . "', nordtax = '" . $this->db->escape($item['nordtax']) . "', ndebitextprice = '" . $this->db->escape($item['ndebitextprice']) . "', ncrditextprice = '" . $this->db->escape($item['ncrditextprice']) . "', ndebittextprice = '" . $this->db->escape($item['ndebittextprice']) . "', ncredittextprice = '" . $this->db->escape($item['ncredittextprice']) . "', vbarcode = '" . $this->db->escape($item['vbarcode']) . "', vreasoncode = '" . $this->db->escape($item['vreasoncode']) . "', ndiffqty = '" . $this->db->escape($item['ndiffqty']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "',SID = '" . (int)($this->session->data['sid'])."'");

        $ipidetid = $this->db2->getLastId();
        return $ipidetid;

    }

    public function updatennettotal($ipiid,$total_nnettotal){
        $this->db2->query("UPDATE trn_physicalinventory SET  nnettotal = nnettotal+'" . $total_nnettotal . "'WHERE ipiid = '" . (int)$ipiid . "'");
    }

    public function calclulatePostCheckData($datas = array()) {

        $data = $datas[0];

        if(isset($datas) && count($datas) > 0){

            if($data['vtype'] == 'Physical'){

                $cal_date = $data['dcalculatedate'];
                $to_date = date('Y-m-d');

                if(count($data['items']) > 0){
                    $temp_items = array();
                    foreach ($data['items'] as $k => $item) {
                       
                        $sql = "SELECT ifnull(SUM(trn_sd.ndebitqty),0) as debitqty FROM trn_salesdetail trn_sd , trn_sales trn_s WHERE trn_s.vtrntype='Transaction' AND  trn_sd.ndebitqty > 0 AND date_format(trn_s.dtrandate,'%Y-%m-%d') >= '".$cal_date."' AND date_format(trn_s.dtrandate,'%Y-%m-%d') <= '".$to_date."' AND trn_s.isalesid=trn_sd.isalesid AND trn_sd.vitemcode='". $this->db->escape($item['vbarcode']) ."'";

                        $query_data = $this->db2->query($sql)->row;

                        $item['sale_qty'] = $query_data['debitqty'];

                        $temp_items[] = $item;
                    }

                    $data['items'] = $temp_items;
                }
            }
            
        }
        
        return $data['items'];
    }

    
}
?>