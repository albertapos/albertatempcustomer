<?php
class ControllerKioskTableAction extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('kiosk/table_action');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/table_action');

		$this->getList();
	}

	public function export() {
		
		$return = array();
		
		$this->load->language('kiosk/table_action');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/table_action');

		if(!empty($this->session->data['db_username2']) && !empty($this->session->data['db_password2']) && !empty($this->session->data['db_database2'])){

			$DBUSER = $this->session->data['db_username2'];
			$DBPASSWD = $this->session->data['db_password2'];
			$DATABASE = $this->session->data['db_database2'];
			$HOST = $this->session->data['db_hostname2'];
			
			$tableArr = array('kiosk_category', 'kiosk_default_ingredients', 'kiosk_global_param', 'kiosk_menu_header', 'kiosk_menu_item', 'kiosk_menu_item_options', 'kiosk_page_flow_detail', 'kiosk_page_flow_header', 'kiosk_page_master', '	kiosk_trn_order', 'mst_item');

			$table_list = implode(' ', $tableArr);

			if(file_exists('system/storage/exprot_db/'.$DATABASE.'.sql')){
	          	unlink('system/storage/exprot_db/'.$DATABASE.'.sql');
	        }

			exec("mysqldump --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE $table_list > system/storage/exprot_db/$DATABASE.sql"); 

			$return['code'] = 1;
			$return['response'] = '/system/storage/exprot_db/'.$DATABASE.'.sql';

		}else{
			$return['code'] = 0;
			$return['response'] = 'Something Went Wrong!!!';
		}

		echo json_encode($return);
		exit;  
	}

	public function import_confirm() {
		
		$return = array();
		
		$this->load->language('kiosk/table_action');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/table_action');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			if(!empty($this->session->data['db_username2']) && !empty($this->session->data['db_password2']) && !empty($this->session->data['db_database2'])){

				$DBUSER = $this->session->data['db_username2'];
				$DBPASSWD = $this->session->data['db_password2'];
				$DATABASE = $this->session->data['db_database2'];
				$HOST = $this->session->data['db_hostname2'];

				// $DBUSER = 'root';
				// $DBPASSWD = 'root';
				// $DATABASE = 'test';
				// $HOST = 'localhost';
				
				$tableArr = array('kiosk_category', 'kiosk_default_ingredients', 'kiosk_global_param', 'kiosk_menu_header', 'kiosk_menu_item', 'kiosk_menu_item_options', 'kiosk_page_flow_detail', 'kiosk_page_flow_header', 'kiosk_page_master', 'kiosk_trn_order', 'mst_item');

				$db_conn = new DB('mysqli', $HOST, $DBUSER, $DBPASSWD, $DATABASE);

				foreach ($tableArr as $key => $value) {
					$db_conn->query("TRUNCATE TABLE $value");
				}

				$uploaded_file_path = $this->request->post['uploaded_file_path'];
				$backup_file_path = $this->request->post['backup_file_path'];
				
				try {
				    exec("mysql --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE  < $uploaded_file_path");

				    foreach ($tableArr as $key => $value) {
						$db_conn->query("UPDATE $value SET `SID`=".(int)($this->session->data['SID']));
					}

				    $return['code'] = 1;
				}
				catch (MySQLDuplicateKeyException $e) {
				    // duplicate entry exception
				    exec("mysql --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE  < $backup_file_path");
				    $return['code'] = 0; 
				}
				catch (MySQLException $e) {
				    // other mysql exception (not duplicate key entry)
				    exec("mysql --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE  < $backup_file_path");
				    $return['code'] = 0;  
				}
				catch (Exception $e) {
				    // not a MySQL exception
				    exec("mysql --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE  < $backup_file_path");
				    $return['code'] = 0;  
				}

			}else{
				$return['code'] = 0;
				$return['response'] = 'Something Went Wrong!!!';
			}

		}else{
			$return['code'] = 0;
			$return['response'] = 'Something Went Wrong!!!';
		}

		echo json_encode($return);
		exit;  
	}

	public function import() {
		
		$return = array();
		
		$this->load->language('kiosk/table_action');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('kiosk/table_action');

		//type
		$types = array('application/gzip', 'application/sql','application/zip', 'application/x-bzip');

		//extention
		$extentions = array('gz', 'sql', 'bz2', 'zip');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			if($this->request->files['import_file']['error'] == 0){

				$ext = pathinfo($this->request->files['import_file']['name'], PATHINFO_EXTENSION);

				if (in_array($ext, $extentions)) {

					if(in_array($this->request->files['import_file']['type'], $types)){

						$pattern = '/.sql/';
						$fileValid = preg_match($pattern,$this->request->files['import_file']['name']);

						if($fileValid){

							if(!empty($this->session->data['db_username2']) && !empty($this->session->data['db_password2']) && !empty($this->session->data['db_database2'])){

								$DBUSER = $this->session->data['db_username2'];
								$DBPASSWD = $this->session->data['db_password2'];
								$DATABASE = $this->session->data['db_database2'];
								$HOST = $this->session->data['db_hostname2'];
								
								$tableArr = array('kiosk_category', 'kiosk_default_ingredients', 'kiosk_global_param', 'kiosk_menu_header', 'kiosk_menu_item', 'kiosk_menu_item_options', 'kiosk_page_flow_detail', 'kiosk_page_flow_header', 'kiosk_page_master', '	kiosk_trn_order', 'mst_item');

								$table_list = implode(' ', $tableArr);

								if(file_exists('system/storage/import_bakcup/'.$DATABASE.'.sql')){
						          	unlink('system/storage/import_bakcup/'.$DATABASE.'.sql');
						        }

								exec("mysqldump --host=$HOST -u $DBUSER --password=$DBPASSWD $DATABASE $table_list > system/storage/import_bakcup/$DATABASE.sql"); 

								$backup_path = 'system/storage/import_bakcup/'.$DATABASE.'.sql';
								$uploaded_file_path = 'system/storage/uploaded_db/'.$this->request->files['import_file']['name'];

								if(file_exists('system/storage/uploaded_db/'.$this->request->files['import_file']['name'])){
						          	unlink('system/storage/uploaded_db/'.$this->request->files['import_file']['name']);
						        }

								move_uploaded_file($this->request->files['import_file']['tmp_name'],'system/storage/uploaded_db/'.$this->request->files['import_file']['name']);

								$arrayyy = explode("\n", file_get_contents('system/storage/uploaded_db/'.$this->request->files['import_file']['name']));

								$pattern = '/INSERT INTO `mst_item`/';
								
								$mainsku = array();
								foreach ($arrayyy as $key => $arr) {
									if(preg_match($pattern,$arr)){
										$insrt = explode("VALUES", $arr);
										$mainsku[] = explode("),(", $insrt[1]);

										// foreach ($insrt as $k => $insert_str) {
										// 	$mainsku[] = str_replace("(","",$insert_str);
										// }
									}
								}

								$skuarr = array();
								foreach ($mainsku as $key => $values) {
									foreach ($values as $k => $value) {
										$skuarr[] = explode(",", $value);
									}
								}
								
								$totsku = array();
								foreach ($skuarr as $key => $skuarray) {

									if($skuarray[6] != '' && preg_match('/[^A-Za-z0-9]/', $skuarray[6])){
										$totsku[] = $skuarray[6];
									}
								}

								$skucounts = $this->model_kiosk_table_action->checkProductSku($totsku);

								if($skucounts > 0){
									$return['code'] = 1;
									$return['backup_file_path'] = $backup_path;
									$return['uploaded_file_path'] = $uploaded_file_path;
									$return['response'] = 'We found total '.$skucounts.' same sku of products<br>Are you sure to update?';
								}else{
									$return['code'] = 2;
									$return['backup_file_path'] = $backup_path;
									$return['uploaded_file_path'] = $uploaded_file_path;
									$return['response'] = 'Are you sure you want to truncate data?';
								}

							}else{
								$return['code'] = 0;
								$return['response'] = 'Something Went Wrong!!!';
							}
						}else{
							$return['code'] = 0;
							$return['response'] = 'File not allowed';
						}

					}else{
						$return['code'] = 0;
						$return['response'] = 'File type allowed';
					}
			        
			    }else{

			    	$return['code'] = 0;
					$return['response'] = 'File extension allowed';

			    }

			}else{

				$return['code'] = 0;
				$return['response'] = 'File not allowed';

			}
		}else{
			$return['code'] = 0;
				$return['response'] = 'Something Went Wrong!!!';
		}

		

		echo json_encode($return);
		exit;  
	}
	  
	protected function getList() {

		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('kiosk/table_action', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('kiosk/table_action/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['export'] = $this->url->link('kiosk/table_action/export', 'token=' . $this->session->data['token'] . $url, true);
		$data['import'] = $this->url->link('kiosk/table_action/import', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_confirm'] = $this->url->link('kiosk/table_action/import_confirm', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_active'] = $this->language->get('text_active');
		$data['text_inactive'] = $this->language->get('text_inactive');
		
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// echo "<pre>";
		// print_r($data);
		// exit;

		$this->response->setOutput($this->load->view('kiosk/table_action_list', $data));
	}


	protected function validateForm() {
		
		$this->load->model('kiosk/table_action');
		
		if (!$this->user->hasPermission('modify', 'kiosk/table_action')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

}
