<?php
require_once("../lib/phpsonic/model.php");

// Setup default DB connection
SonicObj::$_db = new PDO( 
    'mysql:host=localhost;dbname=phpsonic_test', 
    'root', 
    '',
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
);

// Setup default redis connection
SonicObj::$_rs = new Redis();
SonicObj::$_rs->pconnect('127.0.0.1');

// echo Person::build_table();
// echo Book::build_table();

$p = new Person;
$p->first_name = "Piggy";
$p->last_name = "run";
// $p->save();

$objs = Person::get_all_objs();
foreach ($objs as $obj) {
	echo $obj->id;
	echo $obj->first_name;
	echo "\n";	
}


echo "\n";
?>