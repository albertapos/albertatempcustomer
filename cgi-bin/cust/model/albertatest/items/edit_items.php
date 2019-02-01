<?php
class ModelAlbertatestItemsEditItems extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT a.iitemid as iitemid FROM mst_item as a";
        
        // if (!empty($data['searchbox'])) {
        //     $sql .= " WHERE iitemid= ". $this->db->escape($data['searchbox']);
        // }

        if (!empty($data['search_radio'])) {
            
            if(!empty($data['search_find']) && $data['search_radio'] == 'category'){
                $sql .= " WHERE a.estatus='Active' AND a.vcategorycode= ". $this->db->escape($data['search_find']);
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'department'){
                $sql .= " WHERE a.estatus='Active' AND a.vdepcode= ". $this->db->escape($data['search_find']);
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'supplier'){
                $sql .= " WHERE a.estatus='Active' AND a.vsuppliercode= ". $this->db->escape($data['search_find']);
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'food_stamp'){
                 $search_find_str = "'".$data['search_find']."'";
                $sql .= " WHERE a.estatus='Active' AND a.vfooditem= ". $search_find_str;
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'search'){
                $sql .= " WHERE a.estatus='Active' AND (a.vitemname LIKE  '%" .$this->db->escape($data['search_find']). "%' OR  a.vbarcode LIKE  '%" .$this->db->escape($data['search_find']). "%')";
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'item_group'){
                $sql.=", itemgroupdetail as b";
                $sql .= " WHERE a.estatus='Active' AND b.iitemgroupid= ". $this->db->escape($data['search_find'])." AND b.vsku=a.vbarcode";
            }
        }
        
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
        $sql_total_string = '';

        // if (isset($itemdata['searchbox']) && !empty($itemdata['searchbox'])) {
        //     $sql_string .= " WHERE a.iitemid= ". (int)$this->db->escape($itemdata['searchbox']);
        // }

        if (isset($itemdata['search_radio']) && !empty($itemdata['search_radio'])) {
            if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'category'){
                $sql_string .= " WHERE a.estatus='Active' AND a.vcategorycode= ". $this->db->escape($itemdata['search_find']);
                $sql_total_string .= " WHERE a.estatus='Active' AND a.vcategorycode= ". $this->db->escape($itemdata['search_find']);
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'department'){
                $sql_string .= " WHERE a.estatus='Active' AND a.vdepcode= ". $this->db->escape($itemdata['search_find']);
                $sql_total_string .= " WHERE a.estatus='Active' AND a.vdepcode= ". $this->db->escape($itemdata['search_find']);
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'supplier'){
                $sql_string .= " WHERE a.estatus='Active' AND a.vsuppliercode= ". $this->db->escape($itemdata['search_find']);
                $sql_total_string .= " WHERE a.estatus='Active' AND a.vsuppliercode= ". $this->db->escape($itemdata['search_find']);
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'food_stamp'){
                $search_find_str = "'".$itemdata['search_find']."'";
                $sql_string .= " WHERE a.estatus='Active' AND a.vfooditem= ". $search_find_str;
                $sql_total_string .= " WHERE a.estatus='Active' AND a.vfooditem= ". $search_find_str;
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'search'){
                $sql_string .= " WHERE a.estatus='Active' AND (a.vitemname LIKE  '%" .$this->db->escape($itemdata['search_find']). "%' OR  a.vbarcode LIKE  '%" .$this->db->escape($itemdata['search_find']). "%')";
                $sql_total_string .= " WHERE a.estatus='Active' AND (a.vitemname LIKE  '%" .$this->db->escape($itemdata['search_find']). "%' OR  a.vbarcode LIKE  '%" .$this->db->escape($itemdata['search_find']). "%')";
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'item_group'){
                $sql_string.=", itemgroupdetail as b";
                $sql_total_string.=", itemgroupdetail as b";
                $sql_string .= " WHERE a.estatus='Active' AND b.iitemgroupid= ". $this->db->escape($itemdata['search_find'])." AND b.vsku=a.vbarcode";
                $sql_total_string .= " WHERE a.estatus='Active' AND b.iitemgroupid= ". $this->db->escape($itemdata['search_find'])." AND b.vsku=a.vbarcode";
            }

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
            $sql_total_string .= ' WHERE a.estatus="Active" ORDER BY a.LastUpdate DESC';

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

        $query = $this->db2->query("SELECT a.iitemid, a.vitemtype, a.vitemname, a.vbarcode, a.vcategorycode, a.vdepcode, a.vsuppliercode, a.iqtyonhand, a.vtax1, a.vtax2, a.dcostprice, a.dunitprice, a.visinventory, a.isparentchild, mc.vcategoryname, md.vdepartmentname, ms.vcompanyname , CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a LEFT JOIN mst_category mc ON(mc.vcategorycode=a.vcategorycode) LEFT JOIN mst_department md ON(md.vdepcode=a.vdepcode) LEFT JOIN mst_supplier ms ON(ms.vsuppliercode=a.vsuppliercode) $sql_string ");

        $query_total = $this->db2->query("SELECT a.iitemid FROM mst_item as a $sql_total_string ");

        $return = array();
        $return['items'] = $query->rows;
        $return['items_total_ids'] = $query_total->rows;

        return $return;
    }

    public function editlistItems($data = array()) {
        
        $success =array();
        $error =array();
       
        if(isset($data) && count($data) > 0){

              try {
                    if(count($data['item_ids']) > 0){

                        foreach($data['item_ids'] as $value){
                            $updated_column = array();

                            $current_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value ."'")->row;

                            $sql = "";
                            $sql .= "UPDATE mst_item SET";

                            if($data['update_vitemtype'] != 'no-update'){
                                $sql .= " vitemtype='" . $this->db->escape($data['update_vitemtype']) . "',";
                                $updated_column[] = 'vitemtype';
                            }

                            if($data['update_vcategorycode'] != 'no-update'){
                                $sql .= " vcategorycode='" . $this->db->escape($data['update_vcategorycode']) . "',";
                                $updated_column[] = 'vcategorycode';
                            }

                            if($data['update_vunitcode'] != 'no-update'){
                                $sql .= " vunitcode='" . $this->db->escape($data['update_vunitcode']) . "',";
                                $updated_column[] = 'vunitcode';
                            }

                            if($data['update_vsize'] != 'no-update'){
                                $sql .= " vsize='" . $this->db->escape($data['update_vsize']) . "',";
                                $updated_column[] = 'vsize';
                            }

                            if($data['update_vdepcode'] != 'no-update'){
                                $sql .= " vdepcode='" . $this->db->escape($data['update_vdepcode']) . "',";
                                $updated_column[] = 'vdepcode';
                            }

                            if($data['update_vsuppliercode'] != 'no-update'){
                                $sql .= " vsuppliercode='" . $this->db->escape($data['update_vsuppliercode']) . "',";
                                $updated_column[] = 'vsuppliercode';
                            }

                            if($data['update_vfooditem'] != 'no-update'){
                                $sql .= " vfooditem='" . $this->db->escape($data['update_vfooditem']) . "',";
                                $updated_column[] = 'vfooditem';
                            }

                            if($data['update_vtax1'] != 'no-update'){
                                $sql .= " vtax1='" . $this->db->escape($data['update_vtax1']) . "',";
                                $updated_column[] = 'vtax1';
                            }

                            if($data['update_vtax2'] != 'no-update'){
                                $sql .= " vtax2='" . $this->db->escape($data['update_vtax2']) . "',";
                                $updated_column[] = 'vtax2';
                            }

                            if($data['update_aisleid'] != 'no-update'){
                                $sql .= " aisleid='" . $this->db->escape($data['update_aisleid']) . "',";
                                $updated_column[] = 'aisleid';
                            }

                            if($data['update_shelfid'] != 'no-update'){
                                $sql .= " shelfid='" . $this->db->escape($data['update_shelfid']) . "',";
                                $updated_column[] = 'shelfid';
                            }

                            if($data['update_shelvingid'] != 'no-update'){
                                $sql .= " shelvingid='" . $this->db->escape($data['update_shelvingid']) . "',";
                                $updated_column[] = 'shelvingid';
                            }

                            // if(isset($data['update_dunitprice_checkbox']) && $data['update_dunitprice_checkbox'] == 'Y'){
                            //     $sql .= " dunitprice='0',";
                            //     $updated_column[] = 'dunitprice';
                            // }elseif(isset($data['update_dunitprice']) && $data['update_dunitprice'] != '' && $data['update_dunitprice'] != '0'){
                            //     $sql .= " dunitprice='" . $this->db->escape($data['update_dunitprice']) . "',";
                            //     $updated_column[] = 'dunitprice';
                            // }

                            if(isset($data['update_dunitprice_checkbox']) && $data['update_dunitprice_checkbox'] == 'Y'){
                                $sql .= " dunitprice='0',";
                                $new_dunitprice=0;
                                $updated_column[] = 'dunitprice';
                            }else if(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && !isset($data['update_dunitprice_increment']) && !isset($data['update_dunitprice_increment_percent'])){
                                $sql .= " dunitprice='" . $this->db->escape($data['update_dunitprice']) . "',";
                                $updated_column[] = 'dunitprice';
                                $new_dunitprice=$data['update_dunitprice'];
                            }elseif(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && isset($data['update_dunitprice_increment']) && $data['update_dunitprice_increment'] == 'Y' && !isset($data['update_dunitprice_increment_percent'])){
                                $new_dunitprice = $current_item['dunitprice'] + $this->db->escape($data['update_dunitprice']);
                                $sql .= " dunitprice='" . $new_dunitprice . "',";
                                $updated_column[] = 'dunitprice';
                            }elseif(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && !isset($data['update_dunitprice_increment']) && isset($data['update_dunitprice_increment_percent']) && $data['update_dunitprice_increment_percent'] == 'Y'){

                                $new_dunitprice = (($current_item['dunitprice'] * $this->db->escape($data['update_dunitprice'])) / 100) + ($current_item['dunitprice']);
                                $sql .= " dunitprice='" . $new_dunitprice . "',";
                                $updated_column[] = 'dunitprice';

                            }else{
                                $new_dunitprice= $current_item['dunitprice'];
                            }

                            if(isset($data['update_npack_checkbox']) && $data['update_npack_checkbox'] == 'Y'){
                                $sql .= " npack='1',";
                                $current_npack = 1;
                                $updated_column[] = 'npack';
                            }elseif(isset($data['update_npack']) && $data['update_npack'] != '' && $data['update_npack'] != '1' && $data['update_npack'] != '0'){
                                $sql .= " npack='" . $this->db->escape($data['update_npack']) . "',";
                                $current_npack = $data['update_npack'];
                                $updated_column[] = 'npack';
                            }else{
                                $current_npack = $current_item['npack'];
                            }

                            if(isset($data['update_nsellunit_checkbox']) && $data['update_nsellunit_checkbox'] == 'Y'){
                                $sql .= " nsellunit='1',";
                                $updated_column[] = 'nsellunit';
                            }elseif(isset($data['update_nsellunit']) && $data['update_nsellunit'] != '' && $data['update_nsellunit'] != '1' && $data['update_nsellunit'] != '0'){
                                $sql .= " nsellunit='" . $this->db->escape($data['update_nsellunit']) . "',";
                                $updated_column[] = 'nsellunit';
                            }

                            // if(isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y'){
                            //     $sql .= " dcostprice='0',";
                            //     $current_dcostprice = 0;
                            //     $updated_column[] = 'dcostprice';
                            // }elseif(isset($data['update_dcostprice']) && $data['update_dcostprice'] != '' && $data['update_dcostprice'] != '0'){
                            //     $sql .= " dcostprice='" . $this->db->escape($data['update_dcostprice']) . "',";
                            //     $current_dcostprice = $data['update_dcostprice'];
                            //     $updated_column[] = 'dcostprice';
                            // }else{
                            //     $current_dcostprice = $current_item['dcostprice'];
                            // }

                            if(isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y' && $current_item['isparentchild'] !=1){
                                $sql .= " dcostprice='0',";
                                $current_dcostprice = 0;
                                $new_dcostprice = 0;
                                $updated_column[] = 'dcostprice';
                            }else if(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && !isset($data['update_dcostprice_increment']) && !isset($data['update_dcostprice_increment_percent']) && $current_item['isparentchild'] !=1){
                                $sql .= " dcostprice='" . $this->db->escape($data['update_dcostprice']) . "',";
                                $current_dcostprice = $data['update_dcostprice'];
                                $new_dcostprice = $data['update_dcostprice'];
                                $updated_column[] = 'dcostprice';
                            }elseif(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && isset($data['update_dcostprice_increment']) && $data['update_dcostprice_increment'] == 'Y' && !isset($data['update_dcostprice_increment_percent']) && $current_item['isparentchild'] !=1){
                                $new_dcostprice = $current_item['dcostprice'] + $this->db->escape($data['update_dcostprice']);
                                $sql .= " dcostprice='" . $new_dcostprice . "',";
                                $current_dcostprice = $new_dcostprice;
                                $updated_column[] = 'dcostprice';
                            }elseif(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && !isset($data['update_dcostprice_increment']) && isset($data['update_dcostprice_increment_percent']) && $data['update_dcostprice_increment_percent'] == 'Y' && $current_item['isparentchild'] !=1){

                                $new_dcostprice = (($current_item['dcostprice'] * $this->db->escape($data['update_dcostprice'])) / 100) + ($current_item['dcostprice']);
                                $sql .= " dcostprice='" . $new_dcostprice . "',";
                                $current_dcostprice = $new_dcostprice;
                                $updated_column[] = 'dcostprice';

                            }else{
                                $new_dcostprice = $current_item['dcostprice'];
                                $current_dcostprice = $current_item['dcostprice'];
                            }

                            $current_nunitcost = $current_dcostprice /  $current_npack;
                            $sql .= " nunitcost='" . $current_nunitcost . "',";

                            if($data['update_visinventory'] != 'no-update'){
                                $sql .= " visinventory='" . $this->db->escape($data['update_visinventory']) . "',";
                                $updated_column[] = 'visinventory';
                            }

                            if($data['update_ndiscountper'] != ''){
                                $sql .= " ndiscountper='" . $this->db->escape($data['update_ndiscountper']) . "',";
                                $updated_column[] = 'ndiscountper';
                            }

                            if($data['update_nlevel2'] != ''){
                                $sql .= " nlevel2='" . $this->db->escape($data['update_nlevel2']) . "',";
                                $updated_column[] = 'nlevel2';
                            }

                            if($data['update_nlevel3'] != ''){
                                $sql .= " nlevel3='" . $this->db->escape($data['update_nlevel3']) . "',";
                                $updated_column[] = 'nlevel3';
                            }

                            if($data['update_nlevel4'] != ''){
                                $sql .= " nlevel4='" . $this->db->escape($data['update_nlevel4']) . "',";
                                $updated_column[] = 'nlevel4';
                            }

                            if($data['update_wicitem'] != 'no-update'){
                                $sql .= " wicitem='" . $this->db->escape($data['update_wicitem']) . "',";
                                $updated_column[] = 'wicitem';
                            }

                            if($data['update_stationid'] != 'no-update'){
                                $sql .= " stationid='" . $this->db->escape($data['update_stationid']) . "',";
                                $updated_column[] = 'stationid';
                            }

                            if($data['update_vbarcodetype'] != 'no-update'){
                                $sql .= " vbarcodetype='" . $this->db->escape($data['update_vbarcodetype']) . "',";
                                $updated_column[] = 'vbarcodetype';
                            }

                            if($data['update_vdiscount'] != 'no-update'){
                                $sql .= " vdiscount='" . $this->db->escape($data['update_vdiscount']) . "',";
                                $updated_column[] = 'vdiscount';
                            }

                            if($data['update_liability'] != 'no-update'){
                                $sql .= " liability='" . $this->db->escape($data['update_liability']) . "',";
                                $updated_column[] = 'liability';
                            }

                            if($data['update_ireorderpoint'] != ''){
                                $sql .= " ireorderpoint='" . $this->db->escape($data['update_ireorderpoint']) . "',";
                                $updated_column[] = 'ireorderpoint';
                            }

                            if($data['update_norderqtyupto'] != ''){
                                $sql .= " norderqtyupto='" . $this->db->escape($data['update_norderqtyupto']) . "',";
                                $updated_column[] = 'norderqtyupto';
                            }

                            if($data['update_vintage'] != ''){
                                $sql .= " vintage='" . $this->db->escape($data['update_vintage']) . "',";
                                $updated_column[] = 'vintage';
                            }

                            if($data['update_vshowsalesinzreport'] != 'no-update'){
                                $sql .= " vshowsalesinzreport='" . $this->db->escape($data['update_vshowsalesinzreport']) . "',";
                                $updated_column[] = 'vshowsalesinzreport';
                            }

                            if($data['update_visinventory'] != 'no-update'){
                                $sql .= " visinventory='" . $this->db->escape($data['update_visinventory']) . "',";
                                $updated_column[] = 'visinventory';
                            }

                            if($data['update_vageverify'] != 'no-update'){
                                $sql .= " vageverify='" . $this->db->escape($data['update_vageverify']) . "',";
                                $updated_column[] = 'vageverify';
                            }

                            if($data['update_nbottledepositamt'] != ''){
                                if($data['update_nbottledepositamt'] == '0.00' || $data['update_nbottledepositamt'] == '0' || $data['update_nbottledepositamt'] == '0.0' ){
                                    $sql .= " ebottledeposit='No',";
                                    $sql .= " nbottledepositamt='0.00',";
                                $updated_column[] = 'ebottledeposit';
                                $updated_column[] = 'nbottledepositamt';
                                }else{
                                    $sql .= " ebottledeposit='Yes',";
                                    $sql .= " nbottledepositamt='". $this->db->escape($data['update_nbottledepositamt']) ."',";
                                    $updated_column[] = 'ebottledeposit';
                                    $updated_column[] = 'nbottledepositamt';
                                }
                            }

                            if($data['update_rating'] != ''){
                                $sql .= " rating='" . $this->db->escape($data['update_rating']) . "',";
                                $updated_column[] = 'rating';
                            }

                            if($data['update_estatus'] != 'no-update'){
                                $sql .= " estatus='" . $this->db->escape($data['update_estatus']) . "',";
                                $updated_column[] = 'estatus';
                            }

                            $sql = rtrim($sql,',');
                            $sql .= " WHERE iitemid = '" . (int)$value . "'";

                            $this->db2->query($sql);

                            //mst plcb item

                            if(isset($data['options_data']) && count($data['options_data']) > 0){

                                $mst_item_size = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id= '". (int)$value ."' ")->row;

                                if(count($mst_item_size) > 0){

                                    $this->db2->query("UPDATE mst_item_size SET  unit_id = '". (int)$data['options_data']['unit_id'] ."',unit_value = '". (int)$data['options_data']['unit_value'] ."' WHERE item_id = '" . (int)$value . "'");

                                }else{
                                    $this->db2->query("INSERT INTO mst_item_size SET  item_id = '". (int)$value ."',unit_id = '". (int)$data['options_data']['unit_id'] ."',unit_value = '". (int)$data['options_data']['unit_value'] ."',SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                $mst_plcb_item = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id= '". (int)$value ."' ")->row;

                                if(count($mst_plcb_item) > 0){
                                    $this->db2->query("UPDATE mst_plcb_item SET  bucket_id = '". (int)$data['options_data']['bucket_id'] ."',malt = '". (int)$data['options_data']['malt'] ."' WHERE item_id = '" . (int)$value . "'");
                                }else{
                                    $this->db2->query("INSERT INTO mst_plcb_item SET  item_id = '". (int)$value ."',bucket_id = '". (int)$data['options_data']['bucket_id'] ."',prev_mo_beg_qty = '". $current_item['iqtyonhand'] ."',prev_mo_end_qty = '". $current_item['iqtyonhand'] ."',malt = '". (int)$data['options_data']['malt'] ."',SID = '" . (int)($this->session->data['sid'])."'");
                                }
                            }else{
                                $checkexist_mst_item_size = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id='" . (int)$value . "'")->row;

                                if(count($checkexist_mst_item_size) > 0){

                                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_item_size',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_item_size['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                                    $this->db2->query("DELETE FROM mst_item_size WHERE id='" . (int)$checkexist_mst_item_size['id'] . "'");

                                }

                                $checkexist_mst_plcb_item = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id='" . (int)$value . "'")->row;

                                if(count($checkexist_mst_plcb_item) > 0){

                                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_plcb_item',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_plcb_item['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                                    $this->db2->query("DELETE FROM mst_plcb_item WHERE id='" . (int)$checkexist_mst_plcb_item['id'] . "'");

                                }
                            }

                            //mst plcb item

                            //trn_itempricecosthistory
                            if($current_item['dunitprice'] != $new_dunitprice){

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $current_item['iitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'EitemPrice', noldamt = '" . $this->db->escape($current_item['dunitprice']) . "', nnewamt = '" . $this->db->escape($new_dunitprice) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                            }

                            if($current_item['dcostprice'] != $new_dcostprice){

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $current_item['iitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'EitemCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_dcostprice) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                            }

                            //trn_itempricecosthistory

                            //trn_webadmin_history
                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                if((($current_item['dunitprice'] != $new_dunitprice) && ($current_item['dunitprice'] != '0.00')) && (($current_item['dcostprice'] != $new_dcostprice) && ($current_item['dcostprice'] != '0.0000'))){
                                    $old_item_values = $current_item;
                                    unset($old_item_values['itemimage']);

                                    $x_general = new stdClass();
                                    $x_general->old_item_values = $old_item_values;
                                    
                                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($current_item['iitemid']) ."' ")->row;
                                    unset($new_item_values['itemimage']);
                                    $x_general->new_item_values = $new_item_values;
                                    $x_general = addslashes(json_encode($x_general));
                                    try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $current_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'All', oldamount = '0', newamount = '0', general = '" . $x_general . "', source = 'EditMultipleItem', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                    }
                                    catch (Exception $e) {
                                        $this->log->write($e);
                                    }
                                }else{
                                    if(($current_item['dunitprice'] != $new_dunitprice) && ($current_item['dunitprice'] != '0.00')){
                                        $old_item_values = $current_item;
                                        unset($old_item_values['itemimage']);

                                        $x_general = new stdClass();
                                        $x_general->old_item_values = $old_item_values;
                                        
                                        $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($current_item['iitemid']) ."' ")->row;
                                        unset($new_item_values['itemimage']);
                                        $x_general->new_item_values = $new_item_values;
                                        $x_general = addslashes(json_encode($x_general));
                                        try{

                                        $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $current_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'Price', oldamount = '" . $current_item['dunitprice'] . "', newamount = '". $new_dunitprice ."', general = '" . $x_general . "', source = 'EditMultipleItem', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                        }
                                        catch (Exception $e) {
                                            $this->log->write($e);
                                        }
                                    }

                                    if(($current_item['dcostprice'] != $new_dcostprice) && ($current_item['dcostprice'] != '0.0000')){
                                        $old_item_values = $current_item;
                                        unset($old_item_values['itemimage']);
                                        $x_general = new stdClass();
                                        $x_general->old_item_values = $old_item_values;
                                        
                                        $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($current_item['iitemid']) ."' ")->row;
                                        unset($new_item_values['itemimage']);
                                        $x_general->new_item_values = $new_item_values;
                                        $x_general = addslashes(json_encode($x_general));
                                        try{

                                        $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $current_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $current_item['dcostprice'] . "', newamount = '". $new_dcostprice ."', general = '" . $x_general . "', source = 'EditMultipleItem', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                        }
                                        catch (Exception $e) {
                                            $this->log->write($e);
                                        }
                                    }
                                }
                            }

                            //trn_webadmin_history

                            // $user_id = $this->session->data['user_id'];
                            // if(count($updated_column) > 0){
                            //     $object = new stdClass();
                            //     foreach ($updated_column as $k => $u_c){
                            //         $object->$k = $u_c;
                            //     }
                            //     $sql_insert = "";
                            //     $sql_insert .= "INSERT INTO last_modified SET user_id='". (int)$user_id ."', table_name='mst_item', updated_column='". json_encode($object) ."', updated_item='". $value ."', SID='". $this->session->data['sid'] ."'";
                            //     $this->db2->query($sql_insert);                               
                            // }
                            
                            // update child values
                            $isParentCheck = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$value ."'")->row;

                            if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                                $child_items = $this->db2->query("SELECT `iitemid`,`vbarcode`,`dcostprice`,`npack` FROM mst_item WHERE parentmasterid= '". (int)$value ."' ")->rows;

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

                                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($chi_item['iitemid']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($chi_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $chi_item['dcostprice'] . "', newamount = '". (($chi_item['npack']) * ($this->db->escape($isParentCheck['nunitcost']))) ."', source = 'EditMultipleItem', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                            }
                                            catch (Exception $e) {
                                                $this->log->write($e);
                                            }
                                            $trn_webadmin_history_last_id_child = $this->db2->getLastId();
                                        }
                                        //trn_webadmin_history

                                        $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                            '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");

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

                            if(isset($data['update_iitemgroupid']) && $data['update_iitemgroupid'] != 'no-update'){
                                $delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($isParentCheck['vbarcode']) . "'")->row;

                                if(count($delete_ids) > 0){
                                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                $this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($isParentCheck['vbarcode']) . "'");

                                $this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($data['update_iitemgroupid']) . "', vsku='". $this->db->escape($isParentCheck['vbarcode']) ."',vtype='Product',SID = '" . (int)($this->session->data['sid']) . "' ");
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

    public function getItemsUnits() {
        $sql="SELECT * FROM mst_item_unit";
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function getBuckets(){

        $sql="SELECT * FROM mst_item_bucket";
        
        $query = $this->db2->query($sql);

        return $query->rows;
    }
}
?>