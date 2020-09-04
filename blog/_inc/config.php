<?php

// show all errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);


// require stuff
if( !session_id() ) @session_start();
require_once 'vendor/autoload.php';


// constants & settings
define( 'BASE_URL', 'http://localhost:8888/blog' );
define( 'APP_PATH', realpath(__DIR__ . '/../') );


// configurations
$config = [

	'db' => [
		'type'     => 'mysql',
		'name'     => 'miniblog',
		'server'   => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'charset'  => 'utf8'
	]

];



// connect to db
$db = new PDO(
	"{$config['db']['type']}:host={$config['db']['server']};
	dbname={$config['db']['name']};charset={$config['db']['charset']}",
	$config['db']['username'], $config['db']['password']
);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);



// global functions
require_once 'functions-general.php';
require_once 'functions-string.php';
require_once 'functions-auth.php';
require_once 'functions-post.php';



// auth
require_once 'vendor/PHPAuth/languages/en.php';
require_once 'vendor/PHPAuth/config.class.php';
require_once 'vendor/PHPAuth/auth.class.php';

$auth_config = new Config( $db );
$auth = new Auth( $db, $auth_config, $lang );