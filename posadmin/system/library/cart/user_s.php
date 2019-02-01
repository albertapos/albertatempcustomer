<?php
namespace Cart;
class User {
	private $user_id;
	private $username;
	private $permission = array();

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->user_group_id = $user_query->row['user_group_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = json_decode($user_group_query->row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
				
//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='".$this->db->escape($SID). "'");	
				//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='100005'");	
				//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='100051'"); //new store kiosk
				//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='100029'");
				//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='100055'");
				$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='100009'"); // for local
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
					
					//$this->config->set('db_database2',$this->session->data['db_database2']);
					
					//$this->registry->set('db2', new MySQLi2($this->session->data['db_hostname2'], $this->session->data['db_username2'], $this->session->data['db_password2'], $this->session->data['db_database2']));
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];
			//$this->session->data['SID'] = $SID;
			$this->session->data['SID'] = 100071;
			
			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = json_decode($user_group_query->row['permission'], true);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			//$store = $this->db->query("SELECT id,name,db_name,db_username,db_password,db_hostname FROM stores WHERE id='".$this->db->escape($SID). "'");	
//				
//				if(isset($store))
//				{	
//			
//					$this->session->data['db_hostname2'] = $store->row['db_hostname'];
//					$this->session->data['db_username2'] = $store->row['db_username'];
//					$this->session->data['db_password2'] = $store->row['db_password'];
//					$this->session->data['db_database2'] = $store->row['db_name'];
//				}

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}
}