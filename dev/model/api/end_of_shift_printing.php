<?php
class ModelApiEndOfShiftPrinting extends Model {
    
    public function getEndOfShiftPrinting($data = array()) {
        
        $sql = "SELECT * FROM web_store_settings WHERE variablename='EndOfShiftPrinting'";

        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function getPrintDeliveryStation($data = array()) {
        
        $sql = "SELECT * FROM web_store_settings WHERE variablename='PrintDeliveryStation'";

        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function getPrintDeliItemwise($data = array()) {
        
        $sql = "SELECT * FROM web_store_settings WHERE variablename='PrintDeliItemwise'";

        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function editlist($data = array()) {

        $success =array();
        $error =array();

        // EndOfShiftPrinting
        if(isset($data) && isset($data['EndOfShiftPrinting'])){
            $v_EndOfShiftPrinting = $data['EndOfShiftPrinting'];
        }else{
            $v_EndOfShiftPrinting = 0;
        }

        $check_exist = $this->db2->query("SELECT * FROM web_store_settings WHERE variablename='EndOfShiftPrinting'")->row;

        if(count($check_exist) > 0){
            $this->db2->query("UPDATE web_store_settings SET variablevalue = '" . $this->db->escape($v_EndOfShiftPrinting) . "' WHERE variablename = 'EndOfShiftPrinting'");
        }else{
            $this->db2->query("INSERT INTO web_store_settings SET variablename = 'EndOfShiftPrinting', variablevalue = '" . $this->db->escape($v_EndOfShiftPrinting) . "' ,SID = '" . (int)($this->session->data['sid'])."'");
        }
        // EndOfShiftPrinting

        // PrintDeliveryStation
        if(isset($data) && isset($data['PrintDeliveryStation'])){
            $v_PrintDeliveryStation = $data['PrintDeliveryStation'];
        }else{
            $v_PrintDeliveryStation = 0;
        }

        $check_exist = $this->db2->query("SELECT * FROM web_store_settings WHERE variablename='PrintDeliveryStation'")->row;

        if(count($check_exist) > 0){
            $this->db2->query("UPDATE web_store_settings SET variablevalue = '" . $this->db->escape($v_PrintDeliveryStation) . "' WHERE variablename = 'PrintDeliveryStation'");
        }else{
            $this->db2->query("INSERT INTO web_store_settings SET variablename = 'PrintDeliveryStation', variablevalue = '" . $this->db->escape($v_PrintDeliveryStation) . "' ,SID = '" . (int)($this->session->data['sid'])."'");
        }
        // PrintDeliveryStation

        //PrintDeliItemwise
        if(isset($data) && isset($data['PrintDeliItemwise'])){
            $v_PrintDeliItemwise = $data['PrintDeliItemwise'];
        }else{
            $v_PrintDeliItemwise = 0;
        }

        $check_exist = $this->db2->query("SELECT * FROM web_store_settings WHERE variablename='PrintDeliItemwise'")->row;

        if(count($check_exist) > 0){
            $this->db2->query("UPDATE web_store_settings SET variablevalue = '" . $this->db->escape($v_PrintDeliItemwise) . "' WHERE variablename = 'PrintDeliItemwise'");
        }else{
            $this->db2->query("INSERT INTO web_store_settings SET variablename = 'PrintDeliItemwise', variablevalue = '" . $this->db->escape($v_PrintDeliItemwise) . "' ,SID = '" . (int)($this->session->data['sid'])."'");
        }
        //PrintDeliItemwise

        $success['success'] = 'Successfully Updated End of Shift Printing';
        return $success;
    }

}
?>