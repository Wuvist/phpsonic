<?php

#$connection = mysql_connect("localhost", "root", "");

require_once("../lib/phpsonic/model.php");

$p = new Person;
echo $p->first_name;
echo "\n";
echo $p->last_name;

// echo Person::first_name->_field_order;
// echo "\n";
// echo Person::last_name->_field_order;


echo "\n";
?>