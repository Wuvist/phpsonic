<?php
/*
Base Class for SonicObj
*/

require_once("Fields.php");

abstract Class SonicObj
{
	public static $_db;
	public static $_rs;

	var $_field_values = array();
	var $_dirty_fields = array();
	var $_is_new = True;
	var $_table_name;
	var $id;

	public function __get($prop)
	{
		return $this->_field_values[$prop]->_field_value;
	}

	public function __set($prop, $value)
	{
		if(!$this->_is_new)
		{
			$this->_dirty_fields[$prop] = $this->_field_values[$prop]->_field_value;
		}
		$this->_field_values[$prop]->_field_value = $value;
	}

	public static function get($id)
	{
		//todo: should support multi-get

		$class_name = get_called_class();		
		$result = SonicObj::$_db->query("select * FROM $class_name where id=$id");

		$obj = new $class_name;
		foreach ($result as $row) {
			$obj->id = $row["id"];
		    $obj->_from_binary($row["data"]);
		}
		return $obj;
	}

	function SonicObj()
	{
		foreach($this->_fields as $k => $v)
		{
			eval('$this->_field_values[$k]  = new '.$v.";");
			$this->_field_values[$k]->_field_name = $k;
		}

		$this->_table_name = get_called_class();
	}

	static function build_table()
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
		SonicObj::$_db->exec($sql);
	}

	static function get_all_ids()
	{
		$class_name = get_called_class();
		$result = SonicObj::$_rs->zrevrange($class_name."_ids", 0, -1);
		return array_values($result);
	}

	static function get_all_objs()
	{
		$cls = get_called_class();
		$ids = $cls::get_all_ids();
		$result = array();

		//todo: should batch get to increase performance
		foreach($ids as $id)
		{
			$result[] = $cls::get($id);
		}

		return $result;
	}

	function save()
	{			
		if($this->_is_new)
		{
			$this->_insert();			
		}
		else
		{
			if(count($this->_dirty_fields) == 0)
			{
				return False;
			}
				
			$this->_update();			
		}

		$this->_is_new = False;
		$this->_dirty_fields = array();

		return True;
	}

	function _insert()
	{
		$sql = "insert into `$this->_table_name` (data)values(:data)";
		$query = SonicObj::$_db->prepare($sql);
		$query->execute(array(':data' => $this->_to_binary()));
		$this->id = SonicObj::$_db->lastInsertId();

		SonicObj::$_rs->zadd($this->_table_name."_ids", $this->id, $this->id);

		// foreach($this->_indexes as $index)
		// {
		// 	keys = $this->get_index_keys(index.field_names)
		// 	for key in keys:
		// 		if index.order_by:
		// 			order_field = $this->__dict__[index.order_by]
		// 			if order_field == None:
		// 				score = 0
		// 			else:
		// 				score = int(order_field)
		// 			$this->_rs.zadd(key, **{str($this->id): score})
		// 		else:
		// 			$this->_rs.zadd(key, **{str($this->id): $this->id})			
		// }
	}

	function _update()
	{
		$sql = "update `$this->_table_name` set data=:data where id=:id";
		$query = SonicObj::$_db->prepare($sql);
		$query->execute(array(':data' => $this->_to_binary(), ':id' => $this->id));
	}

	function _to_binary()
	{
		return serialize($this->_field_values);
	}

	function _from_binary($binary)
	{
		$this->_is_new = False;
		$this->_field_values = unserialize($binary);
	}
}
?>