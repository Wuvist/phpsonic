<?php
/*
Base Class for SonicObj
*/

require_once("Fields.php");

Class SonicObj
{
	var $_field_values;

	public function __get( $prop )
	{
		return $prop;
	}

	public function __set( $prop, $value )
	{

		return;
	}

	function SonicObj()
	{
		var_dump($this->_fields);
	}
}
?>