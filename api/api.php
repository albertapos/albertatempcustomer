<?php 

$method = $_SERVER['REQUEST_METHOD'];

define('DB_DRIVER_LOCAL', 'mysqli');
define('DB_HOSTNAME_LOCAL', 'localhost');
define('DB_USERNAME_LOCAL', 'root');
define('DB_PASSWORD_LOCAL', '');
define('DB_DATABASE_LOCAL', 'pos2020_portal');
define('DB_PORT_LOCAL', '3306');
define('DB_PREFIX_LOCAL', 'oc_');


// Production server credentials
define('DB_DRIVER_CLOUD', 'mysqli');
define('DB_HOSTNAME_CLOUD', 'albertapayments.cfixtkqw8bai.us-east-2.rds.amazonaws.com');
define('DB_USERNAME_CLOUD', 'alberta');
define('DB_PASSWORD_CLOUD', 'Jalaram123$');
define('DB_DATABASE_CLOUD', 'inslocdb');
define('DB_PORT_CLOUD', '3306');
define('DB_PREFIX_CLOUD', 'oc_');

// Development server credentials
/*define('DB_DRIVER_CLOUD', 'mysqli');
define('DB_HOSTNAME_CLOUD', '13.59.208.236');
define('DB_USERNAME_CLOUD', 'root');
define('DB_PASSWORD_CLOUD', 'Alberta@1');
define('DB_DATABASE_CLOUD', 'inslocdb');
define('DB_PORT_CLOUD', '3306');
define('DB_PREFIX_CLOUD', 'oc_');*/

require_once("db.php");

function library($class) {
	$file = '' . str_replace('\\', '/', strtolower($class)) . '.php';

	if (is_file($file)) {
		include_once($file);

		return true;
	} else {
		return false;
	}
}

spl_autoload_register('library');
spl_autoload_extensions('.php');

$db= new DB(DB_DRIVER_CLOUD, DB_HOSTNAME_CLOUD, DB_USERNAME_CLOUD, DB_PASSWORD_CLOUD, DB_DATABASE_CLOUD, DB_PORT_CLOUD);
//$db= new DB(DB_DRIVER_LOCAL, DB_HOSTNAME_LOCAL, DB_USERNAME_LOCAL, DB_PASSWORD_LOCAL, DB_DATABASE_LOCAL, DB_PORT_LOCAL);

if(isset($method) && $method=="GET")
{
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$zip = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$hashcode = array_shift($request);	
	
	//for Demo Server,Register AND Kiosk
	if(($hashcode=="A2C9DD" || $hashcode=="3BC16A") && $zip=="08852"){//5B204D
		$storedeomo="1234";
		
		if($hashcode=="3BC16A"){
			$register='N';
			$kiosk='Y';
		}else{
			$register='Y';
			$kiosk='N';
		}
			
		$return=array(
			"store_id"=>'100136',
			"uid"=>'101',
			"name"=>'ALBERTADEMO', 
			"business_name"=>'ALBERTADEMO',
			"description"=>'ALBERTADEMO',
			"phone"=>'1888502665',
			"address"=>'68 Culver Dr Suit 125',
			"country"=>'USA',
			"state"=>'NJ',
			"city"=>'Monmouth Junction',
			"zip"=>'08852',
			"hashcode"=>$hashcode,
			"register"=>$register,
			"kiosk"=>$kiosk,
			"server"=>'Y',
			"server_ip"=>'',
			"db_name"=>'u100136',
			"db_username"=>'u100136',
			"db_password"=>'ajbMIt5x74P0s',
			"db_hostname"=>'64.64.3.10',
			"message"=>'',
			"storedemo" =>$storedeomo
		);
		$str.=json_encode($return);
						
	}else{
		$storedeomo="8912";
	
		$query = $db->query("SELECT b.*,a.store_id,a.uid,hashcode,a.register,a.kiosk,a.server,a.status,a.server_ip FROM store_computers a,stores b WHERE a.hashcode='".$hashcode."' AND a.store_id=b.id AND b.zip='".$zip."' AND status='N'");		
		$rows=$query->rows;
		
		if(isset($rows) && count($rows) > 0)
		{
			$query=$db->query("SELECT c.status FROM store_computers c WHERE store_id IN (".$rows[0]['store_id'].") AND server='Y'");
			$row= $query->row;
			$server_status= $row['status'];
			
			$i=0;
			$str='';
			$flg=false;
			
			$return=array(
				"store_id"=>'',
				"uid"=>'',
				"name"=>'', 
				"business_name"=>'',
				"description"=>'',
				"phone"=>'',
				"address"=>'',
				"country"=>'',
				"state"=>'',
				"city"=>'',
				"zip"=>'',
				"hashcode"=>'',
				"register"=>'',
				"kiosk"=>'',
				"server"=>'',
				"server_ip"=>'',
				"db_name"=>'',
				"db_username"=>'',
				"db_password"=>'',
				"db_hostname"=>'',
				"message"=>'',
				"err_code"=>'',
				"storedemo" =>''
			);
			
			if($rows[0]['server']=="Y" && $rows[0]['status']=="N")
			{
				foreach($rows as $key=>$value)
				{		
					$return=array(
						"store_id"=>$value['store_id'],
						"uid"=>$value['uid'],
						"name"=>$value['name'], 
						"business_name"=>$value['business_name'],
						"description"=>$value['description'],
						"phone"=>$value['phone'],
						"address"=>$value['address'],
						"country"=>$value['country'],
						"state"=>$value['state'],
						"city"=>$value['city'],
						"zip"=>$value['zip'],
						"hashcode"=>$value['hashcode'],
						"register"=>$value['register'],
						"kiosk"=>$value['kiosk'],
						"server"=>$value['server'],
						"server_ip"=>$value['server_ip'],
						"db_name"=>$value['db_name'],
						"db_username"=>$value['db_username'],
						"db_password"=>$value['db_password'],
						"db_hostname"=>$value['db_hostname'],
						"message"=>'',
						"storedemo" =>$storedeomo
					);
					$str.=json_encode($return);
					$i++;
				}	
			}
			else
			{
				if($server_status=="N" && ($rows[0]['register']=="Y" || $rows[0]['kiosk']=="Y"))
				{
					$return=array(
						"message"=>'Please first install the server.',
						"err_code"=>'002'
					);
					$str.=json_encode($return);				
				}
				else
				{
					foreach($rows as $key=>$value)
					{			
						$return=array(
							"store_id"=>$value['store_id'],
							"uid"=>$value['uid'],
							"name"=>$value['name'], 
							"business_name"=>$value['business_name'],
							"description"=>$value['description'],
							"phone"=>$value['phone'],
							"address"=>$value['address'],
							"country"=>$value['country'],
							"state"=>$value['state'],
							"city"=>$value['city'],
							"zip"=>$value['zip'],
							"hashcode"=>$value['hashcode'],
							"register"=>$value['register'],
							"kiosk"=>$value['kiosk'],
							"server"=>$value['server'],
							"server_ip"=>$value['server_ip'],
							"db_name"=>$value['db_name'],
							"db_username"=>$value['db_username'],
							"db_password"=>$value['db_password'],
							"db_hostname"=>$value['db_hostname'],
							"message"=>'',
							"storedemo" =>$storedeomo
						);
						$str.=json_encode($return);
						$i++;
					}
				}
			}
		}
		else
		{
			$return=array(
				"message"=>'Invalid activation parameters.',
				"err_code"=>'001'
			);
			$str.=json_encode($return);	
		}
	}
	
	echo $str;
}
if(isset($method) && $method=="POST")
{
	$hashcode=$_POST['hashcode'];
	$server_ip=$_POST['server'];
	
	$sql="UPDATE store_computers SET status='Y' WHERE hashcode='".$hashcode."'";
	$db->query($sql);

	//$sql="UPDATE store_computers SET server_ip='".$server_ip."' WHERE id IN ((select id from store_computers where store_id=(SELECT store_id from store_computers WHERE hashcode='".$hashcode."')))";
	
	if($server_ip!='')
	{	
		$query=$db->query("select id from store_computers where store_id IN (SELECT store_id from store_computers WHERE hashcode='".$hashcode."')");	
		$rows = $query->rows;
		foreach($rows as $row)
		{
			$db->query("UPDATE store_computers SET server_ip='".$server_ip."' WHERE id=".$row['id']);	
		}
	}
}
?>