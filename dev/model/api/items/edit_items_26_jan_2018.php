<?php
class ModelApiItemsEditItems extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT a.iitemid as iitemid FROM mst_item as a";
        
        // if (!empty($data['searchbox'])) {
        //     $sql .= " WHERE iitemid= ". $this->db->escape($data['searchbox']);
        // }

        if (!empty($data['search_radio'])) {
            
            if(!empty($data['search_find']) && $data['search_radio'] == 'category'){
                $sql .= " WHERE a.vcategorycode= ". $this->db->escape($data['search_find']);
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'department'){
                $sql .= " WHERE a.vdepcode= ". $this->db->escape($data['search_find']);
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'food_stamp'){
                 $search_find_str = "'".$data['search_find']."'";
                $sql .= " WHERE a.vfooditem= ". $search_find_str;
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'search'){
                $sql .= " WHERE a.vitemname LIKE  '%" .$this->db->escape($data['search_find']). "%' ";
            }else if(!empty($data['search_find']) && $data['search_radio'] == 'item_group'){
                $sql.=", itemgroupdetail as b";
                $sql .= " WHERE b.iitemgroupid= ". $this->db->escape($data['search_find'])." AND b.vsku=a.vbarcode";
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
                $sql_string .= " WHERE a.vcategorycode= ". $this->db->escape($itemdata['search_find']);
                $sql_total_string .= " WHERE a.vcategorycode= ". $this->db->escape($itemdata['search_find']);
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'department'){
                $sql_string .= " WHERE a.vdepcode= ". $this->db->escape($itemdata['search_find']);
                $sql_total_string .= " WHERE a.vdepcode= ". $this->db->escape($itemdata['search_find']);
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'food_stamp'){
                $search_find_str = "'".$itemdata['search_find']."'";
                $sql_string .= " WHERE a.vfooditem= ". $search_find_str;
                $sql_total_string .= " WHERE a.vfooditem= ". $search_find_str;
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'search'){
                $sql_string .= " WHERE a.vitemname LIKE  '%" .$this->db->escape($itemdata['search_find']). "%' OR  a.vbarcode LIKE  '%" .$this->db->escape($itemdata['search_find']). "%'";
                $sql_total_string .= " WHERE a.vitemname LIKE  '%" .$this->db->escape($itemdata['search_find']). "%' OR  a.vbarcode LIKE  '%" .$this->db->escape($itemdata['search_find']). "%'";
            }else if(!empty($itemdata['search_find']) && $itemdata['search_radio'] == 'item_group'){
                $sql_string.=", itemgroupdetail as b";
                $sql_total_string.=", itemgroupdetail as b";
                $sql_string .= " WHERE b.iitemgroupid= ". $this->db->escape($itemdata['search_find'])." AND b.vsku=a.vbarcode";
                $sql_total_string .= " WHERE b.iitemgroupid= ". $this->db->escape($itemdata['search_find'])." AND b.vsku=a.vbarcode";
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
            $sql_string .= ' ORDER BY a.LastUpdate DESC';
            $sql_total_string .= ' ORDER BY a.LastUpdate DESC';

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

        $query = $this->db2->query("SELECT a.*, CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a $sql_string ");

        $query_total = $this->db2->query("SELECT a.iitemid FROM mst_item as a $sql_total_string ");
                
        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {
                $groupid = $this->db2->query("SELECT * FROM itemgroupdetail WHERE vsku='". $value['vbarcode'] ."'")->row;

                $itemalias = $this->db2->query("SELECT * FROM mst_itemalias WHERE vsku='". $value['vbarcode'] ."'")->rows;

                $itemslabprices = $this->db2->query("SELECT * FROM mst_itemslabprice WHERE vsku='". $value['vbarcode'] ."'")->rows;

                if($value['isparentchild'] == 2){
                    $itemchilditems = $this->db2->query("SELECT `iitemid`,`vitemname`,`npack` FROM mst_item WHERE parentmasterid='". $value['iitemid'] ."'")->rows;
                }else{
                    $itemchilditems = $this->db2->query("SELECT `iitemid`,`vitemname`,`npack` FROM mst_item WHERE parentid='". $value['iitemid'] ."'")->rows;
                }

                $itemparentitems = $this->db2->query("SELECT `iitemid`,`vitemname`,`npack` FROM mst_item WHERE iitemid='". $value['parentid'] ."'")->rows;

                $remove_parent_item = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentid in('". $value['iitemid'] ."') AND isparentchild !=0")->rows;

                $itempacks = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid='". (int)$value['iitemid'] ."' ORDER BY isequence")->rows;

                $itemvendors = $this->db2->query("SELECT * FROM mst_itemvendor as miv,mst_supplier as ms WHERE miv.ivendorid=ms.isupplierid AND  miv.iitemid='". (int)$value['iitemid'] ."'")->rows;

                $temp = array();
                $temp['iitemid'] = $value['iitemid'];
                $temp['iitemgroupid'] = $groupid;
                $temp['itempacks'] = $itempacks;
                $temp['itemalias'] = $itemalias;
                $temp['itemvendors'] = $itemvendors;
                $temp['itemslabprices'] = $itemslabprices;
                $temp['itemchilditems'] = $itemchilditems;
                $temp['itemparentitems'] = $itemparentitems;
                $temp['remove_parent_item'] = $remove_parent_item;
                $temp['webstore'] = $value['webstore'];
                $temp['vitemtype'] = $value['vitemtype'];
                $temp['vitemcode'] = $value['vitemcode'];
                $temp['vitemname'] = $value['vitemname'];
                $temp['VITEMNAME'] = $value['VITEMNAME'];
                $temp['vunitcode'] = $value['vunitcode'];
                $temp['vbarcode'] = $value['vbarcode'];
                $temp['vpricetype'] = $value['vpricetype'];
                $temp['vcategorycode'] = $value['vcategorycode'];
                $temp['vdepcode'] = $value['vdepcode'];
                $temp['vsuppliercode'] = $value['vsuppliercode'];
                $temp['iqtyonhand'] = $value['iqtyonhand'];
                $temp['QOH'] = $value['IQTYONHAND'];
                $temp['ireorderpoint'] = $value['ireorderpoint'];
                $temp['dcostprice'] = $value['dcostprice'];
                $temp['dunitprice'] = $value['dunitprice'];
                $temp['nsaleprice'] = $value['nsaleprice'];
                $temp['nlevel2'] = $value['nlevel2'];
                $temp['nlevel3'] = $value['nlevel3'];
                $temp['nlevel4'] = $value['nlevel4'];
                $temp['iquantity'] = $value['iquantity'];
                $temp['ndiscountper'] = $value['ndiscountper'];
                $temp['ndiscountamt'] = $value['ndiscountamt'];
                $temp['vtax1'] = $value['vtax1'];
                $temp['vtax2'] = $value['vtax2'];
                $temp['vfooditem'] = $value['vfooditem'];
                $temp['vdescription'] = $value['vdescription'];
                $temp['dlastsold'] = $value['dlastsold'];
                $temp['visinventory'] = $value['visinventory'];
                $temp['dpricestartdatetime'] = $value['dpricestartdatetime'];
                $temp['dpriceenddatetime'] = $value['dpriceenddatetime'];
                $temp['estatus'] = $value['estatus'];
                $temp['nbuyqty'] = $value['nbuyqty'];
                $temp['ndiscountqty'] = $value['ndiscountqty'];
                $temp['nsalediscountper'] = $value['nsalediscountper'];
                $temp['vshowimage'] = $value['vshowimage'];
                if(isset($value['vshowimage']) && !empty($value['vshowimage'])){
                    $temp['itemimage'] = $value['itemimage'];
                }else{
                    $temp['itemimage'] = '';
                }
                
                $temp['vageverify'] = $value['vageverify'];
                $temp['ebottledeposit'] = $value['ebottledeposit'];
                $temp['nbottledepositamt'] = $value['nbottledepositamt'];
                $temp['vbarcodetype'] = $value['vbarcodetype'];
                $temp['ntareweight'] = $value['ntareweight'];
                $temp['ntareweightper'] = $value['ntareweightper'];
                $temp['dcreated'] = $value['dcreated'];
                $temp['dlastupdated'] = $value['dlastupdated'];
                $temp['dlastreceived'] = $value['dlastreceived'];
                $temp['dlastordered'] = $value['dlastordered'];
                $temp['nlastcost'] = $value['nlastcost'];
                $temp['nonorderqty'] = $value['nonorderqty'];
                $temp['vparentitem'] = $value['vparentitem'];
                $temp['nchildqty'] = $value['nchildqty'];
                $temp['vsize'] = $value['vsize'];
                $temp['npack'] = $value['npack'];
                $temp['nunitcost'] = $value['nunitcost'];
                $temp['ionupload'] = $value['ionupload'];
                $temp['nsellunit'] = $value['nsellunit'];
                $temp['ilotterystartnum'] = $value['ilotterystartnum'];
                $temp['ilotteryendnum'] = $value['ilotteryendnum'];
                $temp['etransferstatus'] = $value['etransferstatus'];
                $temp['vsequence'] = $value['vsequence'];
                $temp['vcolorcode'] = $value['vcolorcode'];
                $temp['vdiscount'] = $value['vdiscount'];
                $temp['norderqtyupto'] = $value['norderqtyupto'];
                $temp['vshowsalesinzreport'] = $value['vshowsalesinzreport'];
                $temp['iinvtdefaultunit'] = $value['iinvtdefaultunit'];
                $temp['LastUpdate'] = $value['LastUpdate'];
                $temp['SID'] = $value['SID'];
                $temp['stationid'] = $value['stationid'];
                $temp['shelfid'] = $value['shelfid'];
                $temp['aisleid'] = $value['aisleid'];
                $temp['shelvingid'] = $value['shelvingid'];
                $temp['rating'] = $value['rating'];
                $temp['vintage'] = $value['vintage'];
                $temp['PrinterStationId'] = $value['PrinterStationId'];
                $temp['liability'] = $value['liability'];
                $temp['isparentchild'] = $value['isparentchild'];
                $temp['parentid'] = $value['parentid'];
                $temp['parentmasterid'] = $value['parentmasterid'];
                $temp['wicitem'] = $value['wicitem'];
                
                $datas[] = $temp;
            }
        }

        $return = array();
        $return['items'] = $datas;
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
                                $updated_column[] = 'dunitprice';
                            }else if(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && !isset($data['update_dunitprice_increment']) && !isset($data['update_dunitprice_increment_percent'])){
                                $sql .= " dunitprice='" . $this->db->escape($data['update_dunitprice']) . "',";
                                $updated_column[] = 'dunitprice';
                            }elseif(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && isset($data['update_dunitprice_increment']) && $data['update_dunitprice_increment'] == 'Y' && !isset($data['update_dunitprice_increment_percent'])){
                                $new_dunitprice = $current_item['dunitprice'] + $this->db->escape($data['update_dunitprice']);
                                $sql .= " dunitprice='" . $new_dunitprice . "',";
                                $updated_column[] = 'dunitprice';
                            }elseif(isset($data['update_dunitprice_select']) && $data['update_dunitprice_select'] == 'set as price' && $data['update_dunitprice'] != '0' && !isset($data['update_dunitprice_checkbox']) && !isset($data['update_dunitprice_increment']) && isset($data['update_dunitprice_increment_percent']) && $data['update_dunitprice_increment_percent'] == 'Y'){

                                $new_dunitprice = (($current_item['dunitprice'] * $this->db->escape($data['update_dunitprice'])) / 100) + ($current_item['dunitprice']);
                                $sql .= " dunitprice='" . $new_dunitprice . "',";
                                $updated_column[] = 'dunitprice';

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

                            if(isset($data['update_dcostprice_checkbox']) && $data['update_dcostprice_checkbox'] == 'Y'){
                                $sql .= " dcostprice='0',";
                                $current_dcostprice = 0;
                                $updated_column[] = 'dcostprice';
                            }else if(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && !isset($data['update_dcostprice_increment']) && !isset($data['update_dcostprice_increment_percent'])){
                                $sql .= " dcostprice='" . $this->db->escape($data['update_dcostprice']) . "',";
                                $current_dcostprice = $data['update_dcostprice'];
                                $updated_column[] = 'dcostprice';
                            }elseif(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && isset($data['update_dcostprice_increment']) && $data['update_dcostprice_increment'] == 'Y' && !isset($data['update_dcostprice_increment_percent'])){
                                $new_dcostprice = $current_item['dcostprice'] + $this->db->escape($data['update_dcostprice']);
                                $sql .= " dcostprice='" . $new_dcostprice . "',";
                                $current_dcostprice = $new_dcostprice;
                                $updated_column[] = 'dcostprice';
                            }elseif(isset($data['update_dcostprice_select']) && $data['update_dcostprice_select'] == 'set as cost' && $data['update_dcostprice'] != '0' && !isset($data['update_dcostprice_checkbox']) && !isset($data['update_dcostprice_increment']) && isset($data['update_dcostprice_increment_percent']) && $data['update_dcostprice_increment_percent'] == 'Y'){

                                $new_dcostprice = (($current_item['dcostprice'] * $this->db->escape($data['update_dcostprice'])) / 100) + ($current_item['dcostprice']);
                                $sql .= " dcostprice='" . $new_dcostprice . "',";
                                $current_dcostprice = $new_dcostprice;
                                $updated_column[] = 'dcostprice';

                            }else{
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

                            $sql = rtrim($sql,',');
                            $sql .= " WHERE iitemid = '" . (int)$value . "'";

                            $this->db2->query($sql);

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
                                $child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$value ."' ")->rows;

                                if(count($child_items) > 0){
                                    foreach($child_items as $chi_item){
                                        $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                            '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");
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
}
?>