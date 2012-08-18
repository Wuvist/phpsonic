<?php
/*
Base Class for SonicObj
*/

require_once("Fields.php");

Class SonicObj
{
	var $_field_values = array();

	public function __get($prop)
	{
		return $this->_field_values[$prop]->_field_value;
	}

	public function __set($prop, $value)
	{
		$this->_field_values[$prop]->_field_value = $value;
	}

	function SonicObj()
	{
		foreach($this->_fields as $k => $v)
		{
			eval('$this->_field_values[$k]  = new '.$v.";");
			$this->_field_values[$k]->_field_name = $k;
		}
	}
}
?>