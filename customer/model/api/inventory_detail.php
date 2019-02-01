<?php
class ModelApiInventoryDetail extends Model {

	public function getInventoryDetail($sid=0,$tranid=0){
		$data = array();
		$header = array();		
		
		$sql="select ipiid,SID,vrefnumber as Tranid,date_format(dcreatedate,'%m-%d-%Y %h:%i:%s') as dcreatedate,date_format(dclosedate,'%m-%d-%Y %h:%i:%s') as dclosedate,nnettotal,date_format(dcalculatedate,'%m-%d-%Y %h:%i:%s') as dcalculatedate FROM trn_physicalinventory where vtype='Physical' and estatus='Close' AND vrefnumber ='".$tranid."' AND SID='".$sid."' order by date_format(dclosedate,'%m-%d-%Y %h:%i:%s')";
		
		$hed_query = $this->db2->query($sql)->row;
		
		$header = array(
			"ipiid" => $hed_query['ipiid'],
			"dcreatedate" => $hed_query['dcreatedate'],
			"dclosedate" => $hed_query['dclosedate'],
			"nnettotal" => $hed_query['nnettotal'],
		);
			
		$sql_de="SELECT vitemid,vitemname,ndebitqty,(ndebitqty*ndebitunitprice) as amount  FROM trn_physicalinventorydetail where ipiid =".$hed_query['ipiid'];	
		$det_query = $this->db2->query($sql_de)->rows;
		
		if(count($det_query) > 0)
		{	$detail = array();
			foreach($det_query as $det){
				$detail[]= array(
					"vitemid" => $det['vitemid'],
					"vitemname" => $det['vitemname'],
					"ndebitqty" => $det['ndebitqty'],
					"amount" => $det['amount'],
				);	
			}	
		}
		
		$data = array(
			"inventory_header" => $header,
			"inventory_detail" => $detail			 
		);
		
		return $data;
	}
}
