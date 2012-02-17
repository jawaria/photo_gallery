<?php
require_once(LIB_PATH.DS."database.php");
//require_once("functions.php");

class User  extends DatabaseObject {

	protected static $table_name = "users";
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;

	public static function authenticate($username = "", $password = "") {
		global $database;
		$username = $database -> escape_value($username);
		$password = $database -> escape_value($password);

		$sql = "select * from users ";
		$sql .= "where username = '{$username}' ";
		$sql .= "and password = '{$password}' ";
		$sql .= "limit 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public function full_name() {
		if (isset($this -> first_name) && isset($this -> last_name)) {
			return $this -> first_name . " " . $this -> last_name;
		} else {
			return "";
		}
	}

	public function find_all() {
		return self::find_by_sql("select * from " . self::$table_name);
	}

	public static function find_by_id($id = 0) {
		global $database;
		$result_array = self::find_by_sql("select * from 
		" . self::$table_name . " where id={$id} limit 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_by_sql($sql = "") {
		global $database;
		$result_set = $database -> query($sql);
		$object_array = array();
		while ($row = $database -> fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;

	}

	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this);

		return array_key_exists($attribute, $object_vars);
	}

	private static function instantiate($record) {
		$object = new self;
		// $object->id		  =	$record['id'];
		// $object->username = $record['username'];
		// $object->password = $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name = $record['last_name'];

		foreach ($record as $attribute => $value) {
			if ($object -> has_attribute($attribute)) {
				$object -> $attribute = $value;
			}
		}
		return $object;
	}

	public function update() {

	}

	public function delete() {

	}

	public function create() {
		global $database;
		$sql = "insert inro users (";
		$sql .= "username, password ,first_name, last_name";
		$sql .= ") values ('";
		$sql .= $database -> escape_value($this -> username) . "', '";
		$sql .= $database -> escape_value($this -> password) . "', '";
		$sql .= $database -> escape_value($this -> first_name) . "', '";
		$sql .= $database -> escape_value($this -> last_name) . "')";
		if ($database -> query($sql)) {
			$this -> id = $database -> insert_id();
			return true;
		} else {
			return false;
		}
	}

}
?>