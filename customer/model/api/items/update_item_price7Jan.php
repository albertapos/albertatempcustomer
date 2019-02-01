<?php
class ModelApiItemsUpdateItemPrice extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT a.iitemid as iitemid FROM mst_item as a";
            
             if(!empty($data['search_find'])){
                $sql .= " WHERE estatus='Active' AND iitemid= ". $this->db->escape($data['search_find']);
                $sql .= " AND estatus='Active' AND vitemtype= '". $this->db->escape($data['search_item_type'])."'";
            }else{
                $sql .= " WHERE estatus='Active' AND vitemtype= '". $this->db->escape($data['search_item_type'])."'";
            }
        
        $query = $this->db2->query($sql);
        
        $return_arr = array();

        $return_arr['total'] = count($query->rows);
        
        return $return_arr;
    }

    public function getItems($itemdata = array()) {
        $datas = array();
        $sql_string = '';

        if (isset($itemdata['search_find']) && !empty($itemdata['search_find'])) {
            $sql_string .= " WHERE a.estatus='Active' AND a.iitemid= ". $this->db->escape($itemdata['search_find']);
            $sql_string .= " AND a.estatus='Active' AND a.vitemtype= '". $this->db->escape($itemdata['search_item_type'])."'";

            if (isset($itemdata['start']) || isset($itemdata['limit'])) {
                if ($itemdata['start'] < 0) {
                    $itemdata['start'] = 0;
                }

                if ($itemdata['limit'] < 1) {
                    $itemdata['limit'] = 20;
                }

                $sql_string .= " LIMIT " . (int)$itemdata['start'] . "," . (int)$itemdata['limit'];
            }
        }else{
            $sql_string .= " WHERE a.estatus='Active' AND a.vitemtype= '". $this->db->escape($itemdata['search_item_type'])."'";
            $sql_string .= ' ORDER BY a.LastUpdate DESC';

            if (isset($itemdata['start']) || isset($itemdata['limit'])) {
                if ($itemdata['start'] < 0) {
                    $itemdata['start'] = 0;
                }

                if ($itemdata['limit'] < 1) {
                    $itemdata['limit'] = 20;
                }

                $sql_string .= " LIMIT " . (int)$itemdata['start'] . "," . (int)$itemdata['limit'];
            }

        }

        $query = $this->db2->query("SELECT a.iitemid, a.vitemtype, a.vitemname, a.vbarcode, a.vcategorycode, a.vdepcode, a.vsuppliercode, a.vunitcode, a.iqtyonhand, a.vtax1, a.vtax2, a.dcostprice, a.dunitprice, a.visinventory, a.isparentchild, mc.vcategoryname, md.vdepartmentname, ms.vcompanyname, mu.vunitname , CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a LEFT JOIN mst_category mc ON(mc.vcategorycode=a.vcategorycode) LEFT JOIN mst_department md ON(md.vdepcode=a.vdepcode) LEFT JOIN mst_supplier ms ON(ms.vsuppliercode=a.vsuppliercode) LEFT JOIN mst_unit mu ON(mu.vunitcode=a.vunitcode) $sql_string ");

        return $query->rows;
    }

    public function editlistItems($data = array()) {

        $success =array();
        $error =array();
       
        if(isset($data) && count($data) > 0){

              try {

                    foreach($data as $value){

                        $current_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value['iitemid'] ."'")->row;

                        if((($current_item['dcostprice'] != $value['dcostprice']) && ($current_item['dcostprice'] != '0.0000') && $current_item['isparentchild'] !=1) && (($current_item['dunitprice'] != $value['dunitprice']) && ($current_item['dunitprice'] != '0.00'))){

                            //trn_webadmin_history
                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $current_item;
                                unset($old_item_values['itemimage']);
                                $x_general = new stdClass();
                                $x_general->old_item_values = $old_item_values;
                                try{

                                $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $value['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'All', oldamount = '0', newamount = '0', source = 'UpdateItemPrice', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                    $this->log->write($e);
                                }

                                $trn_webadmin_history_last_id = $this->db2->getLastId();
                            }
                            //trn_webadmin_history

                            $unitcost = $value['dcostprice'] / $current_item['npack'];

                            $this->db2->query("UPDATE mst_item SET dcostprice = '" . $this->db->escape($value['dcostprice']) . "', nunitcost = '" . $unitcost . "',dunitprice = '" . $this->db->escape($value['dunitprice']) . "' WHERE iitemid = '" . (int)$value['iitemid'] . "'");

                            //trn_itempricecosthistory
                            $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
                            if($current_item['dcostprice'] != $new_update_values['dcostprice']){

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                            }

                            if($current_item['dunitprice'] != $new_update_values['dunitprice']){

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipPrice', noldamt = '" . $this->db->escape($current_item['dunitprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                            }
                            //trn_itempricecosthistory

                            //trn_webadmin_history
                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
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
                            if(($current_item['dcostprice'] != $value['dcostprice']) && ($current_item['dcostprice'] != '0.0000') && $current_item['isparentchild'] !=1){

                                //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $current_item;
                                    unset($old_item_values['itemimage']);
                                    $x_general = new stdClass();
                                    $x_general->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $value['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $current_item['dcostprice'] . "', newamount = '". $value['dcostprice'] ."', source = 'UpdateItemPrice', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }

                                    $trn_webadmin_history_last_id_cost = $this->db2->getLastId();
                                }
                                //trn_webadmin_history

                                $unitcost = $value['dcostprice'] / $current_item['npack'];

                                $this->db2->query("UPDATE mst_item SET dcostprice = '" . $this->db->escape($value['dcostprice']) . "', nunitcost = '" . $unitcost . "' WHERE iitemid = '" . (int)$value['iitemid'] . "'");

                                //trn_itempricecosthistory
                                $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
                                if($current_item['dcostprice'] != $new_update_values['dcostprice']){

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                if($current_item['dunitprice'] != $new_update_values['dunitprice']){

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipPrice', noldamt = '" . $this->db->escape($current_item['dunitprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                //trn_itempricecosthistory

                                //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
                                    unset($new_item_values['itemimage']);

                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_cost . "'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                }
                                //trn_webadmin_history
                            }

                            if(($current_item['dunitprice'] != $value['dunitprice']) && ($current_item['dunitprice'] != '0.00')){
                                    //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $old_item_values = $current_item;
                                    unset($old_item_values['itemimage']);
                                    $x_general = new stdClass();
                                    $x_general->old_item_values = $old_item_values;
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $value['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'Price', oldamount = '" . $current_item['dunitprice'] . "', newamount = '". $value['dunitprice'] ."', source = 'UpdateItemPrice', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                    $trn_webadmin_history_last_id_price = $this->db2->getLastId();
                                }
                                    //trn_webadmin_history

                                $this->db2->query("UPDATE mst_item SET dunitprice = '" . $this->db->escape($value['dunitprice']) . "' WHERE iitemid = '" . (int)$value['iitemid'] . "'");

                                //trn_itempricecosthistory
                                $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
                                if($current_item['dcostprice'] != $new_update_values['dcostprice']){

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                if($current_item['dunitprice'] != $new_update_values['dunitprice']){

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipPrice', noldamt = '" . $this->db->escape($current_item['dunitprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                //trn_itempricecosthistory

                                //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$value['iitemid'] ."' ")->row;
                                    unset($new_item_values['itemimage']);

                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_price . "'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                }
                                //trn_webadmin_history
                            }
                        }

                        $this->db2->query("UPDATE mst_item SET vtax1 = '" . $this->db->escape($value['vtax1']) . "', vtax2 = '" . $this->db->escape($value['vtax2']) . "' WHERE iitemid = '" . (int)$value['iitemid'] . "'");

                        if(($current_item['dcostprice'] != $value['dcostprice']) && ($current_item['dcostprice'] != '0.0000') && $current_item['isparentchild'] !=1){
                            // update child values
                            $isParentCheck = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value['iitemid'] ."'")->row;
                           
                            if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                                $child_items = $this->db2->query("SELECT `iitemid`,`vbarcode`,`dcostprice`,`npack` FROM mst_item WHERE parentmasterid= '". (int)$value['iitemid'] ."' ")->rows;

                                if(count($child_items) > 0){
                                    foreach($child_items as $chi_item){

                                        //trn_webadmin_history
                                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                            $old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;
                                            unset($old_item_values['itemimage']);

                                            $x_general_child = new stdClass();
                                            $x_general_child->is_child = 'Yes';
                                            $x_general_child->parentmasterid = $old_item_values['parentmasterid'];
                                            $x_general_child->old_item_values = $old_item_values;
                                            try{

                                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($chi_item['iitemid']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($chi_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $chi_item['dcostprice'] . "', newamount = '". (($chi_item['npack']) * ($this->db->escape($isParentCheck['nunitcost']))) ."', source = 'UpdateItemPrice', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                            $trn_webadmin_history_last_id_child = $this->db2->getLastId();
                                        }
                                        //trn_webadmin_history

                                        $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                            '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");

                                        //trn_itempricecosthistory
                                        $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$chi_item['iitemid'] ."' ")->row;
                                        if($chi_item['dcostprice'] != $new_update_values['dcostprice']){

                                            $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'UipCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                        }

                                        //trn_itempricecosthistory

                                        //trn_webadmin_history
                                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;
                                            unset($new_item_values['itemimage']);

                                            $x_general_child->new_item_values = $new_item_values;

                                            $x_general_child = addslashes(json_encode($x_general_child));
                                            try{

                                            $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general_child . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_child . "'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                        }
                                        //trn_webadmin_history
                                    }
                                }
                            }

                            //update item pack details
                            if($this->db->escape($isParentCheck['vitemtype']) == 'Lot Matrix'){
                        
                                if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                                    $lot_child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$value['iitemid'] ."' ")->rows;

                                    if(count($lot_child_items) > 0){
                                        foreach($lot_child_items as $chi){
                                            $pack_lot_child_item = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid= '". (int)$this->db->escape($chi['iitemid']) ."' ")->rows;

                                            if(count($pack_lot_child_item) > 0){
                                                foreach ($pack_lot_child_item as $k => $v) {
                                                    $parent_nunitcost = $this->db->escape($isParentCheck['nunitcost']);

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

                                $vpackname = 'Case';
                                $vdesc = 'Case';

                                $nunitcost = $this->db->escape($isParentCheck['nunitcost']);
                                if($nunitcost == ''){
                                    $nunitcost = 0;
                                }

                                $ipack = $this->db->escape($isParentCheck['nsellunit']);
                                if($this->db->escape($isParentCheck['nsellunit']) == ''){
                                    $ipack = 0;
                                }

                                $npackprice = $this->db->escape($isParentCheck['dunitprice']);
                                if($this->db->escape($isParentCheck['dunitprice']) == ''){
                                    $npackprice = 0;
                                }

                                $npackcost = (int)$ipack * $nunitcost;
                                $iparentid = 1;
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

                                $itempackexist = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE vbarcode='". $this->db->escape($isParentCheck['vbarcode']) ."' AND iitemid='". (int)$value ."' AND iparentid=1")->row;

                                if(count($itempackexist) > 0){
                                    $this->db2->query("UPDATE mst_itempackdetail SET `ipack` = '" . (int)$ipack . "',`npackcost` = '" . $npackcost . "',`nunitcost` = '" . $nunitcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "' WHERE vbarcode='". $this->db->escape($isParentCheck['vbarcode']) ."' AND iitemid='". (int)$value ."' AND iparentid=1");
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

        $success['success'] = 'Successfully Updated Item Price';
        return $success;
    }
}
?>