<?php
class ModelApiItemsSale extends Model {
    public function getSales() {
        $data = array();

        $sales = $this->db2->query("SELECT * FROM trn_saleprice")->rows;

        if(count($sales)){
            foreach ($sales as $key => $sale) {
                $saledetails = $this->db2->query("SELECT * FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($sale['isalepriceid']) . "'")->rows;
                $data[$key] = $sale;
                $data[$key]['items'] = $saledetails;
            }
        }

        return $data;
    }

    public function getSale($isalepriceid) {
        $data = array();

        $sales = $this->db2->query("SELECT * FROM trn_saleprice WHERE isalepriceid='" . (int)$isalepriceid . "'")->row;

        $saledetails = $this->db2->query("SELECT * FROM trn_salepricedetail WHERE isalepriceid='" . (int)$isalepriceid . "'")->rows;
        $data = $sales;
        $data['items'] = $saledetails;

        return $data;
    }

    public function deleteTemplateProduct($itemplateid, $Id) {
        $success = array();

        $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'mst_templatedetail',`Action` = 'delete',`TableId` = '" . (int)$Id . "',SID = '" . (int)($this->session->data['sid'])."'");

        $itemgroup = $this->db2->query("DELETE FROM mst_templatedetail WHERE itemplateid='" . (int)$itemplateid . "' AND Id='" . (int)$Id . "'");

        $success['success'] = 'Successfully Deleted Template Product';
        return $success;
    
    }

    public function getSaleSearch($search) {
        
        $data = array();

        $sales = $this->db2->query("SELECT * FROM trn_saleprice WHERE vsalename LIKE  '%" .$this->db->escape($search). "%' OR vsaletype LIKE  '%" .$this->db->escape($search). "%'")->rows;

        if(count($sales)){
            foreach ($sales as $key => $sale) {
                $saledetails = $this->db2->query("SELECT * FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($sale['isalepriceid']) . "'")->rows;
                $data[$key] = $sale;
                $data[$key]['items'] = $saledetails;
            }
        }

        return $data;
    }

    public function addSaleItems($data = array()) {
        
        
        /*$file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");
        
        $error_log = "\r\n"."ADD";
        
        $error_log .= "\r\n".json_encode($data);
		
		//$data_row = PHP_EOL.json_encode($error_log);
        
        //fwrite($myfile,$error_log);
        fclose($myfile);*/

        $success =array();
        $error =array();
    
        if(isset($data) && count($data) > 0){

            if(isset($data['dstartdatetime_date']) && $data['dstartdatetime_date'] != ''){
                $start_date = $data['dstartdatetime_date'].' '.$data['dstartdatetime_hour'].':00:00';
                $dstartdatetime = DateTime::createFromFormat('m-d-Y H:i:s', $start_date);
                $dstartdatetime = $dstartdatetime->format('Y-m-d H:i:s');
            }else{
                // $dstartdatetime = 'NULL';
                //So that the start date has the current date as the default value
                $dstartdatetime = date( "Y-m-d H", strtotime( "now" )).':00:00';
            }

            if(isset($data['denddatetime_date']) && $data['denddatetime_date'] != ''){
                $end_date = $data['denddatetime_date'].' '.$data['denddatetime_hour'].':00:00';
                $denddatetime = DateTime::createFromFormat('m-d-Y H:i:s', $end_date);
                $denddatetime = $denddatetime->format('Y-m-d H:i:s');
            }else{
                $denddatetime = 'NULL';
            }

            try {
                $this->db2->query("INSERT INTO trn_saleprice SET  vsalename = '" . $this->db->escape($data['vsalename']) . "',`vsaletype` = '" . $this->db->escape($data['vsaletype']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "',`dstartdatetime` = '" . $dstartdatetime . "',`denddatetime` = '" . $denddatetime . "',`nbuyqty` = '" . $this->db->escape($data['nbuyqty']) . "',`vsaleby` = '" . $this->db->escape($data['vsaleby']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "',SID = '" . (int)($this->session->data['sid'])."'");

                $isalepriceid = $this->db2->getLastId();

                if((isset($data['items'])) && (count($data['items']) > 0) ){
                    
                    foreach ($data['items'] as $k => $v) {


                        $saledetail = $this->db2->query("SELECT * FROM trn_salepricedetail WHERE isalepriceid='" . (int)$isalepriceid . "' AND Id='" . $this->db->escape($v['Id']) . "'")->row;

                        if(count($saledetail) > 0){
                            $this->db2->query("UPDATE trn_salepricedetail SET  vitemcode = '" . $this->db->escape($v['vitemcode']) . "',dunitprice = '" . $this->db->escape($v['dunitprice']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',vunitcode = '" . $this->db->escape($v['vunitcode']) . "',vitemtype = '" . $this->db->escape($v['vitemtype']) . "' WHERE isalepriceid='" . (int)$isalepriceid . "' AND Id='" . $this->db->escape($v['Id']) . "'");
                        }else{

                            $this->db2->query("INSERT INTO trn_salepricedetail SET isalepriceid='" . (int)$isalepriceid . "',vitemcode = '" . $this->db->escape($v['vitemcode']) . "',dunitprice = '" . $this->db->escape($v['dunitprice']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',vunitcode = '" . $this->db->escape($v['vunitcode']) . "',vitemtype = '" . $this->db->escape($v['vitemtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                        
                        //update in mst_item
                        $m_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;
    
                        if(count($m_item) > 0){
                            $this->db2->query("UPDATE mst_item SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nbuyqty = '" . $this->db->escape($data['nbuyqty']) . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                        }
    
                        //update in mst_itempackdetail
                        $m_item_pack = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;
    
                        if(count($m_item_pack) > 0){
                            $this->db2->query("UPDATE mst_itempackdetail SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                        }
                    }

                    /*//update in mst_item
                    $m_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;

                    if(count($m_item) > 0){
                        $this->db2->query("UPDATE mst_item SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nbuyqty = '" . $this->db->escape($data['nbuyqty']) . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                    }

                    //update in mst_itempackdetail
                    $m_item_pack = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;

                    if(count($m_item_pack) > 0){
                        $this->db2->query("UPDATE mst_itempackdetail SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                    }*/

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

        $success['success'] = 'Successfully Added Item Sale';
        return $success;
    }

    public function editlistSaleItems($data = array()) {

        $success =array();
        $error =array();
        
       /* $file_path = DIR_TEMPLATE."/administration/error_log_sql_debug.txt";

        $myfile = fopen( DIR_TEMPLATE."/administration/error_log_sql_debug.txt", "a");
        
        $error_log = "\r\n"."EDIT";
        
        $error_log .= "\r\n".json_encode($data);
		
		//$data_row = PHP_EOL.json_encode($error_log);
        
        fwrite($myfile,$error_log);
        fclose($myfile);*/
        
        
        
    
        if(isset($data) && count($data) > 0){

            if(isset($data['dstartdatetime_date']) && ($data['dstartdatetime_date'] != '')){
                $start_date = $data['dstartdatetime_date'].' '.$data['dstartdatetime_hour'].':00:00';
                $dstartdatetime = DateTime::createFromFormat('m-d-Y H:i:s', $start_date);
                $dstartdatetime = $dstartdatetime->format('Y-m-d H:i:s');
            }else{
                $dstartdatetime = 'NULL';
            }

            if(isset($data['denddatetime_date']) && $data['denddatetime_date'] != ''){
                $end_date = $data['denddatetime_date'].' '.$data['denddatetime_hour'].':00:00';
                $denddatetime = DateTime::createFromFormat('m-d-Y H:i:s', $end_date);
                $denddatetime = $denddatetime->format('Y-m-d H:i:s');
            }else{
                $denddatetime = 'NULL';
            }

            try {
                $this->db2->query("UPDATE trn_saleprice SET  vsalename = '" . $this->db->escape($data['vsalename']) . "',`vsaletype` = '" . $this->db->escape($data['vsaletype']) . "', ndiscountper = '" . $this->db->escape($data['ndiscountper']) . "',`dstartdatetime` = '" . $dstartdatetime . "',`denddatetime` = '" . $denddatetime . "',`nbuyqty` = '" . $this->db->escape($data['nbuyqty']) . "',`vsaleby` = '" . $this->db->escape($data['vsaleby']) . "',`estatus` = '" . $this->db->escape($data['estatus']) . "' WHERE isalepriceid = '" . (int)$this->db->escape($data['isalepriceid']) . "'");

                if((isset($data['items'])) && (count($data['items']) > 0) ){

                    $sale_ids = $this->db2->query("SELECT `Id` FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' ")->rows;

                    if(count($sale_ids) > 0){
                        foreach ($sale_ids as $k => $sale_id) {
                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_salepricedetail',`Action` = 'delete',`TableId` = '" . (int)$sale_id['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                    }

                    $this->db2->query("DELETE FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' ");
                    
                    foreach ($data['items'] as $k => $v) {


                        $saledetail = $this->db2->query("SELECT * FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' AND Id='" . $this->db->escape($v['Id']) . "'")->row;

                        if(count($saledetail) > 0){
                            $this->db2->query("UPDATE trn_salepricedetail SET  vitemcode = '" . $this->db->escape($v['vitemcode']) . "',dunitprice = '" . $this->db->escape($v['dunitprice']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',vunitcode = '" . $this->db->escape($v['vunitcode']) . "',vitemtype = '" . $this->db->escape($v['vitemtype']) . "' WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' AND Id='" . $this->db->escape($v['Id']) . "'");
                        }else{

                            $this->db2->query("INSERT INTO trn_salepricedetail SET isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "',vitemcode = '" . $this->db->escape($v['vitemcode']) . "',dunitprice = '" . $this->db->escape($v['dunitprice']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',vunitcode = '" . $this->db->escape($v['vunitcode']) . "',vitemtype = '" . $this->db->escape($v['vitemtype']) . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                        
                        //update in mst_item
                        $m_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;
    
                        if(count($m_item) > 0){
                            $this->db2->query("UPDATE mst_item SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nbuyqty = '" . $this->db->escape($data['nbuyqty']) . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                        }
    
                        //update in mst_itempackdetail
                        $m_item_pack = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;
    
                        if(count($m_item_pack) > 0){
                            $this->db2->query("UPDATE mst_itempackdetail SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                        }
                    }

                    /*//update in mst_item
                    $m_item = $this->db2->query("SELECT * FROM mst_item WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;

                    if(count($m_item) > 0){
                        $this->db2->query("UPDATE mst_item SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nbuyqty = '" . $this->db->escape($data['nbuyqty']) . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                    }

                    //update in mst_itempackdetail
                    $m_item_pack = $this->db2->query("SELECT * FROM mst_itempackdetail WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'")->row;

                    if(count($m_item_pack) > 0){
                        $this->db2->query("UPDATE mst_itempackdetail SET  vpricetype = '" . $this->db->escape($data['vsaleby']) . "',nsaleprice = '" . $this->db->escape($v['nsaleprice']) . "',dpricestartdatetime = '" . $dstartdatetime . "',dpriceenddatetime = '" . $denddatetime . "',nsalediscountper = '" . $this->db->escape($data['ndiscountper']) . "' WHERE iitemid='" . (int)$this->db->escape($v['iitemid']) . "'");
                    }*/

                    
                }else{
                    $sale_ids = $this->db2->query("SELECT `Id` FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' ")->rows;

                    if(count($sale_ids) > 0){
                        foreach ($sale_ids as $k => $sale_id) {
                            $this->db2->query("INSERT INTO mst_delete_table SET  TableName = 'trn_salepricedetail',`Action` = 'delete',`TableId` = '" . (int)$sale_id['Id'] . "',SID = '" . (int)($this->session->data['sid'])."'");
                        }
                    }

                    $this->db2->query("DELETE FROM trn_salepricedetail WHERE isalepriceid='" . (int)$this->db->escape($data['isalepriceid']) . "' ");
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

        $success['success'] = 'Successfully Updated Item Sale';
        return $success;
    }

    public function getPrevRightItemIds($datas = array()) {

        $return = array();

        if(count($datas) > 0){
            foreach($datas as $data){
            $return[] = $this->db2->query("SELECT iitemid FROM mst_item WHERE vitemcode='" . $this->db->escape($data['vitemcode']) . "' AND estatus='Active'")->row;
            }
        }

        $item_arr = array();
        if(count($return) > 0){
            foreach ($return as  $v) {
                if(isset($v['iitemid'])){
                    $item_arr[] = $v['iitemid'];
                }
            }
        }
        
        return $item_arr;
    }

    public function getEditLeftItems($data = array()) {

        $return = array();

        if(count($data) > 0){

            $item_ids = implode(',', $data);

            $query = $this->db2->query("SELECT iitemid,vitemcode,vitemname,vitemtype,dunitprice,vunitcode FROM mst_item WHERE estatus='Active' AND iitemid NOT IN($item_ids)");
            $return = $query->rows;
        }else{
            $query = $this->db2->query("SELECT iitemid,vitemcode,vitemname,vitemtype,dunitprice FROM mst_item WHERE estatus='Active'");
            $return = $query->rows;
        }
        return $return;
    }

    public function getEditRightItems($data = array(),$isalepriceid) {

        $return = array();
        if(count($data) > 0){

            $item_ids = implode(',', $data);

            $query = $this->db2->query("SELECT mi.iitemid,mi.vitemcode,mi.vitemname,mi.vitemtype,mi.dunitprice,mi.vunitcode,tsd.nsaleprice,tsd.Id FROM mst_item as mi,trn_salepricedetail as tsd WHERE mi.vitemcode=tsd.vitemcode AND tsd.isalepriceid='" . (int)$isalepriceid."' AND mi.iitemid IN($item_ids) AND estatus='Active' ");
            $return = $query->rows;
        }
        return $return;
    }

    public function getRightItems($data = array()) {

        $return = array();

        if(count($data) > 0){

            $item_ids = implode(',', $data);

            $query = $this->db2->query("SELECT iitemid,vitemcode,vitemname,vitemtype,dunitprice,vunitcode FROM mst_item WHERE estatus='Active' AND iitemid IN($item_ids) ");
            $return = $query->rows;
        }else{
            $return['error'] = 'data not found';
        }
        return $return;
    }

    public function getLeftItems($data = array()) {

        $return = array();

        if(count($data) > 0){

            $item_ids = implode(',', $data);

            $query = $this->db2->query("SELECT iitemid,vitemcode,vitemname,vitemtype,dunitprice,vunitcode FROM mst_item WHERE estatus='Active' AND iitemid NOT IN($item_ids)");
            $return = $query->rows;
        }else{
            $query = $this->db2->query("SELECT iitemid,vitemcode,vitemname,vitemtype,dunitprice,vunitcode FROM mst_item WHERE estatus='Active'");
            $return = $query->rows;
        }
        return $return;
    }

    public function getItem($vbarcode = null) {
         $query = $this->db2->query("SELECT * FROM mst_item WHERE vbarcode='".$vbarcode."' AND  estatus='Active'");
         return $query->row;
    }

}
?>