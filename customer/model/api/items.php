<?php
class ModelApiItems extends Model {
    public function getTotalItems($data = array()) {
        $sql="SELECT COUNT(*) AS total FROM mst_item ";
        
        if (!empty($data['searchbox'])) {
            $sql .= " WHERE iitemid= ". $this->db->escape($data['searchbox']);
        }else{
            $sql .= " WHERE estatus= '". $this->db->escape($data['show_items'])."'";
        }

        $query = $this->db2->query($sql);

        return $query->row['total'];
    }

    public function getItems($itemdata = array()) {
        $datas = array();
        $sql_string = '';

        if (isset($itemdata['searchbox']) && !empty($itemdata['searchbox'])) {
            $sql_string .= " WHERE a.iitemid= ". (int)$this->db->escape($itemdata['searchbox']);
        }else{
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

        $query = $this->db2->query("SELECT a.*, CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a $sql_string ");
        
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

        return $datas;
    }

    public function getItem($iitemid) {
        $datas = array();

        $query = $this->db2->query("SELECT a.*, CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND FROM mst_item as a where iitemid='". (int)$iitemid ."'");

        if(count($query->row) > 0){
            $value = $query->row;
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
            
                
                
                $get_purchase_details = $this->db2->query("SELECT nunitcost FROM trn_purchaseorderdetail WHERE vitemid='". (int)$value['iitemid'] ."' ORDER BY LastUpdate DESC LIMIT 2")->rows;
                
                if(count($get_purchase_details) == 2){
                    $nunitcost = $get_purchase_details[1]['nunitcost'];
                } else {
                    $nunitcost = $get_purchase_details[0]['nunitcost'];
                }
                //print_r($get_purchase_details);
                //exit;
                
                
                $datas['iitemid'] = $value['iitemid'];
                $datas['itempacks'] = $itempacks;
                $datas['iitemgroupid'] = $groupid;
                $datas['itemalias'] = $itemalias;
                $datas['itemvendors'] = $itemvendors;
                $datas['itemslabprices'] = $itemslabprices;
                $datas['itemchilditems'] = $itemchilditems;
                $datas['itemparentitems'] = $itemparentitems;
                $datas['remove_parent_item'] = $remove_parent_item;
                $datas['webstore'] = $value['webstore'];
                $datas['vitemtype'] = $value['vitemtype'];
                $datas['vitemcode'] = $value['vitemcode'];
                $datas['vitemname'] = $value['vitemname'];
                $datas['vunitcode'] = $value['vunitcode'];
                $datas['vbarcode'] = $value['vbarcode'];
                $datas['vpricetype'] = $value['vpricetype'];
                $datas['vcategorycode'] = $value['vcategorycode'];
                $datas['vdepcode'] = $value['vdepcode'];
                $datas['vsuppliercode'] = $value['vsuppliercode'];
                $datas['iqtyonhand'] = $value['iqtyonhand'];
                $datas['QOH'] = $value['IQTYONHAND'];
                $datas['ireorderpoint'] = $value['ireorderpoint'];
                $datas['dcostprice'] = $value['dcostprice'];
                $datas['dunitprice'] = $value['dunitprice'];
                $datas['nsaleprice'] = $value['nsaleprice'];
                $datas['nlevel2'] = $value['nlevel2'];
                $datas['nlevel3'] = $value['nlevel3'];
                $datas['nlevel4'] = $value['nlevel4'];
                $datas['iquantity'] = $value['iquantity'];
                $datas['ndiscountper'] = $value['ndiscountper'];
                $datas['ndiscountamt'] = $value['ndiscountamt'];
                $datas['vtax1'] = $value['vtax1'];
                $datas['vtax2'] = $value['vtax2'];
                $datas['vfooditem'] = $value['vfooditem'];
                $datas['vdescription'] = $value['vdescription'];
                $datas['dlastsold'] = $value['dlastsold'];
                $datas['visinventory'] = $value['visinventory'];
                $datas['dpricestartdatetime'] = $value['dpricestartdatetime'];
                $datas['dpriceenddatetime'] = $value['dpriceenddatetime'];
                $datas['estatus'] = $value['estatus'];
                $datas['nbuyqty'] = $value['nbuyqty'];
                $datas['ndiscountqty'] = $value['ndiscountqty'];
                $datas['nsalediscountper'] = $value['nsalediscountper'];
                $datas['vshowimage'] = $value['vshowimage'];
                if(isset($value['vshowimage']) && !empty($value['vshowimage'])){
                    $datas['itemimage'] = $value['itemimage'];
                }else{
                    $datas['itemimage'] = '';
                }
                
                $datas['vageverify'] = $value['vageverify'];
                $datas['ebottledeposit'] = $value['ebottledeposit'];
                $datas['nbottledepositamt'] = $value['nbottledepositamt'];
                $datas['vbarcodetype'] = $value['vbarcodetype'];
                $datas['ntareweight'] = $value['ntareweight'];
                $datas['ntareweightper'] = $value['ntareweightper'];
                $datas['dcreated'] = $value['dcreated'];
                $datas['dlastupdated'] = $value['dlastupdated'];
                $datas['dlastreceived'] = $value['dlastreceived'];
                $datas['dlastordered'] = $value['dlastordered'];
                $datas['nlastcost'] = $value['nlastcost'];
                $datas['nonorderqty'] = $value['nonorderqty'];
                $datas['vparentitem'] = $value['vparentitem'];
                $datas['nchildqty'] = $value['nchildqty'];
                $datas['vsize'] = $value['vsize'];
                $datas['npack'] = $value['npack'];
                $datas['nunitcost'] = $value['nunitcost'];
                $datas['ionupload'] = $value['ionupload'];
                $datas['nsellunit'] = $value['nsellunit'];
                $datas['ilotterystartnum'] = $value['ilotterystartnum'];
                $datas['ilotteryendnum'] = $value['ilotteryendnum'];
                $datas['etransferstatus'] = $value['etransferstatus'];
                $datas['vsequence'] = $value['vsequence'];
                $datas['vcolorcode'] = $value['vcolorcode'];
                $datas['vdiscount'] = $value['vdiscount'];
                $datas['norderqtyupto'] = $value['norderqtyupto'];
                $datas['vshowsalesinzreport'] = $value['vshowsalesinzreport'];
                $datas['iinvtdefaultunit'] = $value['iinvtdefaultunit'];
                $datas['LastUpdate'] = $value['LastUpdate'];
                $datas['SID'] = $value['SID'];
                $datas['stationid'] = $value['stationid'];
                $datas['shelfid'] = $value['shelfid'];
                $datas['aisleid'] = $value['aisleid'];
                $datas['shelvingid'] = $value['shelvingid'];
                $datas['rating'] = $value['rating'];
                $datas['vintage'] = $value['vintage'];
                $datas['PrinterStationId'] = $value['PrinterStationId'];
                $datas['liability'] = $value['liability'];
                $datas['isparentchild'] = $value['isparentchild'];
                $datas['parentid'] = $value['parentid'];
                $datas['parentmasterid'] = $value['parentmasterid'];
                $datas['wicitem'] = $value['wicitem'];
                
                $datas['last_costprice'] = $value['last_costprice'];
                $datas['new_costprice'] = $value['new_costprice'];
            
        }  

        return $datas;
    }

    public function getItemsSearch($search) {

        $datas = array();

        $query = $this->db2->query("SELECT * FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($search). "%' OR vbarcode LIKE  '%" .$this->db->escape($search). "%'");

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
                $temp['vunitcode'] = $value['vunitcode'];
                $temp['vbarcode'] = $value['vbarcode'];
                $temp['vpricetype'] = $value['vpricetype'];
                $temp['vcategorycode'] = $value['vcategorycode'];
                $temp['vdepcode'] = $value['vdepcode'];
                $temp['vsuppliercode'] = $value['vsuppliercode'];
                $temp['iqtyonhand'] = $value['iqtyonhand'];
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

        return $datas;
    }

    public function getChildProductsLoad() {
        $query = $this->db2->query("SELECT `iitemid`, `vitemname` FROM mst_item WHERE NOT isparentchild= 1")->rows;
        return $query;
    }

    public function getSKU($vbarcode) {
        $query = $this->db2->query("SELECT * FROM mst_itemalias WHERE valiassku= '". $vbarcode ."'")->row;

        if(count($query) == 0){
            $query = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode= '". $vbarcode ."'")->row;
        }

        return $query;
    }

    public function getItemAllData($vbarcode,$vunitcode,$vsuppliercode,$vdepcode,$vcategorycode) {
        $query = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode= '". $vbarcode ."' AND vunitcode='". $vunitcode ."' AND vsuppliercode='". $vsuppliercode ."' AND vdepcode='". $vdepcode ."' AND vcategorycode='". $vcategorycode ."'")->row;
        return $query;
    }

    public function addUpdateItemVendor($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

               try {
                    $itemvendor_exist = $this->db2->query("SELECT * FROM mst_itemvendor WHERE iitemid= '". (int)$this->db->escape($data['iitemid']) ."' AND ivendorid='". (int)$this->db->escape($data['ivendorid']) ."' AND Id='". (int)$this->db->escape($data['Id']) ."'")->row;

                    if(count($itemvendor_exist) > 0){
                        $this->db2->query("UPDATE mst_itemvendor SET  `vvendoritemcode` = '" . $this->db->escape($data['vvendoritemcode']) . "' WHERE iitemid= '". (int)$this->db->escape($data['iitemid']) ."' AND ivendorid='". (int)$this->db->escape($data['ivendorid']) ."' AND Id='". (int)$this->db->escape($data['Id']) ."'");
                        $success['success'] = 'Successfully Updated Item Vendor';
                    }else{
                        $this->db2->query("INSERT INTO mst_itemvendor SET  iitemid = '" . (int)$this->db->escape($data['iitemid']) . "',`ivendorid` = '" . (int)$this->db->escape($data['ivendorid']) . "',`vvendoritemcode` = '" . $this->db->escape($data['vvendoritemcode']) . "', SID = '" . (int)($this->session->data['sid']) . "'");
                        $success['success'] = 'Successfully Added Item Vendor';
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

        return $success;
    }

    public function addItemAliasCode($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            $item_sku = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode= '". $this->db->escape($data['valiassku']) ."' ")->row;

            if(count($item_sku) > 0){
                $error['error'] = 'Alias Code Already Exist';
                return $error;
            }else{
                $item_valiassku = $this->db2->query("SELECT * FROM mst_itemalias WHERE valiassku= '". $this->db->escape($data['valiassku']) ."' ")->row;
                
                if(count($item_valiassku) > 0){
                    $error['error'] = 'Alias Code Already Exist';
                    return $error;
                }else{
                    try {
                        $this->db2->query("INSERT INTO mst_itemalias SET  vitemcode = '" . $this->db->escape($data['vitemcode']) . "',`vsku` = '" . $this->db->escape($data['vsku']) . "',`valiassku` = '" . $this->db->escape($data['valiassku']) . "', SID = '" . (int)($this->session->data['sid']) . "'");

                            $success['success'] = 'Successfully Added Alias Code';
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

        return $success;
    }

    public function deleteItemAliasCode($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            foreach($data as $value){
                try {
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_itemalias',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $this->db2->query("DELETE FROM mst_itemalias WHERE iitemaliasid='" . (int)$value . "'");
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
        $success['success'] = 'Successfully Deleted Alias Code';
        return $success;
    }

    public function deleteItemLotmatrix($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            foreach($data as $value){
                try {
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_itempackdetail',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $this->db2->query("DELETE FROM mst_itempackdetail WHERE idetid='" . (int)$value . "'");
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
        $success['success'] = 'Successfully Deleted Lot Item';
        return $success;
    }

    public function addItemLotMatrix($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            try {
                $this->db2->query("INSERT INTO mst_itempackdetail SET  iitemid = '" . (int)$this->db->escape($data['iitemid']) . "',`vbarcode` = '" . $this->db->escape($data['vbarcode']) . "',`vpackname` = '" . $this->db->escape($data['vpackname']) . "',`vdesc` = '" . $this->db->escape($data['vdesc']) . "',`ipack` = '" . (int)$this->db->escape($data['ipack']) . "',`npackcost` = '" . $this->db->escape($data['npackcost']) . "',`npackprice` = '" . $this->db->escape($data['npackprice']) . "',`isequence` = '" . (int)$this->db->escape($data['isequence']) . "',`npackmargin` = '" . $this->db->escape($data['npackmargin']) . "', SID = '" . (int)($this->session->data['sid']) . "'");

                    $success['success'] = 'Successfully Added Item Pack';
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

        return $success;
    }

    public function editlistLotMatrixItems($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){

            foreach ($datas as $key => $data) {
                try {
                    $this->db2->query("UPDATE mst_itempackdetail SET  `npackprice` = '" . $this->db->escape($data['npackprice']) . "',`npackmargin` = '" . $this->db->escape($data['npackmargin']) . "' WHERE iitemid='". (int)$this->db->escape($data['iitemid']) ."' AND idetid='". (int)$this->db->escape($data['idetid']) ."'");
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

        $success['success'] = 'Successfully Updated Lot Item';
        return $success;
    }

    public function addItemSlabPrice($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

            $nunitprice = $this->db->escape($data['nprice']) / (int)$this->db->escape($data['iqty']);

            try {
                $this->db2->query("INSERT INTO mst_itemslabprice SET  vsku = '" . $this->db->escape($data['vsku']) . "',`iitemgroupid` = '" . (int)$this->db->escape($data['iitemgroupid']) . "',`iqty` = '" . (int)$this->db->escape($data['iqty']) . "',`nprice` = '" . $this->db->escape($data['nprice']) . "',`nunitprice` = '" . $nunitprice . "', SID = '" . (int)($this->session->data['sid']) . "'");

                    $success['success'] = 'Successfully Added Item Slab Price';
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

        return $success;
    }

    public function editlistSlabPriceItems($datas = array()) {

        $success =array();
        $error =array();

        if(isset($datas) && count($datas) > 0){

            foreach ($datas as $key => $data) {
                try {
                    $this->db2->query("UPDATE mst_itemslabprice SET  `iqty` = '" . (int)$this->db->escape($data['iqty']) . "',`nprice` = '" . $this->db->escape($data['nprice']) . "',`nunitprice` = '" . $this->db->escape($data['nunitprice']) . "' WHERE islabid='". (int)$this->db->escape($data['islabid']) ."'");
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

        $success['success'] = 'Successfully Updated Slab Price Item';
        return $success;
    }

    public function deleteSlabPriceItem($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){
            
            foreach($data as $value){
                try {
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_itemslabprice',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");
                    
                    $this->db2->query("DELETE FROM mst_itemslabprice WHERE islabid='" . (int)$value . "'");
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
        $success['success'] = 'Successfully Deleted Slab Price Item';
        return $success;
    }

    public function addParentItem($data = array()) {

        $success =array();
        $error =array();
        $quatity_on_hand = 0;

        if(isset($data) && count($data) > 0){

            try {
                $parent_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['parent_item_id']) ."' ")->row;

                $quatity_on_hand = $quatity_on_hand + $parent_item['iqtyonhand'];

                $this->db2->query("UPDATE mst_item SET  isparentchild = 2,parentid = 0,parentmasterid = 0 WHERE iitemid= '". (int)$this->db->escape($data['parent_item_id']) ."'");

                $child_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['child_item_id']) ."' ")->row;

                $quatity_on_hand = $quatity_on_hand + $child_item['iqtyonhand'];

                //trn_itempricecosthistory
                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $this->db->escape($data['child_item_id']) . "',vbarcode = '" . $this->db->escape($child_item['vbarcode']) . "', vtype = 'ItemQOH', noldamt = '" . $this->db->escape($child_item['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                //trn_itempricecosthistory

                //trn_webadmin_history
                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                    $old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['child_item_id']) ."' ")->row;
                    unset($old_item_values['itemimage']);
                    $x_general = new stdClass();
                    $x_general->old_item_values = $old_item_values;
                    try{

                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($data['child_item_id']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($child_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($child_item['iqtyonhand']) . "', newamount = '0', source = 'ItemEditAddParent', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                    }
                    catch (Exception $e) {
                        $this->log->write($e);
                    }

                    $trn_webadmin_history_last_id = $this->db2->getLastId();
                }
                //trn_webadmin_history

                $this->db2->query("UPDATE mst_item SET dcostprice='". $this->db->escape($parent_item['dcostprice']) ."',nunitcost='". $this->db->escape($parent_item['nunitcost']) ."',iqtyonhand=0, isparentchild = 1,parentid = '". $this->db->escape($data['parent_item_id']) ."',parentmasterid = '". $this->db->escape($data['parent_item_id']) ."' WHERE iitemid= '". (int)$this->db->escape($data['child_item_id']) ."'");

                //trn_webadmin_history
                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                    $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['child_item_id']) ."' ")->row;
                    unset($new_item_values['itemimage']);
                    $x_general->is_child = 'Yes';
                    $x_general->parentmasterid = $new_item_values['parentmasterid'];
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

                $child_items = $this->db2->query("SELECT `iitemid`,`iqtyonhand`,`vbarcode`,`dcostprice`,`npack` FROM mst_item WHERE parentmasterid= '". (int)$this->db->escape($data['child_item_id']) ."' ")->rows;

                if(count($child_items) > 0){
                    foreach($child_items as $chi_item){

                        //trn_webadmin_history
                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                        $old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;
                        unset($old_item_values['itemimage']);

                            $x_general = new stdClass();
                            $x_general->old_item_values = $old_item_values;
                            try{

                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($chi_item['iitemid']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($chi_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $chi_item['dcostprice'] . "', newamount = '". (($chi_item['npack']) * ($this->db->escape($isParentCheck['nunitcost']))) ."', source = 'ItemEditAddParent', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                            }
                            catch (Exception $e) {
                                $this->log->write($e);
                            }

                            $trn_webadmin_history_last_id = $this->db2->getLastId();
                        }
                        //trn_webadmin_history

                        $quatity_on_hand = $quatity_on_hand + $chi_item['iqtyonhand'];

                        $this->db2->query("UPDATE mst_item SET dcostprice=npack*'". $this->db->escape($parent_item['nunitcost']) ."',nunitcost='". $this->db->escape($parent_item['nunitcost']) ."',parentmasterid='". $this->db->escape($parent_item['iitemid']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");

                        //trn_itempricecosthistory
                        $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$chi_item['iitemid'] ."' ")->row;
                        if($chi_item['dcostprice'] != $new_update_values['dcostprice']){

                            $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'ItemCost', noldamt = '" . $this->db->escape($chi_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                        }
                        //trn_itempricecosthistory
                        //trn_webadmin_history
                        if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;
                            unset($new_item_values['itemimage']);
                            $x_general->is_child = 'Yes';
                            $x_general->parentmasterid = $new_item_values['parentmasterid'];
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

                //trn_itempricecosthistory
                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $this->db->escape($data['parent_item_id']) . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'ItemQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '". $this->db->escape($quatity_on_hand) ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                //trn_itempricecosthistory

                //trn_webadmin_history
                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                    $old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['parent_item_id']) ."' ")->row;
                    unset($old_item_values['itemimage']);

                    $x_general = new stdClass();
                    $x_general->is_parent = 'Yes';
                    $x_general->old_item_values = $old_item_values;

                    try{

                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($data['parent_item_id']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". $this->db->escape($quatity_on_hand) ."', source = 'ItemEditAddParent', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                    }
                    catch (Exception $e) {
                        $this->log->write($e);
                    }


                    $trn_webadmin_history_last_id = $this->db2->getLastId();
                }
                //trn_webadmin_history

                $this->db2->query("UPDATE mst_item SET  iqtyonhand = '". (int)$this->db->escape($quatity_on_hand) ."' WHERE iitemid= '". (int)$this->db->escape($data['parent_item_id']) ."'");
                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($data['parent_item_id']) ."' ")->row;

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

                $success['success'] = 'Successfully Added Parent Item';
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

        return $success;
    }

    public function removeParentItem($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

            try {
                $remove_parent_item = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentid in('". $data['iitemid'] ."') AND isparentchild !=0")->rows;

                if(count($remove_parent_item) == 0){
                    $this->db2->query("UPDATE mst_item SET isparentchild=0,parentid=0,parentmasterid=0 WHERE iitemid= '". (int)$this->db->escape($data['iitemid']) ."'");
                }

                $remove_parent_item_update = $this->db2->query("SELECT `iitemid`,`isparentchild` FROM mst_item WHERE  iitemid='". (int)$this->db->escape($data['selected_parent_item_id']) ."'")->row;

                if($remove_parent_item_update['isparentchild'] == 2){
                    $this->db2->query("UPDATE mst_item SET isparentchild=0,parentid=0,parentmasterid=0 WHERE iitemid= '". (int)$this->db->escape($data['selected_parent_item_id']) ."'");
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
        $success['success'] = 'Successfully Removed Parent Item';
        return $success;
    }

    public function addItems($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

               try {

                    if(isset($data['itemimage']) && !empty($data['itemimage'])){
                        $img = $data['itemimage'];

                        $sql_insert = "INSERT INTO mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', dpricestartdatetime = '" . $this->db->escape($data['dpricestartdatetime']) . "', dpriceenddatetime = '" . $this->db->escape($data['dpriceenddatetime']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', itemimage = '" . $this->db->escape($img) . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dcreated = '" . $this->db->escape($data['dcreated']) . "', dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "', dlastreceived = '" . $this->db->escape($data['dlastreceived']) . "', dlastordered = '" . $this->db->escape($data['dlastordered']) . "', nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "'";

                    }else{
                        $sql_insert = "INSERT INTO mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', dpricestartdatetime = '" . $this->db->escape($data['dpricestartdatetime']) . "', dpriceenddatetime = '" . $this->db->escape($data['dpriceenddatetime']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dcreated = '" . $this->db->escape($data['dcreated']) . "', dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "', dlastreceived = '" . $this->db->escape($data['dlastreceived']) . "', dlastordered = '" . $this->db->escape($data['dlastordered']) . "', nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "'";
                    }
                    
                    $this->db2->query($sql_insert);

                    $last_id = $this->db2->getLastId();
                    $this->db2->query("UPDATE mst_item SET vitemcode = '" . $this->db->escape($data['vbarcode']) . "' WHERE iitemid = '" . (int)$last_id . "'");

                    //mst plcb item

                    if(isset($data['options_data']) && count($data['options_data']) > 0){

                        $this->db2->query("INSERT INTO mst_item_size SET  item_id = '". (int)$last_id ."',unit_id = '". (int)$data['options_data']['unit_id'] ."',unit_value = '". (int)$data['options_data']['unit_value'] ."',SID = '" . (int)($this->session->data['sid'])."'");

                        $this->db2->query("INSERT INTO mst_plcb_item SET  item_id = '". (int)$last_id ."',bucket_id = '". (int)$data['options_data']['bucket_id'] ."',prev_mo_beg_qty = '". $data['iqtyonhand'] ."',prev_mo_end_qty = '". $data['iqtyonhand'] ."',malt = '". (int)$data['options_data']['malt'] ."',SID = '" . (int)($this->session->data['sid'])."'");

                    }else{
                        $checkexist_mst_item_size = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id='" . (int)$last_id . "'")->row;

                        if(count($checkexist_mst_item_size) > 0){

                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_item_size',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_item_size['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                            $this->db2->query("DELETE FROM mst_item_size WHERE id='" . (int)$checkexist_mst_item_size['id'] . "'");

                        }

                        $checkexist_mst_plcb_item = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id='" . (int)$last_id . "'")->row;

                        if(count($checkexist_mst_plcb_item) > 0){

                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_plcb_item',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_plcb_item['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                            $this->db2->query("DELETE FROM mst_plcb_item WHERE id='" . (int)$checkexist_mst_plcb_item['id'] . "'");

                        }
                    }

                    //mst plcb item

                    if(isset($data['iitemgroupid'])){

                        $delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vbarcode']) . "'")->row;

                        if(count($delete_ids) > 0){
                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }

                        $this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vbarcode']) . "'");

                        if($data['iitemgroupid'] != ''){
                            $this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "', vsku='". $this->db->escape($data['vbarcode']) ."',vtype='Product',SID = '" . (int)($this->session->data['sid']) . "' ");
                        }

                    }

                    if($this->db->escape($data['vitemtype']) == 'Lot Matrix'){
                        $vpackname = 'Case';
                        $vdesc = 'Case';

                        $nunitcost = $this->db->escape($data['nunitcost']);
                        if($nunitcost == ''){
                            $nunitcost = 0;
                        }

                        $ipack = $this->db->escape($data['nsellunit']);
                        if($this->db->escape($data['nsellunit']) == ''){
                            $ipack = 0;
                        }

                        $npackprice = $this->db->escape($data['dunitprice']);
                        if($this->db->escape($data['dunitprice']) == ''){
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

                        $this->db2->query("INSERT INTO mst_itempackdetail SET  iitemid = '" . (int)$last_id . "',`vbarcode` = '" . $this->db->escape($data['vbarcode']) . "',`vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`ipack` = '" . (int)$ipack . "',`iparentid` = '" . (int)$iparentid . "',`npackcost` = '" . $npackcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "', SID = '" . (int)($this->session->data['sid']) . "'");
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

        $success['success'] = 'Successfully Added Item';
        $success['iitemid'] = $last_id;
        return $success;
    }

    public function editlistItems($iitemid, $data) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

                //trn_webadmin_history
                    $previous_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$iitemid . "'")->row;
                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                    if(($previous_item['dcostprice'] != $this->db->escape($data['dcostprice'])) && ($previous_item['dunitprice'] != $this->db->escape($data['dunitprice']))){

                            $old_item_values = $previous_item;
                            unset($old_item_values['itemimage']);

                            $x_general = new stdClass();
                            $x_general->old_item_values = $old_item_values;
                            try{

                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $iitemid . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($data['vbarcode']) . "', type = 'All', oldamount = '0', newamount = '0', source = 'ItemEdit', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                            }
                            catch (Exception $e) {
                                $this->log->write($e);
                            }

                            $trn_webadmin_history_last_id = $this->db2->getLastId();

                    }else{
                        if($previous_item['dcostprice'] != $this->db->escape($data['dcostprice'])){

                            $old_item_values = $previous_item;
                            unset($old_item_values['itemimage']);

                            $x_general_cost = new stdClass();
                            $x_general_cost->old_item_values = $old_item_values;
                            try{

                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $iitemid . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($data['vbarcode']) . "', type = 'Cost', oldamount = '" . $previous_item['dcostprice'] . "', newamount = '" . $this->db->escape($data['dcostprice']) . "', source = 'ItemEdit', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                            }
                            catch (Exception $e) {
                                $this->log->write($e);
                            }

                            $trn_webadmin_history_last_id_cost = $this->db2->getLastId();
                        }

                        if($previous_item['dunitprice'] != $this->db->escape($data['dunitprice'])){

                            $old_item_values = $previous_item;
                            unset($old_item_values['itemimage']);
                            $x_general_price = new stdClass();
                            $x_general_price->old_item_values = $old_item_values;
                            try{

                            $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $iitemid . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($data['vbarcode']) . "', type = 'Price', oldamount = '" . $previous_item['dunitprice'] . "', newamount = '" . $this->db->escape($data['dunitprice']) . "', source = 'ItemEdit', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                            }
                            catch (Exception $e) {
                                $this->log->write($e);
                            }
                            $trn_webadmin_history_last_id_price = $this->db2->getLastId();
                        }
                    }
                }

                //trn_webadmin_history

              try {
                    if(isset($data['itemimage']) && !empty($data['itemimage'])){
                        $img = $data['itemimage'];

                        $sql_update = "UPDATE mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', dpricestartdatetime = '" . $this->db->escape($data['dpricestartdatetime']) . "', dpriceenddatetime = '" . $this->db->escape($data['dpriceenddatetime']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', itemimage = '" . $this->db->escape($img) . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "', dlastreceived = '" . $this->db->escape($data['dlastreceived']) . "', dlastordered = '" . $this->db->escape($data['dlastordered']) . "', nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "' WHERE iitemid = '" . (int)$iitemid . "'";
                    }else{
                        $sql_update = "UPDATE mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', dpricestartdatetime = '" . $this->db->escape($data['dpricestartdatetime']) . "', dpriceenddatetime = '" . $this->db->escape($data['dpriceenddatetime']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "', dlastreceived = '" . $this->db->escape($data['dlastreceived']) . "', dlastordered = '" . $this->db->escape($data['dlastordered']) . "', nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', itemimage =null , vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "' WHERE iitemid = '" . (int)$iitemid . "'";
                    }

                    $this->db2->query($sql_update);

                    //mst plcb item

                    if(isset($data['options_data']) && count($data['options_data']) > 0){

                        $mst_item_size = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id= '". (int)$iitemid ."' ")->row;

                        if(count($mst_item_size) > 0){

                            $this->db2->query("UPDATE mst_item_size SET  unit_id = '". (int)$data['options_data']['unit_id'] ."',unit_value = '". (int)$data['options_data']['unit_value'] ."' WHERE item_id = '" . (int)$iitemid . "'");

                        }else{
                            $this->db2->query("INSERT INTO mst_item_size SET  item_id = '". (int)$iitemid ."',unit_id = '". (int)$data['options_data']['unit_id'] ."',unit_value = '". (int)$data['options_data']['unit_value'] ."',SID = '" . (int)($this->session->data['sid'])."'");
                        }

                        $mst_plcb_item = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id= '". (int)$iitemid ."' ")->row;

                        if(count($mst_plcb_item) > 0){
                            $this->db2->query("UPDATE mst_plcb_item SET  bucket_id = '". (int)$data['options_data']['bucket_id'] ."',malt = '". (int)$data['options_data']['malt'] ."' WHERE item_id = '" . (int)$iitemid . "'");
                        }else{
                            $this->db2->query("INSERT INTO mst_plcb_item SET  item_id = '". (int)$iitemid ."',bucket_id = '". (int)$data['options_data']['bucket_id'] ."',prev_mo_beg_qty = '". $data['iqtyonhand'] ."',prev_mo_end_qty = '". $data['iqtyonhand'] ."',malt = '". (int)$data['options_data']['malt'] ."',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                    }else{
                        $checkexist_mst_item_size = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id='" . (int)$iitemid . "'")->row;

                        if(count($checkexist_mst_item_size) > 0){

                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_item_size',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_item_size['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                            $this->db2->query("DELETE FROM mst_item_size WHERE id='" . (int)$checkexist_mst_item_size['id'] . "'");

                        }

                        $checkexist_mst_plcb_item = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id='" . (int)$iitemid . "'")->row;

                        if(count($checkexist_mst_plcb_item) > 0){

                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_plcb_item',`Action` = 'delete',`TableId` = '" . (int)$checkexist_mst_plcb_item['id'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                            $this->db2->query("DELETE FROM mst_plcb_item WHERE id='" . (int)$checkexist_mst_plcb_item['id'] . "'");

                        }
                    }

                    //mst plcb item

                    //trn_itempricecosthistory
                    $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$iitemid ."' ")->row;

                    if($previous_item['dcostprice'] != $new_update_values['dcostprice']){

                        $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'ItemCost', noldamt = '" . $this->db->escape($previous_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                    }

                    if($previous_item['dunitprice'] != $new_update_values['dunitprice']){

                        $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'ItemPrice', noldamt = '" . $this->db->escape($previous_item['dunitprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                    }
                    //trn_itempricecosthistory

                    //trn_webadmin_history
                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                        if(($previous_item['dcostprice'] != $this->db->escape($data['dcostprice'])) && ($previous_item['dunitprice'] != $this->db->escape($data['dunitprice']))){
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$iitemid ."' ")->row;
                                unset($new_item_values['itemimage']);
                                $x_general->new_item_values = $new_item_values;

                                $x_general = addslashes(json_encode($x_general));
                                try{

                                $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id . "'");
                                }
                                catch (Exception $e) {
                                    $this->log->write($e);
                                }
                        }else{
                            if($previous_item['dcostprice'] != $this->db->escape($data['dcostprice'])){
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$iitemid ."' ")->row;
                                unset($new_item_values['itemimage']);
                                $x_general_cost->new_item_values = $new_item_values;

                                $x_general_cost = addslashes(json_encode($x_general_cost));
                                try{

                                $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general_cost . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_cost . "'");
                                }
                                catch (Exception $e) {
                                    $this->log->write($e);
                                }

                            }

                            if($previous_item['dunitprice'] != $this->db->escape($data['dunitprice'])){
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$iitemid ."' ")->row;
                                unset($new_item_values['itemimage']);

                                $x_general_price->new_item_values = $new_item_values;

                                $x_general_price = addslashes(json_encode($x_general_price));
                                try{

                                $this->db2->query("UPDATE trn_webadmin_history SET general = '" . $x_general_price . "' WHERE historyid = '" . (int)$trn_webadmin_history_last_id_price . "'");
                                }
                                catch (Exception $e) {
                                    $this->log->write($e);
                                }

                            }
                        }
                    }
                    //trn_webadmin_history

                    $this->db2->query("UPDATE mst_item SET vitemcode = '" . $this->db->escape($data['vbarcode']) . "' WHERE iitemid = '" . (int)$iitemid . "'");

                    if(isset($data['iitemgroupid'])){
                        $delete_ids = $this->db2->query("SELECT `Id` FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vbarcode']) . "'")->row;

                        if(count($delete_ids) > 0){
                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'itemgroupdetail',`Action` = 'delete',`TableId` = '" . (int)$delete_ids['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }

                        $this->db2->query("DELETE FROM itemgroupdetail WHERE vsku='" . $this->db->escape($data['vbarcode']) . "'");

                        if($data['iitemgroupid'] != ''){
                            $this->db2->query("INSERT INTO itemgroupdetail SET  iitemgroupid = '" . (int)$this->db->escape($data['iitemgroupid']) . "', vsku='". $this->db->escape($data['vbarcode']) ."',vtype='Product',SID = '" . (int)($this->session->data['sid']) . "' ");
                        }
                    }

                    $isParentCheck = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$iitemid ."'")->row;

                    if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                        $child_items = $this->db2->query("SELECT `iitemid`,`vbarcode`,`dcostprice`,`npack` FROM mst_item WHERE parentmasterid= '". (int)$iitemid ."' ")->rows;

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

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $this->db->escape($chi_item['iitemid']) . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($chi_item['vbarcode']) . "', type = 'Cost', oldamount = '" . $chi_item['dcostprice'] . "', newamount = '". (($chi_item['npack']) * ($this->db->escape($isParentCheck['nunitcost']))) ."', source = 'ItemEdit', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
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

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'ItemCost', noldamt = '" . $this->db->escape($chi_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
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

                    if($this->db->escape($data['vitemtype']) == 'Lot Matrix'){
                        
                        if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                            $lot_child_items = $this->db2->query("SELECT `iitemid` FROM mst_item WHERE parentmasterid= '". (int)$iitemid ."' ")->rows;

                            if(count($lot_child_items) > 0){
                                foreach($lot_child_items as $chi){
                                    $pack_lot_child_item = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid= '". (int)$this->db->escape($chi['iitemid']) ."' ")->rows;

                                    if(count($pack_lot_child_item) > 0){
                                        foreach ($pack_lot_child_item as $k => $v) {
                                            $parent_nunitcost = $this->db->escape($data['nunitcost']);

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

                        $nunitcost = $this->db->escape($data['nunitcost']);
                        if($nunitcost == ''){
                            $nunitcost = 0;
                        }

                        $ipack = $this->db->escape($data['nsellunit']);
                        if($this->db->escape($data['nsellunit']) == ''){
                            $ipack = 0;
                        }

                        $npackprice = $this->db->escape($data['dunitprice']);
                        if($this->db->escape($data['dunitprice']) == ''){
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

                        $itempackexist = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE vbarcode='". $this->db->escape($data['vbarcode']) ."' AND iitemid='". (int)$iitemid ."' AND iparentid=1")->row;

                        if(count($itempackexist) > 0){
                            $this->db2->query("UPDATE mst_itempackdetail SET  `vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`ipack` = '" . (int)$ipack . "',`npackcost` = '" . $npackcost . "',`nunitcost` = '" . $nunitcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "' WHERE vbarcode='". $this->db->escape($data['vbarcode']) ."' AND iitemid='". (int)$iitemid ."' AND iparentid=1");
                        }else{
                            $this->db2->query("INSERT INTO mst_itempackdetail SET  iitemid = '" . (int)$iitemid . "',`vbarcode` = '" . $this->db->escape($data['vbarcode']) . "',`vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`nunitcost` = '" . $nunitcost . "',`ipack` = '" . (int)$ipack . "',`iparentid` = '" . (int)$iparentid . "',`npackcost` = '" . $npackcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "', SID = '" . (int)($this->session->data['sid']) . "'");
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

    public function getlistItems() {

        $query = $this->db2->query("SELECT `iitemid`,`vitemtype`,`vitemcode`,`vitemname`,`vunitcode`,`vbarcode`,`vpricetype`,`vcategorycode`,`vdepcode`,`vsuppliercode`,`iqtyonhand`,`dcostprice`,`dunitprice`,`nsaleprice` FROM mst_item WHERE estatus='Active'");
        
        return $query->rows;
    }

    public function getItemListings() {
        $query = $this->db2->query("SELECT variablevalue FROM web_admin_settings WHERE variablename='ItemListing'")->row;

        return $query;
    }

    public function getItemsResult($itemdata = array()) {
        $datas = array();
        $sql_string = '';

        if (isset($itemdata['searchbox']) && !empty($itemdata['searchbox'])) {
            $sql_string .= " WHERE a.iitemid= ". (int)$this->db->escape($itemdata['searchbox']);
            if(isset($itemdata['sort_items']) && $itemdata['sort_items'] !=''){
                $sql_string .= ' ORDER BY a.vitemname '.$itemdata['sort_items'];
            }else{
                $sql_string .= ' ORDER BY a.LastUpdate DESC';
            }
            
        }else{
            
            if(isset($itemdata['sort_items']) && $itemdata['sort_items'] !=''){
                $sql_string .= ' WHERE a.estatus="'.$itemdata['show_items'].'" ORDER BY a.vitemname '.$itemdata['sort_items'];
            }else{
                $sql_string .= ' WHERE a.estatus="'.$itemdata['show_items'].'" ORDER BY a.LastUpdate DESC';
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

        }

        $itemListings = $this->db2->query("SELECT variablevalue FROM web_admin_settings WHERE variablename='ItemListing'")->row;

        if(!empty($itemListings['variablevalue']) && count(json_decode($itemListings['variablevalue'])) > 0){
            $itemListings = json_decode($itemListings['variablevalue']);
        }

        $temp_itemListings = array();
        if($itemListings){
            foreach ($itemListings as $k => $itemListing) {
               $temp_itemListings[$k] = $itemListing;
            }
        }

        if(count($temp_itemListings) > 0){

            $fetch_field_sql = '';
            $fetch_table_sql = '';
            $sql_match = '';

            foreach ($temp_itemListings as $key => $temp_itemListing) {
                if($key == 'vdepcode'){
                    $fetch_field_sql .= 'a.vdepcode,md.vdepartmentname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_department as md ON(a.vdepcode=md.vdepcode)';
                }else if($key == 'vcategorycode'){
                    $fetch_field_sql .= 'a.vcategorycode,mc.vcategoryname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_category as mc ON(a.vcategorycode=mc.vcategorycode)';
                }else if($key == 'vunitcode'){
                    $fetch_field_sql .= 'a.vunitcode,u.vunitname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_unit as u ON(a.vunitcode=u.vunitcode)';
                }else if($key == 'vsuppliercode'){
                    $fetch_field_sql .= 'a.vsuppliercode,ms.vcompanyname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_supplier as ms ON(a.vsuppliercode=ms.vsuppliercode)';
                }else if($key == 'stationid'){
                    $fetch_field_sql .= 'a.stationid,mstation.stationname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_station as mstation ON(a.stationid=mstation.Id)';
                }else if($key == 'aisleid'){
                    $fetch_field_sql .= 'a.aisleid,maisle.aislename,';
                    $fetch_table_sql .= ' LEFT JOIN mst_aisle as maisle ON(a.aisleid=maisle.Id)';
                }else if($key == 'shelfid'){
                    $fetch_field_sql .= 'a.shelfid,mshelf.shelfname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_shelf as mshelf ON(a.shelfid=mshelf.Id)';
                }else if($key == 'shelvingid'){
                    $fetch_field_sql .= 'a.shelvingid,mshelving.shelvingname,';
                    $fetch_table_sql .= ' LEFT JOIN mst_shelving as mshelving ON(a.shelvingid=mshelving.id)';
                }else{
                    $fetch_field_sql .= 'a.'.$key.',';
                }
            }

            $fetch_table_sql = rtrim($fetch_table_sql,", ");

            $query = $this->db2->query("SELECT $fetch_field_sql CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME, a.iitemid,a.vitemtype,a.vbarcode,a.isparentchild FROM mst_item a $fetch_table_sql $sql_string");

            return $query->rows;

        }else{
            // $sql_string = str_replace('WHERE','AND',$sql_string);
            
            $query = $this->db2->query("SELECT a.iitemid,a.vitemtype,a.vitemname,a.vbarcode,a.vcategorycode,mc.vcategoryname,a.vdepcode,md.vdepartmentname,a.vsuppliercode,ms.vcompanyname,a.iqtyonhand,a.dunitprice,a.isparentchild, CASE WHEN a.NPACK = 1 or (a.npack is null)   then a.IQTYONHAND else (Concat(cast(((a.IQTYONHAND div a.NPACK )) as signed), '  (', Mod(a.IQTYONHAND,a.NPACK) ,')') ) end as IQTYONHAND, case isparentchild when 0 then a.VITEMNAME  when 1 then Concat(a.VITEMNAME,' [Child]') when 2 then  Concat(a.VITEMNAME,' [Parent]') end   as VITEMNAME FROM mst_item as a LEFT JOIN mst_category as mc ON (a.vcategorycode=mc.vcategorycode) LEFT JOIN mst_department as md ON(a.vdepcode=md.vdepcode) LEFT JOIN mst_supplier as ms ON (a.vsuppliercode=ms.vsuppliercode) $sql_string ");

            return $query->rows;
        }
 
    }

    public function getItemsSearchResult($search) {

        $datas = array();

        $query = $this->db2->query("SELECT DISTINCT(mi.iitemid),mi.vbarcode,mi.vitemname FROM mst_item as mi LEFT JOIN mst_itemvendor as miv ON(mi.iitemid=miv.iitemid) LEFT JOIN mst_itemalias as mia ON(mi.vitemcode=mia.vitemcode) WHERE mi.estatus='Active' AND ( (mi.vitemname LIKE  '%" .$this->db->escape($search). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search). "%') OR (miv.vvendoritemcode LIKE  '%" .$this->db->escape($search). "%') OR (mia.valiassku LIKE  '%" .$this->db->escape($search). "%') )");

        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {

                $temp = array();
                $temp['iitemid'] = $value['iitemid'];
                $temp['vitemname'] = $value['vitemname'];
                $datas[] = $temp;
            }
        }

        return $datas;
    }

    public function addImportItems($data = array()){

        // $content = "INSERT INTO mst_item SET  dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "',dcreated = '" . $this->db->escape($data['dcreated']) . "',vbarcode = '" . $this->db->escape($data['vbarcode']) . "',vitemcode = '" . $this->db->escape($data['vitemcode']) . "',vitemname = '" . $this->db->escape($data['vitemname']) . "',vitemtype = '" . $this->db->escape($data['vitemtype']) . "',vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "',vdepcode = '" . $this->db->escape($data['vdepcode']) . "',estatus = '" . $this->db->escape($data['estatus']) . "',dunitprice = '" . $this->db->escape($data['dunitprice']) . "',dcostPrice = '" . $this->db->escape($data['dcostPrice']) . "',vunitcode = '" . $this->db->escape($data['vunitcode']) . "',vtax1 = '" . $this->db->escape($data['vtax1']) . "',vtax2 = '" . $this->db->escape($data['vtax2']) . "',vfooditem = '" . $this->db->escape($data['vfooditem']) . "',vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "',vdescription = '" . $this->db->escape($data['vdescription']) . "',vshowimage = '" . $this->db->escape($data['vshowimage']) . "',iquantity = '" . $this->db->escape($data['iquantity']) . "',ireorderpoint = '" . $this->db->escape($data['ireorderpoint']) . "',iqtyonhand = '" . $this->db->escape($data['iqtyonhand']) . "',npack = '" . $this->db->escape($data['npack']) . "',nunitcost = '" . $this->db->escape($data['nunitcost']) . "',vsize = '" . $this->db->escape($data['vsize']) . "',ionupload = '" . $this->db->escape($data['ionupload']) . "',vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "',vageverify = '". $this->db->escape($data['vageverify']) . "',SID = '" . (int)($this->session->data['sid']) . "'";
        //setting inventory as Y and liability as N
        $content = "INSERT INTO mst_item SET  dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "',dcreated = '" . $this->db->escape($data['dcreated']) . "',vbarcode = '" . $this->db->escape($data['vbarcode']) . "',vitemcode = '" . $this->db->escape($data['vitemcode']) . "',vitemname = '" . $this->db->escape($data['vitemname']) . "',vitemtype = '" . $this->db->escape($data['vitemtype']) . "',vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "',vdepcode = '" . $this->db->escape($data['vdepcode']) . "',estatus = '" . $this->db->escape($data['estatus']) . "',dunitprice = '" . $this->db->escape($data['dunitprice']) . "',dcostPrice = '" . $this->db->escape($data['dcostPrice']) . "',vunitcode = '" . $this->db->escape($data['vunitcode']) . "',vtax1 = '" . $this->db->escape($data['vtax1']) . "',vtax2 = '" . $this->db->escape($data['vtax2']) . "',vfooditem = '" . $this->db->escape($data['vfooditem']) . "',vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "',vdescription = '" . $this->db->escape($data['vdescription']) . "',vshowimage = '" . $this->db->escape($data['vshowimage']) . "',iquantity = '" . $this->db->escape($data['iquantity']) . "',ireorderpoint = '" . $this->db->escape($data['ireorderpoint']) . "',iqtyonhand = '" . $this->db->escape($data['iqtyonhand']) . "',npack = '" . $this->db->escape($data['npack']) . "',nunitcost = '" . $this->db->escape($data['nunitcost']) . "',vsize = '" . $this->db->escape($data['vsize']) . "',ionupload = '" . $this->db->escape($data['ionupload']) . "',vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "',vageverify = '". $this->db->escape($data['vageverify']) . "',SID = '" . (int)($this->session->data['sid']) . "',visinventory ='Y',liability = 'N'";

    
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

		$myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");
		
		$content .= "\r\n";

		fwrite($myfile,$content);
		fclose($myfile);*/
    
    
        if(count($data) > 0){
            $this->db2->query("INSERT INTO mst_item SET  dlastupdated = '" . $this->db->escape($data['dlastupdated']) . "',dcreated = '" . $this->db->escape($data['dcreated']) . "',vbarcode = '" . $this->db->escape($data['vbarcode']) . "',vitemcode = '" . $this->db->escape($data['vitemcode']) . "',vitemname = '" . $this->db->escape($data['vitemname']) . "',vitemtype = '" . $this->db->escape($data['vitemtype']) . "',vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "',vdepcode = '" . $this->db->escape($data['vdepcode']) . "',estatus = '" . $this->db->escape($data['estatus']) . "',dunitprice = '" . $this->db->escape($data['dunitprice']) . "',dcostPrice = '" . $this->db->escape($data['dcostPrice']) . "',vunitcode = '" . $this->db->escape($data['vunitcode']) . "',vtax1 = '" . $this->db->escape($data['vtax1']) . "',vtax2 = '" . $this->db->escape($data['vtax2']) . "',vfooditem = '" . $this->db->escape($data['vfooditem']) . "',vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "',vdescription = '" . $this->db->escape($data['vdescription']) . "',vshowimage = '" . $this->db->escape($data['vshowimage']) . "',iquantity = '" . $this->db->escape($data['iquantity']) . "',ireorderpoint = '" . $this->db->escape($data['ireorderpoint']) . "',iqtyonhand = '" . $this->db->escape($data['iqtyonhand']) . "',npack = '" . $this->db->escape($data['npack']) . "',nunitcost = '" . $this->db->escape($data['nunitcost']) . "',vsize = '" . $this->db->escape($data['vsize']) . "',ionupload = '" . $this->db->escape($data['ionupload']) . "',vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "',vageverify = '". $this->db->escape($data['vageverify']) . "',SID = '" . (int)($this->session->data['sid']) . "'");
        }
    }

    public function getItemsSearchBySKU($search) {

        $datas = array();       
        $header = array();
        $detail = array();
        
        $query = $this->db2->query("SELECT * FROM trn_physicalinventorydetail WHERE vbarcode='" .$this->db->escape($search). "'");

        if(count($query->row) > 0){

                $location_query = $this->db2->query("select b.vlocname from trn_physicalinventory  a,mst_location b where a.ilocid=b.ilocid AND a.ipiid='" .$query->row['ipiid']. "'");
                
                 $itemtype_query = $this->db2->query("select vitemtype from mst_item a where iitemid='" .$query->row['vitemid']. "' AND vbarcode='" .$query->row['vbarcode']. "'");
                
                $header = array(
                    'vitemname'=> $query->row['vitemname'],
                    'qoh' => $query->row['itotalunit'],
                    'vlocname' => (count($location_query->row)>0)?$location_query->row['vlocname']:'',
                    'ilocid' => (count($location_query->row)>0)?$location_query->row['ilocid']:'',
                    'vitemtype' => (count($itemtype_query->row)>0)?$itemtype_query->row['vitemtype']:'',
                );
                
                $pack_qty= $this->db2->query("SELECT vpackname FROM mst_itempackdetail WHERE iitemid='" .$query->row['vitemid']. "' AND vbarcode='" .$query->row['vbarcode']. "'");
                
                $detail = array(
                    'vunitcode' => $query->row['vunitcode'],
                    'vpackname' => (count($pack_qty->row)>0)?$pack_qty->row['vpackname']:'',                    
                    'npackqty' => $query->row['npackqty']
            );
            
            $datas = array(
                "header" => $header,
                "detail" => $detail          
            ); 
                
        }

        return $datas;
    }

    public function deleteItems($data) {
        $return = array();

        if(isset($data) && count($data) > 0){
            
            $return = [];

            foreach ($data as $key => $value) {
                
                if($value > 0 && $value < 100){
                    $return['error'] = 'Selected item is used in system OR it is default item. You can not delete this item. ';
                    // return $return;
                }

                $query1 = $this->db2->query("SELECT * FROM trn_purchaseorderdetail WHERE vitemid='" .$this->db->escape($value). "'")->row;

                if(count($query1) > 0){
                    $return['error'] = 'Selected item is used in system OR it is default item. You can not delete this item. ';
                    // return $return;
                }

                $query2 = $this->db2->query("SELECT * FROM trn_salesdetail as ts, mst_item as mi WHERE mi.vbarcode=ts.vitemcode AND mi.iitemid='" .$this->db->escape($value). "'")->row;

                if(count($query2) > 0){
                    $return['error'] = 'Selected item is used in system OR it is default item. You can not delete this item. ';
                    // return $return;
                }

                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_item',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                $this->db2->query("DELETE FROM mst_item WHERE iitemid='" . (int)$value . "'");
            }

        }

        $return['success'] = 'Item Deleted Successfully';

        return $return;

    }
    


    public function getItemByBarcode($vbarcode) {
        $sql="SELECT iitemid FROM mst_item WHERE vbarcode='". $this->db->escape($vbarcode) ."'";

        return $this->db2->query($sql)->row;


    }

    public function checkVendorItemCode($data) {
        $sql="SELECT * FROM mst_itemvendor WHERE iitemid='". $this->db->escape($data['iitemid']) ."' AND ivendorid='". $this->db->escape($data['ivendorid']) ."' AND vvendoritemcode='". $this->db->escape($data['vvendoritemcode']) ."'";

        $v_count = $this->db2->query($sql)->row;

        if(count($v_count) > 0){
            $return['error'] = 'Vendor Code Already Exist';
        }else{
            $return['success'] = 'Vendor Code Not Exist';
        }

        return $return;

    }

    public function deleteVendorItemCode($data) {
        
        if(isset($data) && count($data) > 0){
            
            foreach ($data as $key => $value) {
                $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_itemvendor',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                $this->db2->query("DELETE FROM mst_itemvendor WHERE Id='" . (int)$value . "'");
            }
        }

        $return['success'] = 'Item Vendor Code Deleted Successfully';

        return $return;

    }

    public function getStoreSettingTax1() {
        $sql="SELECT * FROM mst_storesetting WHERE vsettingname='Tax1seletedfornewItem'";

        return $this->db2->query($sql)->row;
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

    
    public function getItemUnitData($iitemid){

        $query = $this->db2->query("SELECT * FROM mst_item_size WHERE item_id='". (int)$iitemid ."'");

        return $query->row;
    }

    public function getItemBucketData($iitemid){

        $query = $this->db2->query("SELECT * FROM mst_plcb_item WHERE item_id='". (int)$iitemid ."'");

        return $query->row;
    }

}
?>