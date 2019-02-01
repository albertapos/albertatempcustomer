<?php
class ModelApiEndOfDayShift extends Model {
    
    public function getBatches($data = array()) {
        
        $sql = "SELECT ibatchid, vbatchname FROM trn_batch WHERE estatus='Close' AND endofday='0'";

        $query = $this->db2->query($sql);

        return $query->rows;
    }

    public function editlist($data = array()) {

        $success =array();
        $error =array();

        $start_date = $data['start_date'];

        $dstartdatetime = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $dstartdatetime = $dstartdatetime->format('Y-m-d');

        $denddatetime = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $denddatetime = $denddatetime->format('Y-m-d');

        $dstartdatetime = $dstartdatetime.' '.date('H:i:s');
        $denddatetime = $denddatetime.' '.date('H:i:s');

        $year = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $year = $year->format('y');

        $month = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $month = $month->format('m');

        $day = DateTime::createFromFormat('m-d-Y', $data['start_date']);
        $day = $day->format('d');

        $auto_inc_id = $year.''.$month.''.$day.'101';

        $check_exist = $this->db2->query("SELECT * FROM trn_endofday WHERE date_format(dstartdatetime,'%m-%d-%Y')='". $start_date ."'")->row;

        $batches = array_values(array_filter($data['batch'], function($value) { return trim($value) !== ''; }));
       
        $batch_ids = implode(',', $batches);

        if(count($check_exist) > 0){

            $exist_batch_ids = $this->db2->query("SELECT batchid FROM trn_endofdaydetail WHERE eodid='". $check_exist['id'] ."'")->rows;

            $old_batch_ids = array();

            if(count($exist_batch_ids) > 0){
                foreach ($exist_batch_ids as $k => $v) {
                    $old_batch_ids[] = $v['batchid'];
                }
            }

            $new_batch_ids = array();

            foreach ($batches as $new_v) {
                if(!in_array($new_v, $old_batch_ids)){
                    $new_batch_ids[]= $new_v;
                } 
            }

            if(count($new_batch_ids) > 0){
                $batch_ids_new = implode(',', $new_batch_ids);

                $batch_data = $this->db2->query("SELECT ifnull(SUM(nnetsales),0.00) as nnetsales, ifnull(SUM(nnetpaidout),0.00) as nnetpaidout, ifnull(SUM(nnetcashpickup),0.00) as nnetcashpickup, ifnull(SUM(nopeningbalance),0.00) as nopeningbalance, ifnull(SUM(nclosingbalance),0.00) as nclosingbalance, ifnull(SUM(nuserclosingbalance),0.00) as nuserclosingbalance, ifnull(SUM(nnetaddcash),0.00) as nnetaddcash, ifnull(SUM(ntotalnontaxable),0.00) as ntotalnontaxable, ifnull(SUM(ntotaltaxable),0.00) as ntotaltaxable, ifnull(SUM(ntotalsales),0.00) as ntotalsales, ifnull(SUM(ntotaltax),0.00) as ntotaltax, ifnull(SUM(ntotalcreditsales),0.00) as ntotalcreditsales, ifnull(SUM(ntotalcashsales),0.00) as ntotalcashsales, ifnull(SUM(ntotalgiftsales),0.00) as ntotalgiftsales, ifnull(SUM(ntotalchecksales),0.00) as ntotalchecksales, ifnull(SUM(ntotalreturns),0.00) as ntotalreturns, ifnull(SUM(ntotaldiscount),0.00) as ntotaldiscount, ifnull(SUM(ntotaldebitsales),0.00) as ntotaldebitsales, ifnull(SUM(ntotalebtsales),0.00) as ntotalebtsales FROM trn_batch WHERE ibatchid IN($batch_ids_new)")->row;

                $this->db2->query("UPDATE trn_endofday SET nnetsales =nnetsales+ '" . $this->db->escape($batch_data['nnetsales']) . "', nnetpaidout =nnetpaidout+ '" . $this->db->escape($batch_data['nnetpaidout']) . "', nnetcashpickup =nnetcashpickup+ '" . $this->db->escape($batch_data['nnetcashpickup']) . "', dstartdatetime = '" . $this->db->escape($dstartdatetime) . "', denddatetime = '" . $this->db->escape($denddatetime) . "', nopeningbalance =nopeningbalance+ '" . $this->db->escape($batch_data['nopeningbalance']) . "', nclosingbalance =nclosingbalance+ '" . $this->db->escape($batch_data['nclosingbalance']) . "', nuserclosingbalance =nuserclosingbalance+ '" . $this->db->escape($batch_data['nuserclosingbalance']) . "', nnetaddcash =nnetaddcash+ '" . $this->db->escape($batch_data['nnetaddcash']) . "',  ntotalnontaxable =ntotalnontaxable+ '" . $this->db->escape($batch_data['ntotalnontaxable']) . "', ntotaltaxable =ntotaltaxable+ '" . $this->db->escape($batch_data['ntotaltaxable']) . "', ntotalsales =ntotalsales+ '" . $this->db->escape($batch_data['ntotalsales']) . "', ntotaltax =ntotaltax+ '" . $this->db->escape($batch_data['ntotaltax']) . "', ntotalcreditsales =ntotalcreditsales+ '" . $this->db->escape($batch_data['ntotalcreditsales']) . "', ntotalcashsales =ntotalcashsales+ '" . $this->db->escape($batch_data['ntotalcashsales']) . "', ntotalgiftsales =ntotalgiftsales+ '" . $this->db->escape($batch_data['ntotalgiftsales']) . "', ntotalchecksales =ntotalchecksales+ '" . $this->db->escape($batch_data['ntotalchecksales']) . "', ntotalreturns =ntotalreturns+ '" . $this->db->escape($batch_data['ntotalreturns']) . "', ntotaldiscount =ntotaldiscount+ '" . $this->db->escape($batch_data['ntotaldiscount']) . "', ntotaldebitsales =ntotaldebitsales+ '" . $this->db->escape($batch_data['ntotaldebitsales']) . "', ntotalebtsales =ntotalebtsales+ '" . $this->db->escape($batch_data['ntotalebtsales']) . "' WHERE id='". $check_exist['id'] ."'");

                foreach ($new_batch_ids as $key_id => $new_batch_ids_value) {
                    $this->db2->query("INSERT INTO trn_endofdaydetail SET eodid = '" . $this->db->escape($check_exist['id']) . "', batchid = '" . $this->db->escape($new_batch_ids_value) . "',SID = '" . (int)($this->session->data['sid'])."'");

                    $this->db2->query("UPDATE trn_batch SET endofday = '1' WHERE ibatchid='". $this->db->escape($new_batch_ids_value) ."'");

                }

            }
 
        }else{
             
            $batch_data = $this->db2->query("SELECT ifnull(SUM(nnetsales),0.00) as nnetsales, ifnull(SUM(nnetpaidout),0.00) as nnetpaidout, ifnull(SUM(nnetcashpickup),0.00) as nnetcashpickup, ifnull(SUM(nopeningbalance),0.00) as nopeningbalance, ifnull(SUM(nclosingbalance),0.00) as nclosingbalance, ifnull(SUM(nuserclosingbalance),0.00) as nuserclosingbalance, ifnull(SUM(nnetaddcash),0.00) as nnetaddcash, ifnull(SUM(ntotalnontaxable),0.00) as ntotalnontaxable, ifnull(SUM(ntotaltaxable),0.00) as ntotaltaxable, ifnull(SUM(ntotalsales),0.00) as ntotalsales, ifnull(SUM(ntotaltax),0.00) as ntotaltax, ifnull(SUM(ntotalcreditsales),0.00) as ntotalcreditsales, ifnull(SUM(ntotalcashsales),0.00) as ntotalcashsales, ifnull(SUM(ntotalgiftsales),0.00) as ntotalgiftsales, ifnull(SUM(ntotalchecksales),0.00) as ntotalchecksales, ifnull(SUM(ntotalreturns),0.00) as ntotalreturns, ifnull(SUM(ntotaldiscount),0.00) as ntotaldiscount, ifnull(SUM(ntotaldebitsales),0.00) as ntotaldebitsales, ifnull(SUM(ntotalebtsales),0.00) as ntotalebtsales FROM trn_batch WHERE ibatchid IN($batch_ids)")->row;

            $this->db2->query("INSERT INTO trn_endofday SET id='". $auto_inc_id ."', nnetsales = '" . $this->db->escape($batch_data['nnetsales']) . "', nnetpaidout = '" . $this->db->escape($batch_data['nnetpaidout']) . "', nnetcashpickup = '" . $this->db->escape($batch_data['nnetcashpickup']) . "', dstartdatetime = '" . $this->db->escape($dstartdatetime) . "', denddatetime = '" . $this->db->escape($denddatetime) . "', nopeningbalance = '" . $this->db->escape($batch_data['nopeningbalance']) . "', nclosingbalance = '" . $this->db->escape($batch_data['nclosingbalance']) . "', nuserclosingbalance = '" . $this->db->escape($batch_data['nuserclosingbalance']) . "', nnetaddcash = '" . $this->db->escape($batch_data['nnetaddcash']) . "',  ntotalnontaxable = '" . $this->db->escape($batch_data['ntotalnontaxable']) . "', ntotaltaxable = '" . $this->db->escape($batch_data['ntotaltaxable']) . "', ntotalsales = '" . $this->db->escape($batch_data['ntotalsales']) . "', ntotaltax = '" . $this->db->escape($batch_data['ntotaltax']) . "', ntotalcreditsales = '" . $this->db->escape($batch_data['ntotalcreditsales']) . "', ntotalcashsales = '" . $this->db->escape($batch_data['ntotalcashsales']) . "', ntotalgiftsales = '" . $this->db->escape($batch_data['ntotalgiftsales']) . "', ntotalchecksales = '" . $this->db->escape($batch_data['ntotalchecksales']) . "', ntotalreturns = '" . $this->db->escape($batch_data['ntotalreturns']) . "', ntotaldiscount = '" . $this->db->escape($batch_data['ntotaldiscount']) . "', ntotaldebitsales = '" . $this->db->escape($batch_data['ntotaldebitsales']) . "', ntotalebtsales = '" . $this->db->escape($batch_data['ntotalebtsales']) . "' ,SID = '" . (int)($this->session->data['sid'])."'");

            // $last_id = $this->db2->getLastId();

            foreach ($batches as $key => $value) {
                $this->db2->query("INSERT INTO trn_endofdaydetail SET eodid = '" . $this->db->escape($auto_inc_id) . "', batchid = '" . $this->db->escape($value) . "',SID = '" . (int)($this->session->data['sid'])."'");

                $this->db2->query("UPDATE trn_batch SET endofday = '1' WHERE ibatchid='". $this->db->escape($value) ."'");
            }

        }

        $success['success'] = 'Successfully Updated End of Day Shift';
        return $success;
    }

}
?>