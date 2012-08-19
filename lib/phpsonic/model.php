<?php

require_once("SonicObj.php");

class Author extends SonicObj
{
	var $_fields = array(
	    "first_name" => "StringField",
	    "last_name" => "StringField",
	    "age" => "IntField",
	);

	var $_indexes = array(
	    array("age"),
	);
}

class Book extends SonicObj
{
	var $_fields = array(
	    "title" => "StringField",
	    "is_release" => "BoolField",
	    "author_id" => "IntField",
	);

	var $_indexes = array(
	    array("author_id", "is_release"),
	    array("author_id"),
	);
}
?>