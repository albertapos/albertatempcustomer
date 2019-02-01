<?php
ini_set('display_errors', 1);

//include("xmlapi.php");

//$db_host = 'localhost';
$db_host = '13.59.208.236';
$cpaneluser = 'albertapayments';
$cpanelpass = 'Albertapayments@1';

//$cpaneluser = 'albertap_ritesh';
//$cpanelpass = 'Albertapos@1';

//$cpaneluser = 'root';
//$cpanelpass = 'Alberta';

$databasename='sunnytest1';
$databaseuser='albertap_ritesh1';
$databasepass='Albertapos@11';

//$xmlapi = new xmlapi($db_host);  
//$xmlapi->password_auth("".$cpaneluser."","".$cpanelpass."");  
//$xmlapi->set_debug(1);//this setting will put output into the error log in the directory that you are calling script from 
//$xmlapi->set_output('array');//set this for browser output
//$xmlapi->set_port(2083);

//$createdb =  $xmlapi->api1_query($cpaneluser, "Mysql", "adddb", array($databasename)); 
 
//$usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($databaseuser, $databasepass)); 

/*
print_r($xmlapi);
echo 'sa<br>';
print_r($createdb);*/

//========================= Changes made by Adarsh =================================================
// Create connection
$conn = new mysqli($db_host, $cpaneluser, $cpanelpass);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE ".$databasename;
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error."<br/>";
}



if ($conn->query("CREATE USER '".$databaseuser."'@'".$db_host."' IDENTIFIED BY '".$databasepass."';") === TRUE) {
    echo "User created successfully.<br/>";
} else {
    echo "Error creating user: " . $conn->error."<br/>";
}



if ($conn->query("GRANT ALL ON ".$databasename.".* TO '".$databaseuser."'@'".$db_host."'") === TRUE) {
    echo "Granted all permissions successfully.<br/>";
} else {
    echo "Error granting permissions: " . $conn->error."<br/>";
}

$conn->close();
