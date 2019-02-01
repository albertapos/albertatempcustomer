<?php
class ModelApiEndOfShiftPrinting extends Model {
    
    public function getEndOfShiftPrinting($data = array()) {
        
        $sql = "SELECT * FROM web_admin_settings WHERE variablename='EndOfShiftPrinting'";

        $query = $this->db2->query($sql);

        return $query->row;
    }

    public function editlist($data = array()) {

        $success =array();
        $error =array();

        if(isset($data) && isset($data['EndOfShiftPrinting'])){
            $v_EndOfShiftPrinting = $data['EndOfShiftPrinting'];
        }else{
            $v_EndOfShiftPrinting = 0;
        }

        $check_exist = $this->db2->query("SELECT * FROM web_admin_settings WHERE variablename='EndOfShiftPrinting'")->row;

        if(count($check_exist) > 0){
            $this->db2->query("UPDATE web_admin_settings SET variablevalue = '" . $this->db->escape($v_EndOfShiftPrinting) . "' WHERE variablename = 'EndOfShiftPrinting'");
        }else{
            $this->db2->query("INSERT INTO web_admin_settings SET variablename = 'EndOfShiftPrinting', variablevalue = '" . $this->db->escape($v_EndOfShiftPrinting) . "' ,SID = '" . (int)($this->session->data['sid'])."'");
        }

        $success['success'] = 'Successfully Updated End of Shift Printing';
        return $success;
    }

}
?>