<?php

class DB{

	protected $host = "";
	protected $db = "";
	protected $user = "";
	protected $pass = "";
	
	var $dbh = null;
	var $statement = null;

	function __construct(){
		try {
			$this->load_db_config();
			$this->connect();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	function get_error(){
		return $this->dbh->errorInfo();
	}

	private function load_db_config(){
		try {
			
			$this->host = HOST;
			$this->db = DB;
			$this->user = DB_USER;
			$this->pass = DB_PASS;

		} catch (PDOException $e) {
			$this->get_error();
		}catch(Exception $e){
			$this->get_error();
		}
	}

	private function connect(){
		$this->dbh = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->pass);
		$this->dbh->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
	}

	function prepare($sql){
		try{
			$this->statement = $this->dbh->prepare($sql);
		}catch(Exception $e){
			$this->get_error();
		}
	}

	function bind_param($params){
		for ($i=0; $i < count($params); $i++) { 
			$this->statement->bindParam(($i+1), $params[$i]);
		}
	}

	function bind_val($name, $val){
		try {
			$this->statement->bindValue($name, $val);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	function bind_int_val($name, $param){
		try {
			$this->statement->bindValue($name, $param, PDO::PARAM_INT);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	function execute(){
		try {
			$this->statement->execute();	
		} catch (Exception $e) {
			die($e->getMessage());
		}

	}

	function execute_with_data($data){
		try {
			$this->statement->execute($data);
		} catch (Exception $e) {
			die($e->getMessage());
		}

	}

	function fetch_all(){
		try{
			return $this->statement->fetchAll();
		}catch(Exception $e){
			die($e->getMessage());
		}

	}

	function fetch_row(){
		try {
			return $this->statement->fetch();
		} catch (Exception $e) {
			die($e->getMessage());
		}

	}

	function row_count(){
		try {
			return $this->statement->rowCount();	
		} catch (Exception $e) {
			die($e->getMessage());	
		}
	}

	function last_insert_id(){
		try {
			return $this->dbh->lastInsertId();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

}

?>