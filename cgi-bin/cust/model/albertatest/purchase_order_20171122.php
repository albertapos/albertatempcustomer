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
        $query1 = $this->db2->query("SELECT tpod.*,mi.iqtyonhand as iqtyonhand,mi.dcostprice as dcostprice, mi.dunitprice as dunitprice,mi.ireorderpoint as ireorderpoint, mi.npack as npack, mi.ireorderpoint - mi.iqtyonhand as case_qty, CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint - mi.iqtyonhand else cast(((mi.ireorderpoint - mi.iqtyonhand)/mi.npack ) as signed)  end as total_case_qty FROM trn_purchaseorderdetail as tpod, mst_item as mi WHERE tpod.vitemid=mi.iitemid AND ipoid='". (int)$ipoid ."'")->rows;

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

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, mi.iqtyonhand, mi.ireorderpoint, mi.ireorderpoint - mi.iqtyonhand as case_qty, CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint - mi.iqtyonhand else cast(((mi.ireorderpoint - mi.iqtyonhand)/mi.npack ) as signed)  end as total_case_qty, miv.ivendorid, miv.vvendoritemcode, mu.vunitname FROM mst_item mi LEFT JOIN mst_itemvendor miv ON (mi.iitemid = miv.iitemid) LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.iitemid='". (int)$iitemid ."' OR (miv.ivendorid='". (int)$ivendorid ."' AND  miv.iitemid='". (int)$iitemid ."' )");

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
							$sql= "INSERT INTO trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '0.00',SID = '" . (int)($this->session->data['sid'])."'";
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
							$sql_rip= "UPDATE trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '0.00',SID = '" . (int)($this->session->data['sid'])."' WHERE id='".$rip_row_count['id']."'";
							$this->db2->query($sql_rip);
							
						}else{
							if($riptotalamount > 0)
							{
								$sql_rip= "INSERT INTO trn_rip_header SET ponumber = '" . $this->db->escape($data['vinvoiceno']) . "', vendorid = '" . $this->db->escape($data['vvendorid']) . "', riptotal = '" . $this->db->escape($riptotalamount) . "', receivedtotalamt = '0.00', pendingtotalamt = '0.00',SID = '" . (int)($this->session->data['sid'])."'";
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

                    $miss_item = $this->db2->query("SELECT * FROM mst_missingitem WHERE imitemid= '". $value ."'")->row;

                    if(count($miss_item) > 0){
                        
                        $vbarcode = $miss_item['vbarcode'];

                        $query1 = $this->db2->query("SELECT * FROM mst_itemalias WHERE valiassku= '". $vbarcode ."'")->row;

                        if(count($query1) == 0){
                            $query1 = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode= '". $vbarcode ."'")->row;
                        }

                        if(count($query1) <= 0){

                            $this->db2->query("INSERT INTO mst_item SET  vbarcode = '" . $this->db->escape($miss_item['vbarcode']) . "',vitemname = '" . $this->db->escape($miss_item['vitemname']) . "',vitemcode = '" . $this->db->escape($miss_item['vitemcode']) . "',vitemtype = '" . $this->db->escape($miss_item['vitemtype']) . "',vunitcode = '" . $this->db->escape($miss_item['vunitcode']) . "',vtax1 = '" . $this->db->escape($miss_item['vtax1']) . "',vcategorycode = '" . $this->db->escape($miss_item['vcatcode']) . "',vdepcode = '" . $this->db->escape($miss_item['vdepcode']) . "',vsuppliercode = '" . $this->db->escape($miss_item['vsuppcode']) . "',dunitprice = '" . $this->db->escape($miss_item['dunitprice']) . "',dcostprice = '" . $this->db->escape($miss_item['dcostprice']) . "',nunitcost = '" . $this->db->escape($miss_item['nunitcost']) . "',nsellunit = '" . $this->db->escape($miss_item['nsellunit']) . "',npack = '" . $this->db->escape($miss_item['npack']) . "',nonorderqty = '" . $this->db->escape($miss_item['norderqty']) . "', SID = '" . (int)($this->session->data['sid']) . "'");

                                $last_iitemid = $this->db2->getLastId();

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

                                $this->db2->query("INSERT INTO trn_purchaseorderdetail SET  ipoid = '" . (int)$this->db->escape($trnPurchaseOrderDetaildto['ipoid']) . "',vitemid = '" . $this->db->escape($trnPurchaseOrderDetaildto['vitemid']) . "',npackqty = '" . $this->db->escape($trnPurchaseOrderDetaildto['npackqty']) . "',vbarcode = '" . $this->db->escape($trnPurchaseOrderDetaildto['vbarcode']) . "',vitemname = '" . $this->db->escape($trnPurchaseOrderDetaildto['vitemname']) . "',vunitname = '" . $this->db->escape($trnPurchaseOrderDetaildto['vunitname']) . "',nordqty = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordqty']) . "',nordunitprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordunitprice']) . "',nordextprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordextprice']) . "',nordtax = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordtax']) . "',nordtextprice = '" . $this->db->escape($trnPurchaseOrderDetaildto['nordtextprice']) . "',vvendoritemcode = '" . $this->db->escape($trnPurchaseOrderDetaildto['vvendoritemcode']) . "',nunitcost = '" . $this->db->escape($trnPurchaseOrderDetaildto['nunitcost']) . "',itotalunit = '" . $this->db->escape($trnPurchaseOrderDetaildto['itotalunit']) . "',vsize = '" . $this->db->escape($trnPurchaseOrderDetaildto['vsize']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                                //insert trn purchaseorderdetail

                                //delete item from missing item table
                                    $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_missingitem',`Action` = 'delete',`TableId` = '" . (int)$miss_item['imitemid'] . "',SID = '" . (int)($this->session->data['sid'])."'");

                                    $this->db2->query("DELETE FROM mst_missingitem WHERE imitemid='" . (int)$miss_item['imitemid'] . "'");
                                //delete item from missing item table
                        }else{
                            $error['error'] = 'Barcode '.$vbarcode.' Already Exist'; 
                            return $error; 
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
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM mst_item mi WHERE (mi.vitemname LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vsize LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dcostprice LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dunitprice LIKE  '%" .$this->db->escape($search_item). "%') AND mi.iitemid NOT IN($pre_items_id)");
        }else{
            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vbarcode,mi.vsize,mi.iqtyonhand,mi.dcostprice,mi.dunitprice,mi.npack,CASE WHEN mi.npack = 1 or (mi.npack is null)   then mi.iqtyonhand else (Concat(cast(((mi.iqtyonhand div mi.npack )) as signed), '  (', Mod(mi.iqtyonhand,mi.npack) ,')') ) end as QOH FROM mst_item mi WHERE (mi.vitemname LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vbarcode LIKE  '%" .$this->db->escape($search_item). "%' OR mi.vsize LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dcostprice LIKE  '%" .$this->db->escape($search_item). "%' OR mi.dunitprice LIKE  '%" .$this->db->escape($search_item). "%')");
        }
        
        return $query->rows;
    }

    public function getSearchItemData($iitemid,$radio_search_by,$vitemcode) {
        
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

        $query = $this->db2->query("SELECT mi.iitemid, mi.vitemcode, mi.vitemname, mi.vunitcode, mi.vbarcode, mi.dcostprice, mi.dunitprice, mi.vsize, mi.npack, mi.iqtyonhand, mi.ireorderpoint, mi.ireorderpoint - mi.iqtyonhand as case_qty, CASE WHEN mi.npack = 1 or (mi.npack is null) then mi.ireorderpoint - mi.iqtyonhand else cast(((mi.ireorderpoint - mi.iqtyonhand)/mi.npack ) as signed)  end as total_case_qty, miv.ivendorid, miv.vvendoritemcode, mu.vunitname FROM mst_item mi LEFT JOIN mst_itemvendor miv ON (mi.iitemid = miv.iitemid) LEFT JOIN mst_unit mu ON (mu.vunitcode = mi.vunitcode) WHERE mi.vsuppliercode='". $isupplierid ."' AND mi.ireorderpoint < mi.iqtyonhand")->rows;

        return $query;
    }

}
?>