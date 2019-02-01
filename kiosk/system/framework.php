<?php
// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$config->load('default');
$config->load($application_config);
$registry->set('config', $config);

//print_r($config);
// Request
$registry->set('request', new Request());

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);


// Session
if ($config->get('session_autostart')) {
	$session = new Session();
	$session->start();
	$registry->set('session', $session);
}

//$registry->set('db_type2',DB_DRIVER2);
//$registry->set('db_hostname2',DB_HOSTNAME2);
//$registry->set('db_username2',DB_USERNAME2);
//$registry->set('db_password2',DB_PASSWORD2);
//$registry->set('db_database2',DB_DATABASE2);
//$registry->set('db_database2','sasaas');

//print_r($registry->get('db_database2'));
//$db_type = ($config->get('db_type'))?$config->get('db_type'):$session->data['db_type'];
//$db_hostname = ($config->get('db_hostname'))?$config->get('db_hostname'):$session->data['db_hostname'];
//$db_username = ($config->get('db_username'))?$config->get('db_username'):$session->data['db_username'];
//
//if($config->get('db_password')==''){
//	$db_password = $config->get('db_password');
//}else{
//	$db_password = $session->data['db_password'];
//}
//
//$db_database = ($config->get('db_database'))?$config->get('db_database'):$session->data['db_database'];
//$db_port = ($config->get('db_port'))?$config->get('db_port'):$session->data['db_port'];

//print_r($registry->get('session'));
// Database
if ($config->get('db_autostart')) {
	
	$registry->set('db', new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE));

	//$registry->set('db2', new DB(DB_DRIVER2, DB_HOSTNAME2, DB_USERNAME2, DB_PASSWORD2, DB_DATABASE2));
	
	//$registry->set('db2',new DB($db_type2, $db_hostname2, $db_username2, $db_password2, $db_database2, $db_port2));
	//$registry->set('db', new DB($config->get('db_type'), $config->get('db_hostname'), $config->get('db2_username'), $config->get('db_password2'), $config->get('db_database'), $config->get('db_port')));
	//$registry->set('db', new DB($db_type, $db_hostname, $db_username, $db_password, $db_database, $db_port));
	
	//$registry->set('db2', new DB($db_type2, $db_hostname2, $db_username2, $db_password2, $db_database2, $db_port2));
	//$registry->set('db2', new DB($config->get('db_type2'), $config->get('db_hostname2'), $config->get('db_username2'), $config->get('db_password2'), $config->get('db_database2'), $config->get('db_port2')));
}

//$session->data['db_database2']='';

if ($config->get('db_database2')=='' && isset($session->data['db_database2'])!='')
{
//$db2 = new Database($session->data['db_hostname2'], $session->data['db_username2'], $session->data['db_password2'], $session->data['db_database2']);
//$db2->connect();
//echo 'sa';
//$registry->set('db2',$db2);
$registry->set('db2', new MySQLi2($session->data['db_hostname2'], $session->data['db_username2'], $session->data['db_password2'], $session->data['db_database2']));
}


//$db_type2 = ($config->get('db_type2'))?DB_DRIVER2:$session->data['db_type2']=$session->data['db_type2'];
//$db_hostname2 = ($config->get('db_hostname2'))?DB_HOSTNAME2:$session->data['db_hostname2'];
//$db_username2 = ($config->get('db_username2'))?DB_USERNAME2:$session->data['db_username2'];
//$db_password2 = ($config->get('db_password2')=='')?DB_PASSWORD2:$session->data['db_password2'];
//$db_database2 = ($config->get('db_database2'))?DB_DATABASE2:$session->data['db_database2'];
//$db_port2 = ($config->get('db_port2'))?DB_PORT2:$session->data['db_port2'];
//$session->data['db_database2']='';
//
//if($db_database2!='')
//{
//	
//	if($db_database2!='')
//	{
//		$db_database2 = $db_database2 ;
//	}
//	else
//	{
//		$db_database2=$session->data['db_database2'];
//	}
//	//echo $session->data['db_database2'];
//	//$registry->set('db2', new DB($db_type2, $db_hostname2, $db_username2, $db_password2, $db_database2, $db_port2));
//	//$registry->set('db2', new DB($config->get('db_type2'), $session->data('db_hostname2'), $session->data('db_username2'), $session->data('db_password2'), $session->data('db_database2'), $session->data('db_port2')));
//}

// Cache 
$registry->set('cache', new Cache($config->get('cache_type'), $config->get('cache_expire')));

// Url
$registry->set('url', new Url($config->get('site_ssl')));

// Language
$language = new Language($config->get('language_default'));
$language->load($config->get('language_default'));
$registry->set('language', $language);

// Document
$registry->set('document', new Document());

// Event
$event = new Event($registry);
$registry->set('event', $event);

// Event Register
if ($config->has('action_event')) {
	foreach ($config->get('action_event') as $key => $value) {
		$event->register($key, new Action($value));
	}
}

// Config Autoload
if ($config->has('config_autoload')) {
	foreach ($config->get('config_autoload') as $value) {
		$loader->config($value);
	}
}

// Language Autoload
//if ($config->has('language_autoload')) {
//	foreach ($config->get('language_autoload') as $value) {
//		$loader->language($value);
//	}
//}

// Library Autoload
if ($config->has('library_autoload')) {
	foreach ($config->get('library_autoload') as $value) {
		$loader->library($value);
	}
}

// Model Autoload
if ($config->has('model_autoload')) {
	foreach ($config->get('model_autoload') as $value) {
		$loader->model($value);
	}
}

// Front Controller
$controller = new Front($registry);

// Pre Actions
if ($config->has('action_pre_action')) {
	foreach ($config->get('action_pre_action') as $value) {

		$controller->addPreAction(new Action($value));
	}
}

// Dispatch
$controller->dispatch(new Action($config->get('action_router')), new Action($config->get('action_error')));

// Output
$response->setCompression($config->get('config_compression'));
$response->output();