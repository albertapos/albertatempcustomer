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

        $sort_data = array(
            'estatus',
            'vponumber',
            'vvendorname',
            'vordertype',
            'dcreatedate',
            'dreceiveddate',
            'LastUpdate',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY LastUpdate";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

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

    public function getPurchaseOrder($ipoid) {
        $return = array();
        $query = $this->db2->query("SELECT * FROM trn_purchaseorder WHERE ipoid='". (int)$ipoid ."'")->row;

        $return = $query;
        $query1 = $this->db2->query("SELECT tpod.*,mi.iqtyonhand as iqtyonhand,mi.dcostprice as dcostprice, mi.dunitprice as dunitprice,mi.ireorderpoint as ireorderpoint, mi.npack as npack, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand else 0 end as case_qty, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint else cast(((mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then  (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) else 0 end as total_case_qty FROM trn_purchaseorderdetail as tpod, mst_item as mi WHERE mi.estatus='Active' AND tpod.vitemid=mi.iitemid AND ipoid='". (int)$ipoid ."' ORDER BY tpod.ipodetid DESC")->rows;

        $return['items'] = $query1;
        return $return;
    }

    public function getVendors() {
        $query = $this->db2->query("SELECT * FROM mst_supplier ORDER BY isupplierid");

        return $query->rows;
    }

    public function getSearchItems($search) {
        $query = $this->db2->query("SELECT `iitemid`,`vitemcode`,`vitemname` FROM mst_item WHERE estatus='Active' AND (vitemname LIKE  '%" .$this->db->escape($search). "%' OR vbarcode LIKE  '%" .$this->db->escape($search). "%')");

        return $query->rows;
    }

    public function getSearchItem($iitemid,$ivendorid) {

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, mi.iqtyonhand, mi.ireorderpoint, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand else 0 end as case_qty, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint else cast(((mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then  (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) else 0 end as total_case_qty, mi.vsuppliercode as ivendorid, mu.vunitname FROM mst_item mi LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.estatus='Active' AND mi.iitemid='". (int)$iitemid ."'");

        $item_arr = $query->row;

        if(count($item_arr) > 0){
            $item_ve = $this->db2->query("SELECT vvendoritemcode FROM mst_itemvendor WHERE iitemid='". (int)$iitemid ."' AND ivendorid='". (int)$ivendorid ."'")->row;
            if(count($item_ve) > 0){
                $item_arr['vvendoritemcode'] = $item_ve['vvendoritemcode'];
            }else{
                $item_arr['vvendoritemcode'] = '';
            }
        }

        return $item_arr;
    }

    public function getSearchItemVendorData($iitemid,$ivendorid) {

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, mi.iqtyonhand, mi.ireorderpoint, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand else 0 end as case_qty, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint else cast(((mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then  (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) else 0 end as total_case_qty, miv.ivendorid, miv.vvendoritemcode, mu.vunitname FROM mst_item mi LEFT JOIN mst_itemvendor miv ON (mi.iitemid = miv.iitemid) LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.estatus='Active' AND miv.ivendorid='". (int)$ivendorid ."' AND  miv.iitemid='". (int)$iitemid ."'");

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

    public function addPurchaseOrder($data = array(), $close = null, $ordertype) {

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
                    $this->db2->query("INSERT INTO trn_purchaseorder SET  vinvoiceno = '" . $this->db->escape($data['vinvoiceno']) . "',vrefnumber = '" . $this->db->escape($data['vinvoiceno']) . "',dcreatedate = '" . $dcreatedate . "', vponumber = '" . $this->db->escape($data['vponumber']) . "',`dreceiveddate` = '" . $dreceiveddate . "',`vordertitle` = '" . $this->db->escape($data['vordertitle']) . "', estatus = '" . $close . "', vorderby = '" . $this->db->escape($data['vorderby']) . "', vconfirmby = '" . $this->db->escape($data['vconfirmby']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', vshipvia = '" . $this->db->escape($data['vshipvia']) . "', vvendorid = '" . $this->db->escape($data['vvendorid']) . "', vvendorname = '" . $this->db->escape($data['vvendorname']) . "', vvendoraddress1 = '" . $this->db->escape($data['vvendoraddress1']) . "', vvendoraddress2 = '" . $this->db->escape($data['vvendoraddress2']) . "', vvendorstate = '" . $this->db->escape($data['vvendorstate']) . "', vvendorzip = '" . $this->db->escape($data['vvendorzip']) . "', vvendorphone = '" . $this->db->escape($data['vvendorphone']) . "',vshpid = '" . $this->db->escape($data['vshpid']) . "',vshpname = '" . $this->db->escape($data['vshpname']) . "',vshpaddress1 = '" . $this->db->escape($data['vshpaddress1']) . "',vshpaddress2 = '" . $this->db->escape($data['vshpaddress2']) . "',vshpstate = '" . $this->db->escape($data['vshpstate']) . "',vshpzip = '" . $this->db->escape($data['vshpzip']) . "',vshpphone = '" . $this->db->escape($data['vshpphone']) . "',nsubtotal = '" . $this->db->escape($data['nsubtotal']) . "',ntaxtotal = '" . $this->db->escape($data['ntaxtotal']) . "',nfreightcharge = '" . $this->db->escape($data['nfreightcharge']) . "',ndeposittotal = '" . $this->db->escape($data['ndeposittotal']) . "',nreturntotal = '" . $this->db->escape($data['nreturntotal']) . "',ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "',nripsamt = '" . $this->db->escape($data['nripsamt']) . "',nnettotal = '" . $this->db->escape($data['nnettotal']) . "', vordertype = '" . $ordertype . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $ipoid = $this->db2->getLastId();
                    $trn_purchaseorder_id = $ipoid;

                    if(isset($data['items']) && count($data['items']) > 0){

                        $data['items'] = array_reverse($data['items']);
						
						$riptotalamount =0;
						
                        foreach ($data['items'] as $key => $item) {

                            $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "',SID = '" . (int)($this->session->data['sid'])."',nripamount= '" . $this->db->escape($item['nripamount']) . "'");
							
							$riptotalamount=$riptotalamount+$item['nripamount'];							
							// Price Change

                            $isItemExist = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$item['vitemid'] ."'")->row;

                            if($item['dunitprice'] != $isItemExist['dunitprice']){

                                $sql_mst_item = "UPDATE mst_item SET dunitprice = '" . $this->db->escape($item['dunitprice']) . "' WHERE iitemid='".(int)$item['vitemid']."'";
                                $this->db2->query($sql_mst_item);

                                if($isItemExist['vitemtype'] == 'Lottery'){
                                    $type_name = 'POPriceLott';
                                }else if($isItemExist['vitemtype'] == 'Kiosk'){
                                    $type_name = 'POPriceKio';
                                }else if($isItemExist['vitemtype'] == 'Lot Matrix'){
                                    $type_name = 'POPriceLot';
                                }else if($isItemExist['vitemtype'] == 'Gasoline'){
                                    $type_name = 'POPriceGas';
                                }else{
                                    $type_name = 'POPriceStd';
                                }

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $item['vitemid'] . "',vbarcode = '" . $this->db->escape($isItemExist['vbarcode']) . "', vtype = '". $type_name ."', noldamt = '" . $this->db->escape($isItemExist['dunitprice']) . "', nnewamt = '" . $this->db->escape($item['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                                //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $isItemExist;
                                unset($old_item_values['itemimage']);

                                $x_general = new stdClass();
                                $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                $x_general->current_po_item_values = $item;
                                $x_general->old_item_values = $old_item_values;
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                unset($new_item_values['itemimage']);
                                $x_general->new_item_values = $new_item_values;

                                $x_general = addslashes(json_encode($x_general));

                                try{
                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $item['vitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($isItemExist['vbarcode']) . "', type = 'Price', oldamount = '" . $this->db->escape($isItemExist['dunitprice']) . "', newamount = '". $this->db->escape($item['dunitprice']) ."', general = '" . $x_general . "', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                      $this->log->write($e);
                                }

                                
                                }
                                //trn_webadmin_history

                                if($this->db->escape($isItemExist['vitemtype']) == 'Lot Matrix'){

                                    $itempackexist = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE vbarcode='". $this->db->escape($isItemExist['vbarcode']) ."' AND iitemid='". (int)$isItemExist['iitemid'] ."' AND iparentid=1")->row;

                                    if(count($itempackexist) > 0){

                                        $vpackname = $itempackexist['vpackname'];
                                        $vdesc = $itempackexist['vdesc'];

                                        $nunitcost = $itempackexist['nunitcost'];
                                        if($nunitcost == ''){
                                            $nunitcost = 0;
                                        }

                                        $ipack = $itempackexist['ipack'];
                                        if($itempackexist['ipack'] == ''){
                                            $ipack = 0;
                                        }

                                        $npackprice = $this->db->escape($item['dunitprice']);
                                        if($this->db->escape($item['dunitprice']) == ''){
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


                                        $this->db2->query("UPDATE mst_itempackdetail SET  `vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`ipack` = '" . (int)$ipack . "',`npackcost` = '" . $npackcost . "',`nunitcost` = '" . $nunitcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "' WHERE vbarcode='". $this->db->escape($isItemExist['vbarcode']) ."' AND iitemid='". (int)$isItemExist['iitemid'] ."' AND iparentid=1");
                                    }else{

                                        $vpackname = 'Case';
                                        $vdesc = 'Case';

                                        $nunitcost = $this->db->escape($isItemExist['nunitcost']);
                                        if($nunitcost == ''){
                                            $nunitcost = 0;
                                        }

                                        $ipack = $this->db->escape($isItemExist['nsellunit']);
                                        if($this->db->escape($isItemExist['nsellunit']) == ''){
                                            $ipack = 0;
                                        }

                                        $npackprice = $this->db->escape($item['dunitprice']);
                                        if($this->db->escape($item['dunitprice']) == ''){
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

                                        $this->db2->query("INSERT INTO mst_itempackdetail SET  iitemid = '" . (int)$iitemid . "',`vbarcode` = '" . $this->db->escape($isItemExist['vbarcode']) . "',`vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`nunitcost` = '" . $nunitcost . "',`ipack` = '" . (int)$ipack . "',`iparentid` = '" . (int)$iparentid . "',`npackcost` = '" . $npackcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "', SID = '" . (int)($this->session->data['sid']) . "'");
                                    }

                                }

                            }

                            // Price Change
                        }
						
						if($riptotalamount > 0)
						{
							$sql= "INSERT INTO trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '" . $this->db->escape($riptotalamount) . "',SID = '" . (int)($this->session->data['sid'])."'";
							$this->db2->query($sql);
						}
                    }

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage().'1'; 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage().'2'; 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage().'3'; 
                    return $error; 
                }
        }

        $success['success'] = 'Successfully Added Purchase Order';
        $success['ipoid'] = $ipoid;
        return $success;
    }

    public function editPurchaseOrder($data = array(), $close = null, $ordertype) {

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
                    $this->db2->query("UPDATE trn_purchaseorder SET  vinvoiceno = '" . $this->db->escape($data['vinvoiceno']) . "',vrefnumber = '" . $this->db->escape($data['vinvoiceno']) . "',dcreatedate = '" . $dcreatedate . "', vponumber = '" . $this->db->escape($data['vponumber']) . "',`dreceiveddate` = '" . $dreceiveddate . "',`vordertitle` = '" . $this->db->escape($data['vordertitle']) . "', estatus = '" . $close . "', vorderby = '" . $this->db->escape($data['vorderby']) . "', vconfirmby = '" . $this->db->escape($data['vconfirmby']) . "', vnotes = '" . $this->db->escape($data['vnotes']) . "', vshipvia = '" . $this->db->escape($data['vshipvia']) . "', vvendorid = '" . $this->db->escape($data['vvendorid']) . "', vvendorname = '" . $this->db->escape($data['vvendorname']) . "', vvendoraddress1 = '" . $this->db->escape($data['vvendoraddress1']) . "', vvendoraddress2 = '" . $this->db->escape($data['vvendoraddress2']) . "', vvendorstate = '" . $this->db->escape($data['vvendorstate']) . "', vvendorzip = '" . $this->db->escape($data['vvendorzip']) . "', vvendorphone = '" . $this->db->escape($data['vvendorphone']) . "',vshpid = '" . $this->db->escape($data['vshpid']) . "',vshpname = '" . $this->db->escape($data['vshpname']) . "',vshpaddress1 = '" . $this->db->escape($data['vshpaddress1']) . "',vshpaddress2 = '" . $this->db->escape($data['vshpaddress2']) . "',vshpstate = '" . $this->db->escape($data['vshpstate']) . "',vshpzip = '" . $this->db->escape($data['vshpzip']) . "',vshpphone = '" . $this->db->escape($data['vshpphone']) . "',nsubtotal = '" . $this->db->escape($data['nsubtotal']) . "',ntaxtotal = '" . $this->db->escape($data['ntaxtotal']) . "',nfreightcharge = '" . $this->db->escape($data['nfreightcharge']) . "',ndeposittotal = '" . $this->db->escape($data['ndeposittotal']) . "',nreturntotal = '" . $this->db->escape($data['nreturntotal']) . "',ndiscountamt = '" . $this->db->escape($data['ndiscountamt']) . "',nripsamt = '" . $this->db->escape($data['nripsamt']) . "',nnettotal = '" . $this->db->escape($data['nnettotal']) . "', vordertype = '" . $ordertype . "' WHERE ipoid='". (int)$this->db->escape($data['ipoid']) ."'");

                    $ipoid = (int)$this->db->escape($data['ipoid']);
                    $trn_purchaseorder_id = $ipoid;

                    if(isset($data['items']) && count($data['items']) > 0){

                        $data['items'] = array_reverse($data['items']);
						
						$riptotalamount =0;
                        
						foreach ($data['items'] as $key => $item) {

                            $ipodetid_ids = $this->db2->query("SELECT `ipodetid` FROM  trn_purchaseorderdetail WHERE ipodetid='" . (int)$this->db->escape($item['ipodetid']) . "' ")->rows;							
                            
							if(count($ipodetid_ids) > 0){
                                $this->db2->query("UPDATE trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "',nripamount= '" . $this->db->escape($item['nripamount']) . "' WHERE ipodetid='" . (int)$this->db->escape($item['ipodetid']) . "' ");
                            }else{
                                $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$ipoid . "',vitemid = '" . $this->db->escape($item['vitemid']) . "',nordunitprice = '" . $this->db->escape($item['nordunitprice']) . "', vunitcode = '" . $this->db->escape($item['vunitcode']) . "',`vunitname` = '" . $this->db->escape($item['vunitname']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "', vsize = '" . $this->db->escape($item['vsize']) . "', nordqty = '" . $this->db->escape($item['nordqty']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', itotalunit = '" . $this->db->escape($item['itotalunit']) . "', nordextprice = '" . $this->db->escape($item['nordextprice']) . "', nunitcost = '" . $this->db->escape($item['nunitcost']) . "',SID = '" . (int)($this->session->data['sid'])."',nripamount= '" . $this->db->escape($item['nripamount']) . "'");
                            }
							
							$riptotalamount=$riptotalamount+$item['nripamount'];

                            // Price Change

                            $isItemExist = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='". (int)$item['vitemid'] ."'")->row;

                            if($item['dunitprice'] != $isItemExist['dunitprice']){

                                $sql_mst_item = "UPDATE mst_item SET dunitprice = '" . $this->db->escape($item['dunitprice']) . "' WHERE iitemid='".(int)$item['vitemid']."'";
                                $this->db2->query($sql_mst_item);

                                if($isItemExist['vitemtype'] == 'Lottery'){
                                    $type_name = 'POPriceLott';
                                }else if($isItemExist['vitemtype'] == 'Kiosk'){
                                    $type_name = 'POPriceKio';
                                }else if($isItemExist['vitemtype'] == 'Lot Matrix'){
                                    $type_name = 'POPriceLot';
                                }else if($isItemExist['vitemtype'] == 'Gasoline'){
                                    $type_name = 'POPriceGas';
                                }else{
                                    $type_name = 'POPriceStd';
                                }

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $item['vitemid'] . "',vbarcode = '" . $this->db->escape($isItemExist['vbarcode']) . "', vtype = '". $type_name ."', noldamt = '" . $this->db->escape($isItemExist['dunitprice']) . "', nnewamt = '" . $this->db->escape($item['dunitprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                                //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $isItemExist;
                                unset($old_item_values['itemimage']);

                                $x_general = new stdClass();
                                $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                $x_general->current_po_item_values = $item;
                                $x_general->old_item_values = $old_item_values;
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                unset($new_item_values['itemimage']);
                                $x_general->new_item_values = $new_item_values;

                                $x_general = addslashes(json_encode($x_general));
                                try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $item['vitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($isItemExist['vbarcode']) . "', type = 'Price', oldamount = '" . $this->db->escape($isItemExist['dunitprice']) . "', newamount = '". $this->db->escape($item['dunitprice']) ."', general = '" . $x_general . "', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                      $this->log->write($e);
                                }
                                }
                                //trn_webadmin_history

                                if($this->db->escape($isItemExist['vitemtype']) == 'Lot Matrix'){

                                    $itempackexist = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE vbarcode='". $this->db->escape($isItemExist['vbarcode']) ."' AND iitemid='". (int)$isItemExist['iitemid'] ."' AND iparentid=1")->row;

                                    if(count($itempackexist) > 0){

                                        $vpackname = $itempackexist['vpackname'];
                                        $vdesc = $itempackexist['vdesc'];

                                        $nunitcost = $itempackexist['nunitcost'];
                                        if($nunitcost == ''){
                                            $nunitcost = 0;
                                        }

                                        $ipack = $itempackexist['ipack'];
                                        if($itempackexist['ipack'] == ''){
                                            $ipack = 0;
                                        }

                                        $npackprice = $this->db->escape($item['dunitprice']);
                                        if($this->db->escape($item['dunitprice']) == ''){
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


                                        $this->db2->query("UPDATE mst_itempackdetail SET  `vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`ipack` = '" . (int)$ipack . "',`npackcost` = '" . $npackcost . "',`nunitcost` = '" . $nunitcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "' WHERE vbarcode='". $this->db->escape($isItemExist['vbarcode']) ."' AND iitemid='". (int)$isItemExist['iitemid'] ."' AND iparentid=1");
                                    }else{

                                        $vpackname = 'Case';
                                        $vdesc = 'Case';

                                        $nunitcost = $this->db->escape($isItemExist['nunitcost']);
                                        if($nunitcost == ''){
                                            $nunitcost = 0;
                                        }

                                        $ipack = $this->db->escape($isItemExist['nsellunit']);
                                        if($this->db->escape($isItemExist['nsellunit']) == ''){
                                            $ipack = 0;
                                        }

                                        $npackprice = $this->db->escape($item['dunitprice']);
                                        if($this->db->escape($item['dunitprice']) == ''){
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

                                        $this->db2->query("INSERT INTO mst_itempackdetail SET  iitemid = '" . (int)$iitemid . "',`vbarcode` = '" . $this->db->escape($isItemExist['vbarcode']) . "',`vpackname` = '" . $vpackname . "',`vdesc` = '" . $vdesc . "',`nunitcost` = '" . $nunitcost . "',`ipack` = '" . (int)$ipack . "',`iparentid` = '" . (int)$iparentid . "',`npackcost` = '" . $npackcost . "',`npackprice` = '" . $npackprice . "',`npackmargin` = '" . $npackmargin . "', SID = '" . (int)($this->session->data['sid']) . "'");
                                    }

                                }

                            }

                            // Price Change

                        }
						
						$rip_row_count = $this->db2->query("SELECT id FROM  trn_rip_header WHERE ponumber='".$this->db->escape($data['vinvoiceno'])."'")->row;	
						
						if(count($rip_row_count) > 0)
						{
							$sql_rip= "UPDATE trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '" . (($this->db->escape($riptotalamount)) - (receivedtotalamt)) . "',SID = '" . (int)($this->session->data['sid'])."' WHERE id='".$rip_row_count['id']."'";
							$this->db2->query($sql_rip);
							
						}else{
							if($riptotalamount > 0)
							{
								$sql_rip= "INSERT INTO trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '" . $this->db->escape($riptotalamount) . "',SID = '" . (int)($this->session->data['sid'])."'";
								$this->db2->query($sql_rip);
							}
						}							
                    }
                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage().'1'; 
                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage().'2'; 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage().'3'; 
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
        $not_updated_items = array();
        
        //Adarsh: get the store id
        $get_store_id = $this->db2->query("SELECT SID FROM mst_store")->row;
        

        if(isset($data['items']) && count($data['items']) > 0){

            if($data['receive_po'] == 'POtoWarehouse'){
                $ordertype = 'POtoWarehouse';
            }else{
                $ordertype = 'PO';
            }

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
                $this->editPurchaseOrder($data,$close,$ordertype);
                $trn_purchaseorder_id = $data['ipoid'];
            }else{
                $query_vinvoiceno = $this->db2->query("SELECT vinvoiceno FROM trn_purchaseorder WHERE vinvoiceno='". $data['vinvoiceno'] ."'")->rows;
                    if(count($query_vinvoiceno) > 0){
                        $error['error'] = 'Invoice Already Exist';
                        return $error;
                    }
                    $close = 'Close';
                    $purchase_order_id = $this->addPurchaseOrder($data,$close,$ordertype);
                    $trn_purchaseorder_id = $purchase_order_id['ipoid'];
            }

            foreach ($data['items'] as $key => $item) {
                
                try {
                    
                    // update in mst_itemvendor table
                    if(isset($item['vvendoritemcode']) && $item['vvendoritemcode'] != '' && strlen(trim($item['vvendoritemcode'])) > 0){
                        
                        $itemvendor_exist = $this->db2->query("SELECT * FROM  mst_itemvendor WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' AND ivendorid='" . (int)$this->db->escape($data['vvendorid']) . "' AND vvendoritemcode='". $this->db->escape($item['vvendoritemcode']) ."' ")->rows;

                        if(count($itemvendor_exist) > 0){
                            $this->db2->query("UPDATE mst_itemvendor SET vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' AND ivendorid='" . (int)$this->db->escape($data['vvendorid']) . "'");
                        }else{
                            $this->db2->query("INSERT INTO mst_itemvendor SET  iitemid = '" . (int)$this->db->escape($item['vitemid']) . "',ivendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',vvendoritemcode = '" . $this->db->escape($item['vvendoritemcode']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                    }
                    
                    // update in mst_itemvendor table
                    $current_item = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;
    
                    $total_cost = $item['nordextprice'] + ($current_item['iqtyonhand'] * $current_item['nunitcost']);

                    if($data['receive_po'] == 'POtoWarehouse'){
                        $total_qty = $current_item['iqtyonhand'];
                    }else{
                        $total_qty = $current_item['iqtyonhand'] + $item['itotalunit'];
                    }

                    if($total_qty == 0 || $total_qty == '0'){
                        $new_nunitcost = $total_cost;
                    }else{
                        $new_nunitcost = $total_cost / $total_qty;
                    }

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

                    if((isset($item['nunitcost']) && isset($current_item['nunitcost']) && isset($item['nordextprice'])) && $item['nunitcost'] != $current_item['nunitcost'] && $item['nunitcost'] > 0 && $item['nordextprice'] > 0){
                        $new_nunitcost = $new_nunitcost;
                        $new_dcostprice = $new_dcostprice;
                    }else{
                        $new_nunitcost = $current_item['nunitcost'];
                        $new_dcostprice = $current_item['dcostprice'];
                    }

                    //update dcostprice,npack and nunitcost
                    if(count($current_item) > 0 && $data['receive_po'] == 'receivetostore'){
                        if($current_item['isparentchild'] == 1){
                            // $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '0',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                            
                            
                            
                            $get_purchase_details = $this->db2->query("SELECT nunitcost FROM trn_purchaseorderdetail WHERE vitemid='". (int)$value['iitemid'] ."' ORDER BY LastUpdate DESC LIMIT 2")->rows;
                
                            if(count($get_purchase_details) == 2){
                                $new_costprice = $get_purchase_details[1]['nunitcost'];
                            } else {
                                $new_costprice = $get_purchase_details[0]['nunitcost'];
                            }
                            
                            //============================================= New query to insert last cost ======================================================================
                            if($get_store_id['SID'] == 1083){
                                $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '0',nunitcost = '" . $new_nunitcost . "',last_costprice='" . $current_item['nunitcost'] . "',new_costprice= '". $new_costprice ."' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                            } else {
                                $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '0',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                            }
                            
                            
                            

                            //trn_itempricecosthistory

                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $item['vitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'POQOH', noldamt = '" . $this->db->escape($current_item['iqtyonhand']) . "', nnewamt = '0', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                                if($current_item['dcostprice'] != $new_dcostprice){
                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $item['vitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'POCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $new_dcostprice . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }

                            //trn_itempricecosthistory

                            //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $current_item;
                                unset($old_item_values['itemimage']);

                                $x_general = new stdClass();
                                $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                $x_general->is_child = 'Yes';
                                $x_general->parentmasterid = $old_item_values['parentmasterid'];
                                $x_general->current_po_item_values = $item;
                                $x_general->old_item_values = $old_item_values;
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($item['vitemid']) ."' ")->row;
                                unset($new_item_values['itemimage']);

                                $x_general->new_item_values = $new_item_values;

                                $x_general = addslashes(json_encode($x_general));
                                try{

                                $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $item['vitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($current_item['iqtyonhand']) . "', newamount = '0', general = '" . $x_general . "', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                      $this->log->write($e);
                                }
                                }
                            //trn_webadmin_history

                            //email
                            $check_item_qoh1 = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;
                            if($check_item_qoh1['iqtyonhand'] != 0){
                                $not_updated_items[] = 'iitemid[child]:'. $item['vitemid'] .' previous:'.$current_item['iqtyonhand'].'  new:0';
                            }
                            //email

                            //trn_itempricecosthistory

                                $parent_item = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($current_item['parentmasterid']) . "'")->row;
                                
                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $parent_item['iitemid'] . "',vbarcode = '" . $this->db->escape($parent_item['vbarcode']) . "', vtype = 'POQOH', noldamt = '" . $this->db->escape($parent_item['iqtyonhand']) . "', nnewamt = '". ($this->db->escape($parent_item['iqtyonhand']) + $total_qty) ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                            //trn_itempricecosthistory

                            //trn_webadmin_history
                                if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $parent_item;
                                unset($old_item_values['itemimage']);

                                $x_general = new stdClass();
                                $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                $x_general->is_parent = 'Yes';
                                $x_general->current_po_item_values = $item;
                                $x_general->old_item_values = $old_item_values;

                                try{

                                $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $parent_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($parent_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($parent_item['iqtyonhand']) . "', newamount = '". ($this->db->escape($parent_item['iqtyonhand']) + $total_qty) ."', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                      $this->log->write($e);
                                }
                                $trn_webadmin_history_last_id = $this->db2->getLastId();
                                }
                            //trn_webadmin_history
                                
                            $this->db2->query("UPDATE mst_item SET iqtyonhand = iqtyonhand+'" . $total_qty . "' WHERE iitemid='" . (int)$this->db->escape($current_item['parentmasterid']) . "' ");

                            //trn_webadmin_history
                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                            $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($current_item['parentmasterid']) ."' ")->row;
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

                            //email
                            $check_item_qoh = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($current_item['parentmasterid']) . "'")->row;
                            if(($this->db->escape($parent_item['iqtyonhand']) + $total_qty) != $check_item_qoh['iqtyonhand']){
                                $not_updated_items[] = 'iitemid[parent]:'. $current_item['parentmasterid'] .' previous:'.$parent_item['iqtyonhand'].'  new:'.($this->db->escape($parent_item['iqtyonhand']) + $total_qty);
                            }
                            //email

                        }else{
                            //Original query: Disabled
                            //$this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '" . $total_qty . "',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");

                            //=============================== New query to insert last cost: Written by Adarsh --- Starts ==========================================================
                            $get_purchase_details = $this->db2->query("SELECT nunitcost FROM trn_purchaseorderdetail WHERE vitemid='". (int)$this->db->escape($item['vitemid']) ."' ORDER BY LastUpdate DESC LIMIT 2")->rows;
                
                            $new_costprice = (count($get_purchase_details)>0)?$get_purchase_details[0]['nunitcost']:0.00;
                            
                            if($get_store_id['SID'] == 1083){ 
                               $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '".$total_qty."',nunitcost = '" . $new_nunitcost . "',last_costprice='" . $current_item['nunitcost'] . "',new_costprice= '". $new_costprice ."' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                            } else {
                               $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '".$total_qty."',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                            }
                            //============================== New query to insert last cost: Written by Adarsh --- Ends ============================================================

                            $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $current_item['iitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'POQOH', noldamt = '" . $this->db->escape($current_item['iqtyonhand']) . "', nnewamt = '". $total_qty ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");

                            if($current_item['dcostprice'] != $new_dcostprice){
                                $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $current_item['iitemid'] . "',vbarcode = '" . $this->db->escape($current_item['vbarcode']) . "', vtype = 'POCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '". $new_dcostprice ."', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                            }

                            //trn_webadmin_history
                            if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                $old_item_values = $current_item;
                                unset($old_item_values['itemimage']);

                                $x_general = new stdClass();
                                $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                $x_general->current_po_item_values = $item;
                                $x_general->old_item_values = $old_item_values;
                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($current_item['iitemid']) ."' ")->row;
                                unset($new_item_values['itemimage']);
                                $x_general->new_item_values = $new_item_values;
                                $x_general = addslashes(json_encode($x_general));
                                try{

                                $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $current_item['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($current_item['vbarcode']) . "', type = 'QOH', oldamount = '" . $this->db->escape($current_item['iqtyonhand']) . "', newamount = '". $total_qty ."', general = '" . $x_general . "', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                }
                                catch (Exception $e) {
                                      $this->log->write($e);
                                }
                            }
                            //trn_webadmin_history

                            //email
                            $check_item_qoh = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;
                            if($total_qty != $check_item_qoh['iqtyonhand']){
                                $not_updated_items[] = 'iitemid:'. $item['vitemid'] .'  previous:'.$current_item['iqtyonhand'].'  new:'.$total_qty;
                            }
                            //email

                        }

                    }else{
                        $this->db2->query("UPDATE mst_item SET dcostprice = '" . $new_dcostprice . "',npack = '" . $npack . "',iqtyonhand = '" . $total_qty . "',nunitcost = '" . $new_nunitcost . "' WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "' ");
                    }
                    
                    //update dcostprice,npack and nunitcost

                    //update child item dcostprice,npack and nunitcost
                    $isParentCheck = $this->db2->query("SELECT * FROM  mst_item WHERE iitemid='" . (int)$this->db->escape($item['vitemid']) . "'")->row;

                    if((count($isParentCheck) > 0) && ($isParentCheck['isparentchild'] == 2)){
                        $child_items = $this->db2->query("SELECT `iitemid`,`dcostprice` FROM mst_item WHERE parentmasterid= '". (int)$this->db->escape($item['vitemid']) ."' ")->rows;

                        if(count($child_items) > 0){
                            foreach($child_items as $chi_item){

                                $old_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;

                                $this->db2->query("UPDATE mst_item SET dcostprice=npack*
                                    '". $this->db->escape($isParentCheck['nunitcost']) ."',nunitcost='". $this->db->escape($isParentCheck['nunitcost']) ."' WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."'");
                                //trn_itempricecosthistory
                                $new_update_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$chi_item['iitemid'] ."' ")->row;
                                if($chi_item['dcostprice'] != $new_update_values['dcostprice']){

                                    $this->db2->query("INSERT INTO trn_itempricecosthistory SET  iitemid = '" . $new_update_values['iitemid'] . "',vbarcode = '" . $this->db->escape($new_update_values['vbarcode']) . "', vtype = 'POCost', noldamt = '" . $this->db->escape($current_item['dcostprice']) . "', nnewamt = '" . $this->db->escape($new_update_values['dcostprice']) . "', iuserid = '" . $this->session->data['user_id'] . "', dhistorydate = CURDATE(), thistorytime = CURTIME(),SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                //trn_itempricecosthistory

                                $new_item_values = $this->db2->query("SELECT * FROM mst_item WHERE iitemid= '". (int)$this->db->escape($chi_item['iitemid']) ."' ")->row;

                                if($old_item_values['dcostprice'] != $new_item_values['dcostprice']){

                                    unset($old_item_values['itemimage']);
                                    unset($new_item_values['itemimage']);
                                    $x_general = new stdClass();
                                    $x_general->trn_purchaseorder_id = $trn_purchaseorder_id;
                                    $x_general->is_child = 'Yes';
                                    $x_general->parentmasterid = $new_item_values['parentmasterid'];
                                    $x_general->current_po_item_values = $item;
                                    $x_general->old_item_values = $old_item_values;
                                    $x_general->new_item_values = $new_item_values;

                                    $x_general = addslashes(json_encode($x_general));
                                    if($this->db2->query(" SHOW tables LIKE 'trn_webadmin_history'")->num_rows){
                                        try{

                                    $this->db2->query("INSERT INTO trn_webadmin_history SET  itemid = '" . $new_item_values['iitemid'] . "',userid = '" . $this->session->data['user_id'] . "',barcode = '" . $this->db->escape($new_item_values['vbarcode']) . "', type = 'Cost', oldamount = '" . $this->db->escape($old_item_values['dcostprice']) . "', newamount = '". $this->db->escape($new_item_values['dcostprice']) ."', general = '" . $x_general . "', source = 'PO', historydatetime = NOW(),SID = '" . (int)($this->session->data['sid'])."'");
                                        }
                                        catch (Exception $e) {
                                            $this->log->write($e);
                                        }
                                    }
                                }
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

                    //POtoWarehouse order type
                    if($data['receive_po'] == 'POtoWarehouse'){

                        $trn_data = $this->db2->query("SELECT * FROM trn_warehouseitems WHERE vvendorid='" .$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['receive_po']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "' AND invoiceid='" .$this->db->escape($data['vinvoiceno']). "'")->row;
                       
                        $new_dreceivedate = date("Y-m-d", strtotime($data['dreceiveddate']));

                        if(count($trn_data) > 0){
                            $this->db2->query("UPDATE trn_warehouseitems SET  vwhcode = 'WH101', vitemname = '" . $this->db->escape($item['vitemname']) . "', dreceivedate = '" . $this->db->escape($new_dreceivedate) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = 'Open', vvendortype = 'Vendor', ntransferqty = '" . $this->db->escape($item['itotalunit']) . "', vsize = '" . $this->db->escape($item['vsize']) . "' WHERE vvendorid='" .$this->db->escape($data['vvendorid']). "' AND vtransfertype='" .$this->db->escape($data['receive_po']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "' AND invoiceid='" .$this->db->escape($data['vinvoiceno']). "' ");
                        }else{
                            $this->db2->query("INSERT INTO trn_warehouseitems SET  vwhcode = 'WH101',`invoiceid` = '" . $this->db->escape($data['vinvoiceno']) . "', vvendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`dreceivedate` = '" . $this->db->escape($new_dreceivedate) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', vitemname = '" . $this->db->escape($item['vitemname']) . "', nitemqoh = '" . $this->db->escape($item['nitemqoh']) . "', npackqty = '" . $this->db->escape($item['npackqty']) . "', estatus = 'Open', vvendortype = 'Vendor', vtransfertype = '" . $this->db->escape($data['receive_po']) . "', ntransferqty = '" . $this->db->escape($item['itotalunit']) . "', vsize = '" . $this->db->escape($item['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }

                        $trn_qoh_data = $this->db2->query("SELECT * FROM trn_warehouseqoh WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'")->row;

                        if($item['nordqty'] != '0.00' || $item['nordqty'] != '0'){
                            if(count($trn_qoh_data) > 0){
                                $this->db2->query("UPDATE trn_warehouseqoh SET  npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty =onhandcaseqty + '" . $this->db->escape($item['nordqty']) . "' WHERE ivendorid='" .(int)$this->db->escape($data['vvendorid']). "' AND vbarcode='" .$this->db->escape($item['vbarcode']). "'");
                            }else{
                                $this->db2->query("INSERT INTO trn_warehouseqoh SET  ivendorid = '" . (int)$this->db->escape($data['vvendorid']) . "',`vbarcode` = '" . $this->db->escape($item['vbarcode']) . "', npack = '" . $this->db->escape($item['npackqty']) . "', onhandcaseqty = '" . $this->db->escape($item['nordqty']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                            }
                        }

                    }
                    //POtoWarehouse order type

                }
                catch (MySQLDuplicateKeyException $e) {
                    // duplicate entry exception
                   $error['error'] = $e->getMessage();

                    //email
                    $not_updated_items[] = 'iitemid:'. $item['vitemid'] .'  Error:'.$e->getMessage();
                    //email

                    return $error; 
                }
                catch (MySQLException $e) {
                    // other mysql exception (not duplicate key entry)
                    
                    $error['error'] = $e->getMessage();
                    //email
                    $not_updated_items[] = 'iitemid:'. $item['vitemid'] .'  Error:'.$e->getMessage();
                    //email 
                    return $error; 
                }
                catch (Exception $e) {
                    // not a MySQL exception
                   
                    $error['error'] = $e->getMessage();
                    //email
                    $not_updated_items[] = 'iitemid:'. $item['vitemid'] .'  Error:'.$e->getMessage();
                    //email 
                    return $error; 
                }
            }

            //email

                if(count($not_updated_items) > 0){
                    $send_arr = array();
                    $send_arr['store_id'] = $this->session->data['sid'];

                    if(isset($data['ipoid'])){
                        $send_arr['PO_id'] = $data['ipoid'];
                    }else{
                        $po_last_id = $this->db2->query("SELECT ipoid FROM trn_purchaseorder ORDER BY ipoid DESC")->row;
                        $send_arr['PO_id'] = $po_last_id['ipoid'];
                    }

                    $send_arr['items'] = $not_updated_items;

                    //$to = "samaj.patel@gmail.com,mehul@dhvitiinfotech.com";
                    $to = "adarsh.s.chacko@gmail.com";
                    $subject = "Store [".$this->session->data['sid']."] PO Issue";
                   
                    $message = "<br>";
                    $message .= "<b>Details</b>";
                    $message .= "<br>";
                    $message .= "<pre>".print_r($send_arr,true);   
                   
                    $header = "From:sales@pos2020.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                   
                    $retval = mail ($to,$subject,$message,$header);
                }

            //email

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

    public function getMissingItems($data = array()) {
        $sql = "SELECT * FROM mst_missingitem as mm, trn_purchaseorder as tp WHERE mm.iinvoiceid=tp.ipoid ORDER BY mm.imitemid DESC";

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function importMissingItems($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && count($data) > 0){

            try {
                foreach ($data as $key => $value) {

                    $miss_i = $this->db2->query("SELECT * FROM mst_missingitem WHERE imitemid= '". $value ."'")->row;

                    if(count($miss_i) > 0){

                        $miss_items = $this->db2->query("SELECT * FROM mst_missingitem WHERE vbarcode= '". $miss_i['vbarcode'] ."'")->rows;

                        if(count($miss_items) > 0){

                            foreach ($miss_items as $key => $miss_item) {
                                
                                $vbarcode = $miss_item['vbarcode'];

                                $query1 = $this->db2->query("SELECT * FROM mst_itemalias WHERE valiassku= '". $vbarcode ."'")->row;

                                if(count($query1) == 0){
                                    $query1 = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode= '". $vbarcode ."'")->row;
                                }

                                if(count($query1) <= 0){

                                    //insert mst item
                                    $this->db2->query("INSERT INTO mst_item SET  vbarcode = '" . $this->db->escape($miss_item['vbarcode']) . "',vitemname = '" . $this->db->escape($miss_item['vitemname']) . "',vitemcode = '" . $this->db->escape($miss_item['vitemcode']) . "',vitemtype = '" . $this->db->escape($miss_item['vitemtype']) . "',vunitcode = '" . $this->db->escape($miss_item['vunitcode']) . "',vtax1 = '" . $this->db->escape($miss_item['vtax1']) . "',vcategorycode = '" . $this->db->escape($miss_item['vcatcode']) . "',vdepcode = '" . $this->db->escape($miss_item['vdepcode']) . "',vsuppliercode = '" . $this->db->escape($miss_item['vsuppcode']) . "',dunitprice = '" . $this->db->escape($miss_item['dunitprice']) . "',dcostprice = '" . $this->db->escape($miss_item['dcostprice']) . "',nunitcost = '" . $this->db->escape($miss_item['nunitcost']) . "',nsellunit = '" . $this->db->escape($miss_item['nsellunit']) . "',npack = '" . $this->db->escape($miss_item['npack']) . "',nonorderqty = '" . $this->db->escape($miss_item['norderqty']) . "',estatus = 'Active', SID = '" . (int)($this->session->data['sid']) . "'");

                                    $last_iitemid = $this->db2->getLastId();
                                    //insert mst item

                                    //insert vendor item code
                                    $dtI = $this->db2->query("SELECT * FROM mst_itemvendor WHERE vvendoritemcode='". $miss_item['vvendoritemcode'] ."'")->row;
                                    if(count($dtI) == 0){
                                        $mstItemVendorDto = array();
                                        $mstItemVendorDto['iitemid'] = $last_iitemid;
                                        $mstItemVendorDto['ivendorid'] = $miss_item['vsuppcode'];
                                        $mstItemVendorDto['vvendoritemcode'] = $miss_item['vvendoritemcode'];

                                        $this->db2->query("INSERT INTO mst_itemvendor SET  iitemid = '" . (int)$this->db->escape($mstItemVendorDto['iitemid']) . "',`ivendorid` = '" . (int)$this->db->escape($mstItemVendorDto['ivendorid']) . "',`vvendoritemcode` = '" . $this->db->escape($mstItemVendorDto['vvendoritemcode']) . "', SID = '" . (int)($this->session->data['sid']) . "'");
                                    }
                                    //insert vendor item code

                                }

                                //insert trn purchaseorderdetail
                                $trnPurchaseOrderDetaildto = array();
                                $trnPurchaseOrderDetaildto['npackqty'] = (int)$miss_item['npack'];
                                $trnPurchaseOrderDetaildto['vbarcode'] = $miss_item['vbarcode'];

                                $trnPurchaseOrderDetaildto['ipoid'] = (int)$miss_item['iinvoiceid'];
                                $trnPurchaseOrderDetaildto['vitemid'] = (string)$last_iitemid;
                                $trnPurchaseOrderDetaildto['vitemname'] = $miss_item['vitemname'];
                                $trnPurchaseOrderDetaildto['vunitname'] = "Each";
                                $trnPurchaseOrderDetaildto['nordqty'] = $miss_item['norderqty'];

                                $nCost = $miss_item['dcostprice'];
                                $unitcost = $miss_item['nunitcost'];
                                $itotalunit = (int)$miss_item['norderqty'] * (int)$miss_item['npack'];
                                $totAmt = (int)$miss_item['norderqty'] * $nCost;

                                $trnPurchaseOrderDetaildto['nordunitprice'] = $nCost;
                                $trnPurchaseOrderDetaildto['nordextprice'] = $totAmt;
                                $trnPurchaseOrderDetaildto['nordtax'] = 0;
                                $trnPurchaseOrderDetaildto['nordtextprice'] = 0;
                                $trnPurchaseOrderDetaildto['vvendoritemcode'] = (string)$miss_item['vvendoritemcode'];
                                $trnPurchaseOrderDetaildto['nunitcost'] = $unitcost;

                                $trnPurchaseOrderDetaildto['itotalunit'] = (int)$itotalunit;
                                $trnPurchaseOrderDetaildto['vsize'] = "";

                                $exist_po = $this->db2->query("SELECT * FROM trn_purchaseorder WHERE ipoid='". (int)$this->db->escape($trnPurchaseOrderDetaildto['ipoid']) ."'")->row;

                                if(count($exist_po) > 0 && $exist_po['estatus'] != 'Close'){

                                    $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$this->db->escape($trnPurchaseOrderDetaildto['ipoid']) . "',vitemid = '" . $this->db->escape($trnPurchaseOrderDetaildto['vitemid']) . "',npackqty = '" . $this->db->escape($trnPurchaseOrderDetaildto['npackqty']) . "',vbarcode = '" . $this->db->escape($trnPurchaseOrderDetaildto['vbarcode']) . "',vitemname = '" . $this->db->escape($trnPurchaseOrderDetaildto['vitemname']) . "',vunitname = '" . $this->db->escape($trnPurchaseOrderDetaildto['vunitname']) . "',nordqty = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordqty']) . "',nordunitprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordunitprice']) . "',nordextprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordextprice']) . "',nordtax = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordtax']) . "',nordtextprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordtextprice']) . "',vvendoritemcode = '" . $this->db->escape($trnPurchaseOrderDetaildto['vvendoritemcode']) . "',nunitcost = '" . $this->db->escape($trnPurchaseOrderDetaildto['nunitcost']) . "',itotalunit = '" . $this->db->escape($trnPurchaseOrderDetaildto['itotalunit']) . "',vsize = '" . $this->db->escape($trnPurchaseOrderDetaildto['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                                }

                                //insert trn purchaseorderdetail


                                //delete item from missing item table
                                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_missingitem',`Action` = 'delete',`TableId` = '" . (int)$miss_item['imitemid'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                                    $this->db2->query("DELETE FROM mst_missingitem WHERE imitemid='" . (int)$miss_item['imitemid'] . "'");
                                //delete item from missing item table

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
        $success['success'] = 'Successfully Imported Missing Items';
        return $success;
    }

    public function getSearchItemHistory($search_item,$ivendorid,$pre_items_id) {

        if(count($pre_items_id) > 0){
            $pre_items_id = implode(',', $pre_items_id);
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM mst_item mi WHERE (mi.vitemname LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vsize LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dcostprice LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dunitprice LIKE  '%" .$this->db->escape($search_item). "%') AND mi.iitemid NOT IN($pre_items_id) AND mi.vsuppliercode='". $ivendorid ."' AND mi.estatus='Active'");
        }else{
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM mst_item mi WHERE (mi.vitemname LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vsize LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dcostprice LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dunitprice LIKE  '%" .$this->db->escape($search_item). "%') AND mi.vsuppliercode='". $ivendorid ."' AND mi.estatus='Active'");
        }
        
        return $query->rows;
    }

    public function getSearchVendorItemCode($search_item,$ivendorid,$pre_items_id) {
       
        if(count($pre_items_id) > 0){
            $pre_items_id = implode(',', $pre_items_id);
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH, mitv.vvendoritemcode, mitv.ivendorid FROM mst_itemvendor as mitv, mst_item as mi WHERE mitv.iitemid=mi.iitemid AND mitv.vvendoritemcode LIKE  '%" .$this->db->escape($search_item). "%' AND mitv.iitemid NOT IN($pre_items_id) AND mitv.ivendorid='". $ivendorid ."' AND mi.estatus='Active'");
        }else{
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH, mitv.vvendoritemcode,mitv.ivendorid FROM mst_itemvendor as mitv , mst_item as mi WHERE mitv.iitemid=mi.iitemid AND mitv.vvendoritemcode LIKE  '%" .$this->db->escape($search_item). "%' AND mitv.ivendorid='". $ivendorid ."' AND mi.estatus='Active'");
        }
        
        return $query->rows;
    }

    public function getSearchItemData($iitemid,$radio_search_by=null,$vitemcode,$start_date = null,$end_date = null) {
        
        if($radio_search_by == 'pre_month'){
            $end_date = date('Y-m-d');
            $start_date = date("Y-m-d", strtotime("-1 month"));
        }else if($radio_search_by == 'pre_quarter'){
            $end_date = date('Y-m-d');
            $start_date = date("Y-m-d", strtotime("-6 month"));
        }else if($radio_search_by == 'pre_year'){
            $end_date = date('Y-m-d');
            $start_date = date("Y-m-d", strtotime("-1 year"));
        }else if($radio_search_by == 'pre_ytd'){
            $end_date = date('Y-m-d');
            $start_date = date("Y-m-d", strtotime("-1 year"));
        }else if(!empty($start_date) && !empty($end_date)){
            $start_date = DateTime::createFromFormat('m-d-Y', $start_date);
            $start_date = $start_date->format('Y-m-d');

            $end_date = DateTime::createFromFormat('m-d-Y', $end_date);
            $end_date = $end_date->format('Y-m-d');
        }else{
            $end_date = date('Y-m-d');
            $start_date = date("Y-m-d", strtotime("-1 week"));
        }
        
        $return = array();

        if($radio_search_by == 'pre_ytd'){
            $query = $this->db2->query("SELECT ifnull(SUM(tsd.ndebitqty),0) as items_sold,ifnull(SUM(tsd.nextunitprice),0) as total_selling_price FROM trn_salesdetail tsd LEFT JOIN trn_sales ts ON (tsd.isalesid = ts.isalesid) WHERE tsd.vitemcode='". $vitemcode ."'");
            $return['item_detail'] = $query->row;

            $query1 = $this->db2->query("SELECT tp.vvendorname as vvendorname, tpd.nunitcost as nunitcost, ifnull(SUM(tpd.nordextprice),0) as total_cost_price, date_format(tp.dcreatedate,'%m-%d-%Y') as purchase_date, ifnull(SUM(tpd.itotalunit),0) as total_quantity, DATE_FORMAT(tp.dcreatedate,'%M, %Y') as month_year FROM trn_purchaseorderdetail tpd LEFT JOIN trn_purchaseorder tp ON (tpd.ipoid = tp.ipoid) WHERE tpd.vitemid='". $iitemid ."' GROUP BY tp.vvendorname, date_format(tp.dcreatedate,'%m-%d-%Y')");

            $temp_datas = $query1->rows;

            if(count($temp_datas) > 0){
                $temp = array();
                foreach ($temp_datas as $key => $temp_data) {
                    if(array_key_exists($temp_data['month_year'],$temp)){
                        $temp[$temp_data['month_year']][] = $temp_data;
                    }else{
                        $temp[$temp_data['month_year']][] = $temp_data;
                    }
                }

                $temp_datas = $temp;
            }

            $return['purchase_items'] = $temp_datas;

        }else{
            $query = $this->db2->query("SELECT ifnull(SUM(tsd.ndebitqty),0) as items_sold,ifnull(SUM(tsd.nextunitprice),0) as total_selling_price FROM trn_salesdetail tsd LEFT JOIN trn_sales ts ON (tsd.isalesid = ts.isalesid) WHERE tsd.vitemcode='". $vitemcode ."' AND (date_format(ts.dtrandate,'%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."') ");
            $return['item_detail'] = $query->row;

            $query1 = $this->db2->query("SELECT tp.vvendorname as vvendorname, tpd.nunitcost as nunitcost, ifnull(SUM(tpd.nordextprice),0) as total_cost_price,date_format(tp.dcreatedate,'%m-%d-%Y') as purchase_date, ifnull(SUM(tpd.itotalunit),0) as total_quantity  FROM trn_purchaseorderdetail tpd LEFT JOIN trn_purchaseorder tp ON (tpd.ipoid = tp.ipoid) WHERE tpd.vitemid='". $iitemid ."' AND (date_format(tp.dcreatedate,'%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."') GROUP BY tp.vvendorname, date_format(tp.dcreatedate,'%m-%d-%Y')");

            $return['purchase_items'] = $query1->rows;
        }

        return $return;

    }

    public function updateBarcode($vCode,$old_vCode) {

        //mst_item
        $this->db2->query("UPDATE mst_item SET vitemcode = '" . $this->db->escape($vCode) . "', vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //mst_item

        //mst_itemalias
        $this->db2->query("UPDATE mst_itemalias SET vitemcode = '" . $this->db->escape($vCode) . "', vsku = '" . $this->db->escape($vCode) . "' WHERE vsku= '". $this->db->escape($old_vCode) ."'");
        //mst_itemalias

        //mst_itempackdetail
        $this->db2->query("UPDATE mst_itempackdetail SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //mst_itempackdetail

        //trn_quickitem
        $this->db2->query("UPDATE trn_quickitem SET vitemcode = '" . $this->db->escape($vCode) . "' WHERE vitemcode= '". $this->db->escape($old_vCode) ."'");
        //trn_quickitem

        //itemgroupdetail
        $this->db2->query("UPDATE itemgroupdetail SET vsku = '" . $this->db->escape($vCode) . "' WHERE vsku= '". $this->db->escape($old_vCode) ."'");
        //itemgroupdetail

        //mst_itemslabprice
        $this->db2->query("UPDATE mst_itemslabprice SET vsku = '" . $this->db->escape($vCode) . "' WHERE vsku= '". $this->db->escape($old_vCode) ."'");
        //mst_itemslabprice

        //trn_salesdetail
        $this->db2->query("UPDATE trn_salesdetail SET vitemcode = '" . $this->db->escape($vCode) . "' WHERE vitemcode= '". $this->db->escape($old_vCode) ."'");
        //trn_salesdetail

        //trn_purchaseorderdetail
        $this->db2->query("UPDATE trn_purchaseorderdetail SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //trn_purchaseorderdetail

        //trn_physicalinventorydetail
        $this->db2->query("UPDATE trn_physicalinventorydetail SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //trn_physicalinventorydetail

        //trn_warehouseitems
        $this->db2->query("UPDATE trn_warehouseitems SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //trn_warehouseitems

        //trn_warehouseqoh
        $this->db2->query("UPDATE trn_warehouseqoh SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //trn_warehouseqoh

        //trn_itempricecosthistory
        $this->db2->query("UPDATE trn_itempricecosthistory SET vbarcode = '" . $this->db->escape($vCode) . "' WHERE vbarcode= '". $this->db->escape($old_vCode) ."'");
        //trn_itempricecosthistory

        //trn_holditem
        $this->db2->query("UPDATE trn_holditem SET vitemcode = '" . $this->db->escape($vCode) . "' WHERE vitemcode= '". $this->db->escape($old_vCode) ."'");
        //trn_holditem

        //trn_salepricedetail
        $this->db2->query("UPDATE trn_salepricedetail SET vitemcode = '" . $this->db->escape($vCode) . "' WHERE vitemcode= '". $this->db->escape($old_vCode) ."'");
        //trn_salepricedetail
    }

    public function getVendorItemData($isupplierid) {

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, mi.iqtyonhand, mi.ireorderpoint, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then mi.iqtyonhand-mi.ireorderpoint WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then mi.ireorderpoint-mi.iqtyonhand else 0 end as case_qty, case WHEN (mi.iqtyonhand <= 0 and mi.ireorderpoint <=0 or mi.ireorderpoint=null) then 0 WHEN (mi.iqtyonhand<=0 and mi.ireorderpoint > 0 or mi.ireorderpoint!=null) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint else cast(((mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand > mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>0 and mi.ireorderpoint >= 0 and mi.iqtyonhand > mi.ireorderpoint) then  (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.iqtyonhand-mi.ireorderpoint else cast(((mi.iqtyonhand-mi.ireorderpoint)/mi.npack ) as signed) end) WHEN (mi.iqtyonhand>=0 and mi.ireorderpoint > 0 and mi.iqtyonhand < mi.ireorderpoint) then (CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint-mi.iqtyonhand else cast(((mi.ireorderpoint-mi.iqtyonhand)/mi.npack ) as signed) end) else 0 end as total_case_qty, miv.ivendorid, miv.vvendoritemcode, mu.vunitname FROM mst_item mi LEFT JOIN mst_itemvendor miv ON (mi.iitemid = miv.iitemid AND mi.vsuppliercode = miv.ivendorid) LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.estatus='Active' AND mi.vsuppliercode='". $isupplierid ."' AND mi.ireorderpoint > mi.iqtyonhand AND mi.ireorderpoint > 0")->rows;

        return $query;
    }

    public function deletePurchaseOrder($data) {
        
        if(isset($data) && count($data) > 0){

            foreach ($data as $key => $value) {
                $trn_purchaseorder = $this->db2->query("SELECT * FROM trn_purchaseorder WHERE ipoid = '" . $this->db->escape($value) . "'")->row;

                if(count($trn_purchaseorder) > 0){
                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_purchaseorder',`Action` = 'delete',`TableId` = '" . (int)$value . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $trn_purchaseorderdetail = $this->db2->query("SELECT ipodetid FROM trn_purchaseorderdetail WHERE ipoid = '" . $this->db->escape($value) . "'")->rows;

                    if(count($trn_purchaseorderdetail)){
                        foreach ($trn_purchaseorderdetail as $k => $v) {
                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_purchaseorderdetail',`Action` = 'delete',`TableId` = '" . (int)$v['ipodetid'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                            $this->db2->query("DELETE FROM trn_purchaseorderdetail WHERE ipodetid='" . (int)$v['ipodetid'] . "'");
                        }
                    }

                    $this->db2->query("DELETE FROM trn_purchaseorder WHERE ipoid='" . (int)$value . "'");

                }
                
            }  
            
        }

        $return['success'] = 'PO Deleted Successfully';

        return $return;

    }

    public function updateItemStatus($iitemid) {
        
        if(isset($iitemid) && !empty($iitemid)){

            $item_exist = $this->db2->query("SELECT * FROM mst_item WHERE iitemid = '" . (int)$iitemid . "'")->row;

            if(count($item_exist) > 0 && $item_exist['estatus'] == 'Inactive'){
                $this->db2->query("UPDATE mst_item SET  `estatus` = 'Active' WHERE iitemid='". (int)$iitemid ."'");
            }
            
        }

        return true;

    }

    public function getItemByBarCodeCheckDigit($vCode) {
        $query = $this->db2->query("SELECT vbarcode FROM mst_item WHERE vbarcode LIKE  '" .$this->db->escape($vCode). "%'")->rows;

        return $query;
    }

    public function calculate_upc_check_digit($upc_code) {
         $checkDigit = -1; // -1 == failure
         $upc = substr($upc_code,0,11);
         // send in a 11 or 12 digit upc code only
        if (strlen($upc) == 11 && strlen($upc_code) <= 12) { 
            $oddPositions = $upc[0] + $upc[2] + $upc[4] + $upc[6] + $upc[8] + $upc[10]; 
            $oddPositions *= 3; 
            $evenPositions= $upc[1] + $upc[3] + $upc[5] + $upc[7] + $upc[9]; 
            $sumEvenOdd = $oddPositions + $evenPositions; 
            $checkDigit = (10 - ($sumEvenOdd % 10)) % 10; 
        }
        return $checkDigit; 
    }

}
?>