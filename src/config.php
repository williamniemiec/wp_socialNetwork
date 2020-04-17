<?php
require 'environment.php';

global $db;

$config = array();

if (ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/wp_socialnetwork/src/");
	$config['dbname'] = 'wp_socialnetwork';
	$config['host'] = '127.0.0.1';
	$config['charset'] = 'utf8';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://mySite.com/");
	$config['dbname'] = '';
	$config['host'] = '127.0.0.1';
	$config['charset'] = 'utf8';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
}

try {
	$db = new \PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=".$config['charset'], $config['dbuser'], $config['dbpass']);
} catch(\PDOException $e){
	'"DATABASE CONNECTION ERROR: '.$e->getMessage();
}