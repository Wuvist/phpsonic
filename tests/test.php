<?php

require_once("../lib/phpsonic/model.php");

SonicObj::$_db = new PDO( 
    'mysql:host=localhost;dbname=phpsonic_test', 
    'root', 
    '', 
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
);

// echo Person::build_table();
// echo Book::build_table();



$p = Person::get(3);
echo $p->first_name;
echo "\n";
echo $p->last_name;
echo "\n";
echo $p->id;


// echo Person::first_name->_field_order;
// echo "\n";
// echo Person::last_name->_field_order;



echo "\n";
?>