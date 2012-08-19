<?php
/*
Fields definition
*/

class Field
{
	static $field_order = 0;

	var $_field_order;
	var $_field_name;
	var $_field_value;

	function Field()
	{
		$this->_field_order = Field::get_field_order();
	}

	public static function get_field_order()
	{
		Field::$field_order += 1;
		return Field::$field_order;
	}

	function __toString()
	{
		return $this->_field_name;
	}
}

class StringField extends Field
{
	function StringField()
	{
		parent::__construct();
	}
}

class BoolField extends Field
{
}

class IntField extends Field
{
	function StringField()
	{
		parent::__construct();
	}
}

class ObjField extends Field
{
	function ObjField()
	{
		parent::__construct();
	}
}
?>