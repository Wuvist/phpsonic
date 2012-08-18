<?php
/*
Fields definition
*/

class Field
{
	static $field_order = 0;

	var $_field_order;

	function Field()
	{
		$this->_field_order = Field::get_field_order();
	}

	public static function get_field_order()
	{
		Field::$field_order += 1;
		return Field::$field_order;
	}
}

class StringField extends Field
{
	function StringField()
	{
		parent::__construct();
	}
}

class IntField extends Field
{
	function StringField()
	{
		parent::__construct();
	}
}
?>