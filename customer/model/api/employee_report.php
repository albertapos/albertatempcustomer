<?php
class ModelApiEmployeeReport extends Model {

	public function getStore() {
		$sql = "SELECT * FROM stores WHERE id = ". (int)($this->session->data['SID']);

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCategories() {
		$sql = "SELECT vcategorycode as id, vcategoryname as name FROM mst_category";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getDepartments() {
		$sql = "SELECT vdepcode as id, vdepartmentname as name FROM mst_department";

		$query = $this->db2->query($sql);

		return $query->rows;
	}

	public function getCategoriesReport($sdate,$edate) {
        /*$to = "adarsh.s.chacko@gmail.com";
        $subject = "Store [".$this->session->data['sid']."] PO Issue";
       
        $message = "<br>";
        $message .= "<b>Details</b>";
        $message .= "<br>";
        //$message .= "<pre>".print_r($send_arr,true);   
       
        $header = "From:sales@pos2020.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
       
        $retval = mail ($to,$subject,$message,$header);*/
        

/*$email_to = "adarsh_chacko@yahoo.com, adarsh.s.chacko@gmail.com";

$to = $email_to;
                    $subject = "Store [".$this->session->data['sid']."] PO Issue";
                   
                    $message = "<br>";
                    $message .= "<b>Details</b>";
                    $message .= "<br>";
                    $message .= "Checking if the mail is sent.";   
                   
                    $header = "From:sales@pos2020.com \r\n".
                                'Reply-To:sales@pos2020.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    

                    
                   
                    $retval = mail ($to,$subject,$message,$header);

print_r($retval);

exit;*/








//$text = 

//$headers = "From: addu@mail.com\r\n";
//$headers .= "Reply-To: addu@mail.com\r\n";
//$headers .= "Return-Path: addu@mail.com\r\n";
//$headers .= "CC: sombodyelse@example.com\r\n";
//$headers .= "BCC: hidden@example.com\r\n";
//$header .= "MIME-Version: 1.0\r\n";
//$header .= "Content-type: text/html\r\n";



//$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

/*$to='adarsh_chacko@yahoo.com';
$subject="Test Mail";

$message = "<p>Hi Adarsh,</p> <p>How is life. How is everything? </p> <p>Hope to see you</p> <p>Addu.</p>";


if ( mail($to,$subject,$message,$headers) ) {
   echo "The email has been sent!";
   } else {
   echo "The email has failed!";
   }
exit;*/

/*$email_to = 'adarsh.s.chacko@aroha.co.in';

$mail = new Mail();

$mail->protocol = $this->config->get('config_mail_protocol');
$mail->parameter = $this->config->get('config_mail_parameter');
$mail->hostname = $this->config->get('config_smtp_host');
$mail->username = $this->config->get('config_smtp_username');
$mail->password = $this->config->get('config_smtp_password');
$mail->port = $this->config->get('config_smtp_port');
$mail->timeout = $this->config->get('config_smtp_timeout');            
$mail->setTo($email_to);
$mail->setReplyTo($email_to);
$mail->setFrom("test@albertapayments.com");
$mail->setSender("Push Notification");
$mail->setSubject("Test mail from Albertapayments");

$message = "<p>Hi,</p> <p>This is a test message sent from Alberta Payments to check if push notification is working.</p> <p>If you see this email please forward it to adarsh@mitiweb.com.</p> <p>Thanks,</p><p>Alberta Payments.</p>";

$mail->setHtml($message);*/
//$mail->isHTML();

//$mail->setText();

//$send = $mail->send();

//print_r($mail);

//exit;

$data['start_date'] = $sdate;

$data['end_date'] = $edate;

//print_r($data); exit;

$sql = "SELECT
        trn_s.vusername as vusername, 
        (case when trn_s.vtendertype='Return' then trn_s.vtendertype else trn_s.vtrntype end)as TrnType,
        trn_sd.isalesid as isalesid, 
        date_format(trn_s.dtrandate,'%m-%d-%Y %H:%i:%s') as trn_date_time,
        trn_sd.vitemname as vitemname,
        trn_sd.nextunitprice as nextunitprice, 
        trn_s.iuserid as iuserid,

        trn_sd.idettrnid as idettrnid, 
        trn_sd.vitemcode as vitemcode, 
        trn_sd.ndebitqty as ndebitqty,
        trn_sd.nunitprice as nunitprice,
        'First Query' as QR
        
        FROM trn_sales trn_s left join trn_salesdetail trn_sd 
        on trn_s.isalesid=trn_sd.isalesid 
        where date_format(trn_s.dtrandate,'%m-%d-%Y') >= '".$data['start_date']."' 
        AND date_format(trn_s.dtrandate,'%m-%d-%Y') <= '".$data['end_date']."' 
        AND ((trn_s.vtrntype in ('Void','No Sale')) OR (trn_s.vtendertype='Return'))
        
        union all
        
        select mu.vfname as vusername,
        'Delete' as TrnType,
        mdi.id as isalesid,
        date_format(mdi.LastUpdate,'%m-%d-%Y') as trn_date_time,
        mdi.itemname as vitemname,
        mdi.extprice as nextunitprice, 
        mdi.userid as iuserid,

        mdi.id as idettrnid, 
        barcode as vitemcode, 
        qty as ndebitqty,
        unitprice as nunitprice,
        'Second Query' as QR
        from mst_deleteditem mdi LEFT JOIN mst_user mu ON(mu.iuserid=mdi.userid)
        where date_format(mdi.LastUpdate,'%m-%d-%Y') >= '".$data['start_date']."' 
        AND date_format(mdi.LastUpdate,'%m-%d-%Y') <= '".$data['end_date']."'
        order by trn_date_time";

/*$sql = "SELECT trn_sd.isalesid as isalesid, 
        trn_sd.idettrnid as idettrnid, 
        trn_sd.vitemcode as vitemcode, 
        trn_sd.vitemname as vitemname,
        trn_sd.ndebitqty as ndebitqty,
        trn_sd.nunitprice as nunitprice, 
        trn_sd.nextunitprice as nextunitprice, 
        trn_s.iuserid as iuserid, 
        trn_s.vusername as vusername, 
        trn_s.vtrntype as vtrntype, 
        date_format(trn_s.dtrandate,'%m-%d-%Y %H:%i:%s') as trn_date_time 
        FROM trn_salesdetail trn_sd , 
        trn_sales trn_s WHERE  date_format(trn_s.dtrandate,'%m-%d-%Y') >= '".$data['start_date'].
        "' AND date_format(trn_s.dtrandate,'%m-%d-%Y') <= '".$data['end_date'].
        "' AND trn_s.isalesid=trn_sd.isalesid AND (trn_s.vtrntype='Void' OR trn_s.vtrntype='Delete')";*/

$query = $this->db2->query($sql);

$return_data = $query->rows;

//print_r($return_data);

//exit;
/*
$return_data =array();

return $return_data['voids'] = $query->rows;

$sql1 = "SELECT mdi.barcode as vitemcode, 
        mdi.itemname as vitemname, 
        mdi.qty as ndebitqty, 
        mdi.unitprice as nunitprice, 
        mdi.extprice as nextunitprice, 
        'Delete' as vtrntype, 
        CONCAT(mu.vfname,' ',mu.vlname) as vusername, 
        date_format(mdi.LastUpdate,'%m-%d-%Y %H:%i:%s') as trn_date_time 
        FROM mst_deleteditem mdi LEFT JOIN mst_user mu ON(mu.iuserid=mdi.userid) 
        WHERE date_format(mdi.LastUpdate,'%m-%d-%Y') >= '".$data['start_date']."' 
        AND date_format(mdi.LastUpdate,'%m-%d-%Y') <= '".$data['end_date']."'";

$query1 = $this->db2->query($sql1);

$return_data['deletes'] = $query1->rows;*/


return $return_data;

//print_r($return_data);

//exit;
        
        
        //$query = $this->db2->query("CALL rp_dailysalesitem('".$sdate."','".$edate."','Category')");
		//$query = $this->db2->query("select vitemcode,vitemname as itemname,vcatname as vname,sum(iunitqty) as qtysold,sum(nextunitprice) as amount from trn_salesdetail a,trn_sales b where a.isalesid = b.isalesid and date_format(dtrandate,'%m-%d-%Y') between '".$sdate."' and '".$edate."' and b.vtrntype='Transaction' and a.vitemtype='Kiosk'  and (a.vcatname <> '' or a.vcatname is not null) group by  vitemcode,vitemname,vcatname order by qtysold desc,vitemname");
        //$query = $this->db2->query("select iitemid as id,vitemname as itemname,LastUpdate as updated_on from mst_item a where date_format(LastUpdate,'%m-%d-%Y') between '".$sdate."' and '".$edate."' order by LastUpdate");

        return $query->rows;
	}

	public function getDepartmentsReport($sdate,$edate) {	
		

		$query = $this->db2->query("CALL rp_dailysalesitem('".$sdate."','".$edate."','Department')");

		return $query->rows;
	}
	
	
	public function sendMail($email_to = 'adarsh.s.chacko@gmail.com'){
        $email_to = 'adarsh.s.chacko@gmail.com';
        
        $mail = new Mail();
        
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');            
        $mail->setTo($email_to);
        $mail->setReplyTo($email_to);
        $mail->setFrom("test@albertapayments.com");
        $mail->setSender("Push Notification");
        $mail->setSubject("Test mail from Albertapayments");
        
        $message = "<p>Hi,</p> <p>This is a test message sent from Alberta Payments to check if push notification is working.</p> <p>If you see this email please forward it to adarsh@mitiweb.com.</p> <p>Thanks,</p><p>Alberta Payments.</p>";
        
        $mail->setHtml($message);
        //$mail->isHTML();
        
        //$mail->setText();
        
        $send = $mail->send();
        
        return $send;
	    
	}
}
