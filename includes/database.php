<?php
require_once(LIB_PATH.DS."config.php");
class MySQLDatabase {
	
	private $connection;
	private $last_query;

	function __construct() {
		$this -> open_connection();
	}

	public function open_connection() {
		$this -> connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this -> connection) {
			die("database connection failed:" . mysql_error());
		}else{
			$db_select=mysql_select_db(DB_NAME,$this->connection);
			if(!$db_select){
				die("Database selection failed: ".mysql_error());
			}
		}
	}
    
	public function close_connection() {
		if(isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql){
		$this->last_query= $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}
	
	public function fetch_array($result_set) {
		return mysql_fetch_array($result_set);
	}
	
	public function escape_value( $value ) {
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");
	if( $new_enough_php){
		if( $magic_quotes_active) {
			$value = stripslashes( $value); }
		else{
			if(!$magic_quotes_active){
				$value = addslashes($value);
			}
			return $value;
		}
		
	}
}
	
	
	private function confirm_query($result){
	if(!$result){
		$output= "database query failed: ". mysql_error()."<rb/><br/>";
		$output .= "last sql query:" . $this->last_query;
		die($output);
	}
	}
	
	public function num_rows($result_set) {
		return mysql_num_rows($result_set);
	}
	
	public function insert_id(){
		return mysql_insert_id($this->connection);
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->connection);
	}
	
	
}
	

$database = new MySQLDatabase();

?>
