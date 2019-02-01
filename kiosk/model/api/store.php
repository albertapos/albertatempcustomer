<?php
class ModelApiStore extends Model {
	public function login($username, $password, $SID) {

		$user_query = $this->db->query("SELECT * FROM users WHERE email = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape($password) . "' ");

		if ($user_query->num_rows) {

			$this->session->data['user_id'] = $user_query->row['id'];
			$this->user_id = $user_query->row['id'];
			$this->username = $user_query->row['fname'];
			$this->user_group_id = 1;
			
			$this->session->data['SID'] = $SID;

			$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='".$SID."'"); // for local
			
				if(isset($store))
				{	
					unset($this->session->data['db2']);
					unset($this->session->data['db_hostname2']);
					unset($this->session->data['db_username2']);
					unset($this->session->data['db_password2']);
					unset($this->session->data['db_database2']);

					$this->session->data['db_hostname2'] = $store->row['db_hostname'];
					$this->session->data['db_username2'] = $store->row['db_username'];
					$this->session->data['db_password2'] = $store->row['db_password'];
					$this->session->data['db_database2'] = $store->row['db_name'];
					$this->session->data['storename'] = $store->row['name'];
					
				}

			return true;
		} else {
			return false;
		}
	}

	public function getData() {
		$query = $this->db2->query("SELECT * FROM mst_item ");
		return $query->rows;
	}
}
