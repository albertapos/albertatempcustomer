<?php 
//http://insloc.com/api/plcbupdate.php?table=item 
//http://insloc.com/api/plcbupdate.php?table=itemdetail

$method = $_SERVER['REQUEST_METHOD']; 

//define('DB_DRIVER_LOCAL', 'mysqli');
//define('DB_HOSTNAME_LOCAL', 'localhost');
//define('DB_USERNAME_LOCAL', 'root');
//define('DB_PASSWORD_LOCAL', '');
//define('DB_DATABASE_LOCAL', 'web_manova_march_end');
//define('DB_PORT_LOCAL', '3306');
//define('SID', '100110');

/*-------------------Beer Ink old ------------------*/

/*define('DB_DRIVER_CLOUD', 'mysqli');
define('DB_HOSTNAME_CLOUD', '64.64.3.10');
define('DB_USERNAME_CLOUD', 'u100071');
define('DB_PASSWORD_CLOUD', 'NvYmwKE85L');
define('DB_DATABASE_CLOUD', 'u100071');
define('DB_PORT_CLOUD', '3306');
define('SID', '100071');
*/
/*-------------------Beer Ink new ------------------*/

define('DB_DRIVER_CLOUD', 'mysqli');
define('DB_HOSTNAME_CLOUD', '64.64.3.10');
define('DB_USERNAME_CLOUD', 'u100247');
define('DB_PASSWORD_CLOUD', 'M21bZxw4ArP0s');
define('DB_DATABASE_CLOUD', 'u100247');
define('DB_PORT_CLOUD', '3306');
define('SID', '100247');

/*-------------------MANOA BEVERAGE------------------*/

/*define('DB_DRIVER_CLOUD', 'mysqli');
define('DB_HOSTNAME_CLOUD', '64.64.3.10');
define('DB_USERNAME_CLOUD', 'u100110');
define('DB_PASSWORD_CLOUD', 'SHLjPmo1DpP0s');
define('DB_DATABASE_CLOUD', 'u100110');
define('DB_PORT_CLOUD', '3306');
define('SID', '100110');
*/
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

if($_REQUEST['table']=="item"){
	$query = $db->query("select iitemid,iqtyonhand from mst_item");	
	$rows=$query->rows;
	
//	$myfile = fopen("mst_plcb_item.txt", "w") or die("Unable to open file!");
	$txt="";
	if(count($rows)>0)
	{
		foreach($rows as $row)
		{
			$sql1="SELECT item_id from mst_plcb_item where item_id=".$row['iitemid'];
			$query1=$db->query($sql1);		
			$row1= $query1->row;
			
			if(count($row1)==1)
			{
				$sql="UPDATE `mst_plcb_item` set prev_mo_beg_qty=prev_mo_end_qty,prev_mo_end_qty=".$row['iqtyonhand']." WHERE item_id=".$row1['item_id'];
				$txt.="update item id :".$row1['item_id'];				
			}else{
				$sql="INSERT INTO `mst_plcb_item` (`item_id`,`bucket_id`,`prev_mo_beg_qty`,`prev_mo_end_qty`,`SID`) VALUES (".$row['iitemid'].",13,0,".$row['iqtyonhand'].",".SID.");";
				$txt.="insert item id :".$row['iitemid'];
			}
			$db->query($sql);
		}
		
		//fwrite($myfile, $txt);
		
		//fclose($myfile);
		echo 'Task Complete';
	}
}

if($_REQUEST['table']=="itemdetail"){

	//$query=$db->query("SELECT * from mst_plcb_item");	
	/* <13 used to remove item which is under not Applicable bucket*/
	$query=$db->query("SELECT * from mst_plcb_item a where bucket_id < 13");		
	$rows= $query->rows;
	
	//$myfile = fopen("mst_plcb_item_detail.txt", "w") or die("Unable to open file!");
	$txt="";
	
	if(count($rows) > 0)
	{
		$db->query("delete from mst_plcb_item_detail");
		
		foreach($rows as $row)
		{
			$sqldet="SELECT * from trn_purchaseorder a,trn_purchaseorderdetail b WHERE a.ipoid=b.ipoid AND b.vitemid=".$row['item_id']." AND a.estatus='Close' AND  date_format(a.dcreatedate,'%Y-%m')='".date('Y-m',strtotime('-1 month'))."'";
			//$sqldet="SELECT * from trn_purchaseorder a LEFT JOIN trn_purchaseorderdetail b ON a.ipoid=b.ipoid WHERE a.ipoid=b.ipoid AND a.estatus='Close' AND  date_format(a.dcreatedate,'%Y-%m')='".date('Y-m',strtotime('-1 month'))."'";
			
			$querydet=$db->query($sqldet);
			$rowsdet= $querydet->rows;	
			
			if(count($rowsdet) > 0)
			{
				$main_arr = array();
				foreach($rowsdet as $detail){
					//print_r($detail['item_id']);exit;
					if(array_key_exists($detail['vvendorid'], $main_arr)){
						//$main_arr[$detail['vvendorid']]['prev_mo_purchase'] = $main_arr[$detail['vvendorid']]['prev_mo_purchase'] + 1;
						$main_arr[$detail['vvendorid']]['prev_mo_purchase'] = $main_arr[$detail['vvendorid']]['prev_mo_purchase'] + $detail['itotalunit'];
                      }else{
                     		$main_arr[$detail['vvendorid']] = array(
																//'plcb_item_id' => $detail['item_id'],
																'plcb_item_id' => $detail['vitemid'],
																'supplier_id' => $detail['vvendorid'],
																'prev_mo_purchase' => $detail['itotalunit']
																//'prev_mo_purchase' => 0
                                                              );
                     }
				}
				
				$main_plcb_details = array();
				foreach ($main_arr as $main_array) {
				   $main_plcb_details[] =  $main_array;
				}	
				
				 foreach ($main_plcb_details as  $main_plcb_detail) {
					 $sql="INSERT INTO mst_plcb_item_detail SET plcb_item_id=".$main_plcb_detail['plcb_item_id'].",supplier_id=".$main_plcb_detail['supplier_id'].",prev_mo_purchase=".$main_plcb_detail['prev_mo_purchase'].",SID=".SID;
					 
					 $db->query($sql);
				 }
			}
		}
	}
	
	echo 'Task Complete';	
}

?>