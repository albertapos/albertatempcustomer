<?php
class ModelAdministrationItems extends Model {
    public function getItems() {
        $datas = array();

        $query = $this->db2->query("SELECT `iitemid`,`webstore`,`vitemtype`,`vitemcode`,`vitemname`,`vunitcode`,`vbarcode`,`vpricetype`,`vcategorycode`,`vdepcode`,`vsuppliercode`,`iqtyonhand`,`ireorderpoint`,`dcostprice`,`dunitprice`,`nsaleprice`,`nlevel2`,`nlevel3`,`nlevel4`,`iquantity`,`ndiscountper`,`ndiscountamt`,`vtax1`,`vtax2`,`vfooditem`,`vdescription`,`dlastsold`,`visinventory`,`dpricestartdatetime`,`dpriceenddatetime`,`estatus`,`nbuyqty`,`ndiscountqty`,`nsalediscountper`,`vshowimage`,`itemimage`,`vageverify`,`ebottledeposit`,`nbottledepositamt`,`vbarcodetype`,`ntareweight`,`ntareweightper`,`dcreated`,`dlastupdated`,`dlastreceived`,`dlastordered`,`nlastcost`,`nonorderqty`,`vparentitem`,`nchildqty`,`vsize`,`npack`,`nunitcost`,`ionupload`,`nsellunit`,`ilotterystartnum`,`ilotteryendnum`,`etransferstatus`,`vsequence`,`vcolorcode`,`vdiscount`,`norderqtyupto`,`vshowsalesinzreport`,`iinvtdefaultunit`,`LastUpdate`,`SID`,`stationid`,`shelfid`,`aisleid`,`shelvingid`,`rating`,`vintage`,`PrinterStationId`,`liability`,`isparentchild`,``parentid,`parentmasterid`,`wicitem` FROM mst_item");

        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {
                $temp = array();
                $temp['iitemid'] = $value['iitemid'];
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

    public function getItem($iitemid) {
        $datas = array();

        $query = $this->db2->query("SELECT * FROM mst_item where iitemid='". (int)$iitemid ."'");

        if(count($query->row) > 0){
            $value = $query->row;
            
                $datas['iitemid'] = $value['iitemid'];
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
            
        }  

        return $datas;
    }

    public function getItemsSearch($search) {

        $datas = array();

        $query = $this->db2->query("SELECT * FROM mst_item WHERE vitemname LIKE  '%" .$this->db->escape($search). "%'");

        if(count($query->rows) > 0){
            foreach ($query->rows as $key => $value) {
                $temp = array();
                $temp['iitemid'] = $value['iitemid'];
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

    public function addItems($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

               try {

                    if(isset($data['itemimage']) && !empty($data['itemimage'])){
                        $img = $data['itemimage'];
                    }else{
                        $img = NULL;
                    }
					//$this->db2->query("INSERT INTO mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "', vitemcode = '" . $this->db->escape($data['vitemcode']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', itemimage = '" . $img . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dcreated = now(), nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "'");

                    $this->db2->query("INSERT INTO mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "', vitemcode = '" . $this->db->escape($data['vitemcode']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', dpricestartdatetime = NULL, dpriceenddatetime = NULL, estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', itemimage = '" . $img . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dcreated = NULL, dlastupdated = NULL , dlastreceived = NULL, dlastordered = NULL , nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "'");
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
        return $success;
    }

    public function editlistItems($iitemid, $data) {

        $success =array();
        $error =array();
        
        if(isset($data) && count($data) > 0){

              try {
                    if(isset($data['itemimage']) && !empty($data['itemimage'])){
                        $img = $data['itemimage'];
                    }else{
                        $img = '';
                    }

                    $this->db2->query("UPDATE mst_item SET  webstore = '" . $this->db->escape($data['webstore']) . "',`vitemtype` = '" . $this->db->escape($data['vitemtype']) . "', vitemcode = '" . $this->db->escape($data['vitemcode']) . "',`vitemname` = '" . $this->db->escape($data['vitemname']) . "',`vunitcode` = '" . $this->db->escape($data['vunitcode']) . "', vbarcode = '" . $this->db->escape($data['vbarcode']) . "', vpricetype = '" . $this->db->escape($data['vpricetype']) . "', vcategorycode = '" . $this->db->escape($data['vcategorycode']) . "', vdepcode = '" . $this->db->escape($data['vdepcode']) . "', vsuppliercode = '" . $this->db->escape($data['vsuppliercode']) . "', iqtyonhand = '" . (int)$this->db->escape($data['iqtyonhand']) . "', ireorderpoint = '" . (int)$this->db->escape($data['ireorderpoint']) . "', dcostprice = '" . $this->db->escape($data['dcostprice']) . "', dunitprice = '" . $this->db->escape($data['dunitprice']) . "', nsaleprice = '" . $this->db->escape($data['nsaleprice']) . "', nlevel2 = '" . $this->db->escape($data['nlevel2']) . "', nlevel3 = '" . $this->db->escape($data['nlevel3']) . "', nlevel4 = '" . $this->db->escape($data['nlevel4']) . "', iquantity = '" . (int)$this->db->escape($data['iquantity']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "', ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "', vtax1 = '" . $this->db->escape($data['vtax1']) . "', vtax2 = '" . $this->db->escape($data['vtax2']) . "', vfooditem = '" . $this->db->escape($data['vfooditem']) . "', vdescription = '" . $this->db->escape($data['vdescription']) . "', dlastsold = '" . $this->db->escape($data['dlastsold']) . "', visinventory = '" . $this->db->escape($data['visinventory']) . "', estatus = '" . $this->db->escape($data['estatus']) . "', nbuyqty = '" . (int)$this->db->escape($data['nbuyqty']) . "', ndiscountqty = '" . (int)$this->db->escape($data['ndiscountqty']) . "', nsalediscountper = '" . $this->db->escape($data['nsalediscountper']) . "', vshowimage = '" . $this->db->escape($data['vshowimage']) . "', itemimage = '" . $img . "', vageverify = '" . $this->db->escape($data['vageverify']) . "', ebottledeposit = '" . $this->db->escape($data['ebottledeposit']) . "', nbottledepositamt = '" . $this->db->escape($data['nbottledepositamt']) . "', vbarcodetype = '" . $this->db->escape($data['vbarcodetype']) . "', ntareweight = '" . $this->db->escape($data['ntareweight']) . "', ntareweightper = '" . $this->db->escape($data['ntareweightper']) . "', dcreated = now(), nlastcost = '" . $this->db->escape($data['nlastcost']) . "', nonorderqty = '" . (int)$this->db->escape($data['nonorderqty']) . "', vparentitem = '" . $this->db->escape($data['vparentitem']) . "', nchildqty = '" . $this->db->escape($data['nchildqty']) . "', vsize = '" . $this->db->escape($data['vsize']) . "', npack = '" . (int)$this->db->escape($data['npack']) . "', nunitcost = '" . $this->db->escape($data['nunitcost']) . "', ionupload = '" . $this->db->escape($data['ionupload']) . "', nsellunit = '" . (int)$this->db->escape($data['nsellunit']) . "', ilotterystartnum = '" . (int)$this->db->escape($data['ilotterystartnum']) . "', ilotteryendnum = '" . (int)$this->db->escape($data['ilotteryendnum']) . "', etransferstatus = '" . $this->db->escape($data['etransferstatus']) . "', vsequence = '" . $this->db->escape($data['vsequence']) . "', vcolorcode = '" . $this->db->escape($data['vcolorcode']) . "', vdiscount = '" . $this->db->escape($data['vdiscount']) . "', norderqtyupto = '" . (int)$this->db->escape($data['norderqtyupto']) . "', vshowsalesinzreport = '" . $this->db->escape($data['vshowsalesinzreport']) . "', iinvtdefaultunit = '" . $this->db->escape($data['iinvtdefaultunit']) . "', SID = '" . (int)($this->session->data['sid']) . "', stationid = '" . (int)$this->db->escape($data['stationid']) . "', shelfid = '" . (int)$this->db->escape($data['shelfid']) . "', aisleid = '" . (int)$this->db->escape($data['aisleid']) . "', shelvingid = '" . (int)$this->db->escape($data['shelvingid']) . "', rating = '" . $this->db->escape($data['rating']) . "', vintage = '" . $this->db->escape($data['vintage']) . "', PrinterStationId = '" . (int)$this->db->escape($data['PrinterStationId']) . "', liability = '" . $this->db->escape($data['liability']) . "', isparentchild = '" . (int)$this->db->escape($data['isparentchild']) . "', parentid = '" . (int)$this->db->escape($data['parentid']) . "', parentmasterid = '" . (int)$this->db->escape($data['parentmasterid']) . "', wicitem = '" . (int)$this->db->escape($data['wicitem']) . "' WHERE iitemid = '" . (int)$iitemid . "'");
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

    public function getDepartments() {
        $query = $this->db2->query("SELECT * FROM mst_department ORDER BY vdepartmentname")->rows;
        return $query;
    }

    public function getCategories() {
        $query = $this->db2->query("SELECT * FROM mst_category ORDER BY vcategoryname")->rows;
        return $query;
    }

    public function getUnits() {
        $query = $this->db2->query("SELECT * FROM mst_unit")->rows;
        return $query;
    }

    public function getSuppliers() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY vcompanyname")->rows;
        return $query;
    }

    public function getSizes() {
        $query = $this->db2->query("SELECT * FROM mst_size")->rows;
        return $query;
    }

    public function getItemGroups() {
        $query = $this->db2->query("SELECT * FROM itemgroup ORDER BY vitemgroupname")->rows;
        return $query;
    }

    public function getAgeVerifications() {
        $query = $this->db2->query("SELECT * FROM mst_ageverification")->rows;
        return $query;
    }

    public function getStations() {
        $query = $this->db2->query("SELECT * FROM  mst_station")->rows;
        return $query;
    }

    public function getAisles() {
        $query = $this->db2->query("SELECT * FROM  mst_aisle")->rows;
        return $query;
    }

    public function getShelfs() {
        $query = $this->db2->query("SELECT * FROM  mst_shelf")->rows;
        return $query;
    }

    public function getShelvings() {
        $query = $this->db2->query("SELECT * FROM  mst_shelving")->rows;
        return $query;
    }

}
?>