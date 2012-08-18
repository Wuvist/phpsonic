<?php

require_once("../lib/phpsonic/model.php");

SonicObj::$_conn = mysql_connect("localhost", "root", "");
mysql_select_db('phpsonic_test', SonicObj::$_conn);


// $result = mysql_query('SELECT count(*) from Author');

// var_dump($result);

$p = new Person;
$p->first_name = "Wei";
$p->last_name = "Weng";

echo $p->first_name;
echo "\n";
echo $p->last_name;

echo Person::build_table();
echo Book::build_table();

// echo Person::first_name->_field_order;
// echo "\n";
// echo Person::last_name->_field_order;



echo "\n";
?>