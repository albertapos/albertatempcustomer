<?php
/**
*Get all form values to the local variables
*
*/

$name = stripslashes($_POST['name']);
$company = stripslashes($_POST['company']);
$email = stripslashes($_POST['email']);
$phone = stripslashes($_POST['phone']);
$comments = stripslashes($_POST['comments']);

/*
 * Assign the required value to send a mail
 */

/*$headers =  "From: $email\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html;charset=iso-8859-1\r\n";
$headers .= "X-Priority: 1\r\n";
$headers .= "X-MSMail-Priority: High\r\n";
$headers .= "X-Mailer: Just My Server\r\n";*/



$to = "thilip.kumar@globalintegra.net";
//$to = "info@albertapayments.com";
//$headers .= 'Cc: boopathy.r@globalintegra.net' . "\r\n";


$subject = "This weblead is from Albertapayments.com";
$subject2 = "Contact us";

/*
 * After success send mail, the page to be redirected
 *
 */

$redirect= "thank-you.php";

/*
 * The Body of the Mail
 *
 */

$body = "
<table width='500' border='1' style='font-family:verdana;' bordercolor='#bbbbbb' cellspacing='0'>
	<tr>
		<td colspan='2' bgcolor='#eeeeee'><h3><strong>$subject</strong></h3></td>
	</tr>
	<tr>
		<td colspan='2' bgcolor='#f5f5f5'><h4><strong>$subject2</strong></h4></td>
	</tr>
	<tr>
		<td width='128'><b>Name</b></td>
		<td width='338'> $name </td>
	</tr>
	<tr>
		<td width='128'><b>Company</b></td>
		<td width='338'> $company </td>
	</tr>
	<tr>
		<td><b>Phone</b></td>
		<td> $phone </td>
	</tr>
	<tr>
		<td><b>E-mail</b></td>
		<td> $email</td>
	</tr>
	<tr>
		<td><b>Comments</b></td>
		<td> $comments </td>
	</tr>
</table>";

$from = "contact@albertapyments.com";

$headers = "From: ".$from."\r\n"; 

$headers .= "MIME-Version: 1.0\r\n"; 

$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

$headers .= "X-Priority: 1\r\n";
  
/*
 * Send mail with gathered information
 */
if($_POST['name']!='' &&$_POST['company']!='' &&$_POST['phone']!='' &&$_POST['email']!='' &&$_POST['comments']!='' ){	
 	if(mail($to,$subject,$body,$headers)){

		header("Location: $redirect");
	}
	else{
		echo "Sorry, Unable to sent mail this time.";
	}
}
else {
	echo 'Invalid request';
}
?>