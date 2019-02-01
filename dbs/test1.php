<?php 

include("xmlapi.php");

$db_host = '64.64.3.10'; //http://pos2020.net/cp.php
$cpaneluser = 'portaluser';
$cpanelpass = 'web@nt!23'; 

$databasename = 'testdb';
$databaseuser = 'web2020n_dbusr'; // Warning: in most of cases this can't be longer than 8 characters
$databasepass = 'n@rayan'; // Warning: be sure the password is strong enough, else the CPanel will reject it

$xmlapi = new xmlapi($db_host);  
$xmlapi->password_auth("".$cpaneluser."","".$cpanelpass."");  
$xmlapi->set_debug(1);//this setting will put output into the error log in the directory that you are calling script from 
$xmlapi->set_output('array');//set this for browser output
$xmlapi->set_port(2083);
//create database  
$createdb = $xmlapi->api1_query($cpaneluser, "Mysql", "adddb", array($databasename)); 
foreach($createdb as $v)
{
    $result = $v['result'];
}
if ($result == 1)
{
    //create user  
    $usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($databaseuser, $databasepass));  
}
foreach($usr as $v)
{
    $result2 = $v['result'];
}
if ($result2 == 1)
{
    //add user to database  
    $addusr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduserdb", array($databasename, $databaseuser, 'all'));  

}
print_r($result);



?>