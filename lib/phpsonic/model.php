<?php

require_once("SonicObj.php");

class Person extends SonicObj
{
	var $_fields = array(
	    "first_name" => "StringField",
	    "last_name" => "StringField",
	    "age" => "IntField",	    
	);
}

class Book extends SonicObj
{
	var $_fields = array(
	    "first_name" => "StringField",
	    "last_name" => "StringField",
	    "age" => "IntField",	    
	);
}


?>