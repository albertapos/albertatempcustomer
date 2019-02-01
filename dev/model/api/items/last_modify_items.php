<?php
class ModelApiItemsLastModifyItems extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT a.iitemid as iitemid FROM mst_item as a WHERE a.estatus='Active'";

        if (!empty($data['search_radio'])) {
            
            if(count($data['search_find_dates']) > 0 && $data['search_radio'] == 'by_dates'){
                
                $start_date = DateTime::createFromFormat('m-d-Y', $data['search_find_dates']['seach_start_date']);
                $data['start_date'] = $start_date->format('Y-m-d');

                $end_date = DateTime::createFromFormat('m-d-Y', $data['search_find_dates']['seach_end_date']);
                $data['end_date'] = $end_date->format('Y-m-d');

                $sql .= " AND date_format(a.LastUpdate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(a.LastUpdate,'%Y-%m-%d') <= '".$data['end_date']."'";

            }else if(!empty($data['search_find']) && $data['search_radio'] == 'search'){
                $sql .= " AND a.vitemname LIKE  '%" .$this->db->escape($data['search_find']). "%' ";
            }
        }

        $sql .=" ORDER BY LastUpdate DESC";
        
        $query = $this->db2->query($sql);

        $return_arr = array();

        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {
                $return_arr['iitemid'][$key] = $value['iitemid'];
            }
        }else{
            $return_arr['iitemid'] = array();
        }

        $return_arr['total'] = count($query->rows);
        
        return $return_arr;
    }

    public function getItems($itemdata = array()) {
        $datas = array();
        $sql_string = '';

        // if (isset($itemdata['searchbox']) && !empty($itemdata['searchbox'])) {
        //     $sql_string .= " WHERE a.iitemid= ". (int)$this->db->escape($itemdata['searchbox']);
        // }

        if (isset($itemdata['search_radio']) && !empty($itemdata['search_radio'])) {
            if(count($itemdata['search_find_dates']) > 0 && $itemdata['search_radio'] == 'by_dates'){
                
                $start_date = DateTime::createFromFormat('m-d-Y', $itemdata['search_find_dates']['seach_start_date']);
                $data['start_date'] = $start_date->format('Y-m-d');

                $end_date = DateTime::createFromFormat('m-d-Y', $itemdata['search_find_dates']['seach_end_date']);
                $data['end_date'] = $end_date->format('Y-m-d');

                $sql_string .= " WHERE a.estatus='Active' AND date_format(a.LastUpdate,'%Y-%m-%d') >= '".$data['start_date']."' AND date_format(a.LastUpdate,'%Y-%m-%d') <= '".$data['end_date']."'";

            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'search'){
                $sql_string .= " WHERE a.estatus='Active' AND a.vitemname LIKE  '%" .$this->db->escape($itemdata['search_find']). "%' ";
            }

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
        }else{
            $sql_string .= ' WHERE a.estatus="Active" ORDER BY a.LastUpdate DESC';

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

        $query = $this->db2->query("SELECT a.iitemid, a.vitemtype, a.vitemname, a.vbarcode, a.vcategorycode, a.vdepcode, a.vsuppliercode, a.iqtyonhand, a.vtax1, a.vtax2, a.dcostprice, a.dunitprice, a.visinventory, a.isparentchild, a.LastUpdate, mc.vcategoryname, md.vdepartmentname, ms.vcompanyname , CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a LEFT JOIN mst_category mc ON(mc.vcategorycode=a.vcategorycode) LEFT JOIN mst_department md ON(md.vdepcode=a.vdepcode) LEFT JOIN mst_supplier ms ON(ms.vsuppliercode=a.vsuppliercode) $sql_string");  

        return $query->rows;
    }

    public function editlistItems($data = array()) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

              try {
                    if(count($data['item_ids']) > 0){
                        foreach($data['item_ids'] as $value){
                            $current_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value ."'")->row;

                            $sql = "";
                            $sql .= "UPDATE mst_item SET";

                            if($data['update_vcategorycode'] != 'no-update'){
                                $sql .= " vcategorycode='" . $this->db->escape($data['update_vcategorycode']) . "',";
                            }

                            if($data['update_vdepcode'] != 'no-update'){
                                $sql .= " vdepcode='" . $this->db->escape($data['update_vdepcode']) . "',";
                            }

                            if($data['update_vsuppliercode'] != 'no-update'){
                                $sql .= " vsuppliercode='" . $this->db->escape($data['update_vsuppliercode']) . "',";
                            }

                            if($data['update_vfooditem'] != 'no-update'){
                                $sql .= " vfooditem='" . $this->db->escape($data['update_vfooditem']) . "',";
                            }

                            if($data['update_vtax1'] != 'no-update'){
                                $sql .= " vtax1='" . $this->db->escape($data['update_vtax1']) . "',";
                            }

                            if($data['update_vtax2'] != 'no-update'){
                                $sql .= " vtax2='" . $this->db->escape($data['update_vtax2']) . "',";
                            }

                            if(isset($data['update_dunitprice_checkbox']) && $data['update_dunitprice_checkbox'] == 'Y' && $data['update_dunitprice'] != ''){
                                $sql .= " dunitprice='" . $this->db->escape($data['update_dunitprice']) . "',";
                            }

                            if(isset($data['update_npack_checkbox']) && $data['update_npack_checkbox'] == 'Y' && $data['update_npack'] != ''){
                                $sql .= " npack='" . $this->db->escape($data['update_npack']) . "',";
                                $current_npack = $data['update_npack'];
                            }else{
                                $current_npack = $current_item['npack'];
                            }

                            if(isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y' && $data['update_dcostprice'] != ''){
                                $sql .= " dcostprice='" . $this->db->escape($data['update_dcostprice']) . "',";
                                $current_dcostprice = $data['update_dcostprice'];
                            }else{
                                $current_dcostprice = $current_item['dcostprice'];
                            }

                            if((isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y') || (isset($data['update_npack_checkbox']) && $data['update_npack_checkbox'] == 'Y')){
                                $current_nunitcost = $current_dcostprice /  $current_npack;
                                $sql .= " nunitcost='" . $current_nunitcost . "',";
                            }

                            if($data['update_visinventory'] != 'no-update'){
                                $sql .= " visinventory='" . $this->db->escape($data['update_visinventory']) . "',";
                            }

                            $sql = rtrim($sql,',');
                            $sql .= " WHERE iitemid = '" . (int)$value . "'";

                            $this->db2->query($sql);

                            // update child values
                            if((isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y') || (isset($data['update_npack_checkbox']) && $data['update_npack_checkbox'] == 'Y') || (isset($data['update_dunitprice_checkbox']) && $data['update_dunitprice_checkbox'] == 'Y')){
                                // update child values
                                $isParentCheck = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value ."'")->row;

                                if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                                    $child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$value ."' ")->rows;

                                    if(count($child_items) > 0){
                                        foreach($child_items as $chi_item){
                                            $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                                '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");
                                        }
                                    }
                                }

                                //update item pack details
                                if($this->db->escape($isParentCheck['vitemtype']) == 'Lot Matrix'){
                            
                                    if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                                        $lot_child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$value ."' ")->rows;

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

        $success['success'] = 'Successfully Updated Item';
        return $success;
    }
}
?>