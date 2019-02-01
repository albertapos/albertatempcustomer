<?php
class ModelApiAuthenticate extends Model {
    public function authenticateUser($username,$password) {

        $return = array();

        $user_email_query = $this->db->query("SELECT * FROM users WHERE email = '" . $this->db->escape($username) . "'");

        if(!$user_email_query->num_rows){
            $return['error'] = 'Please Enter Valid Credentials';
            return $return;
        }

        $hash = $user_email_query->row['password'];

        if (password_verify($this->db->escape($password), $hash)) {

            $this->session->data['user_id'] = $user_email_query->row['id'];
            //$this->session->data['sid'] = $sid;
            
            $this->user_id = $user_email_query->row['id'];
            $this->username = $user_email_query->row['fname'];

            $user_role = $this->db->query("SELECT * FROM role_user WHERE user_id = '" . (int)$user_email_query->row['id'] . "'");

            if(!in_array($user_role->row['role_id'], array(1,2))){
                $return['error'] = 'No match for Username and/or Password';
                return $return;
            }
                
            $this->session->data['user_id'] = $user_email_query->row['id'];
            $this->session->data['role_id'] = $user_role->row['role_id'];

            $stores = $this->selectStore($this->session->data['user_id'],$this->session->data['role_id']);

            $this->session->data['token'] = token(32);
            $return['token'] = $this->session->data['token'];
            $return['stores'] = $stores;
            return $return;
        } else {
            $return['error'] = 'Please Enter Valid Credentials';
            return $return;
        } 
    }

    public function selectStore($userId,$roleId) {
        $agent_office_id = $this->db->query("SELECT `agent_office_id` FROM users WHERE id='".$userId."'");

        $store_arr = array();

        if($roleId == 1){
            $store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname,webadmin FROM stores ORDER BY id");

            $store_arr = $this->db->query("SELECT id,name FROM stores ORDER BY id")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }elseif($roleId == 2){
            $store = $this->db->query("SELECT s.id,s.name,s.db_name,s.db_username,s.db_password,s.db_hostname,s.webadmin FROM stores as s,user_stores as us WHERE s.id=us.store_id AND us.user_id='". (int)$userId ."' ORDER BY s.id");

            $store_arr = $this->db->query("SELECT s.id,s.name FROM stores as s,user_stores as us WHERE s.id=us.store_id AND us.user_id='". (int)$userId ."' ORDER BY s.id")->rows;

            //$this->session->data['store_array'] = $store_arr;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }elseif($roleId == 3){
            $store = $this->db->query("SELECT s.id,s.name,s.db_name,s.db_username,s.db_password,s.db_hostname,s.webadmin FROM stores as s,sales_stores as ss, users as u WHERE u.id=ss.user_id AND ss.user_id='". (int)$userId ."' ORDER BY s.id");

            $store_arr = $this->db->query("SELECT s.id,s.name FROM stores as s,sales_stores as ss, users as u WHERE u.id=ss.user_id AND ss.user_id='". (int)$userId ."' ORDER BY s.id")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }elseif($roleId == 4){
            $store_ids = $this->db->query("SELECT ss.store_id FROM sales_stores as ss, users as u WHERE u.id=ss.user_id AND u.agent_office_id='". (int)$agent_office_id->row['agent_office_id'] ."'")->rows;
            $new_s_ids = array();
            if(count($store_ids) > 0){
                foreach ($store_ids as $key => $value) {
                    array_push($new_s_ids, $value['store_id']);
                }
            }

            $new_s_ids_string = implode(',', $new_s_ids);
           
            $store = $this->db->query("SELECT * FROM stores WHERE id in($new_s_ids_string)");
            $store_arr = $this->db->query("SELECT id,name FROM stores WHERE id in($new_s_ids_string)")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }elseif($roleId == 5){
            $store_ids = $this->db->query("SELECT ss.store_id FROM sales_stores as ss, users as u WHERE u.id=ss.user_id ")->rows;
            $new_s_ids = array();
            if(count($store_ids) > 0){
                foreach ($store_ids as $key => $value) {
                    array_push($new_s_ids, $value['store_id']);
                }
            }

            $new_s_ids_string = implode(',', $new_s_ids);
           
            $store = $this->db->query("SELECT * FROM stores WHERE id in($new_s_ids_string)");
            $store_arr = $this->db->query("SELECT id,name FROM stores WHERE id in($new_s_ids_string)")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }elseif($roleId == 6){

            $store_ids = $this->db->query("SELECT ss.store_id FROM sales_stores as ss, users as u WHERE u.id=ss.user_id AND u.agent_office_id='". (int)$agent_office_id->row['agent_office_id'] ."'")->rows;
            $new_s_ids = array();
            if(count($store_ids) > 0){
                foreach ($store_ids as $key => $value) {
                    array_push($new_s_ids, $value['store_id']);
                }
            }

            $new_s_ids_string = implode(',', $new_s_ids);
           
            $store = $this->db->query("SELECT * FROM stores WHERE id in($new_s_ids_string)");
            $store_arr = $this->db->query("SELECT id,name FROM stores WHERE id in($new_s_ids_string)")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];               
            }
        }elseif($roleId == 8){
            $store = $this->db->query("SELECT DISTINCT s.id,s.name,s.db_name,s.db_username,s.db_password,s.db_hostname,s.webadmin FROM stores as s,sales_stores as ss, users as u WHERE u.id=ss.user_id AND ss.user_id='". (int)$userId ."' ORDER BY s.id");

            $store_arr = $this->db->query("SELECT DISTINCT s.id,s.name FROM stores as s,sales_stores as ss, users as u WHERE u.id=ss.user_id AND ss.user_id='". (int)$userId ."' ORDER BY s.id")->rows;

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];
            }
        }
        return $store_arr;
    }

    public function changeStore($store_id) {
        $return =array();
        
        if(!empty($store_id)){
            $store = $this->db->query("SELECT * FROM stores WHERE id='". (int)$store_id ."'");

            if(isset($store) && count($store->rows) > 0){
                $this->session->data['SID'] = $store->row['id'];
                $this->session->data['sid'] = $store->row['id'];

                unset($this->session->data['db2']);
                unset($this->session->data['db_hostname2']);
                unset($this->session->data['db_username2']);
                unset($this->session->data['db_password2']);
                unset($this->session->data['db_database2']);

                $this->session->data['db_hostname2'] = $store->row['db_hostname'];
                $this->session->data['db_username2'] = $store->row['db_username'];
                $this->session->data['db_password2'] = $store->row['db_password'];
                $this->session->data['db_database2'] = $store->row['db_name'];               
            }
            $return['success'] = 'Store has been changed successfully!';
        }else{
            $return['error'] = 'Store Id Missing!';
        }
        return $return;
    }

}
?>