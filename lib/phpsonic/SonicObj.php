<?php
/*
Base Class for SonicObj
*/

require_once("Fields.php");

abstract Class SonicObj
{
	var $_field_values = array();
	public static $_conn;
	public static $_rs;

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

	function build_table()
	{
		$class_name = get_called_class();
		$sql = <<< sql
		CREATE TABLE IF NOT EXISTS `$class_name`(
		id int AUTO_INCREMENT NOT NULL,
		data mediumblob,
		is_deleted boolean DEFAULT 0,
			PRIMARY KEY (`id`))
		ENGINE = InnoDB;
sql;
		mysql_query($sql);
	}
}
?>